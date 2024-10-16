<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center">TENTANG KAMI</h1>
    </div>
</div>

<!-- Visi Misi Section -->
<section class="py-12 bg-white px-4 md:px-16">
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
<section class="py-12 bg-white px-4 md:px-16">
    <div class="container mx-auto text-center opacity-0 animate-fade-up">
        <h2 class="text-4xl font-bold text-gray-800 mb-8">INDUK ASOSIASI</h2>
        <div class="flex flex-col md:flex-row items-center justify-center gap-8">
            <div class="w-full md:w-1/2">
                <p class="text-lg text-gray-600 leading-relaxed text-justify">
                    Museum Penerangan adalah unit pelaksana teknis di lingkungan Direktorat Jenderal Informasi dan Komunikasi Publik 
                    yang berada di bawah dan bertanggung jawab kepada Direktur Jenderal Informasi dan Komunikasi Publik, 
                    secara administratif dibina oleh Sekretaris Direktorat Jenderal Informasi dan Komunikasi Publik. Hal ini diatur dan 
                    ditetapkan dalam PERMENKOMINFO NO. 05/PER/M.KOMINFO/03/2011 TAHUN 2011, LL. KEMKOMINFO: 5 HLM. 
                    Bahwa dengan ditetapkannya Peraturan Menteri Komunikasi dan Informatika ini, tentang Organisasi dan Tata Kerja 
                    Kementerian Komunikasi dan Informatika, maka dipandang perlu untuk melakukan penataan organisasi dan tata kerja museum penerangan.
                </p>
            </div>
            <div class="w-full md:w-1/2 flex justify-center">
                <img src="<?= base_url('pict/icon.png'); ?>" alt="Kominfo Logo" class="h-48 object-contain">
            </div>
        </div>
    </div>
</section>

<script>
    // Intersection Observer untuk menjalankan animasi saat elemen terlihat di layar
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.remove('opacity-0'); // Hapus opacity-0 saat terlihat
          }
        });
      },
      { threshold: 0.1 } // Mulai animasi ketika 10% elemen terlihat
    );

    // Terapkan observer ke setiap elemen dengan animasi
    document.querySelectorAll('.animate-fade-up').forEach((el) => {
      observer.observe(el);
    });

    // Scroll ke bagian atas saat halaman dimuat atau di-refresh
    window.onbeforeunload = function () {
      window.scrollTo(0, 0);
    };

</script>

<style>

    @keyframes fade-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-up { animation: fade-up 1s ease-in-out forwards; }

    /* Efek Hover untuk Teks */
h2:hover {
    transform: scale(1.1); /* Membesar 10% */
    transition: transform 0.3s ease-in-out; /* Animasi transisi halus */
}

</style>

<?= $this->endSection() ?>
