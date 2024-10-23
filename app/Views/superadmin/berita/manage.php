<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Berita</h1>
        <a href="<?= site_url('superadmin/berita/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Berita
        </a>
    </div>

    <p class="mb-4 text-gray-800">Daftar semua berita di Website Anda</p>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-yellow-400">
                <tr>
                    <th class="text-left py-2 px-4">Foto Berita</th>
                    <th class="text-left py-2 px-4">Nama Berita</th>
                    <th class="text-left py-2 px-4">Sumber Berita</th>
                    <th class="text-left py-2 px-4">Tanggal Berita</th>
                    <th class="text-left py-2 px-4">Penyiar</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <?php if (!empty($berita) && is_array($berita)): ?>
                    <?php foreach ($berita as $item): ?>
                        <tr class="border-b transition duration-200">
                            <td class="py-2 px-4">
                                <img src="<?= base_url('uploads/berita/' . $item['FOTO_BERITA']); ?>" 
                                     alt="Foto Berita" class="w-16 h-24 object-cover rounded-md shadow-sm">
                            </td>
                            <td class="py-2 px-4"><?= esc($item['NAMA_BERITA']); ?></td>
                            <td class="py-2 px-4"><?= esc($item['SUMBER_BERITA']); ?></td>
                            <td class="py-2 px-4"><?= date('d F Y', strtotime($item['TANGGAL_BERITA'])); ?></td>
                            <td class="py-2 px-4">
    <?= esc($item['PENYIAR_BERITA'] ?? 'Pengguna tidak diketahui'); ?>
</td>

                            <td class="py-2 px-4 text-right">
                                <div class="flex justify-end items-center space-x-4">
                                    <a href="<?= site_url('superadmin/berita/edit/' . $item['ID_BERITA']) ?>" 
                                       class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">
                                       Edit
                                    </a>
                                    <button onclick="confirmDelete('<?= $item['ID_BERITA'] ?>')" 
                                            class="text-red-500 font-semibold hover:underline hover:text-red-700">
                                        Delete
                                    </button>
                                </div>
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
        const modal = document.getElementById('deleteModal');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.href = "<?= site_url('superadmin/berita/delete/') ?>" + id_berita;
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

<style>
    tbody tr:hover {
        background-color: #FFEBB5; /* Warna latar saat hover */
    }

    tbody tr:hover td {
        transition: background-color 0.2s ease-in-out;
    }
</style>

<?= $this->endSection() ?>
