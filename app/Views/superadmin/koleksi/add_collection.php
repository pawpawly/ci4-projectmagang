<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Koleksi</h1>

    <form id="koleksiForm" action="<?= site_url('superadmin/koleksi/save') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nama_koleksi" class="block text-sm font-medium text-gray-700">Nama Koleksi</label>
            <input type="text" id="nama_koleksi" name="nama_koleksi" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   value="<?= old('nama_koleksi') ?>">
        </div>

        <div class="mb-4">
            <label for="kategori_koleksi" class="block text-sm font-medium text-gray-700">Kategori Koleksi</label>
            <select id="kategori_koleksi" name="kategori_koleksi"
                    class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
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
            <textarea id="deskripsi_koleksi" name="deskripsi_koleksi" rows="4" autocomplete="off"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= old('deskripsi_koleksi') ?></textarea>
        </div>

        <div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Koleksi</label>
    <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneKoleksi">
        <input type="file" name="foto_koleksi" id="fotoKoleksi" accept=".jpg,.jpeg,.png" class="hidden" required>
        <div id="dropzoneKoleksiContent" class="flex flex-col justify-center items-center space-y-2">
            <!-- Ikon upload -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
            </svg>
            <p class="text-sm text-gray-500">Drop files here or click to upload</p>
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

        const formData = new FormData(this);

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
        });
    });

    // Ambil elemen dropzone dan input file
const dropzoneKoleksi = document.getElementById('dropzoneKoleksi');
const fileInputKoleksi = document.getElementById('fotoKoleksi');
const dropzoneKoleksiContent = document.getElementById('dropzoneKoleksiContent');

// Fungsi untuk menampilkan file yang diunggah
function handleFilesKoleksi(files) {
    if (files.length > 0) {
        dropzoneKoleksiContent.innerHTML = `<p class="text-sm text-green-500">File Terpilih: ${files[0].name}</p>`;
    } else {
        dropzoneKoleksiContent.innerHTML = '<p class="text-sm text-gray-500">Drop files here or click to upload</p>';
    }
}

// Klik pada dropzone membuka file input
dropzoneKoleksi.addEventListener('click', () => fileInputKoleksi.click());

// Update file yang dipilih melalui file input
fileInputKoleksi.addEventListener('change', () => handleFilesKoleksi(fileInputKoleksi.files));

// Tangani event drag-and-drop
dropzoneKoleksi.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzoneKoleksi.classList.add('bg-gray-100'); // Tambahkan efek hover
});

dropzoneKoleksi.addEventListener('dragleave', () => {
    dropzoneKoleksi.classList.remove('bg-gray-100'); // Hapus efek hover
});

dropzoneKoleksi.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzoneKoleksi.classList.remove('bg-gray-100'); // Hapus efek hover
    const files = e.dataTransfer.files; // Ambil file dari drop
    fileInputKoleksi.files = files; // Set file input
    handleFilesKoleksi(files); // Update tampilan
});
</script>

<style>
    textarea:focus, input:focus, select:focus {
        border-color: #ecc94b;
        outline: none;
        box-shadow: 0 0 0 2px rgba(236, 201, 75, 0.5);
    }
</style>

<?= $this->endSection() ?>
