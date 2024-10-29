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
    
        // Ambil tanggal hari ini
        $today = date('Y-m-d');
    
        // Ambil data event dan kategori event dengan filter tanggal
        $builder = $db->table('event');
        $builder->select('event.*, kategori_event.KATEGORI_KEVENT');
        $builder->join('kategori_event', 'event.ID_KEVENT = kategori_event.ID_KEVENT', 'left');
        $builder->where('event.TANGGAL_EVENT >=', $today); // Filter event yang belum lewat
        $builder->orderBy('event.TANGGAL_EVENT', 'ASC'); // Urutkan berdasarkan tanggal terdekat
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
    
        // Ambil tanggal hari ini
        $today = date('Y-m-d');
    
        // Ambil event berdasarkan nama event dan join kategori event
        $builder = $db->table('event');
        $builder->select('event.*, kategori_event.KATEGORI_KEVENT');
        $builder->join('kategori_event', 'event.ID_KEVENT = kategori_event.ID_KEVENT', 'left');
        $builder->where('event.NAMA_EVENT', urldecode($nama_event));
        $builder->where('event.TANGGAL_EVENT >=', $today); // Pastikan event belum lewat
        $event = $builder->get()->getRowArray(); // Ambil satu hasil sebagai array
    
        if (!$event) {
            // Kembalikan 404 jika tidak ditemukan atau sudah lewat
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Event ' . $nama_event . ' tidak ditemukan atau sudah berakhir');
        }
    
        // Kirim data ke view detail
        return view('event/detail', [
            'event' => $event,
            'title' => 'Detail Event'
        ]);
    }    
}