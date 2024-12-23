<?= $this->extend('admin/sidebar') ?>

<?= $this->section('content') ?>

<?php helper('month'); ?>

<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Detail Saran</h1>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Nama:</h2>
        <p><?= esc($saran['NAMA_SARAN']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Email:</h2>
        <p><?= esc($saran['EMAIL_SARAN']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Komentar:</h2>
        <p><?= esc($saran['KOMENTAR_SARAN']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Tanggal Saran:</h2>
        <p>
            <?= formatTanggalIndonesia($saran['TANGGAL_SARAN']) . ' ' . date('H:i:s', strtotime($saran['TANGGAL_SARAN'])) . ' WITA'; ?>
        </p>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        <a href="<?= site_url('admin/saran/manage'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Kembali</a>
    </div>
</div>

<?= $this->endSection() ?>
