<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Kategori Event</h1>
    <a href="<?= site_url('event/category/add') ?>" 
       class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
        Tambah Kategori
    </a>
</div>

<p class="mb-6 text-gray-600">Daftar semua kategori event di website Anda.</p>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-left py-2 px-4">Jenis Acara</th>
                <th class="text-left py-2 px-4">Deskripsi Acara</th>
                <th class="text-right py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            <?php foreach ($categories as $category): ?>
            <tr class="border-b">
                <td class="py-2 px-4"><?= esc($category['KATEGORI_KEVENT']); ?></td>
                <td class="py-2 px-4"><?= esc($category['DESKRIPSI_KEVENT']); ?></td>
                <td class="py-2 px-4 text-right">
                    <a href="<?= site_url('event/category/edit/' . $category['ID_KEVENT']) ?>" 
                       class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mr-2">
                        Edit
                    </a>
                    <button onclick="confirmDelete('<?= $category['ID_KEVENT'] ?>')" 
                            class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Delete
                    </button>
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
        <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
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

<script>
    function showNotification(message) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.classList.remove('hidden');

        setTimeout(() => {
            notification.classList.add('hidden');
        }, 3000);
    }

    function confirmDelete(id_kevent) {
        const modal = document.getElementById('deleteModal');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.href = "<?= site_url('event/category/delete/') ?>" + id_kevent;
        modal.classList.remove('hidden');
    }

    function cancelDelete() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }

    <?php if (session()->getFlashdata('message')): ?>
        showNotification('<?= session()->getFlashdata('message'); ?>');
    <?php elseif (session()->getFlashdata('error')): ?>
        showNotification('<?= session()->getFlashdata('error'); ?>');
    <?php endif; ?>
</script>

<?= $this->endSection() ?>
