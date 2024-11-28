<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Berita</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="editBeritaForm" action="<?= site_url('superadmin/berita/update') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
    <?= csrf_field(); ?>
        <input type="hidden" name="id_berita" value="<?= $berita['ID_BERITA'] ?>">

        <div class="mb-4">
            <label for="nama_berita" class="block text-sm font-medium text-gray-700">Nama Berita</label>
            <input type="text" maxlength="255" id="nama_berita" name="nama_berita" autocomplete="off"
                   value="<?= esc($berita['NAMA_BERITA']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                   placeholder="Masukkan nama berita">
        </div>

        <div class="mb-4">
            <label for="deskripsi_berita" class="block text-sm font-medium text-gray-700">Deskripsi Berita</label>
            <textarea id="deskripsi_berita" name="deskripsi_berita" rows="4" autocomplete="off"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                      placeholder="Masukkan deskripsi berita"><?= esc($berita['DESKRIPSI_BERITA']) ?></textarea>
        </div>

        <div class="mb-4">
            <label for="sumber_berita" class="block text-sm font-medium text-gray-700">Sumber Berita</label>
            <input type="text" maxlength="255" id="sumber_berita" name="sumber_berita" autocomplete="off"
                   value="<?= esc($berita['SUMBER_BERITA']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   placeholder="Masukkan sumber berita">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Berita <i>(Max 2MB)</i><p><i>(Abaikan Jika Tidak Mengganti Foto)</i></p> </label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneEdit">
                <input type="file" name="foto_berita" id="fotoBeritaEdit" accept=".jpg,.jpeg,.png" class="hidden">
                <div id="dropzoneContentEdit" class="flex flex-col justify-center items-center space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500">Drop files here or click to upload</p>
                </div>
            </div>
            <?php if ($berita['FOTO_BERITA']): ?>
                <img src="<?= base_url('uploads/berita/' . $berita['FOTO_BERITA']) ?>" alt="Foto Berita" class="w-24 h-24 mt-2 object-cover rounded-md">
            <?php endif; ?>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/berita/manage') ?>" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 flex items-center justify-center">
                Simpan
                <span id="spinnerContainer" class="ml-2 hidden"></span>
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('editBeritaForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Cegah submit form secara default

    const submitButton = document.querySelector('button[type="submit"]');
    const spinner = `<svg class="animate-spin h-5 w-5 text-white ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
    </svg>`;

    if (!validateForm()) return; // Cek form validitas

    submitButton.disabled = true;
    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
    submitButton.innerHTML = `Menyimpan... ${spinner}`;

    const formData = new FormData(this);

    fetch('<?= site_url('superadmin/berita/update') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({ title: 'Berhasil!', text: data.message, icon: 'success' }).then(() => {
                window.location.href = data.redirect;
            });
        } else {
            Swal.fire({ title: 'Gagal!', text: data.message, icon: 'error' });
            resetButton(submitButton);
        }
    })
    .catch(error => {
        Swal.fire({ title: 'Error!', text: 'Terjadi kesalahan pada server.', icon: 'error' });
        resetButton(submitButton);
    });
});

function resetButton(button) {
    button.disabled = false;
    button.classList.remove('opacity-50', 'cursor-not-allowed');
    button.innerHTML = 'Simpan';
}

function validateForm() {
    const namaBerita = document.getElementById('nama_berita').value.trim();
    const deskripsiBerita = document.getElementById('deskripsi_berita').value.trim();
    const sumberBerita = document.getElementById('sumber_berita').value.trim();
    if (!namaBerita || !deskripsiBerita || !sumberBerita) {
        Swal.fire({ title: 'Oops!', text: 'Semua field wajib diisi!', icon: 'warning' });
        return false;
    }
    return true;
}

// Foto Berita Dropzone Handler
const dropzoneEdit = document.getElementById('dropzoneEdit');
const fileInputEdit = document.getElementById('fotoBeritaEdit');
const dropzoneContentEdit = document.getElementById('dropzoneContentEdit');

function handleFilesEdit(files) {
    const dropzoneText = dropzoneContentEdit.querySelector('p');
    if (files.length > 0) {
        const file = files[0];
        if (file.size > 2 * 1024 * 1024) { // Max 2MB
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file Berita melebihi 2MB',
                text: 'Silakan unggah file dengan ukuran maksimal 2MB.',
            });
            fileInputEdit.value = '';
            dropzoneText.textContent = 'Drop files here or click to upload';
            dropzoneText.classList.remove('text-green-500');
            dropzoneText.classList.add('text-gray-500');
        } else {
            dropzoneText.textContent = `File Terpilih: ${file.name}`;
            dropzoneText.classList.remove('text-gray-500');
            dropzoneText.classList.add('text-green-500');
        }
    } else {
        dropzoneText.textContent = 'Drop files here or click to upload';
        dropzoneText.classList.remove('text-green-500');
        dropzoneText.classList.add('text-gray-500');
    }
}

dropzoneEdit.addEventListener('click', () => fileInputEdit.click());
fileInputEdit.addEventListener('change', () => handleFilesEdit(fileInputEdit.files));

dropzoneEdit.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzoneEdit.classList.add('bg-gray-100');
});
dropzoneEdit.addEventListener('dragleave', () => {
    dropzoneEdit.classList.remove('bg-gray-100');
});
dropzoneEdit.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzoneEdit.classList.remove('bg-gray-100');
    const files = e.dataTransfer.files;
    fileInputEdit.files = files;
    handleFilesEdit(files);
});
</script>

<?= $this->endSection() ?>
