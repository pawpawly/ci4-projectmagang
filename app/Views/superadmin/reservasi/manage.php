    <?= $this->extend('superadmin/sidebar') ?>

    <?= $this->section('content') ?>

    <div class="bg-white min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manajemen Reservasi</h1>
        </div>
        <p class="mb-4 text-gray-800">Daftar semua reservasi di Website Anda</p>

    <!-- Form Pencarian dan Filter -->
    <div class="flex items-center mb-4 space-x-4">
        <form method="get" action="<?= site_url('superadmin/reservasi/manage') ?>" class="flex items-center space-x-4">
            <!-- Input Pencarian -->
            <div class="relative">
                <input type="text" name="search" placeholder="Cari Nama atau Instansi..." autocomplete="off"
                       class="px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       value="<?= esc($search) ?>" id="searchInput" oninput="toggleClearButton()">
                
                <!-- Tombol X untuk menghapus input -->
                <button type="button" id="clearButton" onclick="clearSearch()" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                        style="display: none;">
                    ✕
                </button>
            </div>

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
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 10)) ?></option>
                <?php endfor; ?>
            </select>

<!-- Filter Tahun dengan rentang dinamis -->
<select name="tahun" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
    <option value="">Semua Tahun</option>
    <?php foreach ($yearsRange as $y): ?>
        <option value="<?= $y ?>" <?= $tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
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
                        <th class="text-left py-2 px-4">Nama</th>
                        <th class="text-left py-2 px-4">Instansi</th>
                        <th class="text-left py-2 px-4">No Whatsapp</th>
                        <th class="text-left py-2 px-4">Tanggal Reservasi</th>
                        <th class="text-left py-2 px-4">Status Reservasi</th>
                        <th class="text-right py-2 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
        <?php if (!empty($reservasi)): ?>
            <?php foreach ($reservasi as $item): ?>
                <tr class="border-b">
                    <td class="py-2 px-4"><?= esc($item['NAMA_RESERVASI']); ?></td>
                    <td class="py-2 px-4"><?= esc($item['INSTANSI_RESERVASI']); ?></td>
                    <td class="py-2 px-4"><?= esc($item['TELEPON_RESERVASI']); ?></td>
                    <td class="py-2 px-4"><?= formatTanggalIndonesia($item['TANGGAL_RESERVASI']); ?></td>
                    <td class="py-2 px-4">
                        <?php
                            $status = strtolower($item['STATUS_RESERVASI']);
                            $statusClass = '';
                            switch ($status) {
                                case 'setuju':
                                    $statusClass = 'bg-green-500 text-white';
                                    break;
                                case 'tolak':
                                    $statusClass = 'bg-red-500 text-white';
                                    break;
                                case 'pending':
                                default:
                                    $statusClass = 'bg-yellow-500 text-white';
                                    break;
                            }
                        ?>
                        <span class="px-2 py-1 rounded-md <?= $statusClass; ?>">
                            <?= ucfirst($status); ?>
                        </span>
                    </td>
                    <td class="py-2 px-4 text-right">
                        <a href="#" onclick="showDetail(<?= htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') ?>)" 
                        class="text-green-500 font-semibold hover:underline hover:text-green-700">Detail</a>
                        <a href="#" onclick="confirmDelete('<?= $item['ID_RESERVASI'] ?>')" 
                        class="text-red-500 font-semibold hover:underline hover:text-red-700">Delete</a>
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
    </div>

    <!-- Modal Detail Reservasi -->
    <div id="detailModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Detail Reservasi</h2>
            <p><strong>Nama:</strong> <span id="detailNama"></span></p>
            <p><strong>Instansi:</strong> <span id="detailInstansi"></span></p>
            <p><strong>Email:</strong> <span id="detailEmail"></span></p>
            <p><strong>No Whatsapp:</strong> <span id="detailTelepon"></span></p>
            <p><strong>Jumlah Pengunjung:</strong> <span id="detailJumlahPengunjung"></span></p>
            <p><strong>Kegiatan:</strong> <span id="detailKegiatan"></span></p>
            <p><strong>Tanggal Reservasi:</strong> <span id="detailTanggal"></span></p>
            <p><strong>Status:</strong> <span id="detailStatus"></span></p>
            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="closeDetail()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</button>
                <button onclick="updateStatus('tolak')" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Tolak</button>
                <button onclick="updateStatus('setuju')" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Setuju</button>
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


        let currentReservasiId;

        function showDetail(item) {
            currentReservasiId = item.ID_RESERVASI;
            document.getElementById('detailNama').textContent = item.NAMA_RESERVASI;
            document.getElementById('detailInstansi').textContent = item.INSTANSI_RESERVASI;
            document.getElementById('detailEmail').textContent = item.EMAIL_RESERVASI;
            document.getElementById('detailTelepon').textContent = item.TELEPON_RESERVASI;
            document.getElementById('detailJumlahPengunjung').textContent = item.JMLPENGUNJUNG_RESERVASI;
            document.getElementById('detailKegiatan').textContent = item.KEGIATAN_RESERVASI;
            document.getElementById('detailTanggal').textContent = new Date(item.TANGGAL_RESERVASI).toLocaleDateString();
            document.getElementById('detailStatus').textContent = item.STATUS_RESERVASI;

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
        }
        function updateStatus(status) {
        fetch(`<?= site_url('superadmin/reservasi/status/') ?>${currentReservasiId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status_reservasi: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Status berhasil diperbarui menjadi ${status}.`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
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
                text: 'Terjadi kesalahan.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            console.error('Error:', error);
        });
    }

        function closeDetail() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
        }

        function updateStatus(status) {
        fetch(`<?= site_url('superadmin/reservasi/status/') ?>${currentReservasiId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status_reservasi: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: `Status berhasil diperbarui menjadi ${status}.`,
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
