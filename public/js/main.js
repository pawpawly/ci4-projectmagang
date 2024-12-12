document.addEventListener('DOMContentLoaded', () => {
  window.addEventListener('scroll', function () {
      const header = document.getElementById('navbar');
      const logoImg = document.querySelector('.logo img');
      const scrollTop = window.scrollY;

      if (scrollTop > 50) {
          header.classList.add('bg-gray-900', 'shadow-lg');
          header.classList.remove('bg-transparent');
          header.querySelectorAll('a').forEach(a => {
              a.classList.replace('text-white', 'text-white');
          });
          logoImg.src = `${window.location.origin}/pict/iconmuseum.png`;
      } else {
          header.classList.add('bg-transparent');
          header.classList.remove('bg-gray-900', 'shadow-lg');
          header.querySelectorAll('a').forEach(a => {
              a.classList.replace('text-white', 'text-white');
          });
          logoImg.src = `${window.location.origin}/pict/iconmuseumputih.png`;
      }
  });
});
