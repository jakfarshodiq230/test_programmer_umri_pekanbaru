@extends('Admin.layout')
@section('content')
    <style>
        .border-navy {
            border: 2px solid navy;
            /* Adjust the border width as needed */
            border-radius: 5px;
            /* Optional: Adjust the border radius as needed */
        }
    </style>
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data Rekap Pembayaran
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card">
                                <div class="card-body border-navy">
                                    <form class="row row-cols-md-auto align-items-center" id="dataForm"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12">
                                            <div class="input-group mb-2 me-sm-2">
                                                <div class="input-group-text">Mulai</div>
                                                <input type="date" name="tanggal_awal" id="tanggal_awal"
                                                    class="form-control " placeholder="tanggal_awal" >
                                            </div>                                            
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group mb-2 me-sm-2">
                                                <div class="input-group-text">Akhir</div>
                                                <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                                                class="form-control " placeholder="tanggal_akhir" >
                                                </div>     
                                        </div>
                                        <div class="col-12">
                                            <button type="button" id="BtnCari"
                                                class="btn btn-primary mb-2 me-sm-2">Prosess</button>
                                            <button type="button" id="BtnExcel"
                                                class="btn btn-success mb-2 me-sm-2">Download Excel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Pembayaran</th>
                                        <th>Jumlah Bayar</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Pembayaran</th>
                                        <th>Jumlah Bayar</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
<script>
    $('#BtnExcel').prop('disabled', true);
    function cekInputKosong() {
        var inputValue = $('.form-control').val();
        if (inputValue.trim() === '') {
            $('#BtnCari').prop('disabled', true);
        } else {
            $('#BtnCari').prop('disabled', false);
        }
    }
    $('.form-control').on('input', cekInputKosong);
    $(document).ready(cekInputKosong);



    $(document).on('click', '#BtnCari', function() {
        var TanggalAwal = $('#tanggal_awal').val();
        var TanggalAkhir = $('#tanggal_akhir').val();
        $('#datatables-ajax').DataTable({
            processing: true,
            serverSide: false,
            retrieve: false,
            destroy: true,
            responsive: true,
            ajax: {
                url: '{{ url('admin/rekap/data_bayar') }}/' + TanggalAwal +'/'+ TanggalAkhir,
                dataSrc: function(json) {
                    if (json.data.length > 0) {
                        $('#BtnExcel').prop('disabled', false);
                    } else {
                        $('#BtnExcel').prop('disabled', true);
                    }
                    return json.data;
                }
            },
            columns: [
                {
                    data: null,
                    name: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'nim_mhs',
                    name: 'nim_mhs',
                },
                {
                    data: 'nama_mhs',
                    name: 'nama_mhs',
                    render: function(data, type, row) {
                        var nama_mahasiswa = row.nama_mhs.charAt(0)
                            .toUpperCase() + row.nama_mhs.slice(1);
                        return nama_mahasiswa;
                    }
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                    render: function(data, type, row) {
                        var tanggal = new Date(row.tanggal);
                        
                        // Define options for date and time formatting
                        var dayOptions = { day: '2-digit' };
                        var monthOptions = { month: 'long' };
                        var yearOptions = { year: 'numeric' };
                        var timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

                        // Format day, month, year, and time
                        var day = tanggal.toLocaleDateString('id-ID', dayOptions);
                        var month = tanggal.toLocaleDateString('id-ID', monthOptions);
                        var year = tanggal.toLocaleDateString('id-ID', yearOptions);
                        var time = tanggal.toLocaleTimeString('id-ID', timeOptions);
                        
                        // Combine formatted parts into the desired format
                        var tanggal_formatted = `${day} ${month} ${year} ${time}`;
                        
                        // Return formatted string
                        return tanggal_formatted;
                    }
                },
                {
                    data: 'nama_pembayaran',
                    name: 'nama_pembayaran',
                    render: function(data, type, row) {
                        var nama_pembayaran = row.nama_pembayaran.charAt(0)
                            .toUpperCase() + row.nama_pembayaran.slice(1);

                        // Return formatted string
                        return nama_pembayaran;
                    }
                },
                {
                    data: 'jumlah',
                    name: 'jumlah',
                    render: function(data, type, row, meta) {
                        if (type === 'display' || type === 'filter') {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0,
                            }).format(data);
                        }
                        return data;
                    }
                },
            ]
        });
    });

    $(document).on('click', '#BtnExcel', function() {
        var TanggalAwal = $('#tanggal_awal').val();
        var TanggalAkhir = $('#tanggal_akhir').val();
        var url= '{{ url('admin/rekap/download_excel') }}/' + TanggalAwal +'/'+ TanggalAkhir;
            window.location.href = url;
    });

</script>
@endsection