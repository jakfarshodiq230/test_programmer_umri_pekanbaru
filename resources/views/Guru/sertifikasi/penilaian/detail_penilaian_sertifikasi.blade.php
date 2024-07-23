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
                            <div class="row border-navy">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="align-left">Rata - Rata</th>
                                        <th id="average-column5">0</th>
                                        <th id="average-column6">
                                            <button id="download-button" class="btn btn-sm btn-primary downloadBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Nilai Sertifikasi"><i class="fas fa-download"></i> Download</button>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{-- add atau edit  --}}
                        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true"
                            data-bs-keyboard="false" data-bs-backdrop="static">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form method="POST" id="dataForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabel">Edit Harga</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body m-3">
                                            <div class="row">
                                                <div class="col-6 col-lg-6">
                                                    <div class="mb-3">
                                                        <label>Siswa</label>
                                                        <input type="text" name="siswa" id="siswa"
                                                            class="form-control" placeholder="siswa" readonly>
                                                        <input type="text" name="id_penilaian" id="id_penilaian"
                                                            class="form-control" placeholder="id_penilaian" hidden>
                                                        <div id="siswa-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Kelas</label>
                                                        <input type="text" name="kelas" id="kelas"
                                                            class="form-control" placeholder="Kelas" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Pembimbing</label>
                                                        <input type="text" name="guru" id="guru"
                                                            class="form-control" placeholder="Guru" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-6">
                                                    <div class="row">
                                                        <div class="col-6 col-lg-6">
                                                            <div class="mb-3">
                                                                <label>Surah Mulai</label>
                                                                <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                                    name="surah_mulai" id="surah_mulai" data-bs-toggle="select2" required>
                                                                    <option value="PILIH">PILIH</option>
                                                                </select>
                                                                <div id="surah_mulai-error" class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Surah Akhir</label>
                                                                <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                                    name="surah_akhir" id="surah_akhir" data-bs-toggle="select2" required>
                                                                    <option value="PILIH">PILIH</option>
                                                                </select>
                                                                <div id="surah_akhir-error" class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-lg-6">
                                                            <div class="mb-3">
                                                                <label>Ayat Mulai</label>
                                                                <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                                    name="ayat_mulai" id="ayat_mulai" data-bs-toggle="select2" required>
                                                                    <option value="PILIH">PILIH</option>
                                                                </select>
                                                                <div id="ayat_mulai-error" class="invalid-feedback"></div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Ayat Akhir</label>
                                                                <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                                    name="ayat_akhir" id="ayat_akhir" data-bs-toggle="select2" required>
                                                                    <option value="PILIH">PILIH</option>
                                                                </select>
                                                                <div id="ayat_akhir-error" class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai</label>
                                                        <input type="text" name="nilai" id="nilai"
                                                            class="form-control" placeholder="Nilai Sertifikasi">
                                                        <div id="nilai-error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="text-center">Koreksi dan Saran</label>
                                                    <textarea name="koreksi_saran" id="koreksi_saran"
                                                        class="form-control" placeholder="Koreksi dan Saran Sertifikasi" > </textarea>
                                                    <div id="koreksi_saran-error" class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="button" id="saveBtn" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- end add atau edit guru --}}
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
                url: '{{ url('guru/penilaian_sertifikasi/ajax_detail_penilaian_peserta') }}/' + peserta,
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
                }
            });

            $.ajax({
                url: '{{ url('guru/penilaian_sertifikasi/ajax_detail_penilaian_peserta') }}/' + peserta,
                method: 'GET',
                success: function(data) {
                    // surah awal
                    var select_surah = $('select[name="surah_mulai"]');
                    select_surah.empty();
                    select_surah.append('<option>PILIH</option>'); // Add default option
                    $.each(data.surah, function(key, value) {
                        select_surah.append('<option value="' + value.nomor + '">' + value
                            .namaLatin.trim().toUpperCase() + '</option>');
                    });
                    // Update #kelas text when an option is selected
                    select_surah.change(function() {
                        var selectedId_surah = $(this).val();
                        var selected_surah = data.surah.find(function(surah) {
                            return surah.nomor == selectedId_surah;
                        });

                        if (selected_surah) {
                            var select_ayat_awal = $(
                                'select[name="ayat_mulai"]');
                            select_ayat_awal.empty();
                            select_ayat_awal.append(
                                '<option>PILIH</option>'); // Add default option
                            var jumlahAyat = selected_surah.jumlahAyat;
                            for (var i = 1; i <= jumlahAyat; i++) {
                                select_ayat_awal.append('<option value="' + i + '">' + i +
                                    '</option>');
                            }

                        } else {
                            $('#ayat_mulai').val(
                                ''); // Handle case where no surah is selected
                        }
                    });

                    // surah akhir
                    var select_surah = $('select[name="surah_akhir"]');
                    select_surah.empty();
                    select_surah.append('<option>PILIH</option>'); // Add default option
                    $.each(data.surah, function(key, value) {
                        select_surah.append('<option value="' + value.nomor + '">' + value
                            .namaLatin.trim().toUpperCase() + '</option>');
                    });
                    // Update #kelas text when an option is selected
                    select_surah.change(function() {
                        var selectedId_surah = $(this).val();
                        var selected_surah = data.surah.find(function(surah) {
                            return surah.nomor == selectedId_surah;
                        });

                        if (selected_surah) {
                            var select_ayat_awal = $(
                                'select[name="ayat_akhir"]');
                            select_ayat_awal.empty();
                            select_ayat_awal.append(
                                '<option>PILIH</option>'); // Add default option
                            var jumlahAyat = selected_surah.jumlahAyat;
                            for (var i = 1; i <= jumlahAyat; i++) {
                                select_ayat_awal.append('<option value="' + i + '">' + i +
                                    '</option>');
                            }

                        } else {
                            $('#ayat_mulai').val(
                                ''); // Handle case where no surah is selected
                        }
                    });
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
                    url: '{{ url('guru/penilaian_sertifikasi/ajax_detail_penilaian_peserta') }}/' + peserta,
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
                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-danger deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Nilai Sertifikasi" 
                                    data-id="${row.id_penilaian_sertifikasi}">
                                    <i class="fas fa-trash"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Nilai Sertifikasi" 
                                    data-id="${row.id_penilaian_sertifikasi}">
                                    <i class="fas fa-edit"></i></button>
                                `;
                        }
                    },
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
                    } else {
                        $('#download-button').removeClass('disabled');
                    }
                    
                }
            });
        });

        // delete 
        $(document).on('click', '.deleteBtn', function() {
            var id = $(this).data('id');
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
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('guru/penilaian_sertifikasi/hapus_penilaian_sertifikasi') }}/' +
                            id, // URL to delete data for the selected row
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                        $('#datatables-ajax').DataTable().ajax.reload();
                            Swal.fire({
                                title: response.success ? 'Success' : 'Error',
                                text: response.message,
                                icon: response.success ? 'success' : 'error',
                                confirmButtonText: 'OK'
                            });
                            $('#datatables-ajax').DataTable().ajax.reload();
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
                }
            });
        });
        // edit
        $(document).on('click', '.editBtn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Edit Data',
                text: 'Apakah Anda Ingin Merubah Data Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya merubah data ini'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('guru/penilaian_sertifikasi/edit_penilaian_sertifikasi') }}/' +
                            id,
                        type: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#ModalLabel').text('Edit Penilaian Sertifikasi');
                            $('#dataForm')[0].reset();
                            $('.select2').val(null).trigger('change');
                            $('#formModal').modal('show');
                            $('#formModal input[name="id_penilaian"]').val(response.nilai.id_penilaian_sertifikasi);
                            $('#formModal input[name="siswa"]').val(response.nilai.nama_siswa);
                            $('#formModal input[name="kelas"]').val(response.nilai.nama_kelas);
                            $('#formModal input[name="guru"]').val(response.nilai.nama_guru);
                            $('#formModal select[name="surah_mulai"]').val(response.nilai.surah_mulai).change();
                            $('#formModal select[name="surah_akhir"]').val(response.nilai.surah_akhir).change();
                            $('#formModal select[name="ayat_mulai"]').val(response.nilai.ayat_awal).change();
                            $('#formModal select[name="ayat_akhir"]').val(response.nilai.ayat_akhir).change();
                            $('#formModal input[name="nilai"]').val(response.nilai.nilai_sertifikasi);
                            $('#formModal textarea[name="koreksi_saran"]').val(response.nilai.koreksi_sertifikasi);
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
                }
            });
        });
        // save
        $('#saveBtn').on('click', function() {
            var id = $("#id_penilaian").val();
            var url = '{{ url('guru/penilaian_sertifikasi/update_penilaian_sertifikasi') }}/' + id;
            var form = $('#dataForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('.select2').val(null).trigger('change');
                    $('#dataForm')[0].reset();
                    $('#formModal').modal('hide');
                    $('#datatables-ajax').DataTable().ajax.reload();
                    Swal.fire({
                        title: response.success ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.success ? 'success' : 'error',
                        confirmButtonText: 'OK'
                    });

                },
                error: function(response) {
                    $('.select2').val(null).trigger('change');
                    $('#dataForm')[0].reset();
                    Swal.fire({
                        title: response.success ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.success ? 'success' : 'error',
                        confirmButtonText: 'OK'
                    });

                }
            });
        });
        // download pdf
        $(document).on('click', '.downloadBtn', function() {
            var id = $(this).data('id');
            var url= '{{ url('guru/penilaian_sertifikasi/cetak_sertifikat') }}/'+ id;
            window.location.href = url;
        });

</script>
@endsection
