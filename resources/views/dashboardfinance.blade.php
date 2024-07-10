<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar" style="background-color: #012060;">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 text-white" style="margin-left: 39rem; font-size: 1.5rem; font-weight: bold;">DASHBOARD - FINANCE</span>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Omset laba</h5>
                        <div>
                            <label for="yearFilter" class="form-label">Filter by Year</label>
                            <select id="yearFilter" class="form-select">
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            </select>
                        </div>
                        <canvas id="omsetLabaChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tipe Pengeluaran</h5>
                        <div class="chart-container" style="height: 26rem; margin-left: 9rem;">
                            <canvas id="tipePengeluaranChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pengeluaran</h5>
                        <div>
                            <label for="pengeluaranFilter" class="form-label">Pengeluaran</label>
                            <select id="pengeluaranFilter" class="form-select">
                                <option value="aset">Aset</option>
                                <option value="operasional">Operasional</option>
                                <option value="pengemasan">Pengemasan</option>
                                <option value="marketing">Marketing</option>
                                <option value="gaji">Gaji</option> 
                            </select>
                        </div>
                        <div class="chart-container" style="height: 15rem; margin-left: 4rem;">
                            <canvas id="pengeluaranChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Omset</h5>
                        <input type="text" id="totalOmset" class="form-control mb-2" placeholder="Total Omset" readonly>
                        <h5 class="card-title">Laba</h5>
                        <input type="text" id="totalLaba" class="form-control mb-2" placeholder="Laba" readonly>
                        <h5 class="card-title">%</h5>
                        <input type="text" id="percentageLaba" class="form-control mb-2" placeholder="%" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <script>
        const omsetData = {};
        const labaData = {};
        const pengeluaranData = {};
        let omsetLabaChart = null;
        let pengeluaranChart = null;
        const pengeluaranTotals = {
            aset: 0,
            operasional: 0,
            pengemasan: 0,
            marketing: 0,
            gaji: 0
        };

        function fetchData() {
            fetch('http://127.0.0.1:8000/api/omset')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        processOmsetData(data.data);
                    }
                })
                .catch(error => console.error('Error fetching omset data:', error));

            fetch('http://127.0.0.1:8000/api/laba')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        processLabaData(data.data);
                    }
                })
                .catch(error => console.error('Error fetching laba data:', error));

            // Fetch initial pengeluaran data for the default category
            fetchPengeluaranData('aset');
        }

        function processOmsetData(data) {
            const yearMonthTotals = {};

            data.forEach(item => {
                const date = new Date(item.tanggal_omset);
                const year = date.getFullYear();
                const month = date.getMonth();
                const biaya = parseInt(item.biaya.replace(/Rp\.|\./g, '').trim());

                if (!yearMonthTotals[year]) {
                    yearMonthTotals[year] = Array(12).fill(0);
                }
                yearMonthTotals[year][month] += biaya;
            });

            Object.keys(yearMonthTotals).forEach(year => {
                omsetData[year] = yearMonthTotals[year];
            });

            updateYearFilter();
            initializeChart();
        }

        function processLabaData(data) {
            const yearMonthTotals = {};

            data.forEach(item => {
                const date = new Date(item.tanggal_laba);
                const year = date.getFullYear();
                const month = date.getMonth();
                const biaya = parseInt(item.biaya.replace(/Rp\.|\./g, '').trim());

                if (!yearMonthTotals[year]) {
                    yearMonthTotals[year] = Array(12).fill(0);
                }
                yearMonthTotals[year][month] += biaya;
            });

            Object.keys(yearMonthTotals).forEach(year => {
                labaData[year] = yearMonthTotals[year];
            });

            updateYearFilter();
            initializeChart();
        }

        function fetchPengeluaranData(category) {
            const apiUrlMap = {
                aset: 'http://127.0.0.1:8000/api/aset',
                operasional: 'http://127.0.0.1:8000/api/operasional',
                pengemasan: 'http://127.0.0.1:8000/api/pengemasan',
                marketing: 'http://127.0.0.1:8000/api/marketing',
                gaji: 'http://127.0.0.1:8000/api/gaji'
            };

            fetch(apiUrlMap[category])
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        processPengeluaranData(data.data, category);
                    }
                })
                .catch(error => console.error(`Error fetching ${category} data:`, error));
        }

        function processPengeluaranData(data, category) {
            const yearMonthTotals = {};
            let totalCategory = 0;

            data.forEach(item => {
                let date, biaya;

                if (category === 'aset') {
                    date = new Date(item.tanggal_aset);
                    biaya = parseInt(item.jumlah.replace(/Rp\.|\./g, '').trim());
                } else if (category === 'operasional') {
                    date = new Date(item.tanggal_operasional);
                    biaya = parseInt(item.jumlah.replace(/Rp\.|\./g, '').trim());
                } else if (category === 'pengemasan') {
                    date = new Date(item.tanggal_pengemasan);
                    biaya = parseInt(item.jumlah.replace(/Rp\.|\./g, '').trim());
                } else if (category === 'marketing') {
                    date = new Date(item.tanggal_marketing);
                    biaya = parseInt(item.biaya.replace(/Rp\.|\./g, '').trim());
                } else if (category === 'gaji') {
                    date = new Date(item.tanggal_gaji);
                    biaya = parseInt(item.biaya.replace(/Rp\.|\./g, '').trim());
                }

                const year = date.getFullYear();
                const month = date.getMonth();

                if (!yearMonthTotals[year]) {
                    yearMonthTotals[year] = Array(12).fill(0);
                }
                yearMonthTotals[year][month] += biaya;
                totalCategory += biaya;
            });

            Object.keys(yearMonthTotals).forEach(year => {
                pengeluaranData[year] = yearMonthTotals[year];
            });

            pengeluaranTotals[category] = totalCategory;

            initializePengeluaranChart();
            updateTipePengeluaranChart();
        }

        function updateYearFilter() {
            const yearFilter = document.getElementById('yearFilter');
            yearFilter.innerHTML = '';

            const years = new Set([...Object.keys(omsetData), ...Object.keys(labaData)]);

            years.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.text = year;
                yearFilter.appendChild(option);
            });

            yearFilter.value = new Date().getFullYear();
            updateTotalValues(yearFilter.value);
        }

        function initializeChart() {
            const ctx1 = document.getElementById('omsetLabaChart').getContext('2d');
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            if (omsetLabaChart) {
                omsetLabaChart.destroy();
            }

            omsetLabaChart = new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: monthNames,
                    datasets: [
                        {
                            label: 'Omset',
                            data: omsetData[document.getElementById('yearFilter').value] || [],
                            borderColor: 'green',
                            borderWidth: 1
                        },
                        {
                            label: 'Laba',
                            data: labaData[document.getElementById('yearFilter').value] || [],
                            borderColor: 'red',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp. ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            document.getElementById('yearFilter').addEventListener('change', updateTotalValues);
        }

        function initializePengeluaranChart() {
            const ctx2 = document.getElementById('pengeluaranChart').getContext('2d');
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            if (pengeluaranChart) {
                pengeluaranChart.destroy();
            }

            pengeluaranChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: monthNames,
                    datasets: [
                        {
                            label: 'Pengeluaran',
                            data: pengeluaranData[document.getElementById('yearFilter').value] || [],
                            borderColor: 'blue',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp. ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        function updateTotalValues(year) {
            const selectedYear = year || document.getElementById('yearFilter').value;
            const totalOmset = omsetData[selectedYear] ? omsetData[selectedYear].reduce((a, b) => a + b, 0) : 0;
            const totalLaba = labaData[selectedYear] ? labaData[selectedYear].reduce((a, b) => a + b, 0) : 0;

            document.getElementById('totalOmset').value = 'Rp. ' + totalOmset.toLocaleString();
            document.getElementById('totalLaba').value = 'Rp. ' + totalLaba.toLocaleString();
            document.getElementById('percentageLaba').value = totalOmset ? ((totalLaba / totalOmset) * 100).toFixed(2) + '%' : '0%';

            initializeChart();
            initializePengeluaranChart();
        }

        document.getElementById('pengeluaranFilter').addEventListener('change', function() {
            fetchPengeluaranData(this.value);
        });

        document.getElementById('yearFilter').addEventListener('change', function() {
            updateTotalValues(this.value);
        });

        function updateTipePengeluaranChart() {
            const totalPengeluaran = Object.values(pengeluaranTotals).reduce((a, b) => a + b, 0);
            const percentages = Object.keys(pengeluaranTotals).map(category => (pengeluaranTotals[category] / totalPengeluaran * 100).toFixed(2));

            tipePengeluaranChart.data.datasets[0].data = percentages;
            tipePengeluaranChart.update();
        }

        const ctx3 = document.getElementById('tipePengeluaranChart').getContext('2d');
        const tipePengeluaranChart = new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: ['Aset', 'Operasional', 'Pengemasan', 'Marketing', 'Gaji'],
                datasets: [
                    {
                        label: 'Tipe Pengeluaran',
                        data: [0, 0, 0, 0, 0], // initial data, will be updated
                        backgroundColor: ['blue', 'orange', 'gray', 'yellow', 'red'],
                    }
                ]
            },
            options: {
                responsive: true,
            }
        });

        fetchData();

    </script>
</body>
</html>