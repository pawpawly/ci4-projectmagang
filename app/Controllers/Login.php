<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {

        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $this->response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
        $this->response->setHeader('Pragma', 'no-cache');
        
        return view('login');
    }

    public function authenticate()
    {
        $session = session();
        $request = $this->request;

        // Ambil data input
        $username = $request->getPost('username');
        $password = $request->getPost('password');

        // Validasi input kosong
        if (empty($username) || empty($password)) {
            $session->setFlashdata('error', 'Username dan Password tidak boleh kosong');
            return redirect()->to('/login');
        }

        // Ambil user dari database
        $userModel = new UserModel();
        $user = $userModel->where('USERNAME', $username)->first();

        if (!$user) {
            // Username tidak ditemukan
            $session->setFlashdata('error', 'Username atau Password Salah');
            return redirect()->to('/login');
        }

        if (isset($user['PASSWORD_USER']) && password_verify($password, $user['PASSWORD_USER'])) {
            // Login berhasil
            $session->set([
                'username' => $user['USERNAME'],
                'NAMA_USER' => $user['NAMA_USER'],
                'LEVEL_USER' => $user['LEVEL_USER'], // Set level user
                'isLoggedIn' => true,
            ]);

            // Redirect berdasarkan LEVEL_USER
            if ($user['LEVEL_USER'] == '2') {
                return redirect()->to('/superadmin/dashboard'); // Superadmin
            } elseif ($user['LEVEL_USER'] == '1') {
                return redirect()->to('/admin/dashboard'); // Admin
            } else {
                $session->setFlashdata('error', 'Role pengguna tidak dikenali');
                return redirect()->to('/login');
            }
        } else {
            // Password salah
            $session->setFlashdata('error', 'Username atau Password Salah');
            return redirect()->to('/login');
        }
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'));
    }
}

