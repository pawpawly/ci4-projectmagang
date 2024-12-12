<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center"><?= esc($buku['JUDUL_BUKU']); ?></h1>
    </div>
</div>

<!-- Detail Buku -->
<div class="container mx-auto px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-12">
        <div class="lg:w-1/2">
            <img src="<?= base_url('uploads/bukudigital/sampul/' . $buku['SAMPUL_BUKU']); ?>" 
                 alt="<?= esc($buku['JUDUL_BUKU']); ?>" 
                 class="w-full rounded-lg shadow-lg">
        </div>
        <div class="lg:w-1/2">
            <h1 class="text-4xl font-bold mb-4"><?= esc($buku['JUDUL_BUKU']); ?></h1>
            <p class="text-lg"><strong>Penulis:</strong> <?= esc($buku['PENULIS_BUKU']); ?></p>
            <p class="text-lg"><strong>Tahun Terbit:</strong> <?= esc($buku['TAHUN_BUKU']); ?></p>
            <p class="mt-6 text-justify text-gray-700 leading-relaxed">
                <?= esc($buku['SINOPSIS_BUKU']); ?>
            </p>
            <div class="mt-6 flex gap-4">
                <?php if (!empty($buku['PRODUK_BUKU'])): ?>
                    <a href="<?= base_url('uploads/bukudigital/pdf/' . $buku['PRODUK_BUKU']); ?>" target="_blank" 
                       class="bg-blue-500 text-white px-4 py-2 rounded">
                        View / Download Buku
                    </a>
                <?php else: ?>
                    <span class="text-gray-400 text-xs font-semibold inline-flex items-center justify-center w-48 h-8 rounded-md bg-gray-200">
                        Produk Buku Tidak Tersedia
                    </span>
                <?php endif; ?>
                <a href="<?= site_url('bukudigital'); ?>" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                   Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- E-Book Lainnya -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold mb-8">E-Book Lainnya</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-10">
            <?php foreach ($relatedBooks as $related): ?>
                <div>
                    <img src="<?= base_url('uploads/bukudigital/sampul/' . $related['SAMPUL_BUKU']); ?>" 
                         alt="<?= esc($related['JUDUL_BUKU']); ?>" 
                         class="w-full h-48 object-cover rounded-lg shadow-lg">
                    <h3 class="text-lg font-bold truncate"><?= esc($related['JUDUL_BUKU']); ?></h3>
                    <a href="<?= site_url('bukudigital/detail/' . $related['ID_BUKU']); ?>" 
                       class="text-blue-500 hover:underline mt-2 block">Lihat Selengkapnya</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>