

<header id="navbar" class="fixed top-0 left-0 w-full z-20 transition-all duration-300 bg-transparent">
  <div class="container mx-auto flex justify-between items-center py-4 px-6">
    <div class="logo">
      <a href="<?= site_url('./');?>"><img src="<?= base_url('pict/iconmuseumgray.png'); ?>" alt="Logo" class="h-10"></a>
    </div>

    <!-- Membungkus navigasi dengan div flex untuk memastikan center alignment -->
    <div class="flex-1 flex justify-center">
      <nav class="space-x-8 flex items-center">
        <a href="<?= site_url('./');?>" class="text-gray-200 hover:text-yellow-400 font-semibold">Beranda</a>
        <a href="<?= site_url('schedule');?>" class="text-gray-200 hover:text-yellow-400 font-semibold">Jadwal</a>
        <a href="<?= site_url('koleksi'); ?>" class="text-gray-200 hover:text-yellow-400 font-semibold">Koleksi</a>
        <a href="<?= site_url('bukudigital'); ?>" class="text-gray-200 hover:text-yellow-400 font-semibold">E-Book</a>
        <a href="<?= site_url('event/index'); ?>" class="text-gray-200 hover:text-yellow-400 font-semibold">Event</a>
        <a href="<?= site_url('aboutus');?>" class="text-gray-200 hover:text-yellow-400 font-semibold">Tentang Kami</a>
      </nav>
    </div>
  </div>
</header>
