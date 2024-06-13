@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">

            <div class="header">
                <h1 class="header-title">
                    Selamat Datang Di APKIS, {{ Auth::User()->nama_user }} !
                </h1>
                <p class="header-subtitle">APKIS merupakan sistem manajemen pembukuan sederhana dalam melakukan pembelian
                    atau penjualan hasil panen sawit</p>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3 col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Pengeluaran</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="avatar">
                                        <div class="avatar-title rounded-circle bg-primary-dark">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h1 class="display-5 mt-1 mb-3">
                                {{ 'Rp ' . number_format($Pengeluaran->total_pengeluaran, 0, ',', '.') }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Penjualan</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="avatar">
                                        <div class="avatar-title rounded-circle bg-primary-dark">
                                            <i class="align-middle" data-feather="shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h1 class="display-5 mt-1 mb-3">
                                {{ 'Rp ' . number_format($Penjualan->total_penjualan, 0, ',', '.') }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Pembelian</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="avatar">
                                        <div class="avatar-title rounded-circle bg-primary-dark">
                                            <i class="align-middle" data-feather="activity"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h1 class="display-5 mt-1 mb-3">
                                {{ 'Rp ' . number_format($Pembelian->total_pembelian, 0, ',', '.') }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Pendapatan</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="avatar">
                                        <div class="avatar-title rounded-circle bg-primary-dark">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $total_keuntungan = $Penjualan->total_penjualan - $Pembelian->total_pembelian;
                                $pendapatan = $total_keuntungan - $Pengeluaran->total_pengeluaran;
                            @endphp
                            <h1 class="display-5 mt-1 mb-3">{{ 'Rp ' . number_format($pendapatan, 0, ',', '.') }}</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <a href="{{ url('home') }}" class="me-1">
                                    <i class="align-middle" data-feather="refresh-cw"></i>
                                </a>
                            </div>
                            <h5 class="card-title mb-0">Pembelian Hari Ini</h5>
                        </div>
                        <table id="datatables-dashboard-products" class="table table-striped my-0">
                            <thead>
                                <tr>
                                    <th>Faktur</th>
                                    <th>Berta Normal</th>
                                    <th class="d-none d-xl-table-cell">Berat Potong</th>
                                    <th class="d-none d-xl-table-cell">Berat Bersih</th>
                                    <th class="d-none d-xl-table-cell">Harga</th>
                                    <th class="d-none d-xl-table-cell">Nominal</th>
                                    <th>Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align:right">Total:</th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th></th>
                                    <th class="text-center"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <a href="{{ url('home') }}" class="me-1">
                                    <i class="align-middle" data-feather="refresh-cw"></i>
                                </a>
                            </div>
                            <h5 class="card-title mb-0">Penjulan Hari Ini</h5>
                        </div>
                        <table id="datatables-dashboard-products2" class="table table-striped my-0">
                            <thead>
                                <tr>
                                    <th>Faktur</th>
                                    <th>Berta Normal</th>
                                    <th class="d-none d-xl-table-cell">Berat Potong</th>
                                    <th class="d-none d-xl-table-cell">Berat Bersih</th>
                                    <th class="d-none d-xl-table-cell">Harga</th>
                                    <th class="d-none d-xl-table-cell">Nominal</th>
                                    <th>Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align:right">Total:</th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th></th>
                                    <th class="text-center"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <a href="{{ url('home') }}" class="me-1">
                                    <i class="align-middle" data-feather="refresh-cw"></i>
                                </a>
                            </div>
                            <h5 class="card-title mb-0">Pengeluaran Hari Ini</h5>
                        </div>
                        <table id="datatables-dashboard-products3" class="table table-striped my-0">
                            <thead>
                                <tr>
                                    <th>Rincian</th>
                                    <th class="d-none d-xl-table-cell">Nominal</th>
                                    <th>Petugas</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align:right">Total:</th>
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

        $('#datatables-dashboard-products').DataTable({
            pageLength: 6,
            lengthChange: false,
            bFilter: false,
            autoWidth: false,
            ajax: '{{ url('home/pembelian') }}',
            columns: [{
                    data: 'id_kegiatan_pembelian',
                    name: 'id_kegiatan_pembelian',
                    className: 'text-center'
                },

                {
                    data: 'berat_normal',
                    name: 'berat_normal',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + ' kg';
                    }
                },
                {
                    data: 'berat_potong',
                    name: 'berat_potong',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + ' kg';
                    }
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
                    data: 'harga',
                    name: 'harga',
                    className: 'text-center',
                    render: function(data, type, row) {
                        // Format harga ke format Rupiah
                        var hargaFormatted = formatRupiah(data);
                        return hargaFormatted;
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
                    data: 'nama_user',
                    name: 'nama_user',
                    className: 'text-center'
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
                var beratNormalTotal = api.column(1).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var beratPotongTotal = api.column(2).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var beratBersihTotal = api.column(3).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var nominalRincianPembelianTotal = api.column(5).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer with formatted totals
                $(api.column(1).footer()).html(beratNormalTotal + ' kg');
                $(api.column(2).footer()).html(beratPotongTotal + ' kg');
                $(api.column(3).footer()).html(beratBersihTotal + ' kg');
                $(api.column(5).footer()).html(formatRupiah(nominalRincianPembelianTotal));
            }
        });
        $('#datatables-dashboard-products2').DataTable({
            pageLength: 6,
            lengthChange: false,
            bFilter: false,
            autoWidth: false,
            ajax: '{{ url('home/penjualan') }}',
            columns: [{
                    data: 'id_penjualan',
                    name: 'id_penjualan',
                    className: 'text-center'
                },
                {
                    data: 'berat_normal',
                    name: 'berat_normal',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + ' kg';
                    }
                },
                {
                    data: 'berat_potongan',
                    name: 'berat_potongan',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return data + ' kg';
                    }
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
                    data: 'harga_jual',
                    name: 'harga_jual',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        // Format harga ke format Rupiah
                        var hargaFormatted = formatRupiah(data);
                        return hargaFormatted;
                    }
                },
                {
                    data: 'nominal_rincian_penjualan',
                    name: 'nominal_rincian_penjualan',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        // Format harga ke format Rupiah
                        var hargaFormatted = formatRupiah(data);
                        return hargaFormatted;
                    }
                },
                {
                    data: 'nama_user',
                    name: 'nama_user',
                    className: 'text-center'
                }

            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[^\d]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Calculate totals for each column
                var beratNormalTotal = api.column(1).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var beratPotonganTotal = api.column(2).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var beratBersihTotal = api.column(3).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var nominalRincianPenjualanTotal = api.column(5).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer with formatted totals
                $(api.column(1).footer()).html(beratNormalTotal + ' kg');
                $(api.column(2).footer()).html(beratPotonganTotal + ' kg');
                $(api.column(3).footer()).html(beratBersihTotal + ' kg');
                $(api.column(5).footer()).html(formatRupiah(nominalRincianPenjualanTotal));
            }
        });
        $('#datatables-dashboard-products3').DataTable({
            pageLength: 6,
            lengthChange: false,
            bFilter: false,
            autoWidth: false,
            ajax: '{{ url('home/pengeluaran') }}',
            columns: [{
                    data: 'keterangan_pengeluaran',
                    name: 'keterangan_pengeluaran',
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
                    data: 'nama_user',
                    name: 'nama_user',
                    className: 'text-center'
                }

            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\Rp,.]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(1)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(1, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(1).footer()).html(
                    formatRupiah(pageTotal)
                );
            }
        });
    </script>
@endsection
