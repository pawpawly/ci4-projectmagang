<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Event</h1>
        <a href="<?= site_url('superadmin/event/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Event
        </a>
    </div>

    <form method="get" action="<?= site_url('superadmin/event/manage') ?>" class="flex items-center space-x-4 mb-6">
        <!-- Search Input with Clear Button -->
        <div class="relative">
            <input type="text" name="search" placeholder="Cari Event..." autocomplete="off"
                   class="px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"
                   value="<?= esc($search) ?>" id="searchInput" oninput="toggleClearButton()">
            <button type="button" id="clearButton" onclick="clearSearch()" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 focus:outline-none"
                    style="display: none;">
                ✕
            </button>
        </div>

        <!-- Category Filter Dropdown -->
        <select name="category" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
            <option value="">Semua Kategori</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= esc($cat['ID_KEVENT']) ?>" <?= ($category == $cat['ID_KEVENT']) ? 'selected' : '' ?>>
                    <?= esc($cat['KATEGORI_KEVENT']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Month Filter Dropdown -->
        <select name="month" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
            <option value="">Semua Bulan</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                </option>
            <?php endfor; ?>
        </select>

<!-- Year Filter Dropdown -->
<select name="year" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
    <option value="">Semua Tahun</option>
    <?php foreach ($yearsRange as $y): ?>
        <option value="<?= $y ?>" <?= ($year == $y) ? 'selected' : '' ?>>
            <?= $y ?>
        </option>
    <?php endforeach; ?>
</select>


        <!-- Search Button -->
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Cari</button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-yellow-400">
                <tr>
                    <th class="text-left py-2 px-4">Poster Acara</th>
                    <th class="text-left py-2 px-4">Nama Acara</th>
                    <th class="text-left py-2 px-4">Kategori Acara</th>
                    <th class="text-left py-2 px-4">Tanggal Acara</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
    <?php if (!empty($events) && is_array($events)): ?>
        <?php foreach ($events as $event): ?>
            <tr class="border-b transition duration-200 hover:bg-gray-100">
                <!-- Foto Acara -->
                <td class="py-4 px-4">
                    <img src="<?= base_url('uploads/poster/' . $event['FOTO_EVENT']); ?>" 
                         alt="Poster Acara" class="w-20 h-28 object-cover rounded-md shadow-sm">
                </td>
                
                <!-- Nama Acara -->
                <td class="py-4 px-4 font-semibold"><?= esc($event['NAMA_EVENT']); ?></td>
                
                <!-- Kategori Acara -->
                <td class="py-4 px-4"><?= esc($event['NAMA_KATEGORI']); ?></td>
                
                <td class="py-4 px-4"><?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?></td>
                
                <!-- Aksi Column for Lihat Detail, Edit, and Delete -->
                <td class="py-4 px-4 text-right">
                    <div class="flex justify-end items-center space-x-2">
                        <a href="<?= site_url('superadmin/event/detail/' . $event['ID_EVENT']) ?>" 
                           class="text-blue-500 font-semibold hover:underline hover:text-blue-700">Lihat Detail</a>
                        <a href="<?= site_url('superadmin/event/edit/' . $event['ID_EVENT']) ?>" 
                           class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700">Edit</a>
                        <button onclick="confirmDelete('<?= $event['ID_EVENT'] ?>')" 
                                class="text-red-500 font-semibold hover:underline hover:text-red-700">Delete</button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada event yang ditemukan.</td>
        </tr>
    <?php endif; ?>
</tbody>


        </table>
    </div>
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

    function confirmDelete(id_event) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Event ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteEvent(id_event);
            }
        });
    }

    function deleteEvent(id_event) {
        fetch(`<?= site_url('superadmin/event/delete/') ?>${id_event}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Terhapus!', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
            console.error('Error:', error);
        });
    }
</script>

<?= $this->endSection() ?>
