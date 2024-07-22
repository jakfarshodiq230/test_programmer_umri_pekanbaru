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
                    Data Pendaftaran Peserta Sertifikasi
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
                                        <span class="label text-end" style="flex: 1;">Pendaftaran</span>
                                        <span class="separator">:</span>
                                        <span class="value text-start" id="pendaftaran" style="flex: 1;">-</span>
                                    </div>
                                </div>
                                <div class="col-md-4 profile">
                                    <div class="profile-item mb-3 d-flex flex-column align-items-center">
                                        <button class="btn btn-outline-primary me-2 addBtn text-end" id="addBtn">
                                            PENDAFTARAN
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <table id="datatables-ajax" class="table table-striped mt-4" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Pembimbing</th>
                                            <th>Penguji</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Pembimbing</th>
                                            <th>Penguji</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                        </div>
                    </div>
                    {{-- add atau edit  --}}
                    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true"
                        data-bs-keyboard="false" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered" role="document">
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
                                            <div class="col-12 col-lg-12">
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
                                                    <input type="text" name="id_kelas" id="id_kelas"
                                                        class="form-control" placeholder="id_kelas" hidden>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Pembimbing</label>
                                                    <input type="text" name="guru" id="guru"
                                                        class="form-control" placeholder="Guru" readonly>
                                                    <input type="text" name="id_guru" id="id_guru"
                                                        class="form-control" placeholder="Guru" hidden>
                                                    <input type="text" name="id_periode" id="id_periode"
                                                        class="form-control" placeholder="id_periode" hidden>
                                                    <input type="text" name="id_tahun" id="id_tahun"
                                                        class="form-control" placeholder="id_tahun" hidden>
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
        var periode = '{{ $periode }}';
        var sertifikasi = '{{ $sertifikasi }}';
        var tahun = '{{ $tahun }}';
        var guru = "{{ session('user')['id']}}";
        function capitalizeFirstLetter(string) {
            return string.toUpperCase();
        }
        function loadPeserta() {
            $.ajax({
                url: '{{ url('guru/daftar_sertifikasi/list_peserta') }}/' + tahun + '/' + sertifikasi + '/' + periode,
                method: 'GET',
                success: function(data) {
                    var select = $('select[name="siswa"]');
                    select.empty().append('<option value="">PILIH</option>');

                    $.each(data.peserta, function(key, value) {
                        select.append('<option value="' + value.id_siswa + '">' + 
                            value.nama_siswa.trim().toUpperCase() + ' [ ' + value.nisn_siswa + ' ]' + 
                            '</option>');
                    });

                    select.change(function() {
                        var selectedId = $(this).val();
                        var selectedSiswa = data.peserta.find(function(peserta) {
                            return peserta.id_siswa == selectedId;
                        });

                        if (selectedSiswa) {
                            $('#kelas').val(selectedSiswa.nama_kelas.trim().toUpperCase());
                            $('#id_kelas').val(selectedSiswa.id_kelas);
                            $('#id_guru').val(selectedSiswa.id_guru);
                            $('#guru').val(selectedSiswa.nama_guru.trim().toUpperCase());
                            $('#id_periode').val(periode);
                            $('#id_tahun').val(tahun);
                        } else {
                            $('#kelas').val('');
                            $('#guru').val('');
                            $('#id_kelas').val('');
                            $('#id_siswa').val('');
                            $('#id_guru').val('');
                            $('#id_periode').val('');
                            $('#id_tahun').val('');
                        }
                    });
                }
            });

            $.ajax({
                url: '{{ url('guru/daftar_sertifikasi/list_peserta') }}/' + tahun + '/' + sertifikasi + '/' + periode,
                method: 'GET',
                success: function(response) {
                    $('#tahun_ajaran').text(response.periode.nama_tahun_ajaran);
                    $('#sertifikasi').text(capitalizeFirstLetter(response.periode.jenis_periode.toUpperCase()));
                    $('#juz').text(response.periode.juz_periode);
                    if (response.periode.status_periode === 0) {
                        $('#addBtn').addClass('disabled');
                        $('.deleteBtn').addClass('disabled');
                        $('#pendaftaran').addClass('text-danger').text('TUTUP');
                    } else {
                        $('#addBtn').removeClass('disabled');
                        $('.deleteBtn').removeClass('disabled');
                        $('#pendaftaran').addClass('text-success').text('BUKA');
                    }
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
                ajax: '{{ url('guru/daftar_sertifikasi/ajax_peserta_daftar') }}/' + tahun + '/' + sertifikasi + '/' + periode,
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
                            return nama_siswa;
                        }
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas',
                        render: function(data, type, row) {
                            var nama_kelas = row.nama_kelas.toUpperCase();
                            return nama_kelas;
                        }
                    },
                    {
                        data: 'pembimbing_nama',
                        name: 'pembimbing_nama',
                        render: function(data, type, row) {
                            var pembimbing_nama = row.pembimbing_nama.toUpperCase();
                            return pembimbing_nama;
                        }
                    },
                    {
                        data: 'penguji_nama',
                        name: 'penguji_nama',
                        render: function(data, type, row) {
                            if (row.penguji_nama) {
                                var penguji_nama = row.penguji_nama.charAt(0)
                                    .toUpperCase() + row.penguji_nama.slice(1);
                                return penguji_nama;
                            } else {
                                return 'MENUNGGU PENGUJI';
                            }
                        }
                    },
                    {
                        data: 'status_peserta_sertifikasi',
                        name: 'status_peserta_sertifikasi',
                        render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-danger deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_peserta_sertifikasi}"><i class="fas fa-trash"></i></button>
                                    <button class="btn btn-sm btn-info lihatBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Nilai Sertifikasi" data-id="${row.id_peserta_sertifikasi}"><i class="fas fa-eye"></i></button>
                                `;
                        }
                    },
                ]
            });
        });

        // dafatar
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Daftar Sertifikasi');
            $('#dataForm')[0].reset();
            $('.select2').val(null).trigger('change');
            $('#formModal').modal('show');
        });

        // save button
        $('#saveBtn').on('click', function() {
            url = '{{ url('guru/daftar_sertifikasi/store_daftar') }}';
            
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
                $.ajax({
                    url: '{{ url('guru/daftar_sertifikasi/ajax_delete_peserta') }}/' +
                        id, // URL to delete data for the selected row
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        loadPeserta();
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
            });
        });
</script>
@endsection
