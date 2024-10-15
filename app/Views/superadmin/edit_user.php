<?= $this->extend('superadmin/dashboard') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Pengguna</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('superadmin/user-management/update') ?>" method="POST">
        <input type="hidden" name="original_username" value="<?= esc($user['USERNAME']); ?>">

        <div class="mb-4">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" 
                   class="mt-1 px-4 py-2 w-full border rounded-md" 
                   value="<?= esc($user['NAMA_USER']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" name="username" 
                   class="mt-1 px-4 py-2 w-full border rounded-md" 
                   value="<?= esc($user['USERNAME']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password (Opsional)</label>
            <input type="password" id="password" name="password" 
                   class="mt-1 px-4 py-2 w-full border rounded-md" 
                   placeholder="Kosongkan jika tidak ingin mengubah">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Level User</label>
            <div class="mt-1 flex space-x-4">
                <label>
                    <input type="radio" name="level_user" value="1" <?= $user['LEVEL_USER'] == '1' ? 'checked' : ''; ?>> Admin
                </label>
                <label>
                    <input type="radio" name="level_user" value="2" <?= $user['LEVEL_USER'] == '2' ? 'checked' : ''; ?>> Superadmin
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/user-management'); ?>" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
