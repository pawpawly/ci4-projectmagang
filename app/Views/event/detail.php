<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar dan Nama Event -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center"><?= esc($event['NAMA_EVENT']); ?></h1>
        <p class="text-xl text-white text-center mt-4">Detail Event</p>
    </div>
</div>

<!-- Konten Utama dengan Layout Gambar Kiri dan Keterangan Kanan -->
<div class="container mx-auto px-8 py-12">
    <div class="flex flex-col lg:flex-row items-start gap-8">
        <!-- Gambar Event -->
        <div class="w-full lg:w-1/2">
            <img 
                src="<?= base_url('uploads/poster/' . (!empty($event['FOTO_EVENT']) ? $event['FOTO_EVENT'] : 'default.png')); ?>" 
                alt="<?= esc($event['NAMA_EVENT']); ?>" 
                class="object-contain w-full max-h-[500px] bg-gray-100 p-2 rounded-lg">
        </div>

        <!-- Detail Event -->
        <div class="w-full lg:w-1/2">
            <h1 class="text-4xl font-bold mb-4"><?= esc($event['NAMA_EVENT']); ?></h1>
            <p class="text-gray-500 text-lg">
                <?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?> - <?= date('H:i', strtotime($event['JAM_EVENT'])); ?>
            </p>
            <p class="mt-6 text-base"><?= esc($event['DEKSRIPSI_EVENT']); ?></p>
            <p class="mt-4 text-lg"><strong>Kategori:</strong> <?= esc($event['KATEGORI_KEVENT']); ?></p>
            <a href="<?= site_url('event/index'); ?>" 
               class="mt-6 inline-block bg-blue-500 text-white py-2 px-6 rounded-full hover:bg-blue-600">
               ← Back to home
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
