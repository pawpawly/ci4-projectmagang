<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold text-center">Welcome to the Superadmin Dashboard</h1>
        <p class="text-center">Anda login sebagai <?= session()->get('username'); ?></p>

        <div class="text-center mt-10">
            <a href="<?= site_url('./'); ?>" class="bg-red-500 text-white px-4 py-2 rounded">Logout</a>
        </div>
    </div>
</body>
</html>
