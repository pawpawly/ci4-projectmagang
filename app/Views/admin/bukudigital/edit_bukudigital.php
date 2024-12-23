<?= $this->extend('admin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Buku Digital</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="editBukuDigitalForm" action="<?= site_url('admin/bukudigital/update') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
    <?= csrf_field(); ?>
        <input type="hidden" name="id_buku" value="<?= $bukudigital['ID_BUKU'] ?>">

        <div class="mb-4">
            <label for="judul_buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
            <input type="text" maxlength="255" id="judul_buku" name="judul_buku" autocomplete="off" placeholder="Masukkan judul buku"
                   value="<?= esc($bukudigital['JUDUL_BUKU']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
        </div>

        <div class="mb-4">
            <label for="penulis_buku" class="block text-sm font-medium text-gray-700">Penulis Buku</label>
            <input type="text" maxlength="255" id="penulis_buku" name="penulis_buku" autocomplete="off" placeholder="Masukkan penulis buku"
                   value="<?= esc($bukudigital['PENULIS_BUKU']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
        </div>

        <div class="mb-4">
            <label for="tahun_buku" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
            <input 
                type="text" maxlength="4" id="tahun_buku" name="tahun_buku" 
                class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none" 
                placeholder="Masukkan tahun terbit" value="<?= esc($bukudigital['TAHUN_BUKU']) ?>" pattern="\d*" 
                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" >
        </div>

        <div class="mb-4">
            <label for="sinopsis_buku" class="block text-sm font-medium text-gray-700">Sinopsis</label>
            <textarea id="sinopsis_buku" name="sinopsis_buku" rows="4" autocomplete="off" placeholder="Masukkan sinopsis"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"><?= esc($bukudigital['SINOPSIS_BUKU']) ?></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sampul Buku <i>(Max 2MB)</i> <p><i>(Abaikan Jika Tidak Mengganti Sampul Foto)</i></p></label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneSampul">
                <input type="file" name="sampul_buku" id="sampulBukuInput" accept=".jpg,.jpeg,.png" class="hidden">
                <div id="dropzoneContentSampul" class="flex flex-col justify-center items-center space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500">Drop files here or click to upload (Max 2MB, PNG/JPG)</p>
                </div>
            </div>
            <?php if ($bukudigital['SAMPUL_BUKU']): ?>
                <img src="<?= base_url('uploads/bukudigital/sampul/' . $bukudigital['SAMPUL_BUKU']) ?>" 
                     alt="Sampul Buku" class="w-24 h-24 mt-2 object-cover rounded-md">
            <?php endif; ?>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">File Buku <i>(Max 40MB)</i> <p><i>(Abaikan Jika Tidak Mengganti Buku)</i></p> </label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneFile">
                <input type="file" name="produk_buku" id="fileBukuInput" accept=".pdf" class="hidden">
                <div id="dropzoneContentFile" class="flex flex-col justify-center items-center space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500">Drop files here or click to upload (Max 40MB, PDF)</p>
                </div>
            </div>
            <?php if ($bukudigital['PRODUK_BUKU']): ?>
                <a href="<?= base_url('uploads/bukudigital/pdf/' . $bukudigital['PRODUK_BUKU']) ?>" target="_blank" class="text-blue-500 underline mt-2 block">View/Download PDF</a>
            <?php endif; ?>
        </div>
        
        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('admin/bukudigital/manage') ?>" 
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
               <button type="submit" id="submitButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 flex items-center justify-center">
    <span id="buttonText">Simpan</span> <!-- Teks tombol -->
    <!-- Spinner akan ditambahkan dinamis di sini -->
</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('editBukuDigitalForm');
    const submitButton = document.getElementById('submitButton');
    const buttonText = document.getElementById('buttonText'); // Ambil span untuk teks "Simpan"

    const spinner = `<svg class="animate-spin h-5 w-5 text-white ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>`;

    // Form Validation Before Submit
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const judulBuku = document.getElementById('judul_buku').value;
        const penulisBuku = document.getElementById('penulis_buku').value;
        const tahunBuku = document.getElementById('tahun_buku').value;
        const sinopsisBuku = document.getElementById('sinopsis_buku').value;

        // Validasi sebelum tombol diganti
        if (!judulBuku || !penulisBuku || !tahunBuku || !sinopsisBuku) {
            Swal.fire({
                title: 'Oops!',
                text: 'Semua field wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK',
            });
            return;  // Tidak lanjutkan proses jika ada field kosong
        }

        // Tampilkan spinner dan disable tombol saat form disubmit
        submitButton.disabled = true;
        buttonText.innerHTML = 'Menyimpan...'; // Ubah teks tombol
        submitButton.innerHTML = buttonText.innerHTML + spinner; // Tambahkan spinner di samping teks

        const formData = new FormData(form);

        fetch('<?= site_url('admin/bukudigital/update') ?>', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            // Jangan reset tombol setelah submit berhasil
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Buku digital berhasil diperbarui!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                }).then(() => {
                    window.location.href = '<?= site_url('admin/bukudigital/manage') ?>';
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            }
        })
        .catch(error => {
            // Reset tombol jika terjadi error saat submit
            submitButton.disabled = false;
            buttonText.innerHTML = 'Simpan'; // Reset teks tombol
            submitButton.innerHTML = buttonText.innerHTML; // Reset button inner HTML tanpa spinner
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan. Silakan coba lagi.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const sampulInput = document.getElementById('sampulBukuInput');
    const fileInput = document.getElementById('fileBukuInput');
    const dropzoneSampul = document.getElementById('dropzoneSampul');
    const dropzoneContentSampul = document.getElementById('dropzoneContentSampul');
    const dropzoneFile = document.getElementById('dropzoneFile');
    const dropzoneContentFile = document.getElementById('dropzoneContentFile');

    // Fungsi Reset Dropzone Content
    function resetDropzoneContent(textElement, labelContent) {
        textElement.textContent = labelContent;
        textElement.classList.add('text-gray-500');
        textElement.classList.remove('text-green-500');
    }

    // Fungsi Validasi File
    function validateFile(file, allowedTypes, sizeLimitMB) {
        const fileType = file.name.split('.').pop().toLowerCase(); // Ambil ekstensi file
        if (!allowedTypes.includes(fileType)) {
            Swal.fire({
                icon: 'error',
                title: 'Jenis File Tidak Valid',
                text: `Hanya file ${allowedTypes.join(', ')} yang diperbolehkan.`,
            });
            return false;
        }
        if (file.size > sizeLimitMB * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran File Terlalu Besar',
                text: `Ukuran file melebihi ${sizeLimitMB}MB!`,
            });
            return false;
        }
        return true;
    }

    // Fungsi Assign File ke Input
    function assignFileToInput(file, inputElement) {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        inputElement.files = dataTransfer.files;
    }

    // Dropzone Handler
    function setupDropzone(dropzone, inputElement, textElement, allowedTypes, sizeLimitMB, labelContent) {
        dropzone.addEventListener('click', () => inputElement.click());

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('bg-gray-200');
        });

        dropzone.addEventListener('dragleave', () => dropzone.classList.remove('bg-gray-200'));

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('bg-gray-200');

            const file = e.dataTransfer.files[0];
            if (file && validateFile(file, allowedTypes, sizeLimitMB)) {
                assignFileToInput(file, inputElement);
                textElement.textContent = `File Terpilih: ${file.name}`;
                textElement.classList.remove('text-gray-500');
                textElement.classList.add('text-green-500');
            } else {
                resetDropzoneContent(textElement, labelContent);
            }
        });

        inputElement.addEventListener('change', () => {
            const file = inputElement.files[0];
            if (file && validateFile(file, allowedTypes, sizeLimitMB)) {
                textElement.textContent = `File Terpilih: ${file.name}`;
                textElement.classList.remove('text-gray-500');
                textElement.classList.add('text-green-500');
            } else {
                resetDropzoneContent(textElement, labelContent);
                inputElement.value = '';
            }
        });

        inputElement.addEventListener('click', (e) => {
            e.target.value = ''; // Reset input file saat klik untuk memastikan event 'change' dipicu.
            resetDropzoneContent(textElement, labelContent); // Reset dropzone saat batal.
        });
    }

    // Setup Dropzone Sampul Buku
    setupDropzone(
        dropzoneSampul,
        sampulInput,
        dropzoneContentSampul.querySelector('p'),
        ['png', 'jpg', 'jpeg'],
        2,
        'Drop files here or click to upload (Max 2MB, PNG/JPG)'
    );

    // Setup Dropzone File Buku
    setupDropzone(
        dropzoneFile,
        fileInput,
        dropzoneContentFile.querySelector('p'),
        ['pdf'],
        40,
        'Drop files here or click to upload (Max 40MB, PDF)'
    );
});



</script>

<?= $this->endSection() ?>