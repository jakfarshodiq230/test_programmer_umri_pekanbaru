@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data Harga
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-actions float-end">
                                <div>
                                    <button class="btn btn-primary" id="addBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Data"><i
                                            class="fas fa-add"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Harga</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Harga</th>
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
                                    <form method="POST" id="hargaForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hargaModalLabel">Edit Harga</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body m-3">
                                            <div class="row">
                                                <div class="col-12 col-lg-12">
                                                    <div class="mb-3">
                                                        <label>Judul</label>
                                                        <input type="text" name="id_harga" id="id_harga" class="form-control"
                                                            placeholder="Judul Harga" hidden>
                                                        <input type="text" name="judul_harga" class="form-control"
                                                            placeholder="Judul Harga" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Harga</label>
                                                        <input type="text" name="harga" id="harga" class="form-control"
                                                            placeholder="Harga" required>
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
            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join('');
                var ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return 'Rp ' + ribuan;
            }
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                ajax: '{{ url('harga/data_harga') }}',
                columns: [{
                        data: null,
                        name: 'nomor',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'judul_harga',
                        name: 'judul_harga',
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, row) {
                            // Format harga ke format Rupiah
                            var hargaFormatted = formatRupiah(data);
                            return hargaFormatted;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                    <button class="btn btn-sm btn-warning editBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_harga}"><i
                                                        class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_harga}"><i
                                                        class="fas fa-trash"></i></button>
                                `;
                        }
                    },
                ]
            });
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#hargaModalLabel').text('Tambah Harga');
            $('#hargaForm')[0].reset();
            $('#formModal').modal('show');
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            $('#hargaModalLabel').text('Tambah Harga');
            var id = $(this).data('id');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('harga/edit_harga') }}/' + id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    // Populate the modal fields with the data
                    $('#formModal input[name="id_harga"]').val(data.data.id_harga);
                    $('#formModal input[name="judul_harga"]').val(data.data.judul_harga);
                    $('#formModal input[name="harga"]').val(data.data.harga);
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
            var id = $('#id_harga').val();
            var url = '{{ url('harga/store_harga') }}';
            if (id) {
                url = '{{ url('harga/update_harga') }}/' + id;
            }
            $.ajax({
                url: url,
                method: 'POST',
                data: $('#hargaForm').serialize(),
                success: function(response) {
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
                    url: '{{ url('harga/delete_harga') }}/' + id, // URL to delete data for the selected row
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
