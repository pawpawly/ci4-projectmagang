<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Pengguna</h1>

    <form id="editUserForm" action="<?= site_url('superadmin/user/update') ?>" method="POST" autocomplete="off" novalidate>
    <?= csrf_field(); ?> 
        <input type="hidden" name="original_username" value="<?= esc($user['USERNAME']); ?>">

        <div class="mb-4">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" maxlength="60" id="nama_lengkap" name="nama_lengkap" 
                   value="<?= esc($user['NAMA_USER']); ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" maxlength="30" id="username" name="username" autocomplete="off"
                   value="<?= esc($user['USERNAME']); ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   placeholder="Masukkan username" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password (Opsional)</label>
            <input type="password" maxlength="30" id="password" name="password" autocomplete="off"
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
               <button id="editUserButton" type="submit" 
        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 flex items-center justify-center">
    Simpan Perubahan
</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('editUserForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const editUserButton = document.getElementById('editUserButton');

    // Spinner SVG
    const spinner = `<svg class="animate-spin h-5 w-5 text-white ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
    </svg>`;

    // Validasi Form
    if (!validateForm()) {
        return; // Jika validasi gagal, hentikan proses
    }

    // Ubah tombol menjadi disabled, tambahkan spinner dan teks "Menyimpan..."
    editUserButton.disabled = true;
    editUserButton.classList.add('opacity-50', 'cursor-not-allowed');
    editUserButton.innerHTML = `Menyimpan... ${spinner}`;

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

            // Reset tombol jika gagal
            resetButton(editUserButton);
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

        // Reset tombol jika ada error
        resetButton(editUserButton);
    });
});

// Fungsi untuk mereset tombol
function resetButton(button) {
    button.disabled = false;
    button.classList.remove('opacity-50', 'cursor-not-allowed');
    button.innerHTML = 'Simpan Perubahan'; // Kembalikan teks tombol
}

// Fungsi validasi form
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
