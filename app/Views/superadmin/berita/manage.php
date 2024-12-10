<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<?php helper('month'); ?>

<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Berita</h1>
        <a href="<?= site_url('superadmin/berita/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Berita
        </a>
    </div>

    <form method="get" action="<?= site_url('superadmin/berita/manage') ?>" class="flex items-center space-x-4 mb-6">
    <?= csrf_field(); ?> 
        <!-- Search Input with Clear Button -->
        <div class="relative">
            <input type="text" name="search" placeholder="Cari Berita..." autocomplete="off"
                   class="px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"
                   value="<?= esc($search) ?>" id="searchInput" oninput="toggleClearButton()">
            <button type="button" id="clearButton" onclick="clearSearch()" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                    style="display: none;">
                ✕
            </button>
        </div>

        <!-- Filter Bulan -->
        <select name="month" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
            <option value="">Semua Bulan</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>>
                    <?= getBulanIndo($m) ?> <!-- Menggunakan fungsi helper untuk bulan -->
                </option>
            <?php endfor; ?>
        </select>

<!-- Filter Tahun -->
<select name="year" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
    <option value="">Semua Tahun</option>
    <?php foreach ($yearsRange as $yr): ?>
        <option value="<?= $yr ?>" <?= $year == $yr ? 'selected' : '' ?>>
            <?= $yr ?>
        </option>
    <?php endforeach; ?>
</select>



        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Cari</button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-yellow-400">
                <tr>
                    <th class="text-left py-2 px-4">Foto Berita</th>
                    <th class="text-left py-2 px-4">Nama Berita</th>
                    <th class="text-left py-2 px-4">Sumber Berita</th>
                    <th class="text-left py-2 px-4">Tanggal Berita</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <?php if (!empty($berita) && is_array($berita)): ?>
                    <?php foreach ($berita as $item): ?>
                        <tr class="border-b transition duration-200">
                            <td class="py-2 px-4">
                                <img src="<?= base_url('uploads/berita/' . $item['FOTO_BERITA']); ?>" 
                                     alt="Foto Berita" class="w-24 h-24 object-cover rounded-md shadow-sm">
                            </td>
                            <td class="py-2 px-4"><?= esc($item['NAMA_BERITA']); ?></td>
                            <td class="py-2 px-4"><?= esc($item['SUMBER_BERITA']); ?></td>
                            <td class="py-2 px-4"><?= formatTanggalIndonesia($item['TANGGAL_BERITA']); ?></td>
                            <td class="py-2 px-4 text-right">
                                <div class="flex justify-end items-center space-x-4">
                                    <a href="<?= site_url('superadmin/berita/detail/' . $item['ID_BERITA']) ?>" 
                                       class="text-blue-500 font-semibold hover:underline hover:text-blue-700">Lihat Detail</a>
                                    <a href="<?= site_url('superadmin/berita/edit/' . $item['ID_BERITA']) ?>" 
                                       class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">Edit</a>
                                    <button onclick="confirmDelete('<?= $item['ID_BERITA'] ?>')" 
                                            class="text-red-500 font-semibold hover:underline hover:text-red-700">Delete</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada berita yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
echo view('pagers/admin_pagination', [
    'page' => $page,
    'totalPages' => $totalPages,
    'baseUrl' => site_url('superadmin/berita/manage'),
    'queryParams' => '&search=' . ($search ?? '') . '&month=' . ($month ?? '') . '&year=' . ($year ?? '')
]);
?>

</div>

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

    function confirmDelete(id_berita) {
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
                deleteBerita(id_berita);
            }
        });
    }

    function deleteBerita(id_berita) {
        fetch(`<?= site_url('superadmin/berita/delete/') ?>${id_berita}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire('Terhapus!', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error!', 'Terjadi kesalahan saat menghapus berita.', 'error');
            console.error('Error:', error);
        });
    }
</script>

<?= $this->endSection() ?>
