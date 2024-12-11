<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Kategori</h1>

    <form id="editCategoryForm" action="<?= site_url('superadmin/event/category/update') ?>" method="POST">
    <?= csrf_field(); ?>
        <input type="hidden" autocomplete="off" name="id_kevent" value="<?= $category['ID_KEVENT'] ?>">

        <div class="mb-4">
            <label for="kategori_kevent" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            <input type="text" maxlength="255" id="kategori_kevent" name="kategori_kevent" autocomplete="off" placeholder="Masukkan Nama Kategori Event"
                   value="<?= old('kategori_kevent', $category['KATEGORI_KEVENT']) ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
        </div>

        <div class="mb-4">
            <label for="deskripsi_kevent" class="block text-sm font-medium text-gray-700">Deskripsi Kategori</label>
            <textarea id="deskripsi_kevent" maxlength="1000" name="deskripsi_kevent" rows="4" autocomplete="off" placeholder="Masukkan Deksripsi Kategori Event"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"><?= old('deskripsi_kevent', $category['DESKRIPSI_KEVENT']) ?></textarea>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/event/category') ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit" id="submitButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                Simpan
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('editCategoryForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah submit form secara default

        const submitButton = document.getElementById('submitButton');
        const spinner = `<svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>`;

        // Ambil nilai form
        const kategoriKevent = document.getElementById('kategori_kevent').value.trim();
        const deskripsiKevent = document.getElementById('deskripsi_kevent').value.trim();

        // Validasi: Pastikan kedua field tidak kosong
        if (!kategoriKevent || !deskripsiKevent) {
            Swal.fire({
                title: 'Oops!',
                text: 'Semua field wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return; // Hentikan form submission
        }

        // Disable tombol submit dan tampilkan spinner
        submitButton.disabled = true;
        submitButton.innerHTML = `Menyimpan... ${spinner}`;

        const formData = new FormData(this);

        fetch('<?= site_url('superadmin/event/category/update') ?>', {
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
                    window.location.href = '<?= site_url('superadmin/event/category') ?>';
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Aktifkan kembali tombol submit dan reset teks
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Simpan';
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                // Aktifkan kembali tombol submit dan reset teks
                submitButton.disabled = false;
                submitButton.innerHTML = 'Simpan';
            });
            console.error('Error:', error);
        });
    });
</script>

<?= $this->endSection() ?>
