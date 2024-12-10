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

                                <button onclick="confirmDelete('<?= esc($user['USERNAME']) ?>')" 
                                class="text-red-500 font-semibold hover:underline hover:text-red-700">
                            Delete
                        </button>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
echo view('pagers/admin_pagination', [
    'page' => $page, // Halaman saat ini
    'totalPages' => $totalPages, // Total halaman
    'baseUrl' => site_url('superadmin/user/manage'), // Base URL untuk pagination
    'queryParams' => '&search=' . ($search ?? '') // Query string tambahan untuk pencarian
]);
?>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let deleteUsername = null;

// Fungsi untuk konfirmasi delete dengan SweetAlert2
function confirmDelete(username) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Pengguna ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteUser(username);
        }
    });
}

function deleteUser(username) {
    fetch(`<?= site_url('superadmin/user/delete/') ?>${encodeURIComponent(username)}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Berhasil!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK',
            }).then(() => {
                if (data.redirect) {
                    window.location.href = data.redirect; // Redirect ke halaman login
                } else {
                    document.getElementById(`user-${username}`).remove(); // Hapus baris user dari tabel
                }
            });
        } else {
            Swal.fire({
                title: 'Gagal!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK',
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan pada server.',
            icon: 'error',
            confirmButtonText: 'OK',
        });
        console.error('Error:', error);
    });
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
