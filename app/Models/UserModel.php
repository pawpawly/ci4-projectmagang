<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'USER';
    protected $primaryKey = 'USERNAME';
    protected $allowedFields = ['USERNAME', 'NAMA_USER', 'PASSWORD_USER', 'LEVEL_USER', 'USER_TOKEN'];
    public $timestamps = false;

    public function getUserByUsername($username)
    {
        return $this->where('USERNAME', $username)->first();
    }

    // Fungsi untuk memperbarui user dengan transaksi
    public function updateUserWithTransaction($originalUsername, $data)
    {
        $db = \Config\Database::connect(); // Koneksi DB
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

    // Fungsi untuk memperbarui USER_TOKEN
    public function updateUserToken($username, $token)
    {
        return $this->update($username, ['USER_TOKEN' => $token]);
    }
}
