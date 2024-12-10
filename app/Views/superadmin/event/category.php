<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kategori Event</h1>
        <a href="<?= site_url('superadmin/event/category/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Kategori
        </a>
    </div>

    <p class="mb-4 text-gray-800">Daftar semua kategori event di website Anda.</p>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-yellow-400">
                <tr>
                    <th class="text-left py-2 px-4">Jenis Acara</th>
                    <th class="text-left py-2 px-4">Deskripsi Acara</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <?php foreach ($categories as $category): ?>
                <tr class="border-b">
                    <td class="py-2 px-4">
                        <?= esc($category['KATEGORI_KEVENT']); ?>
                    </td>
                    <td class="py-2 px-4">
                        <?= esc($category['DESKRIPSI_KEVENT']); ?>
                    </td>
                    <td class="py-2 px-4 text-right">
                        <div class="flex justify-end items-center space-x-4">
                            <a href="<?= site_url('superadmin/event/category/edit/' . $category['ID_KEVENT']) ?>" 
                               class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">
                               Edit
                            </a>
                            <button onclick="confirmDelete('<?= $category['ID_KEVENT'] ?>')" 
                                    class="text-red-500 font-semibold hover:underline hover:text-red-700">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
echo view('pagers/admin_pagination', [
    'page' => $page, // Halaman saat ini
    'totalPages' => $totalPages, // Total halaman
    'baseUrl' => site_url('superadmin/event/category'), // Base URL untuk pagination
    'queryParams' => '&search=' . ($search ?? '') // Query string tambahan untuk pencarian
]);
?>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id_kevent) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak bisa mengembalikan data ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteCategory(id_kevent);
            }
        });
    }

    function deleteCategory(id_kevent) {
        fetch(`<?= site_url('superadmin/event/category/delete/') ?>${id_kevent}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire(
                    'Terhapus!',
                    data.message,
                    'success'
                ).then(() => {
                    location.reload(); // Refresh halaman setelah berhasil
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
            Swal.fire(
                'Error!',
                'Terjadi kesalahan pada server.',
                'error'
            );
            console.error('Error:', error);
        });
    }
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
