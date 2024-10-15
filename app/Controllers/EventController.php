<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class EventController extends Controller
{
    public function category()
    {
        // Tampilkan view untuk Kategori Event
        return view('event/category');
    }

    public function manage()
    {
        // Tampilkan view untuk Manajemen Event
        return view('event/manage');
    }
}
