@extends('Admin.layout')
@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Data Pembayaran
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
                                        <th>Tanggal</th>
                                        <th>Pembayaran</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Tempat</th>
                                        <th>Pembayaran</th>
                                        <th>Jumlah Bayar</th>
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
                                                        <label>Nama</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="id_mahasiswa" id="id_mahasiswa" data-bs-toggle="select2" required>
                                                            <option value="PILIH">PILIH</option>
                                                        </select>
                                                        <div id="nim_mhs-error" class="invalid-feedback"></div>
                                                        <input type="text" name="id_bayar"
                                                            id="id_bayar" class="form-control"
                                                            placeholder="Tanggal ID" hidden>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" name="tanggal_lahir"
                                                            id="tanggal_lahir" class="form-control"
                                                            placeholder="Tanggal Lahir" readonly>
                                                            <div id="tanggal_lahir-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Prodi</label>
                                                        <input type="text" name="prodi" id="prodi" class="form-control"
                                                            placeholder="prodi"
                                                            required readonly>
                                                            <div id="prodi-error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-6" >
                                                    <div class="mb-3">
                                                        <label>Jenis Bayar</label>
                                                        <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                            name="id_jenis_bayar" id="id_jenis_bayar" data-bs-toggle="select2" required>
                                                            <option value="PILIH">PILIH</option>
                                                        </select>
                                                        
                                                            <div id="id_jenis_bayar-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tanggal Bayar</label>
                                                        <input type="datetime-local" name="tanggal" id="tanggal" class="form-control"
                                                            placeholder="tanggal"
                                                            required>
                                                            <div id="tanggal-error" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Jumlah Bayar</label>
                                                        <input type="text" name="jumlah" id="jumlah" class="form-control"
                                                            placeholder="jumlah"
                                                            required>
                                                            <div id="jumlah-error" class="invalid-feedback"></div>
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

        // function mhs
        function populateDropdownsSiswa(selectedId) {
            $.ajax({
                url: '{{ url('admin/mahasiswa/data_mahasiswa') }}',
                type: 'GET',
                success: function(response) {
                    var select = $('select[name="id_mahasiswa"]');
                    select.empty().append('<option value="">PILIH</option>');

                    $.each(response.data, function(key, value) {
                        select.append('<option value="' + value.nim_mhs + '">' + value.nim_mhs + ' - ' + 
                            value.nama_mhs.trim().toUpperCase() + 
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

            $('select[name="id_mahasiswa"]').on('change', function() {
                var selectedNim = $(this).val();
                if (selectedNim) {
                    $.ajax({
                        url: '{{ url('admin/pembayaran/data_mahasiswa_bayar') }}/' + selectedNim, // Update with the correct URL
                        type: 'GET',
                        success: function(response) {
                                                       
                            $('#prodi').val(response.data.nama_prodi);
                            $('#tanggal_lahir').val(response.data.tanggal_lahir);
                            $('#prodi-error').text('');
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error: ', status, error);
                            $('#prodi').val('');
                            $('#prodi-error').text('Failed to retrieve prodi.');
                        }
                    });
                } else {
                    $('#prodi').val('');
                    $('#prodi-error').text('');
                }
            });
        }

        // function bayar
        function populateDropdownsBayar(selectedId2) {
            $.ajax({
                url: '{{ url('admin/pembayaran/data_pembayaran') }}',
                type: 'GET',
                success: function(response) {
                    // jenis bayara
                    var select2 = $('select[name="id_jenis_bayar"]');
                    select2.empty().append('<option value="">PILIH</option>');

                    $.each(response.JenisBayar, function(key, value) {
                        select2.append('<option value="' + value.id + '">' +  
                            value.nama_pembayaran.trim().toUpperCase() + 
                            '</option>');
                    });

                    if (selectedId2) {
                        select2.val(selectedId2);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                }
            });
        }
        populateDropdownsSiswa();
        populateDropdownsBayar();

        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('admin/pembayaran/data_pembayaran') }}',
                columns: [
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
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
                            var nama_mahasiswa = row.nama_mhs.charAt(0)
                                .toUpperCase() + row.nama_mhs.slice(1);
                            return nama_mahasiswa;
                        }
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        render: function(data, type, row) {
                            var tanggal = new Date(row.tanggal);
                            var options = { day: 'numeric', month: 'long', year: 'numeric' };
                            var tanggal_formatted = tanggal.toLocaleDateString('id-ID', options);

                            // Return formatted string
                            return tanggal_formatted;
                        }
                    },
                    {
                        data: 'nama_pembayaran',
                        name: 'nama_pembayaran',
                        render: function(data, type, row) {
                            var nama_pembayaran = row.nama_pembayaran.charAt(0)
                                .toUpperCase() + row.nama_pembayaran.slice(1);

                            // Return formatted string
                            return nama_pembayaran;
                        }
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                        render: function(data, type, row, meta) {
                            if (type === 'display' || type === 'filter') {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0,
                                }).format(data);
                            }
                            return data;
                        }
                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id}"><i class="fas fa-trash"></i></button>
                            `;
                        }
                    },
                ]
            });
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah pembayaran');
            $('#dataForm')[0].reset();
            $('#formModal').modal('show');
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            $('#ModalLabel').text('Edit pembayaran');
            var id = $(this).data('id');
            $.ajax({
                url: '{{ url('admin/pembayaran/edit_pembayaran') }}/' + id, 
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#formModal input[name="id_bayar"]').val(data.data.IDBayar);
                    populateDropdownsSiswa(data.data.nim_mhs);
                    $('#formModal input[name="tanggal_lahir"]').val(data.data.tanggal_lahir);
                    $('#formModal input[name="prodi"]').val(data.data.nama_prodi);
                    populateDropdownsBayar(data.data.id_jenis_bayar);
                    $('#formModal input[name="tanggal"]').val(data.data.tanggal);
                    $('#formModal input[name="jumlah"]').val(data.data.jumlah);
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
            var id = $('#id_bayar').val();
            var url = '{{ url('admin/pembayaran/store_pembayaran') }}';

            if (id) {
                url = '{{ url('admin/pembayaran/update_pembayaran') }}/' + id;
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
                        url: '{{ url('admin/pembayaran/delete_pembayaran') }}/' +
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