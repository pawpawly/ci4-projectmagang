<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/waveyellow5.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-40">
        <h1 class="text-5xl font-bold text-gray-800 text-center" style="position: relative; top: -80px;">FORUM</h1>
    </div>
</div>

<div class="container mx-auto px-8 py-12 max-w-7xl">
    <?php if (!empty($berita) && is_array($berita)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($berita as $item): ?>
                <div class="forum-card group"> <!-- Tambahkan group untuk hover parent -->
                    <div class="forum-image-wrapper overflow-hidden rounded-lg transition-transform duration-300 ease-in-out">
                    <a href="<?= site_url('berita/' . $item['ID_BERITA']); ?>">
                            <img src="<?= base_url('uploads/berita/' . $item['FOTO_BERITA']); ?>"
                                 alt="<?= esc($item['NAMA_BERITA']); ?>"
                                 class="w-full h-48 object-cover transition-transform hover:opacity-75 transition duration-200 group-hover:scale-110">
                        </a>
                    </div>
                    <p class="text-gray-600 mt-2"><?= formatTanggalIndonesia($item['TANGGAL_BERITA']); ?></p>
                    <h3 class="forum-title mt-1 text-lg font-semibold">
                        <a href="<?= site_url('berita/' . urlencode($item['ID_BERITA'])); ?>" 
                           class="text-black transition duration-300 ease-in-out group-hover:text-yellow-500 hover:underline">
                            <?= esc($item['NAMA_BERITA']); ?>
                        </a>
                    </h3>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            <?= $pager->links('default', 'custom_pagination'); ?>
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
