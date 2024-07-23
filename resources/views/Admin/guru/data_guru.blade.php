@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data guru
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <div>
                                    <button class="btn btn-success" id="setingBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Seting Data guru"><i
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
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tempat/Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No. HP</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tempat/Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No. HP</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
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
                                                        <label>NIK</label>
                                                        <input type="text" name="nik_guru" id="nik_guru"
                                                            class="form-control" onkeypress="return hanyaAngka(event)"
                                                            placeholder="Nomor Induk Kepegawaian" required>
                                                        <input type="text" name="id_guru" id="id_guru"
                                                            class="form-control" placeholder="id_guru" hidden>
                                                        <div id="nik_guru-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama_guru" id="nama_guru" class="form-control"
                                                            placeholder="Nama" required>
                                                        <div id="nama_guru-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tempat Lahir</label>
                                                        <input type="text" name="tempat_lahir_guru" id="tempat_lahir_guru" class="form-control"
                                                            placeholder="Tempat Lahir" required>
                                                            <div id="tempat_lahir_guru-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" name="tanggal_lahir_guru"
                                                            id="tanggal_lahir_guru" class="form-control"
                                                            placeholder="Tanggal Lahir">
                                                            <div id="tanggal_lahir_guru-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Foto</label>
                                                        <input type="file" name="foto_guru" id="foto_guru" class="form-control"
                                                            placeholder="Foto" required>
                                                            <div id="foto_guru-error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-6">
                                                    <div class="mb-3">
                                                        <label>Jenis Kelamin</label>
                                                        <br>
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="jenis_kelamin_guru" value="L" checked>
                                                            <span class="form-check-label">
                                                                Laki-Laki
                                                            </span>
                                                        </label>
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="jenis_kelamin_guru" value="P">
                                                            <span class="form-check-label">
                                                                Perempuan
                                                            </span>
                                                        </label>
                                                        
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label>No HP</label>
                                                        <input type="text" name="no_hp_guru" id="no_hp_guru" class="form-control"
                                                            placeholder="Nomor HP" onkeypress="return hanyaAngka(event)"
                                                            required>
                                                            <div id="no_hp_guru-error" class="invalid-feedback"></div>
                                                            
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Email</label>
                                                        <input type="email" name="email_guru" id="email_guru" class="form-control"
                                                            placeholder="Email" required>
                                                            <div id="email_guru-error" class="invalid-feedback"></div>
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
                        {{-- end atau edit guru --}}

                        {{-- import excel guru --}}
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
                                                        <input type="file" name="file_guru" class="form-control"
                                                            placeholder="File Excel" required>
                                                    </div>
                                                    <span>Format upload menggunakan Excel <a href="{{ asset('excel/format_import_guru_new.xlsx') }}" download>Download Disini</a></span>
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
                        {{-- end import excel guru --}}

                        {{-- seting guru --}}
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
                                                        <label>Status guru</label>
                                                        <select class="form-control select2" name="status_guru"
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
                        {{-- seting guru --}}
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


        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('admin/guru/data_guru') }}',
                columns: [{
                        data: 'foto_guru',
                        name: 'foto_guru',
                        render: function(data, type, row) {
                            return data == null ?
                                `<img src="{{ asset('assets/admin/img/avatars/avatar.jpg') }}" width="42" height="42" class="rounded-circle my-n1 ${row.status_guru == 1 ? 'border border-success border-3' : 'border border-danger border-3'}" alt="Avatar">` :
                                `<img src="{{ asset('storage/') }}/${row.foto_guru}" width="52" height="52" class="rounded-circle my-n1 ${row.status_guru == 1 ? 'border border-success border-3' : 'border border-danger border-3'}" alt="Avatar">`;
                        }
                    },
                    {
                        data: 'nik_guru',
                        name: 'nik_guru',
                    },
                    {
                        data: 'nama_guru',
                        name: 'nama_guru',
                        render: function(data, type, row) {
                            // Convert tempat_lahir_guru to start with uppercase letter
                            var nama_guru = row.nama_guru.charAt(0)
                                .toUpperCase() + row.nama_guru.slice(1);

                            // Return formatted string
                            return nama_guru;
                        }
                    },
                    {
                        data: 'tanggal_lahir_guru',
                        name: 'tanggal_lahir_guru',
                        render: function(data, type, row) {
                            // Ensure data is not undefined and is a valid string
                            if (data && typeof data === 'string') {
                                // Convert 'tempat_lahir_guru' to start with uppercase letter
                                var tempat_lahir_formatted = (row.tempat_lahir_guru ? row.tempat_lahir_guru.charAt(0).toUpperCase() + row.tempat_lahir_guru.slice(1) : '');
                                
                                // Parse the date
                                var tanggal_lahir = new Date(data);
                                var options = { day: 'numeric', month: 'long', year: 'numeric' };
                                var tanggal_formatted = tanggal_lahir.toLocaleDateString('id-ID', options);
                                
                                // Return formatted string
                                return tempat_lahir_formatted + ' <br> ' + tanggal_formatted;
                            }
                            return ''; // Return empty string if data is not valid
                        }
                    },
                    {
                        data: 'jenis_kelamin_guru',
                        name: 'jenis_kelamin_guru',
                        render: function(data, type, row) {
                            if (data == 'L') {
                                return 'LAKI - LAKI';
                            } else {
                                return 'PEREMPUAN';
                            }
                        }
                    },
                    {
                        data: 'no_hp_guru',
                        name: 'no_hp_guru',
                    },
                    {
                        data: 'email_guru',
                        name: 'email_guru',
                    },
                    {
                        data: 'status_guru',
                        name: 'status_guru',
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
                        data: 'status_guru',
                        name: 'status_guru',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return `
                                    <button class="btn btn-sm btn-danger updateBtn0 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.nik_guru}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.nik_guru}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.nik_guru}"><i class="fas fa-trash"></i></button>
                                `;
                            } else {
                                return `
                                    <button class="btn btn-sm btn-success updateBtn1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.nik_guru}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.nik_guru}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.nik_guru}"><i class="fas fa-trash"></i></button>
                                `;
                            }
                        }
                    },
                ]
            });
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah guru');
            $('#dataForm')[0].reset();
            $('#formModal').modal('show');
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            $('#ModalLabel').text('Edit guru');
            var id = $(this).data('id');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('admin/guru/edit_guru') }}/' + id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    // Populate the modal fields with the data
                    $('#formModal input[name="id_guru"]').val(data.data.id_guru);
                    $('#formModal input[name="nik_guru"]').val(data.data.nik_guru);
                    $('#formModal input[name="nama_guru"]').val(data.data.nama_guru);
                    $('#formModal input[name="tanggal_lahir_guru"]').val(data.data
                        .tanggal_lahir_guru);
                    $('#formModal input[name="tempat_lahir_guru"]').val(data.data.tempat_lahir_guru);
                    $('#formModal input[name="jenis_kelamin_guru"]').each(function() {
                        if ($(this).val() == data.data.jenis_kelamin_guru) {
                            $(this).prop('checked',
                                true); // Check the radio button with matching value
                        } else {
                            $(this).prop('checked', false); // Uncheck other radio buttons
                        }
                    });
                    $('#formModal input[name="no_hp_guru"]').val(data.data.no_hp_guru);
                    $('#formModal input[name="email_guru"]').val(data.data.email_guru);
                    //$('#formModal input[name="foto_guru"]').val(data.data.foto_guru);
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
            var id = $('#id_guru').val();
            var url = '{{ url('admin/guru/store_guru') }}';

            if (id) {
                url = '{{ url('admin/guru/update_guru') }}/' + id;
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
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    if (response) {
                        let errors = response; // Use the response directly, which contains the errors
                        $('.form-control').removeClass('is-invalid').removeClass('is-valid');
                        $('.invalid-feedback').empty();

                        Object.keys(errors).forEach(function(key) {
                            let input = $("#" + key);
                            let errorDiv = $("#" + key + "-error");
                            input.addClass("is-invalid");
                            errorDiv.html('<strong>' + errors[key][0] + '</strong>'); 
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
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('admin/guru/delete_guru') }}/' +
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
                }
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
                        url: '{{ url('admin/guru/status_guru') }}/' + id + '/' + status,
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

        // Upload Excel
        $('#importBtn').on('click', function() {
            $('#ModalLabelUpload').text('Import Excel');
            $('#dataFormUpload')[0].reset();
            $('#formModalUpload').modal('show');
        });

        // prosess imprt excel
        $('#saveBtnUpload').on('click', function() {
            var url = '{{ url('admin/guru/import_guru') }}';
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

        // Seting guru
        $('#setingBtn').on('click', function() {
            $('#ModalLabelSeting').text('Seting guru');
            $('#dataFormSeting')[0].reset();
            $('#formModalSeting').modal('show');
        });

        // prosess imprt excel
        $('#saveBtnSeting').on('click', function() {
            var url = '{{ url('admin/guru/seting_guru') }}';
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
