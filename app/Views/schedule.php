<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Tambahkan SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Header dengan Latar Gambar -->
<div class="relative pb-1" 
     style="background-image: url('<?= base_url('pict/headerbg.png'); ?>'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-8 py-24">
        <h1 class="text-5xl font-bold text-white text-center">JADWAL</h1>
    </div>
</div>

<section class="py-12 bg-white px-4 md:px-16">
    <div class="container mx-auto">
        <div class="bg-white shadow-md rounded-lg">
            <div class="flex justify-between items-center px-6 py-4">
                <h2 id="monthYear" class="text-2xl font-semibold text-gray-800"></h2>

                <div class="flex space-x-2">
                    <button id="today" class="px-4 py-2 text-white rounded-md font-semibold hover:scale-105 hover:bg-yellow-900" 
                            style="background-color: #2C1011;">Today</button>
                    <div class="flex space-x-2">
                        <button id="prev" class="px-4 py-2 text-white rounded-md hover:scale-105 hover:bg-yellow-900" 
                                style="background-color: #2C1011;">&lt;</button>
                        <button id="next" class="px-4 py-2 text-white rounded-md hover:scale-105 hover:bg-yellow-900" 
                                style="background-color: #2C1011;">&gt;</button>
                    </div>
                </div>
            </div>

            <!-- Header Hari -->
            <div class="grid grid-cols-7 gap-px bg-gray-300">
                <?php foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day): ?>
                    <div class="text-center py-3" 
                         style="background-color: #2C1011; color: white; font-weight: 600;">
                        <?= $day; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Grid Kalender -->
            <div id="calendar" class="grid grid-cols-7 gap-px bg-white min-h-[80vh]"></div>
        </div>
        <p class="italic">Klik pada tanggal untuk melakukan reservasi.</p>
    </div>
</section>

<!-- Modal Form Reservasi -->
<div id="reservationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-2">Form Reservasi</h2>
        <p id="selectedDateText" class="text-gray-700 mb-4"></p>
        
        <form id="reservationForm" action="/reservasi/store" method="post" autocomplete="off">
    <input type="hidden" name="tanggal_reservasi" id="selectedDate">

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="nama_reservasi" autocomplete="off" class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Instansi</label>
        <input type="text" name="instansi_reservasi" autocomplete="off" class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email_reservasi" autocomplete="off" class="w-full border rounded px-3 py-2" >
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">No Whatsapp</label>
        <input type="text" name="telepon_reservasi" autocomplete="off" class="w-full border rounded px-3 py-2" >
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Kegiatan</label>
        <input type="text" name="kegiatan_reservasi" autocomplete="off" class="w-full border rounded px-3 py-2" >
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Jumlah Anggota</label>
        <input type="number" name="jmlpengunjung_reservasi" autocomplete="off" class="w-full border rounded px-3 py-2" >
    </div>

    <div class="flex justify-end">
        <button type="button" id="closeModal" class="mr-4 px-4 py-2 border rounded">Batal</button>
        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded">Simpan</button>
    </div>
</form>

    </div>
</div>

<!-- Tambahkan SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    // Fungsi untuk mengatur posisi scroll ke atas saat halaman di-refresh
    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    };
    
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

    reservationForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Cegah form dikirim langsung

        const formData = new FormData(reservationForm); // Ambil data dari form

        fetch('/reservasi/store', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                // Jika validasi gagal, tampilkan pesan error SweetAlert2
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Semua field wajib diisi!',
                });
            } else {
                // Jika validasi berhasil, tampilkan konfirmasi SweetAlert2
                Swal.fire({
                    icon: 'question',
                    title: 'Konfirmasi Reservasi',
                    text: 'Apakah data yang Anda isi sudah benar?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Reservasi berhasil diajukan!',
                            confirmButtonText: 'Lanjutkan ke WhatsApp'
                        }).then(() => {
                            window.location.href = 'https://wa.me/6281231231231';
                        });
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan, silakan coba lagi.',
            });
        });
    });

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
            dayElement.className = 'text-center px-2 py-1 bg-white border border-gray-300 rounded hover:bg-yellow-200 cursor-pointer';

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

        if (selectedDate < today) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anda tidak dapat memilih tanggal dari masa lalu!',
            });
            return; // Jangan buka modal
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
        showCancelButton: true,
        confirmButtonText: 'Lanjutkan ke WhatsApp',
        cancelButtonText: 'Tutup',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'https://wa.me/6281231231231';
        }
    });
    <?php endif; ?>
</script>

<?= $this->endSection() ?>
