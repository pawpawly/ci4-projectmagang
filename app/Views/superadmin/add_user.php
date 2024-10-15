<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Pengguna</h1>

    <!-- Tampilkan pesan error jika username sudah ada -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="addUserForm" action="<?= site_url('superadmin/user-management/save') ?>" method="POST">
        <div class="mb-4">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" 
                class="mt-1 px-4 py-2 w-full border rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" name="username" 
                class="mt-1 px-4 py-2 w-full border rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" 
                class="mt-1 px-4 py-2 w-full border rounded-md" required>
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
            <a href="<?= site_url('superadmin/user-management'); ?>" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Batal
            </a>
            <button type="button" onclick="showConfirmModal()" 
                    class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
                Tambah Pengguna
            </button>
        </div>
    </form>
</div>

<!-- Modal untuk Konfirmasi Tambah Pengguna -->
<div id="confirmAddModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Tambah Pengguna</h2>
        <p>Apakah Anda yakin ingin menambahkan pengguna ini?</p>
        <div class="mt-6 flex justify-end space-x-4">
            <button onclick="cancelAdd()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</button>
            <button onclick="submitAddForm()" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Tambah</button>
        </div>
    </div>
</div>

<script>
    function showConfirmModal() {
        const modal = document.getElementById('confirmAddModal');
        modal.classList.remove('hidden');
    }

    function cancelAdd() {
        const modal = document.getElementById('confirmAddModal');
        modal.classList.add('hidden');
    }

    function submitAddForm() {
        document.getElementById('addUserForm').submit();
    }
</script>

<?= $this->endSection() ?>
