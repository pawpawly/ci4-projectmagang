<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Detail Buku Digital</h1>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Sampul Buku:</h2>
        <img src="<?= base_url('uploads/bukudigital/sampul/' . $book['SAMPUL_BUKU']); ?>" 
             alt="Sampul Buku" class="w-48 h-72 object-cover rounded-md shadow-md">
    </div>
    
    <div class="mb-4">
        <h2 class="text-lg font-semibold">Judul Buku:</h2>
        <p><?= esc($book['JUDUL_BUKU']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Penulis Buku:</h2>
        <p><?= esc($book['PENULIS_BUKU']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Tahun Terbit:</h2>
        <p><?= esc($book['TAHUN_BUKU']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Sinopsis:</h2>
        <p><?= esc($book['SINOPSIS_BUKU']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">File Buku (PDF):</h2>
        <a href="<?= base_url('uploads/bukudigital/pdf/' . $book['PRODUK_BUKU']); ?>" target="_blank" 
           class="text-blue-500 font-semibold hover:underline">
            View / Download PDF
        </a>
    </div>

    <div class="mt-6">
        <a href="<?= site_url('superadmin/bukudigital/manage'); ?>" 
           class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            Kembali
        </a>
    </div>
</div>
<?= $this->endSection() ?>
