<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller
{
    public function logout()
    {
        // Hapus semua session
        session()->destroy();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }
}
