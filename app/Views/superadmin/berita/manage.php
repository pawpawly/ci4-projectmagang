<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Berita</h1>
        <a href="<?= site_url('berita/add') ?>" 
           class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
            Tambah Berita
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left py-2 px-4">Foto Berita</th>
                    <th class="text-left py-2 px-4">Nama Berita</th>
                    <th class="text-left py-2 px-4">Sumber Berita</th>
                    <th class="text-left py-2 px-4">Tanggal Berita</th>
                    <th class="text-left py-2 px-4">Penyiar</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if (!empty($berita) && is_array($berita)): ?>
                    <?php foreach ($berita as $item): ?>
                        <tr class="border-b">
                            <td class="py-2 px-4">
                                <img src="<?= base_url('uploads/berita/' . $item['FOTO_BERITA']); ?>" 
                                     alt="Foto Berita" class="w-16 h-24 object-cover rounded-md">
                            </td>
                            <td class="py-2 px-4"><?= esc($item['NAMA_BERITA']); ?></td>
                            <td class="py-2 px-4"><?= esc($item['SUMBER_BERITA']); ?></td>
                            <td class="py-2 px-4"><?= formatTanggalIndonesia($item['TANGGAL_BERITA']); ?></td>
                            <td class="py-2 px-4"><?= esc($item['NAMA_USER']); ?></td>
                            <td class="py-2 px-4 text-right">                                <a href="<?= site_url('berita/edit/' . $item['ID_BERITA']) ?>" 
                                   class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mr-2">
                                   Edit
                                </a>

                                <button onclick="confirmDelete('<?= $item['ID_BERITA'] ?>')" 
                                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Tidak ada berita yang ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Penghapusan</h2>
        <p>Apakah Anda yakin ingin menghapus berita ini?</p>
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
    
    function confirmDelete(id_berita) {
    if (id_berita <= 0) {
        alert("ID berita tidak valid!");
        return;
    }
    const modal = document.getElementById('deleteModal');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    confirmBtn.href = "<?= site_url('berita/delete/') ?>" + id_berita;
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
