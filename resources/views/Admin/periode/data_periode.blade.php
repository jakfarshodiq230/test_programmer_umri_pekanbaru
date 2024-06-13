@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data Periode
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <div>
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
                                        <th>Judul</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Periode</th>
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
                                                        <label>Judul</label>
                                                        <input type="text" name="id_periode" id="id_periode"
                                                            class="form-control" placeholder="Judul Harga" hidden>
                                                        <input type="text" name="judul_periode" class="form-control"
                                                            placeholder="Judul Periode" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Periode Mulai</label>
                                                        <input type="date" name="tanggal_mulai" class="form-control"
                                                            placeholder="Tanggal Mulai" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Periode Akhir</label>
                                                        <input type="date" name="tanggal_akhir" class="form-control"
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
                        {{-- end periode --}}
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
                ajax: '{{ url('periode/data_periode') }}',
                columns: [{
                        data: null,
                        name: 'nomor',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'judul_periode',
                        name: 'judul_periode',
                    },
                    {
                        data: null,
                        name: 'tanggal',
                        render: function(data, type, row) {
                            return row.tanggal_mulai + ' S/d ' + row.tanggal_akhir;
                        }
                    },
                    {
                        data: 'status_periode',
                        name: 'status_periode',
                        render: function(data, type, row) {
                            return data == 1 ?
                                '<span class="badge bg-success">Aktif</span>' :
                                '<span class="badge bg-danger">Tidak Aktif</span>';
                        }
                    },
                    {
                        data: 'status_periode',
                        name: 'status_periode',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return `
                                    <button class="btn btn-sm btn-danger updateBtn0" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.id_periode}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_periode}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_periode}"><i class="fas fa-trash"></i></button>
                                `;
                            } else {
                                return `
                                    <button class="btn btn-sm btn-success updateBtn1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.id_periode}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_periode}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_periode}"><i class="fas fa-trash"></i></button>
                                `;
                            }
                        }
                    },
                ]
            });
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah Periode');
            $('#dataForm')[0].reset();
            $('#formModal').modal('show');
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            $('#ModalLabel').text('Edit Periode');
            var id = $(this).data('id');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('periode/edit_periode') }}/' + id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    // Populate the modal fields with the data
                    $('#formModal input[name="id_periode"]').val(data.data.id_periode);
                    $('#formModal input[name="judul_periode"]').val(data.data.judul_periode);
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

        // save harga
        $('#saveBtn').on('click', function() {
            var id = $('#id_periode').val();
            var url = '{{ url('periode/store_periode') }}';
            if (id) {
                url = '{{ url('periode/update_periode') }}/' + id;
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
                    url: '{{ url('periode/delete_periode') }}/' +
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

        // update status aktif
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
                    url: '{{ url('periode/status_periode') }}/' + id + '/' +
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
                    url: '{{ url('periode/status_periode') }}/' + id + '/' +
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
