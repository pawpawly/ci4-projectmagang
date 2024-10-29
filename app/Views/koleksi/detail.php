<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center"><?= esc($koleksi['NAMA_KOLEKSI']); ?></h1>
    </div>
</div>

<!-- Detail Koleksi -->
<div class="container mx-auto px-8 py-12">
    <div class="flex flex-col lg:flex-row items-start gap-8">
        <!-- Gambar Koleksi -->
        <div class="w-full lg:w-1/2">
            <img src="<?= base_url('uploads/koleksi/' . $koleksi['FOTO_KOLEKSI']); ?>" 
                 alt="<?= esc($koleksi['NAMA_KOLEKSI']); ?>" 
                 class="w-full h-auto object-cover rounded-md shadow-md">
        </div>

        <!-- Informasi Koleksi -->
        <div class="w-full lg:w-1/2">
            <h1 class="text-4xl font-bold mb-4"><?= esc($koleksi['NAMA_KOLEKSI']); ?></h1>
            <p class="text-lg">
                <strong>Kategori:</strong> <?= esc($koleksi['KATEGORI_KKOLEKSI'] ?? 'Kategori tidak tersedia'); ?>
            </p>
            <p class="mt-4 text-base text-justify"><?= esc($koleksi['DESKRIPSI_KOLEKSI']); ?></p>
        </div>
    </div>

    <!-- Koleksi Terkait -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Koleksi Terkait</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <?php foreach ($relatedKoleksi as $item): ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="<?= base_url('uploads/koleksi/' . $item['FOTO_KOLEKSI']); ?>" 
                         alt="<?= esc($item['NAMA_KOLEKSI']); ?>" 
                         class="w-full h-56 object-cover">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold truncate"><?= esc($item['NAMA_KOLEKSI']); ?></h2>
                        <a href="<?= site_url('koleksi/detail/' . $item['ID_KOLEKSI']); ?>" 
                           class="block mt-2 text-blue-500 hover:underline">Lihat Detail</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
