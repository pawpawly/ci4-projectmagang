<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

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
            <!-- Header Kalender -->
            <div class="flex justify-between items-center px-6 py-4">
                <!-- Nama Bulan dan Tahun di Kiri -->
                <h2 id="monthYear" class="text-2xl font-semibold text-gray-800"></h2>

                <!-- Tombol Navigasi dan Today di Kanan -->
                <div class="flex space-x-2">
                    <button id="today" 
                            class="px-4 py-2 text-white rounded-md font-semibold hover:scale-105 hover:bg-yellow-900" 
                            style="background-color: #2C1011;">
                        Today
                    </button>
                    <div class="flex space-x-2">
                        <button id="prev" 
                                class="px-4 py-2 text-white rounded-md hover:scale-105 hover:bg-yellow-900" 
                                style="background-color: #2C1011;">
                            &lt;
                        </button>
                        <button id="next" 
                                class="px-4 py-2 text-white rounded-md hover:scale-105 hover:bg-yellow-900" 
                                style="background-color: #2C1011;">
                            &gt;
                        </button>
                    </div>
                </div>
            </div>

            <!-- Header Hari -->
            <div class="grid grid-cols-7 gap-px bg-gray-300">
                <div class="text-center py-3" style="background-color: #2C1011; color: white; font-weight: 600;">Sun</div>
                <div class="text-center py-3" style="background-color: #2C1011; color: white; font-weight: 600;">Mon</div>
                <div class="text-center py-3" style="background-color: #2C1011; color: white; font-weight: 600;">Tue</div>
                <div class="text-center py-3" style="background-color: #2C1011; color: white; font-weight: 600;">Wed</div>
                <div class="text-center py-3" style="background-color: #2C1011; color: white; font-weight: 600;">Thu</div>
                <div class="text-center py-3" style="background-color: #2C1011; color: white; font-weight: 600;">Fri</div>
                <div class="text-center py-3" style="background-color: #2C1011; color: white; font-weight: 600;">Sat</div>
            </div>

            <!-- Grid Kalender Fullscreen -->
            <div id="calendar" class="grid grid-cols-7 gap-px bg-white min-h-[80vh]">
                <!-- Tanggal akan diisi dinamis dengan JavaScript -->
            </div>
        </div>
    </div>
</section>


<script>
    const calendar = document.getElementById('calendar');
    const monthYear = document.getElementById('monthYear');
    const todayButton = document.getElementById('today');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');

    let currentDate = new Date();

    function renderCalendar(date) {
        calendar.innerHTML = '';
        const year = date.getFullYear();
        const month = date.getMonth();

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        monthYear.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });

        for (let i = 0; i < firstDay; i++) {
            calendar.appendChild(document.createElement('div'));
        }

        for (let day = 1; day <= lastDate; day++) {
            const dayElement = document.createElement('div');
            dayElement.textContent = day;
            dayElement.className = 'text-center px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-200';

            const today = new Date();
            if (day === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()) {
                dayElement.classList.add('bg-red-100');
            }

            calendar.appendChild(dayElement);
        }
    }

    function changeMonth(offset) {
        currentDate.setMonth(currentDate.getMonth() + offset);
        renderCalendar(currentDate);
    }

    prevButton.addEventListener('click', () => {
        if (currentDate.getMonth() === 0) {
            currentDate.setFullYear(currentDate.getFullYear() - 1);
            currentDate.setMonth(11);
        } else {
            currentDate.setMonth(currentDate.getMonth() - 1);
        }
        renderCalendar(currentDate);
    });

    nextButton.addEventListener('click', () => {
        if (currentDate.getMonth() === 11) {
            currentDate.setFullYear(currentDate.getFullYear() + 1);
            currentDate.setMonth(0);
        } else {
            currentDate.setMonth(currentDate.getMonth() + 1);
        }
        renderCalendar(currentDate);
    });

    todayButton.addEventListener('click', () => {
        currentDate = new Date();
        renderCalendar(currentDate);
    });

    renderCalendar(currentDate);
</script>

<style>

    /* Efek Hover untuk Teks */
h2:hover {
    transform: scale(1.1); /* Membesar 10% */
    transition: transform 0.3s ease-in-out; /* Animasi transisi halus */
}
</style>

<?= $this->endSection() ?>
