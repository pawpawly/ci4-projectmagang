document.addEventListener('DOMContentLoaded', () => {
  window.addEventListener('scroll', function () {
      const header = document.getElementById('navbar');
      const logoImg = document.querySelector('.logo img');
      const scrollTop = window.scrollY;

      if (scrollTop > 50) {
          header.classList.add('bg-white', 'shadow-lg');
          header.classList.remove('bg-transparent');
          header.querySelectorAll('a').forEach(a => {
              a.classList.replace('text-white', 'text-gray-900');
          });
          logoImg.src = `${window.location.origin}/pict/iconmuseum.png`;
      } else {
          header.classList.add('bg-transparent');
          header.classList.remove('bg-white', 'shadow-lg');
          header.querySelectorAll('a').forEach(a => {
              a.classList.replace('text-gray-900', 'text-white');
          });
          logoImg.src = `${window.location.origin}/pict/iconmuseumputih.png`;
      }
  });
});
