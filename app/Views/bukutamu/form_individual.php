<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Buku Tamu - Individual</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    body {
        height: 100vh;
        background-image: url('<?= base_url('pict/endless-constlelation.png'); ?>');
        background-size: cover;
        display: inline;
        justify-content: center;
        align-items: center;
        padding: 1px;
        margin: 0;
    }

    .form-container {
        position: static; /* Tambahkan relative positioning */
        z-index: 1; /* Agar form tetap di depan */
        width: 100%;
        max-width: 500px;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-container .spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }

    /* Styling untuk input nomor HP agar tetap menghilangkan spinner */
    input[type="number"]::-webkit-inner-spin-button, 
    input[type="number"]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }

    input[type="number"] {
        -moz-appearance: textfield; /* Untuk Firefox */
    }
</style>

</head>
<body>
    <div class="container mx-auto px-4 py-8 bg-white border-solid border-2 border-yellow-600 rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-bold text-center mb-6">Form Buku Tamu - Individu</h1>
        <form id="guestbookFormIndividual" action="/bukutamu/storeIndividual" method="POST" autocomplete="off" novalidate class="space-y-4">
        <?= csrf_field(); ?>
                <!-- Field Nama -->
                <div>
                    <label for="NAMA_TAMU" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" maxlength="70" id="NAMA_TAMU" name="NAMA_TAMU" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                    placeholder="Masukkan Nama Anda" required>
                </div>

                <!-- Field Alamat -->
                <div>
                    <label for="ALAMAT_TAMU" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <input type="text" maxlength="255" id="ALAMAT_TAMU" name="ALAMAT_TAMU" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                    placeholder="Masukkan Alamat Anda" required>
                </div>

        <!-- Field No WhatsApp -->
        <div>
            <label for="NOHP_TAMU" class="block text-sm font-medium text-gray-700 mb-1">No WhatsApp</label>
            <input type="number" id="NOHP_TAMU" name="NOHP_TAMU" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" 
            placeholder="Masukkan Nomor Whatsapp Anda" required>
        </div>
                <!-- Field Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <div class="flex space-x-4">
                        <label>
                            <input type="radio" name="JENIS_KELAMIN" value="Laki-Laki">
                            <span class="ml-2">Laki-Laki</span>
                        </label>
                        <label>
                            <input type="radio" name="JENIS_KELAMIN" value="Perempuan">
                            <span class="ml-2">Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Field Foto Tamu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Tamu (Opsional)</label>
                    <div id="cameraContainer">
                        <video id="camera" autoplay playsinline class="hidden w-full rounded-md shadow-md"></video>
                        <canvas id="canvas" class="hidden w-full rounded-md shadow-md"></canvas>
                    </div>
                    <div class="mt-4 flex space-x-4">
                        <button type="button" id="toggleCameraButton" onclick="startCamera()" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Buka Kamera</button>
                        <button type="button" id="captureButton" onclick="capturePhoto()" class="hidden bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Ambil Foto</button>
                        <button type="button" id="cancelCameraButton" onclick="cancelCamera()" class="hidden bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</button>
                        <button type="button" id="deletePhotoButton" onclick="deletePhoto()" class="hidden bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus Foto</button>
                    </div>
                    <input type="hidden" id="fotoTamu" name="foto_tamu">
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" id="submitButton" class="w-full bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">Simpan</button>
                </div>
            </form>
            <p class="mt-6 text-right text-base text-gray-500">
            <a href="<?= site_url('bukutamu/agency'); ?>" class="text-yellow-500 font-medium hover:underline">&larr; Form Instansi</a>
        </p>
        </div>
        <script>
 document.getElementById('guestbookFormIndividual').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah submit default

    // Ambil elemen tombol submit
    const submitButton = document.querySelector('button[type="submit"]');
    
    // Ambil nilai dari form
    const nama = document.getElementById('NAMA_TAMU').value.trim();
    const alamat = document.getElementById('ALAMAT_TAMU').value.trim();
    const nohp = document.getElementById('NOHP_TAMU').value.trim();
    const jenisKelamin = document.querySelector('input[name="JENIS_KELAMIN"]:checked');

    // Ambil input nomor HP
    const nohpInput = document.getElementById('NOHP_TAMU');

    // Validasi form: pastikan semua field diisi
    if (!nama || !alamat || !nohp || !jenisKelamin) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Semua field wajib diisi!',
        });
        return;
    }

    // Validasi panjang nomor HP: minimal 10 digit, maksimal 15 digit
    if (nohpInput.value.length < 10) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Nomor HP harus terdiri dari minimal 10 digit!',
        });
        return;
    }

    if (nohpInput.value.length > 15) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Nomor HP tidak boleh lebih dari 15 digit!',
        });
        return;
    }

    // Menonaktifkan tombol submit dan menampilkan spinner loading
    submitButton.disabled = true;
    submitButton.innerHTML = 'Menyimpan... <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>';

    // Jika semua field terisi dan nomor HP valid, tampilkan SweetAlert sukses
    Swal.fire({
        icon: 'success',
        title: 'Data berhasil ditambahkan!',
        text: 'Terima Kasih Sudah Berkunjung Ke Museum Kayuh Baimbai!',
        confirmButtonText: 'OK'
    }).then(() => {
        // Kirim form setelah user menekan OK
        event.target.submit();
    });
});

// Event listener untuk membatasi panjang input nomor HP secara langsung
const nohpInput = document.getElementById('NOHP_TAMU');
nohpInput.addEventListener('input', function() {
    // Hanya izinkan angka, menghapus karakter yang bukan angka
    nohpInput.value = nohpInput.value.replace(/\D/g, ''); // Menghapus semua karakter selain angka

    // Batasi panjang input nomor HP tidak lebih dari 15 karakter
    if (nohpInput.value.length > 15) {
        nohpInput.value = nohpInput.value.slice(0, 15);
    }
});

            let videoStream = null;

            function startCamera() {
                const camera = document.getElementById('camera');
                const toggleCameraButton = document.getElementById('toggleCameraButton');
                const captureButton = document.getElementById('captureButton');
                const cancelCameraButton = document.getElementById('cancelCameraButton');

                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(stream => {
                        videoStream = stream;
                        camera.srcObject = stream;
                        camera.classList.remove('hidden');
                        toggleCameraButton.classList.add('hidden');
                        captureButton.classList.remove('hidden');
                        cancelCameraButton.classList.remove('hidden');
                    })
                    .catch(error => {
                        alert("Kamera tidak tersedia.");
                        console.error(error);
                    });
            }

            function cancelCamera() {
                if (videoStream) {
                    videoStream.getTracks().forEach(track => track.stop());
                    videoStream = null;
                }
                const camera = document.getElementById('camera');
                const toggleCameraButton = document.getElementById('toggleCameraButton');
                const captureButton = document.getElementById('captureButton');
                const cancelCameraButton = document.getElementById('cancelCameraButton');

                camera.classList.add('hidden');
                toggleCameraButton.classList.remove('hidden');
                captureButton.classList.add('hidden');
                cancelCameraButton.classList.add('hidden');
            }

            function capturePhoto() {
                const camera = document.getElementById('camera');
                const canvas = document.getElementById('canvas');
                const deletePhotoButton = document.getElementById('deletePhotoButton');

                // Freeze video and convert it to an image
                canvas.width = camera.videoWidth;
                canvas.height = camera.videoHeight;
                canvas.getContext('2d').drawImage(camera, 0, 0, canvas.width, canvas.height);

                const photoData = canvas.toDataURL('image/png');
                document.getElementById('fotoTamu').value = photoData;

                // Stop the camera after taking a photo
                if (videoStream) {
                    videoStream.getTracks().forEach(track => track.stop());
                    videoStream = null;
                }

                camera.classList.add('hidden');
                canvas.classList.remove('hidden');
                deletePhotoButton.classList.remove('hidden');
                document.getElementById('captureButton').classList.add('hidden');
                document.getElementById('cancelCameraButton').classList.add('hidden');
            }

            function deletePhoto() {
                const canvas = document.getElementById('canvas');
                const toggleCameraButton = document.getElementById('toggleCameraButton');
                const deletePhotoButton = document.getElementById('deletePhotoButton');

                document.getElementById('fotoTamu').value = '';
                canvas.classList.add('hidden');
                toggleCameraButton.classList.remove('hidden');
                deletePhotoButton.classList.add('hidden');
            }
        </script>
    </body>
    </html>
