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

        <div class="mb-4">
            <label for="foto_berita" class="block text-sm font-medium text-gray-700">Foto Berita</label>
            <input type="file" id="foto_berita" name="foto_berita" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                   accept=".jpg,.jpeg,.png" required>
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
</script>

<?= $this->endSection() ?>
