<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="relative">
    <div class="relative w-full h-[500px] overflow-hidden">
        <!-- Gambar-gambar untuk carousel -->
        <img src="<?= base_url('pict/museum.png'); ?>" alt="Museum 1" class="carousel-image absolute inset-0 w-full h-full object-cover opacity-100 transition-opacity duration-1000">
        <img src="<?= base_url('pict/isimuseum2.png'); ?>" alt="Museum 2" class="carousel-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">
        <img src="<?= base_url('pict/isimuseum3.png'); ?>" alt="Museum 3" class="carousel-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">
    </div>
    <div class="absolute inset-x-0 bottom-0 text-center bg-gradient-to-t from-gray-900/80 to-transparent py-20">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold leading-snug text-white">Museum Kayuh Baimbai Kota Banjarmasin</h2>
            <p class="mt-4 text-lg text-gray-300">"Merawat Tradisi, Mengayuh Sejarah, dan Menginspirasi Generasi."</p>
        </div>
    </div>
</section>

<!-- Icon/Image Section with margins -->
<section class="py-12 bg-white mx-2 md:mx-10">
    <div class="container mx-auto text-center">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="group flex justify-center">
                <img src="<?= base_url('pict/icon.png'); ?>" alt="Icon 1" class="w-auto h-9 md:w-auto md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
            </div>
            <div class="group flex justify-center">
                <img src="<?= base_url('pict/dibanjarmasinaja.png'); ?>" alt="Icon 2" class="w-auto h-5 md:w-auto md:h-5 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
            </div>
            <div class="group flex justify-center">
                <img src="<?= base_url('pict/logodisbudporapar.png'); ?>" alt="Icon 3" class="w-auto h-9 md:w-auto md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
            </div>
            <div class="group flex justify-center">
                <img src="<?= base_url('pict/pesonaindonesia.png'); ?>" alt="Icon 4" class="w-auto h-9 md:w-auto md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
            </div>
        </div>
    </div>
</section>

<!-- JavaScript untuk Carousel -->
<script>
    const images = document.querySelectorAll('.carousel-image');
    let currentImageIndex = 0;

    function changeImage() {
        images[currentImageIndex].classList.remove('opacity-100');
        images[currentImageIndex].classList.add('opacity-0');

        currentImageIndex = (currentImageIndex + 1) % images.length;

        images[currentImageIndex].classList.remove('opacity-0');
        images[currentImageIndex].classList.add('opacity-100');
    }

    setInterval(changeImage, 5000); // Ganti gambar setiap 5 detik
</script>

<!-- Script Counter dan AOS (tidak berubah) -->
<script>
    AOS.init({ once: true });

    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const inc = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    };
</script>

<?= $this->endSection() ?>
