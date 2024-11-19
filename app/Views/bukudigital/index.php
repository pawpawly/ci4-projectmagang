<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center">DAFTAR E-BOOK</h1>
    </div>
</div>

<!-- Filter dan Pencarian -->
<div class="container mx-auto px-8 py-8">
    <div class="flex flex-col md:flex-row justify-center items-center gap-6">
        <form id="searchForm" autocomplete="off" class="flex items-center space-x-4 w-full md:w-1/2">
            <div class="relative w-full">
                <input type="text" name="keyword" placeholder="Cari E-Book..." 
                       class="border border-gray-300 p-3 rounded-lg w-full shadow-md focus:outline-none"
                       value="<?= esc($keyword ?? ''); ?>" id="searchInput" oninput="toggleClearButton()">
                <button type="button" id="clearButton" onclick="clearSearch()" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                        style="display: none;">✕</button>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-5 py-3 rounded-lg shadow-md hover:bg-blue-700">Cari</button>
        </form>
    </div>
</div>

<!-- Grid E-Book -->
<div class="container mx-auto px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <?php foreach ($bukudigital as $buku): ?>
            <div>
                <img src="<?= base_url('uploads/bukudigital/sampul/' . $buku['SAMPUL_BUKU']); ?>" 
                     alt="<?= esc($buku['JUDUL_BUKU']); ?>" 
                     class="w-full h-56 object-cover rounded-lg shadow-lg">
                <h2 class="text-lg font-bold mt-4 truncate"><?= esc($buku['JUDUL_BUKU']); ?></h2>
                <a href="<?= site_url('bukudigital/detail/' . $buku['ID_BUKU']); ?>" 
                   class="text-blue-500 hover:underline mt-2 block">Lihat Selengkapnya</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function toggleClearButton() {
        const searchInput = document.getElementById('searchInput');
        const clearButton = document.getElementById('clearButton');
        clearButton.style.display = searchInput.value ? 'inline' : 'none';
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        toggleClearButton();
        document.getElementById('searchInput').focus();
    }

    document.addEventListener("DOMContentLoaded", toggleClearButton);
</script>

<?= $this->endSection() ?>
