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
            <thead class="bg-gray-600">
                <tr>
                    <th class="text-left text-white font-semibold py-2 px-4">Nama Lengkap</th>
                    <th class="text-left text-white font-semibold py-2 px-4">Role</th>
                    <th class="text-center text-white font-semibold py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800" id="userTable">
                <?php 
                $loggedInUsername = session()->get('username'); 
                foreach ($users as $user): ?>
                    <tr id="user-<?= esc($user['USERNAME']) ?>" class="border-b transition duration-75 hover:bg-gray-300">
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
                        <td class="py-2 px-4 text-center">
                        <div class="flex justify-center text-center items-center space-x-2">
                                <a href="<?= site_url('superadmin/user/edit/' . urlencode($user['USERNAME'])) ?>" 
                                   class="bg-yellow-500 text-white inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-yellow-700" title="Edit">
                                   <svg xmlns="http://www.w3.org/2000/svg" class= "h-6 w-6" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                      <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                      <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                    </svg>
                                </a>
                                <button onclick="confirmDelete('<?= esc($user['USERNAME']) ?>')" 
                                        class="bg-red-500 text-white inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-red-700" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                      <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
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
            })
            .then(() => {
                location.reload();
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



<?= $this->endSection() ?>
