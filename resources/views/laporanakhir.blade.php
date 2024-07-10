<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Marketing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            margin: auto;
        }
        .form-title {
            background-color: #002b7f;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="form-container">
            <h2 class="form-title">Laporan Akhir</h2>
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Operasional</th>
                        <th>Pengemasan</th>
                        <th>Aset</th>
                        <th>Gaji</th>
                        <th>Marketing</th>
                        <th>Total</th>
                        <th>Bulan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            // Object untuk menyimpan total per bulan
            const totalPerBulan = {};

            // Fungsi untuk memformat angka menjadi format rupiah
            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            // Fungsi untuk mendapatkan nama bulan dalam bahasa Indonesia
            function getMonthName(month) {
                const monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                return monthNames[parseInt(month) - 1];
            }

            // Fungsi untuk memproses data dari API dan menambahkannya ke totalPerBulan
            function processData(apiUrl, key, dateKey, amountKey) {
                return $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;

                            // Proses data untuk menjumlahkan berdasarkan bulan dan tahun
                            data.forEach(item => {
                                const date = new Date(item[dateKey]);
                                const monthYear = `${date.getMonth() + 1}-${date.getFullYear()}`;
                                const jumlah = parseInt(item[amountKey].replace(/[^0-9]/g, ''), 10); // Menghilangkan karakter non-numerik

                                if (!totalPerBulan[monthYear]) {
                                    totalPerBulan[monthYear] = { operasional: 0, pengemasan: 0, aset: 0, marketing: 0, gaji: 0 };
                                }
                                totalPerBulan[monthYear][key] += jumlah;
                            });
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            // Panggil API operasional, pengemasan, aset, dan marketing
            $.when(
                processData('http://127.0.0.1:8000/api/operasional', 'operasional', 'tanggal_operasional', 'jumlah'),
                processData('http://127.0.0.1:8000/api/pengemasan', 'pengemasan', 'tanggal_pengemasan', 'jumlah'),
                processData('http://127.0.0.1:8000/api/aset', 'aset', 'tanggal_aset', 'jumlah'),
                processData('http://127.0.0.1:8000/api/marketing', 'marketing', 'tanggal_marketing', 'biaya'),
                processData('http://127.0.0.1:8000/api/gaji', 'gaji', 'tanggal_gaji', 'biaya')
            ).done(function() {
                // Menambahkan data ke tabel setelah semua API diproses
                Object.keys(totalPerBulan).forEach(monthYear => {
                    const [month, year] = monthYear.split('-');
                    const operasional = totalPerBulan[monthYear].operasional;
                    const pengemasan = totalPerBulan[monthYear].pengemasan;
                    const aset = totalPerBulan[monthYear].aset;
                    const marketing = totalPerBulan[monthYear].marketing;
                    const gaji = totalPerBulan[monthYear].gaji;
                    const total = operasional + pengemasan + aset + marketing + gaji;
                    $('#example tbody').append(`
                        <tr>
                            <td>${formatRupiah(operasional.toString(), 'Rp. ')}</td>
                            <td>${formatRupiah(pengemasan.toString(), 'Rp. ')}</td>
                            <td>${formatRupiah(aset.toString(), 'Rp. ')}</td>
                            <td>${formatRupiah(gaji.toString(), 'Rp. ')}</td>
                            <td>${formatRupiah(marketing.toString(), 'Rp. ')}</td>
                            <td>${formatRupiah(total.toString(), 'Rp. ')}</td>
                            <td>${getMonthName(month)} ${year}</td>
                        </tr>
                    `);
                });

                // Inisialisasi DataTables setelah data ditambahkan
                $('#example').DataTable();
            });
        });
    </script>
</body>
</html>
