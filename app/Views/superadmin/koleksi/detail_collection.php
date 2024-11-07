<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Detail Koleksi</h1>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Foto Koleksi:</h2>
        <img src="<?= base_url('uploads/koleksi/' . $collection['FOTO_KOLEKSI']); ?>" 
             alt="Foto Koleksi" class="w-72 h-48 object-cover rounded-md shadow-md">
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Nama Koleksi:</h2>
        <p><?= esc($collection['NAMA_KOLEKSI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Kategori Koleksi:</h2>
        <p><?= esc($collection['KATEGORI_KKOLEKSI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Deskripsi Koleksi:</h2>
        <p><?= !empty($collection['DESKRIPSI_KOLEKSI']) ? esc($collection['DESKRIPSI_KOLEKSI']) : 'Deskripsi Tidak Tersedia'; ?></p>
    </div>

    <div class="mt-6">
        <a href="<?= site_url('superadmin/koleksi/manage'); ?>" 
           class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            Kembali
        </a>
    </div>
</div>
<?= $this->endSection() ?>
