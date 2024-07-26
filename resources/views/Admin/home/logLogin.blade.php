@extends('Admin.layout')
@section('content')
<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
                Aktifitas User Login
            </h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-xxl-4 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Periode</h5>
                    </div>
                    <div class="card-body">
                        <table id="datatables-ajax" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th class="text-end">Peserta</th>
                                    <th class="d-none d-xl-table-cell w-75">% Peserta</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-xxl-4 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0" id="ip_login">User IP</h5>
                    </div>
                    <div class="card-body">
                        <table id="datatables-ajax-all" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">IP</th>
                                    <th class="text-center">Negara</th>
                                    <th class="text-center">Browser</th>
                                    <th class="text-center">Platform</th>
                                    <th class="text-center">Device</th>
                                    <th class="text-center">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
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
    $(document).ready(function() {
        var now = new Date();
        var options = { month: 'long', year: 'numeric' };
        var bulan = now.toLocaleDateString('id-ID', options);

        $('#ip_login').text('User Identitas Login Bulan ' +bulan);
        $('#datatables-ajax').DataTable({
            processing: true,
            serverSide: false, // Change this to true if using server-side processing
            retrieve: true,
            destroy: true,
            responsive: true,
            ajax: {
                url: '{{ url('admin/dashboard/data_home_log') }}',
                dataSrc: 'Persentase',
            },
            columns: [
                {
                    data: 'bulan',
                    title: 'Periode',
                    render: function(data, type, row, meta) {
                        var currentYear = new Date().getFullYear(); // Get the current year
                        var bulan_db = new Date(currentYear, (row.bulan-1)); // June is month index 5 (0-based)

                        const options2 = { 
                            month: 'long', 
                        };
                        var bulan = bulan_db.toLocaleDateString('id-ID', options2);
                        var tahun = row.tahun;
                        return bulan+ ' ' + tahun; 
                    }

                },
                {
                    data: null,
                    title: 'Akses',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        var percentage = row.jumlah_log ;
                        return percentage;
                    }
                },
                {
                    data: null,
                    title: '% Akses',
                    className: 'd-none d-xl-table-cell w-75',
                    render: function(data, type, row, meta) {
                        var percentage = 0;
                        var total = 100; 
                        percentage = (row.jumlah_log / total);

                        return '<div class="progress">' +
                            '<div class="progress-bar bg-primary-dark" role="progressbar" style="width: ' + percentage + '%;" aria-valuenow="' + percentage + '"' +
                            ' aria-valuemin="0" aria-valuemax="100">' + percentage+ '%</div>' +
                            '</div>';
                    }
                }
            ]
        });

        $('#datatables-ajax-all').DataTable({
            processing: true,
            serverSide: false, // Change this to true if using server-side processing
            retrieve: true,
            destroy: true,
            responsive: true,
            ajax: {
                url: '{{ url('admin/dashboard/data_home_log') }}',
                dataSrc: 'Log',
            },
            columns: [
                {
                    data: 'ip_address',
                    title: 'IP Address',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return row.ip_address; 
                    }

                },
                {
                    data: 'negara',
                    title: 'Negara',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return row.negara;
                    }
                },
                {
                    data: 'browser',
                    title: 'Browser',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return row.browser;
                    }
                },
                {
                    data: 'platform',
                    title: 'Platform',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return row.platform;
                    }
                },
                {
                    data: 'device',
                    title: 'Device',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return row.device;
                    }
                },
                {
                    data: 'created_at',
                    title: 'Waktu',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        var tanggal_akhir = new Date(row.created_at);                            
                        const options2 = { 
                            day: 'numeric', 
                            month: 'long', 
                            year: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric',
                            hour12: false // Use 24-hour format; set to true for 12-hour format
                        };
                        var tanggal_formatted = tanggal_akhir.toLocaleDateString('id-ID', options2);
                        return tanggal_formatted;
                    }
                }
            ]
        });
    });

</script>
@endsection

