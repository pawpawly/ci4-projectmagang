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

<section class="py-12 bg-gradient-to-r from-[#b09091] to-white">
    <div class="container mx-auto px-8 relative">
        <h2 class="text-4xl font-bold text-gray-900 text-center mb-8">Event</h2>

        <!-- Tombol Panah Kiri -->
        <button id="leftArrow" 
                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-[#2C1011] rounded-full p-3 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Carousel Container -->
        <div class="overflow-hidden max-w-[960px] mx-auto px-12"> <!-- Lebar dibatasi agar hanya 3 event -->
            <div id="eventCarousel" class="flex space-x-4 overflow-x-auto snap-x snap-mandatory">
                <?php foreach ($events as $event): ?>
                    <div class="flex-none w-[280px] bg-white shadow-md snap-center">
                        <img 
                            src="<?= base_url('uploads/poster/' . $event['FOTO_EVENT']); ?>" 
                            alt="<?= esc($event['NAMA_EVENT']); ?>" 
                            class="h-40 w-full object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold truncate"><?= esc($event['NAMA_EVENT']); ?></h3>
                            <p class="text-gray-600"><?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?></p>
                            <p class="text-sm text-gray-500 mt-2 truncate"><?= esc($event['DEKSRIPSI_EVENT']); ?></p>
                            <a href="<?= site_url('event/' . urlencode($event['NAMA_EVENT'])); ?>" 
                               class="block mt-4 bg-[#2C1011] text-white text-center py-2 rounded-full hover:bg-[#4A2A2C] text-xs">
                               Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tombol Panah Kanan -->
        <button id="rightArrow" 
                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-[#2C1011] rounded-full p-3 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
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


    const carousel = document.getElementById('eventCarousel');
const leftArrow = document.getElementById('leftArrow');
const rightArrow = document.getElementById('rightArrow');
let isDragging = false;
let startPos = 0;
let scrollLeft = 0;
let velocity = 0;
let lastMove = 0;
let animationFrame;

// Fungsi Momentum Scroll
function smoothMomentumScroll() {
    if (Math.abs(velocity) > 0.1) {
        carousel.scrollLeft -= velocity;
        velocity *= 0.95; // Perlambatan momentum
        animationFrame = requestAnimationFrame(smoothMomentumScroll);
    } else {
        cancelAnimationFrame(animationFrame);
    }
}

// Event Drag
carousel.addEventListener('mousedown', (e) => {
    isDragging = true;
    startPos = e.pageX - carousel.offsetLeft;
    scrollLeft = carousel.scrollLeft;
    velocity = 0;
    cancelAnimationFrame(animationFrame);
    carousel.classList.add('dragging');
});

carousel.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - carousel.offsetLeft;
    const deltaX = x - startPos;
    velocity = deltaX - lastMove;
    carousel.scrollLeft = scrollLeft - deltaX;
    lastMove = deltaX;
});

carousel.addEventListener('mouseup', () => {
    isDragging = false;
    carousel.classList.remove('dragging');
    animationFrame = requestAnimationFrame(smoothMomentumScroll);
});

carousel.addEventListener('mouseleave', () => {
    if (isDragging) {
        isDragging = false;
        carousel.classList.remove('dragging');
        animationFrame = requestAnimationFrame(smoothMomentumScroll);
    }
});

// Event Touch untuk Mobile
carousel.addEventListener('touchstart', (e) => {
    isDragging = true;
    startPos = e.touches[0].pageX - carousel.offsetLeft;
    scrollLeft = carousel.scrollLeft;
    velocity = 0;
    cancelAnimationFrame(animationFrame);
});

carousel.addEventListener('touchmove', (e) => {
    if (!isDragging) return;
    const x = e.touches[0].pageX - carousel.offsetLeft;
    const deltaX = x - startPos;
    velocity = deltaX - lastMove;
    carousel.scrollLeft = scrollLeft - deltaX;
    lastMove = deltaX;
});

carousel.addEventListener('touchend', () => {
    isDragging = false;
    animationFrame = requestAnimationFrame(smoothMomentumScroll);
});

// Event Tombol Panah
leftArrow.addEventListener('click', () => {
    carousel.scrollBy({ left: -300, behavior: 'smooth' });
});

rightArrow.addEventListener('click', () => {
    carousel.scrollBy({ left: 300, behavior: 'smooth' });
});






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

#eventCarousel {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    gap: 16px;
    scrollbar-width: none; /* Hilangkan scrollbar di Firefox */
    -ms-overflow-style: none; /* Hilangkan scrollbar di IE */
    scroll-behavior: smooth; /* Smooth scroll behavior */
    padding-left: 12px;
    padding-right: 12px;
}

#eventCarousel::-webkit-scrollbar {
    display: none; /* Hilangkan scrollbar di Chrome */
}

#eventCarousel > div {
    scroll-snap-align: center;
    flex: 0 0 auto;
    width: 280px; /* Tetap 280px */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Berikan bayangan */
}

button {
    cursor: pointer;
}

.dragging {
    cursor: grabbing;
    user-select: none;
}


@media (min-width: 768px) {
    #eventCarousel > div {
        width: 200px; /* Tetap 280px di layar besar */
    }

    #leftArrow {
    left: 180px; /* Posisikan lebih dekat ke carousel */
}

#rightArrow {
    right: 180px; /* Posisikan lebih dekat ke carousel */
}

}





</style>


<?= $this->endSection() ?>
