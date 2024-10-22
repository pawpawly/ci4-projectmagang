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

<!-- Tombol Scroll to Top -->
<button id="scrollTopButton" 
    class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-yellow-500 shadow-lg 
    flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#2C1011]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>

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

        // Scroll ke atas ketika tombol diklik
document.getElementById('scrollTopButton').addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Pantau scroll dan tampilkan/hilangkan tombol
window.addEventListener('scroll', () => {
    const scrollTopButton = document.getElementById('scrollTopButton');
    if (window.scrollY > 100) { // Jika scroll lebih dari 100px
        scrollTopButton.classList.add('opacity-100');
        scrollTopButton.classList.remove('opacity-0', 'pointer-events-none');
    } else {
        scrollTopButton.classList.remove('opacity-100');
        scrollTopButton.classList.add('opacity-0', 'pointer-events-none');
    }
});

    // Scroll ke bagian atas saat halaman dimuat atau di-refresh
    window.onbeforeunload = function () {
      window.scrollTo(0, 0);
    };
</script>

<style>
    #scrollTopButton {
    transition: opacity 0.3s ease-in-out;
}

.opacity-0 {
    opacity: 0;
}

.opacity-100 {
    opacity: 1;
}

</style>


<?= $this->endSection() ?>
