<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; 
    protected $primaryKey = 'USERNAME'; 
    protected $allowedFields = ['USERNAME', 'PASSWORD_USER', 'NAMA_USER', 'LEVEL_USER']; 
    public function getUserByUsername($username)
    {
        return $this->where('USERNAME', $username)->first();
    }
}
