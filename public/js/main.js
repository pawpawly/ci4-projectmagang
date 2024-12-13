document.addEventListener('DOMContentLoaded', () => {
  window.addEventListener('scroll', function () {
      const header = document.getElementById('navbar');
      const logoImg = document.querySelector('.logo img');
      const scrollTop = window.scrollY;

      if (scrollTop > 50) {
          header.classList.add('bg-gray-900', 'shadow-lg');
          header.classList.remove('bg-transparent');
          header.querySelectorAll('a').forEach(a => {
              a.classList.replace('text-gray-800', 'text-yellow-500');
          });
          logoImg.src = `${window.location.origin}/pict/iconmuseum.png`;
      } else {
          header.classList.add('bg-transparent');
          header.classList.remove('bg-gray-900', 'shadow-lg');
          header.querySelectorAll('a').forEach(a => {
              a.classList.replace('text-yellow-500', 'text-gray-800');
          });
          logoImg.src = `${window.location.origin}/pict/iconmuseumabu.png`;
      }
  });
});
