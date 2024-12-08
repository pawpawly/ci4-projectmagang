<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>

<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Koleksi</h1>
        <a href="<?= site_url('superadmin/koleksi/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Koleksi
        </a>
    </div>
    <p class="mb-4 text-gray-800">Daftar semua event di Website Anda</p>

    <div class="flex items-center justify-between mb-6">
    <form method="get" action="<?= site_url('superadmin/koleksi/manage') ?>" class="flex items-center space-x-4 relative">
    <?= csrf_field(); ?>
        <!-- Input Pencarian dengan Tombol X di dalamnya -->
        <div class="relative">
            <input type="text" name="search" placeholder="Cari Koleksi..." autocomplete="off"
                   class="px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"
                   value="<?= esc(service('request')->getGet('search')) ?>" id="searchInput" oninput="toggleClearButton()">
            
            <!-- Tombol X untuk menghapus input, berada di dalam kotak input -->
            <button type="button" id="clearButton" onclick="clearSearch()" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                    style="display: none;">
                ✕
            </button>
        </div>

        <select name="category" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
            <option value="">Semua Kategori</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= esc($cat['ID_KKOLEKSI']) ?>" <?= service('request')->getGet('category') == $cat['ID_KKOLEKSI'] ? 'selected' : '' ?>>
                    <?= esc($cat['KATEGORI_KKOLEKSI']) ?>
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
                <th class="text-left py-2 px-4">Foto Koleksi</th>
                <th class="text-left py-2 px-4">Nama Koleksi</th>
                <th class="text-left py-2 px-4">Kategori Koleksi</th>
                <th class="text-right py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
    <?php foreach ($koleksi as $item): ?>
    <tr class="border-b">
        <td class="py-2 px-4">
            <img src="<?= base_url('uploads/koleksi/' . $item['FOTO_KOLEKSI']); ?>" 
                 alt="Foto Koleksi" class="w-24 h-24 object-cover rounded-md">
        </td>
        <td class="py-2 px-4"><?= esc($item['NAMA_KOLEKSI']); ?></td>
        <td class="py-2 px-4"><?= esc($item['NAMA_KATEGORI']); ?></td>
        <td class="py-2 px-4 text-right">
            <div class="flex justify-end items-center space-x-4">
                <a href="<?= site_url('superadmin/koleksi/detail/' . $item['ID_KOLEKSI']) ?>" 
                   class="text-blue-500 font-semibold hover:underline hover:text-blue-700">Lihat Detail</a>
                <a href="<?= site_url('superadmin/koleksi/edit/' . $item['ID_KOLEKSI']) ?>" 
                   class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">Edit</a>
                <button onclick="confirmDelete('<?= $item['ID_KOLEKSI'] ?>')" 
                   class="text-red-500 font-semibold hover:underline hover:text-red-700">Delete</button>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

    </table>
    <?php
    echo view('pagers/admin_pagination', [
        'page' => $page, // Halaman saat ini
        'totalPages' => $totalPages, // Total halaman
        'baseUrl' => site_url('superadmin/koleksi/manage'), // URL dasar untuk pagination
        'queryParams' => '&search=' . ($search ?? '') . '&category=' . ($category ?? '') // Query tambahan
    ]);
    ?>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    // Tampilkan atau sembunyikan tombol X
    function toggleClearButton() {
        const searchInput = document.getElementById('searchInput');
        const clearButton = document.getElementById('clearButton');
        clearButton.style.display = searchInput.value ? 'inline' : 'none';
    }

    // Kosongkan input pencarian saat tombol X diklik
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        toggleClearButton();
        document.getElementById('searchInput').focus(); // Fokus kembali ke input pencarian
    }

    // Panggil toggleClearButton saat halaman dimuat, untuk memeriksa jika ada nilai default
    document.addEventListener("DOMContentLoaded", toggleClearButton);

    // Fungsi Filter
    function filterTable() {
        const searchInput = document.getElementById('search').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#koleksiTable tbody tr');

        rows.forEach(row => {
            const namaKoleksi = row.querySelector('.nama-koleksi').textContent.toLowerCase();
            const kategoriKoleksi = row.querySelector('.kategori-koleksi').textContent.toLowerCase();

            const matchesSearch = namaKoleksi.includes(searchInput);
            const matchesCategory = categoryFilter === "" || kategoriKoleksi === categoryFilter;

            if (matchesSearch && matchesCategory) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // Fungsi Urutkan Berdasarkan Nama
    function sortTable() {
        const table = document.getElementById('koleksiTable');
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const sortedRows = rows.sort((a, b) => {
            const nameA = a.querySelector('.nama-koleksi').textContent.toLowerCase();
            const nameB = b.querySelector('.nama-koleksi').textContent.toLowerCase();
            return nameA.localeCompare(nameB);
        });

        sortedRows.forEach(row => table.querySelector('tbody').appendChild(row));
    }

    function confirmDelete(id_koleksi) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Koleksi ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("<?= site_url('superadmin/koleksi/delete/') ?>" + id_koleksi, {
                    method: 'DELETE',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
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
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan pada server.',
                        'error'
                    );
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>
