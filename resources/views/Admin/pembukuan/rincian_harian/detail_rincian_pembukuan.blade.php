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
                                        <div class="row">
                                            <!-- Left side: Periode and Tahun -->
                                            <div class="col-md-6 d-flex align-items-end">
                                                <div>
                                                    <div class="d-flex">
                                                        <div class="me-0">Periode</div>
                                                        <div class="ms-2">:</div>
                                                        <div class="ms-2">{{ strtoupper($judul_periode->judul_periode) }}
                                                        </div>
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
                                                    data-pembukuan="{{ $id_pembukuan }}" data-periode="{{ $id_periode }}"
                                                    data-tggl="{{ $tanggal }}">Cetak</button>
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
                                        <div class="col-12 col-lg-12">
                                            <div class="tab">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item"><a class="nav-link active" href="#tab-1"
                                                            data-bs-toggle="tab" role="tab">PEMBELIAN</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#tab-2"
                                                            data-bs-toggle="tab" role="tab">PENJUALAN</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#tab-3"
                                                            data-bs-toggle="tab" role="tab">PENGELUARAN</a></li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab-1" role="tabpanel">
                                                        <div class="card-body">
                                                            <table id="datatables-ajax-pembelian"
                                                                class="table table-striped display" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th class="text-center">Nomor Faktur</th>
                                                                        <th class="text-center">Tanggal</th>
                                                                        <th class="text-center">Berat</th>
                                                                        <th class="text-center">Nominal</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th class="text-center">Nomor Faktur</th>
                                                                        <th class="text-center">Tanggal</th>
                                                                        <th class="text-center">Berat</th>
                                                                        <th class="text-center">Nominal</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane " id="tab-2" role="tabpanel">
                                                        <div class="card-body" id="formInput">
                                                            <table id="datatables-ajax-penjualan"
                                                                class="table table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th class="text-center">Nomor Faktur</th>
                                                                        <th class="text-center">Berat</th>
                                                                        <th class="text-center">Pendapatan</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th class="text-center">Nomor Faktur</th>
                                                                        <th class="text-center">Berat</th>
                                                                        <th class="text-center">Pendapatan</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab-3" role="tabpanel">
                                                        <div class="card-body" id="formInput">
                                                            <table id="datatables-ajax-pengeluaran"
                                                                class="table table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th class="text-center">Nomor Faktur</th>
                                                                        <th class="text-center">Nominal</th>
                                                                        <th class="text-center">Keterangan</th>
                                                                        <th class="text-center">Tanggal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th class="text-center">Nomor Faktur</th>
                                                                        <th class="text-center">Nominal</th>
                                                                        <th class="text-center">Keterangan</th>
                                                                        <th class="text-center">Tanggal</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        $(document).ready(function() {
            var id_periode = '{{ $id_periode }}';
            var id_pembukuan = '{{ $id_pembukuan }}';
            var tanggal = '{{ $tanggal }}';

            // format rupiah
            function formatRupiah(angka) {
                // Mengonversi angka ke format Rupiah
                var reverse = Math.abs(angka).toString().split('').reverse().join('');
                var ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');

                // Menambahkan tanda minus jika angka negatif
                var formatted = 'Rp ' + ribuan;
                if (angka < 0) {
                    formatted = '- ' + formatted;
                }

                return formatted;
            }


            function initDataTable(selector, ajaxUrl, columns) {
                return $(selector).DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: ajaxUrl,
                        dataSrc: function(json) {
                            console.log('Data received from server for', selector, ':', json);
                            return json.data; // Adjust this based on your response structure
                        }
                    },
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
                    columns: columns,
                    dom: 'Bfrtip',
                    buttons: [{
                        text: 'Synchronize',
                        className: 'btn btn-primary synchronize-btn',
                        action: function(e, dt, node, config) {
                            // Show progress bar
                            $('#progress').show();

                            $.ajax({
                                url: ajaxUrl,
                                type: 'GET',
                                xhr: function() {
                                    var xhr = new window.XMLHttpRequest();
                                    xhr.upload.addEventListener("progress",
                                        function(evt) {
                                            if (evt.lengthComputable) {
                                                var percentComplete = evt
                                                    .loaded / evt.total;
                                                $('#progress-bar').css('width',
                                                    percentComplete * 100 +
                                                    '%');
                                            }
                                        }, false);
                                    return xhr;
                                },
                                beforeSend: function() {
                                    $('#progress-bar').css('width', '0%');
                                },
                                success: function(response) {
                                    $('#progress').hide();
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Berhasil Synchronize data',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                    $(selector).DataTable().ajax.reload();
                                },
                                error: function(xhr, status, error) {
                                    $('#progress').hide();
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Gagal Synchronize data',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                },
                                complete: function() {
                                    $('#progress').hide();
                                }
                            });
                        }
                    }]
                });
            }

            var pembelianColumns = [{
                    data: null,
                    name: 'nomor',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'id_kegiatan_pembelian',
                    name: 'id_kegiatan_pembelian',
                    className: 'text-center'
                },
                {
                    data: 'tanggal_transaksi',
                    name: 'tanggal_transaksi',
                    className: 'text-center'
                },

                {
                    data: 'berat_bersih',
                    name: 'berat_bersih',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + ' kg';
                    }
                },
                {
                    data: 'nominal_rincian_pembelian',
                    name: 'nominal_rincian_pembelian',
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
                    <button class="btn btn-sm btn-primary lihatBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" data-id="${row.id_pembelian}"><i class="fas fa-eye"></i></button>
                `;
                    }
                }
            ];

            var penjualanColumns = [
                // Define the columns for penjualan
                // Example:
                {
                    data: null,
                    name: 'nomor',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'id_penjualan',
                    name: 'id_penjualan',
                    className: 'text-center'
                },
                {
                    data: 'berat_bersih_penjualan',
                    name: 'berat_bersih_penjualan',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + ' kg';
                    }
                },
                {
                    data: 'nominal_penjualan',
                    name: 'nominal_penjualan',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
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
                <button class="btn btn-sm btn-primary lihatBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" data-id="${row.id_penjualan}"><i class="fas fa-eye"></i></button>
            `;
                    }
                }
            ];

            var pengeluaranColumns = [
                // Define the columns for pengeluaran
                // Example:
                {
                    data: null,
                    name: 'nomor',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'id_pengeluaran',
                    name: 'id_pengeluaran',
                    className: 'text-center'
                },
                {
                    data: 'nominal_pengeluaran',
                    name: 'nominal_pengeluaran',
                    className: 'text-center',
                    render: function(data, type, row) {
                        // Format harga ke format Rupiah
                        var hargaFormatted = formatRupiah(data);
                        return hargaFormatted;
                    }
                },
                {
                    data: 'keterangan_pengeluaran',
                    name: 'keterangan_pengeluaran',
                    className: 'text-center'
                },
                {
                    data: 'tgl_pengeluaran',
                    name: 'tgl_pengeluaran',
                    className: 'text-center'
                }
            ];

            var pembelianTable = initDataTable('#datatables-ajax-pembelian',
                '{{ url('pembukuan/penjualan/list_data_detail_pembukuan_hari_periode_rincian') }}/' +
                id_pembukuan + '/' +
                id_periode + '/' + tanggal, pembelianColumns);
            var penjualanTable = initDataTable('#datatables-ajax-penjualan',
                '{{ url('pembukuan/pembelian/list_data_detail_pembukuan_hari_periode_rincian') }}/' +
                id_pembukuan + '/' +
                id_periode + '/' + tanggal, penjualanColumns);
            var pengeluaranTable = initDataTable('#datatables-ajax-pengeluaran',
                '{{ url('pembukuan/pengeluaran/list_data_detail_pembukuan_hari_periode_rincian') }}/' +
                id_pembukuan +
                '/' + id_periode + '/' + tanggal, pengeluaranColumns);
        });
        // cetak
        $(document).on('click', '.cetakBtn', function() {
            var pembukuan = $(this).data('pembukuan');
            var periode = $(this).data('periode');
            var tanggal = $(this).data('tggl');
            let iframe = document.getElementById('printIframe');
            var url = '{{ url('pembukuan/cetak_detail_rincian_pdf') }}/' + pembukuan + '/' +
                periode + '/' + tanggal;
            iframe.src = url;

            iframe.onload = function() {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            };
        });
    </script>
@endsection
