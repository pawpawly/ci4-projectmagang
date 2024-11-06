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
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Gambar Koleksi -->
        <div class="lg:w-1/2">
            <img src="<?= base_url('uploads/koleksi/' . $koleksi['FOTO_KOLEKSI']); ?>" 
                 alt="<?= esc($koleksi['NAMA_KOLEKSI']); ?>" 
                 class="w-full rounded-lg shadow-lg">
        </div>

        <!-- Informasi Koleksi -->
        <div class="lg:w-1/2">
            <h1 class="text-4xl font-extrabold mb-4"><?= esc($koleksi['NAMA_KOLEKSI']); ?></h1>
            <p class="text-xl font-semibold">
                <strong>Kategori:</strong> <?= esc($koleksi['KATEGORI_KKOLEKSI'] ?? 'Kategori tidak tersedia'); ?>
            </p>
            <p class="mt-6 text-justify text-gray-700 leading-relaxed">
                <?= esc($koleksi['DESKRIPSI_KOLEKSI']); ?>
            </p>
        </div>
    </div>

    <!-- Koleksi Terkait -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold mb-8">Koleksi Terkait</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-10">
            <?php foreach ($relatedKoleksi as $item): ?>
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-2">
                    <img src="<?= base_url('uploads/koleksi/' . $item['FOTO_KOLEKSI']); ?>" 
                         alt="<?= esc($item['NAMA_KOLEKSI']); ?>" 
                         class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="text-lg font-bold truncate"><?= esc($item['NAMA_KOLEKSI']); ?></h3>
                        <a href="<?= site_url('koleksi/detail/' . $item['ID_KOLEKSI']); ?>" 
                           class="text-blue-500 hover:underline mt-2 block">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
