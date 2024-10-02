<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-900 text-gray-200">
            <div class="p-4">
                <div class="flex items-center">
                <img src="<?= base_url('pict/icon.png'); ?>" alt="Logo" class="w-20 h-auto">
                    <span class="ml-2 text-xl font-bold">Superadmin Dashboard</span>
                </div>
            </div>
<ul class="mt-6">
    <li class="px-4 py-2 hover:bg-gray-800">
        <a href="<?= site_url('superadmin/dashboard'); ?>" class="flex items-center space-x-4">
            <!-- Ikon Rumah (SVG) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9.5L12 2l9 7.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="px-4 py-2 hover:bg-gray-800">
        <a href="<?= site_url('superadmin/user-management'); ?>" class="flex items-center space-x-4">
            <!-- Ikon User (SVG) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Manajemen Pengguna</span>
        </a>
    </li>
</ul>

            <!-- Add more sidebar links here -->
        </div>

<!-- Main Content -->
<div class="flex-1 p-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <!-- Pastikan session()->get('NAMA_USER') digunakan di sini -->
                    <h1 class="text-2xl font-bold">Selamat datang, <?= session()->get('NAMA_USER'); ?></h1>
                </div>
            </div>

            <!-- Main dashboard content -->
            <div class="mt-6">
                <div class="border-2 border-dashed border-gray-300 h-64">
                    <!-- Your content here -->
                      <!-- Konten Utama -->
            <div class="mt-6">
                <!-- Render Section for Dynamic Content -->
                <?= $this->renderSection('content') ?>
            </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
