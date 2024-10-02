<?php

namespace App\Controllers;

class AboutUs extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Tentang Kami'
        ];

        return view('about_us', $data);
    }
}
