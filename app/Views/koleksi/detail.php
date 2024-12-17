<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/waveyellow5.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-40">
        <h1 class="text-3xl font-bold text-black text-center" style="position: relative; top: -80px;">
            <?= esc($koleksi['NAMA_KOLEKSI']); ?>
        </h1>
    </div>
</div>

<!-- Detail Koleksi -->
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Gambar Koleksi -->
        <div class="lg:w-1/2">
            <img src="<?= base_url('uploads/koleksi/' . $koleksi['FOTO_KOLEKSI']); ?>" 
                 alt="<?= esc($koleksi['NAMA_KOLEKSI']); ?>" 
                 class="w-full rounded-lg shadow-lg">
        </div>

    <!-- Informasi Koleksi -->
    <div class="lg:w-1/2">
        <h1 class="text-2xl font-semibold mb-4"><?= esc($koleksi['NAMA_KOLEKSI']); ?></h1>
        <!-- Kategori -->
        <p class="text-base font-semibold text-gray-800"><strong class="font-semibold">Kategori:  </strong>
        <span class="inline-block px-2 py-1 bg-yellow-200 text-yellow-700 font-semibold rounded-lg text-sm uppercase"><?= esc($koleksi['KATEGORI_KKOLEKSI'] ?? 'Kategori tidak tersedia'); ?></span></p>
        <!-- Tambahan Judul Deskripsi -->
        <h2 class=" text-base font-semibold text-gray-800">Deskripsi:</h2>
        <!-- Deskripsi dengan Paragraf -->
        <div class="mt-2 text-gray-800 leading-relaxed text-justify">
            <?= nl2br(esc($koleksi['DESKRIPSI_KOLEKSI'])); ?>
        </div>
        <a href="<?= site_url('koleksi'); ?>" 
               class="mt-6 inline-block bg-gray-900 font-semibold text-yellow-500 py-2 px-6 rounded-lg shadow-lg hover:bg-gray-600">
               ← Kembali
            </a>
    </div>
</div>

    <!-- Koleksi Terkait -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold mb-8">Koleksi Terkait</h2>
        <!-- Grid Koleksi Terkait (Sesuai Desain koleksi/index.php) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            <?php foreach ($relatedKoleksi as $item): ?>
                <!-- Kartu Koleksi Terkait -->
                <div class="bg-gray-100 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-2">
                    <!-- Gambar Koleksi -->
                    <div class="w-full h-60 aspect-w-1 aspect-h-1">
                        <img src="<?= base_url('uploads/koleksi/' . $item['FOTO_KOLEKSI']); ?>" 
                             alt="<?= esc($item['NAMA_KOLEKSI']); ?>" 
                             class="w-full h-full object-cover rounded-t-lg hover:opacity-75 transition duration-200">
                    </div>
                    <!-- Deskripsi Koleksi -->
                    <div class="p-3 md:p-4">
                        <h3 class="text-lg font-semibold truncate"><?= esc($item['NAMA_KOLEKSI']); ?></h3>
                        <span class="inline-block px-2 py-1 bg-yellow-200 text-yellow-700 font-semibold rounded-lg text-xs uppercase">
                                <?= esc($item['KATEGORI_KKOLEKSI']); ?>
                            </span>
                        <p class="mt-1 text-xs md:text-sm text-gray-500">
                            <?= substr($item['DESKRIPSI_KOLEKSI'], 0, 60); ?>...
                        </p>
                        <a href="<?= site_url('koleksi/detail/' . $item['ID_KOLEKSI']); ?>" 
                           class="bg-gray-900 text-yellow-500 font-semibold hover:underline py-2 px-6 rounded-lg hover:bg-gray-600 mt-2 inline-block text-xs">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
