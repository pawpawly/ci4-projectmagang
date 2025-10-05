<header id="navbar" class="fixed top-0 left-0 w-full z-20 transition-all duration-300 bg-transparent">
  <div class="container mx-auto flex justify-between items-center py-4 px-6">
    <!-- Logo -->
    <div class="logo flex items-center">
      <a href="<?= site_url('./'); ?>">
        <img id="navbarLogo" src="<?= base_url('pict/iconmuseumabu.png'); ?>" alt="Logo" class="h-10 transition-all duration-300">
      </a>
    </div>

    <!-- Tombol Hamburger (hanya muncul di mobile) -->
    <button id="menu-btn" class="md:hidden text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 z-30 transition-colors duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Menu Navigasi -->
    <nav id="menu"
      class="md:flex items-center md:space-x-8 absolute md:static top-full left-0 w-full md:w-auto bg-gray-900 md:bg-transparent px-6 py-4 md:p-0 shadow-lg md:shadow-none transition-all duration-300 ease-in-out menu-mobile-closed">
      <a href="<?= site_url('./');?>" class="block py-2 text-gray-100 hover:text-yellow-400 font-semibold transition-colors duration-300">Beranda</a>
      <a href="<?= site_url('schedule');?>" class="block py-2 text-gray-100 hover:text-yellow-400 font-semibold transition-colors duration-300">Jadwal</a>
      <a href="<?= site_url('koleksi'); ?>" class="block py-2 text-gray-100 hover:text-yellow-400 font-semibold transition-colors duration-300">Koleksi</a>
      <a href="<?= site_url('bukudigital'); ?>" class="block py-2 text-gray-100 hover:text-yellow-400 font-semibold transition-colors duration-300">E-Book</a>
      <a href="<?= site_url('event/index'); ?>" class="block py-2 text-gray-100 hover:text-yellow-400 font-semibold transition-colors duration-300">Event</a>
      <a href="<?= site_url('aboutus');?>" class="block py-2 text-gray-100 hover:text-yellow-400 font-semibold transition-colors duration-300">Tentang Kami</a>
    </nav>
  </div>

  <style>
    /* Hanya berlaku untuk mobile */
    @media (max-width: 767px) {
      .menu-mobile-closed {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
      }
      
      .menu-mobile-open {
        max-height: 500px;
        opacity: 1;
      }
    }
  </style>

  <script>
    (function () {
      const navbar = document.getElementById('navbar');
      const menuBtn = document.getElementById('menu-btn');
      const menu = document.getElementById('menu');
      const logo = document.getElementById('navbarLogo');
      const links = menu.querySelectorAll('a');
      let isOpen = false;
      let scrollTimeout;

      const setNavbarDark = () => {
        navbar.classList.remove('bg-transparent');
        navbar.classList.add('bg-gray-900');
        links.forEach(link => link.classList.replace('text-gray-800', 'text-gray-100'));
        menuBtn.classList.replace('text-gray-800', 'text-gray-100');
        logo.src = "<?= base_url('pict/iconmuseumgray.png'); ?>";
      };

      const setNavbarLight = () => {
        navbar.classList.add('bg-transparent');
        navbar.classList.remove('bg-gray-900');
        links.forEach(link => link.classList.replace('text-gray-100', 'text-gray-800'));
        menuBtn.classList.replace('text-gray-100', 'text-gray-800');
        logo.src = "<?= base_url('pict/iconmuseumabu.png'); ?>";
      };

      // Toggle menu (hanya di mobile)
      menuBtn.addEventListener('click', () => {
        if (!isOpen) {
          menu.classList.remove('menu-mobile-closed');
          menu.classList.add('menu-mobile-open');
          setNavbarDark();
          isOpen = true;
        } else {
          menu.classList.add('menu-mobile-closed');
          menu.classList.remove('menu-mobile-open');
          if (window.scrollY <= 10) setNavbarLight();
          isOpen = false;
        }
      });

      // Tutup menu saat scroll (hanya di mobile)
      window.addEventListener('scroll', () => {
        if (window.scrollY > 10) setNavbarDark();
        else if (!isOpen) setNavbarLight();

        if (isOpen && window.innerWidth < 768) {
          clearTimeout(scrollTimeout);
          scrollTimeout = setTimeout(() => {
            menu.classList.add('menu-mobile-closed');
            menu.classList.remove('menu-mobile-open');
            if (window.scrollY <= 10) setNavbarLight();
            isOpen = false;
          }, 100);
        }
      });

      // Reset saat resize
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
          menu.classList.remove('menu-mobile-closed', 'menu-mobile-open');
          isOpen = false;
        } else if (!isOpen) {
          menu.classList.add('menu-mobile-closed');
          menu.classList.remove('menu-mobile-open');
        }
      });

      // Set awal (saat reload di posisi atas)
      if (window.scrollY <= 10) setNavbarLight();
      else setNavbarDark();
    })();
  </script>
</header>