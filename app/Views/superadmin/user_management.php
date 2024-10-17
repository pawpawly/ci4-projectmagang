<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Users</h1>
        <a href="<?= site_url('superadmin/user-management/add') ?>" 
           class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
            Tambah Pengguna
        </a>
    </div>

    <p class="mb-4 text-gray-800">Daftar semua pengguna di Website Anda termasuk nama, role, dan password.</p>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead class="bg-gray-100">
    <tr>
        <th class="text-left py-2 px-4">Nama Lengkap</th>
        <th class="text-left py-2 px-4">Role</th>
        <th class="text-right py-2 px-4">Aksi</th>
    </tr>
</thead>
<tbody class="text-gray-800">
    <?php 
    $loggedInUsername = session()->get('username'); 
    foreach ($users as $user): 
    ?>
    <tr class="border-b">
        <td class="py-2 px-4">
            <?php if ($user['USERNAME'] === $loggedInUsername): ?>
                <strong><?= esc($user['NAMA_USER']); ?> (Saya)</strong>
            <?php else: ?>
                <?= esc($user['NAMA_USER']); ?>
            <?php endif; ?>
        </td>
        <td class="py-2 px-4">
            <?= $user['LEVEL_USER'] == '1' ? 'Admin' : 'Superadmin'; ?>
        </td>
        <td class="py-2 px-4 text-right">
            <a href="<?= site_url('superadmin/user-management/edit/' . $user['USERNAME']) ?>" 
               class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700 mr-4">
               Edit
            </a>
            <?php if ($user['USERNAME'] !== $loggedInUsername): ?>
                <a href="#" onclick="confirmDelete('<?= $user['USERNAME'] ?>')" 
                   class="text-red-500 font-semibold hover:underline hover:text-red-700">
                   Delete
                </a>
            <?php else: ?>
                <!-- Beri elemen kosong untuk menjaga jarak agar posisi tetap konsisten -->
                <span class="text-transparent">Delete</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

        </table>
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 bg-white flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-4">Konfirmasi Penghapusan</h2>
            <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="cancelDelete()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-200">Batal</button>
                <a id="confirmDeleteBtn" href="#" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus</a>
            </div>
        </div>
    </div>

    <div id="notification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-md"></div>
</div>

<script>
    function showNotification(message) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.classList.remove('hidden');

        setTimeout(() => {
            notification.classList.add('hidden');
        }, 3000);
    }

    function confirmDelete(username) {
        const modal = document.getElementById('deleteModal');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.href = "<?= site_url('superadmin/user-management/delete/') ?>" + username;
        modal.classList.remove('hidden');
    }

    function cancelDelete() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }

    <?php if (session()->getFlashdata('message')): ?>
        showNotification('<?= session()->getFlashdata('message'); ?>');
    <?php elseif (session()->getFlashdata('error')): ?>
        showNotification('<?= session()->getFlashdata('error'); ?>');
    <?php endif; ?>
</script>

<?= $this->endSection() ?>
