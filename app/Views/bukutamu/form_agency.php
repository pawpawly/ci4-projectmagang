<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Buku Tamu - Instansi</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background-image: url('<?= base_url('pict/bglogin.jpg'); ?>');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield; /* Untuk Firefox */
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8 bg-white rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-bold text-center mb-6">Form Buku Tamu - Instansi</h1>
        <?= csrf_field(); ?>
        <form id="guestbookFormInstansi" action="/bukutamu/storeAgency" method="POST" autocomplete="off" novalidate class="space-y-4">
    <!-- Field Nama Instansi -->
    <div>
        <label for="NAMA_TAMU" class="block text-sm font-medium text-gray-700 mb-1">Nama Instansi</label>
        <input type="text" id="NAMA_TAMU" name="NAMA_TAMU" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
    </div>

    <!-- Field Alamat -->
    <div>
        <label for="ALAMAT_TAMU" class="block text-sm font-medium text-gray-700 mb-1">Alamat Instansi</label>
        <input type="text" id="ALAMAT_TAMU" name="ALAMAT_TAMU" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
    </div>

    <!-- Field No WhatsApp -->
    <div>
        <label for="NOHP_TAMU" class="block text-sm font-medium text-gray-700 mb-1">No WhatsApp</label>
        <input type="number" id="NOHP_TAMU" name="NOHP_TAMU" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
    </div>

    <!-- Field Jumlah Laki-Laki -->
    <div class="mb-4">
        <label for="JKL_TAMU" class="block text-sm font-medium text-gray-700">Jumlah Laki-Laki</label>
        <input type="number" id="JKL_TAMU" name="JKL_TAMU" class="w-full border rounded px-3 py-2" value="0" required>
    </div>

    <!-- Field Jumlah Perempuan -->
    <div class="mb-4">
        <label for="JKP_TAMU" class="block text-sm font-medium text-gray-700">Jumlah Perempuan</label>
        <input type="number" id="JKP_TAMU" name="JKP_TAMU" class="w-full border rounded px-3 py-2" value="0" required>
    </div>

    <!-- Field Foto Tamu -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Tamu (Opsional)</label>
        <div id="cameraContainer">
            <video id="camera" autoplay playsinline class="hidden w-full rounded-md shadow-md"></video>
            <canvas id="canvas" class="hidden w-full rounded-md shadow-md"></canvas>
        </div>
        <div class="mt-4 flex space-x-4">
            <button type="button" id="toggleCameraButton" onclick="startCamera()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Buka Kamera</button>
            <button type="button" id="captureButton" onclick="capturePhoto()" class="hidden bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Ambil Foto</button>
            <button type="button" id="cancelCameraButton" onclick="cancelCamera()" class="hidden bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Batal</button>
            <button type="button" id="deletePhotoButton" onclick="deletePhoto()" class="hidden bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus Foto</button>
        </div>
        <input type="hidden" id="fotoTamu" name="foto_tamu">
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit" class="w-full bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Simpan</button>
    </div>
</form>

        </form>
    </div>

        <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('guestbookFormInstansi').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const nama = document.getElementById('NAMA_TAMU').value.trim();
        const alamat = document.getElementById('ALAMAT_TAMU').value.trim();
        const nohp = document.getElementById('NOHP_TAMU').value.trim();
        const jumlahLaki = document.getElementById('JKL_TAMU').value.trim(); // Fixed field name
        const jumlahPerempuan = document.getElementById('JKP_TAMU').value.trim(); // Fixed field name

        // Validasi form: pastikan tidak ada yang kosong
        if (!nama || !alamat || !nohp || !jumlahLaki || !jumlahPerempuan) {
            Swal.fire({
                icon: 'warning',
                title: 'Semua field wajib diisi!',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Validasi panjang nomor HP
        if (nohp.length < 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Nomor HP harus terdiri dari minimal 10 digit',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Validasi jumlah Laki-Laki dan Perempuan
        if (isNaN(jumlahLaki) || isNaN(jumlahPerempuan) || jumlahLaki < 0 || jumlahPerempuan < 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Jumlah Laki-Laki dan Perempuan harus berupa angka positif!',
                confirmButtonText: 'OK'
            });
            return;
        }

        // If all fields are valid, show success and submit the form
        Swal.fire({
            icon: 'success',
            title: 'Data berhasil ditambahkan!',
            confirmButtonText: 'OK'
        }).then(() => {
            const formData = new FormData(this);
            formData.append('JKL_TAMU', jumlahLaki); // Add male count to form data
            formData.append('JKP_TAMU', jumlahPerempuan); // Add female count to form data

            fetch(this.action, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      window.location.href = '/bukutamu/form'; // Redirect after success
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error!',
                          text: data.message || 'Terjadi kesalahan, coba lagi.',
                          confirmButtonText: 'OK'
                      });
                  }
              })
              .catch(error => {
                  console.error('Error:', error);
                  Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'Terjadi kesalahan. Coba lagi.',
                      confirmButtonText: 'OK'
                  });
              });
        });
    });
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
