<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Event</h1>

    <form id="eventForm" action="<?= site_url('superadmin/event/save') ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
            <input type="text" id="nama_event" name="nama_event"
                   value="<?= old('nama_event') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="kategori_acara" class="block text-sm font-medium text-gray-700">Kategori Acara</label>
            <select id="kategori_acara" name="kategori_acara"
                    class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                <option value="">Pilih Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['ID_KEVENT'] ?>" <?= old('kategori_acara') == $category['ID_KEVENT'] ? 'selected' : '' ?>>
                        <?= esc($category['KATEGORI_KEVENT']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal_event" class="block text-sm font-medium text-gray-700">Tanggal Event</label>
            <input type="date" id="tanggal_event" name="tanggal_event"
                   value="<?= old('tanggal_event') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="jam_event" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
            <input type="time" id="jam_event" name="jam_event"
                   value="<?= old('jam_event') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi Acara</label>
            <textarea id="deskripsi_event" name="deskripsi_event" rows="4"
                      class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= old('deskripsi_event') ?></textarea>
        </div>

        <div class="mb-4">
            <label for="poster_event" class="block text-sm font-medium text-gray-700">Poster Acara</label>
            <input type="file" id="poster_event" name="poster_event"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   accept=".jpg,.jpeg,.png">
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/event/manage'); ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault(); // Cegah submit default

        const formData = new FormData(this);

        fetch('<?= site_url('superadmin/event/save') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '<?= site_url('superadmin/event/manage') ?>';
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
                confirmButtonText: 'OK'
            });
        });
    });
</script>

<?= $this->endSection() ?>
