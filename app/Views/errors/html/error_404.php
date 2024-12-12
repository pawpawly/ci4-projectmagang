<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Page Not Found</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .background-image {
      background-image: url('<?= base_url('pict/404pict.png'); ?>');
      background-size: cover;
      background-position: center;
    }
  </style>
</head>
<body class="h-screen flex items-center justify-center background-image">
  <div class="text-center text-white">
    <h1 class="text-6xl font-bold mb-4">404</h1>
    <p class="text-2xl mb-6">Halaman tidak ditemukan</p>
    <p class="mb-8">Maaf, kami tidak dapat menemukan halaman yang Anda cari.</p>
    <a href="<?= site_url('/'); ?>" class="text-blue-400 underline">← Kembali ke halaman utama</a>
  </div>
</body>
</html>
