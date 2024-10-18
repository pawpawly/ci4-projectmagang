<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center">EVENT</h1>
    </div>
</div>


<div class="container mx-auto px-8 py-12">
    <h1 class="text-4xl font-bold mb-6"><?= esc($title) ?></h1>

    <?php if (!empty($events) && is_array($events)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($events as $event): ?>
                <div class="border rounded-lg shadow-lg overflow-hidden">
                    <img 
                        src="<?= base_url('uploads/poster/' . (!empty($event['FOTO_EVENT']) ? $event['FOTO_EVENT'] : 'default.png')); ?>" 
                        alt="<?= esc($event['NAMA_EVENT']); ?>" 
                        class="object-cover w-full aspect-[2/3]">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold"><?= esc($event['NAMA_EVENT']); ?></h2>
                        <p class="text-gray-500">
                            <?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?> - <?= date('H:i', strtotime($event['JAM_EVENT'])); ?> WITA
                        </p>
                        <p class="mt-2 text-sm"><?= esc($event['DEKSRIPSI_EVENT']); ?></p>
                        <p class="mt-4 text-sm"><strong>Kategori:</strong> <?= esc($event['KATEGORI_KEVENT']); ?></p>
                        <a href="<?= site_url('event/' . urlencode($event['NAMA_EVENT'])); ?>" class="block mt-4 text-blue-500">Read More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500">Tidak ada event yang tersedia saat ini.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
