<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center">DAFTAR KOLEKSI</h1>
    </div>
</div>

<!-- Filter dan Pencarian -->
<div class="container mx-auto px-8 py-12">
    <div class="flex justify-between items-center mb-6">
        <select id="filterKategori" class="border border-gray-300 p-2 rounded-md">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategori as $kat): ?>
                <option value="<?= esc($kat['ID_KKOLEKSI']); ?>"><?= esc($kat['KATEGORI_KKOLEKSI']); ?></option>
            <?php endforeach; ?>
        </select>

        <form id="searchForm" class="flex space-x-2">
            <input type="text" name="keyword" placeholder="Cari Koleksi..." 
                   class="border border-gray-300 p-2 rounded-md w-64">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Cari
            </button>
        </form>
    </div>

    <!-- Grid Koleksi -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        <?php foreach ($koleksi as $item): ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="<?= base_url('uploads/koleksi/' . $item['FOTO_KOLEKSI']); ?>" 
                     alt="<?= esc($item['NAMA_KOLEKSI']); ?>" 
                     class="w-full h-56 object-cover">
                <div class="p-4">
                    <h2 class="text-lg font-semibold truncate"><?= esc($item['NAMA_KOLEKSI']); ?></h2>
                    <p class="text-sm text-gray-600 truncate">
                        <?= substr($item['DESKRIPSI_KOLEKSI'], 0, 100); ?>...
                    </p>
                    <a href="<?= site_url('koleksi/detail/' . $item['ID_KOLEKSI']); ?>" 
                       class="block mt-2 text-blue-500 hover:underline">Baca Selengkapnya</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        <?= $pager->links(); ?>
    </div>
</div>

<?= $this->endSection() ?>
