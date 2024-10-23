<?php

namespace App\Validation;

class CustomValidation
{
    // Fungsi untuk memvalidasi apakah tanggal tidak di masa lalu
    public static function checkFutureDate(string $tanggal, ?array $data = null): bool
    {
        return strtotime($tanggal) >= strtotime(date('Y-m-d'));
    }

    // Fungsi untuk mengembalikan pesan error
    public static function checkFutureDateError(): string
    {
        return 'Tanggal acara tidak boleh di masa lalu. Harap pilih tanggal yang valid.';
    }
}
