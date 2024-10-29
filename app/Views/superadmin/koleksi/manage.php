<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Koleksi</h1>
        <a href="<?= site_url('superadmin/koleksi/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Koleksi
        </a>
    </div>
    <p class="mb-4 text-gray-800">Daftar semua koleksi di Website Anda</p>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-yellow-400">
                <tr>
                    <th class="text-left py-2 px-4">Foto Koleksi</th>
                    <th class="text-left py-2 px-4">Nama Koleksi</th>
                    <th class="text-left py-2 px-4">Kategori Koleksi</th>
                    <th class="text-left py-2 px-4">Deskripsi Koleksi</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <?php foreach ($koleksi as $item): ?>
                <tr class="border-b">
                    <td class="py-2 px-4">
                        <img src="<?= base_url('uploads/koleksi/' . $item['FOTO_KOLEKSI']); ?>" 
                             alt="Foto Koleksi" class="w-24 h-24 object-cover rounded-md">
                    </td>
                    <td class="py-2 px-4"><?= esc($item['NAMA_KOLEKSI']); ?></td>
                    <td class="py-2 px-4"><?= esc($item['NAMA_KATEGORI']); ?></td>
                    <td class="py-2 px-4">
                        <?= !empty($item['DESKRIPSI_KOLEKSI']) ? esc($item['DESKRIPSI_KOLEKSI']) : 'Deskripsi Tidak Tersedia'; ?>
                    </td>
                    <td class="py-2 px-4 text-right">
                        <div class="flex justify-end items-center space-x-4">
                            <a href="<?= site_url('superadmin/koleksi/edit/' . $item['ID_KOLEKSI']) ?>" 
                               class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">Edit</a>
                            <button onclick="confirmDelete('<?= $item['ID_KOLEKSI'] ?>')" 
                               class="text-red-500 font-semibold hover:underline hover:text-red-700">Delete</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id_koleksi) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Koleksi ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("<?= site_url('superadmin/koleksi/delete/') ?>" + id_koleksi, {
                    method: 'DELETE',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Terhapus!',
                            data.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            data.message,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan pada server.',
                        'error'
                    );
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>
