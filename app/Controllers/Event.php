<?php

namespace App\Controllers;
use App\Models\EventModel;
use App\Models\KategoriEventModel;
use CodeIgniter\Controller;

class Event extends Controller
{
    protected $eventModel;
    protected $kategoriEventModel;

    public function __construct()
    {
        helper('month'); 
        $this->eventModel = new EventModel(); 
    }

    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil data event dan kategori event
        $builder = $db->table('event');
        $builder->select('event.*, kategori_event.KATEGORI_KEVENT');
        $builder->join('kategori_event', 'event.ID_KEVENT = kategori_event.ID_KEVENT', 'left');
        $events = $builder->get()->getResultArray();

        // Kirim data ke view
        return view('event/index', [
            'events' => $events,
            'title' => 'Daftar Event'
        ]);
    }

    public function detail($nama_event)
    {
        $db = \Config\Database::connect();
    
        // Ambil event dengan join kategori_event berdasarkan nama event
        $builder = $db->table('event');
        $builder->select('event.*, kategori_event.KATEGORI_KEVENT');
        $builder->join('kategori_event', 'event.ID_KEVENT = kategori_event.ID_KEVENT', 'left');
        $builder->where('event.NAMA_EVENT', urldecode($nama_event));
        $event = $builder->get()->getRowArray();  // Ambil satu hasil sebagai array
    
        if (!$event) {
            // Kembalikan 404 jika tidak ditemukan
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Event ' . $nama_event . ' tidak ditemukan');
        }
    
        // Kirim data ke view detail
        return view('event/detail', [
            'event' => $event,
            'title' => 'Detail Event'
        ]);
    }
}