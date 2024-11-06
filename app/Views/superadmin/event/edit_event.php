<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Event</h1>

    <form id="eventForm" action="<?= site_url('superadmin/event/update') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="id_event" value="<?= $event['ID_EVENT']; ?>">

        <div class="mb-4">
            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
            <input type="text" id="nama_event" name="nama_event" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   value="<?= old('nama_event', $event['NAMA_EVENT']); ?>">
        </div>

        <div class="mb-4">
            <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori Acara</label>
            <select id="kategori_id" name="kategori_id"
                    class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                <option value="">Pilih Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['ID_KEVENT'] ?>"
                        <?= old('kategori_id', $event['ID_KEVENT']) == $category['ID_KEVENT'] ? 'selected' : '' ?>>
                        <?= esc($category['KATEGORI_KEVENT']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
    <label for="tanggal_event" class="block text-sm font-medium text-gray-700">Tanggal Event</label>
    <input type="date" id="tanggal_event" name="tanggal_event" autocomplete="off"
           class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
           value="<?= date('Y-m-d', strtotime(old('tanggal_event', $event['TANGGAL_EVENT']))); ?>">
</div>


        <div class="mb-4">
            <label for="jam_event" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
            <input type="time" id="jam_event" name="jam_event" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   value="<?= old('jam_event', $event['JAM_EVENT']); ?>">
        </div>

        <div class="mb-4">
            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi Acara</label>
            <textarea id="deskripsi_event" name="deskripsi_event" rows="4" autocomplete="off"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= old('deskripsi_event', $event['DEKSRIPSI_EVENT']); ?></textarea>
        </div>

        <div class="mb-4">
            <label for="foto_event" class="block text-sm font-medium text-gray-700">Poster Acara</label>
            <input type="file" id="foto_event" name="foto_event" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   accept=".jpg,.jpeg,.png">
            <?php if (!empty($event['FOTO_EVENT'])): ?>
                <img src="<?= base_url('uploads/poster/' . $event['FOTO_EVENT']); ?>"
                     alt="Poster Event" class="w-32 h-48 mt-2 object-cover rounded-md">
            <?php endif; ?>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/event/manage'); ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Cegah submit form default

        const formData = new FormData(this);

        fetch('<?= site_url('superadmin/event/update') ?>', {
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
            console.error('Error:', error);
        });
    });
</script>

<?= $this->endSection() ?>
