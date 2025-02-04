<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/waveyellow5.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-40">
        <h1 class="text-5xl font-bold text-gray-800 text-center" style="position: relative; top: -80px;">DAFTAR KOLEKSI</h1>
    </div>
</div>

<!-- Filter dan Pencarian (Posisi di Tengah Atas) -->
<div class="container mx-auto px-8 py-8">
    <div class="flex flex-col md:flex-row justify-center items-center gap-6">
        <form id="searchForm" autocomplete="off" class="flex items-center space-x-4 w-full md:w-1/2">
        <?= csrf_field(); ?>
            <!-- Input Pencarian dengan Tombol X di dalamnya -->
            <div class="relative w-full">
                <input type="text" name="keyword" placeholder="Cari Koleksi..." 
                       class="p-2 w-full border border-gray-400 rounded-md focus:ring-2 focus:ring-yellow-500 focus:outline-none hover:shadow-md transition-shadow duration-200"
                       value="<?= esc($keyword ?? ''); ?>" id="searchInput" oninput="toggleClearButton()">
                <!-- Tombol X untuk menghapus input -->
                <button type="button" id="clearButton" onclick="clearSearch()" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                        style="display: none;">
                    ✕
                </button>
            </div>
            <button type="submit" 
                    class="bg-gray-900 text-yellow-500 py-2 px-6 rounded-lg hover:bg-gray-600">
                Cari
            </button>
        </form>

        <select id="filterKategori" class="p-2 w-full md:w-1/3 border border-gray-400 rounded-md focus:ring-2 focus:ring-yellow-500 focus:outline-none hover:shadow-md transition-shadow duration-200"
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
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Grid dengan 5 Kolom untuk Layar Besar -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        <?php if (count($koleksi) > 0): ?>
            <?php foreach ($koleksi as $item): ?>
                <!-- Kartu Koleksi -->
                <div class="bg-gray-100 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-2">
                    <!-- Gambar Koleksi dengan Rasio 1:1 -->
                    <div class="w-full h-60 aspect-w-1 aspect-h-1">
                        <img src="<?= base_url('uploads/koleksi/' . $item['FOTO_KOLEKSI']); ?>" 
                             alt="<?= esc($item['NAMA_KOLEKSI']); ?>" 
                             class="w-full h-full object-cover rounded-t-lg hover:opacity-75 transition duration-100">
                    </div>
                    <!-- Deskripsi Koleksi -->
                    <div class="p-3 md:p-4">
                        <h2 class="text-lg font-semibold truncate"><?= esc($item['NAMA_KOLEKSI']); ?></h2>
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
        <?php else: ?>
            <p class="text-center text-gray-600 col-span-full">Koleksi tidak ditemukan.</p>
        <?php endif; ?>
    </div>
        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
        <nav aria-label="Pagination" class="inline-flex space-x-1">
        <?= $pager->links('default', 'custom_pagination'); ?>
        </nav>
    </div>
</div>
</div>

<!-- Tombol Scroll to Top -->
<button id="scrollTopButton" 
    class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-yellow-500 shadow-lg 
    flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>

<script>
    // Scroll ke atas ketika tombol diklik
document.getElementById('scrollTopButton').addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Pantau scroll dan tampilkan/hilangkan tombol
window.addEventListener('scroll', () => {
    const scrollTopButton = document.getElementById('scrollTopButton');
    if (window.scrollY > 100) { // Jika scroll lebih dari 100px
        scrollTopButton.classList.add('opacity-100');
        scrollTopButton.classList.remove('opacity-0', 'pointer-events-none');
    } else {
        scrollTopButton.classList.remove('opacity-100');
        scrollTopButton.classList.add('opacity-0', 'pointer-events-none');
    }
});
    // Scroll ke bagian atas saat halaman dimuat atau di-refresh
    window.onbeforeunload = function () {
      window.scrollTo(0, 0);
    };

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
