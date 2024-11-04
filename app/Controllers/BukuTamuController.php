<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BukuTamuModel;

class BukuTamuController extends Controller
{
    public function form()
    {
        helper(['form', 'url']);
        
        // Tambahkan header untuk mencegah cache
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $this->response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
        $this->response->setHeader('Pragma', 'no-cache');
    
        // Cek sesi `guestbook_auth`
        if (!session()->get('guestbook_auth')) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }
    
        return view('bukutamu/form_guestbook');
    }
    
    
    public function storeIndividual()
    {
        // Validate form input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'NAMA_TAMU' => 'required',
            'ALAMAT_TAMU' => 'required',
            'NOHP_TAMU' => 'numeric|min_length[10]',
            'JENIS_KELAMIN' => 'required',
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            // If validation fails, redirect back with error messages
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    
        // Retrieve data from the form
        $jenisKelamin = $this->request->getPost('JENIS_KELAMIN');
        $data = [
            'NAMA_TAMU' => $this->request->getPost('NAMA_TAMU'),
            'TIPE_TAMU' => '1', // Assuming this is for individual, hard-coded or modify as needed
            'ALAMAT_TAMU' => $this->request->getPost('ALAMAT_TAMU'),
            'NOHP_TAMU' => $this->request->getPost('NOHP_TAMU'),
            'TGLKUNJUNGAN_TAMU' => date('Y-m-d H:i:s'), // Use current timestamp
            'JKL_TAMU' => $jenisKelamin == 'Laki-Laki' ? 1 : 0,
            'JKP_TAMU' => $jenisKelamin == 'Perempuan' ? 1 : 0,
        ];
    
        // Save data to the database
        $guestbookModel = new \App\Models\BukuTamuModel();
        $guestbookModel->insert($data);
    
        // Redirect back to the form with a success message
        return redirect()->to('/bukutamu/form')->with('success', 'Data berhasil disimpan.');
    }
    

    public function storeInstansi()
    {
        helper(['form', 'url']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'NAMA_TAMU' => 'required',
            'ALAMAT_TAMU' => 'required',
            'NOHP_TAMU' => 'required|numeric|min_length[10]',
            'JKL_TAMU' => 'required|numeric|greater_than_equal_to[0]',
            'JKP_TAMU' => 'required|numeric|greater_than_equal_to[0]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'TGLKUNJUNGAN_TAMU' => date('Y-m-d H:i:s'),
            'TIPE_TAMU' => 2, // Instansi
            'NAMA_TAMU' => $this->request->getPost('NAMA_TAMU'),
            'ALAMAT_TAMU' => $this->request->getPost('ALAMAT_TAMU'),
            'NOHP_TAMU' => $this->request->getPost('NOHP_TAMU'),
            'JKL_TAMU' => $this->request->getPost('JKL_TAMU'),
            'JKP_TAMU' => $this->request->getPost('JKP_TAMU'),
        ];

        $model = new BukuTamuModel();
        if ($model->insert($data)) {
            return redirect()->to('/bukutamu/form')->with('success', 'Data instansi berhasil disimpan.');
        } else {
            return redirect()->back()->withInput()->with('errors', ['Data gagal disimpan. Silakan coba lagi.']);
        }
    }
}

    
    