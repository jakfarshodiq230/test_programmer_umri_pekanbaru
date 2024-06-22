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
                                    <button class="btn btn-primary" id="addBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Tambah Foto"><i class="fas fa-add"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="dataFoto" class="col-4 col-md-4 col-lg-4">
                                <div class="card">
                                    <img class="card-img-top fotoSiswa" src="{{ url('storage/public/siswa/1234567890-sertifikat tahfizh 2324-01-01.png') }}" alt="foto siswa">
                                    <div class="card-header">
                                        <h5  class="card-title mb-0 namaSiswa">nama</h5>
                                    </div>
                                    <div class="card-body">
                                        <button class="btn btn-sm btn-warning editBtn" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit Data" data-id="${row.nisn_siswa}"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-secondary deleteBtn" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Hapus Data" data-id="${row.nisn_siswa}"><i
                                                class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- add siswa --}}
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
                                                        <label>Nama</label>
                                                        <select class="form-control select2" name="nama_siswa"
                                                            id="nama_siswa" data-bs-toggle="select2" required>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Foto</label>
                                                        <input type="file" id="foto_siswa" name="foto_siswa"
                                                            class="form-control" placeholder="Tempat Lahir" required>
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
        $('#dataFoto').hide();
        // option ajax siswa
        $(document).ready(function() {
            // Assuming you have a function to fetch data from your server
            function fetchData() {
                return $.ajax({
                    url: '{{ url('siswa/data_siswa') }}', // Replace with your actual endpoint
                    type: 'GET', // Or 'POST' depending on your server setup
                    dataType: 'json', // Change the datatype as per your response
                });
            }

            // Function to populate the <select> with options
            function populateSelect(response) {
                var select = $('#nama_siswa');
                select.empty();

                $.each(response.data, function(index, item) {
                    select.append('<option value="' + item.nisn_siswa + '">' + item.nama_siswa +
                        '</option>');
                });
            }

            // Fetch data and populate <select> on page load
            fetchData().done(function(response) {
                populateSelect(response);
            }).fail(function() {
                console.log('Failed to fetch data.');
            });
        });


        $(document).ready(function() {
            // menampilkan data
            $.ajax({
                url: '{{ url('siswa/foto_siswa_data') }}', // URL to fetch data from
                type: 'GET', // HTTP method
                dataType: 'json', // Expected data type from server
                success: function(response) {
                    if (response.data != '') {
                        $.each(response.data, function(index, item) {
                            // Update namaSiswa text (example assuming only one student is fetched)
                            $('.namaSiswa').text(item.nama_siswa);

                            // Update fotoSiswa source attribute (example assuming only one student is fetched)
                            // var fotoLink = "{{ asset('storage') }}/" + item.foto_siswa;
                            // $('.fotoSiswa').attr('src', fotoLink);

                        });
                    } else {
                        $('#dataFoto').hide();
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: response.success ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.success ? 'success' : 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Add Button
        $('#addBtn').on('click', function() {
            $('#ModalLabel').text('Tambah Foto Siswa');
            $('#dataForm')[0].reset();
            $('#formModal').modal('show');
        });

        // editData
        $(document).on('click', '.editBtn', function() {
            $('#ModalLabel').text('Edit Siswa');
            var id = $(this).data('id');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('siswa/edit_siswa') }}/' + id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(data) {
                    // Populate the modal fields with the data
                    $('#formModal input[name="id_siswa"]').val(data.data.id_siswa);
                    $('#formModal input[name="nisn_siswa"]').val(data.data.nisn_siswa);
                    $('#formModal input[name="nama_siswa"]').val(data.data.nama_siswa);
                    $('#formModal input[name="tanggal_lahir_siswa"]').val(data.data
                        .tanggal_lahir_siswa);
                    $('#formModal input[name="tempat_lahir_siswa"]').val(data.data.tempat_lahir_siswa);
                    $('#formModal input[name="jenis_kelamin_siswa"]').each(function() {
                        if ($(this).val() == data.data.jenis_kelamin_siswa) {
                            $(this).prop('checked',
                                true); // Check the radio button with matching value
                        } else {
                            $(this).prop('checked', false); // Uncheck other radio buttons
                        }
                    });
                    $('#formModal input[name="no_hp_siswa"]').val(data.data.no_hp_siswa);
                    $('#formModal input[name="email_siswa"]').val(data.data.email_siswa);
                    $('#formModal input[name="tahun_masuk_siswa"]').val(data.data.tahun_masuk_siswa);
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
            var id = $('#id_siswa').val(); // Assuming you have an ID field if updating
            var url = id ? '{{ url('siswa/update_siswa') }}/' + id : '{{ url('siswa/store_foto_siswa') }}';

            var formData = new FormData($('#dataForm')[0]); // Create FormData object from the form

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false, // Important: tell jQuery not to process the data
                contentType: false, // Important: tell jQuery not to set contentType
                success: function(response) {
                    $('#formModal').modal('hide');
                    Swal.fire({
                        title: response.success ? 'Success' : 'Error',
                        text: response.message,
                        icon: response.success ? 'success' : 'error',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    $('#formModal').modal('hide');
                    Swal.fire({
                        title: 'Error',
                        text: xhr.responseText,
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
    </script>
@endsection
