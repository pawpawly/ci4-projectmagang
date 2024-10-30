<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BukuTamuController extends Controller
{
    public function form()
    {
        // Cek apakah session 'form_access' ada
        if (!session()->get('form_access')) {
            // Jika tidak ada, redirect ke dashboard atau halaman error
            return redirect()->to('/superadmin/dashboard')->with('error', 'Akses tidak valid.');
        }

        // Tampilkan form jika akses valid
        return view('bukutamu/add_guestbook');
    }

    public function grantAccess()
    {
        // Set session 'form_access' saat tombol di SuperAdmin ditekan
        session()->set('form_access', true);

        // Redirect ke halaman form buku tamu
        return redirect()->to('/bukutamu/form');
    }

    public function destroyAccess()
    {
        // Hapus session 'form_access' saat pengguna selesai atau batal
        session()->remove('form_access');
        return redirect()->to('/superadmin/dashboard');
    }
}
