<?php

namespace App\Controllers;

use App\Models\ReservasiModel;
use CodeIgniter\Controller;

class ReservationController extends Controller
{
    protected $reservasiModel;

    public function __construct()
    {
        $this->reservasiModel = new ReservasiModel(); // Panggil model
    }

    public function index()
    {
        // Kirim data title ke view
        $data = [
            'title' => 'Jadwal'
        ];

        return view('schedule', $data);
    }

// Function to save reservation
public function storeReservasi()
{
    $validation = \Config\Services::validation();

    $validation->setRules([
        'nama_reservasi'       => 'required|max_length[255]',
        'instansi_reservasi'   => 'required|max_length[255]',
        'email_reservasi'      => 'required|valid_email|max_length[255]',
        'telepon_reservasi'    => 'required|max_length[15]',
        'kegiatan_reservasi'   => 'required|max_length[255]',
        'jmlpengunjung_reservasi' => 'required|integer',
        'tanggal_reservasi'    => 'required|valid_date[Y-m-d]',
        'surat_reservasi'      => 'uploaded[surat_reservasi]|max_size[surat_reservasi,2024]|mime_in[surat_reservasi,application/pdf,image/png,image/jpeg,image/jpg]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Validation failed: ' . json_encode($validation->getErrors()),
        ]);
    }

    // File handling for "surat_reservasi"
    $suratFile = $this->request->getFile('surat_reservasi');
    $suratFileName = $suratFile->getRandomName();

    try {
        // Move the file to the designated folder
        $suratFile->move(FCPATH . 'uploads/surat_kunjungan', $suratFileName);
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'File upload error: ' . $e->getMessage(),
        ]);
    }

    // Prepare data for database insertion
    $data = [
        'NAMA_RESERVASI' => $this->request->getPost('nama_reservasi'),
        'INSTANSI_RESERVASI' => $this->request->getPost('instansi_reservasi'),
        'EMAIL_RESERVASI' => $this->request->getPost('email_reservasi'),
        'TELEPON_RESERVASI' => $this->request->getPost('telepon_reservasi'),
        'KEGIATAN_RESERVASI' => $this->request->getPost('kegiatan_reservasi'),
        'JMLPENGUNJUNG_RESERVASI' => $this->request->getPost('jmlpengunjung_reservasi'),
        'TANGGAL_RESERVASI' => $this->request->getPost('tanggal_reservasi'),
        'STATUS_RESERVASI' => 'pending', // default status
        'SURAT_RESERVASI' => $suratFileName,
    ];

    // Attempt to insert data into the database
    try {
        $inserted = $this->reservasiModel->insert($data);
        if ($inserted === false) {
            // Log the error if insertion fails
            log_message('error', 'Database error: ' . json_encode($this->reservasiModel->errors()));
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to save reservation. Database error: ' . json_encode($this->reservasiModel->errors()),
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Reservasi berhasil ditambahkan.',
        ]);
    } catch (\Exception $e) {
        log_message('error', 'Database exception: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to save reservation. Exception: ' . $e->getMessage(),
        ]);
    }
}

}    