<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1 bg-gray-200" 
     style="background-image: url('<?= base_url('pict/waveyellow5.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-40">
        <h1 class="text-5xl font-bold text-gray-800 text-center" style="position: relative; top: -80px;">TENTANG KAMI</h1>
    </div>
</div>

<!-- Visi Misi Section -->
<section class="py-12 bg-gray-200 px-4 md:px-16">
    <div class="container mx-auto text-center opacity-0 animate-fade-up">
        <h2 class="text-4xl font-bold text-gray-800 mb-8">VISI & MISI</h2>
        <div class="flex flex-col md:flex-row justify-center space-y-8 md:space-y-0 md:space-x-16">
            <div class="w-full md:w-1/2">
                <h3 class="text-lg font-bold text-gray-800 mb-4">VISI</h3>
                <p class="text-gray-600 leading-relaxed text-justify-center mx-auto">
                    Museum Sebagai Pusat Peradaban, Edukasi Penelitian dan Hiburan.
                </p>
            </div>

            <div class="w-full md:w-1/2">
                <h3 class="text-lg font-bold text-gray-800 mb-4">MISI</h3>
                <ul class="list-none text-gray-600 leading-relaxed text-left mx-auto">
                    <li class="flex items-start mb-2">
                        <svg class="w-6 h-6 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Mendokumentasi Benda-Benda dan Data Sejarah Kota Banjarmasin
                    </li>
                    <li class="flex items-start mb-2">
                        <svg class="w-6 h-6 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Melestarikan Nilai-Nilai Budaya dan Sejarah Kota Banjarmasin
                    </li>
                    <li class="flex items-start mb-2">
                        <svg class="w-6 h-6 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Mengedukasi Masyarakat akan Peradaban dan Sejarah Kota Banjarmasin
                    </li>
                    <li class="flex items-start mb-2">
                        <svg class="w-6 h-6 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Sebagai Wadah Penelitian terhadap Sejarah dan Budaya Banjar
                    </li>
                    <li class="flex items-start mb-2">
                        <svg class="w-6 h-6 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Sebagai Sarana Hiburan dan Rekreasi Sejarah dan Budaya
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Induk Asosiasi Section -->
<section class="py-12 bg-gray-200 px-4 md:px-16">
    <div class="container mx-auto text-center opacity-0 animate-fade-up">
        <h2 class="text-4xl font-bold text-gray-800 mb-8">INDUK ASOSIASI</h2>
        <div class="flex flex-col md:flex-row items-center justify-center gap-8">
            <div class="w-full md:w-1/2 fade-in-left">
                <p class="text-lg text-gray-600 leading-relaxed text-justify">
                    Museum Kayuh Baimbai adalah unit pelaksana teknis di lingkungan Dinas Kebudayaan, Pariwisata, Kepemudaan, dan Olahraga 
                    (Disbudporapar) Kota Banjarmasin yang berada di bawah dan bertanggung jawab kepada Kepala Disbudporapar Kota Banjarmasin 
                    serta secara administratif dibina oleh Sekretaris Disbudporapar Kota Banjarmasin. Hal ini diatur dan ditetapkan dalam 
                    Peraturan Wali Kota Banjarmasin No. [Nomor Peraturan], tentang Organisasi dan Tata Kerja Disbudporapar Kota Banjarmasin 
                    Dengan ditetapkannya peraturan ini, maka dipandang perlu untuk melakukan penataan organisasi dan tata kerja Museum Kayuh 
                    Baimbai guna mendukung pelestarian budaya serta pengelolaan informasi sejarah di Kota Banjarmasin.
                </p>
            </div>
            <div class="w-full md:w-1/2 flex justify-center fade-in-right">
                <img src="<?= base_url('pict/icon.png'); ?>" alt="Kominfo Logo" class="h-48 object-contain">
            </div>
        </div>
    </div>
</section>

<!-- Tombol Scroll to Top -->
<button id="scrollTopButton" 
    class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-yellow-500 shadow-lg 
    flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>


<script>
   // Intersection Observer untuk menjalankan animasi saat elemen terlihat di layar
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.remove('opacity-0'); // Hapus opacity-0 saat terlihat
      entry.target.classList.add('show'); // Tambahkan kelas show
    }
  });
}, { threshold: 0.1 });

// Terapkan observer ke semua elemen dengan kelas animate-fade-up
document.querySelectorAll('.animate-fade-up').forEach((el) => {
  observer.observe(el);
});


    // Scroll ke bagian atas saat halaman dimuat atau di-refresh
    window.onbeforeunload = function () {
      window.scrollTo(0, 0);
    };

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

// Intersection Observer untuk menjalankan animasi fade-in
const fadeObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show'); // Tambah kelas 'show' saat elemen terlihat
    }
  });
}, { threshold: 0.1 }); // Mulai animasi ketika 10% elemen terlihat

// Terapkan observer ke elemen deskripsi dan logo
fadeObserver.observe(document.querySelector('.fade-in-left'));
fadeObserver.observe(document.querySelector('.fade-in-right'));


</script>

<style>

@keyframes fade-up {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-up {
  opacity: 0;
  animation: fade-up 1s ease-in-out forwards;
}

    /* Efek Hover untuk Teks */
h2:hover {
    transform: scale(1.1); /* Membesar 10% */
    transition: transform 0.3s ease-in-out; /* Animasi transisi halus */
}

#scrollTopButton {
    transition: opacity 0.3s ease-in-out;
}


/* Animasi Fade-in dari Kiri */
.fade-in-left {
    opacity: 0;
    transform: translateX(-30px); /* Mulai dari kiri */
    transition: opacity 1s ease-out, transform 1s ease-out;
}

/* Animasi Fade-in dari Kanan */
.fade-in-right {
    opacity: 0;
    transform: translateX(30px); /* Mulai dari kanan */
    transition: opacity 1s ease-out, transform 1s ease-out;
}

/* Saat elemen terlihat di layar */
.show {
    opacity: 1;
    transform: translateX(0); /* Kembali ke posisi awal */
}
</style>

<?= $this->endSection() ?>
