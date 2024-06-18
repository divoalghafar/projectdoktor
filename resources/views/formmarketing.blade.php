<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Marketing</title>
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
    <div class="container mt-4">
        <div class="form-container">
            <h2 class="form-title">Form Input Marketing</h2>
            <form id="marketingForm">
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select border_kolom" placeholder="Pilih Proses"
                        type="text" name="kategori" id="kategori">
                        <option value="" disabled selected class="bi bi-caret-down-fill ">Pilih Kategori</option>
                        <option value="General">General</option>
                        <option value="Biaya Iklan">Biaya Iklan</option>
                        <option value="Biaya Voucher">Biaya Voucher</option>
                        <option value="Biaya Influencer">Biaya Influencer</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kode" class="form-label">Kode</label>
                    <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan Kode">
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan">
                </div>
                <div class="mb-3">
                    <label for="biaya" class="form-label">Biaya</label>
                    <input type="number" class="form-control" id="biaya" name="biaya" placeholder="Masukkan Biaya">
                </div>
                <div class="mb-3">
                    <label for="biayabulan" class="form-label">Biaya Bulan</label>
                    <input type="number" class="form-control" id="biayabulan" name="biayabulan" placeholder="Masukkan Biaya Bulan">
                </div>
                <div class="mb-3">
                    <label for="totalbiaya" class="form-label">Total Biaya</label>
                    <input type="number" class="form-control" id="totalbiaya" name="totalbiaya" placeholder="Masukkan Total Biaya">
                </div>
                <div class="mb-3">
                    <label for="tanggalmarketing" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggalmarketing" name="tanggalmarketing">
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
            $('#marketingForm').on('submit', function(event) {
                event.preventDefault();

                var marketingData = {
                    kategori: $('#kategori').val(),
                    kode: $('#kode').val(),
                    keterangan: $('#keterangan').val(),
                    biaya: $('#biaya').val(),
                    biayabulan: $('#biayabulan').val(),
                    totalbiaya: $('#totalbiaya').val(),
                    tanggalmarketing: $('#tanggalmarketing').val(),
                };

                $.ajax({
                    url: '{{ route('form.marketing.save') }}',
                    method: 'POST',
                    data: marketingData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Sukses');

                            window.location.href = "{{ route('formmarketing') }}";
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
