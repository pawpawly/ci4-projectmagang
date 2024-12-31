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
    <input type="text" id="tanggal_event" name="tanggal_event" 
           placeholder="Pilih Tanggal" 
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
                <input type="file" name="poster_event" id="posterEventInput" accept=".jpg,.jpeg,.png" class="hidden">
                <div id="dropzoneEventContent" class="flex flex-col justify-center items-center space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500" id="dropzoneText">Drop files here or click to upload (Max 2MB, PNG/JPG)</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/event/manage'); ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>


</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
// Dropzone Setup
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

// Fungsi untuk mereset konten dropzone
function resetDropzoneContent() {
    dropzoneText.textContent = 'Drop files here or click to upload (Max 2MB, PNG/JPG)';
    dropzoneText.classList.add('text-gray-500');
    dropzoneText.classList.remove('text-green-500');
}

// Event Listener untuk dropzone
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

flatpickr("#tanggal_event", {
    enableTime: true,        // Aktifkan pilihan waktu
    dateFormat: "Y-m-d H:i", // Format tanggal dan waktu
    minDate: "today",        // Tanggal minimal hari ini
});

document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#tanggal_event", {
        dateFormat: "d-m-Y", // Format tanggal (YYYY-MM-DD)
        minDate: "today",    // Batasi tanggal ke hari ini dan setelahnya
        onChange: function (selectedDates, dateStr, instance) {
            // Validasi tambahan (jika diperlukan)
            if (new Date(dateStr) < new Date()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal Tidak Valid!',
                    text: 'Tidak boleh memilih tanggal masa lalu.',
                    confirmButtonText: 'OK'
                });
                instance.clear(); // Hapus nilai dari input
            }
        }
    });
});


document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault();

    const fileInput = document.getElementById('posterEventInput');
    const namaEvent = document.getElementById('nama_event').value;
    const kategoriAcara = document.getElementById('kategori_acara').value;
    const tanggalEvent = document.getElementById('tanggal_event').value;
    const jamEvent = document.getElementById('jam_event').value;
    const deskripsiEvent = document.getElementById('deskripsi_event').value;
    const submitButton = document.querySelector('button[type="submit"]');
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

// Validasi input tanggal
document.getElementById('tanggal_event').addEventListener('change', function (e) {
    const selectedDate = this.value; // Ambil nilai input tanggal
    const today = new Date().toISOString().split('T')[0]; // Tanggal hari ini dalam format YYYY-MM-DD

    // Periksa jika tanggal belum lengkap (panjang format YYYY-MM-DD adalah 10 karakter)
    if (selectedDate.length < 10) {
        return; // Jangan lakukan validasi jika tanggal belum lengkap
    }

    // Validasi: Tanggal tidak boleh di masa lalu
    if (selectedDate < today) {
        Swal.fire({
            icon: 'error',
            title: 'Tanggal Tidak Valid!',
            text: 'Tidak boleh memilih tanggal masa lalu.',
            confirmButtonText: 'OK'
        }).then(() => {
            this.value = ''; // Kosongkan nilai input
            this.focus();    // Fokus kembali ke input tanggal
        });
    }
});


    // Disable tombol dan tampilkan spinner saat menyimpan
    submitButton.disabled = true;
    submitButton.innerHTML = 'Menyimpan... <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>';

    // Proses pengiriman data
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
            // Jika gagal validasi
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: data.message,
                confirmButtonText: 'OK'
            });
            // Pulihkan tombol
            submitButton.disabled = false;
            submitButton.innerHTML = 'Simpan';
        } else {
            // Jika berhasil
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
        // Jika terjadi kesalahan server
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan pada server.',
            confirmButtonText: 'OK'
        });
        // Pulihkan tombol
        submitButton.disabled = false;
        submitButton.innerHTML = 'Simpan';
    });
});
</script>

<?= $this->endSection() ?>