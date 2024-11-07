<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

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
           class="px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"
           id="searchInput">
    
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
                    <?= date('F', mktime(0, 0, 0, $m, 10)) ?>
                </option>
            <?php endfor; ?>
        </select>

        <!-- Filter Tahun -->
        <select name="tahun" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
            <option value="">Semua Tahun</option>
            <?php for ($y = date('Y'); $y >= 2000; $y--): ?>
                <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
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
                                <a href="#" 
                                   onclick="showDetail(<?= htmlspecialchars(json_encode($tamu), ENT_QUOTES, 'UTF-8') ?>)"
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
</div>

<!-- Modal Detail Buku Tamu -->
<div id="detailModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Detail Buku Tamu</h2>
        <p><strong>Tipe Tamu:</strong> <span id="detailTipe"></span></p>
        <p><strong>Nama Tamu / Instansi:</strong> <span id="detailNama"></span></p>
        <p><strong>Alamat:</strong> <span id="detailAlamat"></span></p>
        <p><strong>No HP:</strong> <span id="detailNoHP"></span></p>
        <p><strong>Tanggal Kunjungan:</strong> <span id="detailTanggal"></span></p>
        <p><strong>Jumlah Tamu Laki-laki:</strong> <span id="detailTamuLaki"></span></p>
        <p><strong>Jumlah Tamu Perempuan:</strong> <span id="detailTamuPerempuan"></span></p>
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

// Kosongkan input pencarian saat tombol X diklik
function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    searchInput.value = '';
    toggleClearButton();
    searchInput.focus();
}

// Panggil toggleClearButton saat halaman dimuat dan saat ada input pada kotak pencarian
document.addEventListener("DOMContentLoaded", toggleClearButton);
document.getElementById('searchInput').addEventListener('input', toggleClearButton);

    
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
    let currentTamuId;

    function showDetail(tamu) {
        currentTamuId = tamu.ID_TAMU;
        document.getElementById('detailTipe').textContent = tamu.TIPE_TAMU === '1' ? 'Individual' : 'Instansi';
        document.getElementById('detailNama').textContent = tamu.NAMA_TAMU;
        document.getElementById('detailAlamat').textContent = tamu.ALAMAT_TAMU;
        document.getElementById('detailNoHP').textContent = tamu.NOHP_TAMU;

        const tanggalKunjungan = new Date(tamu.TGLKUNJUNGAN_TAMU);
        const options = {
            timeZone: 'Asia/Makassar',
            year: 'numeric',
            month: 'numeric',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
            timeZoneName: 'short'
        };

        document.getElementById('detailTanggal').textContent = tanggalKunjungan.toLocaleString('id-ID', options);

        document.getElementById('detailTamuLaki').textContent = `${tamu.JKL_TAMU} Orang`;
        document.getElementById('detailTamuPerempuan').textContent = `${tamu.JKP_TAMU} Orang`;

        const modal = document.getElementById('detailModal');
        modal.classList.remove('hidden');
    }

    function closeDetail() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
    }

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
