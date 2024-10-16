<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Kategori Event</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="categoryForm" method="POST" action="<?= site_url('event/category/update') ?>">
        <input type="hidden" name="id_kevent" value="<?= esc($category['ID_KEVENT']); ?>">

        <div class="mb-4">
            <label for="kategori_kevent" class="block text-sm font-medium text-gray-700">Jenis Acara</label>
            <input type="text" id="kategori_kevent" name="kategori_kevent"
                   value="<?= esc($category['KATEGORI_KEVENT']); ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi_kevent" class="block text-sm font-medium text-gray-700">Deskripsi Acara</label>
            <textarea id="deskripsi_kevent" name="deskripsi_kevent" rows="4"
                      class="mt-1 px-4 py-2 w-full border rounded-md" required><?= esc($category['DESKRIPSI_KEVENT']); ?></textarea>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('event/category'); ?>"
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
            <button type="button" onclick="confirmEdit()"
                    class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Update</button>
        </div>
    </form>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmEditModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Update Kategori</h2>
        <p>Apakah Anda yakin ingin memperbarui kategori ini?</p>
        <div class="mt-6 flex justify-end space-x-4">
            <button onclick="cancelEdit()"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</button>
            <button onclick="submitForm()"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Update</button>
        </div>
    </div>
</div>

<script>
    function confirmEdit() {
        const modal = document.getElementById('confirmEditModal');
        modal.classList.remove('hidden');
    }

    function cancelEdit() {
        const modal = document.getElementById('confirmEditModal');
        modal.classList.add('hidden');
    }

    function submitForm() {
        document.getElementById('categoryForm').submit();
    }
</script>

<?= $this->endSection() ?>
