<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Styling untuk sidebar agar sticky saat scroll */
        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh; /* Menutupi seluruh tinggi layar */
            overflow-y: auto; /* Scroll jika konten terlalu panjang */
        }
    </style>

    <script>
        // JavaScript untuk toggle dropdown menu
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-red-900 text-white sidebar">
            <div class="p-4">
                <div class="flex items-center">
                    <img src="<?= base_url('pict/iconmuseum.png'); ?>" alt="Logo" class="w-15 h-auto">
                </div>
            </div>
            <ul class="mt-6">
                <li class="px-4 py-2 hover:bg-red-800">
                    <a href="<?= site_url('superadmin/dashboard'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-red-800">
                    <a href="<?= site_url('superadmin/bukutamu/manage'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-book-open"></i>
                        <span>Manajemen Buku Tamu</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-red-800">
                    <a href="<?= site_url('superadmin/user/manage'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-users"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-red-800">
                    <a href="<?= site_url('superadmin/berita/manage'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-newspaper"></i>
                        <span>Manajemen Berita</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-red-800">
                    <a href="<?= site_url('superadmin/reservasi/manage'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Manajemen Reservasi</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-red-800">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleDropdown('eventDropdown')">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-calendar-day"></i>
                            <span>Event</span>
                        </div>
                        <i class="fas fa-chevron-down transform transition-transform" id="eventDropdownIcon"></i>
                    </div>
                    <ul id="eventDropdown" class="hidden mt-2 pl-6">
                        <li class="py-1">
                            <a href="<?= site_url('superadmin/event/category'); ?>" class="text-white hover:text-yellow-300">• Kategori Event</a>
                        </li>
                        <li class="py-1">
                            <a href="<?= site_url('superadmin/event/manage'); ?>" class="text-white hover:text-yellow-300">• Manajemen Event</a>
                        </li>
                    </ul>
                </li>

                <li class="px-4 py-2 hover:bg-red-800">
                    <div class="flex items-center justify-between cursor-pointer" onclick="toggleDropdown('koleksiDropdown')">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-book"></i>
                            <span>Koleksi</span>
                        </div>
                        <i class="fas fa-chevron-down transform transition-transform" id="koleksiDropdownIcon"></i>
                    </div>
                    <ul id="koleksiDropdown" class="hidden mt-2 pl-6">
                        <li class="py-1">
                            <a href="<?= site_url('superadmin/koleksi/category'); ?>" class="text-white hover:text-yellow-300">• Kategori Koleksi</a>
                        </li>
                        <li class="py-1">
                            <a href="<?= site_url('superadmin/koleksi/manage'); ?>" class="text-white hover:text-yellow-300">• Manajemen Koleksi</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 bg-white">
            <div class="flex justify-end items-center space-x-4 bg-transparent p-4">
                <div class="relative">
                    <button class="flex items-center space-x-2" onclick="toggleDropdown('userDropdown')">
                        <span class="text-gray-800 font-bold"><?= session()->get('NAMA_USER'); ?></span>
                        <i class="fas fa-user-circle"></i>
                    </button>
                    <ul id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-red-800 shadow-lg rounded-lg">
                        <li class="px-4 py-2 hover:bg-red-400 font-semibold cursor-pointer">
                            <a href="<?= site_url('logout'); ?>">Log Out</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-6">
                <?= $this->renderSection('content'); ?>
            </div>
        </div>
    </div>
</body>

</html>
