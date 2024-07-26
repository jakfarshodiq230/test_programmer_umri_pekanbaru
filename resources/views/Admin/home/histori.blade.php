@extends('Admin.layout')
@section('content')
<style>
    .border-navy {
        border: 2px solid navy;
        border-radius: 5px;
    }
</style>
<main class="content">
    <div class="container-fluid">
        <div class="header">
            <h1 class="header-title" id="judul_header">
            History Perkembangan Peserta
            </h1>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body border-navy">
                            <form id="dataForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="inputEmail4">Tahun Ajaran</label>
                                            <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                name="tahun_ajaran" data-bs-toggle="select2" required>
                                                <option>PILIH</option>
                                            </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="inputEmail4">Peserta</label>
                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                            name="peserta" data-bs-toggle="select2" required>
                                            <option>PILIH</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4 mt-4">
                                        <button type="button" class="btn btn-primary kirimBtn" id="kirimBtn">Proses</button>
                                    </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body border-navy">
                            <div class="row">
                                <h5 class="card-title text-center">TAHSIN</h5>
                                <div class="col-6 col-md-6">
                                    <h5 class="card-title text-center">Hafalan Baru</h5>
                                    <table id="datatables-ajax-tahsin-baru" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Surah</th>
                                                <th>Ketrangan</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>Surah</th>
                                                <th>Ketrangan</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-6 col-md-6">
                                    <h5 class="card-title text-center">Hafalan Lama</h5>
                                    <table id="datatables-ajax-tahsin-lama" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Surah</th>
                                                <th>Ketrangan</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>Surah</th>
                                                <th>Ketrangan</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body border-navy">
                            <div class="row">
                                <h5 class="card-title text-center">TAHFIDZ</h5>
                                <div class="col-6 col-md-6 ">
                                    <h5 class="card-title text-center">Hafalan Baru</h5>
                                    <table id="datatables-ajax-tahfidz-baru" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Surah</th>
                                                <th>Ketrangan</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>Surah</th>
                                                <th>Ketrangan</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-6 col-md-6">
                                    <h5 class="card-title text-center">Hafalan Lama</h5>
                                    <table id="datatables-ajax-tahfidz-lama" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Surah</th>
                                                <th>Ketrangan</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No.</th>
                                                <th>Surah</th>
                                                <th>Ketrangan</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body border-navy">                         
                            <div class="col-12 col-md-12">
                                <h5 class="card-title text-center">Sertifikasi</h5>
                                <table id="datatables-ajax-sertif" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Periode</th>
                                            <th>Juz</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Periode</th>
                                            <th>Juz</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>   
                </div>
                <!-- end card -->
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
    <!-- Your other content -->
    <script>
        $('.select2').val(null).trigger('change');
        $('#dataForm')[0].reset();
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
        const selectElement = document.querySelector('select[name="tahun_ajaran"]');
        const selectElement2 = document.querySelector('select[name="peserta"]');
        const kirimBtn = document.getElementById('kirimBtn');
        function checkInputs() {
            if (selectElement.value.trim() === 'PILIH' || selectElement2.value.trim() === 'PILIH') {
                kirimBtn.disabled = true;
            } else {
                kirimBtn.disabled = false;
            }
        }

        // Use 'change' event for select elements
        $(selectElement).on('change', checkInputs);
        $(selectElement2).on('change', checkInputs);

        checkInputs(); // Initial check

        $(document).ready(function() {
            $('#datatables-ajax-tahsin-baru, #datatables-ajax-tahsin-lama').DataTable({
                language: {
                    emptyTable: "No data available in table"
                },
            });
            $('#datatables-ajax-tahfidz-baru, #datatables-ajax-tahfidz-lama').DataTable({
                language: {
                    emptyTable: "No data available in table"
                },
            });
            $('#datatables-ajax-sertif').DataTable({
                language: {
                    emptyTable: "No data available in table"
                },
            });
            $.ajax({
                url: '{{ url('admin/dashboard/ajax_histori') }}', // Your API endpoint
                method: 'GET',
                success: function(response) {
                    
                    var select1 = $('select[name="tahun_ajaran"]');
                    select1.empty();
                    select1.append('<option value="PILIH" selected>PILIH</option>'); // Add default option
                    $.each(response, function(key, value) {
                        select1.append('<option value="' + value.id_tahun_ajaran + '">' + value.nama_tahun_ajaran + '</option>');
                    });

                    select1.change(function() {
                        let tahunAjaranId = $(this).val();
                        if (tahunAjaranId) {
                            $.ajax({
                                url: '{{ url('admin/dashboard/ajax_histori_peserta') }}/' + tahunAjaranId,
                                method: 'GET',
                                success: function(response) {
                                    var select2 = $('select[name="peserta"]');
                                    select2.empty();
                                    select2.append('<option value="PILIH" selected>PILIH</option>'); // Add default option
                                    $.each(response, function(key, value) {
                                        select2.append('<option value="' + value.id_siswa + '">' + value.nama_siswa.trim().toUpperCase() + ' [ ' + value.nisn_siswa +' ]' + '</option>');
                                    });
                                }
                            });
                        } else {
                            $('#peserta').html('<option value="">PILIH</option>');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.kirimBtn', function() {
            var tahun = $('select[name="tahun_ajaran"]').val();
            var peserta = $('select[name="peserta"]').val();

            Swal.fire({
                title: 'Mencari Data...',
                text: 'Sedang mencari data, harap tunggu.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

                $('#datatables-ajax-tahsin-baru').DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: '{{ url('admin/dashboard/ajax_data_histori') }}/' + peserta + '/' + tahun,
                        dataSrc: 'tahsin_baru'
                    },
                    columns: [
                        {
                            data: null,
                            name: "rowNumber",
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'nama_surah_awal',
                            name: 'nama_surah_awal',
                            render: function(data, type, row) {
                                    var surahMulai = row.ayat_awal_penilaian_kegiatan === 0 ? row.nama_surah_awal : row.nama_surah_awal + ' [ ' + row.ayat_awal_penilaian_kegiatan + ' ]';
                                    var surahAkhir = row.ayat_akhir_penilaian_kegiatan === 0 ? row.nama_surah_akhir : row.nama_surah_akhir + ' [ ' + row.ayat_akhir_penilaian_kegiatan + ' ]';
                                    return surahMulai + ' s/d ' + surahAkhir;
                            }
                        },
                        {
                            data: 'keterangan_penilaian_kegiatan',
                            name: 'keterangan_penilaian_kegiatan',
                            render: function(data, type, row) {
                                return row.keterangan_penilaian_kegiatan || '';
                            }
                        }
                    ]
                });

                $('#datatables-ajax-tahsin-lama').DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: '{{ url('admin/dashboard/ajax_data_histori') }}/' + peserta + '/' + tahun,
                        dataSrc: 'tahsin_lama'
                    },
                    columns: [
                        {
                            data: null,
                            name: "rowNumber",
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'nama_surah_awal',
                            name: 'nama_surah_awal',
                            render: function(data, type, row) {
                                    var surahMulai = row.ayat_awal_penilaian_kegiatan === 0 ? row.nama_surah_awal : row.nama_surah_awal + ' [ ' + row.ayat_awal_penilaian_kegiatan + ' ]';
                                    var surahAkhir = row.ayat_akhir_penilaian_kegiatan === 0 ? row.nama_surah_akhir : row.nama_surah_akhir + ' [ ' + row.ayat_akhir_penilaian_kegiatan + ' ]';
                                    return surahMulai + ' s/d ' + surahAkhir;
                            }
                        },
                        {
                            data: 'keterangan_penilaian_kegiatan',
                            name: 'keterangan_penilaian_kegiatan',
                            render: function(data, type, row) {
                                return row.keterangan_penilaian_kegiatan || '';
                            }
                        }
                    ]
                });

                $('#datatables-ajax-tahfidz-baru').DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: '{{ url('admin/dashboard/ajax_data_histori') }}/' + peserta + '/' + tahun,
                        dataSrc: 'tahfidz_baru'
                    },
                    columns: [
                        {
                            data: null,
                            name: "rowNumber",
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'nama_surah_awal',
                            name: 'nama_surah_awal',
                            render: function(data, type, row) {
                                    var surahMulai = row.ayat_awal_penilaian_kegiatan === 0 ? row.nama_surah_awal : row.nama_surah_awal + ' [ ' + row.ayat_awal_penilaian_kegiatan + ' ]';
                                    var surahAkhir = row.ayat_akhir_penilaian_kegiatan === 0 ? row.nama_surah_akhir : row.nama_surah_akhir + ' [ ' + row.ayat_akhir_penilaian_kegiatan + ' ]';
                                    return surahMulai + ' s/d ' + surahAkhir;
                            }
                        },
                        {
                            data: 'keterangan_penilaian_kegiatan',
                            name: 'keterangan_penilaian_kegiatan',
                            render: function(data, type, row) {
                                return row.keterangan_penilaian_kegiatan || '';
                            }
                        }
                    ]
                });

                $('#datatables-ajax-tahfidz-lama').DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: '{{ url('admin/dashboard/ajax_data_histori') }}/' + peserta + '/' + tahun,
                        dataSrc: 'tahfidz_lama'
                    },
                    columns: [
                        {
                            data: null,
                            name: "rowNumber",
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'nama_surah_awal',
                            name: 'nama_surah_awal',
                            render: function(data, type, row) {
                                    var surahMulai = row.ayat_awal_penilaian_kegiatan === 0 ? row.nama_surah_awal : row.nama_surah_awal + ' [ ' + row.ayat_awal_penilaian_kegiatan + ' ]';
                                    var surahAkhir = row.ayat_akhir_penilaian_kegiatan === 0 ? row.nama_surah_akhir : row.nama_surah_akhir + ' [ ' + row.ayat_akhir_penilaian_kegiatan + ' ]';
                                    return surahMulai + ' s/d ' + surahAkhir;
                            }
                        },
                        {
                            data: 'keterangan_penilaian_kegiatan',
                            name: 'keterangan_penilaian_kegiatan',
                            render: function(data, type, row) {
                                return row.keterangan_penilaian_kegiatan || '';
                            }
                        }
                    ]
                });

                $('#datatables-ajax-sertif').DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: '{{ url('admin/dashboard/ajax_data_histori') }}/' + peserta + '/' + tahun,
                        dataSrc: 'sertifikasi'
                    },
                    columns: [
                        {
                            data: null,
                            name: "rowNumber",
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'judul_periode',
                            name: 'judul_periode',
                            render: function(data, type, row) {
                                return row.judul_periode.toUpperCase() + ' ' + row.jenis_periode.toUpperCase();
                            }
                        },
                        {
                            data: null,
                            name: null,
                            render: function(data, type, row) {
                                return 'Juz ' + row.juz_periode ;
                            }
                        },
                        {
                            data: 'total_nilai_sertifikasi',
                            name: 'total_nilai_sertifikasi',
                            render: function(data, type, row) {
                                return row.total_nilai_sertifikasi.toFixed(0) + ' ( '+categorizeAverageScore(row.total_nilai_sertifikasi)+' )' ;
                            }
                        }
                    ],
                    initComplete: function() {
                        Swal.close();
                    }
                });
        });
    </script>
@endsection


