<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\ReservasiModel;

class ScheduleController extends BaseController
{
public function index()
{
    $eventModel = new EventModel();
    $reservasiModel = new ReservasiModel();

    $month = $this->request->getGet('month') ?? date('m');
    $year = $this->request->getGet('year') ?? date('Y');

    $events = $eventModel->getEventsByMonth($month, $year);
    $reservations = $reservasiModel->getReservationsByMonth($month, $year);

    if ($this->request->isAJAX()) {
        return $this->response->setJSON([
            'events' => $events,
            'reservations' => $reservations,
        ]);
    }

    $data = [
        'title' => 'Jadwal & Reservasi',
        'events' => $events,
        'reservations' => $reservations,
        'month' => $month,
        'year' => $year,
    ];

    return view('schedule', $data);
}
    
}
