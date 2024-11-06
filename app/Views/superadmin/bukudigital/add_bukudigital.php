<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Tambah Buku Digital</h1>

    <form id="tambahBukuDigitalForm" action="<?= site_url('superadmin/bukudigital/save') ?>" 
          method="POST" autocomplete="off" enctype="multipart/form-data" novalidate>
        <div class="mb-4">
            <label for="judul_buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
            <input type="text" id="judul_buku" name="judul_buku" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                   placeholder="Masukkan judul buku" required>
        </div>

        <div class="mb-4">
            <label for="penulis_buku" class="block text-sm font-medium text-gray-700">Penulis Buku</label>
            <input type="text" id="penulis_buku" name="penulis_buku" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                   placeholder="Masukkan penulis buku" required>
        </div>

        <div class="mb-4">
            <label for="tahun_buku" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
            <input type="text" id="tahun_buku" name="tahun_buku" autocomplete="off"
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                   placeholder="Masukkan tahun terbit" required>
        </div>

        <div class="mb-4">
            <label for="sinopsis_buku" class="block text-sm font-medium text-gray-700">Sinopsis</label>
            <textarea id="sinopsis_buku" name="sinopsis_buku" rows="4" autocomplete="off"
                      class="mt-1 px-4 py-2 w-full border resize-none rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                      placeholder="Masukkan sinopsis buku" required></textarea>
        </div>

        <div class="mb-4">
            <label for="sampul_buku" class="block text-sm font-medium text-gray-700">Sampul Buku <i>Max 2MB</i></label>
            <input type="file" id="sampul_buku" name="sampul_buku" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                   accept=".jpg,.jpeg,.png" required>
        </div>

        <div class="mb-4">
            <label for="produk_buku" class="block text-sm font-medium text-gray-700">File Buku (PDF) <i>Max 40MB</i></label>
            <input type="file" id="produk_buku" name="produk_buku" 
                   class="mt-1 px-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                   accept=".pdf" required>
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
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('tambahBukuDigitalForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);
    
    // Check if all required fields are filled and files are uploaded
    if (!formData.get('judul_buku') || !formData.get('penulis_buku') || !formData.get('tahun_buku') ||
        !formData.get('sinopsis_buku') || !formData.get('sampul_buku') || !formData.get('produk_buku')) {
        
        // Show SweetAlert warning if any field is missing
        Swal.fire({
            title: 'Oops!',
            text: 'Semua field wajib diisi!',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return; // Stop the form submission
    }

    // Proceed with form submission via AJAX if all fields are valid
    fetch('<?= site_url('superadmin/bukudigital/save') ?>', {
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
                text: 'Buku digital berhasil ditambahkan.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '<?= site_url('superadmin/bukudigital/manage'); ?>';
            });
        } else {
            Swal.fire({
                title: 'Gagal!',
                text: data.message || 'Gagal menyimpan buku digital.',
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
</script>


<?= $this->endSection() ?>
