<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        // JavaScript untuk dropdown event dan akun
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-red-900 text-white">
            <div class="p-4">
                <div class="flex items-center">
                    <img src="<?= base_url('pict/iconmuseum.png'); ?>" alt="Logo" class="w-15 h-auto">
                </div>
            </div>
            <ul class="mt-6">
                <li class="px-4 py-2 hover:bg-red-800">
                    <a href="<?= site_url('superadmin/dashboard'); ?>" class="flex items-center space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M3 9.5L12 2l9 7.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="px-4 py-2 hover:bg-red-800">
                    <a href="<?= site_url('superadmin/user-management'); ?>" class="flex items-center space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Manajemen Pengguna</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-red-800">
                <a href="<?= site_url('berita/manage'); ?>" class="flex items-center space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 4h6M7 9h2m-2 4h6m-6 4h2"/>
                    </svg>
                    <span>Manajemen Berita</span>
                </a>
                </li>

                <li class="px-4 py-2 hover:bg-red-800">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleDropdown('eventDropdown')">
                        <div class="flex items-center space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-5 4h.01M5.5 21h13a2.5 2.5 0 0 0 2.5-2.5v-11a2.5 2.5 0 0 0-2.5-2.5h-13A2.5 2.5 0 0 0 3 7.5v11A2.5 2.5 0 0 0 5.5 21z"/>
                            </svg>
                            <span>Event</span>
                        </div>
                        <svg id="dropdownIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <ul id="eventDropdown" class="hidden mt-2 pl-6">
                        <li class="py-1">
                            <a href="<?= site_url('event/category'); ?>" class="text-white hover:text-yellow-300">• Kategori Event</a>
                        </li>
                        <li class="py-1">
                            <a href="<?= site_url('event/manage'); ?>" class="text-white hover:text-yellow-300">• Manajemen Event</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 bg-white">
            <!-- Header -->
            <div class="flex justify-end items-center space-x-4 bg-transparent p-4">
                <div class="relative">
                    <button class="flex items-center space-x-2" onclick="toggleDropdown('userDropdown')">
                        <span class="text-gray-800 font-bold"><?= session()->get('NAMA_USER'); ?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <ul id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-red shadow-lg rounded-lg">
                        <li class="px-4 py-2 hover:bg-red-100 font-semibold cursor-pointer">
                            <a href="<?= site_url('logout'); ?>">Log Out</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Dynamic Content Section -->
            <div class="mt-6">
                <?= $this->renderSection('content'); ?>
            </div>
        </div>
    </div>
</body>
</html>
