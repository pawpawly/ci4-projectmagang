<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriEventModel extends Model
{
    protected $table = 'kategori_event';
    protected $primaryKey = 'ID_KEVENT';
    protected $allowedFields = ['KATEGORI_KEVENT', 'DESKRIPSI_KEVENT'];
}
