<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Kategori Event</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="categoryForm" method="POST" action="<?= site_url('event/category/save') ?>">
        <div class="mb-4">
            <label for="kategori_kevent" class="block text-sm font-medium text-gray-700">Jenis Acara</label>
            <input type="text" id="kategori_kevent" name="kategori_kevent"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi_kevent" class="block text-sm font-medium text-gray-700">Deskripsi Acara</label>
            <textarea id="deskripsi_kevent" name="deskripsi_kevent" rows="4"
                      class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required></textarea>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('event/category'); ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="button" onclick="confirmAdd()"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah</button>
        </div>
    </form>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmAddModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Tambah Kategori</h2>
        <p>Apakah Anda yakin ingin menambahkan kategori ini?</p>
        <div class="mt-6 flex justify-end space-x-4">
            <button onclick="cancelAdd()"
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</button>
            <button onclick="submitForm()"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Tambah</button>
        </div>
    </div>
</div>

<script>
    function confirmAdd() {
        const modal = document.getElementById('confirmAddModal');
        modal.classList.remove('hidden');
    }

    function cancelAdd() {
        const modal = document.getElementById('confirmAddModal');
        modal.classList.add('hidden');
    }

    function submitForm() {
        document.getElementById('categoryForm').submit();
    }
</script>

<?= $this->endSection() ?>
