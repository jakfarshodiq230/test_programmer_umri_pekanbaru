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
                    Data Periode Kegiatan
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
                                                    <div class="input-group-text">Tahun Ajaran</div>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="tahun_ajaran" data-bs-toggle="select2" required style="width: 150px;">
                                                        <option value="PILIH">PILIH</option>
                                                    </select>
                                                    <input type="text" name="id_periode" id="id_periode" hidden>
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <div class="input-group mb-2 me-sm-2">
                                                    <div class="input-group-text">Kegiatan</div>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0 " name="kegiatan"
                                                        data-bs-toggle="select2" required style="width: 150px;">
                                                        <option value="PILIH" selected>PILIH</option>
                                                        <option value="tahfidz">TAHFIDZ</option>
                                                        <option value="tahsin">TAHSIN</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <button type="button" id="saveBtn"
                                                    class="btn btn-primary mb-2 me-sm-2">Simpan</button>
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
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>ID</th>
                                        <th>Periode</th>
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
        $('.select2').val(null).trigger('change');
        $('#dataForm')[0].reset();
        // tahun ajaran
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.querySelector('select[name="tahun_ajaran"]');
            const selectElement2 = document.querySelector('select[name="kegiatan"]');
            const saveBtn = document.getElementById('saveBtn');

            $.ajax({
                url: '{{ url('periode/data_tahun') }}',
                type: 'GET',
                dataType: 'json', // Ensure response is treated as JSON
                success: function(response) {
                    const data = response.data; // Assuming response has a 'data' array
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id_tahun_ajaran;
                        option.textContent = item.nama_tahun_ajaran;
                        selectElement.appendChild(option);
                    });

                    // Initialize Select2 after appending options
                    $(selectElement).select2();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to load data tahun',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            function checkInputs() {
                if (selectElement.value.trim() === 'PILIH' || selectElement2.value.trim() === 'PILIH' || selectElement.value.trim() === '' || selectElement2.value.trim() === '') {
                    saveBtn.disabled = true;
                } else {
                    saveBtn.disabled = false;
                }
            }

            // Use 'change' event for select elements
            $(selectElement).on('change', checkInputs);
            $(selectElement2).on('change', checkInputs);

            checkInputs(); // Initial check
        });



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
                        "data": null,
                        "name": "rowNumber",
                        "render": function(data, type, row, meta) {
                            return meta.row +
                                1;
                        }
                    },
                    {
                        data: 'id_periode',
                        name: 'id_periode',
                    },
                    {
                        data: 'nama_tahun_ajaran',
                        name: 'nama_tahun_ajaran',
                        render: function(data, type, row) {
                            var nama_tahun_ajaran = row.nama_tahun_ajaran.charAt(0).toUpperCase() +
                                row.nama_tahun_ajaran.slice(1);
                            var jenis_periode = row.jenis_periode.trim().toUpperCase();
                            var formatted_string = nama_tahun_ajaran + ' [ ' + jenis_periode + ' ]';
                            return formatted_string;
                        }

                    },
                    {
                        data: 'status_periode',
                        name: 'status_periode',
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
                        data: 'status_periode',
                        name: 'status_periode',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return `
                                <button class="btn btn-sm btn-danger updateBtn0 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.id_periode}"><i class="fas fa-power-off"></i></button>
                                <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_periode}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_periode}"><i class="fas fa-trash"></i></button>
                            `;
                            } else {
                                return `
                                <button class="btn btn-sm btn-success updateBtn1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.id_periode}"><i class="fas fa-power-off"></i></button>
                                <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_periode}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_periode}"><i class="fas fa-trash"></i></button>
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
                url: '{{ url('periode/edit_periode') }}/' +
                    id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    saveBtn.disabled = false;
                    // Populate the modal fields with the data
                    $('#dataForm input[name="id_periode"]').val(data.data.id_periode);
                    $('select[name="tahun_ajaran"] option').each(function() {
                        // Check if the value of the option matches tahun_awal
                        if ($(this).val() === data.data.id_tahun_ajaran) {
                            // Set the selected attribute of the matching option
                            $(this).prop('selected', true);
                        }
                    });
                    $('select[name="tahun_ajaran"]').select2();
                    $('select[name="kegiatan"] option').each(function() {
                        // Check if the value of the option matches tahun_awal
                        if ($(this).val() === data.data.jenis_periode) {
                            // Set the selected attribute of the matching option
                            $(this).prop('selected', true);
                        }
                    });
                    $('select[name="kegiatan"]').select2();
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
            var id = $('#id_periode').val();
            var url = '{{ url('periode/store_periode') }}';

            if (id) {
                url = '{{ url('periode/update_periode') }}/' + id;
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
                    $('.select2').val(null).trigger('change');
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
                    $('.select2').val(null).trigger('change');
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
                    url: '{{ url('periode/delete_periode') }}/' +
                        id, // URL to delete data for the selected row
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Reload the table data
                        $('.select2').val(null).trigger('change');
                        Swal.fire({
                            title: response.success ? 'Success' : 'Error',
                            text: response.message,
                            icon: response.success ? 'success' : 'error',
                            confirmButtonText: 'OK'
                        });
                        $('#datatables-ajax').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        $('.select2').val(null).trigger('change');
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
            console.log(id);
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
                        url: '{{ url('periode/status_periode') }}/' + id + '/' + status,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('.select2').val(null).trigger('change');
                            Swal.fire({
                                title: response.error ? 'Error!' : 'Success!',
                                text: response.message,
                                icon: response.error ? 'error' : 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#datatables-ajax').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            $('.select2').val(null).trigger('change');
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
