<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Berita</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="editBeritaForm" action="<?= site_url('superadmin/berita/update') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_berita" value="<?= $berita['ID_BERITA'] ?>">

        <div class="mb-4">
            <label for="nama_berita" class="block text-sm font-medium text-gray-700">Nama Berita</label>
            <input type="text" id="nama_berita" name="nama_berita" 
                   value="<?= esc($berita['NAMA_BERITA']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi_berita" class="block text-sm font-medium text-gray-700">Deskripsi Berita</label>
            <textarea id="deskripsi_berita" name="deskripsi_berita" rows="4" 
                      class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= esc($berita['DESKRIPSI_BERITA']) ?></textarea>
        </div>

        <div class="mb-4">
            <label for="sumber_berita" class="block text-sm font-medium text-gray-700">Sumber Berita</label>
            <input type="text" id="sumber_berita" name="sumber_berita" 
                   value="<?= esc($berita['SUMBER_BERITA']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="foto_berita" class="block text-sm font-medium text-gray-700">Foto Berita</label>
            <input type="file" id="foto_berita" name="foto_berita" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" accept=".jpg,.jpeg,.png">
            <?php if ($berita['FOTO_BERITA']): ?>
                <img src="<?= base_url('uploads/berita/' . $berita['FOTO_BERITA']) ?>" 
                     alt="Foto Berita" class="w-16 h-24 mt-2 object-cover rounded-md">
            <?php endif; ?>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/berita/manage') ?>" 
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
