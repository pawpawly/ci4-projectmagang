<?php

namespace App\Controllers;

use App\Models\EventModel;  // Panggil model event
use App\Models\BeritaModel; // Panggil model berita
use App\Models\KoleksiModel; // Panggil model koleksi

class Home extends BaseController
{
    protected $eventModel;
    protected $beritaModel;
    protected $koleksiModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();   // Inisialisasi model event
        $this->beritaModel = new BeritaModel(); // Inisialisasi model berita
        $this->koleksiModel = new KoleksiModel(); // Inisialisasi model koleksi
    }

    public function index()
{
    $today = date('Y-m-d'); // Ambil tanggal hari ini

    // Ambil hanya event yang belum lewat (tanggal event >= hari ini)
    $events = $this->eventModel
                   ->where('TANGGAL_EVENT >=', $today)
                   ->orderBy('TANGGAL_EVENT', 'ASC') // Urutkan berdasarkan tanggal terdekat
                   ->findAll();

    // Ambil maksimal 4 berita terbaru berdasarkan tanggal
    $berita = $this->beritaModel
                   ->orderBy('TANGGAL_BERITA', 'DESC')
                   ->limit(4)
                   ->getBeritaWithUser();

    // Ambil 5 koleksi secara random
    $koleksi = $this->koleksiModel
                    ->orderBy('RAND()')
                    ->limit(5)
                    ->findAll();

    // Hitung jumlah koleksi
    $jumlahKoleksi = $this->koleksiModel->countAll(); 

    // Kirim data ke view
    return view('home', [
        'title' => 'Home',
        'events' => $events,       // Hanya event mendatang
        'berita' => $berita,       // Berita terbaru
        'koleksi' => $koleksi,     // Koleksi random
        'jumlahKoleksi' => $jumlahKoleksi, // Jumlah koleksi
    ]);
}

    
}
