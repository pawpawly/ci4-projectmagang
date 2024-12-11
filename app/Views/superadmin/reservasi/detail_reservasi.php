<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Detail Reservasi</h1>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Nama:</h2>
        <p><?= esc($reservasi['NAMA_RESERVASI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Instansi:</h2>
        <p><?= esc($reservasi['INSTANSI_RESERVASI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Email:</h2>
        <p><?= esc($reservasi['EMAIL_RESERVASI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">No Whatsapp:</h2>
        <p><?= esc($reservasi['TELEPON_RESERVASI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Jumlah Pengunjung:</h2>
        <p><?= esc($reservasi['JMLPENGUNJUNG_RESERVASI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Kegiatan:</h2>
        <p><?= esc($reservasi['KEGIATAN_RESERVASI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Tanggal Reservasi:</h2>
        <p><?= formatTanggalIndonesia($reservasi['TANGGAL_RESERVASI']); ?></p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Status Reservasi:</h2>
        <p>
            <?php 
                $status = strtolower($reservasi['STATUS_RESERVASI']);
                $statusClass = '';
                switch ($status) {
                    case 'setuju':
                        $statusClass = 'bg-green-200 text-green-700 text-white text-center  text-base font-semibold rounded-md px-1 py-1';
                        break;
                    case 'tolak':
                        $statusClass = 'bg-red-200 text-red-700 text-white text-center  text-base font-semibold rounded-md px-1 py-1';
                        break;
                    case 'pending':
                    default:
                        $statusClass = 'bg-yellow-200 text-yellow-700 text-white text-center  text-base font-semibold rounded-md px-1 py-1';
                        break;
                }
            ?>
            <span id="detailStatus" class="<?= $statusClass; ?>"><?= ucfirst($status); ?></span>
        </p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Surat Kunjungan (PDF/Gambar):</h2>
        <?php if (!empty($reservasi['SURAT_RESERVASI'])): ?>
            <a href="<?= base_url('uploads/surat_kunjungan/' . $reservasi['SURAT_RESERVASI']); ?>" target="_blank" 
               class="text-blue-500 font-semibold hover:underline">
                View / Download File
            </a>
        <?php else: ?>
            <p class="text-gray-500">Tidak ada file surat kunjungan yang diunggah.</p>
        <?php endif; ?>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        <button onclick="updateStatus('tolak')" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Tolak</button>
        <button onclick="updateStatus('setuju')" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Setuju</button>
        <a href="<?= site_url('superadmin/reservasi/manage'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Kembali</a>
    </div>
</div>

<!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function updateStatus(newStatus) {
    const idReservasi = <?= $reservasi['ID_RESERVASI']; ?>;

    fetch(`<?= site_url('superadmin/reservasi/update-status/'); ?>${idReservasi}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ status_reservasi: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update status label in the view
            const statusElement = document.getElementById('detailStatus');
            statusElement.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            statusElement.className = 
                data.status === 'setuju' ? 'bg-green-200 text-green-700 text-white text-center  text-base font-semibold rounded-md px-1 py-1' :
                data.status === 'tolak' ? 'bg-red-200 text-red-700 text-white text-center  text-base font-semibold rounded-md px-1 py-1' :
                'bg-yellow-500 text-white px-2 py-1 rounded';

            // Show success message with SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Status berhasil diperbarui menjadi ' + data.status + '.',
                confirmButtonText: 'OK'
            });
        } else {
            // Show error message with SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal memperbarui status: ' + data.message,
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan saat memperbarui status.',
            confirmButtonText: 'OK'
        });
    });
}
</script>

<?= $this->endSection() ?>
