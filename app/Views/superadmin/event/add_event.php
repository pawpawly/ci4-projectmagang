<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Event</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('event/save') ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
            <input type="text" id="nama_event" name="nama_event" 
                   class="mt-1 px-4 py-2 w-full border rounded-md" value="<?= old('nama_event') ?>" required>
        </div>

        <div class="mb-4">
            <label for="kategori_acara" class="block text-sm font-medium text-gray-700">Kategori Acara</label>
            <select id="kategori_acara" name="kategori_acara" 
                    class="mt-1 px-4 py-2 w-full border rounded-md" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['ID_KEVENT'] ?>">
                        <?= esc($category['KATEGORI_KEVENT']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal_event" class="block text-sm font-medium text-gray-700">Tanggal Event</label>
            <input type="date" id="tanggal_event" name="tanggal_event" 
                   class="mt-1 px-4 py-2 w-full border rounded-md" value="<?= old('tanggal_event') ?>" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi Acara</label>
            <textarea id="deskripsi_event" name="deskripsi_event" rows="4" 
                      class="mt-1 px-4 py-2 w-full border rounded-md" required><?= old('deskripsi_event') ?></textarea>
        </div>

        <div class="mb-4">
            <label for="poster_event" class="block text-sm font-medium text-gray-700">Poster Acara</label>
            <input type="file" id="poster_event" name="poster_event" 
                   class="mt-1 px-4 py-2 w-full border rounded-md" accept=".jpg,.jpeg,.png" required>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('event/manage'); ?>" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
            <button type="submit" 
                    class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Simpan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
