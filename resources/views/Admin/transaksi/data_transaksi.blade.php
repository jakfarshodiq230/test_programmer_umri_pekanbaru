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
                    Data Transaksi
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div id="progress" class="progress">
                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 col-lg-12">
                                <div class="tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab"
                                                role="tab">PEMBELIAN</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#tab-2" data-bs-toggle="tab"
                                                role="tab">PENJUALAN</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#tab-3" data-bs-toggle="tab"
                                                role="tab">PENGELUARAN</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-1" role="tabpanel">
                                            <div class="card-body" id="formInput">
                                                <table id="datatables-ajax-pembelian" class="table table-striped"
                                                    style="width:100%">
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
                                                <table id="datatables-ajax-penjualan" class="table table-striped"
                                                    style="width:100%">
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
                                                <table id="datatables-ajax-pengeluaran" class="table table-striped"
                                                    style="width:100%">
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

                                        {{-- show pembelian --}}
                                        <div class="modal fade" id="formModal" tabindex="-1" role="dialog"
                                            aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ModalLabel">Edit Harga</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body m-3">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="text-muted">No. Faktur</div>
                                                                    <strong id="nomor_faktur">-</strong>
                                                                </div>
                                                                <div class="col-md-6 text-md-end">
                                                                    <div class="text-muted">Tanggal Pembelian</div>
                                                                    <strong id="tggl_faktur">-</strong>
                                                                </div>
                                                            </div>

                                                            <hr class="my-4" />
                                                            <table class="table table-sm" id="tabel_rincian">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Harga</th>
                                                                        <th>Berat Normal</th>
                                                                        <th>Berat Potongan</th>
                                                                        <th>Berat Bersih</th>
                                                                        <th class="text-end">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" id="btnCetak">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end show pembelian --}}

                                        {{-- show pembelian --}}
                                        <div class="modal fade" id="formModal2" tabindex="-1" role="dialog"
                                            aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ModalLabel2">Edit Harga</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body m-3">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="text-muted">No. Faktur</div>
                                                                    <strong id="nomor_faktur2">-</strong>
                                                                </div>
                                                                <div class="col-md-6 text-md-end">
                                                                    <div class="text-muted">Tanggal Input Penjualan</div>
                                                                    <strong id="tggl_faktur2">-</strong>
                                                                </div>
                                                            </div>

                                                            <hr class="my-4" />
                                                            <table class="table table-sm" id="tabel_rincian2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Harga Terima</th>
                                                                        <th>Berat Normal</th>
                                                                        <th>Berat Potongan</th>
                                                                        <th>Berat Bersih</th>
                                                                        <th>Keterangan</th>
                                                                        <th>Tanggal</th>
                                                                        <th class="text-end">Hasil</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" id="btnCetak2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end show pembelian --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <iframe id="printIframe" style="display: none;"></iframe>
@endsection
@section('scripts')
    <!-- Your other content -->

    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    <script>
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


        function formatDate(dateStr) {
            let date = new Date(dateStr);
            let options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            return date.toLocaleDateString('id-ID', options);
        }
        $(document).ready(function() {
            // menampilkan data

            $('#progress').hide();

            // datatable pembelian
            $('#datatables-ajax-pembelian').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('transaksi/data_transaksi') }}',
                columns: [{
                        data: null,
                        name: 'nomor',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'id_pembelian',
                        name: 'id_pembelian',
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
                        data: 'nominal_pembelian',
                        name: 'nominal_pembelian',
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

                ],
                // button costum + progres bar
                dom: 'Bfrtip',
                buttons: [{
                    text: 'Synchronize',
                    className: 'btn btn-primary synchronize-btn',
                    action: function(e, dt, node, config) {
                        // Show progress bar
                        $('#progress').show();

                        $.ajax({
                            url: '{{ url('transaksi/data_transaksi') }}',
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

            // datatable penjualan
            $('#datatables-ajax-penjualan').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                ajax: '{{ url('transaksi/data_transaksi_penjualan') }}',
                columns: [{
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
                                <button class="btn btn-sm btn-primary lihatBtn2" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" data-id="${row.id_penjualan}"><i class="fas fa-eye"></i></button>
                            `;
                        }
                    }

                ],
                // button costum + progres bar
                dom: 'Bfrtip',
                buttons: [{
                    text: 'Synchronize',
                    className: 'btn btn-primary synchronize-btn',
                    action: function(e, dt, node, config) {
                        // Show progress bar
                        $('#progress').show();

                        $.ajax({
                            url: '{{ url('transaksi/data_transaksi_penjualan') }}',
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
            // end datatable penjualan

            // // datatable pengeluaran
            $('#datatables-ajax-pengeluaran').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                ajax: '{{ url('transaksi/data_transaksi_Pengeluaran') }}',
                columns: [{
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

                ],
                // button costum + progres bar
                dom: 'Bfrtip',
                buttons: [{
                    text: 'Synchronize',
                    className: 'btn btn-primary synchronize-btn',
                    action: function(e, dt, node, config) {
                        // Show progress bar
                        $('#progress').show();

                        $.ajax({
                            url: '{{ url('transaksi/data_transaksi_Pengeluaran') }}',
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
            // // end datatable pengeluaran
        });

        // pembelian faktur
        $(document).on('click', '.lihatBtn', function() {
            var id = $(this).data('id');
            $('#ModalLabel').text('Detail Pembelian');
            $('#formModal').modal('show');
            $.ajax({
                url: '{{ url('transaksi/data_rincian_pembelian') }}/' + id,
                type: 'GET',
                success: function(response) {
                    $('#nomor_faktur').text(response.data[0]['id_pembelian']);
                    $('#tggl_faktur').text(response.data[0]['tgl_pembelian']);
                    let tbody = $('#tabel_rincian tbody');
                    tbody.empty(); // Clear existing rows

                    let totalAmount = 0;
                    let TotalCount = 0;

                    // Append each row from the response
                    response.data.forEach(function(item, index) {
                        TotalCount = item.harga_beli * item.berat_bersih;
                        let row = `<tr>
                            <th>${index + 1}</th>
                            <td>${formatRupiah(item.harga_beli)}</td>
                            <td>${item.berat_normal+' Kg'}</td>
                            <td>${item.berat_potong+ ' Kg'}</td>
                            <td>${item.berat_bersih+ ' Kg'}</td>
                            <td class="text-end">${formatRupiah(TotalCount)}</td>
                        </tr>`;
                        tbody.append(row);
                        totalAmount += parseFloat(TotalCount); // Calculate total amount
                    });

                    // Append the total row
                    let totalRow = `<tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>Total</th>
                        <th class="text-end">${formatRupiah(totalAmount)}</th>
                    </tr>`;
                    tbody.append(totalRow);
                    // Append the "Cetak" button to the modal footer
                    let modalFooter = $('#btnCetak');
                    modalFooter.empty(); // Clear existing buttons
                    let cetakButton = $('<button class="btn btn-primary">Cetak</button>');
                    var lin_cetak = '{{ url('transaksi/cetak_rincian_pembelian') }}/' + response.data[0]
                        ['id_pembelian'];
                    cetakButton.on('click', function() {
                        //window.open(lin_cetak, '_blank');
                        let iframe = document.getElementById('printIframe');
                        iframe.src = lin_cetak;

                        iframe.onload = function() {
                            iframe.contentWindow.focus();
                            iframe.contentWindow.print();
                        };
                    });
                    modalFooter.append(cetakButton);
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // penjualan faktur
        $(document).on('click', '.lihatBtn2', function() {
            var id = $(this).data('id');
            $('#ModalLabel2').text('Detail Penjualan');
            $('#formModal2').modal('show');
            $.ajax({
                url: '{{ url('transaksi/data_rincian_penjualan') }}/' + id,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#nomor_faktur2').text(response.data[0]['id_penjualan']);
                    $('#tggl_faktur2').text(response.data[0]['tggl_penjualan']);
                    let tbody = $('#tabel_rincian2 tbody');
                    tbody.empty(); // Clear existing rows

                    let totalAmount = 0;
                    let TotalCount = 0;

                    // Append each row from the response
                    response.data.forEach(function(item, index) {
                        TotalCount = item.harga_jual * item.berat_bersih;
                        let row = `<tr>
                            <th>${index + 1}</th>
                            <td>${formatRupiah(item.harga_jual)}</td>
                            <td>${item.berat_normal+' Kg'}</td>
                            <td>${item.berat_potongan+ ' Kg'}</td>
                            <td>${item.berat_bersih+ ' Kg'}</td>
                            <td>${item.keterangan_penjualan+ ' Kg'}</td>
                            <td>${formatDate(item.tggl_rincian_penjualan)}</td>
                            <td class="text-end">${formatRupiah(TotalCount)}</td>
                        </tr>`;
                        tbody.append(row);
                        totalAmount += parseFloat(TotalCount); // Calculate total amount
                    });

                    // Append the total row
                    let totalRow = `<tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>Total</th>
                        <th class="text-end">${formatRupiah(totalAmount)}</th>
                    </tr>`;
                    tbody.append(totalRow);
                    let modalFooter = $('#btnCetak2');
                    modalFooter.empty(); // Clear existing buttons
                    let cetakButton = $('<button class="btn btn-primary">Cetak</button>');
                    var lin_cetak = '{{ url('transaksi/cetak_rincian_penjualan') }}/' + response.data[
                            0]
                        ['id_penjualan'];
                    cetakButton.on('click', function() {
                        //window.open(lin_cetak, '_blank');
                        let iframe = document.getElementById('printIframe');
                        iframe.src = lin_cetak;

                        iframe.onload = function() {
                            iframe.contentWindow.focus();
                            iframe.contentWindow.print();
                        };
                    });
                    modalFooter.append(cetakButton);
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
@endsection
