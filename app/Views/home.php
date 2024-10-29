<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="relative">
    <div class="relative w-full h-[500px] overflow-hidden">
        <img src="<?= base_url('pict/museum.png'); ?>" alt="Museum 1" class="carousel-image absolute inset-0 w-full h-full object-cover opacity-100 transition-opacity duration-1000">
        <img src="<?= base_url('pict/isimuseum2.png'); ?>" alt="Museum 2" class="carousel-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">
        <img src="<?= base_url('pict/isimuseum3.png'); ?>" alt="Museum 3" class="carousel-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">
    </div>
    <div class="absolute inset-x-0 bottom-0 text-center bg-gradient-to-t from-gray-900/80 to-transparent py-20">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold leading-snug text-white hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">Museum Kayuh Baimbai Kota Banjarmasin</h2>
            <p class="mt-4 text-lg text-gray-300 hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">"Merawat Tradisi, Mengayuh Sejarah, dan Menginspirasi Generasi."</p>
        </div>
    </div>
</section>

<!-- Section Icon -->
<section class="py-5 bg-white mx-2 md:mx-10">
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

<!-- Event Section -->
<section class="py-12 bg-gradient-to-b from-white to-[#B09091] relative overflow-hidden">
    <div class="container mx-auto px-8 relative">
        <div class="relative text-center">
            <h2 class="event-overlay">EVENT</h2>
            <h2 class="event-heading text-4xl font-bold mb-8 hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">Event</h2>
        </div>

        <?php if (!empty($events) && is_array($events)): ?>
            <div class="carousel-wrapper relative">
                <div id="eventCarousel" class="carousel flex gap-6 overflow-hidden snap-x snap-mandatory">
                    <?php foreach ($events as $event): ?>
                        <div class="event-item flex-none w-[200px] bg-white shadow-md rounded-lg snap-center p-4 select-none">
                            <img 
                                src="<?= base_url('uploads/poster/' . $event['FOTO_EVENT']); ?>" 
                                alt="<?= esc($event['NAMA_EVENT']); ?>" 
                                class="rounded-md h-40 w-full object-cover">
                            <h3 class="text-lg font-semibold truncate mt-2"><?= esc($event['NAMA_EVENT']); ?></h3>
                            <p class="text-gray-600"><?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?></p>
                            <p class="text-sm text-gray-500 mt-2 truncate"><?= esc($event['DEKSRIPSI_EVENT']); ?></p>
                            <a href="<?= site_url('event/' . urlencode($event['NAMA_EVENT'])); ?>" 
                               class="block mt-4 bg-[#2C1011] text-white text-center font-semibold py-2 rounded-full hover:bg-[#4A2A2C] text-xs">
                               Baca Selengkapnya
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Tombol Navigasi -->
                <div class="flex justify-center gap-4 mt-4">
                    <button id="leftArrow" class="nav-button"><</button>
                    <button id="rightArrow" class="nav-button">></button>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 text-lg mt-2">Tidak ada event yang tersedia saat ini.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Forum Section -->
<section class="py-12 bg-gradient-to-b from-[#B09091] to-white relative overflow-hidden">
    <div class="container mx-auto px-8">
        <div class="relative text-center">
            <h2 class="event-overlay">FORUM</h2> <!-- Overlay -->
            <h2 class="event-heading text-4xl font-bold mb-8 hover:grayscale-0 hover:scale-105 duration-300 ease-in-out">Forum</h2>
        </div>

        <?php if (!empty($berita) && is_array($berita)): ?>
            <div class="forum-grid-wrapper">
                <div class="forum-grid grid-cols-2"> <!-- 2 berita per baris -->
                    <?php foreach (array_slice($berita, 0, 4) as $item): ?>
                        <div class="forum-card">
                            <div class="forum-image-wrapper">
                                <a href="<?= site_url('berita/' . urlencode($item['NAMA_BERITA'])); ?>"> <!-- Link ke detail berita -->
                                    <img src="<?= base_url('uploads/berita/' . $item['FOTO_BERITA']); ?>"
                                         alt="<?= esc($item['NAMA_BERITA']); ?>"
                                         class="forum-image">
                                </a>
                            </div>
                            <p class="text-gray-600 mt-2"><?= formatTanggalIndonesia($item['TANGGAL_BERITA']); ?></p>
                            <h3 class="forum-title mt-1 text-lg font-semibold">
                                <a href="<?= site_url('berita/' . urlencode($item['NAMA_BERITA'])); ?>" 
                                   class="hover:text-red-400 transition duration-300 ease-in-out">
                                    <?= esc($item['NAMA_BERITA']); ?>
                                </a>
                            </h3>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="<?= site_url('berita'); ?>" 
                   class="bg-red-900 text-white py-2 px-6 rounded-full hover:bg-red-700">
                   Lihat Berita Lebih Banyak
                </a>
            </div>         
        <?php else: ?>
            <p class="text-center text-gray-500">Tidak ada berita tersedia saat ini.</p>
        <?php endif; ?>
    </div>
</section>



<style>
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




</style>

<script>
    const eventCarousel = document.getElementById('eventCarousel');
    const leftArrow = document.getElementById('leftArrow');
    const rightArrow = document.getElementById('rightArrow');

    // Fungsi Scroll Langsung ke Ujung Kiri atau Kanan
    leftArrow.addEventListener('click', () => {
        eventCarousel.scrollTo({ left: 0, behavior: 'smooth' });
    });

    rightArrow.addEventListener('click', () => {
        eventCarousel.scrollTo({ left: eventCarousel.scrollWidth, behavior: 'smooth' });
    });

    // Fungsi Drag dengan Grabbing
    let isDown = false;
    let startX;
    let scrollLeft;

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

    // Sembunyikan Tombol Navigasi jika Tidak Ada Event
    if (!eventCarousel || eventCarousel.children.length === 0) {
        leftArrow.style.display = 'none';
        rightArrow.style.display = 'none';


const forumCarousel = document.getElementById('forumCarousel');
let isDown = false;
let startX;
let scrollLeft;

forumCarousel.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - forumCarousel.offsetLeft;
    scrollLeft = forumCarousel.scrollLeft;
});

forumCarousel.addEventListener('mouseleave', () => {
    isDown = false;
});

forumCarousel.addEventListener('mouseup', () => {
    isDown = false;
});

forumCarousel.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - forumCarousel.offsetLeft;
    const walk = (x - startX) * 2;
    forumCarousel.scrollLeft = scrollLeft - walk;
});


}

</script>

<?= $this->endSection() ?>
