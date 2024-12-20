<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Berita</h1>

    <form id="tambahBeritaForm" 
      action="<?= site_url('superadmin/berita/save') ?>" 
      method="POST" 
      enctype="multipart/form-data" 
      autocomplete="off" 
      novalidate>
    <?= csrf_field(); ?>
        <div class="mb-4">
            <label for="nama_berita" class="block text-sm font-medium text-gray-700">Nama Berita</label>
            <input type="text" maxlength="255" id="nama_berita" name="nama_berita" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none" 
                   placeholder="Masukkan nama berita" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi_berita" class="block text-sm font-medium text-gray-700">Deskripsi Berita</label>
            <textarea id="deskripsi_berita" name="deskripsi_berita" rows="4" autocomplete="off"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none" 
                      placeholder="Masukkan deskripsi berita" required></textarea>
        </div>

        <div class="mb-4">
            <label for="sumber_berita" class="block text-sm font-medium text-gray-700">Sumber Berita</label>
            <input type="text" maxlength="255" id="sumber_berita" name="sumber_berita" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none" 
                   placeholder="Masukkan sumber berita" required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Berita <i>(Max 2MB)</i></label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzone">
            <input type="file" name="foto_berita" id="fotoBerita" accept=".jpg,.jpeg,.png" class="hidden" required>
                <div id="dropzoneContent" class="flex flex-col justify-center items-center space-y-2">
                    <!-- Ikon upload -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500">Drop files here or click to upload (Max 2MB, PNG/JPG)</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/berita/manage') ?>" 
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
               <button id="submitButton" type="submit" 
        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 flex items-center justify-center">
            Simpan
        </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Ambil elemen dropzone dan input file
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fotoBerita');
const dropzoneContent = document.getElementById('dropzoneContent');

// Fungsi untuk menampilkan file yang diunggah
function handleFiles(files) {
    if (files.length > 0) {
        const file = files[0];
        const allowedExtensions = ['png', 'jpg', 'jpeg']; // Format yang diperbolehkan
        const fileExtension = file.name.split('.').pop().toLowerCase(); // Ambil ekstensi file

        if (!allowedExtensions.includes(fileExtension)) {
            Swal.fire({
                icon: 'error',
                title: 'Format file tidak valid',
                text: `Hanya file dengan format ${allowedExtensions.join(', ')} yang diperbolehkan.`,
            });
            fileInput.value = ''; // Reset file input
            resetDropzoneContent(); // Reset tampilan dropzone
            return;
        }

        if (file.size > 2 * 1024 * 1024) { // Jika file lebih besar dari 2MB
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file melebihi 2MB',
                text: 'Silakan unggah file dengan ukuran maksimal 2MB.',
            });
            fileInput.value = ''; // Reset file input
            resetDropzoneContent(); // Reset tampilan dropzone
            return;
        }

        // Jika file valid, tampilkan nama file
        dropzoneContent.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
            </svg>
            <p class="text-sm text-green-500">File Terpilih: ${file.name}</p>
        `;
    } else {
        resetDropzoneContent(); // Reset jika tidak ada file
    }
}

// Fungsi untuk mereset konten dropzone
function resetDropzoneContent() {
    dropzoneContent.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
        </svg>
        <p class="text-sm text-gray-500">Drop files here or click to upload (Max 2MB, PNG/JPG)</p>
    `;
}

// Klik pada dropzone membuka file input
dropzone.addEventListener('click', () => fileInput.click());

// Update file yang dipilih melalui file input
fileInput.addEventListener('change', () => handleFiles(fileInput.files));

// Tangani event drag-and-drop
dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('bg-gray-100'); // Tambahkan efek hover
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('bg-gray-100'); // Hapus efek hover
});

dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('bg-gray-100'); // Hapus efek hover
    const files = e.dataTransfer.files; // Ambil file dari drop
    fileInput.files = files; // Set file input
    handleFiles(files); // Update tampilan
});


// Submit form
// Submit form
document.getElementById('tambahBeritaForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Mencegah submit form secara default

    const submitButton = document.getElementById('submitButton');
    const spinner = `<svg class="animate-spin h-5 w-5 text-white ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>`;

    // Validasi Form
    if (!validateForm()) {
        return; // Jika validasi gagal, hentikan proses
    }

    // Ubah tombol menjadi disabled, tambahkan spinner dan teks "Menyimpan..."
    submitButton.disabled = true;
    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
    submitButton.innerHTML = `Menyimpan... ${spinner}`;

    const formData = new FormData(this);

    fetch('<?= site_url('superadmin/berita/save') ?>', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berita berhasil ditambahkan',
                text: 'Berita baru telah berhasil disimpan.',
            }).then(() => {
                // Arahkan ke halaman "manage" setelah SweetAlert ditutup
                window.location.href = '<?= site_url('superadmin/berita/manage') ?>';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal menambahkan berita',
                text: 'Terjadi kesalahan saat menambahkan berita. Silakan coba lagi.',
            });
        }
    })
    .catch(error => {
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        submitButton.innerHTML = 'Simpan'; // Kembali ke "Simpan" jika terjadi error jaringan
        Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan',
            text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
        });
    });
});

function validateForm() {
    const nameInput = document.getElementById('nama_berita');
    const descInput = document.getElementById('deskripsi_berita');
    const sourceInput = document.getElementById('sumber_berita');
    const fileInput = document.getElementById('fotoBerita');

    // Validasi
    if (!nameInput.value || !descInput.value || !sourceInput.value || !fileInput.files[0]) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Semua field wajib diisi!',
        });
        return false;
    }
    return true;
}
</script>

<?= $this->endSection() ?>
