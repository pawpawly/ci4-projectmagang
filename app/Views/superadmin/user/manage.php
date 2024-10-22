<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="bg-white min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Users</h1>
        <a href="<?= site_url('superadmin/user/add') ?>" 
           class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Pengguna
        </a>
    </div>

    <p class="mb-4 text-gray-800">Daftar semua pengguna di Website Anda termasuk nama, role, dan password.</p>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead class="bg-yellow-400">
                <tr>
                    <th class="text-left py-2 px-4">Nama Lengkap</th>
                    <th class="text-left py-2 px-4">Role</th>
                    <th class="text-right py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800" id="userTable">
                <?php 
                $loggedInUsername = session()->get('username'); 
                foreach ($users as $user): ?>
                    <tr id="user-<?= esc($user['USERNAME']) ?>" class="border-b">
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
                            <div class="flex justify-end items-center space-x-4">
                                <a href="<?= site_url('superadmin/user/edit/' . urlencode($user['USERNAME'])) ?>" 
                                   class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700 mr-4">
                                   Edit
                                </a>

                                <?php if ($user['USERNAME'] !== $loggedInUsername): ?>
                                    <button onclick="confirmDelete('<?= esc($user['USERNAME']) ?>')" 
                                            class="text-red-500 font-semibold hover:underline hover:text-red-700">
                                        Delete
                                    </button>
                                <?php else: ?>
                                    <span class="text-transparent">Delete</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-4">Konfirmasi Penghapusan</h2>
            <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="cancelDelete()" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</button>
                <button id="confirmDeleteBtn" 
                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus</button>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div id="notification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-md"></div>
</div>

<script>
let deleteUsername = null;

function confirmDelete(username) {
    deleteUsername = username;
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
}

function cancelDelete() {
    deleteUsername = null;
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (deleteUsername) {
        fetch(`<?= site_url('superadmin/user/delete/') ?>${encodeURIComponent(deleteUsername)}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                renderUserTable(data.users); // Render ulang tabel dengan data terbaru
                showNotification(data.message, 'success');
            } else if (data.error) {
                showNotification(data.error, 'error');
            }
        })
        .catch(() => showNotification('Terjadi kesalahan saat menghapus pengguna.', 'error'));

        cancelDelete();
    }
});

function renderUserTable(users) {
    const userTable = document.getElementById('userTable');
    userTable.innerHTML = ''; // Hapus semua baris sebelumnya

    users.forEach(user => {
        const isCurrentUser = user.USERNAME === '<?= session()->get('username'); ?>';
        const userRow = `
            <tr id="user-${user.USERNAME}" class="border-b">
                <td class="py-2 px-4">${isCurrentUser ? `<strong>${user.NAMA_USER} (Saya)</strong>` : user.NAMA_USER}</td>
                <td class="py-2 px-4">${user.LEVEL_USER == '1' ? 'Admin' : 'Superadmin'}</td>
                <td class="py-2 px-4 text-right">
                    <div class="flex justify-end items-center space-x-4">
                        <a href="<?= site_url('superadmin/user/edit/') ?>${encodeURIComponent(user.USERNAME)}" 
                           class="text-yellow-500 font-semibold hover:underline hover:text-yellow-700 mr-4">Edit</a>
                        ${!isCurrentUser ? 
                            `<button onclick="confirmDelete('${user.USERNAME}')" 
                                class="text-red-500 font-semibold hover:underline hover:text-red-700">Delete</button>` : 
                            `<span class="text-transparent">Delete</span>`}
                    </div>
                </td>
            </tr>`;
        userTable.insertAdjacentHTML('beforeend', userRow);
    });
}

function showNotification(message, type) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
    notification.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');
    setTimeout(() => {
        notification.classList.add('hidden');
    }, 3000);
}









</script>

<style>
    tbody tr:hover {
        background-color: #FFEBB5;
    }

    tbody tr:hover td {
        transition: background-color 0.2s ease-in-out;
    }
</style>

<?= $this->endSection() ?>
