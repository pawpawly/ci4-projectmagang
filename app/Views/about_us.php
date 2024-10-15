<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Header Kuning dengan Garis Melengkung -->
<div class="relative bg-gradient-to-r from-[#FFD202] to-[#FFD202] pb-32"> <!-- Gradien diperbarui -->
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center">TENTANG KAMI</h1>
    </div>

    <!-- SVG untuk Garis Melengkung -->
    <div class="absolute bottom-0 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#FFFFFF" fill-opacity="1" 
                d="M0,288L48,272C96,256,192,224,288,224C384,224,480,256,576,266.7C672,277,768,267,864,250.7C960,235,1056,203,1152,186.7C1248,171,1344,181,1392,186.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>
</div>

<!-- Visi Misi Section -->
<section class="py-12 bg-white px-4 md:px-16">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold text-gray-800 mb-8">VISI & MISI</h2>
      <div class="flex flex-col md:flex-row justify-center space-y-8 md:space-y-0 md:space-x-16">
        <!-- Visi Section -->
        <div class="w-full md:w-1/2">
          <h3 class="text-lg font-bold text-gray-800 mb-4">VISI</h3>
          <p class="text-gray-600 leading-relaxed text-justify-center mx-auto">
            Museum Sebagai Pusat Peradabaan, Edukasi Penelitian dan Hiburan.
          </p>
        </div>

        <!-- Misi Section -->
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
              Mengedukasi Masyarakat akan Peradabaan dan Sejarah Kota Banjarmasin
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
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold text-gray-800 mb-8">INDUK ASOSIASI</h2>
        <div class="flex flex-col md:flex-row items-center justify-center gap-8">
            <!-- Teks Deskripsi -->
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

            <!-- Logo Induk Asosiasi -->
            <div class="w-full md:w-1/2 flex justify-center">
                <img src="<?= base_url('pict/icon.png'); ?>" alt="Kominfo Logo" class="h-48 object-contain">
            </div>
        </div>
    </div>
</section>


<?= $this->endSection() ?>
