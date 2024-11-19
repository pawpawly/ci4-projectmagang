<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<section class="relative">
    <div class="relative w-full h-[500px] overflow-hidden">
        <img src="<?= base_url('pict/museum.png'); ?>" alt="Museum Kayuh Baimbai" class="absolute inset-0 w-full h-full object-cover">
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

<!-- New Carousel Section -->
<section class="py-12 bg-gradient-to-b from-white to-[#B09091] relative overflow-hidden">
    <div class="container mx-auto">
        <div id="carouselExample" class="relative overflow-hidden" style="max-width: 900px; margin: 0 auto;">
            <!-- Carousel Wrapper -->
            <div id="carouselInner" class="flex transition-transform duration-700">
                <div class="carousel-item flex-shrink-0 w-full">
                    <img src="<?= base_url('pict/museum.png'); ?>" alt="Carousel Image 1" class="w-full h-[400px] object-cover rounded-lg">
                </div>
                <div class="carousel-item flex-shrink-0 w-full">
                    <img src="<?= base_url('pict/isimuseum2.png'); ?>" alt="Carousel Image 2" class="w-full h-[400px] object-cover rounded-lg">
                </div>
                <div class="carousel-item flex-shrink-0 w-full">
                    <img src="<?= base_url('pict/isimuseum3.png'); ?>" alt="Carousel Image 3" class="w-full h-[400px] object-cover rounded-lg">
                </div>
            </div>

            <!-- Indicators -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                <button class="indicator h-[4px] w-[40px] bg-gray-300 rounded-full transition-all duration-300" data-index="0"></button>
                <button class="indicator h-[4px] w-[40px] bg-gray-300 rounded-full transition-all duration-300" data-index="1"></button>
                <button class="indicator h-[4px] w-[40px] bg-gray-300 rounded-full transition-all duration-300" data-index="2"></button>
            </div>
        </div>

        <!-- Text Below Carousel -->
        <div class="text-center mt-4">
            <p id="carouselText" class="text-white font-semibold text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
    </div>
</section>

<!-- Event Section -->
<section class="py-12 bg-gradient-to-b from-[#B09091] to-white relative overflow-hidden">
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
<section class="py-12 bg-gradient-to-b from-white to-[#B09091] relative overflow-hidden">
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
                            <div class="forum-image-wrapper overflow-hidden rounded-lg">
                                <a href="<?= site_url('berita/' . urlencode($item['NAMA_BERITA'])); ?>"> 
                                    <img src="<?= base_url('uploads/berita/' . $item['FOTO_BERITA']); ?>"
                                         alt="<?= esc($item['NAMA_BERITA']); ?>"
                                         class="forum-image transition-transform duration-300 ease-in-out hover:scale-105">
                                </a>
                            </div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <p class="text-sm"><?= formatTanggalIndonesia($item['TANGGAL_BERITA']); ?></p>
                                <h3 class="mt-1 text-xl font-semibold">
                                    <a href="<?= site_url('berita/' . urlencode($item['NAMA_BERITA'])); ?>" 
                                       class="hover:text-red-400 transition duration-300 ease-in-out">
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
                   class="bg-red-900 text-white py-2 px-6 rounded-full hover:bg-red-700">
                   Lihat Berita Lebih Banyak
                </a>
            </div>         
        <?php else: ?>
            <p class="text-center text-gray-500">Tidak ada berita tersedia saat ini.</p>
        <?php endif; ?>
    </div>
</section>


<!-- Section Kayuh Baimbai TV -->
<section class="py-12 bg-gradient-to-b from-[#B09091] to-white relative overflow-hidden">
    <div class="container mx-auto max-w-7xl px-4">
        <!-- Judul Section -->
        <div class="relative text-center mb-8">
            <h2 class="event-overlay">KAYUH BAIMBAI TV</h2>
            <h2 class="text-4xl font-bold text-[#2C1011] mb-4 hover:scale-105 transition-transform duration-300">
                KAYUH BAIMBAI TV
            </h2>
        </div>

        <!-- Video Besar -->
        <div class="mb-8 flex justify-center">
            <iframe width="60%" height="350" src="https://www.youtube.com/embed/9pRIoZr-jZ0" 
                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen class="rounded-xl shadow-lg"></iframe>
        </div>

        <!-- Grid Video Kecil -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Video Kecil 1 -->
            <div>
                <iframe width="100%" height="200" src="https://www.youtube.com/embed/w4jypfkkOXw" 
                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen class="rounded-xl shadow-lg"></iframe>
            </div>
            <!-- Video Kecil 2 -->
            <div>
                <iframe width="100%" height="200" src="https://www.youtube.com/embed/m_oAtvIruqg" 
                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen class="rounded-xl shadow-lg"></iframe>
            </div>
            <!-- Video Kecil 3 -->
            <div>
                <iframe width="100%" height="200" src="https://www.youtube.com/embed/yRjmuzSq4h4" 
                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen class="rounded-xl shadow-lg"></iframe>
            </div>
        </div>

        <!-- Tombol Lihat Lainnya -->
        <div class="text-center mt-8">
            <a href="https://www.youtube.com/@EwingHDTV" target="_blank" 
               class="bg-[#2C1011] text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:bg-[#4A2A2C] transition-transform duration-300">
                Lihat Lainnya...
            </a>
        </div>
    </div>
</section>




<!-- Saran Section -->
<section class="py-12 bg-gradient-to-b from-white to-[#B09091] relative overflow-hidden">
    <div class="container mx-auto px-8">
        <div class="relative text-center mb-12">
            <h2 class="event-overlay text-6xl font-extrabold text-gray-200 mb-2">SARAN</h2>
            <h2 class="text-4xl font-bold text-[#2C1011] mb-4 hover:scale-105 transition-transform duration-300">SARAN</h2>
        </div>
        <p class="text-gray-800 text-center hover:text-[#4A2A2C] transition duration-300">Kami sangat menghargai masukan dan saran Anda untuk meningkatkan layanan kami.</p>
        <div class="max-w-3xl mx-auto p-10">
        <form id="saranForm" class="space-y-8" autocomplete="off">


    <div>
        <label for="NAMA_SARAN" class="block text-[#2C1011] text-lg font-semibold">Nama*</label>
        <input type="text" id="NAMA_SARAN" name="NAMA_SARAN" autocomplete="off" class="mt-2 block w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none hover:shadow-md transition-shadow duration-200" placeholder="Nama Anda">
    </div>

    <div>
        <label for="EMAIL_SARAN" class="block text-[#2C1011] text-lg font-semibold">Email*</label>
        <input type="email" id="EMAIL_SARAN" name="EMAIL_SARAN" autocomplete="off" class="mt-2 block w-full p-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#2C1011] focus:outline-none hover:shadow-md transition-shadow duration-200" placeholder="Email Anda">
    </div>

    <div>
        <label for="KOMENTAR_SARAN" class="block text-[#2C1011] text-lg font-semibold">Saran*</label>
        <textarea id="KOMENTAR_SARAN" name="KOMENTAR_SARAN" rows="5" autocomplete="off" class="mt-2 block w-full p-4 border border-gray-300 rounded-md resize-none overflow-y-auto focus:ring-2 focus:ring-[#2C1011] focus:outline-none hover:shadow-md transition-shadow duration-200" placeholder="Tulis saran Anda di sini..."></textarea>
    </div>
    <div class="text-center">
        <button type="submit" id="submitBtn" class="px-8 py-3 bg-[#2C1011] text-white font-bold rounded-lg hover:bg-[#4A2A2C] hover:shadow-lg transition duration-300">Kirim</button>
    </div>
</form>


        </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('saranForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const nama = document.getElementById('NAMA_SARAN').value.trim();
    const email = document.getElementById('EMAIL_SARAN').value.trim();
    const saran = document.getElementById('KOMENTAR_SARAN').value.trim();

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
    submitBtn.innerText = "Mengirim...";

    fetch('<?= site_url("saran/saveSaran") ?>', {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Response data:", data); // Debugging line

        if (data.success) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Saran berhasil dikirim!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                document.getElementById('saranForm').reset();
                submitBtn.disabled = false;
                submitBtn.innerText = "Kirim";
            });
        } else {
            Swal.fire({
                title: 'Gagal!',
                text: data.message || 'Gagal mengirim saran.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            submitBtn.disabled = false;
            submitBtn.innerText = "Kirim";
        }
    })
    .catch(error => {
        console.error('Error:', error); // Debugging line
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan pada server.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        submitBtn.disabled = false;
        submitBtn.innerText = "Kirim";
    });
});
    // Fungsi untuk mengatur posisi scroll ke atas saat halaman di-refresh
    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    };

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
setInterval(() => {
    currentIndex = (currentIndex + 1) % slideCount;
    setPositionByIndex();
}, 5000);

// Inisialisasi awal
updateCarousel(currentIndex);


</script>

<?= $this->endSection() ?>
