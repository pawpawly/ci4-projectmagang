<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Event</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="eventForm" action="<?= site_url('event/save') ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
            <input type="text" id="nama_event" name="nama_event" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   value="<?= old('nama_event') ?>" required>
        </div>

        <div class="mb-4">
            <label for="kategori_acara" class="block text-sm font-medium text-gray-700">Kategori Acara</label>
            <select id="kategori_acara" name="kategori_acara" 
                    class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
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
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   value="<?= old('tanggal_event') ?>" required>
        </div>

        <div class="mb-4">
            <label for="jam_event" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
            <input type="time" id="jam_event" name="jam_event" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   value="<?= old('jam_event') ?>" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi Acara</label>
            <textarea id="deskripsi_event" name="deskripsi_event" rows="4" 
                      class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required><?= old('deskripsi_event') ?></textarea>
        </div>

        <div class="mb-4">
            <label for="poster_event" class="block text-sm font-medium text-gray-700">Poster Acara</label>
            <input type="file" id="poster_event" name="poster_event" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   accept=".jpg,.jpeg,.png" required>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('event/manage'); ?>" 
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="button" onclick="confirmAdd()" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmAddModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Tambah Event</h2>
        <p>Apakah Anda yakin ingin menambahkan event ini?</p>
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
        document.getElementById('eventForm').submit();
    }
</script>

<?= $this->endSection() ?>
