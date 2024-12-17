<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar dan Nama Event -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/waveyellow5.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-40">
        <h1 class="text-4xl font-bold text-gray-800 text-center" style="position: relative; top: -80px;"><?= esc($event['NAMA_EVENT']); ?></h1>
        <p class="text-xl text-gray-800 font-semibold text-center mt-4" style="position: relative; top: -80px;">Detail Event</p>
    </div>
</div>

<!-- Detail Event -->
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Gambar Event -->
        <div class="lg:w-1/2">
            <a href="<?= base_url('uploads/poster/' . (!empty($event['FOTO_EVENT']) ? $event['FOTO_EVENT'] : 'default.png')); ?>" 
               target="_blank" 
               rel="noopener noreferrer">
                <img 
                    src="<?= base_url('uploads/poster/' . (!empty($event['FOTO_EVENT']) ? $event['FOTO_EVENT'] : 'default.png')); ?>" 
                    alt="<?= esc($event['NAMA_EVENT']); ?>" 
                    class="w-full rounded-lg shadow-lg">
            </a>
        </div>

        <!-- Informasi Event -->
        <div class="lg:w-1/2">
            <h1 class="text-2xl font-semibold mb-4"><?= esc($event['NAMA_EVENT']); ?></h1>
            <!-- Tanggal dan Jam -->
            <p class="text-gray-500 text-lg font-semibold">
                <?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?> - <?= date('H:i', strtotime($event['JAM_EVENT'])); ?> WITA
            </p>
            <!-- Kategori -->
            <p class="mt-1 text-base font-semibold text-gray-800">
                <strong class="font-semibold">Kategori: </strong>
                <span class="inline-block px-2 py-1 bg-yellow-200 text-yellow-700 font-semibold rounded-lg text-sm uppercase">
                    <?= esc($event['KATEGORI_KEVENT'] ?? 'Kategori tidak tersedia'); ?>
                </span>
            </p>
            <!-- Judul Deskripsi -->
            <h2 class="mt-1 text-base font-semibold text-gray-800">Deskripsi:</h2>
            <!-- Deskripsi dengan Paragraf -->
            <div class=" text-gray-800 leading-relaxed text-justify">
                <?= nl2br(esc($event['DEKSRIPSI_EVENT'])); ?>
            </div>
            <!-- Tombol Kembali -->
            <a href="<?= site_url('event/index'); ?>" 
               class="mt-6 inline-block bg-gray-900 font-semibold text-yellow-500 py-2 px-6 rounded-lg shadow-lg hover:bg-gray-600">
               ← Kembali
            </a>
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

<style>
    #scrollTopButton {
        transition: opacity 0.3s ease-in-out;
    }

    .opacity-0 {
        opacity: 0;
    }

    .opacity-100 {
        opacity: 1;
    }

    .justify-text {
        text-align: justify;
    }
</style>

<?= $this->endSection() ?>
