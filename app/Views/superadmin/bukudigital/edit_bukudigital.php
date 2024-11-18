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
        <input type="hidden" name="id_buku" value="<?= $bukudigital['ID_BUKU'] ?>">

        <div class="mb-4">
            <label for="judul_buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
            <input type="text" id="judul_buku" name="judul_buku" autocomplete="off"
                   value="<?= esc($bukudigital['JUDUL_BUKU']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        <div class="mb-4">
            <label for="penulis_buku" class="block text-sm font-medium text-gray-700">Penulis Buku</label>
            <input type="text" id="penulis_buku" name="penulis_buku" autocomplete="off"
                   value="<?= esc($bukudigital['PENULIS_BUKU']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        <div class="mb-4">
            <label for="tahun_buku" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
            <input type="text" id="tahun_buku" name="tahun_buku" autocomplete="off"
                   value="<?= esc($bukudigital['TAHUN_BUKU']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>

        <div class="mb-4">
            <label for="sinopsis_buku" class="block text-sm font-medium text-gray-700">Sinopsis</label>
            <textarea id="sinopsis_buku" name="sinopsis_buku" rows="4" autocomplete="off"
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
            <button type="submit" 
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('editBukuDigitalForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('<?= site_url('superadmin/bukudigital/update') ?>', {
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
                window.location.href = data.redirect;
            });
        } else {
            // Check if there are specific validation errors
            if (data.errors) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Semua field wajib diisi!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
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

document.addEventListener('DOMContentLoaded', () => {
    // Drop zone for Sampul Buku
    const dropzoneSampul = document.getElementById('dropzoneSampul');
    const sampulBukuInput = document.getElementById('sampulBukuInput');
    const dropzoneContentSampul = document.getElementById('dropzoneContentSampul');

    dropzoneSampul.addEventListener('click', () => sampulBukuInput.click());
    sampulBukuInput.addEventListener('change', () => handleFiles(dropzoneContentSampul, sampulBukuInput.files));
    dropzoneSampul.addEventListener('dragover', (e) => handleDragOver(e, dropzoneSampul));
    dropzoneSampul.addEventListener('drop', (e) => handleDrop(e, dropzoneContentSampul, sampulBukuInput));

    // Drop zone for File Buku
    const dropzoneFile = document.getElementById('dropzoneFile');
    const fileBukuInput = document.getElementById('fileBukuInput');
    const dropzoneContentFile = document.getElementById('dropzoneContentFile');

    dropzoneFile.addEventListener('click', () => fileBukuInput.click());
    fileBukuInput.addEventListener('change', () => handleFiles(dropzoneContentFile, fileBukuInput.files));
    dropzoneFile.addEventListener('dragover', (e) => handleDragOver(e, dropzoneFile));
    dropzoneFile.addEventListener('drop', (e) => handleDrop(e, dropzoneContentFile, fileBukuInput));

    // Common drop zone functions
    function handleFiles(contentDiv, files) {
        if (files.length > 0) {
            contentDiv.innerHTML = `<p class="text-sm text-green-500">File Terpilih: ${files[0].name}</p>`;
        } else {
            contentDiv.innerHTML = '<p class="text-sm text-gray-500">Drop files here or click to upload</p>';
        }
    }

    function handleDragOver(e, dropzone) {
        e.preventDefault();
        dropzone.classList.add('bg-gray-100');
    }

    function handleDrop(e, contentDiv, fileInput) {
        e.preventDefault();
        const files = e.dataTransfer.files;
        fileInput.files = files;
        handleFiles(contentDiv, files);
    }
});
</script>

<?= $this->endSection() ?>
