<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Event</h1>

    <form id="eventForm" action="<?= site_url('superadmin/event/save') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
    <?= csrf_field(); ?>
        <div class="mb-4">
            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
            <input type="text" maxlength="255" id="nama_event" name="nama_event" autocomplete="off" placeholder="Masukkan Nama Event"
                   value="<?= old('nama_event') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
        </div>

        <div class="mb-4">
            <label for="kategori_acara" class="block text-sm font-medium text-gray-700">Kategori Acara</label>
            <select id="kategori_acara" name="kategori_acara" 
                    class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
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
            <input type="date" id="tanggal_event" name="tanggal_event" autocomplete="off"
                   value="<?= old('tanggal_event') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
        </div>

        <div class="mb-4">
            <label for="jam_event" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
            <input type="time" id="jam_event" name="jam_event" autocomplete="off"
                   value="<?= old('jam_event') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
        </div>

        <div class="mb-4">
            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi Acara</label>
            <textarea id="deskripsi_event" name="deskripsi_event" rows="4" autocomplete="off" placeholder="Masukkan Deskripsi Event"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"><?= old('deskripsi_event') ?></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Poster Acara <i>(Max 2MB)</i></label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneEvent">
                <input type="file" name="poster_event" id="posterEventInput" accept=".jpg,.jpeg,.png" class="hidden" >
                <div id="dropzoneEventContent" class="flex flex-col justify-center items-center space-y-2">
                    <!-- Ikon upload -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500" id="dropzoneText">Drop files here or click to upload (Max 2MB, PNG/JPG)</p>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
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
const dropzoneEvent = document.getElementById('dropzoneEvent');
const fileInputEvent = document.getElementById('posterEventInput');
const dropzoneText = document.getElementById('dropzoneText');

// Fungsi untuk menangani file yang diunggah
function handleFilesEvent(files) {
    if (files.length > 0) {
        const file = files[0];

        // Validasi jenis file berdasarkan ekstensi
        const allowedExtensions = ['png', 'jpg', 'jpeg'];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            Swal.fire({
                icon: 'error',
                title: 'Jenis File Tidak Valid!',
                text: `File poster hanya diperbolehkan berformat: ${allowedExtensions.join(', ').toUpperCase()}.`,
            });
            fileInputEvent.value = ''; // Reset file input
            resetDropzoneContent();
            return;
        }

        // Validasi ukuran file
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran File Terlalu Besar!',
                text: 'File poster acara harus memiliki ukuran maksimal 2MB.',
            });
            fileInputEvent.value = ''; // Reset file input
            resetDropzoneContent();
            return;
        }

        // Jika validasi berhasil
        dropzoneText.textContent = `File Terpilih: ${file.name}`;
        dropzoneText.classList.remove('text-gray-500');
        dropzoneText.classList.add('text-green-500');
    }
}

// Fungsi untuk mereset dropzone
function resetDropzoneContent() {
    dropzoneText.textContent = 'Drop files here or click to upload (Max 2MB, PNG/JPG)';
    dropzoneText.classList.add('text-gray-500');
    dropzoneText.classList.remove('text-green-500');
}

// Event Listener
dropzoneEvent.addEventListener('click', () => fileInputEvent.click());

fileInputEvent.addEventListener('change', () => handleFilesEvent(fileInputEvent.files));

dropzoneEvent.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzoneEvent.classList.add('bg-gray-100');
});

dropzoneEvent.addEventListener('dragleave', () => {
    dropzoneEvent.classList.remove('bg-gray-100');
});

dropzoneEvent.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzoneEvent.classList.remove('bg-gray-100');
    const files = e.dataTransfer.files;
    fileInputEvent.files = files;
    handleFilesEvent(files);
});

fileInputEvent.addEventListener('click', () => {
    resetDropzoneContent();
});



    document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault();

    const fileInput = document.getElementById('posterEventInput');
    const namaEvent = document.getElementById('nama_event').value;
    const kategoriAcara = document.getElementById('kategori_acara').value;
    const tanggalEvent = document.getElementById('tanggal_event').value;
    const jamEvent = document.getElementById('jam_event').value;
    const deskripsiEvent = document.getElementById('deskripsi_event').value;
    const formData = new FormData(this);

    // Validasi jika ada field yang kosong
    if (!namaEvent || !kategoriAcara || !tanggalEvent || !jamEvent || !deskripsiEvent || !fileInput.files.length) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Semua field wajib diisi!',
            confirmButtonText: 'OK'
        });
        return;
    }

    const today = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD

    // Validasi Tanggal Tidak Boleh Masa Lalu
    if (tanggalEvent < today) {
        Swal.fire({
            icon: 'error',
            title: 'Tanggal Tidak Valid!',
            text: 'Tidak boleh memilih tanggal masa lalu.',
            confirmButtonText: 'OK'
        });
        return;
    }

    const submitButton = document.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = 'Menyimpan... <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>';

    fetch('<?= site_url('superadmin/event/save') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Pastikan spinner tetap ada setelah penyimpanan berhasil
        submitButton.disabled = true;
        submitButton.innerHTML = 'Menyimpan... <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>';

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
                // Redirect setelah sukses
                window.location.href = '<?= site_url('superadmin/event/manage') ?>';
            });
        }
    })
    .catch(error => {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Simpan';

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
