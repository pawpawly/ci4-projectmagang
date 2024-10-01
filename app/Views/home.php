<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="relative">
    <img src="<?= base_url('pict/museum.jpg'); ?>" alt="Hero Image" class="w-full h-[500px] object-cover">
    <div class="absolute inset-x-0 bottom-0 text-center bg-gradient-to-t from-gray-900/80 to-transparent py-20">
      <div class="container mx-auto">
        <h2 class="text-4xl font-bold leading-snug text-white">Museum Kayuh Baimbai Kota Banjarmasin</h2>
        <p class="mt-4 text-lg text-gray-300">"Merawat Tradisi, Mengayuh Sejarah, dan Menginspirasi Generasi."</p>
      </div>
    </div>
</section>

<!-- Icon/Image Section with margins -->
<section class="py-12 bg-gray-100 mx-2 md:mx-10">
    <div class="container mx-auto text-center">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        <!-- Icon 1 -->
        <div class="group flex justify-center">
          <img src="<?= base_url('assets/icon.png'); ?>" alt="Icon 1" class="w-auto h-9 md:w-auto md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
        </div>
        <!-- Icon 2 -->
        <div class="group flex justify-center">
          <img src="<?= base_url('assets/icon.png'); ?>" alt="Icon 2" class="w-auto h-9 md:w-auto md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
        </div>
        <!-- Icon 3 -->
        <div class="group flex justify-center">
          <img src="<?= base_url('assets/icon.png'); ?>" alt="Icon 3" class="w-auto h-9 md:w-auto md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
        </div>
        <!-- Icon 4 -->
        <div class="group flex justify-center">
          <img src="<?= base_url('assets/icon.png'); ?>" alt="Icon 4" class="w-auto h-9 md:w-auto md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
        </div>
      </div>
    </div>
  </section>

  <!-- Visi Misi Section -->
  <section class="py-12 bg-gray-100 px-4 md:px-16">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold text-gray-800 mb-8">VISI & MISI</h2>
      <div class="flex flex-col md:flex-row justify-center space-y-8 md:space-y-0 md:space-x-16">
        <!-- Visi Section -->
        <div class="w-full md:w-1/2">
          <h3 class="text-lg font-bold text-gray-800 mb-4">VISI</h3>
          <p class="text-gray-600 leading-relaxed text-justify mx-auto">
            Pelopor data statistik bagi semua kalangan dengan pendataan secara digital. Dengan visi baru ini, eksistensi BPS sebagai penyedia data dan informasi statistik menjadi semakin penting, karena memegang peran dan pengaruh sentral dalam penyediaan statistik berkualitas tidak hanya di Indonesia, melainkan juga di tingkat dunia.
          </p>
          <p class="text-gray-600 leading-relaxed text-justify mt-4 mx-auto">
            Dengan visi tersebut juga, semakin menguatkan peran BPS sebagai pembina data statistik.
          </p>
        </div>

        <!-- Misi Section -->
        <div class="w-full md:w-1/2">
          <h3 class="text-lg font-bold text-gray-800 mb-4">MISI</h3>
          <p class="text-gray-600 leading-relaxed text-justify mx-auto">
            Menjadi jembatan atau penghubung untuk mendapatkan data antara pengguna dan penyedia layanan data (BPS). Dalam memenuhi kebutuhan masyarakat akan data, buku tamu elektronik memiliki tujuan sebagai berikut:
          </p>
          <ul class="list-none text-gray-600 leading-relaxed text-left mx-auto">
            <li class="flex items-start mb-2">
              <svg class="w-6 h-6 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Mengetahui data jumlah banyaknya tamu yang berkunjung
            </li>
            <li class="flex items-start mb-2">
              <svg class="w-6 h-6 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Mengetahui tujuan penggunaan data dan kunjungan tiap periode
            </li>
            <li class="flex items-start mb-2">
              <svg class="w-6 h-6 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Mendapat timbal balik antara pengunjung dengan layanan BPS
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Milestone Section -->
  <section class="py-20 bg-gray-100 text-gray-900">
    <div class="container mx-auto text-center">
      <!-- Section Title and Description -->
      <h3 class="text-sm font-semibold text-indigo-400" data-aos="fade-up">Our track record</h3>
      <h2 class="text-4xl font-bold mt-2 transition-all hover-scale" data-aos="fade-up">Trusted by thousands of developers worldwide</h2>
      <p class="mt-4 max-w-2xl mx-auto text-gray-600" data-aos="fade-up">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
      </p>

      <!-- Milestone Stats with interactive hover effects -->
      <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <!-- Stat 1 -->
        <div class="transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110" data-aos="fade-up" data-aos-delay="100">
          <h3 class="text-4xl font-bold counter" data-target="8000">0</h3>
          <p class="mt-2 text-gray-600">Developers on the platform</p>
        </div>
        <!-- Stat 2 -->
        <div class="transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110" data-aos="fade-up" data-aos-delay="200">
          <h3 class="text-4xl font-bold counter" data-target="900000000">0</h3>
          <p class="mt-2 text-gray-600">Daily requests</p>
        </div>
        <!-- Stat 3 -->
        <div class="transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110" data-aos="fade-up" data-aos-delay="300">
          <h3 class="text-4xl font-bold counter" data-target="99.9">0.0</h3>
          <p class="mt-2 text-gray-600">Uptime guarantee</p>
        </div>
        <!-- Stat 4 -->
        <div class="transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110" data-aos="fade-up" data-aos-delay="400">
          <h3 class="text-4xl font-bold counter" data-target="12000000">0</h3>
          <p class="mt-2 text-gray-600">Projects deployed</p>
        </div>
      </div>
    </div>
  </section>

  <script>
    // Initialize AOS with 'once: true' to ensure animations only happen once
    AOS.init({
      once: true  // This ensures animations only occur once when elements come into view
    });

    // Counter Animation Script - Only runs once when page is loaded
    const counters = document.querySelectorAll('.counter');
    const speed = 200; // The lower the slower

    counters.forEach(counter => {
      const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;

        const inc = target / speed;

        if(count < target) {
          counter.innerText = Math.ceil(count + inc);
          setTimeout(updateCount, 1);
        } else {
          counter.innerText = target;
        }
      };

      updateCount();
    });

    // Scroll to top of the page on refresh or load
    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    };
  </script>
<?= $this->endSection() ?>
