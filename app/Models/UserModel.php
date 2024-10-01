<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'USER'; // Nama tabel dalam huruf kapital
    protected $primaryKey = 'USERNAME'; // Primary key dengan kapital
    protected $allowedFields = ['USERNAME', 'NAMA_USER', 'PASSWORD_USER', 'LEVEL_USER']; // Kolom-kolom dengan kapital

    // Fungsi untuk mengambil user berdasarkan USERNAME
    public function getUserByUsername($username)
    {
        return $this->where('USERNAME', $username)->first();
    }
}
