<?= $this->extend('admin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Detail Berita</h1>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Foto Berita:</h2>
        <?php if (!empty($berita['FOTO_BERITA'])): ?>
            <img src="<?= base_url('uploads/berita/' . $berita['FOTO_BERITA']); ?>" 
                 alt="Foto Berita" class="w-72 h-48 object-cover rounded-md shadow-md">
        <?php else: ?>
            <span class="text-gray-400 text-xs font-semibold inline-flex items-center justify-center w-24 h-8 rounded-md text-sm">Foto Berita Tidak Tersedia</span>
        <?php endif; ?>
    </div>
    
    <div class="mb-4">
        <h2 class="text-lg font-semibold">Nama Berita:</h2>
        <p><?= esc($berita['NAMA_BERITA']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Penyiar Berita:</h2>
        <p><?= esc($berita['PENYIAR_BERITA']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Sumber Berita:</h2>
        <p><?= esc($berita['SUMBER_BERITA']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Tanggal Berita:</h2>
        <p><?= formatTanggalIndonesia($berita['TANGGAL_BERITA']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Deskripsi:</h2>
        <p><?= nl2br(esc($berita['DESKRIPSI_BERITA'])); ?></p>
    </div>


    <div class="mt-6">
        <a href="<?= site_url('admin/berita/manage'); ?>" 
           class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            Kembali
        </a>
    </div>
</div>
<?= $this->endSection() ?>
