<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\KategoriEventModel;
use CodeIgniter\Controller;

class Event extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Lakukan JOIN antara event dan kategori_event
        $builder = $db->table('event');
        $builder->select('event.*, kategori_event.KATEGORI_KEVENT');
        $builder->join('kategori_event', 'event.ID_KEVENT = kategori_event.ID_KEVENT', 'left');
        $events = $builder->get()->getResultArray();

        // Kirim data event dan title ke view
        return view('event', [
            'events' => $events,
            'title' => 'Daftar Event'
        ]);
    }
}
