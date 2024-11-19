<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Form Buku Tamu</title>
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
    </style>
</head>
<body>
    <script>
        // Menonaktifkan tombol "Go Back" di browser langsung setelah halaman dimuat
        (function preventBackNavigation() {
            // Menambahkan state palsu secara otomatis
            history.pushState(null, null, location.href);

            // Fungsi untuk tetap berada di halaman
            function stayOnPage() {
                history.pushState(null, null, location.href); // Dorong pengguna tetap di halaman yang sama
            }

            // Tangkap event popstate untuk mencegah tombol kembali
            window.addEventListener('popstate', function () {
                stayOnPage(); // Paksa pengguna tetap di halaman
                Swal.fire({
                    title: 'Aksi Tidak Diizinkan!',
                    text: 'Tombol kembali dinonaktifkan untuk halaman ini.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#fbbf24'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Setelah klik OK, tampilkan pilihan kembali
                        Swal.fire({
                            title: 'Apakah Kamu dari Instansi?',
                            icon: 'question',
                            showCancelButton: false,
                            allowOutsideClick: false,
                            confirmButtonText: 'Tidak, Saya datang sendiri',
                            confirmButtonColor: '#fbbf24',
                            showDenyButton: true,
                            denyButtonText: 'Iya, Saya dari Instansi',
                            denyButtonColor: '#1d4ed8',
                            heightAuto: false, // Fullscreen dialog
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?= base_url('bukutamu/individual'); ?>"; // Route untuk Individual
                            } else if (result.isDenied) {
                                window.location.href = "<?= base_url('bukutamu/agency'); ?>"; // Route untuk Agency
                            }
                        });
                    }
                });
            });

            // Jalankan stayOnPage secara langsung untuk pertama kali
            setTimeout(stayOnPage, 0);
        })();

        // Menampilkan dialog pilihan awal dalam layar penuh
        window.onload = function () {
            Swal.fire({
                title: 'Apakah Kamu dari Instansi?',
                icon: 'question',
                showCancelButton: false,
                allowOutsideClick: false,
                confirmButtonText: 'Tidak, Saya datang sendiri',
                confirmButtonColor: '#fbbf24',
                showDenyButton: true,
                denyButtonText: 'Iya, Saya dari Instansi',
                denyButtonColor: '#1d4ed8',
                heightAuto: false, // Fullscreen dialog
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url('bukutamu/individual'); ?>"; // Route untuk Individual
                } else if (result.isDenied) {
                    window.location.href = "<?= base_url('bukutamu/agency'); ?>"; // Route untuk Agency
                }
            });
        };
    </script>
</body>
</html>
