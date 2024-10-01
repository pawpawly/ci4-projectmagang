<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Pastikan user login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        // Pastikan user adalah admin (LEVEL_USER = 1)
        if (session()->get('LEVEL_USER') !== '1') {
            return redirect()->to(site_url('login'))->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu digunakan untuk kasus ini
    }
}
