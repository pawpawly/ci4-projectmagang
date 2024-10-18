<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SuperAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah pengguna sudah login
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu.');
            return redirect()->to(site_url('login'));
        }

        // Cek apakah level user adalah superadmin (2)
        if (session()->get('LEVEL_USER') !== '2') {
            session()->setFlashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman ini!');
            return redirect()->to(site_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Pastikan tidak ada cache pada halaman terproteksi
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->setHeader('Pragma', 'no-cache');
        $response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
}
