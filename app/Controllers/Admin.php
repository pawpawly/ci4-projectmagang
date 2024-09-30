<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        return view('admin/dashboard');
    }
}
