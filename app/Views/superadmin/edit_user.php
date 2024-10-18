<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Pengguna</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="editUserForm" action="<?= site_url('superadmin/user-management/update') ?>" method="POST">
        <input type="hidden" name="original_username" value="<?= esc($user['USERNAME']); ?>">

        <div class="mb-4">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   value="<?= esc($user['NAMA_USER']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" name="username" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   value="<?= esc($user['USERNAME']); ?>" required>
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
                    <input type="radio" name="level_user" value="1" <?= $user['LEVEL_USER'] == '1' ? 'checked' : ''; ?>> Admin
                </label>
                <label>
                    <input type="radio" name="level_user" value="2" <?= $user['LEVEL_USER'] == '2' ? 'checked' : ''; ?>> Superadmin
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/user-management'); ?>" 
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="button" onclick="confirmEdit()" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan Perubahan</button>
        </div>
    </form>
</div>

<!-- Modal Konfirmasi Simpan -->
<div id="confirmEditModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Simpan Perubahan</h2>
        <p>Apakah Anda yakin ingin menyimpan perubahan ini?</p>
        <div class="mt-6 flex justify-end space-x-4">
            <button onclick="cancelEdit()" 
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</button>
            <button onclick="submitForm()" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </div>
</div>

<script>
    function confirmEdit() {
        const modal = document.getElementById('confirmEditModal');
        modal.classList.remove('hidden');
    }

    function cancelEdit() {
        const modal = document.getElementById('confirmEditModal');
        modal.classList.add('hidden');
    }

    function submitForm() {
        document.getElementById('editUserForm').submit();
    }
</script>

<?= $this->endSection() ?>
