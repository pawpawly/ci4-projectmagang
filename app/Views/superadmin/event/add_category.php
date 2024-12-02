<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Kategori Event</h1>

    <form id="categoryForm" autocomplete="off" action="<?= site_url('superadmin/event/category/save') ?>" method="POST">
    <?= csrf_field(); ?>
        <div class="mb-4">
            <label for="kategori_kevent" class="block text-sm font-medium text-gray-700">Kategori Event</label>
            <input type="text" placeholder="Masukkan Nama Kategori Event" id="kategori_kevent" name="kategori_kevent" autocomplete="off" maxlength="255"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="deskripsi_kevent" class="block text-sm font-medium text-gray-700">Deskripsi Event</label>
            <textarea id="deskripsi_kevent" placeholder="Masukkan Deskripsi Kategori Event" name="deskripsi_kevent" rows="4" autocomplete="off" maxlength="1000"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
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
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('categoryForm');
    const submitButton = document.getElementById('submitButton');
    const spinner = `<svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>`;

    // Handle form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        // Get form data
        const kategoriKevent = document.getElementById('kategori_kevent').value.trim();
        const deskripsiKevent = document.getElementById('deskripsi_kevent').value.trim();

        // Validasi: Pastikan semua field terisi
        if (!kategoriKevent || !deskripsiKevent) {
            Swal.fire({
                title: 'Oops!',
                text: 'Semua field wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Disable the submit button and show spinner
        submitButton.disabled = true;
        submitButton.innerHTML = `Menyimpan... ${spinner}`;

        // Create FormData to send to the server
        const formData = new FormData(form);

        fetch('<?= site_url('superadmin/event/category/save') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Handle success
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
                // Handle failure: reset button to "Simpan"
                Swal.fire({
                    title: 'Oops!',
                    text: data.message,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Simpan';
                });
            }
        })
        .catch(error => {
            // Handle error: reset button to "Simpan"
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Simpan';
            });
            console.error('Error:', error);
        });
    });
});
</script>

<?= $this->endSection() ?>
