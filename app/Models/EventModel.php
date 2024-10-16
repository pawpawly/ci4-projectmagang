<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'ID_EVENT';
    protected $allowedFields = [
        'ID_KEVENT', 'USERNAME', 'NAMA_EVENT', 
        'DEKSRIPSI_EVENT', 'TANGGAL_EVENT', 'FOTO_EVENT'
    ];

    // Matikan timestamps jika tidak digunakan
    protected $useTimestamps = false;
}
