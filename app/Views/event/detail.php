<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar dan Nama Event -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center"><?= esc($event['NAMA_EVENT']); ?></h1>
        <p class="text-xl text-white text-center mt-4">Detail Event</p>
    </div>
</div>

<!-- Konten Utama dengan Layout Gambar Kiri dan Keterangan Kanan -->
<div class="container mx-auto px-8 py-12">
    <div class="flex flex-col lg:flex-row items-start gap-8">
        <!-- Gambar Event -->
        <div class="w-full lg:w-1/2">
            <img 
                src="<?= base_url('uploads/poster/' . (!empty($event['FOTO_EVENT']) ? $event['FOTO_EVENT'] : 'default.png')); ?>" 
                alt="<?= esc($event['NAMA_EVENT']); ?>" 
                class="object-contain w-full max-h-[500px] bg-gray-100 p-2 rounded-lg">
        </div>

        <!-- Detail Event -->
        <div class="w-full lg:w-1/2">
            <h1 class="text-4xl font-bold mb-4"><?= esc($event['NAMA_EVENT']); ?></h1>
            <p class="text-gray-500 text-lg">
                <?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?> - <?= date('H:i', strtotime($event['JAM_EVENT'])); ?>
            </p>
            <p class="mt-6 text-base justify-text"><?= esc($event['DEKSRIPSI_EVENT']); ?></p>
            <p class="mt-4 text-lg"><strong>Kategori:</strong> <?= esc($event['KATEGORI_KEVENT']); ?></p>
            <a href="<?= site_url('event/index'); ?>" 
               class="mt-6 inline-block bg-red-900 text-white py-2 px-6 rounded-full hover:bg-red-700">
               ← Kembali
            </a>
        </div>
    </div>
</div>

<!-- Tombol Scroll to Top -->
<button id="scrollTopButton" 
    class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-yellow-500 shadow-lg 
    flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2C1011]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
