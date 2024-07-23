@extends('Guru.layout')
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
        .profile-item .value ol {
            margin: 0;
            padding-left: 10px;
        }
    </style>
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title" id="judul_header">
                    Data Penilaian Peserta Sertifikasi
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body ">
                            <div class="row border-navy mb-4">
                                <div class="col-md-4 profile">
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Tahun Ajaran</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="tahun_ajaran" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Sertifikasi</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="sertifikasi" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Pembimbing</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="pembimbing" style="flex: 1;">-</span>
                                    </div>
                                </div>
                                <div class="col-md-4 profile">
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Nama</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="siswa" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Kelas</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="kelas" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Juz</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="juz" style="flex: 1;">-</span>
                                    </div>
                                </div>
                                <div class="col-md-4 profile">
                                    <div class="text-center">
                                        <img alt="Peserta" id="avatarImg" src=""
                                            class="rounded-circle img-responsive" width="100" height="100" />
                                    </div>
                                </div>
                            </div>
                            <table id="datatables-ajax" class="table table-striped mt-4" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Sesi Ujian</th>
                                        <th>Surah</th>
                                        <th>Koreksi dan Saran</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="align-left">Rata - Rata</th>
                                        <th id="average-column5">0</th>
                                    </tr>
                                </tfoot>
                                <button id="download-button" class="btn btn-sm btn-primary downloadBtn me-1 mb-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Nilai Sertifikasi"><i class="fas fa-download"></i> Nilai</button>
                                <button id="downloadSertif-button" class="btn btn-sm btn-warning downloadSertifBtn me-1 mb-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Sertifikasi"><i class="fas fa-download"></i> Sertifikat</button>
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
        var peserta = '{{ $peserta }}';
        // Define the ranges object
        const ranges = {
            "Lulus": {
                min: 65,
                max: 100
            },
            "Tidak Lulus": {
                min: 0,
                max: 64
            }
        };

        function categorizeAverageScore(average) {
            for (let category in ranges) {
                const { min, max } = ranges[category];
                if (average >= min && average <= max) {
                    return category;
                }
            }
            return 'Unknown';
        }

        function capitalizeFirstLetter(string) {
            return string.toUpperCase();
        }

        function loadPeserta() {
            $.ajax({
                url: '{{ url('guru/daftar_sertifikasi/ajax_detail_penilaian_peserta') }}/' + peserta,
                method: 'GET',
                success: function(response) {
                    $('#tahun_ajaran').text(response.identitas.nama_tahun_ajaran);
                    $('#sertifikasi').text(capitalizeFirstLetter(response.identitas.jenis_periode.toUpperCase()));
                    $('#juz').text(response.identitas.juz_periode);
                    $('#pembimbing').text(capitalizeFirstLetter(response.identitas.nama_guru.toUpperCase()));
                    $('#siswa').text(capitalizeFirstLetter(response.identitas.nama_siswa.toUpperCase()));
                    $('#kelas').text(capitalizeFirstLetter(response.identitas.nama_kelas.toUpperCase()));
                    if (response.identitas.foto_siswa != null) {
                        var fotoSiswaUrl = "{{ url('storage') }}/" + response.identitas.foto_siswa;
                        $('#avatarImg').attr('src', fotoSiswaUrl);
                    } else {
                        var fotoSiswaUrl = '{{ asset('assets/admin/img/avatars/avatar.jpg') }}'
                        $('#avatarImg').attr('src', fotoSiswaUrl);
                    }
                    $('.downloadBtn').attr('data-id', response.identitas.id_peserta_sertifikasi);
                    $('.downloadSertifBtn').attr('data-id', response.identitas.id_peserta_sertifikasi);
                }
            });
        }
        loadPeserta();

        // datatabel
        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: {
                    url: '{{ url('guru/daftar_sertifikasi/ajax_detail_penilaian_peserta') }}/' + peserta,
                    dataSrc:'nilai',
                },
                columns: [{
                        "data": null,
                        "name": "rowNumber",
                        "render": function(data, type, row, meta) {
                            return meta.row +
                                1;
                        }
                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row, meta) {
                                return 'SESI KE-' + (meta.row + 1);
                        }
                    },
                    {
                        data: 'SurahMulai',
                        name: 'SurahMulai',
                        render: function(data, type, row) {
                            var surah_mulai = row.ayat_awal === 0 ? row.SurahMulai :  row.SurahMulai + ' [ ' + row.ayat_awal + ' ]';
                            var surah_akhir = row.ayat_akhir === 0 ? row.SurahAkhir :  row.SurahAkhir + ' [ ' + row.ayat_akhir + ' ]';
                            return surah_mulai + ' s/d ' + surah_akhir;
                        }
                    },
                    {
                        data: 'koreksi_sertifikasi',
                        name: 'koreksi_sertifikasi',
                    },
                    {
                        data: 'nilai_sertifikasi',
                        name: 'nilai_sertifikasi',
                        render: function(data, type, row) {
                                return row.nilai_sertifikasi === null ? 0 : row.nilai_sertifikasi;
                        }
                    }
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    var columnIndex = 4; // Index of the column for 'nilai_sertifikasi'

                    var total = api.column(columnIndex).data().reduce(function(a, b) {
                        return a + parseFloat(b);
                    }, 0);

                    var count = api.column(columnIndex).data().count();
                    var average = count > 0 ? (total / count).toFixed(0) : 0;
                    var nilai_ktr = average + ' (' + categorizeAverageScore(average) + ')';
                    $('#average-column5').text(nilai_ktr);
                    if (average < 65 && average > 0) {
                        $('#download-button').addClass('disabled');
                        $('#downloadSertif-button').addClass('disabled');
                    } else {
                        $('#download-button').removeClass('disabled');
                        $('#downloadSertif-button').removeClass('disabled');
                    }
                    
                }
            });
        });

        // download pdf
        $(document).on('click', '.downloadBtn', function() {
            var id = $(this).data('id');
            var url= '{{ url('guru/penilaian_sertifikasi/cetak_sertifikat') }}/'+ id;
            window.location.href = url;
        });

        $(document).on('click', '.downloadSertifBtn', function() {
            var id = $(this).data('id');
            var url= '{{ url('guru/daftar_sertifikasi/download_sertifikat') }}/'+ id;
            window.location.href = url;
        });

</script>
@endsection
