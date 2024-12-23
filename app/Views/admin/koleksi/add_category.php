<?= $this->extend('admin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Kategori Koleksi</h1>

    <form id="categoryForm" action="<?= site_url('admin/koleksi/category/save') ?>" autocomplete="off" method="POST">
        <?= csrf_field(); ?>
        <div class="mb-4">
            <label for="kategori_kkoleksi" class="block text-sm font-medium text-gray-700">Kategori Koleksi</label>
            <input type="text" placeholder="Masukkan Nama Kategori Koleksi" id="kategori_kkoleksi" name="kategori_kkoleksi" autocomplete="off" maxlength="255"
                   value="<?= old('kategori_kkoleksi') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
        </div>

        <div class="mb-4">
            <label for="deskripsi_kkoleksi" class="block text-sm font-medium text-gray-700">Deskripsi Koleksi</label>
            <textarea id="deskripsi_kkoleksi" placeholder="Masukkan Deskripsi Kategori Koleksi" name="deskripsi_kkoleksi" rows="4" autocomplete="off" maxlength="1000"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"><?= old('deskripsi_kkoleksi') ?></textarea>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('admin/koleksi/category') ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit"
                    id="submitButton"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('categoryForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah form submit secara langsung

        const kategoriKoleksi = document.getElementById('kategori_kkoleksi').value;
        const deskripsiKoleksi = document.getElementById('deskripsi_kkoleksi').value;

        // Check if required fields are empty
        if (!kategoriKoleksi || !deskripsiKoleksi) {
            Swal.fire({
                title: 'Oops!',
                text: 'Semua field wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return; // Prevent form submission if fields are empty
        }

        const submitButton = document.getElementById('submitButton');  // Get the submit button
        const formData = new FormData(this);  // Prepare form data

        // Disable submit button and show loading spinner
        submitButton.disabled = true;
        submitButton.innerHTML = 'Menyimpan... <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>';

        fetch('<?= site_url('admin/koleksi/category/save') ?>', {
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
                    window.location.href = '<?= site_url('admin/koleksi/category') ?>';
                });
            } else {
                Swal.fire({
                    title: 'Oops!',
                    text: data.message,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                submitButton.disabled = false;  // Re-enable button if error
                submitButton.innerHTML = 'Simpan';  // Reset button text
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            submitButton.disabled = false;  // Re-enable button if error
            submitButton.innerHTML = 'Simpan';  // Reset button text
            console.error('Error:', error);
        });
    });
</script>

<?= $this->endSection() ?>
