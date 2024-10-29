<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Pengguna</h1>

    <form id="editUserForm" action="<?= site_url('superadmin/user/update') ?>" method="POST" novalidate>
        <input type="hidden" name="original_username" value="<?= esc($user['USERNAME']); ?>">

        <div class="mb-4">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" 
                   value="<?= esc($user['NAMA_USER']); ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" name="username" 
                   value="<?= esc($user['USERNAME']); ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   placeholder="Masukkan username" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password (Opsional)</label>
            <input type="password" id="password" name="password" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   placeholder="Kosongkan jika tidak ingin mengubah">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Level User</label>
            <div class="mt-1 flex space-x-4">
                <label>
                    <input type="radio" name="level_user" value="1" 
                           <?= $user['LEVEL_USER'] == '1' ? 'checked' : ''; ?> required> Admin
                </label>
                <label>
                    <input type="radio" name="level_user" value="2" 
                           <?= $user['LEVEL_USER'] == '2' ? 'checked' : ''; ?> required> Superadmin
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/user/manage'); ?>" 
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('editUserForm').addEventListener('submit', function (e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        const formData = new FormData(this);

        fetch('<?= site_url('superadmin/user/update') ?>', {
            method: 'POST',
            body: formData,
            headers: {
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
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = data.redirect;
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
    });

    function validateForm() {
        const namaLengkap = document.getElementById('nama_lengkap').value.trim();
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();
        const levelUser = document.querySelector('input[name="level_user"]:checked');

        if (!namaLengkap || !username || !levelUser) {
            Swal.fire({
                title: 'Oops!',
                text: 'Semua field wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }

        if (password && password.length < 8) {
            Swal.fire({
                title: 'Oops!',
                text: 'Password harus minimal 8 karakter!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }

        return true;
    }
</script>

<?= $this->endSection() ?>
