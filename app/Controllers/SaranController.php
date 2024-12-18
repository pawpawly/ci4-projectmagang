<?php

namespace App\Controllers;

use App\Models\SaranModel;
use CodeIgniter\Controller;

class SaranController extends Controller
{
    protected $saranModel;

    public function __construct()
    {
        $this->saranModel = new SaranModel();
    }

    public function saveSaran()
    {
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'NAMA_SARAN'          => 'required',
            'EMAIL_SARAN'         => 'required|valid_email',
            'KOMENTAR_SARAN'      => 'required',
            'g-recaptcha-response' => 'required' // Tambahkan validasi CAPTCHA
        ]);
    
// Jalankan validasi
if (!$validation->withRequest($this->request)->run()) {
    $errors = $validation->getErrors();

    // Periksa apakah error berasal dari validasi EMAIL_SARAN
    if (isset($errors['EMAIL_SARAN'])) {
        return $this->response->setJSON([
            'success' => false,
            'icon'    => 'warning', 
            'message' => 'Format Email Tidak Sesuai.',
            'errors'  => $errors
        ]);
    }

    // Jika ada error lainnya
    return $this->response->setJSON([
        'success' => false,
        'icon'    => 'error',
        'message' => 'Format data tidak valid.',
        'errors'  => $errors
    ]);
}
    
        // reCAPTCHA Validation
        $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
        $secretKey = '6Lex854qAAAAAOw4Pkbyc66-dSXlbrS3JZqfoZsv';
        $url = 'https://www.google.com/recaptcha/api/siteverify';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'secret'   => $secretKey,
            'response' => $recaptchaResponse
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            log_message('error', 'reCAPTCHA cURL Error: ' . curl_error($ch));
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kesalahan koneksi ke reCAPTCHA.',
            ]);
        }
        curl_close($ch);
    
        $responseKeys = json_decode($response, true);
        log_message('debug', 'reCAPTCHA API Response: ' . json_encode($responseKeys));
    
        if (empty($responseKeys['success']) || !$responseKeys['success']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Verifikasi CAPTCHA gagal. Silakan coba lagi.'
            ]);
        }
    
        // Save data to database
        $data = [
            'NAMA_SARAN'      => $this->request->getPost('NAMA_SARAN'),
            'EMAIL_SARAN'     => $this->request->getPost('EMAIL_SARAN'),
            'KOMENTAR_SARAN'  => $this->request->getPost('KOMENTAR_SARAN'),
            'TANGGAL_SARAN'   => date('Y-m-d H:i:s')
        ];
    
        if ($this->saranModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Saran berhasil dikirim!'
            ]);
        } else {
            log_message('error', 'Database insertion failed');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengirim saran.'
            ]);
        }
    }
    
}