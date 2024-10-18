<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah pengguna sudah login
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Anda harus login untuk mengakses halaman ini.');
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Pastikan halaman tidak di-cache
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->setHeader('Pragma', 'no-cache');
        $response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
}
