<?= $this->extend('admin/sidebar') ?>

<?= $this->section('content') ?>

<?php helper('month'); ?>

<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Berita</h1>
        <a href="<?= site_url('admin/berita/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Berita
        </a>
    </div>

    <p class="mb-4 text-gray-800">Daftar semua berita di halaman anda</p>

    <form method="get" action="<?= site_url('admin/berita/manage') ?>" class="flex items-center space-x-4 mb-6">
    <?= csrf_field(); ?> 
        <!-- Search Input with Clear Button -->
        <div>
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



        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Cari</button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-gray-600">
                <tr>
                    <th class="text-left text-white py-2 px-4">Foto Berita</th>
                    <th class="text-left text-white py-2 px-4">Nama Berita</th>
                    <th class="text-left text-white py-2 px-4">Sumber Berita</th>
                    <th class="text-left text-white py-2 px-4">Tanggal Berita</th>
                    <th class="text-center text-white py-2 px-4">Aksi</th>
                </tr>
            </thead>
           <tbody class="text-gray-800">
                <?php if (!empty($berita) && is_array($berita)): ?>
                    <?php foreach ($berita as $item): ?>
                        <tr class="border-b transition duration-75 hover:bg-gray-300">
                            <td class="py-2 px-4">
                                <?php if ($item['FOTO_BERITA']): ?>
                                    <img src="<?= base_url('uploads/berita/' . $item['FOTO_BERITA']); ?>" 
                                         alt="Foto Berita" class="w-24 h-24 object-cover rounded-md shadow-sm">
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs font-semibold inline-flex items-center justify-center w-24 h-8 rounded-md text-sm">Foto Berita Tidak Tersedia</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-2 px-4"><?= esc($item['NAMA_BERITA']); ?></td>
                            <td class="py-2 px-4"><?= esc($item['SUMBER_BERITA']); ?></td>
                            <td class="py-2 px-4"><?= formatTanggalIndonesia($item['TANGGAL_BERITA']); ?></td>
                            <td class="py-2 px-4 text-center">
                                <div class="flex justify-center text-center items-center space-x-2">
                                    <!-- Tombol Lihat Detail -->
                                    <a href="<?= site_url('admin/berita/detail/' . $item['ID_BERITA']) ?>" 
                                       class="bg-blue-500 text-white inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-blue-700" title="Lihat Detail">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                          <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                          <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                                        </svg>
                                    </a>

                                    <!-- Tombol Edit -->
                                    <a href="<?= site_url('admin/berita/edit/' . $item['ID_BERITA']) ?>" 
                                       class="bg-yellow-500 text-white inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-yellow-700" title="Edit">
                                       <svg xmlns="http://www.w3.org/2000/svg" class= "h-6 w-6" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                          <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                          <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                        </svg>
                                    </a>

                                    <!-- Tombol Delete -->
                                    <button onclick="confirmDelete('<?= $item['ID_BERITA'] ?>')" 
                                            class="bg-red-500 text-white inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-red-700" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                          <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
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
    'baseUrl' => site_url('admin/berita/manage'),
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
        fetch(`<?= site_url('admin/berita/delete/') ?>${id_berita}`, {
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
