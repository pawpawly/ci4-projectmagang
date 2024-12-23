<?= $this->extend('admin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Event</h1>

    <form id="eventForm" action="<?= site_url('admin/event/update') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="id_event" value="<?= $event['ID_EVENT']; ?>">

        <div class="mb-4">
            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
            <input type="text" maxlength="255" id="nama_event" name="nama_event" autocomplete="off" placeholder="Masukkan Nama Event"
                value="<?= old('nama_event', $event['NAMA_EVENT']); ?>"
                class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
        </div>

        <div class="mb-4">
            <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori Acara</label>
            <select id="kategori_id" name="kategori_id"
                    class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
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
                class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"
                value="<?= date('Y-m-d', strtotime(old('tanggal_event', $event['TANGGAL_EVENT']))); ?>">
        </div>

        <div class="mb-4">
            <label for="jam_event" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
            <input type="time" id="jam_event" name="jam_event" autocomplete="off"
                class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"
                value="<?= old('jam_event', $event['JAM_EVENT']); ?>">
        </div>

        <div class="mb-4">
            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi Acara</label>
            <textarea id="deskripsi_event" name="deskripsi_event" rows="4" autocomplete="off" placeholder="Masukkan Deskripsi Event"
                class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"><?= old('deskripsi_event', $event['DEKSRIPSI_EVENT']); ?></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Poster Acara <i>(Max 2MB)</i><p><i>Abaikan jika tidak ingin mengganti poster</i></p></label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneEditEvent">
                <input type="file" name="foto_event" id="posterEventInputEdit" accept=".jpg,.jpeg,.png" class="hidden">
                <div id="dropzoneContentEditEvent" class="flex flex-col justify-center items-center space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500" id="dropzoneText">Drop files here or click to upload (Max 2MB, PNG/JPG)</p>
                </div>
            </div>
            <?php if (!empty($event['FOTO_EVENT'])): ?>
                <img src="<?= base_url('uploads/poster/' . $event['FOTO_EVENT']); ?>" alt="Poster Event" class="w-32 h-48 mt-2 object-cover rounded-md">
            <?php endif; ?>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('admin/event/manage'); ?>" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit" id="submitButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        const namaEvent = document.getElementById('nama_event').value;
        const kategoriAcara = document.getElementById('kategori_id').value;
        const tanggalEvent = document.getElementById('tanggal_event').value;
        const jamEvent = document.getElementById('jam_event').value;
        const deskripsiEvent = document.getElementById('deskripsi_event').value;

        // Get today's date in YYYY-MM-DD format
        const today = new Date().toISOString().split('T')[0];

        // Validasi Tanggal Tidak Boleh Masa Lalu
        if (tanggalEvent < today) {
            Swal.fire({
                icon: 'error',
                title: 'Tanggal Tidak Valid!',
                text: 'Tidak boleh memilih tanggal masa lalu.',
                confirmButtonText: 'OK'
            });
            return; // Prevent form submission
        }

        // Check if any required fields are empty
        if (!namaEvent || !kategoriAcara || !tanggalEvent || !jamEvent || !deskripsiEvent) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Semua field wajib diisi!',
                confirmButtonText: 'OK'
            });
            return; // Prevent form submission
        }

        const submitButton = document.getElementById('submitButton');
        const formData = new FormData(this);

        // Disable submit button and show loading spinner
        submitButton.disabled = true;
        submitButton.innerHTML = 'Menyimpan... <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>';

        fetch('<?= site_url('admin/event/update') ?>', {
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
                submitButton.disabled = false;
                submitButton.innerHTML = 'Simpan Perubahan';
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '<?= site_url('admin/event/manage') ?>';
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
            submitButton.disabled = false;
            submitButton.innerHTML = 'Simpan Perubahan';
            console.error('Error:', error);
        });
    });

    const dropzoneEditEvent = document.getElementById('dropzoneEditEvent');
const fileInputEventEdit = document.getElementById('posterEventInputEdit');
const dropzoneText = document.getElementById('dropzoneText');
const dropzoneContentEditEvent = document.getElementById('dropzoneContentEditEvent');

// Fungsi untuk menangani file yang diunggah
function handleFilesEventEdit(files) {
    if (files.length > 0) {
        const file = files[0];

        // Validasi jenis file
        const allowedExtensions = ['png', 'jpg', 'jpeg'];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            Swal.fire({
                icon: 'error',
                title: 'Jenis File Tidak Valid!',
                text: `Hanya file dengan format ${allowedExtensions.join(', ').toUpperCase()} yang diperbolehkan.`,
            });
            fileInputEventEdit.value = ''; // Reset file input
            resetDropzoneContent(); // Reset tampilan dropzone
            return;
        }

        // Validasi ukuran file
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file terlalu besar!',
                text: 'Silakan unggah file dengan ukuran maksimal 2MB.',
            });
            fileInputEventEdit.value = ''; // Reset file input
            resetDropzoneContent(); // Reset tampilan dropzone
            return;
        }

        // Jika validasi berhasil
        dropzoneText.textContent = `File Terpilih: ${file.name}`;
        dropzoneText.classList.remove('text-gray-500');
        dropzoneText.classList.add('text-green-500');
    } else {
        resetDropzoneContent();
    }
}

// Fungsi untuk mereset dropzone
function resetDropzoneContent() {
    dropzoneText.textContent = 'Drop files here or click to upload (Max 2MB, PNG/JPG)';
    dropzoneText.classList.add('text-gray-500');
    dropzoneText.classList.remove('text-green-500');
}

// Event listeners
dropzoneEditEvent.addEventListener('click', () => fileInputEventEdit.click());

fileInputEventEdit.addEventListener('change', () => handleFilesEventEdit(fileInputEventEdit.files));

dropzoneEditEvent.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzoneEditEvent.classList.add('bg-gray-100');
});

dropzoneEditEvent.addEventListener('dragleave', () => {
    dropzoneEditEvent.classList.remove('bg-gray-100');
});

dropzoneEditEvent.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzoneEditEvent.classList.remove('bg-gray-100');
    const files = e.dataTransfer.files;
    fileInputEventEdit.files = files;
    handleFilesEventEdit(files);
});

fileInputEventEdit.addEventListener('click', () => {
    resetDropzoneContent();
});

</script>

<?= $this->endSection() ?>
