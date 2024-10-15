<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {

        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $this->response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
        $this->response->setHeader('Pragma', 'no-cache');
        
        return view('login');
    }

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password'); 
        $userModel = new UserModel();
        $user = $userModel->where('USERNAME', $username)->first(); 


        if ($user) {
            if (password_verify($password, $user['PASSWORD_USER'])) {
                session()->set([
                    'username' => $username,
                    'NAMA_USER' => $user['NAMA_USER'],
                    'isLoggedIn' => true,
                    'LEVEL_USER' => $user['LEVEL_USER']
                ]);
                if ($user['LEVEL_USER'] === '1') {
                    return redirect()->to(site_url('admin/dashboard'));
                } elseif ($user['LEVEL_USER'] === '2') {
                    return redirect()->to(site_url('superadmin/dashboard'));
                }
            } else {
                return redirect()->back()->with('error', 'Password salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'));
    }
}

