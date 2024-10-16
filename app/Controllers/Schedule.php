<?php

namespace App\Controllers;

class Schedule extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Jadwal'
        ];

        return view('schedule', $data);
    }
}