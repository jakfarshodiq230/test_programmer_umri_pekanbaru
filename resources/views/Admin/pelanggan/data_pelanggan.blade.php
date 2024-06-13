@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data pelanggan
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div id="progress" class="progress">
                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Usaha</th>
                                        <th>No. HP</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Usaha</th>
                                        <th>No. HP</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{-- add pelanggan --}}
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
                                                        <input type="text" name="id_pelanggan" id="id_pelanggan"
                                                            class="form-control" placeholder="Judul Harga" hidden>
                                                        <input type="text" name="judul_pelanggan" class="form-control"
                                                            placeholder="Judul pelanggan" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>pelanggan Mulai</label>
                                                        <input type="date" name="tanggal_mulai" class="form-control"
                                                            placeholder="Tanggal Mulai" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>pelanggan Akhir</label>
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
                        {{-- end pelanggan --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <!-- Your other content -->
    <script>
        function UpdateStatus(id) {
            $.ajax({
                url: '{{ url('pelanggan/status_pelanggan') }}/' + id + '/1',
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
        $(document).ready(function() {
            $('#progress').hide();
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('pelanggan/data_pelanggan') }}',
                columns: [{
                        data: null,
                        name: 'nomor',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nama_pelanggan',
                        name: 'nama_pelanggan',
                    },
                    {
                        data: 'email_pelanggan',
                        name: 'email_pelanggan',
                    },
                    {
                        data: 'nama_usaha',
                        name: 'nama_usaha',
                        render: function(data, type, row) {
                            return 'Nama : ' + row.nama_usaha + ' <br> Alamat : ' + row
                                .alamat_usaha;
                        }
                    },
                    {
                        data: 'no_hp_usaha',
                        name: 'no_hp_usaha',
                    },
                    {
                        data: null,
                        name: 'counter',
                        render: function(data, type, row) {
                            return 'Daftar : ' + row.tggl_daftar_pelanggan +
                                '<br> Expert :' +
                                row.tggl_batas_pelanggan;

                        }
                    },
                    {
                        data: 'status_pelanggan',
                        name: 'status_pelanggan',
                        render: function(data, type, row) {
                            return data == 1 ?
                                '<span class="badge bg-success">Aktif</span>' :
                                '<span class="badge bg-danger">Tidak Aktif</span>';
                        }
                    },
                    {
                        data: 'status_pelanggan',
                        name: 'status_pelanggan',
                        render: function(data, type, row) {
                            return data == 1 ?
                                `
                            <button class="btn btn-sm btn-danger updateBtn me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.id_pelanggan}" data-status="0"><i class="fas fa-power-off"></i></button>
                            <button class="btn btn-sm btn-secondary deleteBtn me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_pelanggan}"><i class="fas fa-trash"></i></button>` :
                                `
                            <button class="btn btn-sm btn-success updateBtn me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.id_pelanggan}" data-status="1"><i class="fas fa-power-off"></i></button>
                            <button class="btn btn-sm btn-secondary deleteBtn me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_pelanggan}"><i class="fas fa-trash"></i></button>`;
                        }
                    },
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
                            url: '{{ url('pelanggan/data_pelanggan') }}',
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
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah pelanggan');
            $('#dataForm')[0].reset();
            $('#formModal').modal('show');
        });

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
                        url: '{{ url('pelanggan/status_pelanggan') }}/' + id + '/' + (status ? 1 :
                            0),
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
                    url: '{{ url('pelanggan/delete_pelanggan') }}/' +
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
    </script>
@endsection
