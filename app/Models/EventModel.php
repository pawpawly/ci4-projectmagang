<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'event'; // Correct table name
    protected $primaryKey = 'ID_EVENT';
    protected $allowedFields = [
        'NAMA_EVENT', 'ID_KEVENT', 'TANGGAL_EVENT', 'JAM_EVENT', 'FOTO_EVENT', 'DEKSRIPSI_EVENT'
    ];

    // Method to get events with their categories
    public function getEventsWithCategory()
    {
        return $this->select('event.*, kategori_event.KATEGORI_KEVENT as NAMA_KATEGORI')
                    ->join('kategori_event', 'kategori_event.ID_KEVENT = event.ID_KEVENT', 'left')
                    ->findAll();
    }
}
