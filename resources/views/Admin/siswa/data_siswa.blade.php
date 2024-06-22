@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data Siswa/i
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <div>
                                    <button class="btn btn-warning" id="importBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Import Data"><i class="fas fa-upload"></i></button>
                                    <button class="btn btn-success" id="fotoBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Upload Foto"><i class="fas fa-user"></i></button>
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
                                        <th></th>
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
                                        <th>No.</th>
                                        <th></th>
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
                        {{-- add siswa --}}
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
                                                            class="form-control" placeholder="Nomor Induk Nasional">
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
                                                </div>
                                                <div class="col-6 col-lg-6">
                                                    <div class="mb-3">
                                                        <label>Jenis Kelamin</label>
                                                        <input type="date" name="jenis_kelamin_siswa"
                                                            class="form-control" placeholder="Tanggal Mulai" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>No HP</label>
                                                        <input type="text" name="no_hp_siswa" class="form-control"
                                                            placeholder="Nomor HP" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Email</label>
                                                        <input type="email" name="email_siswa" class="form-control"
                                                            placeholder="Email" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tahun Masuk</label>
                                                        <input type="date" name="tahun_masuk_siswa" class="form-control"
                                                            placeholder="Tanggal Akhir" required>
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
                        {{-- end siswa --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <!-- Your other content -->
    <script>
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
                        data: null,
                        name: 'nomor',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'foto_siswa',
                        name: 'foto_siswa',
                        render: function(data, type, row) {
                            return data == null ?
                                `<img src="{{ url('img/avatars/avatar.jpg') }}" width="32" height="32" class="rounded-circle my-n1" alt="Avatar">` :
                                `<img src="{{ url('storage/siswa/') }}/${row.foto_siswa}" height="32" class="rounded-circle my-n1" alt="Avatar">`;
                        }
                    },
                    {
                        data: 'nisn_siswa',
                        name: 'nisn_siswa',
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                    },
                    {
                        data: 'tanggal_lahir_siswa',
                        name: 'tanggal_lahir_siswa',
                    },
                    {
                        data: 'jenis_kelamin_siswa',
                        name: 'jenis_kelamin_siswa',
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
                            } else if (data == 2) {
                                return '<span class="badge bg-danger">Tidak Aktif</span>';
                            } else {
                                return '<span class="badge bg-secondary">Hapus</span>';
                            }
                        }

                    },
                    {
                        data: 'status_siswa',
                        name: 'status_siswa',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return `
                                    <button class="btn btn-sm btn-danger updateBtn0" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.id_siswa}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_siswa}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_siswa}"><i class="fas fa-trash"></i></button>
                                `;
                            } else {
                                return `
                                    <button class="btn btn-sm btn-success updateBtn1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.id_siswa}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_siswa}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_siswa}"><i class="fas fa-trash"></i></button>
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
            $('#ModalLabel').text('Edit siswa');
            var id = $(this).data('id');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('siswa/edit_siswa') }}/' + id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    // Populate the modal fields with the data
                    $('#formModal input[name="id_siswa"]').val(data.data.id_siswa);
                    $('#formModal input[name="judul_siswa"]').val(data.data.judul_siswa);
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

        // save dan update data
        $('#saveBtn').on('click', function() {
            var id = $('#id_siswa').val();
            var url = '{{ url('siswa/store_siswa') }}';
            if (id) {
                url = '{{ url('siswa/update_siswa') }}/' + id;
            }
            $.ajax({
                url: url,
                method: 'POST',
                data: $('#dataForm').serialize(),
                success: function(response) {
                    console.log(response.data);
                    $('#formModal').modal('hide');
                    $('#datatables-ajax').DataTable().ajax.reload();
                    Swal.fire({
                        title: 'Success!',
                        text: response.massage,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
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

        // update status 
        $(document).on('click', '.updateBtn1', function() {
            var id = $(this).data('id');
            // Make an Ajax call to delete the record
            Swal.fire({
                title: 'Aktifkan Data',
                text: 'Apakah Anda Ingin Mengaktifkan Data Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya menghapus data ini'
            }).then((result) => {
                $.ajax({
                    url: '{{ url('siswa/status_siswa') }}/' + id + '/' +
                        1, // URL to delete data for the selected row
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Reload the table data
                        Swal.fire({
                            title: response.error == true ? 'Error !' : 'Success',
                            text: response.message,
                            icon: response.error == true ? 'error' : 'success',
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
            });
        });

        $(document).on('click', '.updateBtn0', function() {
            var id = $(this).data('id');
            // Make an Ajax call to delete the record
            Swal.fire({
                title: 'Aktifkan Data',
                text: 'Apakah Anda Ingin Mengaktifkan Data Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya menghapus data ini'
            }).then((result) => {
                $.ajax({
                    url: '{{ url('siswa/status_siswa') }}/' + id + '/' +
                        0, // URL to delete data for the selected row
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Reload the table data
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
            });
        });
    </script>
@endsection
