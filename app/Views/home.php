    <?= $this->extend('homelayout') ?>

    <?= $this->section('content') ?>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <section class="relative">
        <div class="relative w-full h-[500px] overflow-hidden">
            <img src="<?= base_url('pict/museum.png'); ?>" alt="Museum Kayuh Baimbai" class="absolute inset-0 w-full h-full object-cover">
        </div>
        <div class="absolute inset-x-0 bottom-0 text-center bg-gradient-to-t from-gray-900/80 to-transparent py-20">
            <div class="container mx-auto">
                <h2 class="text-4xl font-bold leading-snug text-gray-100 hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">Museum Kayuh Baimbai Kota Banjarmasin</h2>
                <p class="mt-4 text-lg text-gray-300 hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">"Merawat Tradisi, Mengayuh Sejarah, dan Menginspirasi Generasi."</p>
            </div>
        </div>
    </section>
        
    <!-- Section Icon -->
    <section class="py-5 mx-2 md:mx-10" style="background-image: url('<?= base_url('pict/sasiranganabu2.png'); ?>'); background-size: cover; background-position: center;">
        <div class="container mx-auto text-center">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="group flex justify-center">
                    <img src="<?= base_url('pict/icon.png'); ?>" alt="Icon 1" class="w-auto h-9 md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
                </div>
                <div class="group flex justify-center">
                    <img src="<?= base_url('pict/dibanjarmasinaja.png'); ?>" alt="Icon 2" class="w-auto h-5 md:h-5 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
                </div>
                <div class="group flex justify-center">
                    <img src="<?= base_url('pict/logodisbudporapar.png'); ?>" alt="Icon 3" class="w-auto h-9 md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
                </div>
                <div class="group flex justify-center">
                    <img src="<?= base_url('pict/pesonaindonesia.png'); ?>" alt="Icon 4" class="w-auto h-9 md:h-9 transition-all transform grayscale hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">
                </div>
            </div>
        </div>
    </section>

    <!-- ==================================================================================== -->
    <section class="py-12 bg-gray-200">
    <div class="container mx-auto px-8 flex flex-col md:flex-row items-center justify-between">
        <!-- Bagian Kiri: Tulisan Informasi -->
        <div class="w-full md:w-1/2 text-left mb-8 md:mb-0 flex justify-center md:justify-start md:pl-16 lg:pl-32">
            <div class="max-w-lg">
                <!-- Judul -->
                <h1 class="text-4xl md:text-4xl font-bold text-gray-800 leading-snug">
                    Salam Museum Dihati❤️,
                </h1>
                <p class="text-lg text-gray-800 mt-10">
                    Selamat datang di <strong class="font-bold ">Museum Kayuh Baimbai!</strong><br>
                    Jelajahi sejarah masa lalu, masa kini, dan masa depan Sejarah Kota Banjarmasin.
                </p>
                <p class="text-base text-gray-800 mt-4">
                    Kunjungan Museum Kayuh Baimbai Terbuka Untuk Siapa Saja
                    <strong class="text-green-500">Gratis!!</strong>
                </p>

                <!-- Informasi Jam Operasional -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kotak 1 -->
                    <div class="border-2 border-gray-300 rounded-lg p-4 text-center">
                        <p class="text-gray-600 text-sm mb-2">Senin - Jumat</p>
                        <p class="text-xl font-bold text-yellow-500">08:00 - 15.00 WITA</p>
                    </div>
                    <!-- Kotak 2 -->
                    <div class="border-2 border-gray-300 rounded-lg p-6 text-center">
                        <p class="text-gray-600 text-sm mb-2">Hari Sabtu, Minggu dan Hari Libur Nasional <strong class="text-red-500">Museum Tutup</strong>.</p>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="mt-4 text-gray-700 text-sm">
                    <p>Perhatian: Jam kunjungan museum dapat berubah sewaktu-waktu sesuai situasi dan kondisi yang ada.</p>
                </div>

                <!-- Tombol Reservasi -->
                <div class="mt-6 text-center md:text-left">
                    <a href="<?= site_url('schedule');?>" class="inline-block bg-gray-900 text-yellow-500 py-2 px-6 rounded-lg font-semibold shadow-lg hover:bg-gray-600 transition duration-300">
                        Reservasi Kunjungan →
                    </a>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Gambar Animasi -->
        <div class="w-full md:w-1/2 flex justify-center">
            <div id="lottie-anim" class="w-full h-[400px] md:h-[600px]"></div>
        </div>
    </div>
</section>




<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>
<script>
    // Memuat file JSON menggunakan Lottie
    document.addEventListener("DOMContentLoaded", function () {
        lottie.loadAnimation({
            container: document.getElementById("lottie-anim"), // ID container
            renderer: "svg",             // Tipe renderer (SVG, canvas, html)
            loop: true,                  // Animasi diulang terus menerus
            autoplay: true,              // Animasi mulai otomatis
            path: "<?= base_url('js/female-clouds.json'); ?>" // Path ke file JSON
        });
    });
</script>


<!-- ==================================================================================== -->

<!-- Section Koleksi -->
<section class="py-12 bg-gray-200">
    <div class="container mx-auto px-8">


        <!-- Judul Section -->
        <div class="relative text-center mb-8">
            <h2 class="event-overlay text-6xl font-extrabold text-gray-200 mb-2">KOLEKSI</h2>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Koleksi</h2>
        </div>

        <!-- Teks Informasi Koleksi -->
        <div class="text-center mb-8">
            <p class="text-gray-700 text-lg md:text-lg">
                Temui lebih dari <strong class="font-bold"><?= esc($jumlahKoleksi); ?> koleksi</strong>
                warisan budaya Banjar, yang menggambarkan perjalanan sejarah, tradisi, dan kehidupan masyarakat Banjar dari masa ke masa. <br>Rasakan pengalaman menyelami kekayaan budaya yang terus hidup di hati warga Banua.
            </p>
        </div>

        <!-- Swiper Slider -->
        <div class="swiper koleksi-slider">
            <div class="swiper-wrapper">
                <?php foreach ($koleksi as $item): ?>
                    <!-- Slide Koleksi -->
                    <div class="swiper-slide flex justify-center items-center">
                        <div class="relative flex w-[100%] max-w-4xl h-[300px] md:h-[400px] bg-white shadow-lg rounded-lg overflow-hidden">
                            <!-- Gambar Koleksi -->
                            <div class="relative w-full h-full">
                                <img src="<?= base_url('uploads/koleksi/' . $item['FOTO_KOLEKSI']); ?>" 
                                     alt="<?= esc($item['NAMA_KOLEKSI']); ?>" 
                                     class="absolute inset-0 w-full h-full object-cover"
                                     onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'600\'%3E%3Crect width=\'100%25\' height=\'100%25\' fill=\'%23e5e7eb\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'%236b7280\' font-family=\'Arial\' font-size=\'24\'%3EImage not found%3C/text%3E%3C/svg%3E'">
                            </div>
                            <!-- Deskripsi Koleksi (Hanya di Slide Tengah) -->
                            <div class="deskripsi hidden absolute inset-0 flex flex-col justify-center p-6 bg-white opacity-0 transition-opacity duration-300">
                                <h3 class="text-lg md:text-2xl font-bold mb-2 text-gray-800"><?= esc($item['NAMA_KOLEKSI']); ?></h3>
                                <p class="text-sm md:text-base text-gray-600 leading-relaxed line-clamp-3">
                                    <?= substr(esc($item['DESKRIPSI_KOLEKSI']), 0, 100); ?>...
                                </p>
                                <a href="<?= site_url('koleksi/detail/' . $item['ID_KOLEKSI']); ?>" 
                                   class="mt-4 text-yellow-500 font-semibold text-sm hover:underline">
                                    Selengkapnya →
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tombol Lihat Koleksi Lebih Banyak -->
        <div class="text-center mt-8">
            <a href="<?= site_url('koleksi'); ?>" 
               class="inline-block bg-gray-900 text-yellow-500 py-2 px-6 rounded-lg font-semibold shadow-lg hover:bg-gray-600 transition duration-300">
                Lihat Koleksi Lebih Banyak
            </a>
        </div>
    </div>
</section>





    <!-- Forum Section -->
    <section class="py-12 bg-gray-200">
        <div class="container mx-auto px-8">
            <div class="relative text-center">
                <h2 class="event-overlay">FORUM</h2> <!-- Overlay -->
                <h2 class="event-heading text-4xl font-bold mb-8 hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">Forum</h2>
            </div>

            <?php if (!empty($berita) && is_array($berita)): ?>
                <div class="forum-grid-wrapper">
                    <div class="forum-grid grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto"> 
                        <!-- 2 berita per baris pada layar medium dan besar -->
                        <?php foreach (array_slice($berita, 0, 3) as $item): ?>
                            <div class="forum-card relative">
                            <div class="forum-image-wrapper overflow-hidden rounded-lg relative">
                                <a href="<?= site_url('berita/' . $item['ID_BERITA']); ?>"> 
                                    <img src="<?= base_url('uploads/berita/' . $item['FOTO_BERITA']); ?>"
                                         alt="<?= esc($item['NAMA_BERITA']); ?>"
                                         class="forum-image transition-transform duration-300 ease-in-out hover:scale-105"
                                         onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'600\'%3E%3Crect width=\'100%25\' height=\'100%25\' fill=\'%23e5e7eb\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'%236b7280\' font-family=\'Arial\' font-size=\'24\'%3EImage not found%3C/text%3E%3C/svg%3E'">
                                    <!-- Inner Shadow -->
                                    <div class="absolute inset-0 pointer-events-none rounded-lg" 
                                         style="box-shadow: inset 0 -30px 100px -10px rgba(0, 0, 0, 0.5);"></div>
                                </a>
                            </div>
                                <div class="absolute bottom-4 left-4 text-gray-100">
                                    <p class="text-sm"><?= formatTanggalIndonesia($item['TANGGAL_BERITA']); ?></p>
                                    <h3 class="mt-1 text-xl font-semibold">
                                    <a href="<?= site_url('berita/' . $item['ID_BERITA']); ?>"
                                        class="hover:text-yellow-600 transition duration-300 ease-in-out">
                                            <?= esc($item['NAMA_BERITA']); ?>
                                        </a>
                                    </h3>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="text-center mt-8">
                    <a href="<?= site_url('berita'); ?>" 
                    class="bg-gray-900 text-yellow-500 py-2 px-6 font-semibold rounded-lg hover:bg-gray-600">
                    Lihat Berita Lebih Banyak
                    </a>
                </div>         
            <?php else: ?>
                <p class="text-center text-gray-500">Tidak ada berita tersedia saat ini.</p>
            <?php endif; ?>
        </div>
    </section>


        <!-- Section Kayuh Baimbai Instagram -->
        <section class="py-12 bg-gray-200">
        <div class="container mx-auto max-w-7xl px-4">
            <!-- Judul Section -->
            <div class="relative text-center mb-8">
                <h2 class="event-overlay">IG KAYUH BAIMBAI</h2>
                <h2 class="text-4xl font-bold text-gray-900 mb-4 hover:scale-105 transition-transform duration-300">
                    IG KAYUH BAIMBAI
                </h2>
            </div>

            <!-- Grid Instagram Posts -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Instagram Post 1 -->
                <div>
                    <iframe width="100%" height="560" src="https://www.instagram.com/reel/C4HOU9pS-ki/embed" frameborder="0" scrolling="no" allowtransparency="true" class="rounded-xl shadow-lg"></iframe>
                </div>
                <!-- Instagram Post 2 -->
                <div>
                    <iframe width="100%" height="560" src="https://www.instagram.com/reel/DDvt1eZTABR/embed" frameborder="0" scrolling="no" allowtransparency="true" class="rounded-xl shadow-lg"></iframe>
                </div>
                <!-- Instagram Post 3 -->
                <div>
                    <iframe width="100%" height="560" src="https://www.instagram.com/reel/C36m9gxxHZP/embed" frameborder="0" scrolling="no" allowtransparency="true" class="rounded-xl shadow-lg"></iframe>
                </div>
            </div>

            <!-- Tombol Lihat Lainnya -->
            <div class="text-center mt-8">
                <a href="https://www.instagram.com/museum_kayuhbaimbai?igsh=MTcyeWQ5OTA2andjYw==" target="_blank" 
                class="bg-gray-900 text-yellow-500 px-8 py-3 rounded-lg font-semibold shadow-lg hover:bg-gray-600 transition-transform duration-300">
                    Lihat Lainnya
                </a>
            </div>
        </div>
    </section>

    
    <!-- Saran Section -->
    <section class="py-12 bg-gray-200" style="background-image: url('<?= base_url('pict/mountain3.png'); ?>'); background-size: cover; background-position: center;">
        <div class="container mx-auto px-8">
            <div class="relative text-center mb-12">
                <h2 class="event-overlay text-6xl font-extrabold text-gray-200 mb-2">SARAN</h2>
                <h2 class="text-4xl font-bold text-gray-900 mb-4 hover:scale-105 transition-transform duration-300">SARAN</h2>
            </div>
            <p class="text-gray-700 text-center md:text-lg px-20">Kami sangat menghargai masukan dan saran Anda untuk meningkatkan layanan kami.</p>
            <div class="max-w-3xl mx-auto p-10">
            <form id="saranForm" class="space-y-8" autocomplete="off">


        <div>
            <label for="NAMA_SARAN" class="block text-gray-900 text-lg font-semibold">Nama*</label>
            <input type="text" id="NAMA_SARAN" name="NAMA_SARAN" autocomplete="off" class="mt-2 block w-full p-4 border border-gray-400 rounded-md focus:ring-2 focus:ring-yellow-500 focus:outline-none hover:shadow-md transition-shadow duration-200" placeholder="Nama Anda">
        </div>

        <div>
            <label for="EMAIL_SARAN" class="block text-gray-900 text-lg font-semibold">Email*</label>
            <input type="text" id="EMAIL_SARAN" name="EMAIL_SARAN" autocomplete="off" class="mt-2 block w-full p-4 border border-gray-400 rounded-md focus:ring-2 focus:ring-yellow-500 focus:outline-none hover:shadow-md transition-shadow duration-200" placeholder="Email Anda">
        </div>

        <div>
            <label for="KOMENTAR_SARAN" class="block text-gray-900 text-lg font-semibold">Saran*</label>
            <textarea id="KOMENTAR_SARAN" name="KOMENTAR_SARAN" rows="5" autocomplete="off" class="mt-2 block w-full p-4 border border-gray-400 rounded-md resize-none overflow-y-auto focus:ring-2 focus:ring-yellow-500 focus:outline-none hover:shadow-md transition-shadow duration-200" placeholder="Tulis saran Anda di sini..."></textarea>
        </div>

          <!-- Tambahkan reCAPTCHA -->
    <div class="g-recaptcha" data-sitekey="6Lex854qAAAAAOXI-dTJvt2LLR85jJF63NRXPePe"></div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <div class="text-center">
            <button type="submit" id="submitBtn" class="px-8 py-3 bg-gray-900 text-yellow-500 font-bold rounded-lg hover:bg-gray-600 hover:shadow-lg transition duration-300">Kirim</button>
        </div>
    </form>


            </div>
        </div>
    </section>
    
    <!-- Tombol Scroll to Top -->
    <button id="scrollTopButton" 
    class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-yellow-500 shadow-lg 
    flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300"
    style="z-index: 9999;">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>


    <style>
        html, body {
    overflow-x: hidden; /* Hilangkan overflow horizontal */
    max-width: 100%; /* Pastikan lebar tidak lebih dari viewport */
    margin: 0; /* Hapus margin default */
}
    /* Styling untuk Swiper Event */
    .swiper-container {
        padding-bottom: 2   0px;
        width: 100%; /* Kurangi 50px kiri dan kanan */
        margin: 0 auto;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
        margin: 10px 5px; /* Atur jarak antar slide */
        width: auto; /* Pastikan slide sesuai kontainer */
        min-width: 0; /* Batasi lebar minimum */
    }

    .event-item {
        width: 200px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 350px;
        justify-content: space-between;
    }

    /* Tombol Navigasi Swiper */
    .swiper-button-next, .swiper-button-prev {
        color: #007bff;
        width: 30px;
        height: 30px;
    }
    

    .swiper-pagination {
        margin-top: 20px;
        text-align: center;
    }

    .swiper-pagination-bullet {
        background: #007bff;
    }

    /* Overlay dan Heading */
    .event-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 65px;
        font-weight: bold;
        color: rgba(0, 0, 0, 0.1);
        z-index: 0;
        pointer-events: none;
    }

    .event-heading {
        position: relative;
        z-index: 10;
        text-transform: uppercase;
    }

    .carousel-wrapper {
        position: relative;
        overflow: hidden;
        margin: 0 auto;
        max-width: 880px;
    }

    .event-item {
        width: 200px;
    }

    #eventCarousel {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    #eventCarousel::-webkit-scrollbar {
        display: none;
    }

    .nav-button {
        background-color: gray;
        color: white;
        border: none;
        padding: 1px 20px;
        cursor: pointer;
        font-weight: bold;
        font-size: 1.5rem;
        transition: background-color 0.3s ease-in-out;
    }

    .nav-button:hover {
        background-color: #4A2A2C;
    }
    .grabbing {
        cursor: grabbing;
        cursor: -webkit-grabbing;
    }

    /* Forum Section Layout */
    .forum-grid-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
        max-width: 1200px;
    }

    .forum-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    /* Gambar dengan efek hover zoom */
    .forum-image-wrapper {
        overflow: hidden;
        border-radius: 8px;
        transition: transform 0.3s ease-in-out;
    }

    .forum-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
    }

    .forum-card:hover .forum-image {
        transform: scale(1.1);
    }

    /* Judul berita dengan ellipsis dan efek underline */
    .forum-title {
        position: relative;
        display: inline-block;
        color: #2C1011;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .forum-title::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #2C1011;
        transition: width 0.3s ease-in-out;
    }

    .forum-title:hover::before {
        width: 100%;
    }

    /* Styling untuk responsif */
    @media (max-width: 768px) {
        .forum-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ============================================ */
    .koleksi-slider {
    width: 100%;
    overflow: hidden;
}

.koleksi-slider .swiper-slide {
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
    opacity: 0.5;
    transform: scale(0.8); /* Slide kiri-kanan lebih kecil */
}

.koleksi-slider .swiper-slide-active {
    opacity: 1;
    transform: scale(1); /* Slide tengah lebih besar */
    z-index: 10;
}

/* Tampilkan deskripsi hanya untuk slide aktif */
.koleksi-slider .swiper-slide-active .deskripsi {
    opacity: 1;
    display: flex;
}

.koleksi-slider .swiper-slide .deskripsi {
    display: none; /* Sembunyikan deskripsi di slide lain */
}

/* Hilangkan jarak antar slide */
.koleksi-slider .swiper-wrapper {
    display: flex;
    align-items: center;
    padding: 0;
    margin: 0;
}

.line-clamp-3 {
    display: -webkit-box;
    line-clamp: 3;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}





    /* ============================================ */


    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>


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

            document.addEventListener('DOMContentLoaded', function () {
                const swiperEvent = new Swiper('.swiper-container', {
    loop: false,  // Menonaktifkan loop, tidak akan ada perulangan
    grabCursor: true,  // Menampilkan kursor grab saat menyeret
    autoplay: {
        delay: 4000,  // Slide otomatis setiap 4 detik
        disableOnInteraction: false,  // Biarkan autoplay berjalan meskipun ada interaksi
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    slidesPerView: 1,  // Menampilkan 1 slide per tampilan (default untuk perangkat kecil)
    spaceBetween: 10,  // Mengurangi jarak antar slide
    breakpoints: {
        640: { slidesPerView: 2 },  // Jika lebar layar >= 640px, tampilkan 2 slide
        1024: { slidesPerView: 4 },  // Jika lebar layar >= 1024px, tampilkan 4 slide
    },
});
                // Custom controls for swiper
                const leftArrow = document.querySelector('.swiper-button-prev');
                const rightArrow = document.querySelector('.swiper-button-next');

                leftArrow.addEventListener('click', () => swiperEvent.slidePrev());
                rightArrow.addEventListener('click', () => swiperEvent.slideNext());
            });
        
    document.getElementById('saranForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const nama = document.getElementById('NAMA_SARAN').value.trim();
    const email = document.getElementById('EMAIL_SARAN').value.trim();
    const saran = document.getElementById('KOMENTAR_SARAN').value.trim();

    document.getElementById('saranForm').addEventListener('submit', function (e) {
    const recaptchaResponse = grecaptcha.getResponse(); // Ambil respons reCAPTCHA
    const captchaError = document.getElementById('captchaError');

    if (!recaptchaResponse) {
        e.preventDefault(); // Cegah pengiriman form
        captchaError.classList.remove('hidden'); // Tampilkan pesan error
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Verifikasi CAPTCHA diperlukan. Silakan centang reCAPTCHA.',
        });
    } else {
        captchaError.classList.add('hidden'); // Sembunyikan pesan error jika valid
    }
});

    if (!nama || !email || !saran) {
        Swal.fire({
            title: 'Oops!',
            text: 'Semua field wajib diisi!',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }

    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Mengirim... <svg class="animate-spin h-5 w-5 text-white inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>';

    fetch('<?= site_url("saran/saveSaran") ?>', {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            Swal.fire({
                icon: data.icon || 'error', // Gunakan ikon dari backend
                title: 'Gagal!',
                text: data.message
            });
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message
            }).then(() => {
                window.location.reload();
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan pada server.'
        });
        console.error('Error:', error);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = "Kirim";
    });
});

        // Fungsi untuk mengatur posisi scroll ke atas saat halaman di-refresh
        window.onbeforeunload = function () {
            window.scrollTo(0, 0);
        };


        // Fungsi Drag dengan Grabbing
        let isDown = false;
        let startX;
        let scrollLeft;
        const eventCarousel = document.querySelector('.swiper-wrapper');
        if (eventCarousel) {
        eventCarousel.addEventListener('mousedown', (e) => {
            isDown = true;
            eventCarousel.classList.add('grabbing');
            startX = e.pageX - eventCarousel.offsetLeft;
            scrollLeft = eventCarousel.scrollLeft;
        });

        eventCarousel.addEventListener('mouseleave', () => {
            isDown = false;
            eventCarousel.classList.remove('grabbing');
        });

        eventCarousel.addEventListener('mouseup', () => {
            isDown = false;
            eventCarousel.classList.remove('grabbing');
        });

        eventCarousel.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - eventCarousel.offsetLeft;
            const walk = (x - startX) * 2; // Sensitivitas drag
            eventCarousel.scrollLeft = scrollLeft - walk;
        });
        }

        // Sembunyikan Tombol Navigasi jika Tidak Ada Event
        if (!eventCarousel || eventCarousel.children.length === 0) {
            const leftArrow = document.querySelector('.swiper-button-prev');
            const rightArrow = document.querySelector('.swiper-button-next');
            if (leftArrow) leftArrow.style.display = 'none';
            if (rightArrow) rightArrow.style.display = 'none';
            document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Swiper untuk Event Section
        const swiperEvent = new Swiper('.swiper-container', {
            loop: true,  // Agar swiper berulang
            grabCursor: true,  // Menampilkan kursor grab saat menyeret
            autoplay: {
                delay: 4000,  // Slide otomatis setiap 4 detik
                disableOnInteraction: false,  // Biarkan autoplay berjalan meskipun ada interaksi
            },
            pagination: {
                el: '.swiper-pagination',  // Menampilkan pagination (dot) jika diinginkan
                clickable: true,  // Memungkinkan pengguna mengklik pagination untuk berpindah slide
            },
            navigation: {
                nextEl: '.swiper-button-next',  // Tombol navigasi "Next"
                prevEl: '.swiper-button-prev',  // Tombol navigasi "Prev"
            },
            slidesPerView: 1,  // Menampilkan 1 slide per tampilan (default untuk perangkat kecil)
            spaceBetween: 20,  // Jarak antar slide
            breakpoints: {
                640: { slidesPerView: 2 },  // Jika lebar layar >= 640px, tampilkan 2 slide
                1024: { slidesPerView: 3 },  // Jika lebar layar >= 1024px, tampilkan 3 slide
            },
        });
        
        // Fetch data ketika tahun diganti untuk bagian lain
        const yearSelector = document.getElementById('yearSelector');
        if (yearSelector) {
        yearSelector.addEventListener('change', function () {
            const selectedYear = yearSelector.value;
            fetch(`<?= site_url('superadmin/statistik/bulanan') ?>?year=${selectedYear}`)
                .then(response => response.json())
                .then(data => {
                    // Update data grafik jika ada data tahun baru
                    monthlyChart.data.datasets[0].data = data.laki;
                    monthlyChart.data.datasets[1].data = data.perempuan;
                    monthlyChart.update();
                    document.getElementById('totalMale').textContent = data.laki.reduce((a, b) => a + b, 0);
                    document.getElementById('totalFemale').textContent = data.perempuan.reduce((a, b) => a + b, 0);
                    document.getElementById('totalVisitors').textContent = document.getElementById('totalMale').textContent + document.getElementById('totalFemale').textContent;
                })
                .catch(error => console.error('Error:', error));
        });
        }

        // Untuk Tombol Navigasi
        const leftArrow = document.getElementById('leftArrow');
        const rightArrow = document.getElementById('rightArrow');

        if (leftArrow) {
            leftArrow.addEventListener('click', () => {
                swiperEvent.slidePrev();  // Swipe ke slide sebelumnya
            });
        }

        if (rightArrow) {
            rightArrow.addEventListener('click', () => {
                swiperEvent.slideNext();  // Swipe ke slide berikutnya
            });
        }

        // Mencegah aksi default pada mouse drag untuk penggeser
        let isDown = false;
        let startX;
        let scrollLeft;

        const eventCarousel = document.querySelector('.swiper-wrapper'); // Mengambil container slide
        if (eventCarousel) {
        eventCarousel.addEventListener('mousedown', (e) => {
            isDown = true;
            eventCarousel.classList.add('grabbing');
            startX = e.pageX - eventCarousel.offsetLeft;
            scrollLeft = eventCarousel.scrollLeft;
        });

        eventCarousel.addEventListener('mouseleave', () => {
            isDown = false;
            eventCarousel.classList.remove('grabbing');
        });

        eventCarousel.addEventListener('mouseup', () => {
            isDown = false;
            eventCarousel.classList.remove('grabbing');
        });

        eventCarousel.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - eventCarousel.offsetLeft;
            const walk = (x - startX) * 2; // Sensitivitas drag
            eventCarousel.scrollLeft = scrollLeft - walk;
        });
        }
    });

    }

    const carouselInner = document.getElementById('carouselInner');
    const indicators = document.querySelectorAll('.indicator');
    const carouselText = document.getElementById('carouselText'); // Ambil elemen teks di bawah carousel
    const slideCount = indicators.length;
    let currentIndex = 0;

    // Variabel untuk drag
    let isDragging = false;
    let startPos = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;

    // Text untuk setiap slide
    const slideTexts = [
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
        "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris."
    ];

    // Prevent default untuk drag
    if (carouselInner) {
    carouselInner.addEventListener('mousedown', (e) => {
        e.preventDefault(); // Mencegah default behavior
        startDrag(e);
    });
    carouselInner.addEventListener('touchstart', (e) => {
        e.preventDefault(); // Mencegah default behavior
        startDrag(e);
    });

    carouselInner.addEventListener('mousemove', drag);
    carouselInner.addEventListener('touchmove', drag);

    carouselInner.addEventListener('mouseup', endDrag);
    carouselInner.addEventListener('touchend', endDrag);

    carouselInner.addEventListener('mouseleave', () => {
        if (isDragging) endDrag();
    });
    }

    function startDrag(event) {
        isDragging = true;
        startPos = getPositionX(event);
        carouselInner.style.transition = 'none'; // Matikan transisi saat drag
    }

    function drag(event) {
        if (isDragging) {
            const currentPosition = getPositionX(event);
            currentTranslate = prevTranslate + currentPosition - startPos;
            carouselInner.style.transform = `translateX(${currentTranslate}px)`;
        }
    }

    function endDrag() {
        isDragging = false;
        const movedBy = currentTranslate - prevTranslate;

        if (movedBy < -100 && currentIndex < slideCount - 1) currentIndex++;
        if (movedBy > 100 && currentIndex > 0) currentIndex--;

        setPositionByIndex();
    }

    function setPositionByIndex() {
        const slideWidth = carouselInner.offsetWidth;
        currentTranslate = currentIndex * -slideWidth;
        prevTranslate = currentTranslate;
        carouselInner.style.transition = 'transform 0.5s ease';
        carouselInner.style.transform = `translateX(${currentTranslate}px)`;
        updateCarousel(currentIndex);
    }

    function getPositionX(event) {
        return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
    }

    function updateCarousel(index) {
        // Update indikator
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('bg-gray-800', i === index);
            indicator.classList.toggle('bg-gray-300', i !== index);
        });

        // Update teks di bawah carousel
        carouselText.textContent = slideTexts[index];
    }

    // Auto Slide
    if (carouselInner && slideCount > 0) {
        setInterval(() => {
            currentIndex = (currentIndex + 1) % slideCount;
            setPositionByIndex();
        }, 5000);
    }

    // Inisialisasi awal
    if (carouselInner) {
        updateCarousel(currentIndex);
    }
    </script>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Swiper Koleksi
        new Swiper('.koleksi-slider', {
            loop: true,
            centeredSlides: true,
            slidesPerView: 3, // Hanya tampilkan 3 koleksi
            spaceBetween: 0,  // Hilangkan jarak antar slide
            grabCursor: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
        });
    });
</script>



    <?= $this->endSection() ?>
