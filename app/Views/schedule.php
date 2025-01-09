<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Tambahkan SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/waveyellow5.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-40">
        <h1 class="text-5xl font-bold text-gray-800 text-center" style="position: relative; top: -80px;">JADWAL & RESERVASI</h1>
    </div>
</div>

<section class="py-12 bg-gray-200 px-4 md:px-16">
    <div class="container mx-auto">
        <div class="bg-gray-200 shadow-md rounded-lg">
            <div class="flex justify-between items-center px-6 py-4">
                <h2 id="monthYear" class="text-2xl font-semibold text-gray-800"></h2>

                <div class="flex space-x-2">
                    <button id="today" class="px-4 py-2 text-yellow-500 rounded-md font-semibold hover:scale-105 hover:bg-yellow-900" 
                            style="background-color: #111827;">Today</button>
                    <div class="flex space-x-2">
                        <button id="prev" class="px-4 py-2 text-yellow-500 rounded-md hover:scale-105 hover:bg-yellow-900" 
                                style="background-color: #111827;">&lt;</button>
                        <button id="next" class="px-4 py-2 text-yellow-500 rounded-md hover:scale-105 hover:bg-yellow-900" 
                                style="background-color: #111827;">&gt;</button>
                    </div>
                </div>
            </div>

            <!-- Header Hari -->
            <div class="grid grid-cols-7 gap-px bg-gray-300">
                <?php foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day): ?>
                    <div class="text-center py-3 font-yellow-500" 
                         style="background-color: #111827; color: #eab308; font-weight: 600;">
                        <?= $day; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Grid Kalender -->
            <div id="calendar" class="grid grid-cols-7 gap-px bg-gray-200 min-h-[80vh]"></div>
        </div>
        <p class="italic">Note: Klik pada tanggal untuk melakukan reservasi.</p>
    </div>
</section>

<!-- Modal Form Reservasi -->
<div id="reservationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-30">
    <div class="bg-gray-200 p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-2">Form Reservasi</h2>
        <p id="selectedDateText" class="text-gray-700 mb-4"></p>
        <form id="reservationForm" action="/reservasi/store" method="post" enctype="multipart/form-data" autocomplete="off">
        <?= csrf_field(); ?> 
            <input type="hidden" name="tanggal_reservasi" id="selectedDate">


            <!-- Grid untuk Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" maxlength="60" name="nama_reservasi" 
                    placeholder="Masukkan Nama "
                    class="w-full border rounded px-3 py-2" autocomplete="off">
                </div>

                <!-- Nama Instansi -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Instansi, Lembaga, Komuntasi, dan lainnya</label>
                    <input type="text" maxlength="60" name="instansi_reservasi"
                    placeholder="Masukkan Nama Instansi, Lembaga, Komuntasi, dan lainnya"
                    class="w-full border rounded px-3 py-2" autocomplete="off">
                </div>

                <!-- Email -->
                <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" maxlength="60" name="email_reservasi"
                    placeholder="Masukkan Email"
                    class="w-full border rounded px-3 py-2" autocomplete="off">
            </div>


                <!-- No Whatsapp -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">No Whatsapp</label>
                    <input type="text" maxlength="15" name="telepon_reservasi" 
                    class="w-full border rounded px-3 py-2" placeholder="Masukkan No Whatsapp" oninput="this.value = this.value.replace(/[^0-9]/g, '')" autocomplete="off">
                </div>

                <!-- Kegiatan -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kegiatan</label>
                    <input type="text" maxlength="255" name="kegiatan_reservasi"
                    placeholder="Masukkan Nama Kegiatan"
                     class="w-full border rounded px-3 py-2" autocomplete="off">
                </div>

                <!-- Jumlah Anggota -->
                <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Jumlah Anggota</label>
    <input type="text" maxlength="4" name="jmlpengunjung_reservasi"
           placeholder="Masukkan Jumlah Anggota"
           class="w-full border rounded px-3 py-2"
           oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
           autocomplete="off">
</div>

            </div>

<!-- Dropzone Surat Kunjungan -->
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Surat Kunjungan (Foto/PDF) <i>Max 2MB</i></label>
    <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-200 transition relative" id="dropzone">
        <input type="file" name="surat_reservasi" id="suratReservasi" accept=".pdf, image/*" class="hidden" />
        <div id="dropzoneContent" class="flex flex-col justify-center items-center space-y-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-4-4m0 0l-4 4m4-4v12M4 4h16" />
            </svg>
            <p class="text-sm text-gray-500" id="dropzoneText">Drop files here or click to upload (Max 2MB, PDF, PNG/JPG)</p>
        </div>
    </div>
</div>

<div class="mb-4">
    <div class="g-recaptcha" data-sitekey="6Lex854qAAAAAOXI-dTJvt2LLR85jJF63NRXPePe"></div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

            <div class="flex justify-end">
                <button type="button" id="closeModal" class="mr-4 px-4 py-2 bg-gray-900 text-yellow-500 font-semibold rounded flex items-center justify-center">Batal</button>
                <button type="submit" id="submitBtn" class="px-4 py-2 bg-yellow-500 text-gray-900 font-semibold rounded flex items-center justify-center">
                <span id="btnText">Simpan</span>
                <span id="spinnerContainer" class="ml-2 hidden"></span>
            </button>
            </div>
        </form>
    </div>
</div>

<!-- Tombol Scroll to Top -->
<button id="scrollTopButton" 
    class="fixed bottom-6 right-6 w-12 h-12 rounded-full bg-yellow-500 shadow-lg 
    flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>


<!-- Tambahkan SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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

    document.querySelector('input[name="jmlpengunjung_reservasi"]').addEventListener('input', function () {
        if (this.value < 0) {
            this.value = 0;
        }
    });

    document.getElementById('reservationForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Cegah form dikirim langsung

    const nama = document.querySelector('input[name="nama_reservasi"]').value.trim();
    const email = document.querySelector('input[name="email_reservasi"]').value.trim();
    const noWhatsapp = document.querySelector('input[name="telepon_reservasi"]').value.trim();
    const kegiatan = document.querySelector('input[name="kegiatan_reservasi"]').value.trim();
    const jumlahAnggota = document.querySelector('input[name="jmlpengunjung_reservasi"]').value.trim();
    const fileInput = document.getElementById('suratReservasi');
    const file = fileInput.files[0];
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const spinnerContainer = document.getElementById('spinnerContainer');

    const spinner = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
    </svg>`;

    document.getElementById('reservationForm').addEventListener('submit', function (event) {
    const recaptcha = document.querySelector('.g-recaptcha-response').value;

    if (!recaptcha) {
        event.preventDefault(); // Cegah form dikirim
    }
});

    // Validasi field kosong
    if (!nama || !email || !noWhatsapp || !kegiatan || !jumlahAnggota || !file) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Semua field wajib diisi!',
        });
        return;
    }

    // Validasi format email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Format Email Tidak Valid',
        });
        return;
    }

    // Validasi nomor WhatsApp (minimal 10 digit)
    if (noWhatsapp.length < 10) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Nomor HP harus terdiri dari minimal 10 digit',
        });
        return;
    }

    // Validasi jumlah anggota
    if (!/^\d+$/.test(jumlahAnggota) || parseInt(jumlahAnggota) < 1) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Jumlah anggota harus minimal 1!',
        });
        return;
    }

    // Validasi ukuran file
    if (file && file.size > 2 * 1024 * 1024) { // 2MB dalam byte
        Swal.fire({
            icon: 'error',
            title: 'Ukuran file yang Anda unggah melebihi 2MB.',
            text: 'Silakan unggah file dengan ukuran maksimal 2MB.'
        });
        return;
    }

    // Disable tombol dan tampilkan spinner
    submitBtn.disabled = true;
    btnText.textContent = "Menyimpan...";
    spinnerContainer.innerHTML = spinner;
    spinnerContainer.classList.remove('hidden');

    // Kirim data
    const formData = new FormData(this);

    fetch('/reservasi/store', {
    method: 'POST',
    body: formData
})
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Reservasi berhasil diajukan, silahkan melanjutkan konfirmasi ke WhatsApp.',
                confirmButtonText: 'Lanjutkan ke WhatsApp',
            }).then(() => {
                window.location.href = 'https://wa.me/6281231231231'; // Ganti dengan nomor WhatsApp yang sesuai
            });

            // Reset form setelah sukses
            document.getElementById('reservationForm').reset(); // Reset form
            btnText.textContent = "Simpan"; // Reset teks tombol
            spinnerContainer.classList.add('hidden'); // Sembunyikan spinner
            submitBtn.disabled = false;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Gagal menyimpan data.',
            });
            submitBtn.disabled = false;
            btnText.textContent = "Simpan"; // Reset teks tombol
            spinnerContainer.classList.add('hidden'); // Sembunyikan spinner
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan saat mengirim data, silakan coba lagi.',
        });
        submitBtn.disabled = false;
        btnText.textContent = "Simpan"; // Reset teks tombol
        spinnerContainer.classList.add('hidden'); // Sembunyikan spinner
    });
});

    const calendar = document.getElementById('calendar');
    const monthYear = document.getElementById('monthYear');
    const todayButton = document.getElementById('today');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    const reservationModal = document.getElementById('reservationModal');
    const selectedDateText = document.getElementById('selectedDateText');
    const selectedDateInput = document.getElementById('selectedDate');
    const closeModalButton = document.getElementById('closeModal');
    const reservationForm = document.getElementById('reservationForm');

    let currentDate = new Date();

    function renderCalendar(date) {
        calendar.innerHTML = ''; // Kosongkan kalender
        const year = date.getFullYear();
        const month = date.getMonth();

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        monthYear.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });

        // Elemen kosong sebelum tanggal 1
        for (let i = 0; i < firstDay; i++) {
            calendar.appendChild(document.createElement('div'));
        }

        // Tampilkan tanggal dalam kalender
        for (let day = 1; day <= lastDate; day++) {
            const dayElement = document.createElement('div');
            dayElement.textContent = day;
            dayElement.className = 'text-center px-2 py-1 bg-gray-200 border border-gray-300 rounded hover:bg-yellow-200 cursor-pointer';

            const today = new Date();
            if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dayElement.classList.add('bg-yellow-100');
            }

            dayElement.addEventListener('click', () => handleDateClick(year, month, day));
            calendar.appendChild(dayElement);
        }
    }

    function handleDateClick(year, month, day) {
        const selectedDate = new Date(year, month, day);
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Set waktu ke awal hari untuk perbandingan

        if (selectedDate <= today) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tidak dapat memilih tanggal hari ini atau sebelumnya!',
            });
            return; 
        }

        openModal(selectedDate);
    }

    function openModal(date) {
        selectedDateText.textContent = `Tanggal Dipilih: ${date.toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        })}`;
        selectedDateInput.value = date.toISOString().split('T')[0];
        reservationModal.classList.remove('hidden');
    }

    closeModalButton.addEventListener('click', () => reservationModal.classList.add('hidden'));

    prevButton.addEventListener('click', () => changeMonth(-1));
    nextButton.addEventListener('click', () => changeMonth(1));
    todayButton.addEventListener('click', () => {
        currentDate = new Date();
        renderCalendar(currentDate);
    });

    function changeMonth(offset) {
        currentDate.setMonth(currentDate.getMonth() + offset);
        renderCalendar(currentDate);
    }

    renderCalendar(currentDate);

    <?php if (session()->getFlashdata('success')): ?>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Reservasi berhasil diajukan, silahkan melanjutkan konfirmasi ke WhatsApp.',
        confirmButtonText: 'Lanjutkan ke WhatsApp',
    }).then(() => {
        window.location.href = 'https://wa.me/6281231231231';
    });
    <?php endif; ?>

    
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('suratReservasi');
    const dropzoneContent = document.getElementById('dropzoneContent');
    const dropzoneText = document.getElementById('dropzoneText');

// Fungsi untuk memproses file yang diunggah
function handleFiles(files, allowedFormats, maxSizeMB) {
    const file = files[0];

    if (file) {
        const fileExtension = file.name.split('.').pop().toLowerCase(); // Ekstensi file
        const dropzoneText = document.getElementById('dropzoneText'); // Elemen untuk teks dropzone

        // Validasi format file
        if (!allowedFormats.includes(fileExtension)) {
            Swal.fire({
                icon: 'error',
                title: 'Jenis File Tidak Valid',
                text: `Hanya file dengan format ${allowedFormats.join(', ')} yang diperbolehkan.`,
            });
            fileInput.value = ''; // Reset input file
            dropzoneText.textContent = 'Drop files here or click to upload (Max 2MB, PDF, PNG/JPG)'; // Reset teks
            return;
        }

        // Validasi ukuran file
        if (file.size > maxSizeMB * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: `Ukuran file yang Anda unggah melebihi ${maxSizeMB}MB.`,
                text: `Silakan unggah file dengan ukuran maksimal ${maxSizeMB}MB.`,
            });
            fileInput.value = ''; // Reset input file
            dropzoneText.textContent = 'Drop files here or click to upload (Max 2MB, PDF, PNG/JPG)'; // Reset teks
        } else {
            // Menampilkan nama file yang dipilih
            dropzoneText.innerHTML = `<span class="text-green-500">File Terpilih: ${file.name}</span>`;
        }
    } else {
        // Reset jika tidak ada file
        dropzoneText.textContent = 'Drop files here or click to upload (Max 2MB, PDF, PNG/JPG)';
    }
}

// Tangani event klik pada dropzone
dropzone.addEventListener('click', () => {
    fileInput.click(); // Membuka dialog file
});

// Update file yang dipilih melalui file input
fileInput.addEventListener('change', () => {
    handleFiles(fileInput.files, ['pdf', 'png', 'jpg', 'jpeg'], 2); // Hanya menerima PDF, PNG, JPG dengan ukuran maksimal 2MB
});

// Tangani event drag-and-drop
dropzone.addEventListener('dragover', (e) => {
    e.preventDefault(); // Menghindari aksi default
    dropzone.classList.add('bg-gray-200'); // Tambahkan efek hover saat dragover
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('bg-gray-200'); // Hapus efek hover saat dragleave
});

dropzone.addEventListener('drop', (e) => {
    e.preventDefault(); // Menghindari aksi default
    dropzone.classList.remove('bg-gray-200'); // Hapus efek hover setelah drop
    const files = e.dataTransfer.files; // Ambil file dari drop
    fileInput.files = files; // Set file input
    handleFiles(files, ['pdf', 'png', 'jpg', 'jpeg'], 2); // Validasi file dengan format dan ukuran
});

// Reset saat file input dibatalkan
fileInput.addEventListener('click', function () {
    if (!fileInput.files.length) {
        dropzoneText.textContent = 'Drop files here or click to upload (Max 2MB, PDF, PNG/JPG)'; // Reset teks saat Cancel
    }
});

// ===================================================


</script>

<script>
const NewCalendar = (function() {
    let currentDate = new Date();
    let events = <?= json_encode($events) ?>;
    let reservations = <?= json_encode($reservations) ?>;

    function formatTanggal(date) {
        const tahun = date.getFullYear();
        const bulan = String(date.getMonth() + 1).padStart(2, '0');
        const tanggal = String(date.getDate()).padStart(2, '0');
        return `${tahun}-${bulan}-${tanggal}`;
    }

    // Fungsi untuk mengambil data baru
    async function fetchData(bulan, tahun) {
        try {
            const response = await fetch(`/schedule?month=${bulan}&year=${tahun}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            events = data.events;
            reservations = data.reservations;
            renderCalendar(currentDate);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    function renderCalendar(date) {
        const calendar = document.getElementById('calendar');
        const monthYear = document.getElementById('monthYear');
        calendar.innerHTML = '';

        const tahun = date.getFullYear();
        const bulan = date.getMonth();
        const hariPertama = new Date(tahun, bulan, 1).getDay();
        const tanggalTerakhir = new Date(tahun, bulan + 1, 0).getDate();

        monthYear.textContent = date.toLocaleString('id-ID', { 
            month: 'long', 
            year: 'numeric' 
        });

        // Tambah div kosong untuk hari-hari sebelum tanggal 1
        for (let i = 0; i < hariPertama; i++) {
            calendar.appendChild(document.createElement('div'));
        }

        // Render semua tanggal dalam bulan
        for (let hari = 1; hari <= tanggalTerakhir; hari++) {
            const tanggalObj = new Date(tahun, bulan, hari);
            const tanggalStr = formatTanggal(tanggalObj);
            
            const dayElement = document.createElement('div');
            // Menambahkan kelas hover dan transisi
            dayElement.className = 'text-center px-2 py-1 border border-gray-300 rounded cursor-pointer min-h-[80px] transition-all duration-200 hover:shadow-lg hover:border-gray-400 hover:scale-105';
            
            // Tambahkan nomor tanggal
            const tanggalSpan = document.createElement('div');
            tanggalSpan.textContent = hari;
            tanggalSpan.className = 'font-bold';
            dayElement.appendChild(tanggalSpan);

            // Tandai hari ini
            const today = new Date();
            if (hari === today.getDate() && bulan === today.getMonth() && tahun === today.getFullYear()) {
                dayElement.classList.add('bg-yellow-100', 'hover:bg-yellow-100');
                const todayText = document.createElement('div');
                todayText.textContent = 'Hari ini';
                todayText.className = 'text-xs mt-1 font-medium text-yellow-600';
                dayElement.appendChild(todayText);
            }

            // Cek dan tampilkan event
            const event = events.find(e => e.tanggal_event === tanggalStr);
            if (event) {
                dayElement.classList.remove('bg-yellow-100', 'hover:bg-yellow-200');
                dayElement.classList.add('bg-green-200', 'hover:bg-green-300');
                
                const eventDiv = document.createElement('div');
                eventDiv.className = 'text-xs mt-1 font-medium text-green-800';
                eventDiv.textContent = event.nama_event;
                dayElement.appendChild(eventDiv);

                dayElement.addEventListener('click', () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Event Tanggal ini',
                        text: `${event.nama_event} `,
                        showCancelButton: true,
                        confirmButtonText: 'Lihat Detail',
                        confirmButtonColor: '#fab911',
                        cancelButtonText: 'Kembali',
                        cancelButtonColor: '#424242',
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.confirm) {
                            window.location.href = "<?= site_url(); ?>/event/" + encodeURIComponent(event.id);
                        }
                    });
                });
            }

            // Cek dan tampilkan reservasi
            const reservation = reservations.find(r => r.tanggal_reservasi === tanggalStr);
            if (reservation) {
                dayElement.classList.remove('bg-yellow-100', 'hover:bg-yellow-200');
                dayElement.classList.add('bg-blue-200', 'hover:bg-blue-300');
                
                const reservationDiv = document.createElement('div');
                reservationDiv.className = 'text-xs mt-1 font-medium text-blue-800';
                reservationDiv.textContent = 'Reserved';
                dayElement.appendChild(reservationDiv);

                dayElement.addEventListener('click', () => {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal Direservasi',
                        text: `Tanggal ini telah direservasi oleh ${reservation.instansi_reservasi}`
                    });
                });
            }

            // Tambahkan listener untuk tanggal kosong
            if (!event && !reservation) {
                // Tambahkan hover effect untuk tanggal kosong
                dayElement.classList.add('hover:bg-gray-100');
                
                dayElement.addEventListener('click', () => {
                    const selectedDate = new Date(tahun, bulan, hari);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (selectedDate <= today) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Tidak dapat memilih tanggal hari ini atau sebelumnya!'
                        });
                        return;
                    }

                    const modal = document.getElementById('reservationModal');
                    const selectedDateText = document.getElementById('selectedDateText');
                    const selectedDateInput = document.getElementById('selectedDate');

                    selectedDateText.textContent = `Tanggal Dipilih: ${selectedDate.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    })}`;
                    selectedDateInput.value = formatTanggal(selectedDate);
                    modal.classList.remove('hidden');
                });
            }

            calendar.appendChild(dayElement);
        }
    }

    // Event listeners untuk navigasi
    document.getElementById('prev').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        const bulan = currentDate.getMonth() + 1;
        const tahun = currentDate.getFullYear();
        fetchData(bulan, tahun);
    });

    document.getElementById('next').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        const bulan = currentDate.getMonth() + 1;
        const tahun = currentDate.getFullYear();
        fetchData(bulan, tahun);
    });

    document.getElementById('today').addEventListener('click', () => {
        currentDate = new Date();
        const bulan = currentDate.getMonth() + 1;
        const tahun = currentDate.getFullYear();
        fetchData(bulan, tahun);
    });

    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById('reservationModal').classList.add('hidden');
    });

    renderCalendar(currentDate);

    return {
        renderCalendar,
        currentDate
    };
})();
</script>



        

<?= $this->endSection() ?>
