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
            <!-- Tabs -->
            <div class="flex justify-center mb-4">
                <button id="individualTab" onclick="showForm('individualForm')" 
                        class="px-6 py-2 text-white bg-yellow-500 rounded-t-md hover:bg-yellow-600 focus:outline-none">
                    Individual
                </button>
                <button id="instansiTab" onclick="showForm('instansiForm')" 
                        class="px-6 py-2 text-white bg-gray-300 hover:bg-gray-400 rounded-t-md focus:outline-none">
                    Instansi
                </button>
            </div>

            <!-- Form Individual -->
            <div id="individualForm" class="form-container">
                <h2 class="text-xl font-bold mb-4">Form Buku Tamu - Individual</h2>
                <form action="/bukutamu/submit" method="POST" onsubmit="return validateNumberInput(this)">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="NAMA_TAMU" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" name="ALAMAT_TAMU" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">No WhatsApp</label>
                        <input type="number" name="NOHP_TAMU" class="w-full border rounded px-3 py-2" required min="0">
                    </div>

                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-700">Jenis Kelamin</span>
                        <div class="flex space-x-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="JENIS_KELAMIN" value="Laki-Laki" required>
                                <span class="ml-2 text-gray-700">Laki-Laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="JENIS_KELAMIN" value="Perempuan" required>
                                <span class="ml-2 text-gray-700">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Saran</label>
                        <textarea name="SARAN_TAMU" rows="4" class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                        Simpan
                    </button>
                </form>
            </div>

            <!-- Form Instansi -->
            <div id="instansiForm" class="form-container hidden">
                <h2 class="text-xl font-bold mb-4">Form Buku Tamu - Instansi</h2>
                <form action="/bukutamu/submit" method="POST" onsubmit="return validateNumberInput(this)">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama Instansi</label>
                        <input type="text" name="NAMA_TAMU" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alamat Instansi</label>
                        <input type="text" name="ALAMAT_TAMU" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">No WhatsApp</label>
                        <input type="number" name="NOHP_TAMU" class="w-full border rounded px-3 py-2" required min="0">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jumlah Anggota Laki-Laki</label>
                        <input type="number" name="JKL_TAMU" class="w-full border rounded px-3 py-2" required min="0">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jumlah Anggota Perempuan</label>
                        <input type="number" name="JKP_TAMU" class="w-full border rounded px-3 py-2" required min="0">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Saran</label>
                        <textarea name="SARAN_TAMU" rows="4" class="w-full border rounded px-3 py-2"></textarea>
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
            const forms = document.querySelectorAll('.form-container');
            forms.forEach(form => form.classList.add('hidden'));
            document.getElementById(formId).classList.remove('hidden');

            // Ubah warna tab aktif
            document.getElementById('individualTab').classList.toggle('bg-yellow-500', formId === 'individualForm');
            document.getElementById('individualTab').classList.toggle('bg-gray-300', formId !== 'individualForm');
            document.getElementById('instansiTab').classList.toggle('bg-yellow-500', formId === 'instansiForm');
            document.getElementById('instansiTab').classList.toggle('bg-gray-300', formId !== 'instansiForm');
        }

        function validateNumberInput(form) {
            const inputs = form.querySelectorAll('input[type="number"]');
            for (let input of inputs) {
                if (input.value < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Nilai tidak boleh negatif!',
                    });
                    return false;
                }
            }
            return true;
        }
    </script>
</body>
</html>
