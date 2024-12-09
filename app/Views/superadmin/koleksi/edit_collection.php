<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Koleksi</h1>

    <form id="koleksiForm" action="<?= site_url('superadmin/koleksi/update') ?>" method="POST" autocomplete="off" enctype="multipart/form-data">
    <?= csrf_field(); ?>
        <input type="hidden" name="id_koleksi" value="<?= $koleksi['ID_KOLEKSI'] ?>">

        <div class="mb-4">
            <label for="nama_koleksi" class="block text-sm font-medium text-gray-700">Nama Koleksi</label>
            <input type="text" maxlength="255" id="nama_koleksi" name="nama_koleksi" autocomplete="off" placeholder="Masukkan Nama Koleksi"
                   value="<?= old('nama_koleksi', $koleksi['NAMA_KOLEKSI']) ?>"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        </div>

        <div class="mb-4">
            <label for="kategori_koleksi" class="block text-sm font-medium text-gray-700">Kategori Koleksi</label>
            <select id="kategori_koleksi" name="kategori_koleksi" 
                    class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                <option value="">Pilih Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['ID_KKOLEKSI'] ?>"
                        <?= old('kategori_koleksi', $koleksi['ID_KKOLEKSI']) == $category['ID_KKOLEKSI'] ? 'selected' : '' ?>>
                        <?= esc($category['KATEGORI_KKOLEKSI']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="deskripsi_koleksi" class="block text-sm font-medium text-gray-700">Deskripsi Koleksi</label>
            <textarea id="deskripsi_koleksi" name="deskripsi_koleksi" rows="4" autocomplete="off" placeholder="Masukkan Deskripsi Koleksi"
                      class="mt-1 px-4 py-2 w-full resize-none border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= old('deskripsi_koleksi', $koleksi['DESKRIPSI_KOLEKSI'] ?? '') ?></textarea>
        </div>

        <div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Koleksi <i>(Max 2MB)</i> <p><i>Abaikan jika tidak ingin mengganti foto</i></p> </label>
    <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-100 transition relative" id="dropzoneKoleksiEdit">
        <input type="file" name="foto_koleksi" id="fotoKoleksiEdit" accept=".jpg,.jpeg,.png" class="hidden">
        <div id="dropzoneKoleksiContentEdit" class="flex flex-col justify-center items-center space-y-2">
            <!-- Ikon upload -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
            </svg>
            <p class="text-sm text-gray-500">Drop files here or click to upload</p>
        </div>
    </div>
    <?php if ($koleksi['FOTO_KOLEKSI']): ?>
        <img src="<?= base_url('uploads/koleksi/' . $koleksi['FOTO_KOLEKSI']) ?>" 
             alt="Foto Koleksi" class="w-24 h-24 mt-2 object-cover rounded-md">
    <?php endif; ?>
</div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('superadmin/koleksi/manage') ?>"
               class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</a>
            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Menangani pengiriman form dengan AJAX
    document.getElementById('koleksiForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Mencegah pengiriman form default

        // Validasi untuk memastikan semua field sudah diisi (kecuali foto)
        const namaKoleksi = document.getElementById('nama_koleksi').value.trim();
        const kategoriKoleksi = document.getElementById('kategori_koleksi').value.trim();
        const deskripsiKoleksi = document.getElementById('deskripsi_koleksi').value.trim();
        
        if (!namaKoleksi || !kategoriKoleksi || !deskripsiKoleksi) {
            Swal.fire({
                title: 'Oops!',
                text: 'Semua field wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return; // Tidak lanjutkan proses submit jika ada field kosong
        }

        const submitButton = document.querySelector('button[type="submit"]');
        submitButton.disabled = true; // Disable submit button
        submitButton.innerHTML = 'Menyimpan... <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>';

        const formData = new FormData(this);

        fetch('<?= site_url('superadmin/koleksi/update') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Mengatur respons sukses
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
                submitButton.disabled = false; // Aktifkan kembali tombol jika ada kesalahan
                submitButton.innerHTML = 'Simpan';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            submitButton.disabled = false; // Aktifkan kembali tombol jika terjadi error
            submitButton.innerHTML = 'Simpan';
        });
    });

    // Mengatur drag-and-drop untuk input file
    const dropzoneKoleksiEdit = document.getElementById('dropzoneKoleksiEdit');
    const fileInput = document.getElementById('fotoKoleksiEdit');
    const dropzoneContentFile = document.getElementById('dropzoneKoleksiContentEdit');

    dropzoneKoleksiEdit.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        const textElement = dropzoneContentFile.querySelector('p');

        if (!file) {
            resetDropzoneContent(textElement);
        } else if (file.size > 2 * 1024 * 1024) { // 2MB limit
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file Koleksi melebihi 2MB',
                text: 'Silakan unggah file dengan ukuran maksimal 2MB.',
            });
            fileInput.value = ''; // Reset file input
            resetDropzoneContent(textElement);
        } else {
            textElement.textContent = `File Terpilih: ${file.name}`;
            textElement.classList.remove('text-gray-500');
            textElement.classList.add('text-green-500');
        }
    });

    function resetDropzoneContent(textElement) {
        textElement.textContent = 'Drop files here or click to upload';
        textElement.classList.add('text-gray-500');
        textElement.classList.remove('text-green-500');
    }

    // Menangani efek drag-and-drop
    dropzoneKoleksiEdit.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzoneKoleksiEdit.classList.add('bg-gray-100'); // Efek hover saat dragover
    });

    dropzoneKoleksiEdit.addEventListener('dragleave', () => {
        dropzoneKoleksiEdit.classList.remove('bg-gray-100'); // Menghapus efek hover saat drag leave
    });

    dropzoneKoleksiEdit.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzoneKoleksiEdit.classList.remove('bg-gray-100'); // Menghapus efek hover setelah drop
        const files = e.dataTransfer.files; // Ambil file dari drop
        fileInput.files = files; // Set file input dengan file yang di-drop
        handleFilesKoleksiEdit(files); // Update tampilan dengan file yang dipilih
    });

    // Fungsi untuk memperbarui tampilan file yang dipilih
    function handleFilesKoleksiEdit(files) {
        const textElement = dropzoneContentFile.querySelector('p');
        const file = files[0];

        if (file && file.size <= 2 * 1024 * 1024) { // 2MB limit
            textElement.textContent = `File Terpilih: ${file.name}`;
            textElement.classList.remove('text-gray-500');
            textElement.classList.add('text-green-500');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran file Koleksi melebihi 2MB',
                text: 'Silakan unggah file dengan ukuran maksimal 2MB.',
            });
            fileInput.value = ''; // Reset file input jika file melebihi ukuran
            resetDropzoneContent(textElement);
        }
    }
</script>


<?= $this->endSection() ?>
