<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Buku Digital</h1>

    <form id="tambahBukuDigitalForm" action="<?= site_url('superadmin/bukudigital/save') ?>" 
      method="POST" autocomplete="off" enctype="multipart/form-data" novalidate>
    <?= csrf_field(); ?>
    
    <div class="mb-4">
        <label for="judul_buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
        <input type="text" maxlength="255" id="judul_buku" name="judul_buku" 
               class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
               placeholder="Masukkan judul buku" required>
    </div>

    <div class="mb-4">
        <label for="penulis_buku" class="block text-sm font-medium text-gray-700">Penulis Buku</label>
        <input type="text" maxlength="255" id="penulis_buku" name="penulis_buku" 
               class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
               placeholder="Masukkan penulis buku" required>
    </div>

    <div class="mb-4">
    <label for="tahun_buku" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
    <input 
        type="text" 
        maxlength="4" 
        id="tahun_buku" 
        name="tahun_buku" 
        class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
        placeholder="Masukkan tahun terbit" 
        pattern="\d*" 
        inputmode="numeric" 
        required>
</div>

    <div class="mb-4">
        <label for="sinopsis_buku" class="block text-sm font-medium text-gray-700">Sinopsis</label>
        <textarea id="sinopsis_buku" name="sinopsis_buku" rows="4" 
                  class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                  placeholder="Masukkan sinopsis buku" required></textarea>
    </div>

<!-- Dropzone Sampul -->
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Sampul Buku <i>Max 2MB</i></label>
    <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneSampul">
        <input type="file" name="sampul_buku" id="sampulBukuInput" accept=".jpg,.jpeg,.png" class="hidden">
        <div id="dropzoneContentSampul" class="flex flex-col justify-center items-center space-y-2">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
            </svg>
            <p class="text-sm text-gray-500">Drop files here or click to upload</p>
        </div>
    </div>
</div>

<!-- Dropzone File Buku -->
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">File Buku (PDF) <i>Max 40MB</i></label>
    <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneFile">
        <input type="file" name="produk_buku" id="fileBukuInput" accept=".pdf" class="hidden">
        <div id="dropzoneContentFile" class="flex flex-col justify-center items-center space-y-2">
            <!-- SVG Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
            </svg>
            <p class="text-sm text-gray-500">Drop files here or click to upload</p>
        </div>
    </div>
</div>

    <div class="mt-6 flex justify-end space-x-4">
        <a href="<?= site_url('superadmin/bukudigital/manage') ?>" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
        <button type="submit" id="submitButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Simpan
        </button>
    </div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('tambahBukuDigitalForm');
    const sampulInput = document.getElementById('sampulBukuInput');
    const fileInput = document.getElementById('fileBukuInput');
    const submitButton = document.getElementById('submitButton');
    const spinner = `<svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>`;

    const dropzoneSampul = document.getElementById('dropzoneSampul');
    const dropzoneContentSampul = document.getElementById('dropzoneContentSampul');
    const dropzoneFile = document.getElementById('dropzoneFile');
    const dropzoneContentFile = document.getElementById('dropzoneContentFile');

    // Handle Sampul Dropzone
    dropzoneSampul.addEventListener('click', () => sampulInput.click());
    sampulInput.addEventListener('change', () => {
        const file = sampulInput.files[0];
        const textElement = dropzoneContentSampul.querySelector('p');
        if (!file) {
            resetDropzoneContent(textElement);
        } else if (file.size > 2 * 1024 * 1024) { // 2MB limit
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file Sampul Buku melebihi 2MB',
                text: 'Silakan unggah file dengan ukuran maksimal 2MB.',
            });
            sampulInput.value = ''; // Reset file input
            resetDropzoneContent(textElement);
        } else {
            textElement.textContent = `File Terpilih: ${file.name}`;
            textElement.classList.remove('text-gray-500');
            textElement.classList.add('text-green-500');
        }
    });

    // Handle File Dropzone
    dropzoneFile.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        const textElement = dropzoneContentFile.querySelector('p');
        if (!file) {
            resetDropzoneContent(textElement);
        } else if (file.size > 40 * 1024 * 1024) { // 40MB limit
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file Produk Buku melebihi 40MB',
                text: 'Silakan unggah file dengan ukuran maksimal 40MB.',
            });
            fileInput.value = ''; // Reset file input
            resetDropzoneContent(textElement);
        } else {
            textElement.textContent = `File Terpilih: ${file.name}`;
            textElement.classList.remove('text-gray-500');
            textElement.classList.add('text-green-500');
        }
    });

    // Reset Dropzone Content
    function resetDropzoneContent(textElement) {
        textElement.textContent = 'Drop files here or click to upload';
        textElement.classList.add('text-gray-500');
        textElement.classList.remove('text-green-500');
    }

    // Allow only numbers for Tahun Terbit
    document.getElementById('tahun_buku').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, ''); // Hanya izinkan angka
    });

    // Form Submission Validation
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const judulBuku = document.getElementById('judul_buku').value.trim();
        const penulisBuku = document.getElementById('penulis_buku').value.trim();
        const tahunBuku = document.getElementById('tahun_buku').value.trim();
        const sinopsisBuku = document.getElementById('sinopsis_buku').value.trim();

        if (!judulBuku || !penulisBuku || !tahunBuku || !sinopsisBuku || !sampulInput.files[0] || !fileInput.files[0]) {
            Swal.fire({
                title: 'Oops!',
                text: 'Semua field wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK',
            });
            return;
        }

        submitButton.disabled = true;
        submitButton.innerHTML = `Menyimpan... ${spinner}`;

        const formData = new FormData(form);
        fetch('<?= site_url('superadmin/bukudigital/save') ?>', {
            method: 'POST',
            body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Buku digital berhasil disimpan.',
                    icon: 'success',
                }).then(() => {
                    window.location.href = '<?= site_url('superadmin/bukudigital/manage') ?>';
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal menyimpan buku digital. Pastikan semua field terisi dengan benar.',
                    icon: 'error',
                });
            }
        })
        .catch((error) => {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
                icon: 'error',
            });
            console.error(error);
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Simpan';
        });
    });
});
</script>
<?= $this->endSection() ?>
