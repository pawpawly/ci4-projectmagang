<?php

namespace App\Controllers;
use App\Models\EventModel; // Panggil model event
use App\Models\BeritaModel; // Panggil model berita

class Home extends BaseController
{
    protected $eventModel;
    protected $beritaModel;

    public function __construct()
    {
        $this->eventModel = new EventModel(); // Inisialisasi model event
        $this->beritaModel = new BeritaModel(); // Inisialisasi model berita
    }

    public function index()
    {
        $events = $this->eventModel->findAll(); // Ambil semua event
        $berita = $this->beritaModel->getBeritaWithUser(); // Ambil semua berita dengan user

        return view('home', [
            'title' => 'Home',
            'events' => $events,
            'berita' => $berita, // Kirim data berita ke view
        ]);
    }
}
