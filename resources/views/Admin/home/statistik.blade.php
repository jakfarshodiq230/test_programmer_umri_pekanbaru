@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">

                            <div class="card-actions float-end">
                                <button class="btn btn-secondary sinkronBtn">Synhronize</button>
                            </div>
                            <h4 class="card-title mb-0">Statistik Pembukan Hasil Dari Pembelian, Penjualan dan Pengeluaran
                            </h4>
                            <div id="progress" class="progress mt-3">
                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <table id="datatables-dashboard-products" class="table table-striped my-0">
                            <thead>
                                <tr>
                                    <th>Faktur</th>
                                    <th>Periode</th>
                                    <th>Jenis Pembukuan</th>
                                    <th class="d-none d-xl-table-cell">Pembelian</th>
                                    <th class="d-none d-xl-table-cell">Penjualan</th>
                                    <th class="d-none d-xl-table-cell">Pengeluaran</th>
                                    <th class="d-none d-xl-table-cell">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align:right">Total:</th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        $('#progress').hide();
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


        function formatDate(dateStr) {
            let date = new Date(dateStr);
            let options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            return date.toLocaleDateString('id-ID', options);
        }

        var table = $('#datatables-dashboard-products').DataTable({
            processing: true,
            pageLength: 6,
            lengthChange: false,
            bFilter: false,
            autoWidth: false,
            ajax: '{{ url('home/ajax_statistik') }}',
            columns: [{
                    data: 'id_pembukuan',
                    name: 'id_pembukuan',
                    className: 'text-center'
                },
                {
                    data: 'judul_periode',
                    name: 'judul_periode',
                    className: 'text-center'
                },
                {
                    data: 'jenis_pembukuan',
                    name: 'jenis_pembukuan',
                    className: 'text-center',
                    render: function(data, type, row) {
                        // Format harga ke format Rupiah
                        var hasil_pembukuan = '';
                        if (row.jenis_pembukuan === 'hari') {
                            hasil_pembukuan = '<span class="badge bg-success"> HARI</span>';
                        } else if (row.jenis_pembukuan === 'bulan') {
                            hasil_pembukuan = '<span class="badge bg-secondary">BULAN</span>';
                        } else {
                            hasil_pembukuan = '<span class="badge bg-warning">TAHUN</span>';
                        }
                        return hasil_pembukuan;
                    }
                },

                {
                    data: 'total_pembelian',
                    name: 'total_pembelian',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + ' kg';
                    }
                },
                {
                    data: 'total_penjualan',
                    name: 'total_penjualan',
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
                        var hasil_pembukuan = '';
                        if (row.pendapatan_bersih <= 0) {
                            hasil_pembukuan = '<span class="text-danger">' + hargaFormatted + '</span>';
                        } else if (row.pendapatan_bersih <= 10000000) {
                            hasil_pembukuan = '<span class="text-warning">' + hargaFormatted + '</span>';
                        } else {
                            hasil_pembukuan = '<span class="text-success">' + hargaFormatted + '</span>';
                        }
                        return hasil_pembukuan;
                    }
                }

            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[^\d.-]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Calculate totals for each column
                var pembelian = api.column(3).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                var penjualan = api.column(4).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var pengeluaran = api.column(5).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                var nominal = api.column(6).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer with formatted totals
                $(api.column(3).footer()).html(pembelian + ' kg');
                $(api.column(4).footer()).html(penjualan + ' kg');
                $(api.column(5).footer()).html(formatRupiah(pengeluaran));
                // Formatting based on conditions
                var hargaFormatted = formatRupiah(nominal);
                var hasil_pembukuan = '';
                if (nominal <= 0) {
                    hasil_pembukuan = '<span class="text-danger">' + hargaFormatted + '</span>';
                } else if (nominal <= 10000000) {
                    hasil_pembukuan = '<span class="text-warning">' + hargaFormatted + '</span>';
                } else {
                    hasil_pembukuan = '<span class="text-success">' + hargaFormatted + '</span>';
                }
                $(api.column(6).footer()).html(hasil_pembukuan);


            }

        });

        $(document).on('click', '.sinkronBtn', function() {
            $('#progress').show();
            $.ajax({
                url: '{{ url('home/ajax_statistik') }}',
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
        });
    </script>
@endsection
