@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">

            <div class="header">
                <h1 class="header-title">
                    Selamat Datang Di APKIS, {{ ucwords(Auth::User()->nama_user) }} !
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
                                    <h5 class="card-title">Pelanggan Aktif</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="avatar">
                                        <div class="avatar-title rounded-circle bg-success-dark">
                                            <i class="align-middle" data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h1 class="display-5 mt-1 mb-3">
                                {{ $PelangganAktif }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Pelanggan Tidak Aktif</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="avatar">
                                        <div class="avatar-title rounded-circle bg-danger-dark">
                                            <i class="align-middle" data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h1 class="display-5 mt-1 mb-3">
                                {{ $PelangganAktif }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">User Aktif</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="avatar">
                                        <div class="avatar-title rounded-circle bg-info-dark">
                                            <i class="align-middle" data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h1 class="display-5 mt-1 mb-3">
                                {{ $UserAktif }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xl">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">User Tidak Aktif</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="avatar">
                                        <div class="avatar-title rounded-circle bg-primary-dark">
                                            <i class="align-middle" data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h1 class="display-5 mt-1 mb-3">{{ $UserTidakAktif }}</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <button class="btn btn-primary deleteBtn" id="deleteBtn" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Menghapus seluruh data pengunjung" data-confirm-delete="true"><i
                                        class="fas fa-trash" style="color: white;"></i></button>
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <div id="progress" class="progress mt-0 mb-4">
                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>IP Address</th>
                                        <th>Browser</th>
                                        <th>Platform</th>
                                        <th>Negara</th>
                                        <th>Waktu</th>
                                        <th>Nama</th>
                                        <th>Usaha</th>
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
        $('#progress').hide();
        $('#datatables-ajax').DataTable({
            processing: true,
            serverSide: false,
            retrieve: false,
            destroy: true,
            responsive: true,
            ajax: '{{ url('home/data_akses_pengguna') }}',
            columns: [{
                    data: null,
                    name: 'nomor',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'ip_address',
                    name: 'ip_address',
                },
                {
                    data: 'browser',
                    name: 'browser',
                },
                {
                    data: 'platform',
                    name: 'platform',
                    render: function(data, type, row) {
                        return row.platform + ' V. ' + row
                            .device;
                    }
                },
                {
                    data: 'negara',
                    name: 'negara',
                },
                {
                    data: 'waktu',
                    name: 'waktu',

                },
                {
                    data: 'nama_user',
                    name: 'nama_user',
                },
                {
                    data: 'nama_pelanggan',
                    name: 'nama_pelanggan',
                },
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
                        url: '{{ url('pelanggan/data_pelanggan') }}',
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
        });
        $(document).on('click', '.deleteBtn', function() {
                // Make an Ajax call to delete the record
            Swal.fire({
                title: 'Hapus Data',
                text: 'Apakah Anda Ingin Menghapus Data Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya menghapus data ini'
            }).then((result) => {
                $.ajax({
                    url: '{{ url('home/hapus_akses_pengguna') }}', // URL to delete data for the selected row
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Reload the table data
                        Swal.fire({
                            title: 'Success!',
                            text: response.massage,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $('#datatables-ajax').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'gagal Hapus',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection
