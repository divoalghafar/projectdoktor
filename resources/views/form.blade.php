<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Manajemen Resiko - Retur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
    <div class="container mt-4
    ">
        <div class="form-container">
            <h2 class="form-title">Form Input Manajemen Resiko - Retur</h2>
            <form id="resikoForm">
                <div class="mb-3">
                    <label for="namaBarang" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="namaBarang" name="namaBarang" placeholder="Masukkan Barang">
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah">
                </div>
                <div class="mb-3">
                    <label for="penyebab" class="form-label">Penyebab</label>
                    <input type="text" class="form-control" id="penyebab" name="penyebab" placeholder="Masukkan Penyebab">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" class="form-control" id="status" name="status" placeholder="Masukkan Status">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan">
                </div>
                <div class="mb-3">
                    <label for="tanggalRetur" class="form-label">Tanggal Retur</label>
                    <input type="date" class="form-control" id="tanggalRetur" name="tanggalRetur">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#resikoForm').on('submit', function(event) {
                event.preventDefault();

                var formData = {
                    namaBarang: $('#namaBarang').val(),
                    jumlah: $('#jumlah').val(),
                    penyebab: $('#penyebab').val(),
                    status: $('#status').val(),
                    keterangan: $('#keterangan').val(),
                    tanggalRetur: $('#tanggalRetur').val(),
                };

                $.ajax({
                    url: '{{ route('form.save') }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Sukses');
                        } else {
                            toastr.error('Terjadi kesalahan dalam mengirim data', 'Error');
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        toastr.error('Error - ' + errorMessage, 'Error');
                    }
                });
            });
        });
    </script>
</body>
</html>
