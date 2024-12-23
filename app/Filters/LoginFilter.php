<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserModel;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userModel = new UserModel();

        // Cek jika user belum login atau tidak memiliki token
        if (!$session->get('isLoggedIn') || !$session->get('USER_TOKEN')) {
            $session->destroy();
            return redirect()->to('/login')->with('error', 'Sesi Anda tidak valid atau telah berakhir.');
        }

        // Ambil user dari database berdasarkan username dan validasi token
        $username = $session->get('username');
        $userToken = $session->get('USER_TOKEN');
        $user = $userModel->where('USERNAME', $username)->first();

        // Validasi USER_TOKEN
        if (!$user || $user['USER_TOKEN'] !== $userToken) {
            $session->destroy();
            return redirect()->to('/login')->with('error', 'Sesi tidak valid atau telah berakhir.');
        }

        // Validasi LEVEL_USER jika argument level diberikan
        if ($arguments && !in_array($session->get('LEVEL_USER'), $arguments)) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Pastikan halaman tidak disimpan di cache
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->setHeader('Pragma', 'no-cache');
        $response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
}
