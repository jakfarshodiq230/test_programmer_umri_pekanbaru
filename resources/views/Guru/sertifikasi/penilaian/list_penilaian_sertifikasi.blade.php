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
                                    
                                </div>
                                <div class="col-md-4 profile">
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Juz</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="juz" style="flex: 1;">-</span>
                                    </div>
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Penilaian</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="penilaian" style="flex: 1;">-</span>
                                    </div>
                                </div>
                                <div class="col-md-4 profile">
                                    <div class="profile-item mb-3 d-flex flex-column align-items-center">
                                        <button class="btn btn-outline-primary me-2 addBtn text-end" id="addBtn">
                                            PENILAIAN SERTIFIKASI
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <table id="datatables-ajax" class="table table-striped mt-4" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Sesi Ujian</th>
                                        <th>Nilai</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Sesi Ujian</th>
                                        <th>Nilai</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="siswa" id="siswa" data-bs-toggle="select2" required>
                                                        <option value="PILIH">PILIH</option>
                                                    </select>
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
    </main>
@endsection
@section('scripts')
    <!-- Your other content -->
<script>
        var periode = '{{ $periode }}';
        var sertifikasi = '{{ $sertifikasi }}';
        var tahun = '{{ $tahun }}';
        var guru = "{{ session('user')['id']}}";
        function capitalizeFirstLetter(string) {
            return string.toUpperCase();
        }
        function loadPeserta() {
            $.ajax({
                url: '{{ url('guru/penilaian_sertifikasi/list_peserta') }}/' + tahun + '/' + sertifikasi + '/' + periode,
                method: 'GET',
                success: function(data) {
                    var select = $('select[name="siswa"]');
                    select.empty().append('<option value="">PILIH</option>');

                    $.each(data.peserta, function(key, value) {
                        //if (value.count_penilaian < 2) {
                            select.append('<option value="' + value.id_peserta_sertifikasi + '">' + 
                            value.nama_siswa.trim().toUpperCase() + ' [ ' + value.nisn_siswa + ' ]' + 
                            '</option>');
                        //}
                    });

                    select.change(function() {
                        var selectedId = $(this).val();
                        var selectedSiswa = data.peserta.find(function(peserta) {
                            return peserta.id_peserta_sertifikasi == selectedId;
                        });

                        if (selectedSiswa) {
                            $('#kelas').val(selectedSiswa.nama_kelas.trim().toUpperCase());
                            $('#guru').val(selectedSiswa.nama_guru.trim().toUpperCase());
                        } else {
                            $('#kelas').val('');
                            $('#guru').val('');
                        }
                    });
                }
            });

            $.ajax({
                url: '{{ url('guru/penilaian_sertifikasi/list_peserta') }}/' + tahun + '/' + sertifikasi + '/' + periode,
                method: 'GET',
                success: function(response) {
                    $('#tahun_ajaran').text(response.periode.nama_tahun_ajaran);
                    $('#sertifikasi').text(capitalizeFirstLetter(response.periode.jenis_periode.toUpperCase()));
                    $('#juz').text(response.periode.juz_periode);
                    if (response.periode.tggl_akhir_penilaian < new Date()) {
                        $('#addBtn').addClass('disabled');
                        $('.deleteBtn').addClass('disabled');
                        $('#penilaian').addClass('text-danger').text('TUTUP');
                    } else {
                        $('#addBtn').removeClass('disabled');
                        $('.deleteBtn').removeClass('disabled');
                        $('#penilaian').addClass('text-success').text('BUKA');
                    }
                }
            });

            $.ajax({
                url: '{{ url('guru/penilaian_sertifikasi/list_peserta') }}/' + tahun + '/' + sertifikasi + '/' + periode,
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
                    url: '{{ url('guru/penilaian_sertifikasi/ajax_peserta_daftar') }}/' + tahun + '/' + sertifikasi + '/' + periode,
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
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                        render: function(data, type, row) {
                            var nama_siswa = row.nama_siswa.toUpperCase() ;
                            return nama_siswa + '<br>' + row.nisn_siswa + '<br>' + row.nama_kelas.toUpperCase();
                        }
                    },
                    {
                        data: 'count_penilaian',
                        name: 'count_penilaian',
                        render: function(data, type, row) {
                                return 'SESI '+ row.count_penilaian + ' / ' + row.sesi_periode;
                        }
                    },
                    {
                        data: 'avg_penilaian',
                        name: 'avg_penilaian',
                        render: function(data, type, row) {
                                return row.avg_penilaian === null ? 0 : row.avg_penilaian;
                        }
                    },
                    {
                        data: 'status_peserta_sertifikasi',
                        name: 'status_peserta_sertifikasi',
                        render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-info lihatBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Nilai Sertifikasi" 
                                    data-peserta="${row.id_peserta_sertifikasi}">
                                    <i class="fas fa-eye"></i></button>
                                `;
                        }
                    },
                ]
            });
        });

        // dafatar
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Penilaian Sertifikasi');
            $('#dataForm')[0].reset();
            $('.select2').val(null).trigger('change');
            $('#formModal').modal('show');
        });

        // save button
        $('#saveBtn').on('click', function() {
            url = '{{ url('guru/penilaian_sertifikasi/store_daftar') }}';
            
            var form = $('#dataForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#dataForm')[0].reset();
                    $('#formModal').modal('hide');
                    $('.select2').val(null).trigger('change');
                    loadPeserta();
                    $('#datatables-ajax').DataTable().ajax.reload();
                    Swal.fire({
                        title: response.success ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.success ? 'success' : 'error',
                        confirmButtonText: 'OK'
                    });

                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    if (response) {
                        let errors = response; // Use the response directly, which contains the errors
                        $('.form-control').removeClass('is-invalid').removeClass('is-valid');
                        $('.invalid-feedback').empty();

                        Object.keys(errors).forEach(function(key) {
                            console.log(key);
                            let input = $("#" + key);
                            let errorDiv = $("#" + key + "-error");

                            input.addClass("is-invalid");
                            errorDiv.html('<strong>' + errors[key][0] + '</strong>'); 

                            if (input.hasClass("select2-hidden-accessible")) {
                                input.parent().addClass("is-invalid");
                            }
                        });
                    }
                }
            });
        });

        // detail 
        $(document).on('click', '.lihatBtn', function() {
            var peserta = $(this).data('peserta');
            var url= '{{ url('guru/penilaian_sertifikasi/detail_penilaian_peserta') }}/'+ peserta;
            window.location.href = url;
        });
</script>
@endsection
