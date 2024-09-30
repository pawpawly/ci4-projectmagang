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
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password'); 


        $userModel = new UserModel();
        $user = $userModel->getUserByUsername($username);

        if ($user) {
  
            if (isset($user['PASSWORD_USER']) && $user['PASSWORD_USER'] === $password) {
                session()->set([
                    'username' => $username,
                    'isLoggedIn' => true,
                    'level' => $user['LEVEL_USER'] 
                ]);

                return redirect()->to(site_url('admin/dashboard'));
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
