<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/waveyellow5.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-40">
        <h1 class="text-5xl font-bold text-gray-800 text-center" style="position: relative; top: -80px;">DAFTAR E-BOOK</h1>
    </div>
</div>

<!-- Filter dan Pencarian -->
<div class="container mx-auto px-8 py-8">
    <div class="flex flex-col md:flex-row justify-center items-center gap-6">
        <form id="searchForm" autocomplete="off" class="flex items-center space-x-4 w-full md:w-1/2">
            <?= csrf_field(); ?>
            <div class="relative w-full">
                <input type="text" name="keyword" placeholder="Cari E-Book..." 
                       class="p-2 w-full border border-gray-400 rounded-md focus:ring-2 focus:ring-yellow-500 focus:outline-none hover:shadow-md transition-shadow duration-200"
                       value="<?= esc($keyword ?? ''); ?>" id="searchInput" oninput="toggleClearButton()">
                <button type="button" id="clearButton" onclick="clearSearch()" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                        style="display: none;">✕</button>
            </div>
            <button type="submit" class="bg-gray-900 text-yellow-500 py-2 px-6 rounded-lg hover:bg-gray-600">
                Cari
            </button>
        </form>
    </div>
</div>

<!-- Grid E-Book -->
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        <?php if (!empty($bukudigital) && count($bukudigital) > 0): ?>
            <?php foreach ($bukudigital as $buku): ?>
                <!-- Kartu E-Book -->
                <div class="bg-gray-100 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-2">
                    <!-- Gambar E-Book dengan Rasio 1:1 -->
                    <div class="w-full h-80 aspect-w-1 aspect-h-1">
                        <img src="<?= base_url('uploads/bukudigital/sampul/' . $buku['SAMPUL_BUKU']); ?>" 
                             alt="<?= esc($buku['JUDUL_BUKU']); ?>" 
                             class="w-full h-full object-cover rounded-t-lg hover:opacity-75 transition duration-200">
                    </div>
                    <!-- Deskripsi E-Book -->
                    <div class="p-3 md:p-4">
                        <h2 class="text-lg font-semibold truncate"><?= esc($buku['JUDUL_BUKU']); ?></h2>
                        <!-- Sinopsis Buku -->
                        <p class="mt-1 text-xs md:text-sm text-gray-500">
                            <?= substr($buku['SINOPSIS_BUKU'], 0, 60); ?>...
                        </p>
                        <a href="<?= site_url('bukudigital/detail/' . $buku['ID_BUKU']); ?>" 
                           class="bg-gray-900 text-yellow-500 font-semibold hover:underline py-2 px-6 rounded-lg hover:bg-gray-600 mt-2 inline-block text-xs">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-600 col-span-full">Buku digital tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-10 flex justify-center">
        <nav aria-label="Pagination" class="inline-flex space-x-1">
            <?= $pager->links('default', 'custom_pagination'); ?>
        </nav>
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
