<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANAJEMEN RESIKO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .chart-container {
            width: 100%;
            height: 400px;
        }
        .table-container {
            max-height: 260px; /* Adjust as needed */
            overflow-y: auto;
        }
        .table-container thead th {
            position: sticky;
            top: 0;
            z-index: 1;
        }
    </style>
</head>
<body>
    <nav class="navbar" style="background-color: #012060;">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 text-white" style="margin-left: 33rem; font-size: 2rem; font-weight: bold;">MANAJEMEN RESIKO - RETUR</span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="h4 text-center mt-3">JUMLAH BARANG RETUR</div>
                <div class="card w-100 h-70 mb-3" style="border: 2px solid;">
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="h4 text-center mt-3">STATUS RETUR</div>
                <div class="card w-100 h-70 mb-3" style="border: 2px solid;">
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="doughnutChart" style="margin-left: 9rem;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-container">
            <table class="table table-bordered">
                <thead >
                    <tr>
                        <th style="background-color: #012060; color: white">Tanggal Retur</th>
                        <th style="background-color: #012060; color: white">Nama Barang</th>
                        <th style="background-color: #012060; color: white">Jumlah</th>
                        <th style="background-color: #012060; color: white">Penyebab</th>
                        <th style="background-color: #012060; color: white">Status</th>
                        <th style="background-color: #012060; color: white">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item['Tanggal Retur']}}</td>
                            <td>{{ $item['Nama Barang']}}</td>
                            <td>{{ $item['Jumlah']}}</td>
                            <td>{{ $item['Penyebab']}}</td>
                            <td>{{ $item['Status']}}</td>
                            <td style="font-size: 12px; ">{{ $item['Keterangan']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>





    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <script>

        function fetchData() {
            return $.ajax({
                url: '{{ url ("/api/data") }}',
                method: 'GET',
                dataType: 'json'
            });
        }
        
        
        
        // Update the charts with the fetched data
        function updateCharts(data) {
            console.log(data);
            let returnData = data.data
            const totalReturns = returnData.length;

            const lineChartLabels = data.data.map(item => item['Tanggal Retur']);
            const groupedReturns = {};

            for (const returnItem of returnData) {

                const returnDate = new Date(returnItem["Tanggal Retur"]);
                const year = returnDate.getFullYear();
                const month = returnDate.getMonth() + 1;
                // console.log(year, month);
                const groupKey = `${year}-${month}`; // Combine year and month for the group key

                if (!groupedReturns[groupKey]) {
                    groupedReturns[groupKey] = {
                        "totalReturns": 0,
                        "products": {},
                        "reasons": {}
                    };
                }

                const group = groupedReturns[groupKey];
                group.totalReturns += returnItem["Jumlah"];
                // console.log(group);

            }

            let datalabels = [];
            let datavalues = [];
            for (const groupKey in groupedReturns) {
                const group = groupedReturns[groupKey];
                const [year, month] = groupKey.split("-");

                console.log(`Year: ${year}, Month: ${month}`);
                console.log(`Total Returns: ${group.totalReturns}`);
                datalabels.push(`${year}-${month}`);
                datavalues.push(group.totalReturns);
            }

            console.log(lineChartLabels);
            const lineChartData = data['Jumlah'];
            const doughnutChartLabels = data['Status'];
            const doughnutChartData = data['Jumlah'];


            const returnsByStatus = {
                "Selesai": 0,
                "Proses": 0
                };

            for (const returnItem of returnData) {
                const returnStatus = returnItem["Status"];
                returnsByStatus[returnStatus] += 1;            
            }

            console.log(returnsByStatus);

            let datastatus = [];
            let datajumlah = [];
            for (const status in returnsByStatus) {
                const count = returnsByStatus[status];
                const percentage = (count / totalReturns) * 100;

                console.log(`${status}:`);
                console.log(`Total Returns: ${count}`);
                console.log(`Percentage: ${percentage.toFixed(2)}%`); // Round to 2 decimal places
                console.log("-----------------------"); // Separator between groups
                datastatus.push(status);
                datajumlah.push(percentage.toFixed(2));
            }
            // Update line chart
            const lineChart = new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: datalabels,
                    datasets: [{
                        label: 'Record Count',
                        data: datavalues,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Update doughnut chart
            const doughnutChart = new Chart(document.getElementById('doughnutChart'), {
                type: 'doughnut',
                data: {
                    labels: datastatus,
                    datasets: [{
                        data: datajumlah,
                        backgroundColor: ['#28a745', '#ffc107']
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right'
                        }
                    }
                }
            });
        }

        // Fetch and update charts and table on page load
        $(document).ready(function() {
            fetchData().done(function(data) {
            updateCharts(data);

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching data: ', textStatus, errorThrown);
            });
        });

    </script>
</body>
</html>