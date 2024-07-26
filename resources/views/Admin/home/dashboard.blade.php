@extends('Admin.layout')
@section('content')
<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
                Selamat Datang {{ ucfirst(strtolower(session('user')['nama_user'])) }},  Di MY TAHFIDZ.
            </h1>
            <p class="header-subtitle">MY TAHFIDZ merupakan sistem informasi dan manajemen Tahsin, Tahfidz dan Sertifikasi Al-Qur'an.</p>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Peserta</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="peserta">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Guru</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="guru">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Tahsin</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="tahsin">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Tahfidz</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="tahfidz">0</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Sertifikasi</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="sertifikasi">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Periode</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="periode">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Tahun Ajaran</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="activity"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="tahun_ajaran">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Kelas</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="home"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="kelas">0</h1>
                    </div>
                </div>
            </div>
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
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $.ajax({
            url: '{{ url('admin/dashboard/data_home_default') }}',
            type: 'GET',
            success: function(response) {
                console.log(response);
                // Populate the modal fields with the data
                $('#peserta').text(response.peserta);
                $('#guru').text(response.guru);
                $('#tahsin').text(response.tahsin);
                $('#tahfidz').text(response.tahfidz);
                $('#sertifikasi').text(response.sertifikasi);
                $('#periode').text(response.periode);
                $('#tahun_ajaran').text(response.tahun);
                $('#kelas').text(response.kelas);
            },
            error: function(response) {
                alert('error request');
            }
        });
    });
    $(document).ready(function() {
    // Initialize DataTable
        $('#datatables-ajax').DataTable({
            processing: true,
            serverSide: false, // Change this to true if using server-side processing
            retrieve: true,
            destroy: true,
            responsive: true,
            ajax: {
                url: '{{ url('admin/dashboard/data_home_default') }}',
                dataSrc: 'PresentaseSetoran',
            },
            columns: [
                {
                    data: 'nama_tahun_ajaran',
                    title: 'Periode',
                    render: function(data, type, row, meta) {
                        var judulPeriode = row.judul_periode.toUpperCase(); 
                        var jenisPeriode = row.jenis_periode.toUpperCase();
                        var namaTahunAjaran = row.nama_tahun_ajaran;

                        // Return formatted string based on the value of judul_periode
                        return row.judul_periode === 'setoran' ? jenisPeriode + ' [ ' + namaTahunAjaran + ' ]' : judulPeriode + ' ' + row.juz_periode + ' [ ' + namaTahunAjaran + ' ' + jenisPeriode + ' ]';
                    }
                },
                {
                    data: null,
                    title: 'Peserta',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        var percentage = 0;
                        if (row.judul_periode === 'sertifikasi') {
                            percentage = row.jumlah_siswa_sertifikasi;
                        } else if (row.judul_periode === "setoran") {
                            percentage = row.jumlah_siswa_setoran ;
                        }

                        return percentage;
                    }
                },
                {
                    data: null,
                    title: '% Peserta',
                    className: 'd-none d-xl-table-cell w-75',
                    render: function(data, type, row, meta) {
                        var percentage = 0;
                        var total = 100; 
                        if (row.judul_periode === 'sertifikasi') {
                            percentage = (row.jumlah_siswa_sertifikasi / total) * 100;
                        } else if (row.judul_periode === "setoran") {
                            percentage = (row.jumlah_siswa_setoran / total) * 100;
                        }

                        return '<div class="progress">' +
                            '<div class="progress-bar bg-primary-dark" role="progressbar" style="width: ' + percentage + '%;" aria-valuenow="' + percentage + '"' +
                            ' aria-valuemin="0" aria-valuemax="100">' + Math.round(percentage) + '%</div>' +
                            '</div>';
                    }
                }
            ]
        });
    });

</script>
@endsection

