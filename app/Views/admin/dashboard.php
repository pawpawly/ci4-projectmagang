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
                    <span class="ml-2 text-xl font-bold">Admin Dashboard</span>
                </div>
            </div>
            <ul class="mt-6">
                <li class="px-4 py-2 hover:bg-gray-800">
                    <a href="#" class="flex items-center space-x-4">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M3 10h18M3 16h18M3 22h18" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="px-4 py-2 hover:bg-gray-800">
                    <a href="#" class="flex items-center space-x-4">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18m-9-9v18" />
                        </svg>
                        <span>Projects</span>
                    </a>
                </li>
                <!-- Add more sidebar links here -->
            </ul>
        </div>

        <!-- Main content -->
        <div class="flex-1 p-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div class="relative">
                    <!-- Tampilkan NAMA_USER -->
                    <span class="ml-2 font-semibold text-gray-700">Selamat datang, <?= $NAMA_USER; ?></span>
                </div>
            </div>

            <!-- Main dashboard content -->
            <div class="mt-6">
                <div class="border-2 border-dashed border-gray-300 h-64">
                    <!-- Your content here -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
