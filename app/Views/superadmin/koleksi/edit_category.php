<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Kategori Koleksi</h1>

    <?php if (session()->getFlashdata('validation')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                <?php foreach (session()->getFlashdata('validation')->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('superadmin/koleksi/category/update') ?>" method="POST">
        <input type="hidden" name="id_kkoleksi" value="<?= $category['ID_KKOLEKSI'] ?>">

        <div class="mb-4">
            <label for="kategori_kkoleksi" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            <input type="text" id="kategori_kkoleksi" name="kategori_kkoleksi"
                   value="<?= old('kategori_kkoleksi', $category['KATEGORI_KKOLEKSI']) ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   required>
        </div>

        <div class="mb-4">
            <label for="deskripsi_kkoleksi" class="block text-sm font-medium text-gray-700">Deskripsi Kategori</label>
            <textarea id="deskripsi_kkoleksi" name="deskripsi_kkoleksi" rows="4"
                      class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                      required><?= old('deskripsi_kkoleksi', $category['DESKRIPSI_KKOLEKSI']) ?></textarea>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/koleksi/category') ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
