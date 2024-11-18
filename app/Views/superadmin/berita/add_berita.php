<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Berita</h1>

    <form id="tambahBeritaForm" autocomplete="off" action="<?= site_url('superadmin/berita/save') ?>" 
          method="POST" enctype="multipart/form-data" novalidate>
        <div class="mb-4">
            <label for="nama_berita" class="block text-sm font-medium text-gray-700">Nama Berita</label>
            <input type="text" id="nama_berita" name="nama_berita" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                   placeholder="Masukkan nama berita" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi_berita" class="block text-sm font-medium text-gray-700">Deskripsi Berita</label>
            <textarea id="deskripsi_berita" name="deskripsi_berita" rows="4" autocomplete="off"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                      placeholder="Masukkan deskripsi berita" required></textarea>
        </div>

        <div class="mb-4">
            <label for="sumber_berita" class="block text-sm font-medium text-gray-700">Sumber Berita</label>
            <input type="text" id="sumber_berita" name="sumber_berita" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                   placeholder="Masukkan sumber berita" required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Berita</label>
            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzone">
                <input type="file" name="foto_berita" id="fotoBerita" accept=".jpg,.jpeg,.png" class="hidden" required>
                <div id="dropzoneContent" class="flex flex-col justify-center items-center space-y-2">
                    <!-- Ikon upload -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
                    </svg>
                    <p class="text-sm text-gray-500">Drop files here or click to upload</p>
                </div>
            </div>
        </div>


        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/berita/manage') ?>" 
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('tambahBeritaForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah submit form secara default

        if (!validateForm()) {
            return; // Hentikan proses jika form tidak valid
        }

        const formData = new FormData(this);

        fetch('<?= site_url('superadmin/berita/save') ?>', {
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
                    text: 'Berita berhasil ditambahkan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '<?= site_url('superadmin/berita/manage'); ?>';
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message || 'Gagal menyimpan berita.',
                    icon: 'error',
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

    function validateForm() {
        const inputs = document.querySelectorAll('#tambahBeritaForm input, #tambahBeritaForm textarea');

        for (let input of inputs) {
            if (!input.checkValidity()) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Semua field wajib diisi!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return false;
            }
        }

        const fotoBerita = document.getElementById('foto_berita').files[0];
        if (!fotoBerita) {
            Swal.fire({
                title: 'Oops!',
                text: 'Foto berita wajib diunggah!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }

        return true;
    }

    // Ambil elemen dropzone dan input file
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fotoBerita');
const dropzoneContent = document.getElementById('dropzoneContent');

// Fungsi untuk menampilkan file yang diunggah
function handleFiles(files) {
    if (files.length > 0) {
        dropzoneContent.innerHTML = `<p class="text-sm text-green-500">File Terpilih: ${files[0].name}</p>`;
    } else {
        dropzoneContent.innerHTML = '<p class="text-sm text-gray-500">Drop files here to upload</p>';
    }
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

</script>

<?= $this->endSection() ?>
