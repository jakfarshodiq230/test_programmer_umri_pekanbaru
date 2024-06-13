@extends('Admin.layout')
@section('content')
    <style>
        .dataTables_wrapper .dt-buttons {
            float: left;
            margin-top: 0;
        }

        .synchronize-btn {
            margin-top: 0;
        }

        #formInput {
            border: 2px solid #153d77;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            //text-align: center;
        }
    </style>
    <main class="content">
        <div class="container-fluid">

            <div class="header">
                <h1 class="header-title">
                    Pembukuan Perbulan
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card" id="formInput">
                                <div class="card-body">
                                    <div class="col-12 justify-content-center" id="formData">
                                        <form method="POST" id="dataForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row align-items-end">
                                                <div class="col-12 col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="id_periode">Periode</label>
                                                        <select name="id_periode" id="id_periode"
                                                            class="form-control select2" required>
                                                            <option selected>PILIH</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="bulan">Bulan</label>
                                                        <select name="bulan" id="bulan" class="form-control select2"
                                                            required>
                                                            @php
                                                            $months = [
                                                                '01' => 'January',
                                                                '02' => 'February',
                                                                '03' => 'March',
                                                                '04' => 'April',
                                                                '05' => 'May',
                                                                '06' => 'June',
                                                                '07' => 'July',
                                                                '08' => 'August',
                                                                '09' => 'September',
                                                                '10' => 'October',
                                                                '11' => 'November',
                                                                '12' => 'December',
                                                            ];
                                                        @endphp
                                                        
                                                        @foreach ($months as $key => $month)
                                                            <option value="{{ $key }}">{{ $month}}</option>
                                                        @endforeach                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <label for="tahun">Tahun</label>
                                                        <select name="tahun" id="tahun" class="form-control select2"
                                                            required>
                                                            @for ($tahun = date('Y'); $tahun >= date('Y') - 10; $tahun--)
                                                                <option value="{{ $tahun }}">{{ $tahun }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3 mb-3">
                                                    <div class="form-group">
                                                        <button type="button" id="saveBtn"
                                                            class="btn btn-primary mt-4">Proses</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 col-lg-12">
                                <car class="card" id="formInput">
                                    <div class="card-body">
                                        <table id="datatables-ajax-bulan" class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Periode</th>
                                                    <th>Pembelian</th>
                                                    <th>Penjualan</th>
                                                    <th>Pengeluaran</th>
                                                    <th>Hasil</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Periode</th>
                                                    <th>Pembelian</th>
                                                    <th>Penjualan</th>
                                                    <th>Pengeluaran</th>
                                                    <th>Hasil</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </car>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        $('#cetakBtn').hide();
        function formatRupiah(angka) {
            // Mengonversi angka ke format Rupiah
            var reverse = Math.abs(angka).toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');

            // Menambahkan tanda minus jika angka negatif
            var formatted = 'Rp ' + ribuan;
            if (angka < 0) {
                formatted = '-' + formatted;
            }

            return formatted;
        }

        // data periode
        $(document).ready(function() {
            $.ajax({
                url: '{{ url('pembukuan/data_periode') }}', // Ganti dengan URL skrip PHP Anda
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Hapus semua opsi kecuali yang pertama (PILIH)
                    $('select[name="id_periode"]').find('option:not(:first)').remove();

                    // Tambahkan opsi baru berdasarkan data yang diterima dari server
                    $.each(response.data, function(index, value) {
                        $('select[name="id_periode"]').append('<option value="' + value
                            .id_periode +
                            '">' + value.judul_periode.toUpperCase() + '</option>');
                    });

                    // Aktifkan kembali plugin Select2 setelah memperbarui opsi
                    $('.select2').select2();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // database periode
        $('#datatables-ajax-bulan').DataTable({
            processing: true,
            serverSide: false,
            retrieve: false,
            destroy: true,
            responsive: true,
            ajax: '{{ url('pembukuan/data_pembukuan_bulan_periode') }}',
            columns: [{
                    data: null,
                    name: 'nomor',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'id_periode',
                    name: 'id_periode',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return row.judul_periode + '<br>[' + row.id_periode + ']'+'<br>[' + row.bulan_pembukuan + ']';
                    }
                },
                {
                    data: 'total_berat_pembelian',
                    name: 'total_berat_pembelian',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + ' kg';
                    }
                },
                {
                    data: 'total_berat_penjualan',
                    name: 'total_berat_penjualan',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + ' kg';
                    }
                },
                {
                    data: 'total_pengeluaran',
                    name: 'total_pengeluaran',
                    className: 'text-center',

                    render: function(data, type, row) {
                        // Format harga ke format Rupiah
                        var hargaFormatted = formatRupiah(data);
                        return hargaFormatted;
                    }

                },
                {
                    data: 'pendapatan_bersih',
                    name: 'pendapatan_bersih',
                    className: 'text-center',
                    render: function(data, type, row) {
                        // Format harga ke format Rupiah
                        var hargaFormatted = formatRupiah(data);
                        return hargaFormatted;
                    }

                },
                {
                    data: null,
                    name: 'action',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                                <button class="btn btn-sm btn-primary lihatBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" data-id="${row.id_pembukuan}" data-periode ="${row.id_periode}"><i class="fas fa-eye"></i></button>
                            `;
                    }
                }

            ],
            drawCallback: function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).data().length;

                if (rows === 0) {
                    $('#cetakBtn').hide(); // Hide the button if no rows
                } else {
                    $('#cetakBtn').show(); // Show the button if there are rows
                }
            },
            // button costum + progres bar
            dom: 'Bfrtip',
            buttons: [{
                text: 'Synchronize',
                className: 'btn btn-primary synchronize-btn',
                action: function(e, dt, node, config) {
                    // Show progress bar
                    $('#progress').show();

                    $.ajax({
                        url: '{{ url('pembukuan/data_pembukuan_hari_periode') }}',
                        type: 'GET',
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            // Listen to the progress event
                            xhr.upload.addEventListener("progress", function(
                                evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded /
                                        evt.total;
                                    // Update progress bar
                                    $('#progress-bar').css('width',
                                        percentComplete * 100 + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function() {
                            // Reset progress bar
                            $('#progress-bar').css('width', '0%');
                        },
                        success: function(response) {
                            // Hide progress bar on success
                            $('#progress').hide();
                            Swal.fire({
                                title: 'Success!',
                                text: 'Berhasil Synhronize data',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#datatables-ajax').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            // Hide progress bar on error
                            $('#progress').hide();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal Synhronize data',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        },
                        complete: function() {
                            // Hide progress bar on completion
                            $('#progress').hide();
                        }
                    });
                }
            }]

            // end button costum + progres bar
        });

        // end datatable pembelian

        //save pembelian
        $('#saveBtn').on('click', function() {
            var url = '{{ url('pembukuan/store_pembukuan_bulan') }}';
            $.ajax({
                url: url,
                method: 'POST',
                data: $('#dataForm').serialize(),
                success: function(response) {
                    $('#datatables-ajax-bulan').DataTable().ajax.reload();
                    Swal.fire({
                        title: 'Success!',
                        text: response.massage,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.massage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // data lanjutan hari rincian
        $(document).on('click', '.lihatBtn', function() {
            var id = $(this).data('id');
            var idPeriode = $(this).data('periode');
            // Construct the URL based on the id and tggl
            var url = '{{ url('pembukuan/data_pembukuan_bulan_periode_rincian') }}/' + id + '/' + idPeriode;

            // Open the URL link
            window.location.href = url;
        });
    </script>
@endsection
