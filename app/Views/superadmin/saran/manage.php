<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<?php helper('month'); ?>

<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Saran Pengunjung</h1>
    </div>
    <p class="mb-4 text-gray-800">Daftar semua saran yang diterima dari pengunjung</p>

 <!-- Form Pencarian dan Filter -->
 <div class="flex items-center mb-4 space-x-4">
        <form method="get" action="<?= site_url('superadmin/saran/manage') ?>" class="flex items-center space-x-4">
        <?= csrf_field(); ?>
            <!-- Input Pencarian -->
            <div class="relative">
                <input type="text" name="search" placeholder="Cari Nama Pengirim..." autocomplete="off"
                       class="px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       value="<?= esc($search) ?>" id="searchInput" oninput="toggleClearButton()">
                
                <!-- Tombol X untuk menghapus input -->
                <button type="button" id="clearButton" onclick="clearSearch()" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                        style="display: none;">
                    ✕
                </button>
            </div>

            <!-- Filter Bulan -->
            <select name="bulan" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Bulan</option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>><?= getBulanIndo($i) ?></option>
                <?php endfor; ?>
            </select>
                
            <!-- Filter Tahun -->
            <select name="tahun" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
    <option value="">Semua Tahun</option>
    <?php foreach ($yearsRange as $year): ?>
        <option value="<?= $year ?>" <?= $tahun == $year ? 'selected' : '' ?>>
            <?= $year ?>
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
                    <th class="text-left py-2 px-4">Nama Pengirim</th>
                    <th class="text-left py-2 px-4">Email</th>
                    <th class="text-left py-2 px-4">Tanggal</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <?php if (!empty($saranList)): ?>
                    <?php foreach ($saranList as $saran): ?>
                        <tr class="border-b">
                            <td class="py-2 px-4"><?= esc($saran['NAMA_SARAN']); ?></td>
                            <td class="py-2 px-4"><?= esc($saran['EMAIL_SARAN']); ?></td>
                            <td class="py-2 px-4">
                                <?= formatTanggalIndonesia($saran['TANGGAL_SARAN']) . ' ' . date('H:i:s', strtotime($saran['TANGGAL_SARAN'])) . ' WITA'; ?>
                            </td>
                            <td class="py-2 px-4 text-right">
                                <a href="#" onclick="showDetail(<?= htmlspecialchars(json_encode($saran), ENT_QUOTES, 'UTF-8') ?>)" 
                                class="text-green-500 font-semibold hover:underline hover:text-green-700">Lihat Saran</a>
                                <a href="#" onclick="confirmDelete('<?= $saran['ID_SARAN'] ?>')" 
                                class="text-red-500 font-semibold hover:underline hover:text-red-700">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4">Tidak ada data saran</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php
echo view('pagers/admin_pagination', [
    'page' => $page, // Halaman saat ini
    'totalPages' => $totalPages, // Total halaman
    'baseUrl' => site_url('superadmin/saran/manage'), // Base URL untuk pagination
    'queryParams' => '&search=' . ($search ?? '') . '&tipe_tamu=' . ($tipeTamu ?? '') . '&bulan=' . ($bulan ?? '') . '&tahun=' . ($tahun ?? '') // Query string tambahan
]);
?>
</div>

<!-- Modal Detail Saran -->
<div id="detailModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Detail Saran</h2>
        <p><strong>Nama Pengirim:</strong> <span id="detailNama"></span></p>
        <p><strong>Email:</strong> <span id="detailEmail"></span></p>
        <p><strong>Tanggal:</strong> <span id="detailTanggal"></span></p>
        <p><strong>Isi Saran:</strong> <span id="detailSaran"></span></p>
        <div class="mt-6 flex justify-end space-x-4">
            <button onclick="closeDetail()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Tutup</button>
        </div>
    </div>
</div>

<!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    // Toggle Clear Button (X) for Search Input
    function toggleClearButton() {
        const searchInput = document.getElementById('searchInput');
        const clearButton = document.getElementById('clearButton');
        clearButton.style.display = searchInput.value ? 'inline' : 'none';
    }

    // Clear Search Input
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        toggleClearButton();
        document.getElementById('searchInput').focus(); // Focus back to search input
    }

    // Call toggleClearButton on page load to set initial state
    document.addEventListener("DOMContentLoaded", toggleClearButton);

    let currentSaranId;

    function showDetail(saran) {
        currentSaranId = saran.ID_SARAN;
        document.getElementById('detailNama').textContent = saran.NAMA_SARAN;
        document.getElementById('detailEmail').textContent = saran.EMAIL_SARAN;

        // Format TANGGAL_SARAN untuk modal
        const date = new Date(saran.TANGGAL_SARAN);
        const formattedDate = new Intl.DateTimeFormat('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            timeZone: 'Asia/Makassar'
        }).format(date) + ' WITA';

        document.getElementById('detailTanggal').textContent = formattedDate;
        document.getElementById('detailSaran').textContent = saran.KOMENTAR_SARAN;

        const modal = document.getElementById('detailModal');
        modal.classList.remove('hidden');
    }

    function closeDetail() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
    }

    function confirmDelete(id_saran) {
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
                deleteSaran(id_saran);
            }
        });
    }

    function deleteSaran(id_saran) {
        fetch(`<?= site_url('superadmin/saran/delete/') ?>${id_saran}`, {
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
