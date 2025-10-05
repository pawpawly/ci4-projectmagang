<header id="navbar" class="fixed top-0 left-0 w-full z-20 transition-all duration-300 bg-transparent">
  <div class="container mx-auto flex justify-between items-center py-4 px-6">
    <!-- Logo -->
    <div class="logo flex items-center">
      <a href="<?= site_url('./');?>"><img src="<?= base_url('pict/iconmuseumgray.png'); ?>" alt="Logo" class="h-10"></a>
    </div>

    <!-- Tombol Hamburger -->
    <button id="navToggle" aria-label="Toggle navigation" class="md:hidden text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Menu Navigasi -->
    <nav id="navMenu" class="hidden md:flex items-center md:space-x-8 md:static absolute top-full left-0 w-full md:w-auto bg-gray-900 md:bg-transparent px-6 py-4 md:p-0 shadow-lg md:shadow-none opacity-0 md:opacity-100 translate-y-[-10px] md:translate-y-0 transition-all duration-300">
      <a href="<?= site_url('./');?>" class="block py-2 text-gray-200 hover:text-yellow-400 font-semibold">Beranda</a>
      <a href="<?= site_url('schedule');?>" class="block py-2 text-gray-200 hover:text-yellow-400 font-semibold">Jadwal</a>
      <a href="<?= site_url('koleksi'); ?>" class="block py-2 text-gray-200 hover:text-yellow-400 font-semibold">Koleksi</a>
      <a href="<?= site_url('bukudigital'); ?>" class="block py-2 text-gray-200 hover:text-yellow-400 font-semibold">E-Book</a>
      <a href="<?= site_url('event/index'); ?>" class="block py-2 text-gray-200 hover:text-yellow-400 font-semibold">Event</a>
      <a href="<?= site_url('aboutus');?>" class="block py-2 text-gray-200 hover:text-yellow-400 font-semibold">Tentang Kami</a>
    </nav>
  </div>

  <script>
    (function() {
      const toggle = document.getElementById('navToggle');
      const menu = document.getElementById('navMenu');
      const navbar = document.getElementById('navbar');
      let isMenuOpen = false;

      const setNavbarDark = () => {
        navbar.classList.remove('bg-transparent');
        navbar.classList.add('bg-gray-900');
      };

      const setNavbarTransparent = () => {
        navbar.classList.add('bg-transparent');
        navbar.classList.remove('bg-gray-900');
      };

      const openMenu = () => {
        menu.classList.remove('hidden');
        setTimeout(() => {
          menu.classList.remove('translate-y-[-10px]', 'opacity-0');
          menu.classList.add('translate-y-0', 'opacity-100');
        }, 10);
        setNavbarDark();
        isMenuOpen = true;
      };

      const closeMenu = () => {
        menu.classList.add('translate-y-[-10px]', 'opacity-0');
        menu.classList.remove('translate-y-0', 'opacity-100');
        setTimeout(() => menu.classList.add('hidden'), 300);
        if (window.scrollY <= 10) setNavbarTransparent();
        isMenuOpen = false;
      };

      // Toggle click
      toggle.addEventListener('click', () => {
        isMenuOpen ? closeMenu() : openMenu();
      });

      // Scroll event
      let scrollTimeout;
      window.addEventListener('scroll', () => {
        if (window.scrollY > 10) setNavbarDark();
        else if (!isMenuOpen) setNavbarTransparent();

        // Tutup menu saat scroll, dengan debounce
        if (isMenuOpen && window.innerWidth < 768) {
          clearTimeout(scrollTimeout);
          scrollTimeout = setTimeout(() => closeMenu(), 100);
        }
      });

      // Reset menu saat resize ke desktop
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
          menu.classList.remove('hidden', 'opacity-0', 'translate-y-[-10px]');
          isMenuOpen = false;
        } else {
          menu.classList.add('hidden', 'opacity-0', 'translate-y-[-10px]');
        }
      });
    })();
  </script>
</header>
