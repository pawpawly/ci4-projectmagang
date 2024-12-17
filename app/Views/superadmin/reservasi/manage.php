<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<?php helper('month'); ?>


<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Reservasi</h1>
    </div>
    <p class="mb-4 text-gray-800">Daftar semua reservasi di Website Anda</p>

    <!-- Form Pencarian dan Filter -->
    <div class="flex items-center mb-4 space-x-4">
        <form method="get" action="<?= site_url('superadmin/reservasi/manage') ?>" class="flex items-center space-x-4">
        <?= csrf_field(); ?>
            <!-- Input Pencarian -->
                <input type="text" name="search" placeholder="Cari Nama atau Instansi..." autocomplete="off"
                       class="px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"
                       value="<?= esc($search) ?>" id="searchInput" oninput="toggleClearButton()">
                
                <!-- Tombol X untuk menghapus input -->
                <button type="button" id="clearButton" onclick="clearSearch()" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                        style="display: none;">
                    ✕
                </button>
           

            <!-- Filter Status Reservasi -->
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="setuju" <?= $status == 'setuju' ? 'selected' : '' ?>>Setuju</option>
                <option value="tolak" <?= $status == 'tolak' ? 'selected' : '' ?>>Tolak</option>
                <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Pending</option>
            </select>

            <!-- Filter Bulan -->
            <select name="bulan" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Bulan</option>
                <?php 
                for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>>
                        <?= getBulanIndo($i) ?> <!-- Menggunakan helper untuk bulan -->
                    </option>
                <?php endfor; ?>
            </select>


            <!-- Filter Tahun -->
            <select name="tahun" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Tahun</option>
                <?php foreach ($yearsRange as $y): ?>
                    <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endforeach; ?>
            </select>


            <!-- Tombol Cari -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-gray-600">
                <tr>
                    <th class="text-left  text-white py-2 px-4">Nama</th>
                    <th class="text-left  text-white py-2 px-4">Instansi</th>
                    <th class="text-left  text-white py-2 px-4">No Whatsapp</th>
                    <th class="text-left  text-white py-2 px-4">Tanggal Reservasi</th>
                    <th class="text-center  text-white py-2 px-4">Status Reservasi</th>
                    <th class="text-center text-white py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <?php if (!empty($reservasi)): ?>
                    <?php foreach ($reservasi as $item): ?>
                        <tr class="border-b transition duration-75 hover:bg-gray-300">
                            <td class="py-2 px-4"><?= esc($item['NAMA_RESERVASI']); ?></td>
                            <td class="py-2 px-4"><?= esc($item['INSTANSI_RESERVASI']); ?></td>
                            <td class="py-2 px-4">
                                <?= esc(preg_replace('/\D/', '', $item['TELEPON_RESERVASI'])); // Hanya angka ?>
                            </td>
                            <td class="py-2 px-4"><?= formatTanggalIndonesia($item['TANGGAL_RESERVASI']); ?></td>
                            <td class="py-2 px-4 text-center  text-xs font-semibold" >
                                <?php
                                    $status = strtolower($item['STATUS_RESERVASI']);
                                    $statusClass = '';
                                    switch ($status) {
                                        case 'setuju':
                                            $statusClass = 'bg-green-200 text-green-700 text-white';
                                            break;
                                        case 'tolak':
                                            $statusClass = 'bg-red-200 text-red-700 text-white';
                                            break;
                                        case 'pending':
                                        default:
                                            $statusClass = 'bg-yellow-200 text-yellow-700 text-white';
                                            break;
                                    }
                                ?>
                                <span class="px-2 py-1 rounded-md <?= $statusClass; ?>">
                                    <?= ucfirst($status); ?>
                                </span>
                            </td>
                            <td class="py-2 px-4 text-center">
                            <div class="flex justify-center text-center items-center space-x-2">
                                <a href="<?= site_url('superadmin/reservasi/detail/' . $item['ID_RESERVASI']); ?>" 
                                   class="bg-blue-500 text-white inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-blue-700" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                      <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                      <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#" onclick="confirmDelete('<?= $item['ID_RESERVASI'] ?>')" 
                                   class="bg-red-500 text-white inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-red-700" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                      <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                </div>
                            </td>                                
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">Tidak ada data reservasi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
echo view('pagers/admin_pagination', [
    'page' => $page, // Halaman saat ini
    'totalPages' => $totalPages, // Total halaman
    'baseUrl' => site_url('superadmin/reservasi/manage'), // Base URL untuk pagination
    'queryParams' => '&search=' . ($search ?? '') . '&bulan=' . ($bulan ?? '') . '&tahun=' . ($tahun ?? '') // Query string tambahan
]);
?>


</div>

<!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function toggleClearButton() {
    const searchInput = document.getElementById('searchInput');
    const clearButton = document.getElementById('clearButton');
    clearButton.style.display = searchInput.value ? 'inline' : 'none';
}

function clearSearch() {
    document.getElementById('searchInput').value = '';
    toggleClearButton();
    document.getElementById('searchInput').focus();
}

document.addEventListener("DOMContentLoaded", toggleClearButton);

function confirmDelete(id_reservasi) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data ini akan dihapus secara permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteReservation(id_reservasi);
        }
    });
}

function deleteReservation(id_reservasi) {
    fetch(`<?= site_url('superadmin/reservasi/delete/') ?>${id_reservasi}`, {
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
                text: 'Data berhasil dihapus.',
                icon: 'success',
                confirmButtonText: 'OK'
            })
            .then(() => {
                location.reload();
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

<?= $this->endSection() ?>
