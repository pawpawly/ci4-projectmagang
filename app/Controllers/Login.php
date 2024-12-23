<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        // Set anti-cache headers
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $this->response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
        $this->response->setHeader('Pragma', 'no-cache');

        return view('login');
    }

    public function authenticate()
    {
        $session = session();
        $request = $this->request;
        $userModel = new \App\Models\UserModel();
    
        // Ambil input username dan password
        $username = $request->getPost('username');
        $password = $request->getPost('password');
    
        // Validasi input kosong
        if (empty($username) || empty($password)) {
            $session->setFlashdata('error', 'Username dan Password tidak boleh kosong');
            return redirect()->to('/login');
        }
    
        // Ambil user dari database
        $user = $userModel->where('USERNAME', $username)->first();
    
        // Validasi user dan password
        if (!$user || !password_verify($password, $user['PASSWORD_USER'])) {
            $session->setFlashdata('error', 'Username atau Password salah.');
            return redirect()->to('/login');
        }
    
        // Generate token unik
        $userToken = bin2hex(random_bytes(16));
    
        // Update USER_TOKEN menggunakan USERNAME sebagai kunci
        $userModel->update($user['USERNAME'], ['USER_TOKEN' => $userToken]);
    
        // Set data sesi
        $session->set([
            'username'     => $user['USERNAME'],
            'NAMA_USER'    => $user['NAMA_USER'],
            'LEVEL_USER'   => $user['LEVEL_USER'],
            'isLoggedIn'   => true,
            'USER_TOKEN'   => $userToken,
        ]);
    
        // Redirect berdasarkan LEVEL_USER
        if ($user['LEVEL_USER'] === '1') {
            return redirect()->to('/admin/dashboard');
        } elseif ($user['LEVEL_USER'] === '2') {
            return redirect()->to('/superadmin/dashboard');
        } else {
            $session->destroy();
            return redirect()->to('/login')->with('error', 'Role pengguna tidak dikenali.');
        }
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
