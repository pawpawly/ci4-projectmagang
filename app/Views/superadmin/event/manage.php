<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '<?= session()->getFlashdata('error'); ?>',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
<?php elseif (session()->getFlashdata('message')): ?>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('message'); ?>',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>

<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Event</h1>
        <a href="<?= site_url('superadmin/event/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Acara
        </a>
    </div>
    <p class="mb-4 text-gray-800">Daftar semua event di Website Anda</p>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-yellow-400">
                <tr>
                    <th class="text-left py-2 px-4">Poster Acara</th>
                    <th class="text-left py-2 px-4">Nama Acara</th>
                    <th class="text-left py-2 px-4">Kategori Acara</th>
                    <th class="text-left py-2 px-4">Tanggal Acara</th>
                    <th class="text-left py-2 px-4">Jam Mulai</th>
                    <th class="text-left py-2 px-4">Deskripsi Acara</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <?php foreach ($events as $event): ?>
                <tr class="border-b transition duration-200">
                    <td class="py-2 px-4">
                        <img src="<?= base_url('uploads/poster/' . $event['FOTO_EVENT']); ?>" 
                             alt="Poster Acara" class="w-16 h-24 object-cover rounded-md shadow-sm">
                    </td>
                    <td class="py-2 px-4"><?= esc($event['NAMA_EVENT']); ?></td>
                    <td class="py-2 px-4"><?= esc($event['NAMA_KATEGORI']); ?></td>
                    <td class="py-2 px-4"><?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?></td>
                    <td class="py-2 px-4"><?= date('H:i', strtotime($event['JAM_EVENT'])) ?></td>
                    <td class="py-2 px-4"><?= esc($event['DEKSRIPSI_EVENT']); ?></td>
                    <td class="py-2 px-4 text-right">
                        <div class="flex justify-end items-center space-x-4">
                            <a href="<?= site_url('superadmin/event/edit/' . $event['ID_EVENT']) ?>" 
                               class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">
                               Edit
                            </a>
                            <button onclick="confirmDelete('<?= $event['ID_EVENT'] ?>')" 
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
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function confirmDelete(id_event) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Event ini akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`<?= site_url('superadmin/event/delete/') ?>${id_event}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Terhapus!', data.message, 'success')
                            .then(() => location.reload()); // Reload halaman jika berhasil
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
                    console.error('Error:', error);
                });
            }
        });
    }
</script>


<style>
    tbody tr:hover {
        background-color: #FFEBB5; /* Warna abu-abu muda saat hover */
    }

    tbody tr:hover td {
        transition: background-color 0.2s ease-in-out;
    }
</style>

<?= $this->endSection() ?>
