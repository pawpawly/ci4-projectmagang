<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-3xl font-bold text-white text-center"><?= esc($berita['NAMA_BERITA']); ?></h1>
    </div>
</div>

<div class="container mx-auto px-8 py-12 max-w-6xl">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <!-- Bagian Kiri: Detail Berita -->
        <div class="md:col-span-2">
            <a href="<?= base_url('uploads/berita/' . $berita['FOTO_BERITA']); ?>" target="_blank">
                <img src="<?= base_url('uploads/berita/' . $berita['FOTO_BERITA']); ?>" 
                     alt="<?= esc($berita['NAMA_BERITA']); ?>" 
                     class="w-full rounded-lg mb-6">
            </a>
            <h1 class="text-3xl font-bold mb-2"><?= esc($berita['NAMA_BERITA']); ?></h1>
            <p class="text-gray-600"><?= formatTanggalIndonesia($berita['TANGGAL_BERITA']); ?> | Sumber: <?= esc($berita['SUMBER_BERITA']); ?></p>
            <div class="mt-4 text-lg text-gray-800">
                <?= esc($berita['DESKRIPSI_BERITA']); ?>
            </div>
        </div>

        <!-- Bagian Kanan: Latest Post -->
        <div>
            <h2 class="text-2xl font-bold mb-6">Latest Post</h2>
            <?php if (!empty($latestPosts) && is_array($latestPosts)): ?>
                <ul class="space-y-4">
                    <?php foreach ($latestPosts as $post): ?>
                        <li class="flex gap-4 items-center">
                            <a href="<?= site_url('berita/' . urlencode($post['NAMA_BERITA'])); ?>" class="block">
                                <img src="<?= base_url('uploads/berita/' . $post['FOTO_BERITA']); ?>" 
                                     alt="<?= esc($post['NAMA_BERITA']); ?>" 
                                     class="w-20 h-20 object-cover rounded-md">
                            </a>
                            <div class="flex-1">
                                <a href="<?= site_url('berita/' . urlencode($post['NAMA_BERITA'])); ?>" 
                                   class="text-lg font-semibold hover:text-red-400 transition duration-300 ease-in-out line-clamp-2">
                                    <?= esc($post['NAMA_BERITA']); ?>
                                </a>
                                <p class="text-sm text-gray-600"><?= formatTanggalIndonesia($post['TANGGAL_BERITA']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-500">Tidak ada berita terbaru.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk mengatur posisi scroll ke atas saat halaman di-refresh
    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    };
    
</script>
<?= $this->endSection() ?>
