<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class GuestbookAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Validate that `guestbook_auth` session exists
        if (!session()->get('guestbook_auth')) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk halaman ini.');
            return redirect()->to('/'); 
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Set headers to prevent caching after the response
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->setHeader('Pragma', 'no-cache');
        $response->setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

        $currentURL = current_url();
        if (strpos($currentURL, '/bukutamu') === false) {
            session()->destroy();
        }
    }
}
