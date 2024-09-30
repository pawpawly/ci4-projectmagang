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

        return view('superadmin/dashboard');
    }
}
