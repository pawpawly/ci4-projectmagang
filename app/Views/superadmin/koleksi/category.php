<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php elseif (session()->getFlashdata('message')): ?>
    <div class="bg-green-500 text-white p-4 rounded mb-4">
        <?= session()->getFlashdata('message'); ?>
    </div>
<?php endif; ?>

<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kategori Koleksi</h1>
        <a href="<?= site_url('superadmin/koleksi/category/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Kategori
        </a>
    </div>

    <p class="mb-4 text-gray-800">Daftar semua kategori koleksi di website Anda.</p>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-yellow-400">
                <tr>
                    <th class="text-left py-2 px-4">Kategori Koleksi</th>
                    <th class="text-left py-2 px-4">Deskripsi Koleksi</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <?php foreach ($categories as $category): ?>
                <tr class="border-b">
                    <td class="py-2 px-4">
                        <?= esc($category['KATEGORI_KKOLEKSI']); ?>
                    </td>
                    <td class="py-2 px-4">
                        <?= esc($category['DESKRIPSI_KKOLEKSI']); ?>
                    </td>
                    <td class="py-2 px-4 text-right">
                        <div class="flex justify-end items-center space-x-4">
                            <a href="<?= site_url('superadmin/koleksi/category/edit/' . $category['ID_KKOLEKSI']) ?>" 
                               class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">
                               Edit
                            </a>
                            <a href="#" onclick="confirmDelete('<?= $category['ID_KKOLEKSI'] ?>')" 
                               class="text-red-500 font-semibold hover:underline hover:text-red-700">
                               Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-4">Konfirmasi Penghapusan</h2>
            <p>Apakah Anda yakin ingin menghapus kategori koleksi ini?</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="cancelDelete()" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</button>
                <a id="confirmDeleteBtn" href="#" 
                   class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus</a>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div id="notification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-md"></div>
</div>

<script>
    function showNotification(message) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.classList.remove('hidden');

        setTimeout(() => {
            notification.classList.add('hidden');
        }, 3000);
    }

    function confirmDelete(id_kkoleksi) {
        const modal = document.getElementById('deleteModal');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.href = "<?= site_url('superadmin/koleksi/category/delete/') ?>" + id_kkoleksi;
        modal.classList.remove('hidden');
    }

    function cancelDelete() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }
</script>

<style>
    tbody tr:hover {
        background-color: #FFEBB5;
    }

    tbody tr:hover td {
        transition: background-color 0.2s ease-in-out;
    }
</style>

<?= $this->endSection() ?>
