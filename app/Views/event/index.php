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
                <div class="border border-[#2C1011] rounded-lg shadow-lg overflow-hidden bg-white">
                    <div class="relative bg-gray-100" style="background-image: url('<?= base_url('pict/dotted-pattern.png'); ?>'); background-size: cover;">
                        <img 
                            src="<?= base_url('uploads/poster/' . (!empty($event['FOTO_EVENT']) ? $event['FOTO_EVENT'] : 'default.png')); ?>" 
                            alt="<?= esc($event['NAMA_EVENT']); ?>" 
                            class="object-contain w-full h-[250px]">
                    </div>
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold truncate"><?= esc($event['NAMA_EVENT']); ?></h2>
                        <p class="text-gray-500">
                            <?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?> - <?= date('H:i', strtotime($event['JAM_EVENT'])); ?> WITA
                        </p>
                        <p class="mt-2 text-sm truncate"><?= esc($event['DEKSRIPSI_EVENT']); ?></p>
                        <div class="mt-4">
                            <span class="inline-block px-2 py-1 bg-red-400 text-white font-semibold rounded text-sm">
                                <?= esc($event['KATEGORI_KEVENT']); ?>
                            </span>
                        </div>
                        <a href="<?= site_url('event/' . urlencode($event['NAMA_EVENT'])); ?>" 
                        class="block mt-4 text-center bg-red-900 text-white py-2 px-6 rounded-full hover:bg-red-700">
                        Read More
                    </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500">Tidak ada event yang tersedia saat ini.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
