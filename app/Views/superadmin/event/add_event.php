<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Event</h1>

    <form id="eventForm" action="<?= site_url('superadmin/event/save') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
            <input type="text" id="nama_event" name="nama_event" autocomplete="off"
                   value="<?= old('nama_event') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="kategori_acara" class="block text-sm font-medium text-gray-700">Kategori Acara</label>
            <select id="kategori_acara" name="kategori_acara" 
                    class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
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
            <input type="date" id="tanggal_event" name="tanggal_event" autocomplete="off"
                   value="<?= old('tanggal_event') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="jam_event" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
            <input type="time" id="jam_event" name="jam_event" autocomplete="off"
                   value="<?= old('jam_event') ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi Acara</label>
            <textarea id="deskripsi_event" name="deskripsi_event" rows="4" autocomplete="off"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= old('deskripsi_event') ?></textarea>
        </div>

        <div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Poster Acara</label>
    <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneEvent">
        <input type="file" name="poster_event" id="posterEventInput" accept=".jpg,.jpeg,.png" class="hidden" required>
        <div id="dropzoneEventContent" class="flex flex-col justify-center items-center space-y-2">
            <!-- Ikon upload -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
            </svg>
            <p class="text-sm text-gray-500">Drop files here or click to upload</p>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault(); // Cegah submit default

        const formData = new FormData(this);

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
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            } else {
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
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
                confirmButtonText: 'OK'
            });
        });
    });

    // Ambil elemen dropzone dan input file
const dropzoneEvent = document.getElementById('dropzoneEvent');
const fileInputEvent = document.getElementById('posterEventInput');
const dropzoneEventContent = document.getElementById('dropzoneEventContent');

// Fungsi untuk menampilkan file yang diunggah
function handleFilesEvent(files) {
    if (files.length > 0) {
        dropzoneEventContent.innerHTML = `<p class="text-sm text-green-500">File Terpilih: ${files[0].name}</p>`;
    } else {
        dropzoneEventContent.innerHTML = '<p class="text-sm text-gray-500">Drop files here or click to upload</p>';
    }
}

// Klik pada dropzone membuka file input
dropzoneEvent.addEventListener('click', () => fileInputEvent.click());

// Update file yang dipilih melalui file input
fileInputEvent.addEventListener('change', () => handleFilesEvent(fileInputEvent.files));

// Tangani event drag-and-drop
dropzoneEvent.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzoneEvent.classList.add('bg-gray-100'); // Tambahkan efek hover
});

dropzoneEvent.addEventListener('dragleave', () => {
    dropzoneEvent.classList.remove('bg-gray-100'); // Hapus efek hover
});

dropzoneEvent.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzoneEvent.classList.remove('bg-gray-100'); // Hapus efek hover
    const files = e.dataTransfer.files; // Ambil file dari drop
    fileInputEvent.files = files; // Set file input
    handleFilesEvent(files); // Update tampilan
});
</script>

<?= $this->endSection() ?>
