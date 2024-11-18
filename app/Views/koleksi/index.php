<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center">DAFTAR KOLEKSI</h1>
    </div>
</div>

<!-- Filter dan Pencarian (Posisi di Tengah Atas) -->
<div class="container mx-auto px-8 py-8">
    <div class="flex flex-col md:flex-row justify-center items-center gap-6">
        <form id="searchForm" autocomplete="off" class="flex items-center space-x-4 w-full md:w-1/2">
            <!-- Input Pencarian dengan Tombol X di dalamnya -->
            <div class="relative w-full">
                <input type="text" name="keyword" placeholder="Cari Koleksi..." 
                       class="border border-gray-300 p-3 rounded-lg w-full shadow-md focus:outline-none"
                       value="<?= esc($keyword ?? ''); ?>" id="searchInput" oninput="toggleClearButton()">
                <!-- Tombol X untuk menghapus input -->
                <button type="button" id="clearButton" onclick="clearSearch()" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                        style="display: none;">
                    ✕
                </button>
            </div>
            <button type="submit" 
                    class="bg-blue-600 text-white px-5 py-3 rounded-lg shadow-md hover:bg-blue-700">
                Cari
            </button>
        </form>

        <select id="filterKategori" class="border border-gray-300 p-3 rounded-lg shadow-md w-full md:w-1/3"
                onchange="location = this.value;">
            <option value="<?= site_url('koleksi'); ?>">Semua Kategori</option>
            <?php foreach ($kategori as $kat): ?>
                <option value="<?= site_url('koleksi?kategori=' . $kat['ID_KKOLEKSI']); ?>" 
                        <?= (isset($selectedKategori) && $selectedKategori == $kat['ID_KKOLEKSI']) ? 'selected' : ''; ?>>
                    <?= esc($kat['KATEGORI_KKOLEKSI']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- Grid Koleksi -->
<div class="container mx-auto px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <?php if (count($koleksi) > 0): ?>
            <?php foreach ($koleksi as $item): ?>
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-2">
                    <img src="<?= base_url('uploads/koleksi/' . $item['FOTO_KOLEKSI']); ?>" 
                         alt="<?= esc($item['NAMA_KOLEKSI']); ?>" 
                         class="w-full h-56 object-cover rounded-t-lg">
                    <div class="p-5">
                        <h2 class="text-xl font-bold truncate"><?= esc($item['NAMA_KOLEKSI']); ?></h2>
                        <p class="mt-2 text-sm text-gray-500">
                            <?= substr($item['DESKRIPSI_KOLEKSI'], 0, 80); ?>...
                        </p>
                        <a href="<?= site_url('koleksi/detail/' . $item['ID_KOLEKSI']); ?>" 
                           class="text-blue-500 hover:underline mt-4 block">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-600">Koleksi tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-10 flex justify-center">
        <nav aria-label="Pagination" class="inline-flex space-x-1">
            <?= $pager->links('default', 'custom_pagination'); ?>
        </nav>
    </div>
</div>

<script>
    // Tampilkan atau sembunyikan tombol X
    function toggleClearButton() {
        const searchInput = document.getElementById('searchInput');
        const clearButton = document.getElementById('clearButton');
        clearButton.style.display = searchInput.value ? 'inline' : 'none';
    }

    // Kosongkan input pencarian saat tombol X diklik
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        toggleClearButton();
        document.getElementById('searchInput').focus(); // Fokus kembali ke input pencarian
    }

    // Panggil toggleClearButton saat halaman dimuat, untuk memeriksa jika ada nilai default
    document.addEventListener("DOMContentLoaded", toggleClearButton);
</script>

<?= $this->endSection() ?>
