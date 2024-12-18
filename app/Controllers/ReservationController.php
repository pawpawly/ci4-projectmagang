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
        'surat_reservasi'      => 'uploaded[surat_reservasi]|max_size[surat_reservasi,2024]|mime_in[surat_reservasi,application/pdf,image/png,image/jpeg,image/jpg]',
        'g-recaptcha-response' => 'required' // Tambahkan validasi CAPTCHA
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Validation failed: ' . json_encode($validation->getErrors()),
        ]);
    }

    // Validasi reCAPTCHA
    $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
    $secretKey = '6Lex854qAAAAAOw4Pkbyc66-dSXlbrS3JZqfoZsv'; // Ganti dengan Secret Key Anda
    $url = "https://www.google.com/recaptcha/api/siteverify";

    // Kirim permintaan ke Google
    $response = file_get_contents($url . "?secret={$secretKey}&response={$recaptchaResponse}");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys['success']) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'CAPTCHA tidak valid, silakan coba lagi.',
        ]);
    }

    // File handling for "surat_reservasi"
    $suratFile = $this->request->getFile('surat_reservasi');
    $suratFileName = $suratFile->getRandomName();

    try {
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
        'STATUS_RESERVASI' => 'pending',
        'SURAT_RESERVASI' => $suratFileName,
    ];

    // Attempt to insert data into the database
    try {
        $this->reservasiModel->insert($data);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Reservasi berhasil ditambahkan.',
        ]);
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage(),
        ]);
    }
}
}