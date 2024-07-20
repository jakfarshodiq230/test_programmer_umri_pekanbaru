@extends('Admin.layout')
@section('content')
    <style>
        .border-navy {
            border: 2px solid navy;
            /* Adjust the border width as needed */
            border-radius: 5px;
            /* Optional: Adjust the border radius as needed */
        }
    </style>

    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title" id="judul_header">
                    Data Peserta Kegiatan {{ $judul_3 }}
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item AktifAllBtn" id="AktifAllBtn">AKTIFKAN ALL</button>
                                            <button class="dropdown-item NonAllBtn" id="NonAllBtn">NON AKTIFKAN ALL</button>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" id="addBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Tambah Data"><i class="fas fa-add"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Guru</th>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Guru</th>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- add atau edit guru --}}
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
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label>Tahun Ajaran</label>
                                                            <input type="text" name="tahun_ajaran" id="tahun_ajaran"
                                                                class="form-control" placeholder="Tahun Ajaran"
                                                                value="{{ ucfirst($judul_2->nama_tahun_ajaran) . ' [' . ucfirst($judul_1->jenis_periode) . ']' }}"
                                                                readonly>
                                                            <input type="text" name="id_tahun_ajaran"
                                                                id="id_tahun_ajaran" class="form-control"
                                                                placeholder="id_tahun_ajaran" value="{{ $tahun_ajaran }}"
                                                                hidden>
                                                            <input type="text" name="id_periode" id="id_periode"
                                                                class="form-control" placeholder="id_periode"
                                                                value="{{ $periode }}" hidden>
                                                            <input type="text" name="id_peserta_kegiatan"
                                                                id="id_peserta_kegiatan" class="form-control"
                                                                placeholder="id_peserta_kegiatan" hidden>
                                                        </div>
                                                        <div class="mb-3 error-placeholder">
                                                            <label>Guru</label>
                                                            <select class="form-control select2 " name="guru"
                                                                data-bs-toggle="select2" required>
                                                                <option>PILIH</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label>Peserta</label>
                                                            <select class="form-control select2 " name="peserta"
                                                                data-bs-toggle="select2" required>
                                                                <option>PILIH</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Kelas</label>
                                                            <select class="form-control select2 " name="kelas"
                                                                data-bs-toggle="select2" required>
                                                                <option>PILIH</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="button" id="saveBtn"
                                                    class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- end atau edit guru --}}
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
        var periode = "{{ $periode }}";
        var tahun_ajaran = "{{ $tahun_ajaran }}";
        $('.select2').val(null).trigger('change');
        $('#dataForm')[0].reset();

        $(document).ready(function() {
            $.ajax({
                url: '{{ url('guru/data_guru') }}',
                method: 'GET',
                success: function(data) {
                    var select = $('select[name="guru"]');
                    var selectedId = select.val();
                    select.empty();
                    select.append('<option>PILIH</option>'); // Add default option
                    $.each(data.data, function(key, value) {
                        select.append('<option value="' + value.id_guru + '">' + value
                            .nama_guru + '</option>');
                    });

                    if (selectedId && select.find('option[value="' + selectedId + '"]').length > 0) {
                        select.val(selectedId); // Set selected value
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
            $.ajax({
                url: '{{ url('peserta/data_siswa') }}/' + tahun_ajaran + '/' + periode,
                method: 'GET',
                success: function(data) {
                    var select = $('select[name="peserta"]');
                    select.empty();
                    select.append('<option>PILIH</option>'); // Add default option
                    $.each(data.data, function(key, value) {
                        select.append('<option value="' + value.id_siswa + '">' + value
                            .nama_siswa + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });

            $.ajax({
                url: '{{ url('kelas/data_kelas') }}',
                method: 'GET',
                success: function(data) {
                    var select = $('select[name="kelas"]');
                    select.empty();
                    select.append('<option>PILIH</option>'); // Add default option
                    $.each(data.data, function(key, value) {
                        select.append('<option value="' + value.id_kelas + '">' + value
                            .nama_kelas + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });

        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: "{{ url('peserta/data_peserta') }}/" + periode + "/" + tahun_ajaran,
                columns: [{
                        "data": null,
                        "name": "rowNumber",
                        "render": function(data, type, row, meta) {
                            return meta.row +
                                1;
                        }
                    },
                    {
                        data: 'nama_guru',
                        name: 'nama_guru',
                        render: function(data, type, row) {
                            return row.nama_guru.trim().toUpperCase();
                        }

                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                        render: function(data, type, row) {
                            return row.nama_siswa.trim().toUpperCase();
                        }
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas',
                        render: function(data, type, row) {
                            return row.nama_kelas.trim().toUpperCase();
                        }
                    },
                    {
                        data: 'status_peserta_kegiatan',
                        name: 'status_peserta_kegiatan',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge bg-success">Aktif</span>';
                            } else if (data == 0) {
                                return '<span class="badge bg-danger">Tidak Aktif</span>';
                            } else {
                                return '<span class="badge bg-warning">Hapus</span>';
                            }
                        }

                    },
                    {
                        data: 'status_peserta_kegiatan',
                        name: 'status_peserta_kegiatan',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return `
                                <button class="btn btn-sm btn-danger updateBtn0 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.id_peserta_kegiatan}"><i class="fas fa-power-off"></i></button>
                                <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_peserta_kegiatan}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_peserta_kegiatan}"><i class="fas fa-trash"></i></button>
                            `;
                            } else {
                                return `
                                <button class="btn btn-sm btn-success updateBtn1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.id_peserta_kegiatan}"><i class="fas fa-power-off"></i></button>
                                <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_peserta_kegiatan}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_peserta_kegiatan}"><i class="fas fa-trash"></i></button>
                            `;
                            }
                        }
                    },
                ]
            });
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah Peserta Kegiatan');
            $('#dataForm')[0].reset();
            $('#formModal').modal('show');
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            var id = $(this).data('id');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('peserta/edit_peserta') }}/' +
                    id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    $('#formModal').modal('show');
                    // Populate the modal fields with the data
                    $('#dataForm input[name="id_peserta_kegiatan"]').val(data.data.id_peserta_kegiatan);
                    // Function to populate select options
                    function populateSelectGuru(select, options) {
                        select.empty();
                        select.append('<option>PILIH</option>');
                        $.each(options, function(key, value) {
                            select.append('<option value="' + value.id_guru + '">' + value
                                .nama_guru +
                                '</option>');
                        });
                    }

                    function populateSelectPeserta(select, options) {
                        select.empty();
                        select.append('<option>PILIH</option>');
                        $.each(options, function(key, value) {
                            select.append('<option value="' + value.id_siswa + '">' + value
                                .nama_siswa +
                                '</option>');
                        });
                    }

                    function populateSelectKelas(select, options) {
                        select.empty();
                        select.append('<option>PILIH</option>');
                        $.each(options, function(key, value) {
                            select.append('<option value="' + value.id_kelas + '">' + value
                                .nama_kelas +
                                '</option>');
                        });
                    }

                    // Populate guru select
                    var guruSelect = $('select[name="guru"]');
                    populateSelectGuru(guruSelect, data.data_guru);
                    if (data.data.id_guru) {
                        guruSelect.val(data.data.id_guru);
                    }

                    // Populate peserta select
                    var pesertaSelect = $('select[name="peserta"]');
                    populateSelectPeserta(pesertaSelect, data.data_siswa);
                    if (data.data.id_siswa) {
                        pesertaSelect.val(data.data.id_siswa);
                    }

                    // Populate kelas select
                    var kelasSelect = $('select[name="kelas"]');
                    populateSelectKelas(kelasSelect, data.data_kelas);
                    if (data.data.id_kelas) {
                        kelasSelect.val(data.data.id_kelas);
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
        });

        // save dan update data
        $('#saveBtn').on('click', function() {
            var id = $('#id_peserta_kegiatan').val();
            var url = '{{ url('peserta/store_peserta') }}';

            if (id) {
                url = '{{ url('peserta/update_peserta') }}/' + id;
            }
            var form = $('#dataForm')[0];
            var formData = new FormData(form);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#formModal').modal('hide');
                    $('#datatables-ajax').DataTable().ajax.reload();
                    $('.select2').val(null).trigger('change');
                    $('#dataForm')[0].reset();
                    Swal.fire({
                        title: response.success ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.success ? 'success' : 'error',
                        confirmButtonText: 'OK'
                    });

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

        // hapus data
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
                    url: '{{ url('peserta/delete_peserta') }}/' +
                        id, // URL to delete data for the selected row
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Reload the table data
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

        // update status 
        $(document).on('click', '.updateBtn1, .updateBtn0', function() {
            var id = $(this).data('id');
            var status = $(this).hasClass('updateBtn1') ? 1 : 0; // Determine status based on the class
            Swal.fire({
                title: 'Aktifkan Data',
                text: 'Apakah Anda Ingin Mengaktifkan Data Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya menghapus data ini'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('peserta/status_peserta') }}/' + id + '/' + status,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('.select2').val(null).trigger('change');
                            Swal.fire({
                                title: response.error ? 'Error!' : 'Success!',
                                text: response.message,
                                icon: response.error ? 'error' : 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#datatables-ajax').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            $('.select2').val(null).trigger('change');
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

        // update status  all
        $(document).on('click', '.AktifAllBtn, .NonAllBtn', function() {
            var status = $(this).hasClass('AktifAllBtn') ? 1 : 0; // Determine status based on the class
            Swal.fire({
                title: 'Aktifkan/Non Aktifkan Data',
                text: 'Apakah Anda Ingin Merubah Data Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya Merubah data ini'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('peserta/status_peserta_all') }}/' + tahun_ajaran + '/' + periode + '/' + status,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: response.error ? 'Error!' : 'Success!',
                                text: response.message,
                                icon: response.error ? 'error' : 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#datatables-ajax').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
