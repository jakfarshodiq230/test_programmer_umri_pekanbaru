@extends('Admin.layout')
@section('content')
    <style>
        .dataTables_wrapper .dt-buttons {
            float: left;
            margin-top: 0;
        }

        .synchronize-btn {
            margin-top: 0;
        }
    </style>
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data Akun
                </h1>
            </div>
            <div class="row">
                <div class="card ">
                    @if (Auth::User()->level_user == 'superadmin')
                        <div class="col-lg-12 col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Fomulir Tambah Akun</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="dataForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6 col-lg-6">
                                                <div class="mb-3">
                                                    <label>Pelanngan</label>
                                                    <select class="form-control select2" name="pelanggan" id="pelanggan"
                                                        onchange="updatePengguna(this)" required>
                                                        <option selected>PILIH</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Level</label>
                                                    <select class="form-control select2" name="level_user" id="level_user"
                                                        required>
                                                        <option selected>PILIH</option>
                                                        <option value="kasir">Kasir</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="superadmin">Superadmin</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Nama</label>
                                                    <input type="text" name="nama_user" id="nama_user"
                                                        class="form-control" placeholder="Nama" required readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Password</label>
                                                    <div class="input-group date" id="password-view"
                                                        data-target-input="nearest">
                                                        <input type="password" class="form-control " id="password"
                                                            name="password" data-target="#password-view"
                                                            placeholder="Password" required />
                                                        <div class="input-group-text" onclick="togglePasswordVisibility()">
                                                            <i class="fas fa-eye" id="toggle-icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <div class="mb-3">
                                                    <label>No. HP</label>
                                                    <input type="text" name="no_hp_user" id="no_hp_user"
                                                        class="form-control" placeholder="Nomor HP" required readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Email</label>
                                                    <input type="email" name="email_user" id="email_user"
                                                        class="form-control" placeholder="Email" required readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Alamat</label>
                                                    <textarea name="alamat_user" id="alamat_user" class="form-control" placeholder="Alamat" required readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                            <button type="submit" id="submitBtn" class="btn btn-primary">Simapn</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-12 col-md-12">
                        <div class="card mt-4">
                            <div class="card-header">
                                <div id="progress" class="progress">
                                    <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                @if (Auth::User()->level_user == 'admin')
                                    <div class="card-actions float-end mt-4">
                                        <div>
                                            <button class="btn btn-primary" id="addBtn" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Tambah Akun"><i
                                                    class="fas fa-add"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Instansi</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No HP</th>
                                            <th>Level</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Instansi</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No HP</th>
                                            <th>Level</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            {{-- add periode --}}
                            <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true"
                                data-bs-keyboard="false" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="POST" id="dataFormAkun" enctype="multipart/form-data">
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
                                                            <label>Nama Usaha</label>
                                                            <input type="text" name="id_pelanggan" id="id_pelanggan"
                                                                class="form-control" placeholder="Nama Usaha"
                                                                value="{{ strtoupper(session('nama_usaha')) }}" readonly>
                                                            <input type="text" name="id_user_akun" id="id_user_akun"
                                                                class="form-control" placeholder="Nama Usaha" hidden>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Nama</label>
                                                            <input type="text" name="nama_user_akun"
                                                                id="nama_user_akun" class="form-control"
                                                                placeholder="Nama User" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>No. HP</label>
                                                            <input type="text" name="no_hp_user_akun"
                                                                id="no_hp_user_akun" class="form-control"
                                                                placeholder="No HP" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Alamat</label>
                                                            <input type="text" name="alamat_user_akun"
                                                                id="alamat_user_akun" class="form-control"
                                                                placeholder="Alamat" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Email</label>
                                                            <input type="email" name="email_user_akun"
                                                                id="email_user_akun" class="form-control"
                                                                placeholder="Email" required>
                                                        </div>
                                                        <div class="mb-3" id="password_akun">
                                                            <label>Password</label>
                                                            <input type="password" name="password_user_akun"
                                                                id="password_user_akun" class="form-control"
                                                                placeholder="Password" required>
                                                        </div>
                                                        <div class="mb-3" id="level_akun">
                                                            <label>Level</label>
                                                            <select class="form-control " name="level_user_akun"
                                                                id="level_user_akun" required>
                                                                <option selected>PILIH</option>
                                                                <option value="kasir">Kasir</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" id="saveAkunBtn"
                                                    class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- end periode --}}

                            {{-- pass --}}
                            <div class="modal fade" id="formModalPass" tabindex="-1" role="dialog" aria-hidden="true"
                                data-bs-keyboard="false" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="POST" id="dataFormAkunPass" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Edit Password</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body m-3">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12">
                                                        <div class="mb-3" id="password_akun">
                                                            <label>Password</label>
                                                            <input type="password" name="password_user_akun"
                                                                id="password_user_akun" class="form-control"
                                                                placeholder="Password" required>
                                                            <input type="text" name="id" id="id"
                                                                class="form-control" placeholder="Password" hidden>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" id="saveAkunBtnPass"
                                                    class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        // lihat password
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        $(document).ready(function() {
            //$('#dataForm')[0].reset();
            $('#progress').hide();
            $('#dataFormAkun')[0].reset();
            // Initialize DataTable
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('user/data_user') }}',
                columns: [{
                        data: null,
                        name: 'nomor',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'id_pelanggan',
                        name: 'id_pelanggan',
                        render: function(data, type, row) {
                            if (row.id_pelanggan == "null") {
                                return 'Superadmin';
                            } else {
                                return row.id_pelanggan;
                            }
                        }
                    },
                    {
                        data: 'nama_user',
                        name: 'nama_user'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'no_hp_user',
                        name: 'no_hp_user'
                    },
                    {
                        data: 'level_user',
                        name: 'level_user'
                    },
                    {
                        data: 'status_user',
                        name: 'status_user',
                        render: function(data) {
                            return data == 1 ? '<span class="badge bg-success">Aktif</span>' :
                                '<span class="badge bg-danger">Tidak Aktif</span>';
                        }
                    },
                    {
                        data: 'status_user',
                        name: 'status_user',
                        render: function(data, type, row) {
                            return data == 1 ?
                                `
                        <button class="btn btn-sm btn-danger updateBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.id}" data-status="0"><i class="fas fa-power-off"></i></button>
                        <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-success passBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Password" data-id="${row.id}"><i class="fas fa-key"></i></button>
                        <button class="btn btn-sm btn-info emailBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kirim Email" data-id="${row.email}"><i class="fas fa-envelope"></i></button>
                        <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id}"><i class="fas fa-trash"></i></button>` :
                                `
                        <button class="btn btn-sm btn-success updateBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.id}" data-status="1"><i class="fas fa-power-off"></i></button>
                        <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-success passBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Password" data-id="${row.id}"><i class="fas fa-key"></i></button>
                        <button class="btn btn-sm btn-info emailBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Kirim Email" data-id="${row.email}"><i class="fas fa-envelope"></i></button>
                        <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id}"><i class="fas fa-trash"></i></button>`;
                        }
                    }
                ],
                // button costum + progres bar
                dom: 'Bfrtip',
                buttons: [{
                    text: 'Synchronize',
                    className: 'btn btn-primary synchronize-btn',
                    action: function(e, dt, node, config) {
                        // Show progress bar
                        $('#progress').show();

                        $.ajax({
                            url: '{{ url('user/data_user') }}',
                            type: 'GET',
                            xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                // Listen to the progress event
                                xhr.upload.addEventListener("progress", function(
                                    evt) {
                                    if (evt.lengthComputable) {
                                        var percentComplete = evt.loaded /
                                            evt.total;
                                        // Update progress bar
                                        $('#progress-bar').css('width',
                                            percentComplete * 100 + '%');
                                    }
                                }, false);
                                return xhr;
                            },
                            beforeSend: function() {
                                // Reset progress bar
                                $('#progress-bar').css('width', '0%');
                            },
                            success: function(response) {
                                // Hide progress bar on success
                                $('#progress').hide();
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Berhasil Synhronize data',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                $('#datatables-ajax').DataTable().ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                // Hide progress bar on error
                                $('#progress').hide();
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal Synhronize data',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            },
                            complete: function() {
                                // Hide progress bar on completion
                                $('#progress').hide();
                            }
                        });
                    }
                }]
            });

            // Initialize Select2
            $('.select2').select2();

            // Fetch and update options for level_user
            $.ajax({
                url: '{{ url('user/data_pelanggan') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var $select = $('select[name="pelanggan"]');
                    $select.find('option:not(:first)').remove();
                    $.each(response.data, function(index, value) {
                        // cek user
                        if (value.deleted_at == null) {
                            $select.append('<option value="' + value.id_pelanggan + '">' + value
                                .nama_usaha.toUpperCase() + '</option>');
                        }
                    });
                    $select.trigger('change.select2'); // Reinitialize Select2
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            // simpan data
            $('#dataForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: '{{ url('user/store_user') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.lgo(response);
                        $('#dataForm')[0].reset();
                        $('#datatables-ajax').DataTable().ajax.reload();
                        Swal.fire({
                            title: 'Success!',
                            text: 'Berhasil Simpan Data',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(xhr, status, error) {
                        $('#dataForm')[0].reset();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal Daftar',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // save akun
            $('#dataFormAkun').on('submit', function(event) {
                event.preventDefault();

                var id = $('#id_user_akun').val();
                var url = '{{ url('user/store_user_akun') }}';
                if (id) {
                    url = '{{ url('user/update_user_akun') }}/' + id;
                }
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#dataFormAkun')[0].reset();
                        $('#formModal').modal('hide');
                        $('#datatables-ajax').DataTable().ajax.reload();
                        Swal.fire({
                            title: 'Success!',
                            text: 'Berhasil Simpan Data',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(xhr, status, error) {
                        $('#formModal').modal('hide');
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal Daftar, Email sudah terdaftar',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

        });
        // update option

        function updatePengguna(select) {
            var selectedOption = select.value;
            var namaInput = document.getElementById('nama_user');
            var nohpInput = document.getElementById('no_hp_user');
            var emailInput = document.getElementById('email_user');
            var alamatInput = document.getElementById('alamat_user');
            $.ajax({
                url: '{{ url('user/data_pelanggan_ajax') }}/' + selectedOption,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        namaInput.value = response.data.nama_pelanggan;
                        nohpInput.value = response.data.no_hp_usaha;
                        emailInput.value = response.data.email_pelanggan;
                        alamatInput.value = response.data.alamat_usaha;

                    } else {
                        namaInput.value = "";
                        nohpInput.value = "";
                        emailInput.value = "";
                        alamatInput.value = "";
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // update status
        $(document).on('click', '.updateBtn', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');

            var actionText = status ? 'Aktifkan' : 'Nonaktifkan';
            var confirmText = status ? 'Apakah Anda ingin mengaktifkan data ini?' :
                'Apakah Anda ingin menonaktifkan data ini?';

            Swal.fire({
                title: actionText + ' Data',
                text: confirmText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya ' + actionText.toLowerCase() + ' data ini'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('user/status_user') }}/' + id + '/' + (status ? 1 : 0),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
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

        // delete harga
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
                    url: '{{ url('user/delete_user') }}/' +
                        id, // URL to delete data for the selected row
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Reload the table data
                        Swal.fire({
                            title: 'Success!',
                            text: response.massage,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $('#datatables-ajax').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.massage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah Akun User');
            $('#dataFormAkun')[0].reset();
            $('#formModal').modal('show');
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            $('#ModalLabel').text('Edit Periode');
            var id = $(this).data('id');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('user/edit_user_akun') }}/' + id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    // Populate the modal fields with the data
                    $('#formModal input[name="nama_user_akun"]').val(data.data.nama_user);
                    $('#formModal input[name="no_hp_user_akun"]').val(data.data.no_hp_user);
                    $('#formModal input[name="alamat_user_akun"]').val(data.data.alamat_user);
                    $('#formModal input[name="email_user_akun"]').val(data.data.email);
                    $('#formModal input[name="level_user_akun"]').val(data.data.level_user);
                    $('#formModal input[name="id_user_akun"]').val(data.data.id);
                    $('#password_akun').hide();
                    $('#level_akun').hide();
                    $('#password_user_akun').removeAttr('required');
                    $('#level_user_akun').removeAttr('required');
                    $('#formModal').modal('show');
                },
                error: function(response) {
                    $('#formModal').modal('hide');
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.massage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // edit pass
        $(document).on('click', '.passBtn', function() {
            var id = $(this).data('id');
            $('#formModalPass').modal('show');
            $('#formModalPass input[name="id"]').val(id);
        });

        // save akun
        $('#dataFormAkunPass').on('submit', function(event) {
            event.preventDefault();

            var id = $('#id').val();
            var url = '{{ url('user/update_password_akun') }}/' + id;
            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#dataFormAkunPass')[0].reset();
                    $('#formModalPass').modal('hide');
                    $('#datatables-ajax').DataTable().ajax.reload();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Berhasil Update Password',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    $('#dataFormAkunPass').modal('hide');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal Update Password',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $(document).on('click', '.emailBtn', function() {
            var id = $(this).data('id');
            var url = '{{ url('kirim_verivikasi_akun') }}/' + id;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#datatables-ajax').DataTable().ajax.reload();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Berhasil Kirim Email',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal Kirim Email',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
@endsection
