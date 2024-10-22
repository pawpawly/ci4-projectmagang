<?php

namespace App\Controllers;
use App\Models\EventModel; // Panggil model event

class Home extends BaseController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel(); // Inisialisasi model
    }

    public function index()
    {
        $events = $this->eventModel->findAll(); // Pastikan tidak ada limit di sini
    
        return view('home', [
            'title' => 'Home',
            'events' => $events,
        ]);
    }
    
}
