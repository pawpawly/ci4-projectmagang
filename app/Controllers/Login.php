<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{

    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        // Dapatkan data dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password'); // Password yang dimasukkan user

        // Inisialisasi UserModel untuk mengakses database
        $userModel = new UserModel();
        $user = $userModel->getUserByUsername($username);

        // Cek apakah user ditemukan
        if ($user) {
            // Cek apakah password benar (plaintext, disarankan menggunakan hash di masa depan)
            if (isset($user['PASSWORD_USER']) && $user['PASSWORD_USER'] === $password) {
                // Simpan informasi login ke session
                session()->set([
                    'username' => $username,
                    'isLoggedIn' => true,
                    'level' => $user['LEVEL_USER'] // Simpan level user di session
                ]);

                // Redirect berdasarkan LEVEL_USER
                if ($user['LEVEL_USER'] === '1') {
                    return redirect()->to(site_url('admin/dashboard'));
                } elseif ($user['LEVEL_USER'] === '2') {
                    return redirect()->to(site_url('superadmin/dashboard'));
                }

            } else {
                // Jika password salah
                return redirect()->back()->with('error', 'Password salah!');
            }
        } else {
            // Jika username tidak ditemukan
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }
    }

    public function logout()
    {
        // Hapus session login
        session()->destroy();
        return redirect()->to(site_url('login'));
    }
}
