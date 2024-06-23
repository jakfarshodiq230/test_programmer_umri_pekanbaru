@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data Siswa
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <div>
                                    <button class="btn btn-success" id="setingBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Seting Data Siswa"><i
                                            class="fas fa-cog"></i></button>
                                    <button class="btn btn-warning" id="importBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Import Data"><i class="fas fa-upload"></i></button>
                                    <button class="btn btn-primary" id="addBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Tambah Data"><i class="fas fa-add"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Tempat/Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No. HP</th>
                                        <th>Email</th>
                                        <th>Tahun Masuk</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Tempat/Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No. HP</th>
                                        <th>Email</th>
                                        <th>Tahun Masuk</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{-- add atau edit siswa --}}
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
                                                        <label>NISN</label>
                                                        <input type="text" name="nisn_siswa" id="nisn_siswa"
                                                            class="form-control" onkeypress="return hanyaAngka(event)"
                                                            placeholder="Nomor Induk Nasional">
                                                        <input type="text" name="id_siswa" id="id_siswa"
                                                            class="form-control" placeholder="id_siswa" hidden>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama_siswa" class="form-control"
                                                            placeholder="Nama" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tempat Lahir</label>
                                                        <input type="text" name="tempat_lahir_siswa" class="form-control"
                                                            placeholder="Tempat Lahir" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" name="tanggal_lahir_siswa"
                                                            id="tanggal_lahir_siswa" class="form-control"
                                                            placeholder="Tanggal Lahir">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Foto</label>
                                                        <input type="file" name="foto_siswa" class="form-control"
                                                            placeholder="Foto" required>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-6">
                                                    <div class="mb-3">
                                                        <label>Jenis Kelamin</label>
                                                        <br>
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="jenis_kelamin_siswa" value="L">
                                                            <span class="form-check-label">
                                                                Laki-Laki
                                                            </span>
                                                        </label>
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="jenis_kelamin_siswa" value="P">
                                                            <span class="form-check-label">
                                                                Perempuan
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>No HP</label>
                                                        <input type="text" name="no_hp_siswa" class="form-control"
                                                            placeholder="Nomor HP" onkeypress="return hanyaAngka(event)"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Email</label>
                                                        <input type="email" name="email_siswa" class="form-control"
                                                            placeholder="Email" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tahun Masuk</label>
                                                        <select class="form-control select2" name="tahun_masuk_siswa"
                                                            data-bs-toggle="select2" required>
                                                        </select>
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
                        {{-- end atau edit siswa --}}

                        {{-- import excel siswa --}}
                        <div class="modal fade" id="formModalUpload" tabindex="-1" role="dialog" aria-hidden="true"
                            data-bs-keyboard="false" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form method="POST" id="dataFormUpload" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabelUpload">Edit Harga</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body progres m-3">
                                            <div class="row">
                                                <div class="col-12 col-lg-12">
                                                    <div class="mb-3">
                                                        <label>File Excel</label>
                                                        <input type="file" name="file_siswa" class="form-control"
                                                            placeholder="File Excel" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="button" id="saveBtnUpload"
                                                class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- end import excel siswa --}}

                        {{-- seting siswa --}}
                        <div class="modal fade" id="formModalSeting" tabindex="-1" role="dialog" aria-hidden="true"
                            data-bs-keyboard="false" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form method="POST" id="dataFormSeting" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabelSeting">Edit Harga</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body progres-seting m-3">
                                            <div class="row">
                                                <div class="col-12 col-lg-12">
                                                    <div class="mb-3">
                                                        <label>Tahun Masuk</label>
                                                        <select class="form-control select2" name="tahun_masuk_siswa2"
                                                            data-bs-toggle="select2" required>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Status Siswa</label>
                                                        <select class="form-control select2" name="status_siswa"
                                                            data-bs-toggle="select2" required>
                                                            <option selected>PILIH</option>
                                                            <option value="1">AKTIF</option>
                                                            <option value="0">TIDAK AKTIF</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="button" id="saveBtnSeting"
                                                class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- seting siswa --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <!-- Your other content -->
    <script>
        $('#dataForm')[0].reset();
        $('#dataFormUpload')[0].reset();
        $('#dataFormSeting')[0].reset();
        // tahun option
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.querySelector('select[name="tahun_masuk_siswa"]');
            const selectElement2 = document.querySelector('select[name="tahun_masuk_siswa2"]');
            const currentYear = new Date().getFullYear();
            const startYear = 2000;

            for (let year = currentYear; year >= startYear; year--) {

                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                selectElement.appendChild(option);


                // Create options for selectElement2
                const option2 = document.createElement('option');
                option2.value = year;
                option2.textContent = year;
                selectElement2.appendChild(option2);
            }

            // Initialize select2 if it is being used
            if (typeof $.fn.select2 !== 'undefined') {
                $(selectElement).select2();
                $(selectElement2).select2();
            }
        });

        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('siswa/data_siswa') }}',
                columns: [{
                        data: 'foto_siswa',
                        name: 'foto_siswa',
                        render: function(data, type, row) {
                            return data == null ?
                                `<img src="{{ asset('assets/admin/img/avatars/avatar.jpg') }}" width="42" height="42" class="rounded-circle my-n1" alt="Avatar">` :
                                `<img src="{{ url('storage') }}/${row.foto_siswa}" width="52" height="52" class="rounded-circle my-n1" alt="Avatar">`;
                        }
                    },
                    {
                        data: 'nisn_siswa',
                        name: 'nisn_siswa',
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                        render: function(data, type, row) {
                            // Convert tempat_lahir_siswa to start with uppercase letter
                            var nama_siswa = row.nama_siswa.charAt(0)
                                .toUpperCase() + row.nama_siswa.slice(1);

                            // Return formatted string
                            return nama_siswa;
                        }
                    },
                    {
                        data: 'tanggal_lahir_siswa',
                        name: 'tanggal_lahir_siswa',
                        render: function(data, type, row) {
                            // Convert tempat_lahir_siswa to start with uppercase letter
                            var tempat_lahir_formatted = row.tempat_lahir_siswa.charAt(0)
                                .toUpperCase() + row.tempat_lahir_siswa.slice(1);

                            // Return formatted string
                            return tempat_lahir_formatted + ' <br> ' + row.tanggal_lahir_siswa;
                        }


                    },
                    {
                        data: 'jenis_kelamin_siswa',
                        name: 'jenis_kelamin_siswa',
                        render: function(data, type, row) {
                            if (data == 'L') {
                                return 'LAKI - LAKI';
                            } else {
                                return 'PEREMPUAN';
                            }
                        }
                    },
                    {
                        data: 'no_hp_siswa',
                        name: 'no_hp_siswa',
                    },
                    {
                        data: 'email_siswa',
                        name: 'email_siswa',
                    },
                    {
                        data: 'tahun_masuk_siswa',
                        name: 'tahun_masuk_siswa',
                    },
                    {
                        data: 'status_siswa',
                        name: 'status_siswa',
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
                        data: 'status_siswa',
                        name: 'status_siswa',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return `
                                    <button class="btn btn-sm btn-danger updateBtn0 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.nisn_siswa}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.nisn_siswa}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.nisn_siswa}"><i class="fas fa-trash"></i></button>
                                `;
                            } else {
                                return `
                                    <button class="btn btn-sm btn-success updateBtn1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.nisn_siswa}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.nisn_siswa}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.nisn_siswa}"><i class="fas fa-trash"></i></button>
                                `;
                            }
                        }
                    },
                ]
            });
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah Siswa');
            $('#dataForm')[0].reset();
            $('#formModal').modal('show');
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            $('#ModalLabel').text('Edit Siswa');
            var id = $(this).data('id');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('siswa/edit_siswa') }}/' + id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    // Populate the modal fields with the data
                    $('#formModal input[name="id_siswa"]').val(data.data.id_siswa);
                    $('#formModal input[name="nisn_siswa"]').val(data.data.nisn_siswa);
                    $('#formModal input[name="nama_siswa"]').val(data.data.nama_siswa);
                    $('#formModal input[name="tanggal_lahir_siswa"]').val(data.data
                        .tanggal_lahir_siswa);
                    $('#formModal input[name="tempat_lahir_siswa"]').val(data.data.tempat_lahir_siswa);
                    $('#formModal input[name="jenis_kelamin_siswa"]').each(function() {
                        if ($(this).val() == data.data.jenis_kelamin_siswa) {
                            $(this).prop('checked',
                                true); // Check the radio button with matching value
                        } else {
                            $(this).prop('checked', false); // Uncheck other radio buttons
                        }
                    });
                    $('#formModal input[name="no_hp_siswa"]').val(data.data.no_hp_siswa);
                    $('#formModal input[name="email_siswa"]').val(data.data.email_siswa);
                    $('#formModal input[name="tahun_masuk_siswa"]').val(data.data.tahun_masuk_siswa);
                    //$('#formModal input[name="foto_siswa"]').val(data.data.foto_siswa);
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
            var id = $('#id_siswa').val();
            var url = '{{ url('siswa/store_siswa') }}';

            if (id) {
                url = '{{ url('siswa/update_siswa') }}/' + id;
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
                    $('#dataForm')[0].reset();
                    $('#datatables-ajax').DataTable().ajax.reload();
                    Swal.fire({
                        title: response.success ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.success ? 'success' : 'error',
                        confirmButtonText: 'OK'
                    });

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
                    url: '{{ url('siswa/delete_siswa') }}/' +
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
                        url: '{{ url('siswa/status_siswa') }}/' + id + '/' + status,
                        type: 'DELETE',
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

        // Upload Excel
        $('#importBtn').on('click', function() {
            $('#ModalLabelUpload').text('Import Excel');
            $('#dataFormUpload')[0].reset();
            $('#formModalUpload').modal('show');
        });

        // prosess imprt excel
        $('#saveBtnUpload').on('click', function() {
            var url = '{{ url('siswa/import_siswa') }}';
            var form = $('#dataFormUpload')[0];
            var formData = new FormData(form);

            // Tambahkan progres bar
            var progressBar = $(
                '<div class="progress"><div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div></div>'
            );
            $('.progres').append(progressBar);

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    // Listen to the upload progress.
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            // Update progress bar with the new percentage.
                            progressBar.find('.progress-bar').css('width', percentComplete +
                                '%');
                            progressBar.find('.progress-bar').html(percentComplete.toFixed(2) +
                                '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    $('#dataFormUpload')[0].reset();
                    $('#datatables-ajax').DataTable().ajax.reload();
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
                },
                complete: function() {
                    $('#formModalUpload').modal('hide');
                    progressBar.remove();
                }
            });
        });

        // Seting Siswa
        $('#setingBtn').on('click', function() {
            $('#ModalLabelSeting').text('Seting Siswa');
            $('#dataFormSeting')[0].reset();
            $('#formModalSeting').modal('show');
        });

        // prosess imprt excel
        $('#saveBtnSeting').on('click', function() {
            var url = '{{ url('siswa/seting_siswa') }}';
            // Tambahkan progres bar
            var progressBar = $(
                '<div class="progress"><div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div></div>'
            );
            $('.progres-seting').append(progressBar);

            $.ajax({
                url: url,
                method: 'POST',
                data: $('#dataFormSeting').serialize(),
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    // Listen to the upload progress.
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            // Update progress bar with the new percentage.
                            progressBar.find('.progress-bar').css('width', percentComplete +
                                '%');
                            progressBar.find('.progress-bar').html(percentComplete.toFixed(2) +
                                '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    $('#dataFormSeting')[0].reset();
                    $('#datatables-ajax').DataTable().ajax.reload();
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
                },
                complete: function() {
                    progressBar.remove();
                    $('#formModalSeting').modal('hide');
                }
            });
        });
    </script>
@endsection
