<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'USER'; // Tabel menggunakan huruf kapital
    protected $primaryKey = 'USERNAME';
    protected $allowedFields = ['USERNAME', 'NAMA_USER', 'PASSWORD_USER', 'LEVEL_USER'];
    public $timestamps = false;

    // Method untuk mendapatkan user berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('USERNAME', $username)->first();
    }
}
