<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class EventController extends Controller
{
    protected $eventModel;
    protected $kategoriEventModel;

    public function __construct()
    {
        helper('month');  // Muat helper bulan
        $this->eventModel = new EventModel();  // Inisialisasi model event
    }

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

    public function detail($nama_event)
    {
        // Temukan event berdasarkan nama event
        $event = $this->eventModel->where('NAMA_EVENT', $nama_event)->first();

        if (!$event) {
            return redirect()->to('/event')->with('error', 'Event tidak ditemukan.');
        }

        // Kirim data event ke view detail
        return view('event/detail', ['event' => $event]);
    }
}

