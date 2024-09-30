<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Nama tabel
    protected $primaryKey = 'USERNAME'; // Primary key dengan kapital
    protected $allowedFields = ['USERNAME', 'PASSWORD_USER', 'NAMA_USER', 'LEVEL_USER']; // Kolom-kolom yang diizinkan

    // Fungsi untuk mengambil user berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('USERNAME', $username)->first();
    }
}
