<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

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
                    <td class="py-2 px-4"><?= esc($category['KATEGORI_KKOLEKSI']); ?></td>
                    <td class="py-2 px-4"><?= esc($category['DESKRIPSI_KKOLEKSI']); ?></td>
                    <td class="py-2 px-4 text-right">
                        <div class="flex justify-end items-center space-x-4">
                            <a href="<?= site_url('superadmin/koleksi/category/edit/' . $category['ID_KKOLEKSI']) ?>" 
                               class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">Edit</a>
                            <a href="#" onclick="confirmDelete('<?= $category['ID_KKOLEKSI'] ?>')" 
                               class="text-red-500 font-semibold hover:underline hover:text-red-700">Delete</a>
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
    function confirmDelete(id_kkoleksi) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteKategoriKoleksi(id_kkoleksi);
            }
        });
    }

    function deleteKategoriKoleksi(id_kkoleksi) {
        fetch(`<?= site_url('superadmin/koleksi/category/delete/') ?>${id_kkoleksi}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload(); // Refresh halaman setelah penghapusan berhasil
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            console.error('Error:', error);
        });
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
