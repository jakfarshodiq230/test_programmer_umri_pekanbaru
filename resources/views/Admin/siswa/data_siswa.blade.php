@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data Mahamahasiswa
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
                                        <th>#</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Tempat/Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Tempat/Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{-- add atau edit mahasiswa --}}
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
                                                        <label>NIM</label>
                                                        <input type="text" name="nim_mhs" id="nim_mhs"
                                                            class="form-control" onkeypress="return hanyaAngka(event)"
                                                            placeholder="Nomor Induk Mahasiswa" readonly>
                                                            <div id="nim_mhs-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama_mhs" id="nama_mhs" class="form-control"
                                                            placeholder="Nama" required>
                                                            <div id="nama_mhs-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" name="tanggal_lahir"
                                                            id="tanggal_lahir" class="form-control"
                                                            placeholder="Tanggal Lahir" >
                                                            <div id="tanggal_lahir-error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-6" >
                                                    <div class="mb-3" id="view_pass">
                                                        <label>Password</label>
                                                        <input type="password" name="password" id="password" class="form-control"
                                                            placeholder="Password"
                                                            required>
                                                            <div id="password-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Prodi</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="id_program_studi" id="id_program_studi" data-bs-toggle="select2" required>
                                                            <option value="PILIH">PILIH</option>
                                                        </select>
                                                            <div id="id_program_studi-error" class="invalid-feedback"></div>
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
                        {{-- end atau edit mahasiswa --}}

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
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        function populateDropdownsProdi(selectedId) {
            $.ajax({
                url: '{{ url('admin/mahasiswa/data_mahasiswa') }}',
                type: 'GET',
                success: function(response) {

                    var select = $('select[name="id_program_studi"]');
                    select.empty().append('<option value="">PILIH</option>');

                    $.each(response.prodi, function(key, value) {
                        select.append('<option value="' + value.id + '">' + 
                            value.nama_prodi.trim().toUpperCase() + 
                            '</option>');
                    });

                    if (selectedId) {
                        select.val(selectedId);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                }
            });
        }
        populateDropdownsProdi();
        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('admin/mahasiswa/data_mahasiswa') }}',
                columns: [{
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            return `<img src="{{ asset('assets/admin/img/avatars/avatar.jpg') }}" width="42" height="42" class="rounded-circle my-n1 border border-success border-3" alt="Avatar">`;
                        }
                    },
                    {
                        data: 'nim_mhs',
                        name: 'nim_mhs',
                    },
                    {
                        data: 'nama_mhs',
                        name: 'nama_mhs',
                        render: function(data, type, row) {
                            // Convert tempat_lahir_mahasiswa to start with uppercase letter
                            var nama_mahasiswa = row.nama_mhs.charAt(0)
                                .toUpperCase() + row.nama_mhs.slice(1);

                            // Return formatted string
                            return nama_mahasiswa;
                        }
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir',
                        render: function(data, type, row) {
                            // Convert tempat_lahir_mahasiswa to start with uppercase letter
                            var tanggal_lahir = new Date(row.tanggal_lahir);
                            var options = { day: 'numeric', month: 'long', year: 'numeric' };
                            var tanggal_formatted = tanggal_lahir.toLocaleDateString('id-ID', options);

                            // Return formatted string
                            return tanggal_formatted;
                        }


                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            var nama_prodi = row.nama_prodi.charAt(0)
                                .toUpperCase() + row.nama_prodi.slice(1);
                            return nama_prodi;
                        }
                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.nim_mhs}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.nim_mhs}"><i class="fas fa-trash"></i></button>
                            `;
                        }
                    },
                ]
            });
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah mahasiswa');
            $('#dataForm')[0].reset();
            $('#formModal').modal('show');
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            $('#ModalLabel').text('Edit mahasiswa');
            var id = $(this).data('id');
            $.ajax({
                url: '{{ url('admin/mahasiswa/edit_mahasiswa') }}/' + id, 
                type: 'GET',
                success: function(data) {
                    $('#view_pass').hide();
                    
                    $('#formModal input[name="id_nim_mhs"]').val(data.data.id_nim_mhs);
                    $('#formModal input[name="nim_mhs"]').val(data.data.nim_mhs);
                    $('#formModal input[name="nama_mhs"]').val(data.data.nama_mhs);
                    $('#formModal input[name="tanggal_lahir"]').val(data.data.tanggal_lahir);
                    populateDropdownsProdi(data.data.id_program_studi);
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
            var id = $('#nim_mhs').val();
            var url = '{{ url('admin/mahasiswa/store_mahasiswa') }}';

            if (id) {
                url = '{{ url('admin/mahasiswa/update_mahasiswa') }}/' + id;
            }
            
            var form = $('#dataForm')[0];
            var formData = new FormData(form);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#formModal').modal('hide');
                    if (response.success) {
                        $('#dataForm')[0].reset();
                        $('#datatables-ajax').DataTable().ajax.reload();
                    }
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
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('admin/mahasiswa/delete_mahasiswa') }}/' +
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

    </script>
@endsection
