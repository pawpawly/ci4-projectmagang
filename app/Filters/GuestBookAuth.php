<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class GuestbookAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Disable caching to prevent accessing through the back button
        $request->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $request->setHeader('Pragma', 'no-cache');
        
        // Validate that `guestbook_auth` session exists
        if (!session()->get('guestbook_auth')) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk halaman ini.');
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after request
    }
}
