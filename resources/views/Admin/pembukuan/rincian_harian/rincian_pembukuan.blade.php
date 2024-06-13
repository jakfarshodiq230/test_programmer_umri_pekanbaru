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
                    Detail Pembukuan Perhari
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card" id="formInput">
                                <div class="card-body">
                                    <div class="col-12" id="formData">
                                        <div class="row align-items-end text-center">
                                            <!-- Left side: Periode and Tahun -->
                                            <div class="col-md-6 d-flex align-items-end">
                                                <div>
                                                    <div class="d-flex">
                                                        <div class="me-0">Periode</div>
                                                        <div class="ms-2">:</div>
                                                        <div class="ms-2">
                                                            {{ strtoupper($judul_periode->judul_periode) }}</div>
                                                    </div>
                                                    <div class="d-flex mt-2">
                                                        <div class="me-4">Hari</div>
                                                        <div class="ms-2">:</div>
                                                        <div class="ms-2">
                                                            {{ date('d F Y', strtotime($pembukuan->tanggal_pembukuan)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right side: Cetak button -->
                                            <div class="col-md-6 d-flex justify-content-end align-items-end text-end">
                                                <button type="button" id="cetakBtn" class="btn btn-primary cetakBtn"
                                                    data-pembukuan="{{ $id_pembukuan }}"
                                                    data-periode="{{ $id_periode }}">Cetak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 col-lg-12">
                                <car class="card" id="formInput">
                                    <div class="card-body">
                                        <table id="datatables-ajax-periode" class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Tanggal</th>
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
                                                    <th>Tanggal</th>
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
                    </div>
                </div>
            </div>
        </div>
        <iframe id="printIframe" style="display: none;"></iframe>
    </main>
@endsection
@section('scripts')
    <script>
        $('#cetakBtn').hide();
        var id_periode = '{{ $id_periode }}';
        var id_pembukuan = '{{ $id_pembukuan }}';

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
        $('#datatables-ajax-periode').DataTable({
            processing: true,
            serverSide: false,
            retrieve: false,
            destroy: true,
            responsive: true,
            ajax: '{{ url('pembukuan/list_data_pembukuan_hari_periode_rincian') }}/' + id_periode + '/' +
                id_pembukuan,
            columns: [{
                    data: null,
                    name: 'nomor',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'tgl_hari_pembukuan',
                    name: 'tgl_hari_pembukuan',
                    className: 'text-center',
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
                                <button class="btn btn-sm btn-primary lihatBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" data-id="${row.id_pembukuan}" data-periode="${row.id_periode}" data-tggl ="${row.tgl_hari_pembukuan}"><i class="fas fa-eye"></i></button>
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
                        url: '{{ url('pembukuan/list_data_pembukuan_hari_periode_rincian') }}/' +
                            id_periode + '/' + id_pembukuan,
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

        // data lanjutan hari rincian
        $(document).on('click', '.lihatBtn', function() {
            var pembukuan = $(this).data('id');
            var periode = $(this).data('periode');
            var tanggal = $(this).data('tggl');
            var url = '{{ url('pembukuan/data_detail_pembukuan_hari_periode_rincian') }}/' + pembukuan + '/' +
                periode + '/' + tanggal;
            window.location.href = url;
        });

        // cetak
        $(document).on('click', '.cetakBtn', function() {
            var pembukuan = $(this).data('pembukuan');
            var periode = $(this).data('periode');
            var url = '{{ url('pembukuan/cetak_rincian_pdf') }}/' + pembukuan + '/' +
                periode;
            let iframe = document.getElementById('printIframe');
            iframe.src = url;

            iframe.onload = function() {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            };
        });
    </script>
@endsection
