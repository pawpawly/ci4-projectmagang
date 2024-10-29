<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Koleksi</h1>

    <form id="koleksiForm" action="<?= site_url('superadmin/koleksi/save') ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nama_koleksi" class="block text-sm font-medium text-gray-700">Nama Koleksi</label>
            <input type="text" id="nama_koleksi" name="nama_koleksi"
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
            <textarea id="deskripsi_koleksi" name="deskripsi_koleksi" rows="4"
                      class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"><?= old('deskripsi_koleksi') ?></textarea>
        </div>

        <div class="mb-4">
            <label for="foto_koleksi" class="block text-sm font-medium text-gray-700">Foto Koleksi</label>
            <input type="file" id="foto_koleksi" name="foto_koleksi"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                   accept=".jpg,.jpeg,.png">
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
</script>

<style>
    textarea:focus, input:focus, select:focus {
        border-color: #ecc94b;
        outline: none;
        box-shadow: 0 0 0 2px rgba(236, 201, 75, 0.5);
    }
</style>

<?= $this->endSection() ?>
