<?= $this->extend('superadmin/sidebar'); ?>

<?= $this->section('content'); ?>
<section>
<div class="bg-white min-h-screen p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Statistik Pengunjung</h1>

    <div class="flex flex-col sm:flex-row gap-6">
        <!-- Grafik Garis -->
        <div class="bg-white shadow-lg rounded-lg p-6 flex-1">
            <h2 class="text-xl font-bold mb-4">Statistik Pengunjung per Bulan</h2>
            <div class="flex justify-between mb-4">
                <select id="yearSelector" class="border px-3 py-2 rounded">
                    <!-- Tahun akan muncul jika ada datanya -->
                    <?php if (!empty($years)): ?>
                        <?php foreach ($years as $year): ?>
                            <option value="<?= $year ?>" <?= $year == $year ? 'selected' : '' ?>><?= $year ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                
                <div class="flex items-center">
    <p><span class= "font-bold" style="color: rgba(54, 162, 235, 1);">Laki-laki:</span> <strong id="totalMale"></strong></p>
    <p class="ml-4 font-bold"><span style="color: rgba(255, 99, 132, 1);">Perempuan:</span> <strong id="totalFemale"></strong></p>
    <p class="ml-4 font-bold">Total: <strong id="totalVisitors"></strong></p>
</div>

            </div>
            <canvas id="monthlyChart" width="650" height="350"></canvas>  <!-- Grafik garis lebih besar -->
        </div>

<!-- Grafik Lingkaran -->
<div class="bg-white shadow-lg rounded-lg p-6 mt-6 sm:mt-0 w-full sm:w-[350px]">
    <h2 class="text-xl font-bold mb-4">Distribusi Pengunjung Hari Ini</h2>
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
</section>

<!-- Section Baru untuk Konten Lainnya -->
<section class="mt-10">
    <!-- Anda bisa menambahkan konten lain di sini -->
</section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const monthlyChartCtx = document.getElementById('monthlyChart').getContext('2d');
    const dailyChartCtx = document.getElementById('dailyChart').getContext('2d');

    // Data yang dikirim dari backend
    const dataBulanan = <?= json_encode($dataBulanan); ?>;
    const dataHarian = <?= json_encode($dataHarian); ?>;

    // Menampilkan total Laki-laki, Perempuan, dan Total di Grafik Garis
    const totalLaki = dataBulanan.laki.reduce((a, b) => a + b, 0);
    const totalPerempuan = dataBulanan.perempuan.reduce((a, b) => a + b, 0);
    document.getElementById('totalMale').textContent = totalLaki;
    document.getElementById('totalFemale').textContent = totalPerempuan;
    document.getElementById('totalVisitors').textContent = totalLaki + totalPerempuan;

    // Data Grafik Bulanan
    const monthlyData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'Laki-laki',
                data: dataBulanan.laki,
                backgroundColor: 'rgba(54, 162, 235, 0.3)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true,
                pointStyle: 'circle',
            },
            {
                label: 'Perempuan',
                data: dataBulanan.perempuan,
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: true,
                pointStyle: 'circle',
            },
        ],
    };

    // Grafik Bulanan
    const monthlyChart = new Chart(monthlyChartCtx, {
        type: 'line',
        data: monthlyData,
        options: {
            responsive: true,
            maintainAspectRatio: true, // Menjaga rasio grafik tetap stabil
            hover: {
                mode: 'index',
                intersect: false,
                animationDuration: 0,
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    position: 'nearest',
                    callbacks: {
                        title: function(tooltipItem) {
                            return `${tooltipItem[0].label}`;
                        },
                        label: function(tooltipItem) {
                            const maleData = tooltipItem.datasetIndex === 0 ? tooltipItem.raw : 0;
                            const femaleData = tooltipItem.datasetIndex === 1 ? tooltipItem.raw : 0;
                            return `${tooltipItem.datasetIndex === 0 ? 'Laki-laki' : 'Perempuan'}: ${maleData + femaleData}`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    title: { display: true, text: 'Bulan' },
                    grid: { display: false },
                    ticks: {
                        autoSkip: true,
                        maxRotation: 45,
                        minRotation: 45,
                    },
                },
                y: {
                    title: { display: true, text: 'Jumlah Pengunjung' },
                    beginAtZero: true,
                    ticks: { stepSize: 10 },
                    grid: { drawBorder: false },
                },
            },
            elements: {
                line: { tension: 0.4 },
                point: { radius: 4 },
            },
        },
    });

    // Grafik Harian (Lingkaran)
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

        fetch(`<?= site_url('superadmin/statistik/bulanan') ?>?year=${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                monthlyChart.data.datasets[0].data = data.laki;
                monthlyChart.data.datasets[1].data = data.perempuan;
                monthlyChart.update();
                document.getElementById('totalMale').textContent = data.laki.reduce((a, b) => a + b, 0);
                document.getElementById('totalFemale').textContent = data.perempuan.reduce((a, b) => a + b, 0);
                document.getElementById('totalVisitors').textContent = document.getElementById('totalMale').textContent + document.getElementById('totalFemale').textContent;
            })
            .catch(error => console.error('Error:', error));
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
