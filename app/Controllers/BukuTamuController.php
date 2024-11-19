<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BukuTamuModel;

class BukuTamuController extends Controller
{
    public function form()
    {
        helper(['form', 'url']);

        // Header untuk mencegah cache
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $this->response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
        $this->response->setHeader('Pragma', 'no-cache');

        // Cek sesi `guestbook_auth`
        if (!session()->get('guestbook_auth')) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }

        return view('bukutamu/form_guestbook');
    }

    public function individual()
    {
        return view('bukutamu/form_individual');
    }

    public function agency()
    {
        return view('bukutamu/form_agency');
    }


    public function storeIndividual()
    {
        helper(['filesystem']); // Memuat helper untuk manajemen file
    
        // Validasi input untuk form individual
        $validation = \Config\Services::validation();
        $validation->setRules([
            'NAMA_TAMU'    => 'required',
            'ALAMAT_TAMU'  => 'required',
            'NOHP_TAMU'    => 'required|numeric|min_length[10]',
            'JENIS_KELAMIN' => 'required',
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    
        // Default path untuk foto
        $fotoTamuPath = 'uploads/foto_tamu/default.png';
    
        // Jika ada foto yang diunggah
        $fotoData = $this->request->getPost('foto_tamu');
        if (!empty($fotoData)) {
            $fotoData = str_replace('data:image/png;base64,', '', $fotoData);
            $fotoData = base64_decode($fotoData);
    
            if ($fotoData !== false) {
                $uploadDir = FCPATH . 'uploads/foto_tamu/'; // Path untuk menyimpan foto di public/uploads/foto_tamu/
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Membuat direktori jika belum ada
                }
    
                $fileName = uniqid() . '.png'; // Nama file unik
                $filePath = $uploadDir . $fileName;
    
                if (write_file($filePath, $fotoData)) {
                    $fotoTamuPath = 'uploads/foto_tamu/' . $fileName; // Path foto yang akan disimpan ke database
                } else {
                    log_message('error', 'Gagal menyimpan file di ' . $filePath);
                }
            }
        }
    
        // Data untuk disimpan ke database
        $jenisKelaminL = $this->request->getPost('JENIS_KELAMIN') === 'Laki-Laki' ? 1 : 0;
        $jenisKelaminP = $this->request->getPost('JENIS_KELAMIN') === 'Perempuan' ? 1 : 0;
    
        $data = [
            'TGLKUNJUNGAN_TAMU' => date('Y-m-d H:i:s'), // Waktu saat ini
            'TIPE_TAMU'         => '1',
            'NAMA_TAMU'         => $this->request->getPost('NAMA_TAMU'),
            'ALAMAT_TAMU'       => $this->request->getPost('ALAMAT_TAMU'),
            'NOHP_TAMU'         => $this->request->getPost('NOHP_TAMU'),
            'JKL_TAMU'          => $jenisKelaminL,
            'JKP_TAMU'          => $jenisKelaminP,
            'FOTO_TAMU'         => $fotoTamuPath,
        ];
    
        log_message('debug', 'Data yang akan disimpan: ' . json_encode($data));
    
        $model = new BukuTamuModel();
        if ($model->insert($data)) {
            log_message('debug', 'Data berhasil disimpan: ' . json_encode($data));
            return redirect()->to('/bukutamu/form')->with('success', 'Data individu berhasil disimpan.');
        } else {
            log_message('error', 'Gagal menyimpan data ke database.');
            return redirect()->back()->withInput()->with('errors', ['Data gagal disimpan.']);
        }
    }

    public function storeAgency()
{
    helper(['filesystem']); // Memuat helper untuk manajemen file

    // Validasi input untuk form instansi
    $validation = \Config\Services::validation();
    $validation->setRules([
        'NAMA_TAMU'    => 'required',
        'ALAMAT_TAMU'  => 'required',
        'NOHP_TAMU'    => 'required|numeric|min_length[10]',
        'JKL_TAMU'     => 'required|numeric', // Male count field
        'JKP_TAMU'     => 'required|numeric', // Female count field
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Default path untuk foto
    $fotoTamuPath = 'uploads/foto_tamu/default.png';

    // Jika ada foto yang diunggah
    $fotoData = $this->request->getPost('foto_tamu');
    if (!empty($fotoData)) {
        $fotoData = str_replace('data:image/png;base64,', '', $fotoData);
        $fotoData = base64_decode($fotoData);

        if ($fotoData !== false) {
            $uploadDir = FCPATH . 'uploads/foto_tamu/'; // Path untuk menyimpan foto di public/uploads/foto_tamu/
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Membuat direktori jika belum ada
            }

            $fileName = uniqid() . '.png'; // Nama file unik
            $filePath = $uploadDir . $fileName;

            if (write_file($filePath, $fotoData)) {
                $fotoTamuPath = 'uploads/foto_tamu/' . $fileName; // Path foto yang akan disimpan ke database
            } else {
                log_message('error', 'Gagal menyimpan file di ' . $filePath);
            }
        }
    }

    // Data untuk disimpan ke database
    $data = [
        'TGLKUNJUNGAN_TAMU' => date('Y-m-d H:i:s'),
        'TIPE_TAMU'         => '2', // Instansi type
        'NAMA_TAMU'         => $this->request->getPost('NAMA_TAMU'),
        'ALAMAT_TAMU'       => $this->request->getPost('ALAMAT_TAMU'),
        'NOHP_TAMU'         => $this->request->getPost('NOHP_TAMU'),
        'JKL_TAMU'          => $this->request->getPost('JKL_TAMU'), // Male count
        'JKP_TAMU'          => $this->request->getPost('JKP_TAMU'), // Female count
        'FOTO_TAMU'         => $fotoTamuPath,
    ];

    log_message('debug', 'Data yang akan disimpan: ' . json_encode($data));

    // Initialize the model
    $model = new BukuTamuModel();
    if ($model->insert($data)) {
        log_message('debug', 'Data berhasil disimpan: ' . json_encode($data));

        // Return JSON response for frontend
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Data instansi berhasil disimpan.'
        ]);
    } else {
        log_message('error', 'Gagal menyimpan data ke database.');

        // Return JSON response with error message
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Data gagal disimpan.'
        ]);
    }
}
}