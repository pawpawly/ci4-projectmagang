<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Buku Digital</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form id="editBukuDigitalForm" action="<?= site_url('superadmin/bukudigital/update') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
    <?= csrf_field(); ?>
        <input type="hidden" name="id_buku" value="<?= $bukudigital['ID_BUKU'] ?>">

        <div class="mb-4">
            <label for="judul_buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
            <input type="text" maxlength="255" id="judul_buku" name="judul_buku" autocomplete="off" placeholder="Masukkan judul buku"
                   value="<?= esc($bukudigital['JUDUL_BUKU']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        <div class="mb-4">
            <label for="penulis_buku" class="block text-sm font-medium text-gray-700">Penulis Buku</label>
            <input type="text" maxlength="255" id="penulis_buku" name="penulis_buku" autocomplete="off" placeholder="Masukkan penulis buku"
                   value="<?= esc($bukudigital['PENULIS_BUKU']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        <div class="mb-4">
            <label for="tahun_buku" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
            <input 
                type="text" maxlength="4" id="tahun_buku" name="tahun_buku" 
                class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                placeholder="Masukkan tahun terbit" value="<?= esc($bukudigital['TAHUN_BUKU']) ?>" pattern="\d*" 
                inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" >
        </div>

        <div class="mb-4">
            <label for="sinopsis_buku" class="block text-sm font-medium text-gray-700">Sinopsis</label>
            <textarea id="sinopsis_buku" name="sinopsis_buku" rows="4" autocomplete="off" placeholder="Masukkan sinopsis"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"><?= esc($bukudigital['SINOPSIS_BUKU']) ?></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sampul Buku (Foto) <i>Max 2MB</i></label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneSampul">
                <input type="file" name="sampul_buku" id="sampulBukuInput" accept=".jpg,.jpeg,.png" class="hidden">
                <div id="dropzoneContentSampul" class="flex flex-col justify-center items-center space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500">Drop files here or click to upload</p>
                </div>
            </div>
            <?php if ($bukudigital['SAMPUL_BUKU']): ?>
                <img src="<?= base_url('uploads/bukudigital/sampul/' . $bukudigital['SAMPUL_BUKU']) ?>" 
                     alt="Sampul Buku" class="w-24 h-24 mt-2 object-cover rounded-md">
            <?php endif; ?>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">File Buku (PDF) <i>Max 40MB</i></label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneFile">
                <input type="file" name="produk_buku" id="fileBukuInput" accept=".pdf" class="hidden">
                <div id="dropzoneContentFile" class="flex flex-col justify-center items-center space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500">Drop files here or click to upload</p>
                </div>
            </div>
            <?php if ($bukudigital['PRODUK_BUKU']): ?>
                <a href="<?= base_url('uploads/bukudigital/pdf/' . $bukudigital['PRODUK_BUKU']) ?>" target="_blank" class="text-blue-500 underline mt-2 block">View/Download PDF</a>
            <?php endif; ?>
        </div>
        
        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/bukudigital/manage') ?>" 
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

        fetch('<?= site_url('superadmin/bukudigital/update') ?>', {
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
                    window.location.href = '<?= site_url('superadmin/bukudigital/manage') ?>';
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



// Handler untuk Dropzone Sampul Buku dan Produk Buku
document.addEventListener('DOMContentLoaded', () => {
    // Dropzone untuk Sampul Buku (maks 2MB)
    const dropzoneSampul = document.getElementById('dropzoneSampul');
    const sampulBukuInput = document.getElementById('sampulBukuInput');
    const dropzoneContentSampul = document.getElementById('dropzoneContentSampul');

    dropzoneSampul.addEventListener('click', () => sampulBukuInput.click());
    sampulBukuInput.addEventListener('change', () => {
        const file = sampulBukuInput.files[0];
        const textElement = dropzoneContentSampul.querySelector('p');
        if (!file) {
            resetDropzoneContent(textElement);
        } else if (file.size > 2 * 1024 * 1024) { // 2MB limit for Sampul Buku
            Swal.fire({
                icon: 'error',
                title: 'Ukuran Sampul Buku Terlalu Besar',
                text: 'Silakan unggah file dengan ukuran maksimal 2MB.',
            });
            sampulBukuInput.value = ''; // Reset file input
            resetDropzoneContent(textElement);
        } else {
            textElement.textContent = `File Terpilih: ${file.name}`;
            textElement.classList.remove('text-gray-500');
            textElement.classList.add('text-green-500');
        }
    });

    // Dropzone untuk Produk Buku (maks 40MB)
    const dropzoneFile = document.getElementById('dropzoneFile');
    const fileBukuInput = document.getElementById('fileBukuInput');
    const dropzoneContentFile = document.getElementById('dropzoneContentFile');

    dropzoneFile.addEventListener('click', () => fileBukuInput.click());
    fileBukuInput.addEventListener('change', () => {
        const file = fileBukuInput.files[0];
        const textElement = dropzoneContentFile.querySelector('p');
        if (!file) {
            resetDropzoneContent(textElement);
        } else if (file.size > 40 * 1024 * 1024) { // 40MB limit for Produk Buku
            Swal.fire({
                icon: 'error',
                title: 'Ukuran File Produk Buku Terlalu Besar',
                text: 'Silakan unggah file dengan ukuran maksimal 40MB.',
            });
            fileBukuInput.value = ''; // Reset file input
            resetDropzoneContent(textElement);
        } else {
            textElement.textContent = `File Terpilih: ${file.name}`;
            textElement.classList.remove('text-gray-500');
            textElement.classList.add('text-green-500');
        }
    });

    // Fungsi untuk reset konten dropzone
    function resetDropzoneContent(textElement) {
        textElement.textContent = 'Drop files here or click to upload';
        textElement.classList.add('text-gray-500');
        textElement.classList.remove('text-green-500');
    }
});

</script>

<?= $this->endSection() ?>
