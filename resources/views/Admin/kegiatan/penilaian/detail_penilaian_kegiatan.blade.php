@extends('Admin.layout')
@section('content')
    <style>
        .border-navy {
            border: 2px solid navy;
            /* Adjust the border width as needed */
            border-radius: 5px;
            /* Optional: Adjust the border radius as needed */
        }

        .profile {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-item {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 10px;
        }

        .profile-item span.label {
            font-weight: bold;
            margin-right: 10px;
        }

        .profile-item span.separator {
            margin-right: 10px;
        }

        .profile-item span.value {
            margin-left: 10px;
        }
    </style>
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title" id="judul_header">
                    Data Penialian Kegiatan {{ $judul_3 }}
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body ">
                            <form>
                                <div class="row border-navy">
                                    <div class="col-md-4 profile">
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Tahun Ajaran</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="tahun_ajaran" style="flex: 1;">Andi</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Kegiatan</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="kegiatan" style="flex: 1;">Andi</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Pembimbing</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="pembimbing" style="flex: 1;">Andi</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 profile">
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Nama</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="nama" style="flex: 1;">Andi</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Kelas</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="kelas" style="flex: 1;">Andi</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 profile">
                                        <div class="text-center">
                                            <img alt="Peserta" id="avatarImg" src=""
                                                class="rounded-circle img-responsive" width="100" height="100" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- tahfidz --}}
                    <div class="card" id="tahfidz">
                        <div class="card-body">
                            <table id="datatables-ajax-tahfidz" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Surah</th>
                                        <th>Tajwid</th>
                                        <th>Fasohah</th>
                                        <th>Kelancaran</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Surah</th>
                                        <th>Tajwid</th>
                                        <th>Fasohah</th>
                                        <th>Kelancaran</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                    {{-- tahsin --}}
                    <div class="card" id="tahsin">
                        <div class="card-body">
                            <table id="datatables-ajax-tahsin" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Surah</th>
                                        <th>Kelancaran</th>
                                        <th>Ghunnah</th>
                                        <th>Mad</th>
                                        <th>Waqof</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Surah</th>
                                        <th>Kelancaran</th>
                                        <th>Ghunnah</th>
                                        <th>Mad</th>
                                        <th>Waqof</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
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
    <!-- Your other content -->
    <script>
        var id_tahun = "{{ $tahun }}";
        var id_periode = "{{ $periode }}";
        var id_siswa = "{{ $siswa }}";
        var id_guru = "{{ $guru }}";
        var id_kelas = "{{ $kelas }}";
        var kegiatan = "{{ $kegiatan }}";
        // profil
        $.ajax({
            url: "{{ url('penilaian_kegiatan/data_penilaian_kegiatan_all') }}/" +
                id_tahun + "/" +
                id_periode + "/" +
                id_siswa + "/" +
                id_guru + "/" +
                id_kelas,
            type: 'GET',
            success: function(data) {
                // Populate the modal fields with the data
                console.log(data);
                $('#tahun_ajaran').text(capitalizeFirstLetter(data.siswa.nama_tahun_ajaran));
                $('#kegiatan').text(capitalizeFirstLetter(data.siswa.jenis_periode));
                $('#pembimbing').text(capitalizeFirstLetter(data.siswa.nama_guru));
                $('#nama').text(capitalizeFirstLetter(data.siswa.nama_siswa));
                $('#kelas').text(data.siswa.nama_kelas);
                if (data.siswa.foto_siswa != null) {
                    var fotoSiswaUrl = "{{ url('storage') }}/" + data.siswa.foto_siswa;
                    $('#avatarImg').attr('src', fotoSiswaUrl);
                } else {
                    var fotoSiswaUrl = '{{ asset('assets/admin/img/avatars/avatar.jpg') }}'
                    $('#avatarImg').attr('src', fotoSiswaUrl);
                }

                function capitalizeFirstLetter(string) {
                    return string.charAt(0).toUpperCase() + string.slice(1);
                }

            },
            error: function(response) {
                Swal.fire({
                    title: response.success ? 'Success' : 'Error',
                    text: response.message,
                    icon: response.success ? 'success' : 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
        $('#tahfidz').hide();
        $('#tahsin').hide();
        $(document).ready(function() {

            if (kegiatan === 'tahfidz') {
                $('#tahfidz').show();
                $('#datatables-ajax-tahfidz').DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: "{{ url('penilaian_kegiatan/data_penilaian_kegiatan_all') }}/" +
                            id_tahun + "/" +
                            id_periode + "/" +
                            id_siswa + "/" +
                            id_guru + "/" +
                            id_kelas,
                        dataSrc: 'nilai' // Specify the data source as 'nilai'
                    },

                    columns: [{
                            "data": null,
                            "name": "rowNumber",
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'surah_penilaian_kegiatan',
                            name: 'surah_penilaian_kegiatan'
                        },
                        {
                            data: 'nilai_tajwid_penilaian_kegiatan',
                            name: 'nilai_tajwid_penilaian_kegiatan'
                        },
                        {
                            data: 'nilai_fasohah_penilaian_kegiatan',
                            name: 'nilai_fasohah_penilaian_kegiatan'
                        },
                        {
                            data: 'nilai_kelancaran_penilaian_kegiatan',
                            name: 'nilai_kelancaran_penilaian_kegiatan'
                        },
                        {
                            data: 'keterangan_penilaian_kegiatan',
                            name: 'keterangan_penilaian_kegiatan'
                        },
                        {
                            data: 'status_peserta_kegiatan',
                            name: 'status_peserta_kegiatan',
                            render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-info detalBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" 
                                    data-id_penialain="${row.id_penialain_kegiatan}">
                                    <i class="fas fa-eye"></i></button>
                                    `;
                            }
                        }
                    ]
                });
            } else {
                $('#tahsin').show();
                $('#datatables-ajax-tahsin').DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: "{{ url('penilaian_kegiatan/data_penilaian_kegiatan_all') }}/" +
                            id_tahun + "/" +
                            id_periode + "/" +
                            id_siswa + "/" +
                            id_guru + "/" +
                            id_kelas,
                        dataSrc: 'nilai' // Specify the data source as 'nilai'
                    },

                    columns: [{
                            "data": null,
                            "name": "rowNumber",
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'surah_penilaian_kegiatan',
                            name: 'surah_penilaian_kegiatan'
                        },
                        {
                            data: 'nilai_kelancaran_penilaian_kegiatan',
                            name: 'nilai_kelancaran_penilaian_kegiatan'
                        },
                        {
                            data: 'nilai_ghunnah_penilaian_kegiatan',
                            name: 'nilai_ghunnah_penilaian_kegiatan'
                        },
                        {
                            data: 'nilai_mad_penilaian_tahsin',
                            name: 'nilai_mad_penilaian_tahsin'
                        },
                        {
                            data: 'nilai_waqof_penilaian_tahsin',
                            name: 'nilai_waqof_penilaian_tahsin'
                        },
                        {
                            data: 'keterangan_penilaian_kegiatan',
                            name: 'keterangan_penilaian_kegiatan'
                        },
                        {
                            data: 'status_peserta_kegiatan',
                            name: 'status_peserta_kegiatan',
                            render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-info detalBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" 
                                    data-id_penialain="${row.id_penialain_kegiatan}">
                                    <i class="fas fa-eye"></i></button>
                                    `;
                            }
                        }
                    ]
                });
            }
        });
    </script>
@endsection
