<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Pengguna</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Tampilkan pesan error jika ada -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="addUserForm" action="<?= site_url('superadmin/user/save') ?>" method="POST" onsubmit="return validateForm()">
        <div class="mb-4">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   required placeholder="Masukkan nama lengkap">
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" name="username" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   required placeholder="Masukkan username">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   required placeholder="Masukkan password">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Level User</label>
            <div class="mt-1 flex space-x-4">
                <label>
                    <input type="radio" name="level_user" value="1" required> Admin
                </label>
                <label>
                    <input type="radio" name="level_user" value="2" required> Superadmin
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/user/manage'); ?>" 
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                Batal
            </a>
            <button type="submit" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                Tambah Pengguna
            </button>
        </div>
    </form>
</div>

<script>
    // Validasi JavaScript untuk memastikan semua field terisi
    function validateForm() {
        const namaLengkap = document.getElementById('nama_lengkap').value.trim();
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();
        const levelUser = document.querySelector('input[name="level_user"]:checked');

        if (!namaLengkap || !username || !password || !levelUser) {
            alert('Semua field wajib diisi.');
            return false;
        }
        return true;
    }
</script>

<?= $this->endSection() ?>
