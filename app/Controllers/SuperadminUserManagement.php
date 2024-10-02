<?php

namespace App\Controllers;

use App\Models\UserModel;

class SuperadminUserManagement extends BaseController
{
    public function index()
    {
        // Periksa apakah user sudah login dan memiliki level superadmin
        if (!session()->get('isLoggedIn') || session()->get('LEVEL_USER') !== '2') {
            return redirect()->to(site_url('login'))->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini!');
        }

        // Inisialisasi model untuk mengambil data user
        $userModel = new UserModel();
        $users = $userModel->findAll(); // Ambil semua data user

        // Kirim data pengguna ke view
        return view('superadmin/user_management', ['users' => $users]);
    }
}
