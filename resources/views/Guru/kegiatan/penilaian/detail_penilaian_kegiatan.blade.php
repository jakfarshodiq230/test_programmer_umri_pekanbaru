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
                        </div>
                    </div>
                    {{-- tahfidz --}}
                    <div class="card" id="tahfidz">
                        <div class="card-body">
                            <table id="datatables-ajax-tahfidz" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Penilaian</th>
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
                                        <th>Penilaian</th>
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
                                        <th>Penilaian</th>
                                        <th>Surah</th>
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
                                        <th>Penilaian</th>
                                        <th>Surah</th>
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
                    {{-- add atau edit guru --}}
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
                                                    <label>Tahun Ajaran</label>
                                                    <input type="text" name="tahun_ajaran" id="tahun_ajaran"
                                                        class="form-control" placeholder="id_tahun_ajaran" readonly>
                                                    <input type="text" name="id_penilaian_kegiatan"
                                                        id="id_penilaian_kegiatan" class="form-control"
                                                        placeholder="id_penilaian_kegiatan" hidden>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Siswa</label>
                                                    <input type="text" name="siswa_penilaian" id="siswa_penilaian"
                                                        class="form-control" placeholder="siswa_penilaian" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Surah Awal</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="surah_awal_penilaian_kegiatan" data-bs-toggle="select2"
                                                        required>
                                                        <option>PILIH</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Surah Akhir</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="surah_akhir_penilaian_kegiatan" data-bs-toggle="select2"
                                                        required>
                                                        <option>PILIH</option>
                                                    </select>
                                                </div>
                                                <div id="tahfidz_form">
                                                    <div class="mb-3">
                                                        <label>Tajwid</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_tajwid" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_tajwid_penilaian_kegiatan\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Fasohah</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_fasohah" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_fasohah_penilaian_kegiatan\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Kelancaran</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_kelancaran" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_kelancaran_penilaian_kegiatan\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- tahsin --}}
                                                <div id="tahsin_form">
                                                    <div class="mb-3">
                                                        <label>Ghunnah</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_ghunnah" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_ghunnah_penilaian_kegiatan\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Mad</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_mad" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_mad_penilaian_tahsin\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Waqof</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_waqof" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_waqof_penilaian_tahsin\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- end tahsin --}}
                                                <div class="mb-3">
                                                    <label>Tanggal Penilaian</label>
                                                    <input type="date" name="tanggal_penilaian_kegiatan"
                                                        class="form-control" placeholder="Tanggal Penilaian" required>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <div class="mb-3">
                                                    <label>Kegiatan</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="jenis_penilaian_kegiatan" data-bs-toggle="select2" required>
                                                        <option>PILIH</option>
                                                        @if ($kegiatan === 'tahfidz')
                                                            <option value="tahfidz">TAHFIDZ</option>
                                                            <option value="murajaah">MURAJA'AH</option>
                                                        @else
                                                            <option value="tahsin">TAHSIN</option>
                                                            <option value="materikulasi">MATERIKULASI</option>
                                                        @endif


                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Kelas</label>
                                                    <input type="text" name="kelas" id="kelas"
                                                        class="form-control" placeholder="Kelas" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Ayat Awal</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="ayat_awal_penilaian_kegiatan" data-bs-toggle="select2"
                                                        required>
                                                        <option>PILIH</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Ayat Akhir</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="ayat_akhir_penilaian_kegiatan" data-bs-toggle="select2"
                                                        required>
                                                        <option>PILIH</option>
                                                    </select>
                                                </div>

                                                <div id="tahfidz_form_keterangan">
                                                    <div class="mb-3">
                                                        <label>Nilai Tajwid</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_tajwid_penilaian_kegiatan"
                                                            data-bs-toggle="select2" required>
                                                            <option>PILIH</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai Fasohah</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_fasohah_penilaian_kegiatan"
                                                            data-bs-toggle="select2" required>
                                                            <option>PILIH</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai Kelancaran</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_kelancaran_penilaian_kegiatan"
                                                            data-bs-toggle="select2" required>
                                                            <option>PILIH</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- tahsin --}}
                                                <div id="tahsin_form_keterangan">
                                                    <div class="mb-3">
                                                        <label>Nilai Ghunnah</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_ghunnah_penilaian_kegiatan"
                                                            data-bs-toggle="select2" required>
                                                            <option>PILIH</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai Mad</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_mad_penilaian_tahsin" data-bs-toggle="select2"
                                                            required>
                                                            <option>PILIH</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai Waqof</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_waqof_penilaian_tahsin" data-bs-toggle="select2"
                                                            required>
                                                            <option>PILIH</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- end tahsin --}}
                                                <div class="mb-3">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan_penilaian_kegiatan" class="form-control" placeholder="Keterangan" required></textarea>
                                                </div>
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
        var id_tahun = "{{ $tahun }}";
        var id_periode = "{{ $periode }}";
        var id_siswa = "{{ $siswa }}";
        var id_guru = "{{ $guru }}";
        var id_kelas = "{{ $kelas }}";
        var kegiatan = "{{ $kegiatan }}";
        $('#dataForm')[0].reset();
        $('#tahsin_form').hide();
        $('#tahsin_form_keterangan').hide();
        $('#tahfidz_form').hide();
        $('#tahfidz_form_keterangan').hide();
        // profil
        $.ajax({
            url: "{{ url('guru/penilaian_kegiatan/data_penilaian_kegiatan_all') }}/" +
                id_tahun + "/" +
                id_periode + "/" +
                id_siswa + "/" +
                id_guru + "/" +
                id_kelas,
            type: 'GET',
            success: function(data) {
                if (data.siswa.jenis_periode === 'tahfidz') {
                    $('#kegiatan').text('Tahfidz/Murajaah');
                } else {
                    $('#kegiatan').text('Tahsin/Materikulasi');
                }
                $('#tahun_ajaran').text(capitalizeFirstLetter(data.siswa.nama_tahun_ajaran));
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
        // surah
        $(document).ready(function() {
            $.ajax({
                url: '{{ url('guru/penilaian_kegiatan/data_siswa') }}/' + id_tahun + '/' + id_periode +
                    '/' +
                    id_guru,
                method: 'GET',
                success: function(data) {
                    // surah awal
                    var select_surah = $('select[name="surah_awal_penilaian_kegiatan"]');
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
                                'select[name="ayat_awal_penilaian_kegiatan"]');
                            select_ayat_awal.empty();
                            select_ayat_awal.append(
                                '<option>PILIH</option>'); // Add default option
                            var jumlahAyat = selected_surah.jumlahAyat;
                            for (var i = 1; i <= jumlahAyat; i++) {
                                select_ayat_awal.append('<option value="' + i + '">' + i +
                                    '</option>');
                            }

                        } else {
                            $('#ayat_awal_penilaian_kegiatan').val(
                                ''); // Handle case where no surah is selected
                        }
                    });

                    // surah akhir
                    var select_surah2 = $('select[name="surah_akhir_penilaian_kegiatan"]');
                    select_surah2.empty();
                    select_surah2.append('<option>PILIH</option>'); // Add default option
                    $.each(data.surah, function(key, value) {
                        select_surah2.append('<option value="' + value.nomor + '">' + value
                            .namaLatin.trim().toUpperCase() + '</option>');
                    });
                    // Update #kelas text when an option is selected
                    select_surah2.change(function() {
                        var selectedId_surah2 = $(this).val();
                        var selected_surah2 = data.surah.find(function(surah) {
                            return surah.nomor == selectedId_surah2;
                        });

                        if (selected_surah2) {
                            var select_ayat_akhir = $(
                                'select[name="ayat_akhir_penilaian_kegiatan"]');
                            select_ayat_akhir.empty();
                            select_ayat_akhir.append(
                                '<option>PILIH</option>'); // Add default option
                            var jumlahAyat2 = selected_surah2.jumlahAyat;
                            for (var i = 1; i <= jumlahAyat2; i++) {
                                select_ayat_akhir.append('<option value="' + i + '">' + i +
                                    '</option>');
                            }

                        } else {
                            $('#ayat_akhir_penilaian_kegiatan').val(
                                ''); // Handle case where no surah is selected
                        }
                    });



                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
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
                        url: "{{ url('guru/penilaian_kegiatan/data_penilaian_kegiatan_all') }}/" +
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
                            data: 'jenis_penilaian_kegiatan',
                            name: 'jenis_penilaian_kegiatan',
                            render: function(data, type, row) {
                                return row.jenis_penilaian_kegiatan.trim().toUpperCase()
                            }
                        },
                        {
                            data: null,
                            name: null,
                            render: function(data, type, row) {
                                return 'SURAH AWAL : ' + row.namaLatin_awal.trim().toUpperCase() +
                                    ' [ ' + row.ayat_awal_penilaian_kegiatan + ' ]<br>' +
                                    'SURAH AKHIR : ' + row.namaLatin_akhir.trim().toUpperCase() +
                                    ' [ ' + row.ayat_akhir_penilaian_kegiatan + ' ]';
                            }
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
                            data: null,
                            name: null,
                            render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-info editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" 
                                    data-id_penialain="${row.id_penilaian_kegiatan}">
                                    <i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" 
                                    data-id_penialain="${row.id_penilaian_kegiatan}">
                                    <i class="fas fa-trash"></i></button>
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
                        url: "{{ url('guru/penilaian_kegiatan/data_penilaian_kegiatan_all') }}/" +
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
                            data: 'jenis_penilaian_kegiatan',
                            name: 'jenis_penilaian_kegiatan',
                            render: function(data, type, row) {
                                return row.jenis_penilaian_kegiatan.trim().toUpperCase()
                            }
                        },
                        {
                            data: null,
                            name: null,
                            render: function(data, type, row) {
                                return 'SURAH AWAL : ' + row.namaLatin_awal.trim().toUpperCase() +
                                    ' [ ' + row.ayat_awal_penilaian_kegiatan + ' ]<br>' +
                                    'SURAH AKHIR : ' + row.namaLatin_akhir.trim().toUpperCase() +
                                    ' [ ' + row.ayat_akhir_penilaian_kegiatan + ' ]';
                            }
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
                            data: null,
                            name: null,
                            render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-info editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" 
                                    data-id_penialain="${row.id_penilaian_kegiatan}">
                                    <i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" 
                                    data-id_penialain="${row.id_penilaian_kegiatan}">
                                    <i class="fas fa-trash"></i></button>
                                    `;
                            }
                        }
                    ]
                });
            }
        });

        // delete 
        $(document).on('click', '.deleteBtn', function() {
            var id = $(this).data('id_penialain');
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
                        url: '{{ url('guru/penilaian_kegiatan/hapus_penilaian_kegiatan') }}/' +
                            id, // URL to delete data for the selected row
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (kegiatan === "tahfidz") {
                                $('#datatables-ajax-tahfidz').DataTable().ajax.reload();
                            } else {
                                $('#datatables-ajax-tahsin').DataTable().ajax.reload();
                            }
                            Swal.fire({
                                title: response.success ? 'Success' : 'Error',
                                text: response.message,
                                icon: response.success ? 'success' : 'error',
                                confirmButtonText: 'OK'
                            });
                            $('#datatables-ajax').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            if (kegiatan === "tahfidz") {
                                $('#datatables-ajax-tahfidz').DataTable().ajax.reload();
                            } else {
                                $('#datatables-ajax-tahsin').DataTable().ajax.reload();
                            }
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

        // penilaian
        const ranges = {
            "sangat_baik": {
                min: 96,
                max: 100
            },
            "baik": {
                min: 86,
                max: 95
            },
            "cukup": {
                min: 80,
                max: 85
            },
            "kurang": {
                min: 0,
                max: 79
            }
        };

        function handleNilaiChange(selectElement, select) {
            const id = selectElement.value;
            select.empty();
            select.append('<option>PILIH</option>'); // Add default option

            if (ranges[id]) {
                const {
                    min,
                    max
                } = ranges[id];
                for (let i = min; i <= max; i++) {
                    select.append('<option value="' + i + '">' + i + '</option>');
                }
            }

            // Display alert if "PILIH" is selected
            if (id === "PILIH") {
                alert("Silahkan Pilih");
            }
        }

        function getRange(input) {
            for (const [key, value] of Object.entries(ranges)) {
                if (input >= value.min && input <= value.max) {
                    return key;
                }
            }
        }

        $(document).on('click', '.editBtn', function() {
            // edit
            if (kegiatan === "tahfidz") {
                $('#tahfidz_form').show();
                $('#tahfidz_form_keterangan').show();
            } else {
                $('#tahsin_form').show();
                $('#tahsin_form_keterangan').show();

            }
            $('#ModalLabel').text('Edit guru');
            var id = $(this).data('id_penialain');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('guru/penilaian_kegiatan/edit_penilaian_kegiatan') }}/' +
                    id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    // Populate the modal fields with the data
                    $('#formModal input[name="id_penilaian_kegiatan"]').val(data.data
                        .id_penilaian_kegiatan);
                    $('#formModal input[name="tahun_ajaran"]').val(data.data.nama_tahun_ajaran);
                    $('#formModal select[name="jenis_penilaian_kegiatan"]').val(data.data
                        .jenis_penilaian_kegiatan).change();
                    $('#formModal input[name="siswa_penilaian"]').val(data.data.nama_siswa);
                    $('#formModal input[name="kelas"]').val(data.data.nama_kelas);
                    $('#formModal input[name="tanggal_penilaian_kegiatan"]').val(data.data
                        .tanggal_penilaian_kegiatan);
                    $('#formModal select[name="surah_awal_penilaian_kegiatan"]').val(data.data
                        .surah_awal_penilaian_kegiatan).change();
                    $('#formModal select[name="surah_akhir_penilaian_kegiatan"]').val(data.data
                        .surah_akhir_penilaian_kegiatan).change();
                    $('#formModal select[name="ayat_awal_penilaian_kegiatan"]').val(data.data
                        .ayat_awal_penilaian_kegiatan).change();
                    $('#formModal select[name="ayat_akhir_penilaian_kegiatan"]').val(data.data
                        .ayat_akhir_penilaian_kegiatan).change();

                    // tahfidz
                    const keterangan_tajwid = getRange(data.data.nilai_tajwid_penilaian_kegiatan);
                    $('#formModal select[name="keterangan_tajwid"]').val(keterangan_tajwid).change();
                    $('#formModal select[name="nilai_tajwid_penilaian_kegiatan"]').val(data.data
                        .nilai_tajwid_penilaian_kegiatan).change();

                    const keterangan_fasohah = getRange(data.data.nilai_fasohah_penilaian_kegiatan);
                    $('#formModal select[name="keterangan_fasohah"]').val(keterangan_fasohah).change();
                    $('#formModal select[name="nilai_fasohah_penilaian_kegiatan"]').val(data.data
                        .nilai_fasohah_penilaian_kegiatan).change();

                    const keterangan_kelancaran = getRange(data.data
                        .nilai_kelancaran_penilaian_kegiatan);
                    $('#formModal select[name="keterangan_kelancaran"]').val(keterangan_kelancaran)
                        .change();
                    $('#formModal select[name="nilai_kelancaran_penilaian_kegiatan"]').val(data.data
                        .nilai_kelancaran_penilaian_kegiatan).change();

                    // tahsin
                    const keterangan_gunah = getRange(data.data
                        .nilai_ghunnah_penilaian_kegiatan);
                    $('#formModal select[name="keterangan_gunah"]').val(keterangan_gunah)
                        .change();
                    $('#formModal select[name="nilai_ghunnah_penilaian_kegiatan"]').val(data.data
                        .nilai_ghunnah_penilaian_kegiatan).change();

                    const keterangan_mad = getRange(data.data
                        .nilai_mad_penilaian_tahsin);
                    $('#formModal select[name="keterangan_mad"]').val(keterangan_mad)
                        .change();
                    $('#formModal select[name="nilai_mad_penilaian_tahsin"]').val(data.data
                        .nilai_mad_penilaian_tahsin).change();

                    const keterangan_waqof = getRange(data.data
                        .nilai_mad_penilaian_tahsin);
                    $('#formModal select[name="keterangan_waqof"]').val(keterangan_waqof)
                        .change();
                    $('#formModal select[name="nilai_waqof_penilaian_tahsin"]').val(data.data
                        .nilai_mad_penilaian_tahsin).change();

                    $('#formModal textarea[name="keterangan_penilaian_kegiatan"]').val(data.data
                        .keterangan_penilaian_kegiatan);
                    $('#formModal').modal('show');
                },
                error: function(response) {
                    $('#formModal').modal('hide');
                    Swal.fire({
                        title: response.success ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.success ? 'success' : 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // save dan update data
        $('#saveBtn').on('click', function() {
            var id = $("#id_penilaian_kegiatan").val();
            var url = '{{ url('guru/penilaian_kegiatan/update_penilaian') }}/' + id;
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

                    if (kegiatan === "tahfidz") {
                        $('#datatables-ajax-tahfidz').DataTable().ajax.reload();
                    } else {
                        $('#datatables-ajax-tahsin').DataTable().ajax.reload();
                    }

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
    </script>
@endsection
