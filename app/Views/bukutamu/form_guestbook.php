<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Form Buku Tamu</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100" style="background-image: url('<?= base_url('pict/bglogin.jpg'); ?>'); background-size: cover;">

    <div class="container mx-auto p-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <?php if (session()->getFlashdata('success')): ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: '<?= session()->getFlashdata('success'); ?>',
                        confirmButtonText: 'OK'
                    });
                </script>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops!',
                        text: 'Semua field wajib diisi',
                        confirmButtonText: 'OK'
                    });

                    window.onload = function() {
                        showForm('instansiForm');
                    };
                </script>
            <?php endif; ?>

            <div class="flex justify-center mb-4">
                <button id="individualTab" onclick="showForm('individualForm')" class="px-6 py-2 text-white bg-yellow-500 rounded-t-md hover:bg-yellow-600 focus:outline-none">Individual</button>
                <button id="instansiTab" onclick="showForm('instansiForm')" class="px-6 py-2 text-white bg-gray-300 hover:bg-gray-400 rounded-t-md focus:outline-none">Instansi</button>
            </div>

            <div id="individualForm" class="form-container">
                <h2 class="text-xl font-bold mb-4">Form Buku Tamu - Individual</h2>
                <form id="guestbookFormIndividual" action="/bukutamu/submit" method="POST" onsubmit="return validateFormIndividual()">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="NAMA_TAMU" name="NAMA_TAMU" value="<?= old('NAMA_TAMU'); ?>" class="w-full border rounded px-3 py-2" autocomplete="off">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" id="ALAMAT_TAMU" name="ALAMAT_TAMU" value="<?= old('ALAMAT_TAMU'); ?>" class="w-full border rounded px-3 py-2" autocomplete="off">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">No WhatsApp</label>
                        <input type="number" id="NOHP_TAMU" name="NOHP_TAMU" value="<?= old('NOHP_TAMU'); ?>" class="w-full border rounded px-3 py-2" min="0">
                    </div>

                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-700">Jenis Kelamin</span>
                        <div class="flex space-x-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" id="JKL_L" name="JENIS_KELAMIN" value="Laki-Laki" <?= old('JENIS_KELAMIN') == 'Laki-Laki' ? 'checked' : ''; ?>>
                                <span class="ml-2 text-gray-700">Laki-Laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" id="JKL_P" name="JENIS_KELAMIN" value="Perempuan" <?= old('JENIS_KELAMIN') == 'Perempuan' ? 'checked' : ''; ?>>
                                <span class="ml-2 text-gray-700">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                        Simpan
                    </button>
                </form>
            </div>

            <div id="instansiForm" class="form-container hidden">
                <h2 class="text-xl font-bold mb-4">Form Buku Tamu - Instansi</h2>
                <form id="guestbookFormInstansi" action="/bukutamu/storeInstansi" method="POST" onsubmit="return validateFormInstansi()">
                    <input type="hidden" name="TIPE_TAMU" value="2">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama Instansi</label>
                        <input type="text" id="NAMA_INSTANSI" name="NAMA_TAMU" value="<?= old('NAMA_TAMU'); ?>" class="w-full border rounded px-3 py-2" autocomplete="off">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alamat Instansi</label>
                        <input type="text" id="ALAMAT_INSTANSI" name="ALAMAT_TAMU" value="<?= old('ALAMAT_TAMU'); ?>" class="w-full border rounded px-3 py-2" autocomplete="off">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">No WhatsApp</label>
                        <input type="number" id="NOHP_INSTANSI" name="NOHP_TAMU" value="<?= old('NOHP_TAMU'); ?>" class="w-full border rounded px-3 py-2" min="0">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jumlah Laki-Laki</label>
                        <input type="number" id="JKL_INSTANSI" name="JKL_TAMU" value="<?= old('JKL_TAMU'); ?>" class="w-full border rounded px-3 py-2" min="0">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jumlah Perempuan</label>
                        <input type="number" id="JKP_INSTANSI" name="JKP_TAMU" value="<?= old('JKP_TAMU'); ?>" class="w-full border rounded px-3 py-2" min="0">
                    </div>

                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function showForm(formId) {
        document.getElementById('individualForm').classList.add('hidden');
        document.getElementById('instansiForm').classList.add('hidden');
        document.getElementById(formId).classList.remove('hidden');
    }

    function validateFormIndividual() {
        const nama = document.getElementById('NAMA_TAMU').value.trim();
        const alamat = document.getElementById('ALAMAT_TAMU').value.trim();
        const nohp = document.getElementById('NOHP_TAMU').value.trim();
        const jkl = document.querySelector('input[name="JENIS_KELAMIN"]:checked');

        if (!nama || !alamat || !nohp || !jkl) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Semua field wajib diisi',
                confirmButtonText: 'OK'
            });
            return false;
        }

        if (nohp.length < 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Nomor HP harus terdiri dari minimal 10 digit',
                confirmButtonText: 'OK'
            });
            return false;
        }

        return true;
    }
</script>
</body>
</html>
