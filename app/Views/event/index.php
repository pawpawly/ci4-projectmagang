<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<!-- Header dengan Latar Gambar -->
<div class="relative pb-1 bg-gray-200" 
     style="background-image: url('<?= base_url('pict/waveyellow5.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-40">
        <h1 class="text-5xl font-bold text-gray-800 text-center" style="position: relative; top: -80px;">DAFTAR EVENT</h1>
    </div>
</div>

<div class="container mx-auto px-8 bg-gray-200 py-12 max-w-5xl"> <!-- Menambah max-width agar tidak full screen -->

    <?php if (!empty($events) && is_array($events)): ?>
        <div class="space-y-8 bg-gray-200"> <!-- Memberi jarak vertikal antar event -->
            <?php foreach ($events as $event): ?>
                <div class="flex flex-col md:flex-row items-center border border-gray-900 rounded-lg shadow-lg overflow-hidden bg-gray-100">
                    <!-- Bagian Poster -->
                    <div class="w-full md:w-1/3 bg-gray-100" 
                         style="background-image: url('<?= base_url('pict/dotted-pattern.png'); ?>'); background-size: cover;">
                        <img 
                            src="<?= base_url('uploads/poster/' . (!empty($event['FOTO_EVENT']) ? $event['FOTO_EVENT'] : 'default.png')); ?>" 
                            alt="<?= esc($event['NAMA_EVENT']); ?>" 
                            class="object-contain w-full h-[250px]">
                    </div>

                    <!-- Bagian Konten -->
                    <div class="w-full md:w-2/3 p-6">
                        <h2 class="text-2xl font-semibold truncate"><?= esc($event['NAMA_EVENT']); ?></h2>
                        <p class="text-gray-500 font-semibold text-sm mt-1">
                            <?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?> - <?= date('H:i', strtotime($event['JAM_EVENT'])); ?> WITA
                        </p>
                        <p class="mt-2 text-sm text-gray-600 truncate"><?= esc($event['DEKSRIPSI_EVENT']); ?></p>

                        <div class="mt-4">
                            <span class="inline-block px-2 py-1 bg-yellow-200 text-yellow-700 font-semibold rounded-lg text-xs uppercase">
                                <?= esc($event['KATEGORI_KEVENT']); ?>
                            </span>
                        </div>

                        <div class="mt-4 flex justify-start"> <!-- Mengatur posisi tombol -->
                        <a href="<?= site_url('event/' . $event['ID_EVENT']); ?>"
                               class="bg-gray-900 text-yellow-500 py-2 px-6 rounded-lg hover:bg-gray-600">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-700">Tidak ada event yang tersedia saat ini.</p>
    <?php endif; ?>
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

</style>

<?= $this->endSection() ?>
