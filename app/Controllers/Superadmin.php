<?php

namespace App\Controllers;

class Superadmin extends BaseController
{
    public function dashboard()
    {
        // Periksa apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        // Pastikan user memiliki LEVEL_USER = 2 (superadmin)
        if (session()->get('LEVEL_USER') !== '2') {
            return redirect()->to(site_url('login'))->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini!');
        }

        // Ambil NAMA_USER dari session
        $NAMA_USER = session()->get('NAMA_USER');

        // Kirim data NAMA_USER ke view
        return view('superadmin/dashboard', ['NAMA_USER' => $NAMA_USER]);
    }
}
