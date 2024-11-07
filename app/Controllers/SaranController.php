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
            'NAMA_SARAN' => 'required',
            'EMAIL_SARAN' => 'required|valid_email',
            'KOMENTAR_SARAN' => 'required'
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Semua field wajib diisi dengan benar.',
                'errors' => $validation->getErrors()
            ]);
        }
    
        $data = [
            'NAMA_SARAN' => $this->request->getPost('NAMA_SARAN'),
            'EMAIL_SARAN' => $this->request->getPost('EMAIL_SARAN'),
            'KOMENTAR_SARAN' => $this->request->getPost('KOMENTAR_SARAN'),
            'TANGGAL_SARAN' => date('Y-m-d H:i:s')
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