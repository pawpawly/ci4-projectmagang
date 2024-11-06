<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Kategori Event</h1>

    <form id="categoryForm" autocomplete="off" action="<?= site_url('superadmin/event/category/save') ?>" method="POST">
        <div class="mb-4">
            <label for="kategori_kevent" class="block text-sm font-medium text-gray-700">Kategori Event</label>
            <input type="text" id="kategori_kevent" name="kategori_kevent" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="deskripsi_kevent" class="block text-sm font-medium text-gray-700">Deskripsi Event</label>
            <textarea id="deskripsi_kevent" name="deskripsi_kevent" rows="4" autocomplete="off"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/event/category') ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('categoryForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah submit form secara default

        const formData = new FormData(this);

        fetch('<?= site_url('superadmin/event/category/save') ?>', {
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
                    title: 'Oops!',
                    text: data.message,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
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
        });
    });
</script>

<?= $this->endSection() ?>
