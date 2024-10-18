

<header id="navbar" class="fixed top-0 left-0 w-full z-20 transition-all duration-300 bg-transparent">
  <div class="container mx-auto flex justify-between items-center py-4 px-6">
    <div class="logo">
      <a href="#"><img src="<?= base_url('pict/iconmuseumputih.png'); ?>" alt="Logo" class="h-10"></a>
    </div>

    <!-- Membungkus navigasi dengan div flex untuk memastikan center alignment -->
    <div class="flex-1 flex justify-center">
      <nav class="space-x-8 flex items-center">
        <a href="<?= site_url('./');?>" class="text-white hover:text-gray-300 font-semibold">Beranda</a>
        <a href="<?= site_url('schedule');?>" class="text-white hover:text-gray-300 font-semibold">Jadwal</a>
        <a href="#koleksi" class="text-white hover:text-gray-300 font-semibold">Koleksi</a>
        <a href="<?= site_url('event/index'); ?>" class="text-white hover:text-gray-300 font-semibold">Event</a>
        <a href="<?= site_url('aboutus');?>" class="text-white hover:text-gray-300 font-semibold">Tentang Kami</a>
      </nav>
    </div>

    <!-- Tombol Login -->
    <a href="<?= site_url('login');?>" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-400">
      Login
    </a>
  </div>
</header>
