<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Detail Buku Tamu</h1>

    <div class="mb-4">
    <h2 class="text-lg font-semibold">Foto Tamu:</h2>
    <img src="<?= base_url($tamu['FOTO_TAMU']) ?>" 
         alt="Foto Tamu" class="w-72 h-48 object-cover rounded-md shadow-md">
</div>

<div class="mb-4">
    <h2 class="text-lg font-semibold">Nama Tamu / Instansi:</h2>
    <p><?= esc($tamu['NAMA_TAMU']); ?></p>
</div>

<div class="mb-4">
    <h2 class="text-lg font-semibold">Alamat:</h2>
    <p><?= esc($tamu['ALAMAT_TAMU']); ?></p>
</div>

<div class="mb-4">
    <h2 class="text-lg font-semibold">No HP:</h2>
    <p><?= esc($tamu['NOHP_TAMU']); ?></p>
</div>

<div class="mb-4">
    <h2 class="text-lg font-semibold">Tanggal Kunjungan:</h2>
    <p><?= formatTanggalIndonesia($tamu['TGLKUNJUNGAN_TAMU']); ?></p>
</div>

<div class="mb-4">
    <h2 class="text-lg font-semibold">Jumlah Tamu Laki-laki:</h2>
    <p><?= esc($tamu['JKL_TAMU']); ?> Orang</p>
</div>

<div class="mb-4">
    <h2 class="text-lg font-semibold">Jumlah Tamu Perempuan:</h2>
    <p><?= esc($tamu['JKP_TAMU']); ?> Orang</p>
</div>

<div class="mt-6">
    <a href="<?= site_url('superadmin/bukutamu/manage'); ?>" 
       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
        Kembali
    </a>
</div>

<?= $this->endSection() ?>
