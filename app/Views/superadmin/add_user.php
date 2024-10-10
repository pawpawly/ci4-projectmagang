<?= $this->extend('superadmin/dashboard') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Pengguna</h1>
    
    <form action="<?= site_url('superadmin/user-management/save'); ?>" method="post">
        <div class="mb-4">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" id="username" class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="mt-1 px-4 py-2 w-full border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="level_user" class="block text-sm font-medium text-gray-700">Level Pengguna</label>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" name="level_user" value="1" class="form-radio" required>
                    <span class="ml-2">Admin</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" name="level_user" value="2" class="form-radio" required>
                    <span class="ml-2">Superadmin</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Simpan</button>
            <a href="<?= site_url('superadmin/user-management'); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
