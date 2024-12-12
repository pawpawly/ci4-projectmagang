<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
</head>
<body class="h-screen bg-cover bg-center" style="background-image: url('<?= base_url('pict/loginbg.png'); ?>');">

    <!-- Container Form -->
    <div class="w-full max-w-md px-8 py-10 bg-white bg-opacity-90 shadow-lg rounded-lg mx-auto mt-20">
        <div class="flex justify-center mb-6">
            <img src="<?= base_url('pict/iconmuseum.png'); ?>" alt="Logo" class="h-13">
        </div>

        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Karyawan</h1>

        <form id="loginForm" action="<?= site_url('login/authenticate'); ?>" method="POST" autocomplete="off">
            <?= csrf_field(); ?> 
            
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" maxlength="30"id="username" name="username" 
                placeholder="Masukkan Username "
                       class="mt-1 px-4 py-2 w-full bg-gray-50 border border-gray-300 rounded 
                       focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent" 
                       autocomplete="off">
            </div>

            <div class="mb-4">
                <div class="flex justify-between">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                </div>
                <input type="password" maxlength="30" id="password" name="password" 
                placeholder="Masukkan Password"
                       class="mt-1 px-4 py-2 w-full bg-gray-50 border border-gray-300 rounded 
                       focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
            </div>

<div class="mt-6">
    <button id="loginButton" type="submit" 
            class="w-full px-4 py-2 bg-yellow-400 text-white rounded 
            hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600 flex justify-center items-center">
        <span id="buttonText">Login</span>
        <svg id="spinner" class="hidden w-5 h-5 ml-2 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
    </button>
</div>

        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            <a href="<?= site_url('./'); ?>" class="text-yellow-500 font-medium hover:underline">&larr; Kembali</a>
        </p>
    </div>

    <!-- Footer -->
    <footer class="absolute bottom-0 w-full py-6">
        <div class="max-w-4xl mx-auto text-center">
            <p class="text-sm text-gray-700 font-medium">&copy; 2024 Museum Kayuh Baimbai.</p>
        </div>
    </footer>
    
    <!-- SweetAlert2 untuk Validasi -->

<script>
document.getElementById('loginForm').addEventListener('submit', function(event) {
    const loginButton = document.getElementById('loginButton');
    const buttonText = document.getElementById('buttonText');
    const spinner = document.getElementById('spinner');
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    // Cek apakah username atau password kosong
    if (!username || !password) {
        event.preventDefault(); // Mencegah form terkirim
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Mohon Username dan Password diisi terlebih dahulu!'
        });
        return; // Hentikan eksekusi lebih lanjut
    }

    // Ubah tombol login menjadi "Logging in...", tampilkan spinner, dan disable tombol
    spinner.classList.remove('hidden'); // Tampilkan spinner
    buttonText.textContent = 'Logging in...';
    loginButton.disabled = true;
    loginButton.classList.add('opacity-50', 'cursor-not-allowed');
});

window.onload = function() {
    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session()->getFlashdata('error') ?>'
        });
    <?php endif; ?>
};
</script>


</body>
</html>
