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
    /* Default: Menu dan Submenu */
    .sidebar a {
        color: white; /* Warna default */
        transition: color 0.3s; /* Animasi halus */
    }

    /* Hover: Semua menu dan submenu */
    .sidebar a:hover {
        color: #FFD700; /* Warna kuning saat hover */
    }

    /* Aktif: Menu dan submenu yang terbuka */
    .sidebar a.active {
        color: #FFD700; /* Warna kuning saat aktif */
    }
    
</style>



<script>
    // JavaScript untuk toggle dropdown menu
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('hidden');
    }

document.addEventListener('DOMContentLoaded', function () {
    const currentUrl = window.location.href;

    // Loop untuk semua menu di sidebar
    document.querySelectorAll('.sidebar a').forEach(link => {
        const linkHref = link.getAttribute('href');
        // Jika URL saat ini cocok dengan href, tambahkan class 'active'
        if (currentUrl.includes(linkHref)) {
            link.classList.add('active');
        }
    });

    // Dropdown Event
    if (currentUrl.includes('superadmin/event/')) {
        const eventDropdown = document.getElementById('eventDropdown');
        const eventDropdownIcon = document.getElementById('eventDropdownIcon');
        eventDropdown.classList.remove('hidden');
        eventDropdownIcon.classList.add('rotate-180');
    }

    // Dropdown Koleksi
    if (currentUrl.includes('superadmin/koleksi/')) {
        const koleksiDropdown = document.getElementById('koleksiDropdown');
        const koleksiDropdownIcon = document.getElementById('koleksiDropdownIcon');
        koleksiDropdown.classList.remove('hidden');
        koleksiDropdownIcon.classList.add('rotate-180');
    }
});



</script>

</head>

<body class="bg-white">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-600 text-white sidebar fixed h-screen">
            <div class="p-4">
                <div class="flex items-center">
                    <img src="<?= base_url('pict/iconmuseum.png'); ?>" alt="Logo" class="w-15 h-auto">
                </div>
            </div>
            <ul class="mt-6">
                <li class="px-4 py-2 hover:bg-gray-500">
                    <a href="<?= site_url('superadmin/dashboard'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-gray-500">
                    <a href="<?= site_url('superadmin/bukutamu/manage'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-book-open"></i>
                        <span>Manajemen Buku Tamu</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-gray-500">
                    <a href="<?= site_url('superadmin/reservasi/manage'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Manajemen Reservasi</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-gray-500">
                    <a href="<?= site_url('superadmin/user/manage'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-users"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                </li>

                <li class="px-4 py-2 hover:bg-gray-500">
                    <a href="<?= site_url('superadmin/berita/manage'); ?>" class="flex items-center space-x-4">
                        <i class="fas fa-newspaper"></i>
                        <span>Manajemen Berita</span>
                    </a>
                </li>



        <li class="px-4 py-2 hover:bg-gray-500">
            <a href="<?= site_url('superadmin/bukudigital/manage'); ?>" class="flex items-center space-x-4">
                <i class="fas fa-book-reader"></i>
                <span>Manajemen Buku Digital</span>
                </a>
                </li>

                <li class="px-4 py-2 hover:bg-gray-500">
                <a href="<?= site_url('superadmin/saran/manage'); ?>" class="flex items-center space-x-4">
                    <i class="fas fa-comments"></i>
                    <span>Saran Pengunjung</span>
                </a>
            </li>


                <!-- Item Menu Event -->
                <li class="px-4 py-2 hover:bg-gray-500">
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
                

                <li class="px-4 py-2 hover:bg-gray-500">
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


        <div class="flex-1 p-6 bg-white ml-64">
    <div class="flex justify-end items-center space-x-4 bg-transparent p-4">
        <div class="relative">
            <button class="flex items-center space-x-2" onclick="toggleDropdown('userDropdown')">
                <span class="text-gray-800 font-bold"><?= session()->get('NAMA_USER'); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-800">
                  <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                </svg>
            </button>
            <ul id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-gray-600 shadow-lg rounded-lg">
                <li class="hover:bg-gray-400 font-semibold cursor-pointer">
                    <a href="<?= site_url('logout'); ?>" class="block px-4 py-2 text-white text-center">
                        Log Out
                    </a>
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
