<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'USERNAME'; // Asumsikan primary key adalah USERNAME
    protected $allowedFields = ['USERNAME', 'NAMA_USER', 'PASSWORD_USER', 'LEVEL_USER'];
}
