<header id="navbar" class="fixed top-0 left-0 w-full z-20 transition-all duration-300 bg-transparent">
  <div class="container mx-auto flex justify-between items-center py-4 px-6">
    <div class="logo">
      <a href="#"><img src="<?= base_url('pict/iconmuseum.png'); ?>" alt="Logo" class="h-10"></a>
    </div>
    <nav class="space-x-4 flex items-center">
      <a href="#beranda" class="text-white hover:text-gray-300 font-semibold">Beranda</a>
      <a href="#jadwal" class="text-white hover:text-gray-300 font-semibold">Jadwal</a>
      <a href="#koleksi" class="text-white hover:text-gray-300 font-semibold">Koleksi</a>
      <a href="#event" class="text-white hover:text-gray-300 font-semibold">Event</a>
      <a href="#tentangkami" class="text-white hover:text-gray-300 font-semibold">Tentang Kami</a>
      <a href="<?= site_url('login');?>" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-400">Login</a>
      <!-- <a href="#" class="bg-gradient-to-r from-yellow-400 to-red-500 text-white py-2 px-4 rounded hover:from-yellow-300 hover:to-red-400">Reservasi Kunjungan</a> -->
    </nav>
  </div>
</header>
