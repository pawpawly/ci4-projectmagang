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

    <form id="addUserForm" action="<?= site_url('superadmin/user/save') ?>" method="POST" autocomplete="off">
    <?= csrf_field(); ?> 
    <div class="mb-4">
        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" maxlength="30" id="nama_lengkap"  name="nama_lengkap" autocomplete="off" 
               class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none" 
               placeholder="Masukkan nama lengkap">
    </div>

    <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" maxlength="30" id="username" name="username" autocomplete="off"
               class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none" 
               placeholder="Masukkan username">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" maxlength="30" id="password" name="password" autocomplete="off"
               class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none" 
               placeholder="Masukkan password">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Level User</label>
        <div class="mt-1 flex space-x-4">
            <label>
                <input type="radio" name="level_user" value="1"> Admin
            </label>
            <label>
                <input type="radio" name="level_user" value="2"> Superadmin
            </label>
        </div>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        <a href="<?= site_url('superadmin/user/manage'); ?>" 
           class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
            Batal
        </a>
        <button id="addUserButton" type="submit" 
        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 flex items-center justify-center">
    Tambah Pengguna
</button>

    </div>
</form>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('addUserForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Mencegah submit default

    const addUserButton = document.getElementById('addUserButton');

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
    addUserButton.disabled = true;
    addUserButton.classList.add('opacity-50', 'cursor-not-allowed');
    addUserButton.innerHTML = `Menyimpan... ${spinner}`;

    const formData = new FormData(this);

    // Kirim data menggunakan fetch
    fetch('<?= site_url('superadmin/user/save') ?>', {
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
                text: 'Pengguna berhasil ditambahkan.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '<?= site_url('superadmin/user/manage'); ?>';
            });
        } else {
            Swal.fire({
                title: 'Gagal!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });

            // Reset tombol jika gagal
            resetButton(addUserButton);
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
        resetButton(addUserButton);
    });
});

// Fungsi untuk mereset tombol
function resetButton(button) {
    button.disabled = false;
    button.classList.remove('opacity-50', 'cursor-not-allowed');
    button.innerHTML = 'Tambah Pengguna'; // Kembalikan teks tombol
}

// Fungsi validasi form
function validateForm() {
    const namaLengkap = document.getElementById('nama_lengkap').value.trim();
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    const levelUser = document.querySelector('input[name="level_user"]:checked');

    // Periksa apakah semua field terisi
    if (!namaLengkap || !username || !password || !levelUser) {
        Swal.fire({
            title: 'Oops!',
            text: 'Semua field wajib diisi!',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return false;
    }

    // Validasi panjang password minimal 8 karakter
    if (password.length < 8) {
        Swal.fire({
            title: 'Oops!',
            text: 'Password harus lebih dari 8 karakter!',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return false;
    }

    return true;
}

</script>



<?= $this->endSection() ?>
