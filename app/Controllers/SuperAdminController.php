<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class SuperAdminController extends Controller
{
    // Metode untuk menampilkan form tambah pengguna
    public function addUserForm()
    {
        return view('superadmin/add_user');
    }

    // Metode untuk menyimpan data pengguna baru
    public function saveUser()
    {
        $userModel = new UserModel();

        // Dapatkan data dari form
        $data = [
            'NAMA_USER' => $this->request->getPost('nama_lengkap'),
            'USERNAME'  => $this->request->getPost('username'),
            'PASSWORD_USER' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'LEVEL_USER' => $this->request->getPost('level_user'),
        ];

        // Masukkan ke database
        $userModel->insert($data);

        // Redirect kembali ke halaman manajemen pengguna dengan pesan sukses
        return redirect()->to('superadmin/user-management')->with('message', 'User berhasil ditambahkan');
    }
}
