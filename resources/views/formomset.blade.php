<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Omset</title>
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
            <h2 class="form-title">Form Input Omset</h2>
            <form id="omsetForm">
                <div class="mb-3">
                    <label for="biaya" class="form-label">Biaya</label>
                    <input type="text" class="form-control" id="biaya" name="biaya" placeholder="Masukkan Biaya">
                </div>
                <div class="mb-3">
                    <label for="tanggalomset" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggalomset" name="tanggalomset">
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
            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    var separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            $('#biaya').on('input', function() {
                $(this).val(formatRupiah($(this).val(), 'Rp. '));
            });

            $('#omsetForm').on('submit', function(event) {
                event.preventDefault();

                var omsetData = {
                    biaya: $('#biaya').val(),
                    tanggalomset: $('#tanggalomset').val(),
                };

                $.ajax({
                    url: '{{ route('form.omset.save') }}',
                    method: 'POST',
                    data: omsetData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Sukses');

                            window.location.href = "{{ route('formomset') }}";
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