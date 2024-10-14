<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class SuperAdminController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        // Inisialisasi UserModel sekali agar tidak diulang-ulang
        $this->userModel = new UserModel();
    }

    /**
     * Tampilkan halaman manajemen pengguna.
     */
    public function index()
    {
        $users = $this->userModel->findAll();
        return view('superadmin/user_management', ['users' => $users]);
    }

    /**
     * Tampilkan form tambah pengguna.
     */
    public function addUserForm()
    {
        return view('superadmin/add_user');
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function saveUser()
    {
        $username = $this->request->getPost('username');

        // Cek apakah username sudah ada
        if ($this->userModel->where('USERNAME', $username)->first()) {
            return redirect()->back()->with('error', 'Username sudah digunakan!');
        }

        $data = [
            'NAMA_USER'     => $this->request->getPost('nama_lengkap'),
            'USERNAME'      => $username,
            'PASSWORD_USER' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'LEVEL_USER'    => $this->request->getPost('level_user'),
        ];

        $this->userModel->insert($data);
        return redirect()->to('superadmin/user-management')->with('message', 'User berhasil ditambahkan.');
    }

    /**
     * Hapus pengguna berdasarkan username.
     */
    public function deleteUser($username)
    {
        try {
            if ($this->userModel->where('USERNAME', $username)->delete()) {
                return redirect()->to('superadmin/user-management')->with('message', 'User berhasil dihapus.');
            } else {
                return redirect()->to('superadmin/user-management')->with('error', 'Gagal menghapus user.');
            }
        } catch (\Exception $e) {
            return redirect()->to('superadmin/user-management')->with('error', $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit pengguna berdasarkan username.
     */
    public function editUser($username)
    {
        $user = $this->userModel->where('USERNAME', $username)->first();

        if (!$user) {
            return redirect()->to('superadmin/user-management')->with('error', 'User tidak ditemukan!');
        }

        return view('superadmin/edit_user', ['user' => $user]);
    }

    /**
     * Update data pengguna.
     */
    public function updateUser()
    {
        $originalUsername = $this->request->getPost('original_username');
        $newUsername = $this->request->getPost('username');

        // Cek apakah username baru sudah digunakan oleh user lain
        if ($newUsername !== $originalUsername && $this->userModel->where('USERNAME', $newUsername)->first()) {
            return redirect()->back()->with('error', 'Username sudah digunakan!');
        }

        $data = [
            'NAMA_USER'  => $this->request->getPost('nama_lengkap'),
            'USERNAME'   => $newUsername,
            'LEVEL_USER' => $this->request->getPost('level_user'),
        ];

        // Update password jika diisi
        if ($this->request->getPost('password')) {
            $data['PASSWORD_USER'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->where('USERNAME', $originalUsername)->set($data)->update();
        return redirect()->to('superadmin/user-management')->with('message', 'User berhasil diperbarui.');
    }
}
