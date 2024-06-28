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
                    Data Tahun Ajaran
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card">
                                <div class="card-body border-navy">
                                    <form class="row row-cols-md-6 align-items-center" id="dataForm"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12">
                                            <label class="visually-hidden" for="inlineFormInputName2">Awal Tahun
                                                Ajaran</label>
                                            <select class="form-control select2 mb-4 me-sm-2" name="awal_nama_tahun_ajaran"
                                                data-bs-toggle="select2" required>
                                                <option>PILIH</option>
                                            </select>
                                            <input type="text" name="id_tahun_ajaran" id="id_tahun_ajaran"
                                                class="form-control mb-4 me-sm-2" placeholder="id_tahun_ajaran" hidden>
                                        </div>
                                        <div class="col-12">
                                            <label class="visually-hidden" for="inlineFormInputName2">Akhir Tahun
                                                Ajaran</label>
                                            <select class="form-control select2 mb-4 me-sm-2" name="akhir_nama_tahun_ajaran"
                                                data-bs-toggle="select2" required>
                                                <option>PILIH</option>
                                            </select>
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
        // tahun option
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.querySelector('select[name="awal_nama_tahun_ajaran"]');
            const selectElement2 = document.querySelector('select[name="akhir_nama_tahun_ajaran"]');
            const currentYear = new Date().getFullYear();
            const startYear = 2000;

            for (let year = currentYear; year >= startYear; year--) {

                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                selectElement.appendChild(option);


                // Create options for selectElement2
                const option2 = document.createElement('option');
                option2.value = year;
                option2.textContent = year;
                selectElement2.appendChild(option2);
            }

            // Initialize select2 if it is being used
            if (typeof $.fn.select2 !== 'undefined') {
                $(selectElement).select2();
                $(selectElement2).select2();
            }
        });

        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('tahun_ajaran/data_tahun_ajaran') }}',
                columns: [{
                        "data": null,
                        "name": "rowNumber",
                        "render": function(data, type, row, meta) {
                            return meta.row +
                                1;
                        }
                    },
                    {
                        data: 'id_tahun_ajaran',
                        name: 'id_tahun_ajaran',
                    },
                    {
                        data: 'nama_tahun_ajaran',
                        name: 'nama_tahun_ajaran',
                        render: function(data, type, row) {
                            // Convert tempat_lahir_tahun_ajaran to start with uppercase letter
                            var nama_tahun_ajaran = row.nama_tahun_ajaran.charAt(0)
                                .toUpperCase() + row.nama_tahun_ajaran.slice(1);

                            // Return formatted string
                            return nama_tahun_ajaran;
                        }
                    },
                    {
                        data: 'status_tahun_ajaran',
                        name: 'status_tahun_ajaran',
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
                        data: 'status_tahun_ajaran',
                        name: 'status_tahun_ajaran',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return `
                                    <button class="btn btn-sm btn-danger updateBtn0 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Tidak Aktif" data-id="${row.id_tahun_ajaran}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_tahun_ajaran}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_tahun_ajaran}"><i class="fas fa-trash"></i></button>
                                `;
                            } else {
                                return `
                                    <button class="btn btn-sm btn-success updateBtn1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.id_tahun_ajaran}"><i class="fas fa-power-off"></i></button>
                                    <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_tahun_ajaran}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_tahun_ajaran}"><i class="fas fa-trash"></i></button>
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
                url: '{{ url('tahun_ajaran/edit_tahun_ajaran') }}/' +
                    id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    // Populate the modal fields with the data
                    let str = data.data.nama_tahun_ajaran;
                    let parts = str.split("/"); // ["2023", "2024"]
                    let tahun_awal = parts[0]; // "2023"
                    let tahun_akhir = parts[1]; // "2024"
                    $('#dataForm input[name="id_tahun_ajaran"]').val(data.data.id_tahun_ajaran);
                    $('select[name="awal_nama_tahun_ajaran"] option').each(function() {
                        // Check if the value of the option matches tahun_awal
                        if ($(this).val() === tahun_awal) {
                            // Set the selected attribute of the matching option
                            $(this).prop('selected', true);
                        }
                    });
                    $('select[name="awal_nama_tahun_ajaran"]').select2();
                    $('select[name="akhir_nama_tahun_ajaran"] option').each(function() {
                        // Check if the value of the option matches tahun_awal
                        if ($(this).val() === tahun_akhir) {
                            // Set the selected attribute of the matching option
                            $(this).prop('selected', true);
                        }
                    });
                    $('select[name="akhir_nama_tahun_ajaran"]').select2();
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
            var id = $('#id_tahun_ajaran').val();
            var url = '{{ url('tahun_ajaran/store_tahun_ajaran') }}';

            if (id) {
                url = '{{ url('tahun_ajaran/update_tahun_ajaran') }}/' + id;
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
                $.ajax({
                    url: '{{ url('tahun_ajaran/delete_tahun_ajaran') }}/' +
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
                        url: '{{ url('tahun_ajaran/status_tahun_ajaran') }}/' + id + '/' + status,
                        type: 'DELETE',
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
