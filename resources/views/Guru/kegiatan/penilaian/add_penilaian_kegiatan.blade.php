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
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
        }

        .profile-item {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 5px;
        }

        .profile-item span.label {
            font-weight: bold;
            margin-right: 5px;
        }

        .profile-item span.separator {
            margin-right: 5px;
        }

        .profile-item span.value {
            margin-left: 5px;
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
                                <div class="col-md-3 profile">
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Tahun Ajaran</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="tahun_ajaran_tahfidz"
                                            style="flex: 1;">{{ $tahun->nama_tahun_ajaran }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3 profile">
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Kegiatan</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="kegiatan" style="flex: 1;">
                                            {{ $periode->jenis_periode == 'tahfidz' ? 'Tahfidz/Murajaah' : 'Tahsin/Materikulasi' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2 profile">
                                    <div class="profile-item mb-3 d-flex justify-content-between">
                                        <span class="label text-end" style="flex: 1;">Data</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="countdata" style="flex: 1;">0</span>
                                    </div>
                                </div>
                                <div class="col-md-4 profile">
                                    <div class="profile-item mb-3 d-flex justify-content-center">
                                        <button class="btn btn-outline-primary addBtn me-2  text-end"
                                            id="addBtn">Penilaian
                                        </button>
                                        <button class="btn btn-outline-warning text-start kirimBtn" id="kirimBtn">Kirim
                                            Data </button>
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
                                        <th>Siswa</th>
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
                                        <th>Siswa</th>
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
                                        <th>Siswa</th>
                                        <th>Penilaian</th>
                                        <th>Surah</th>
                                        <th>Ghunnah</th>
                                        <th>Mad</th>
                                        <th>Waqof</th>
                                        <th>Kelancaran</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Siswa</th>
                                        <th>Penilaian</th>
                                        <th>Surah</th>
                                        <th>Ghunnah</th>
                                        <th>Mad</th>
                                        <th>Waqof</th>
                                        <th>Kelancaran</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    {{-- add --}}
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
                                                        class="form-control" placeholder="id_tahun_ajaran"
                                                        value="{{ $tahun->nama_tahun_ajaran }}" readonly>
                                                    <input type="text" name="id_tahun_ajaran" id="id_tahun_ajaran"
                                                        class="form-control" value="{{ $tahun->id_tahun_ajaran }}"
                                                        placeholder="id_tahun_ajaran" hidden>
                                                    <div id="tahun_ajaran-error" class="invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Siswa</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="siswa" id="siswa" data-bs-toggle="select2" required>
                                                        <option value="PILIH">PILIH</option>
                                                    </select>
                                                    <div id="siswa-error" class="invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Surah Awal</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="surah_awal_penilaian_kegiatan" id="surah_awal_penilaian_kegiatan" data-bs-toggle="select2"
                                                        required>
                                                        <option>PILIH</option>
                                                    </select>
                                                    <div id="surah_awal_penilaian_kegiatan-error" class="invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Surah Akhir</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="surah_akhir_penilaian_kegiatan" id="surah_akhir_penilaian_kegiatan" data-bs-toggle="select2"
                                                        required>
                                                        <option>PILIH</option>
                                                    </select>
                                                    <div id="surah_akhir_penilaian_kegiatan-error" class="invalid-feedback"></div>
                                                </div>
                                                <div id="tahfidz_form">
                                                    <div class="mb-3">
                                                        <label>Tajwid</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_tajwid" id="tahun_masuk_siswa" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_tajwid_penilaian_kegiatan\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                        <div id="tahun_masuk_siswa-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Fasohah</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_fasohah" id="keterangan_fasohah" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_fasohah_penilaian_kegiatan\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                        <div id="keterangan_fasohah-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Kelancaran</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_kelancaran_tahfidz" id="keterangan_kelancaran_tahfidz" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_kelancaran_penilaian_kegiatan_tahfidz\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                        <div id="keterangan_kelancaran-error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>

                                                {{-- tahsin --}}
                                                <div id="tahsin_form">
                                                    <div class="mb-3">
                                                        <label>Ghunnah</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_ghunnah" id="keterangan_ghunnah" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_ghunnah_penilaian_kegiatan\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                        <div id="keterangan_ghunnah-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Mad</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_mad" id="keterangan_mad" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_mad_penilaian_tahsin\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                        <div id="keterangan_mad-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Waqof</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_waqof" id="keterangan_waqof" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_waqof_penilaian_tahsin\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                        <div id="keterangan_waqof-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Kelancaran</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="keterangan_kelancaran_tahsin" id="keterangan_kelancaran_tahsin" data-bs-toggle="select2"
                                                            onchange="handleNilaiChange(this, $('select[name=\'nilai_kelancaran_penilaian_kegiatan_tahsin\']'))"
                                                            required>
                                                            <option>PILIH</option>
                                                            <option value="sangat_baik">SANGAT BAIK</option>
                                                            <option value="baik">BAIK</option>
                                                            <option value="cukup">CUKUP</option>
                                                            <option value="kurang">KURANG</option>
                                                        </select>
                                                        <div id="keterangan_kelancaran-error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                {{-- end tahsin --}}
                                                <div class="mb-3">
                                                    <label>Tanggal Penilaian</label>
                                                    <input type="date" name="tanggal_penilaian_kegiatan" id="tanggal_penilaian_kegiatan"
                                                        class="form-control" placeholder="Tanggal Penilaian" required>
                                                        <div id="tanggal_penilaian_kegiatan-error" class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <div class="mb-3">
                                                    <label>Kegiatan</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="jenis_penilaian_kegiatan" id="jenis_penilaian_kegiatan" data-bs-toggle="select2" required>
                                                        <option value="PILIH">PILIH</option>
                                                        @if ($periode->jenis_periode === 'tahfidz')
                                                            <option value="tahfidz">TAHFIDZ</option>
                                                            <option value="murajaah">MURAJA'AH</option>
                                                        @else
                                                            <option value="tahsin">TAHSIN</option>
                                                            <option value="materikulasi">MATERIKULASI</option>
                                                        @endif
                                                    </select>
                                                    <input type="text" name="id_periode" id="id_periode"
                                                        class="form-control" value="{{ $periode->id_periode }}"
                                                        placeholder="id_tahun_ajaran" hidden>
                                                        <div id="jenis_penilaian_kegiatan-error" class="invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Kelas</label>
                                                    <input type="text" name="kelas" id="kelas"
                                                        class="form-control" placeholder="Kelas" readonly>
                                                    <input type="text" name="id_kelas" id="id_kelas"
                                                        class="form-control" placeholder="id_kelas" hidden>
                                                    <input type="text" name="id_peserta_kegiatan"
                                                        id="id_peserta_kegiatan" class="form-control"
                                                        placeholder="id_peserta_kegiatan" hidden>
                                                        <div id="kelas-error" class="invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Ayat Awal</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="ayat_awal_penilaian_kegiatan" id="ayat_awal_penilaian_kegiatan" data-bs-toggle="select2"
                                                        required>
                                                        <option>PILIH</option>
                                                    </select>
                                                    <div id="ayat_awal_penilaian_kegiatan-error" class="invalid-feedback"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Ayat Akhir</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="ayat_akhir_penilaian_kegiatan" id="ayat_akhir_penilaian_kegiatan" data-bs-toggle="select2"
                                                        required>
                                                        <option>PILIH</option>
                                                    </select>
                                                    <div id="ayat_akhir_penilaian_kegiatan-error" class="invalid-feedback"></div>
                                                </div>
                                                <!-- tahfidz -->
                                                <div id="tahfidz_form_keterangan">
                                                    <div class="mb-3">
                                                        <label>Nilai Tajwid</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_tajwid_penilaian_kegiatan" id="nilai_tajwid_penilaian_kegiatan"
                                                            data-bs-toggle="select2" required>
                                                            <option>PILIH</option>
                                                        </select>
                                                        <div id="nilai_tajwid_penilaian_kegiatan-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai Fasohah</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_fasohah_penilaian_kegiatan" id="nilai_fasohah_penilaian_kegiatan"
                                                            data-bs-toggle="select2" required>
                                                            <option>PILIH</option>
                                                        </select>
                                                        <div id="nilai_fasohah_penilaian_kegiatan-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai Kelancaran</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_kelancaran_penilaian_kegiatan_tahfidz" id="nilai_kelancaran_penilaian_kegiatan_tahfidz"
                                                            data-bs-toggle="select2" required>
                                                            <option>PILIH</option>
                                                        </select>
                                                        <div id="nilai_kelancaran_penilaian_kegiatan_tahfidz-error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                {{-- tahsin --}}
                                                <div id="tahsin_form_keterangan">
                                                    <div class="mb-3">
                                                        <label>Nilai Ghunnah</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_ghunnah_penilaian_kegiatan" id="nilai_ghunnah_penilaian_kegiatan"
                                                            data-bs-toggle="select2" required>
                                                            <option>PILIH</option>
                                                        </select>
                                                        <div id="nilai_ghunnah_penilaian_kegiatan-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai Mad</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_mad_penilaian_tahsin" id="nilai_mad_penilaian_tahsin" data-bs-toggle="select2"
                                                            required>
                                                            <option>PILIH</option>
                                                        </select>
                                                        <div id="nilai_mad_penilaian_tahsin-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai Waqof</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="nilai_waqof_penilaian_tahsin" id="nilai_waqof_penilaian_tahsin" data-bs-toggle="select2"
                                                            required>
                                                            <option>PILIH</option>
                                                        </select>
                                                        <div id="nilai_waqof_penilaian_tahsin-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nilai Kelancaran</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0 "
                                                            name="nilai_kelancaran_penilaian_kegiatan_tahsin" id="nilai_kelancaran_penilaian_kegiatan_tahsin"
                                                            data-bs-toggle="select2" required>
                                                            <option>PILIH</option>
                                                        </select>
                                                        <div id="nilai_kelancaran_penilaian_kegiatan_tahsin-error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>

                                                {{-- end tahsin --}}
                                                <div class="mb-3">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan_penilaian_kegiatan" id="keterangan_penilaian_kegiatan" class="form-control" placeholder="Keterangan" required></textarea>
                                                    <div id="keterangan_penilaian_kegiatan-error" class="invalid-feedback"></div>
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
        $('#dataForm')[0].reset();
        $('#tahsin_form').hide();
        $('#tahsin_form_keterangan').hide();
        $('#tahfidz_form').hide();
        $('#tahfidz_form_keterangan').hide();
        $('#kirimBtn').hide();
        // ajax datatabel
        $('#tahfidz').hide();
        $('#tahsin').hide();
        

        $(document).ready(function() {
            var periode = "{{ $periode->id_periode }}";
            var tahun = "{{ $tahun->id_tahun_ajaran }}";
            var guru = "{{ session('user')['id'] }}";
            var kegiatan = "{{ $periode->jenis_periode }}";
            if (kegiatan === 'tahfidz') {
                $('#tahfidz').show();
                $('#datatables-ajax-tahfidz').DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: "{{ url('guru/penilaian_kegiatan/data_penilaian_kegiatan_sm') }}/" + periode +
                            '/' + guru + '/' + kegiatan,
                        error: function(xhr, error, thrown) {
                            console.log("AJAX error:", error);
                            console.log("Thrown error:", thrown);
                        }
                    },

                    columns: [{
                            "data": null,
                            "name": "rowNumber",
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'nama_siswa',
                            name: 'nama_siswa',
                            render: function(data, type, row) {
                                return row.nama_siswa.trim().toUpperCase()+'<br>'+row.nisn_siswa;
                            }
                        },
                        {
                            data: 'jenis_penilaian_kegiatan',
                            name: 'jenis_penilaian_kegiatan',
                            render: function(data, type, row) {
                                return row.jenis_penilaian_kegiatan.trim().toUpperCase();
                            }
                        },
                        {
                            data: 'surah_awal_penilaian_kegiatan',
                            name: 'surah_awal_penilaian_kegiatan',
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
                                    <button class="btn btn-sm btn-danger deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" 
                                    data-id_penialain="${row.id_penilaian_kegiatan}">
                                    <i class="fas fa-trash"></i></button>
                                    `;
                            }
                        }
                    ],
                    drawCallback: function(settings) {
                        var api = this.api();
                        var count = api.data().count();
                        $('#countdata').text(count);
                        if (count > 0) {
                            $('#kirimBtn').show()
                        }
                    }
                });
            } else {
                $('#tahsin').show();
                console.log("{{ url('guru/penilaian_kegiatan/data_penilaian_kegiatan_sm') }}/" + periode +
                            '/' + guru + '/' + kegiatan);
                $('#datatables-ajax-tahsin').DataTable({
                    processing: true,
                    serverSide: false,
                    retrieve: false,
                    destroy: true,
                    responsive: true,
                    ajax: {
                        url: "{{ url('guru/penilaian_kegiatan/data_penilaian_kegiatan_sm') }}/" + periode +
                            '/' + guru + '/' + kegiatan,
                        error: function(xhr, error, thrown) {
                            console.log("AJAX error:", error);
                            console.log("Thrown error:", thrown);
                        }
                    },

                    columns: [{
                            "data": null,
                            "name": "rowNumber",
                            "render": function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'nama_siswa',
                            name: 'nama_siswa',
                            render: function(data, type, row) {
                                return row.nama_siswa.trim().toUpperCase()+'<br>'+row.nisn_siswa;
                            }
                        },
                        {
                            data: 'jenis_penilaian_kegiatan',
                            name: 'jenis_penilaian_kegiatan',
                            render: function(data, type, row) {
                                return row.jenis_penilaian_kegiatan.trim().toUpperCase();
                            }
                        },
                        {
                            data: 'surah_awal_penilaian_kegiatan',
                            name: 'surah_awal_penilaian_kegiatan',
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
                                    <button class="btn btn-sm btn-danger deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" 
                                    data-id_penialain="${row.id_penilaian_kegiatan}">
                                    <i class="fas fa-trash"></i></button>
                                    `;
                            }
                        }
                    ],
                    drawCallback: function(settings) {
                        var api = this.api();
                        var count = api.data().count();
                        $('#countdata').text(count);
                        if (count > 0) {
                            $('#kirimBtn').show()
                        }
                    }
                });
            }
        });

        var judul = "{{ $judul_3 }}";
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
       
        var kegiatan = "{{ $periode->jenis_periode }}";
        if (kegiatan === "tahfidz") {
            $('#tahfidz_form').show();
            $('#tahfidz_form_keterangan').show();
        } else {
            $('#tahsin_form').show();
            $('#tahsin_form_keterangan').show();

        }

        $(document).ready(function() {
            var periode = "{{ $periode->id_periode }}";
            var tahun = "{{ $tahun->id_tahun_ajaran }}";
            var guru = "{{ session('user')['id'] }}";
            var kegiatan = "{{ $periode->jenis_periode }}";
            $.ajax({
                url: '{{ url('guru/penilaian_kegiatan/data_siswa') }}/' + tahun + '/' + periode + '/' +
                    guru,
                method: 'GET',
                success: function(data) {
                    var select = $('select[name="siswa"]');
                    select.empty();
                    select.append('<option value="PILIH" selected>PILIH</option>'); // Add default option
                    $.each(data.siswa, function(key, value) {
                        select.append('<option value="' + value.id_siswa + '">' + value
                            .nama_siswa.trim().toUpperCase() + ' [ ' + value.nisn_siswa +
                            ' ]' + '</option>');
                    });
                    // Update #kelas text when an option is selected
                    select.change(function() {
                        var selectedId = $(this).val();
                        var selectedSiswa = data.siswa.find(function(siswa) {
                            return siswa.id_siswa == selectedId;
                        });
                        if (selectedSiswa) {
                            $('#kelas').val(selectedSiswa.nama_kelas.trim().toUpperCase());
                            $('#id_kelas').val(selectedSiswa.id_kelas);
                            $('#id_peserta_kegiatan').val(selectedSiswa.id_peserta_kegiatan);
                        } else {
                            $('#kelas').val(''); // Handle case where no student is selected
                        }
                    });

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

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah Penilaian ' + judul);
            $('#dataForm')[0].reset();
            $('#formModal').modal('show');
        });

        // save dan update data
        $('#saveBtn').on('click', function() {
            var url = '{{ url('guru/penilaian_kegiatan/store_penilaian') }}';
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
                        url: '{{ url('guru/penilaian_kegiatan/hapus_data_penilaian_kegiatan') }}/' +
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

        // kirim data
        $(document).on('click', '.kirimBtn', function() {
            var periode = "{{ $periode->id_periode }}";
            var tahun = "{{ $tahun->id_tahun_ajaran }}";
            var guru = "{{ session('user')['id'] }}";
            var kegiatan = "{{ $periode->jenis_periode }}";
            Swal.fire({
                title: 'Kirim Data',
                text: 'Apakah Anda Ingin Mengirim Semua Data Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya mengirim semua data ini'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengirim...',
                        text: 'Sedang mengirim data, harap tunggu.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: '{{ url('guru/penilaian_kegiatan/kirim_data_penilaian_kegiatan') }}/' +
                            periode + '/' + guru + '/' + kegiatan,
                        type: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close(); // Close the loading dialog
                            Swal.fire({
                                title: response.success ? 'Sukses' : 'Error',
                                text: response.message,
                                icon: response.success ? 'success' : 'error',
                                confirmButtonText: 'OK'
                            });

                            if (kegiatan === "tahfidz") {
                                $('#datatables-ajax-tahfidz').DataTable().ajax.reload();
                            } else {
                                $('#datatables-ajax-tahsin').DataTable().ajax.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.close(); // Close the loading dialog
                            Swal.fire({
                                title: 'Error',
                                text: xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat mengirim data.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });

                            if (kegiatan === "tahfidz") {
                                $('#datatables-ajax-tahfidz').DataTable().ajax.reload();
                            } else {
                                $('#datatables-ajax-tahsin').DataTable().ajax.reload();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
