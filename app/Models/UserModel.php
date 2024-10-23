<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'USER';  
    protected $primaryKey = 'USERNAME';
    protected $allowedFields = ['USERNAME', 'NAMA_USER', 'PASSWORD_USER', 'LEVEL_USER'];
    public $timestamps = false;

    public function getUserByUsername($username)
    {
        return $this->where('USERNAME', $username)->first();
    }

    // Fungsi untuk memperbarui user dengan transaksi
    public function updateUserWithTransaction($originalUsername, $data)
    {
        $db = \Config\Database::connect(); // Pastikan koneksi DB ada
        $builder = $db->table($this->table);

        try {
            $db->transBegin(); // Mulai transaksi

            // Update data pengguna berdasarkan USERNAME
            $builder->where('USERNAME', $originalUsername)->update($data);

            if ($db->transStatus() === false) {
                $db->transRollback(); // Rollback jika terjadi kesalahan
                return false;
            }

            $db->transCommit(); // Commit jika sukses
            return true;
        } catch (\Exception $e) {
            $db->transRollback(); // Rollback jika exception
            log_message('error', $e->getMessage());
            return false;
        }
    }
}
