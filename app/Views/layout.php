<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body>

  <!-- Include Header -->
  <?= $this->include('header'); ?>

  <!-- Page Content -->
  <main class="bg-gray-200">
    <?= $this->renderSection('content') ?>
  </main>

  <!-- Include Footer -->
  <?= $this->include('footer'); ?>

  <script src="<?= base_url('js/main.js'); ?>"></script>

</body>
</html>