<?php

namespace App\Controllers;

use App\Models\EventModel;  // Panggil model event
use App\Models\BeritaModel; // Panggil model berita

class Home extends BaseController
{
    protected $eventModel;
    protected $beritaModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();   // Inisialisasi model event
        $this->beritaModel = new BeritaModel(); // Inisialisasi model berita
    }

    public function index()
    {
        // Ambil semua event
        $events = $this->eventModel->findAll();

        // Ambil maksimal 4 berita terbaru berdasarkan tanggal
        $berita = $this->beritaModel
                       ->orderBy('TANGGAL_BERITA', 'DESC')
                       ->limit(4)
                       ->getBeritaWithUser();

        // Kirim data ke view
        return view('home', [
            'title' => 'Home',
            'events' => $events,
            'berita' => $berita, // Kirim berita terbaru ke view
        ]);
    }
}
