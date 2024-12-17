<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/waveyellow5.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-40">
        <h1 class="text-4xl font-bold text-gray-800 text-center" style="position: relative; top: -80px;">
            <?= esc($buku['JUDUL_BUKU']); ?>
        </h1>
    </div>
</div>

<!-- Detail Buku -->
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Gambar Buku -->
        <div class="lg:w-1/2">
            <img src="<?= base_url('uploads/bukudigital/sampul/' . $buku['SAMPUL_BUKU']); ?>" 
                 alt="<?= esc($buku['JUDUL_BUKU']); ?>" 
                 class="w-full rounded-lg shadow-lg">
        </div>

        <!-- Informasi Buku -->
        <div class="lg:w-1/2">
            <h1 class="text-2xl font-semibold mb-4"><?= esc($buku['JUDUL_BUKU']); ?></h1>
            <p class="text-base font-semibold text-gray-800">
                <strong class="font-semibold">Penulis:</strong> <?= esc($buku['PENULIS_BUKU']); ?>
            </p>
            <p class="mt-2 text-base font-semibold text-gray-800">
                <strong class="font-semibold">Tahun Terbit:</strong> <?= esc($buku['TAHUN_BUKU']); ?>
            </p>
            <!-- Judul Deskripsi -->
            <h2 class="mt-2 text-base font-semibold text-gray-800">Sinopsis:</h2>
            <!-- Deskripsi dengan Paragraf -->
            <div class="mt-2 text-gray-800 leading-relaxed text-justify">
                <?= nl2br(esc($buku['SINOPSIS_BUKU'])); ?>
            </div>
            <!-- Tombol Aksi -->
            <div class="mt-6 flex gap-4">
                <?php if (!empty($buku['PRODUK_BUKU'])): ?>
                    <a href="<?= base_url('uploads/bukudigital/pdf/' . $buku['PRODUK_BUKU']); ?>" target="_blank" 
                       class="bg-yellow-500 text-gray-900 font-semibold py-2 px-6 rounded-lg shadow-lg hover:bg-yellow-600">
                        View / Download Buku
                    </a>
                <?php else: ?>
                    <span class="text-gray-400 text-sm font-semibold inline-flex items-center justify-center w-48 h-10 rounded-md bg-gray-200">
                        Produk Buku Tidak Tersedia
                    </span>
                <?php endif; ?>
                <a href="<?= site_url('bukudigital'); ?>" 
                   class="bg-gray-900 font-semibold text-yellow-500 py-2 px-6 rounded-lg shadow-lg hover:bg-gray-600">
                   ← Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- E-Book Lainnya -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold mb-8">E-Book Lainnya</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            <?php foreach ($relatedBooks as $related): ?>
                <div class="bg-gray-100 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:-translate-y-2">
                    <!-- Gambar E-Book -->
                    <div class="w-full h-60 aspect-w-1 aspect-h-1">
                        <img src="<?= base_url('uploads/bukudigital/sampul/' . $related['SAMPUL_BUKU']); ?>" 
                             alt="<?= esc($related['JUDUL_BUKU']); ?>" 
                             class="w-full h-full object-cover rounded-t-lg hover:opacity-75 transition duration-200">
                    </div>
                    <!-- Deskripsi E-Book -->
                    <div class="p-3 md:p-4">
                        <h3 class="text-lg font-semibold truncate"><?= esc($related['JUDUL_BUKU']); ?></h3>
                        <p class="mt-1 text-xs md:text-sm text-gray-500">
                            <?= substr($related['SINOPSIS_BUKU'], 0, 60); ?>...
                        </p>
                        <a href="<?= site_url('bukudigital/detail/' . $related['ID_BUKU']); ?>" 
                           class="bg-gray-900 text-yellow-500 font-semibold hover:underline py-2 px-6 rounded-lg hover:bg-gray-600 mt-2 inline-block text-xs">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
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
</script>

<?= $this->endSection() ?>
