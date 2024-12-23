<?= $this->extend('admin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Detail Event</h1>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Poster Acara:</h2>
        <?php if (!empty($event['FOTO_EVENT'])): ?>
            <img src="<?= base_url('uploads/poster/' . $event['FOTO_EVENT']); ?>" 
                 alt="Poster Acara" class="w-48 h-72 object-cover rounded-md shadow-md">
        <?php else: ?>
            <span class="text-gray-400 text-xs font-semibold inline-flex items-center justify-center w-24 h-8 rounded-md text-sm">Foto Event Tidak Tersedia</span>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Nama Acara:</h2>
        <p><?= esc($event['NAMA_EVENT']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Kategori Acara:</h2>
        <p><?= esc($event['NAMA_KATEGORI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Tanggal Acara:</h2>
        <p><?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?></p>
    </div>

    <div class="mb-4">
    <h2 class="text-lg font-semibold">Jam Mulai:</h2>
    <p><?= date('H:i', strtotime($event['JAM_EVENT'])) . ' WITA'; ?></p>
</div>


    <div class="mb-4">
        <h2 class="text-lg font-semibold">Deskripsi Acara:</h2>
        <p><?= esc($event['DEKSRIPSI_EVENT']); ?></p>
    </div>

    <div class="mt-6">
        <a href="<?= site_url('admin/event/manage'); ?>" 
           class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            Kembali
        </a>
    </div>
</div>
<?= $this->endSection() ?>
