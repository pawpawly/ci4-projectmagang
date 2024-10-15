<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="h-screen bg-cover bg-center" style="background-image: url('<?= base_url('pict/bglogin4.png'); ?>');">

    <!-- Container Form -->
    <div class="w-full max-w-md px-8 py-10 bg-white bg-opacity-90 shadow-lg rounded-lg mx-auto mt-20">
        <div class="flex justify-center mb-6">
            <img src="<?= base_url('pict/iconmuseum.png'); ?>" alt="Logo" class="h-13">
        </div>

        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Karyawan</h1>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login/authenticate'); ?>" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" 
                       class="mt-1 px-4 py-2 w-full bg-gray-50 border border-gray-300 rounded 
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
            </div>
            <div class="mb-4">
                <div class="flex justify-between">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <a href="#" class="text-sm text-indigo-600 hover:underline">Lupa Password?</a>
                </div>
                <input type="password" id="password" name="password" 
                       class="mt-1 px-4 py-2 w-full bg-gray-50 border border-gray-300 rounded 
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
            </div>
            <div class="mt-6">
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded 
                        hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Login</button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            <a href="<?= site_url('./');?>" class="text-indigo-600 font-medium hover:underline">&larr; Kembali</a>
        </p>
    </div>

    <!-- Footer -->
    <footer class="absolute bottom-0 w-full py-6">
        <div class="max-w-4xl mx-auto text-center ">
            <p class="text-sm text-gray-700 font-medium">&copy; 2024 Museum Kayuh Baimbai.</p>
        </div>
    </footer>
    
    <!-- JavaScript untuk Alert -->
<script>
    window.onload = function() {
        <?php if (session()->getFlashdata('message')): ?>
        showAlert('success', '<?= session()->getFlashdata('message'); ?>');
        <?php elseif (session()->getFlashdata('error')): ?>
        showAlert('error', '<?= session()->getFlashdata('error'); ?>');
        <?php endif; ?>
    };

    function showAlert(type, message) {
        const alertContainer = document.getElementById('alert-container');
        const alert = document.createElement('div');

        alert.className = p-4 mb-4 rounded shadow-md ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white;
        alert.innerText = message;

        alertContainer.appendChild(alert);

        // Hapus alert setelah 3 detik
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
</script>
</body>
</html>
