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
                <h1 class="header-title">
                    Data Kelas
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card">
                                <div class="card-body border-navy">
                                    <form class="row row-cols-md-auto align-items-center" id="dataForm"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12">
                                            <div class="input-group mb-2 me-sm-2">
                                                <div class="input-group-text">Kelas</div>
                                                <input type="text" name="nama_kelas" id="nama_kelas"
                                                    class="form-control me-sm-2" placeholder="A.12">
                                                <input type="text" name="id_kelas" id="id_kelas"
                                                    class="form-control mb-4 me-sm-2" placeholder="id_kelas" hidden>
                                                <input type="text" name="id_periode" id="id_periode" hidden>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" id="saveBtn" class="btn btn-primary mb-2">Tambah
                                                Kelas</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
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
        $('#dataForm')[0].reset();
        document.addEventListener('DOMContentLoaded', function () {
            const saveBtn = document.getElementById('saveBtn');
            const namaKelas = document.getElementById('nama_kelas');

            function checkInputs() {
                if (namaKelas.value.trim() === '') {
                    saveBtn.disabled = true;
                } else {
                    saveBtn.disabled = false;
                }
            }

            namaKelas.addEventListener('input', checkInputs);
            checkInputs();
        });
        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('admin/kelas/data_kelas') }}',
                columns: [{
                        "data": null,
                        "name": "rowNumber",
                        "render": function(data, type, row, meta) {
                            return meta.row +
                            1;
                        }
                    },
                    {
                        data: 'id_kelas',
                        name: 'id_kelas',
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas',
                        render: function(data, type, row) {
                            // Convert tempat_lahir_kelas to start with uppercase letter
                            var nama_kelas = row.nama_kelas.charAt(0)
                                .toUpperCase() + row.nama_kelas.slice(1);

                            // Return formatted string
                            return nama_kelas;
                        }
                    },
                    {
                        data: 'status_kelas',
                        name: 'status_kelas',
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
                        data: 'status_kelas',
                        name: 'status_kelas',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return `
                                    <button class="btn btn-sm btn-danger updateBtn0 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.id_kelas}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_kelas}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_kelas}"><i class="fas fa-trash"></i></button>
                                `;
                            } else {
                                return `
                                    <button class="btn btn-sm btn-success updateBtn1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.id_kelas}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_kelas}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_kelas}"><i class="fas fa-trash"></i></button>
                                `;
                            }
                        }
                    },
                ]
            });
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            var id = $(this).data('id');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('admin/kelas/edit_kelas') }}/' + id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    saveBtn.disabled = false;
                    // Populate the modal fields with the data
                    $('#dataForm input[name="id_kelas"]').val(data.data.id_kelas);
                    $('#dataForm input[name="nama_kelas"]').val(data.data.nama_kelas);
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
            var id = $('#id_kelas').val();
            var url = '{{ url('admin/kelas/store_kelas') }}';

            if (id) {
                url = '{{ url('admin/kelas/update_kelas') }}/' + id;
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
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('admin/kelas/delete_kelas') }}/' +
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
                        url: '{{ url('admin/kelas/status_kelas') }}/' + id + '/' + status,
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
