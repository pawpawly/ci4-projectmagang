<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Event</h1>
        <a href="<?= site_url('event/add') ?>" 
           class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
            Tambah Acara
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left py-2 px-4">Poster Acara</th>
                    <th class="text-left py-2 px-4">Nama Acara</th>
                    <th class="text-left py-2 px-4">Kategori Acara</th>
                    <th class="text-left py-2 px-4">Tanggal Acara</th>
                    <th class="text-left py-2 px-4">Deskripsi Acara</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php foreach ($events as $event): ?>
                <tr class="border-b">
                    <td class="py-2 px-4">
                        <img src="<?= base_url('uploads/poster/' . $event['FOTO_EVENT']); ?>" 
                             alt="Poster Acara" class="w-16 h-24 object-cover rounded-md">
                    </td>
                    <td class="py-2 px-4"><?= esc($event['NAMA_EVENT']); ?></td>
                    <td class="py-2 px-4"><?= esc($event['NAMA_KATEGORI']); ?></td>
                    <td class="py-2 px-4"><?= date('d M Y', strtotime($event['TANGGAL_EVENT'])); ?></td>
                    <td class="py-2 px-4"><?= esc($event['DEKSRIPSI_EVENT']); ?></td>
                    <td class="py-2 px-4 text-right">
                        <a href="<?= site_url('event/edit/' . $event['ID_EVENT']) ?>" 
                           class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mr-2">
                           Edit
                        </a>
                        <button onclick="confirmDelete('<?= $event['ID_EVENT'] ?>')" 
                                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                            Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Penghapusan</h2>
        <p>Apakah Anda yakin ingin menghapus event ini?</p>
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
    function confirmDelete(id_event) {
        const modal = document.getElementById('deleteModal');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.href = "<?= site_url('event/delete/') ?>" + id_event;
        modal.classList.remove('hidden');
    }

    function cancelDelete() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }

    <?php if (session()->getFlashdata('message')): ?>
    const notification = document.getElementById('notification');
    notification.textContent = '<?= session()->getFlashdata('message'); ?>';
    notification.classList.remove('hidden');
    setTimeout(() => {
        notification.classList.add('hidden');
    }, 3000);
    <?php endif; ?>
</script>

<?= $this->endSection() ?>
