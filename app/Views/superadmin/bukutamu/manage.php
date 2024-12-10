<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<?php helper('month'); ?>

<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Buku Tamu</h1>
        <a href="<?= site_url('superadmin/bukutamu/form') ?>" 
           class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
           Form Buku Tamu
        </a>
    </div>

    <div class="bg-white min-h-screen">
        <div class="flex justify-between items-center mb-4">
        </div>
        <p class="mb-4 text-gray-800">Daftar semua tamu yang berkunjung ke museum</p>
        <div class="flex items-center justify-between mb-6">
            <form method="get" action="<?= site_url('superadmin/bukutamu/manage') ?>" class="flex items-center space-x-4 relative">
                <!-- Input Pencarian -->
                <div class="relative">
                    <input type="text" name="search" placeholder="Cari Nama Tamu..." autocomplete="off" 
                    class="px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    value="<?= esc($search) ?>" id="searchInput" oninput="toggleClearButton()">
                <!-- Tombol X untuk menghapus input -->
                <button type="button" id="clearButton" onclick="clearSearch()" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                        style="display: none;">
                    ✕
                </button>
            </div>

                <!-- Filter Tipe Tamu -->
                <select name="tipe_tamu" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
                    <option value="">Semua Tipe Tamu</option>
                    <option value="1" <?= $tipeTamu === '1' ? 'selected' : '' ?>>Individual</option>
                    <option value="2" <?= $tipeTamu === '2' ? 'selected' : '' ?>>Instansi</option>
                </select>

                <!-- Filter Bulan -->
                <select name="bulan" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
                    <option value="">Semua Bulan</option>
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= $bulan == $m ? 'selected' : '' ?>>
                            <?= getBulanIndo($m) ?> <!-- Menggunakan fungsi helper untuk bulan -->
                        </option>
                    <?php endfor; ?>
                </select>

<!-- Filter Tahun -->
<select name="tahun" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
    <option value="">Semua Tahun</option>
    <?php foreach ($uniqueYears as $y): ?>
        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>>
            <?= $y ?>
        </option>
    <?php endforeach; ?>
</select>


                <!-- Tombol Cari -->
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-yellow-400">
                    <tr>
                        <th class="text-left py-2 px-4">Tipe Tamu</th>
                        <th class="text-left py-2 px-4">Nama Tamu / Instansi</th>
                        <th class="text-left py-2 px-4">Tanggal Kunjungan</th>
                        <th class="text-left py-2 px-4">Jumlah Tamu</th>
                        <th class="text-right py-2 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    <?php if (!empty($bukutamu)): ?>
                        <?php foreach ($bukutamu as $tamu): ?>
                            <tr class="border-b">
                                <td class="py-2 px-4">
                                    <?= $tamu['TIPE_TAMU'] == '1' ? 'Individual' : 'Instansi'; ?>
                                </td>
                                <td class="py-2 px-4"><?= esc($tamu['NAMA_TAMU']); ?></td>
                                <td class="py-2 px-4">
                                    <?= formatTanggalIndonesia($tamu['TGLKUNJUNGAN_TAMU']) . ' ' . date('H:i:s', strtotime($tamu['TGLKUNJUNGAN_TAMU'])) . ' WITA'; ?>
                                </td>
                                <td class="py-2 px-4">
                                    <?= esc($tamu['JKL_TAMU'] + $tamu['JKP_TAMU']); ?> Orang
                                </td>
                                <td class="py-2 px-4 text-right">
    <a href="<?= site_url('superadmin/bukutamu/detailGuestBook/' . $tamu['ID_TAMU']) ?>"
       class="text-green-500 font-semibold hover:underline hover:text-green-700">Detail</a>
    <a href="#" 
       onclick="confirmDelete('<?= $tamu['ID_TAMU'] ?>')" 
       class="text-red-500 font-semibold hover:underline hover:text-red-700">Delete</a>
</td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada data buku tamu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Panggil Komponen Pagination -->
<?php
echo view('pagers/admin_pagination', [
    'page' => $page, // Halaman saat ini
    'totalPages' => $totalPages, // Total halaman
    'baseUrl' => site_url('superadmin/bukutamu/manage'), // Base URL untuk pagination
    'queryParams' => '&search=' . ($search ?? '') . '&tipe_tamu=' . ($tipeTamu ?? '') . '&bulan=' . ($bulan ?? '') . '&tahun=' . ($tahun ?? '') // Query string tambahan
]);
?>
    </div>
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

    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };

    function confirmDelete(id_tamu) {
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
                deleteTamu(id_tamu);
            }
        });
    }

    function deleteTamu(id_tamu) {
        fetch(`<?= site_url('superadmin/bukutamu/delete/') ?>${id_tamu}`, {
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
                }).then(() => {
                    location.reload(); // Refresh halaman setelah sukses
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
