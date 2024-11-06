<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Buku Digital</h1>
        <a href="<?= site_url('superadmin/bukudigital/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Buku Digital
        </a>
    </div>

    <p class="mb-4 text-gray-800">Daftar semua buku digital di koleksi Anda</p>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-yellow-400">
                <tr>
                    <th class="text-left py-2 px-4">Sampul Buku</th>
                    <th class="text-left py-2 px-4">Judul Buku</th>
                    <th class="text-left py-2 px-4">Penulis Buku</th>
                    <th class="text-left py-2 px-4">Produk Buku</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <?php if (!empty($bukudigital) && is_array($bukudigital)): ?>
                    <?php foreach ($bukudigital as $item): ?>
                        <tr class="border-b transition duration-200">
                        <td class="py-2 px-4">
                        <?php if (!empty($item['SAMPUL_BUKU']) && file_exists(FCPATH . 'uploads/bukudigital/sampul/' . $item['SAMPUL_BUKU'])): ?>
                            <img src="<?= base_url('uploads/bukudigital/sampul/' . $item['SAMPUL_BUKU']); ?>" 
                                alt="Sampul Buku" class="w-24 h-36 object-cover rounded-md shadow-sm">
                        <?php else: ?>
                            <span class="text-gray-500">Sampul Tidak Tersedia</span>
                        <?php endif; ?>
                    </td>

                            <td class="py-2 px-4"><?= esc($item['JUDUL_BUKU']); ?></td>
                            <td class="py-2 px-4"><?= esc($item['PENULIS_BUKU']); ?></td>
                            <td class="py-2 px-4">
                                <?php if (!empty($item['PRODUK_BUKU'])): ?>
                                    <a href="<?= site_url('superadmin/bukudigital/view/' . $item['ID_BUKU']); ?>" 
                                       class="text-blue-500 font-semibold hover:underline hover:text-blue-700">
                                        Lihat Detail
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-500">Tidak Tersedia</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-2 px-4 text-right">
                                <div class="flex justify-end items-center space-x-4">
                                    <a href="<?= site_url('superadmin/bukudigital/edit/' . $item['ID_BUKU']) ?>" 
                                       class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">
                                       Edit
                                    </a>
                                    <button onclick="confirmDelete('<?= $item['ID_BUKU'] ?>')" 
                                            class="text-red-500 font-semibold hover:underline hover:text-red-700">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">
                            Tidak ada buku digital yang ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id_buku) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan dapat mengembalikan data ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteBuku(id_buku);
        }
    });
}

function deleteBuku(id_buku) {
    fetch(`<?= site_url('superadmin/bukudigital/delete/') ?>${id_buku}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
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
        Swal.fire(
            'Error!',
            'Terjadi kesalahan saat menghapus buku.',
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