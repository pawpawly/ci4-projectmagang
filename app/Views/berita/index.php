<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center">FORUM</h1>
    </div>
</div>

<div class="container mx-auto px-8 py-12 max-w-7xl">
    <?php if (!empty($berita) && is_array($berita)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($berita as $item): ?>
                <div class="forum-card group"> <!-- Tambahkan group untuk hover parent -->
                    <div class="forum-image-wrapper overflow-hidden rounded-lg transition-transform duration-300 ease-in-out">
                        <a href="<?= site_url('berita/' . urlencode($item['NAMA_BERITA'])); ?>">
                            <img src="<?= base_url('uploads/berita/' . $item['FOTO_BERITA']); ?>"
                                 alt="<?= esc($item['NAMA_BERITA']); ?>"
                                 class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                        </a>
                    </div>
                    <p class="text-gray-600 mt-2"><?= formatTanggalIndonesia($item['TANGGAL_BERITA']); ?></p>
                    <h3 class="forum-title mt-1 text-lg font-semibold">
                        <a href="<?= site_url('berita/' . urlencode($item['NAMA_BERITA'])); ?>" 
                           class="text-black transition duration-300 ease-in-out group-hover:text-red-400">
                            <?= esc($item['NAMA_BERITA']); ?>
                        </a>
                    </h3>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500">Tidak ada berita yang ditemukan.</p>
    <?php endif; ?>
</div>

<script>
    // Fungsi untuk mengatur posisi scroll ke atas saat halaman di-refresh
    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    };
    
</script>
<?= $this->endSection() ?>
