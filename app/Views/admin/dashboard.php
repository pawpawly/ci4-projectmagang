<?= $this->extend('admin/sidebar'); ?>

<?= $this->section('content'); ?>
<section>
    <div class="bg-white min-h-screen p-6">

        <!-- New Section for the 4 Boxes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <!-- Kotak 1: Pending Reservations -->
    <div class="bg-white shadow-lg rounded-lg p-6 cursor-pointer hover:bg-gray-200" onclick="window.location.href='<?= site_url('admin/reservasi/manage'); ?>'">
        <h3 class="text-xl font-bold mb-4">Reservasi Pending</h3>
        <div class="flex justify-between">
            <p class="text-3xl font-bold"><?= $pendingReservations ?></p>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008Z" />
            </svg>
        </div>
    </div>

    <!-- Kotak 2: Total Collections -->
    <div class="bg-white shadow-lg rounded-lg p-6 cursor-pointer hover:bg-gray-200" onclick="window.location.href='<?= site_url('admin/koleksi/manage'); ?>'">
        <h3 class="text-xl font-bold mb-4">Total Koleksi</h3>
        <div class="flex justify-between">
            <p class="text-3xl font-bold"><?= $totalCollections ?></p>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
            </svg>
        </div>
    </div>

    <!-- Kotak 3: Upcoming Events -->
    <div class="bg-white shadow-lg rounded-lg p-6 cursor-pointer hover:bg-gray-200" onclick="window.location.href='<?= site_url('admin/event/manage'); ?>'">
        <h3 class="text-xl font-bold mb-4">Events Berlangsung</h3>
        <div class="flex justify-between">
            <p class="text-3xl font-bold"><?= $upcomingEvents ?></p>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
            </svg>
        </div>
    </div>


            <!-- Kotak 4: Digital Clock -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Waktu Saat Ini</h3>
                <div class="flex justify-between">
                    <p class="text-3xl font-bold" id="digitalClock">00:00:00</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>


<section>
<div class="bg-white min-h-screen p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Statistik Pengunjung</h1>

    <div class="flex flex-col sm:flex-row gap-6">
        <!-- Grafik Garis -->
        <div class="bg-white shadow-lg rounded-lg p-6 flex-1">
            <h2 class="text-xl font-bold mb-4">Grafik Pengunjung Perbulan Dalam Tahun Ini</h2>
            <div class="flex justify-between mb-4">
            <p id="noDataMessage" class="text-gray-500 mt-2" style="display: <?= empty($years) ? 'block' : 'none'; ?>">
                Tidak ada data untuk ditampilkan.
            </p>
                
                <div class="flex items-center">
    <p><span class="ml-12 font-bold" style="color: rgba(54, 162, 235, 1);">Laki-laki:</span> <strong id="totalMale"></strong></p>
    <p><span class="ml-12 font-bold" style="color: rgba(255, 99, 132, 1);">Perempuan:</span> <strong id="totalFemale"></strong></p>
    <p><span class="ml-12 font-bold">Total:</span> <strong id="totalVisitors"></strong></p>
</div>

            </div>
            <canvas id="monthlyChart" width="650" height="350"></canvas>  <!-- Grafik garis lebih besar -->
        </div>

<!-- Grafik Lingkaran -->
<div class="bg-white shadow-lg rounded-lg p-6 mt-6 sm:mt-0 w-full sm:w-[350px]">
    <h2 class="text-xl font-bold mb-4">Grafik Pengunjung Hari Ini</h2>
    <canvas id="dailyChart" width="300" height="300"></canvas>  <!-- Grafik lingkaran lebih kecil -->

    <!-- Menampilkan jumlah dan persentase di bawah grafik -->
    <div class="flex justify-between mt-4">
        <p><span class="font-bold" style="color: rgba(54, 162, 235, 1);">Laki-laki:</span> <strong id="totalMaleWithPercentage"></strong></p>
        <p><span class="font-bold" style="color: rgba(255, 99, 132, 1);">Perempuan:</span> <strong id="totalFemaleWithPercentage"></strong></p>
    </div>
    
    <!-- Teks ketika tidak ada pengunjung hari ini -->
    <div id="noVisitorsText" class="mt-4 text-center text-gray-600 font-semibold hidden">Tidak ada pengunjung hari ini</div>
</div>


    </div>
    <div class="bg-white shadow-lg rounded-lg p-6">
    <h3 class="text-xl font-bold mb-4">Saran</h3>
    <div class="space-y-4">
        <?php 
        use App\Models\SaranModel;

        $saranModel = new SaranModel();
        $sarans = $saranModel->orderBy('TANGGAL_SARAN', 'DESC')->findAll(4);

        foreach ($sarans as $saran):
            $timeAgo = time() - strtotime($saran['TANGGAL_SARAN']);
        
            if ($timeAgo < 60) {
                $timeString = $timeAgo . " detik yang lalu";
            } elseif ($timeAgo < 3600) {
                $timeString = floor($timeAgo / 60) . " menit yang lalu";
            } elseif ($timeAgo < 86400) {
                $timeString = floor($timeAgo / 3600) . " jam yang lalu";
            } else {
                $timeString = floor($timeAgo / 86400) . " hari yang lalu";
            }
        ?>
        
        <div class="flex items-start space-x-4">
            <!-- Icon SVG -->
            <div class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
            <!-- Feedback Content -->
            <div>
                <p class="font-bold"><?= esc($saran['NAMA_SARAN']) ?></p>
                <p class="text-sm text-gray-500"><?= $timeString ?></p>
                <p class="text-gray-700 truncate-multiline"><?= esc($saran['KOMENTAR_SARAN']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <!-- Lihat Selengkapnya -->
    <?php if ($saranModel->countAllResults() > 4): ?>
        <div class="text-center mt-4">
            <a href="<?= site_url('admin/saran/manage') ?>" class="text-blue-600 hover:text-blue-500 font-medium">
                Lihat saran selebihnya &rarr;
            </a>
        </div>
    <?php endif; ?>
</div>
</section>
<style>
    .truncate-multiline {
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Jumlah baris maksimal */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    
// Jam Digital
function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('digitalClock').textContent = `${hours}:${minutes}:${seconds}`;
}
setInterval(updateClock, 1000);

// Inisialisasi dengan memanggil fungsi saat halaman dimuat
updateClock();

// Fungsi untuk menghitung total pengunjung (Laki-laki, Perempuan, Total)
function updateTotals(data) {
    const totalMale = data.laki.reduce((sum, value) => sum + value, 0);
    const totalFemale = data.perempuan.reduce((sum, value) => sum + value, 0);
    const totalVisitors = totalMale + totalFemale;

    document.getElementById('totalMale').textContent = totalMale;
    document.getElementById('totalFemale').textContent = totalFemale;
    document.getElementById('totalVisitors').textContent = totalVisitors;
}



document.addEventListener('DOMContentLoaded', function () {
    const monthlyChartCtx = document.getElementById('monthlyChart').getContext('2d');

    // Data awal dari backend (tahun default)
    const initialData = <?= json_encode($dataBulanan); ?>;

    // Inisialisasi chart bulanan
    const monthlyChart = new Chart(monthlyChartCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [
            {
                label: 'Laki-laki',
                data: initialData.laki,
                backgroundColor: 'rgba(54, 162, 235, 0.3)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true,
            },
            {
                label: 'Perempuan',
                data: initialData.perempuan,
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: true,
            },
        ],
    },
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: 'Bulan' } },
            y: { title: { display: true, text: 'Jumlah Pengunjung' }, beginAtZero: true },
        },
        plugins: {
            legend: {
                display: false, // Menonaktifkan legend
            },
        },
    },
});

// Panggil fungsi updateTotals dengan data awal
updateTotals(initialData);


    // Grafik Harian (Lingkaran)
    const dailyChartCtx = document.getElementById('dailyChart').getContext('2d');
    const dataHarian = <?= json_encode($dataHarian); ?>;

    const dailyChart = new Chart(dailyChartCtx, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [
                {
                    data: [dataHarian.laki, dataHarian.perempuan],
                    backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(255, 99, 132, 0.7)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Menjaga grafik tetap stabil
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const total = tooltipItem.dataset.data.reduce((sum, value) => sum + value, 0);
                            const percentage = ((tooltipItem.raw / total) * 100).toFixed(2);
                            return `${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
                        },
                    },
                },
            },
        },
    });

    // Menampilkan persentase di bawah grafik lingkaran
    const totalLakiHarian = dataHarian.laki;
    const totalPerempuanHarian = dataHarian.perempuan;
    const totalPengunjungHarian = totalLakiHarian + totalPerempuanHarian;

    if (totalLakiHarian === 0 && totalPerempuanHarian === 0) {
        // Jika tidak ada pengunjung hari ini
        document.getElementById('dailyChart').style.display = 'none';  // Menyembunyikan grafik lingkaran
        document.getElementById('noVisitorsText').classList.remove('hidden'); // Menampilkan teks "Tidak ada pengunjung hari ini"

        document.getElementById('totalMaleWithPercentage').textContent = '';
        document.getElementById('totalFemaleWithPercentage').textContent = '';
    } else {
        // Menampilkan grafik dan data persentase
        document.getElementById('dailyChart').style.display = 'block';
        document.getElementById('noVisitorsText').classList.add('hidden'); // Menyembunyikan teks "Tidak ada pengunjung hari ini"
        const malePercentageHarian = ((totalLakiHarian / totalPengunjungHarian) * 100).toFixed(2);
        const femalePercentageHarian = ((totalPerempuanHarian / totalPengunjungHarian) * 100).toFixed(2);

        document.getElementById('totalMaleWithPercentage').textContent = `${totalLakiHarian} (${malePercentageHarian}%)`;
        document.getElementById('totalFemaleWithPercentage').textContent = `${totalPerempuanHarian} (${femalePercentageHarian}%)`;
    }

    // Fetch data ketika tahun diganti
    const yearSelector = document.getElementById('yearSelector');

    yearSelector.addEventListener('change', function () {
    const selectedYear = yearSelector.value;

    fetch(`<?= site_url('admin/statistikBulanan') ?>?year=${selectedYear}`)
        .then(response => response.json())
        .then(data => {
            // Update grafik bulanan
            monthlyChart.data.datasets[0].data = data.laki;
            monthlyChart.data.datasets[1].data = data.perempuan;

            // Update total pengunjung
            updateTotals(data);

            // Render ulang grafik
            monthlyChart.update();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});



    
});

</script>

<style>
    #dailyChart {
    max-width: 100%; /* Membatasi ukuran canvas */
    height: auto; /* Menjaga agar tinggi canvas proporsional dengan lebar */
}

#noVisitorsText {
    font-size: 16px;
}

</style>

<?= $this->endSection(); ?>
