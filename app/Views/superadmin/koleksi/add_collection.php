<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Koleksi</h1>

    <form id="koleksiForm" action="<?= site_url('superadmin/koleksi/save') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
    <?= csrf_field(); ?>
        <div class="mb-4">
            <label for="nama_koleksi" class="block text-sm font-medium text-gray-700">Nama Koleksi</label>
            <input type="text" maxlength="255" id="nama_koleksi" name="nama_koleksi" autocomplete="off" placeholder="Masukkan Nama Koleksi"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"
                   value="<?= old('nama_koleksi') ?>">
        </div>

        <div class="mb-4">
            <label for="kategori_koleksi" class="block text-sm font-medium text-gray-700">Kategori Koleksi</label>
            <select id="kategori_koleksi" name="kategori_koleksi"
                    class="mt-1 px-4 py-2 w-full border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none">
                <option value="">Pilih Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['ID_KKOLEKSI'] ?>" <?= old('kategori_koleksi') == $category['ID_KKOLEKSI'] ? 'selected' : '' ?>>
                        <?= esc($category['KATEGORI_KKOLEKSI']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="deskripsi_koleksi" class="block text-sm font-medium text-gray-700">Deskripsi Koleksi</label>
            <textarea id="deskripsi_koleksi" name="deskripsi_koleksi" rows="4" autocomplete="off" placeholder="Masukkan Deskripsi Koleksi"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none"><?= old('deskripsi_koleksi') ?></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Koleksi <i>(Max 2MB)</i></label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneKoleksi">
                <input type="file" name="foto_koleksi" id="fotoKoleksi" accept=".jpg,.jpeg,.png" class="hidden">
                <div id="dropzoneKoleksiContent" class="flex flex-col justify-center items-center space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500">Drop files here or click to upload (Max 2MB, PNG/JPG)</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/koleksi/manage'); ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('koleksiForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Mencegah form dikirim langsung

    const submitButton = document.querySelector('button[type="submit"]');
    const formData = new FormData(this);

    // Validasi: Periksa apakah semua field terisi
    const namaKoleksi = document.getElementById('nama_koleksi').value.trim();
    const kategoriKoleksi = document.getElementById('kategori_koleksi').value.trim();
    const deskripsiKoleksi = document.getElementById('deskripsi_koleksi').value.trim();
    const fotoKoleksi = document.getElementById('fotoKoleksi').files.length > 0;

    // Jika ada field yang kosong, tampilkan SweetAlert2 dengan ikon warning
    if (!namaKoleksi || !kategoriKoleksi || !deskripsiKoleksi || !fotoKoleksi) {
        Swal.fire({
            title: 'Oops!',
            text: 'Semua field wajib diisi!',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return; // Batalkan proses lebih lanjut
    }

    // Disable submit button and show loading spinner
    submitButton.disabled = true;
    submitButton.innerHTML = 'Menyimpan... <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>';

    fetch('<?= site_url('superadmin/koleksi/save') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Berhasil!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '<?= site_url('superadmin/koleksi/manage') ?>';
            });
        } else {
            Swal.fire({
                title: 'Oops!',
                text: 'Semua field wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan pada server.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.error('Error:', error);
    })
    .finally(() => {
        // Setelah proses selesai, biarkan tombol tetap disable dan spinner tetap aktif
        // Tidak mereset status tombol kembali ke "Simpan"
    });
});

const dropzoneKoleksi = document.getElementById('dropzoneKoleksi');
const fileInputKoleksi = document.getElementById('fotoKoleksi');
const dropzoneKoleksiContent = document.getElementById('dropzoneKoleksiContent');

function handleFilesKoleksi(files) {
    if (files.length > 0) {
        const file = files[0];
        const fileName = file.name;

        // Validasi jenis file
        const allowedExtensions = ['png', 'jpg', 'jpeg'];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            Swal.fire({
                icon: 'error',
                title: 'Jenis File Tidak Valid!',
                text: `Hanya file dengan format ${allowedExtensions.join(', ').toUpperCase()} yang diperbolehkan.`,
            });
            resetDropzone();
            return;
        }

        // Validasi ukuran file (maksimal 2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran File Terlalu Besar!',
                text: 'Silakan unggah file dengan ukuran maksimal 2MB.',
            });
            resetDropzone();
            return;
        }

        // Tetapkan file ke elemen input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInputKoleksi.files = dataTransfer.files;

        // Jika validasi berhasil
        dropzoneKoleksiContent.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
            </svg>
            <p class="text-sm text-green-500">File Terpilih: ${fileName}</p>
        `;
        dropzoneKoleksi.classList.add('bg-green-100');
    } else {
        resetDropzone();
    }
}

function resetDropzone() {
    fileInputKoleksi.value = '';
    dropzoneKoleksiContent.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
        </svg>
        <p class="text-sm text-gray-500">Drop files here or click to upload (Max 2MB, PNG/JPG)</p>
    `;
    dropzoneKoleksi.classList.remove('bg-green-100');
}

// Event listeners
dropzoneKoleksi.addEventListener('click', () => {
    fileInputKoleksi.click();
});

fileInputKoleksi.addEventListener('change', (event) => {
    handleFilesKoleksi(event.target.files);
});

dropzoneKoleksi.addEventListener('dragover', (event) => {
    event.preventDefault();
    dropzoneKoleksi.classList.add('bg-green-50');
});

dropzoneKoleksi.addEventListener('dragleave', () => {
    dropzoneKoleksi.classList.remove('bg-green-50');
});

dropzoneKoleksi.addEventListener('drop', (event) => {
    event.preventDefault();
    dropzoneKoleksi.classList.remove('bg-green-50');

    const files = event.dataTransfer.files;

    // Tetapkan file ke elemen input
    const dataTransfer = new DataTransfer();
    for (const file of files) {
        dataTransfer.items.add(file);
    }
    fileInputKoleksi.files = dataTransfer.files;

    handleFilesKoleksi(files);
});


</script>

<?= $this->endSection() ?>
