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
                    Data Periode Sertifikasi
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card">
                                <div class="card-body border-navy">
                                    <form id="dataForm"
                                        enctype="multipart/form-data">
                                        @csrf
										<div class="row">
											<div class="mb-3 col-md-4">
												<label for="inputEmail4">Tahun Ajaran</label>
												<select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="tahun_ajaran" data-bs-toggle="select2" required>
                                                        <option>PILIH</option>
                                                    </select>
                                                    <input type="text" name="id_periode" id="id_periode" hidden>
											</div>
                                            <div class="mb-3 col-md-4">
												<label for="inputEmail4">Taggal Akhir Penilaian Sertifikasi</label>
												<input type="datetime-local" class="form-control" name="tggl_akhir_penilaian" id="tggl_akhir_penilaian" placeholder="Password">
											</div>
                                            <div class="mb-3 col-md-4">
												<label for="inputEmail4">Taggal Terbit Sertifikasi</label>
												<input type="date" class="form-control" name="tggl_sertifikasi" id="tggl_sertifikasi" placeholder="Password">
											</div>
										</div>
                                        <div class="row">
                                            <div class="mb-3 col-md-4">
												<label for="inputPassword4">Sertifikasi</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0 " name="sertifikasi"
                                                    data-bs-toggle="select2" required>
                                                    <option selected>PILIH</option>
                                                    <option value="tahfidz">TAHFIDZ</option>
                                                    <option value="tahsin">TAHSIN</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
												<label for="inputPassword4">Juz</label>
                                                    <select class="form-control select2 mb-4 me-sm-2 mt-0 " name="juz_sertifikasi"
                                                    data-bs-toggle="select2" required>
                                                    <option selected>PILIH</option>
                                                    @for ($i = 1; $i <= 30; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
												<label for="inputEmail4">Sesi Penilaian Sertifikat</label>
                                                <select class="form-control select2 mb-4 me-sm-2 mt-0 " name="sesi_sertifikasi"
                                                    data-bs-toggle="select2" required>
                                                    <option selected>PILIH</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                </select>
											</div>
										</div>
                                        <div class="row">
                                            <div class="mb-3 col-md-4">
												<label for="inputEmail4">file Sertifikat</label>
												<input type="file" class="form-control" name="file_sertifikat" id="file_sertifikat" placeholder="Password">
                                                <span class="text-danger text-sm">File upload jpg</span>
											</div>
                                            <div class="mb-3 col-md-4">
												<label for="inputEmail4">Penanggung Jawab Sertifikasi</label>
												<input type="text" class="form-control" name="tanggungjawab_sertifikasi" id="tanggungjawab_sertifikasi" placeholder="Penanggung Jawab sertifikat">
											</div>
                                            <div class="mb-3 col-md-4 mt-4 text-center">
                                                <button type="button" class="btn btn-primary saveBtn" id="saveBtn">Simpan</button>
                                            </div>
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
                                        <th>Periode</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Periode</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- view sertifikat -->
                        <div class="modal fade" id="viewSertifikat" tabindex="-1" role="dialog" aria-hidden="true"
                            data-bs-keyboard="false" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalLabelUpload">Edit Harga</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body m-3">
                                            <div class="row">
                                                <div class="col-12 col-lg-12">
                                                    <div id="loading-indicator" style="display:none;">Loading...</div>
                                                    <img id="view-image" src="" alt="Dynamic Image" width="840" height="500" style="display:none;" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="button" id="downloadPdf"
                                                class="btn btn-primary">Download PDF</button>
                                        </div>
                                </div>
                            </div>
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
            const selectElements = [
                document.querySelector('select[name="tahun_ajaran"]'),
                document.querySelector('select[name="sertifikasi"]'),
                document.querySelector('select[name="juz_sertifikasi"]'),
                document.querySelector('select[name="sesi_sertifikasi"]'),
            ];

            const inputElements = [
                document.querySelector('input[name="tggl_akhir_penilaian"]'),
                document.querySelector('input[name="tanggungjawab_sertifikasi"]')
            ];
            const saveBtn = document.querySelector('#saveBtn'); // Adjust the selector as needed

            $.ajax({
                url: '{{ url('admin/periode/data_tahun') }}',
                type: 'GET',
                dataType: 'json', // Ensure response is treated as JSON
                success: function(response) {
                    const data = response.data; // Assuming response has a 'data' array
                    const tahun_list = document.querySelector('select[name="tahun_ajaran"]');
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id_tahun_ajaran;
                        option.textContent = item.nama_tahun_ajaran;
                        tahun_list.appendChild(option);
                    });

                    // Initialize Select2 after appending options
                    $(tahun_list).select2();
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
                const allInputsFilled = [
                    ...selectElements,
                    ...inputElements
                ].every(el => el.value.trim() !== '' && el.value.trim() !== 'PILIH');

                saveBtn.disabled = !allInputsFilled;
            }

            [...selectElements, ...inputElements].forEach(element => {
                element.addEventListener('input', checkInputs);
            });

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
                ajax: '{{ url('admin/periode_sertifikasi/data_periode_sertifikasi') }}',
                columns: [{
                        "data": null,
                        "name": "rowNumber",
                        "render": function(data, type, row, meta) {
                            return meta.row +
                                1;
                        }
                    },
                    {
                        data: 'nama_tahun_ajaran',
                        name: 'nama_tahun_ajaran',
                        render: function(data, type, row) {
                            var nama_tahun_ajaran = row.nama_tahun_ajaran.charAt(0).toUpperCase() +
                                row.nama_tahun_ajaran.slice(1);
                            var jenis_periode = row.jenis_periode.trim().toUpperCase();
                            var juz_periode =  row.juz_periode === null ? 0 : row.juz_periode;                           
                            return 'Periode : ' + nama_tahun_ajaran + '<br>' +
                            'Sertifikasi : ' +  jenis_periode + ' JUZ : ' + juz_periode +
                            '<br> Penanggung Jawab : ' + row.tanggungjawab_periode;
                        }

                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            var tanggal_akhir = new Date(row.tggl_akhir_penilaian);                            
                            const options2 = { 
                                day: 'numeric', 
                                month: 'long', 
                                year: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric',
                                second: 'numeric',
                                hour12: false // Use 24-hour format; set to true for 12-hour format
                            };
                            var tanggal_formatted = tanggal_akhir.toLocaleDateString('id-ID', options2);

                            var tanggal = new Date(row.tggl_periode);
                            var options = { day: 'numeric', month: 'long', year: 'numeric' };
                            var tanggal_terbit = tanggal.toLocaleDateString('id-ID', options);

                            return `Terbit Sertifikat : ${tanggal_terbit}<br>
                            <span class="badge ${new Date(row.tggl_akhir_penilaian) < new Date() ? 'bg-danger' : 'bg-success'}">Akhir Penilaian : ${tanggal_formatted}
                            </span> <br>
                             <span class="badge bg-success">Sesi Penilaian : ${row.sesi_periode === null ? 0 : row.sesi_periode}
                            </span>`;
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
                                <button class="btn btn-sm btn-primary viewBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Sertifkat" data-id="${row.id_periode}"><i class="fas fa-eye"></i></button>
                            `;
                            } else {
                                return `
                                <button class="btn btn-sm btn-success updateBtn1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Update Status Aktif" data-id="${row.id_periode}"><i class="fas fa-power-off"></i></button>
                                <button class="btn btn-sm btn-warning editBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data" data-id="${row.id_periode}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-secondary deleteBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data" data-id="${row.id_periode}"><i class="fas fa-trash"></i></button>
                                <button class="btn btn-sm btn-primary viewBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Sertifkat" data-id="${row.id_periode}"><i class="fas fa-eye"></i></button>
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
            Swal.fire({
                title: 'Edit Data',
                text: 'Apakah Anda Ingin Mengedit Data Ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya mengedit data ini'
            }).then((result) => {
                $.ajax({
                    url: '{{ url('admin/periode/edit_periode') }}/' +
                        id, // URL to fetch data for the selected row
                    type: 'GET',
                    success: function(data) {
                        saveBtn.disabled  = false;
                        // Populate the modal fields with the data
                        $('#dataForm input[name="id_periode"]').val(data.data.id_periode);
                        $('select[name="tahun_ajaran"] option').each(function() {
                            if ($(this).val() === data.data.id_tahun_ajaran) {
                                $(this).prop('selected', true);
                            }
                        });
                        $('select[name="tahun_ajaran"]').select2();

                        $('select[name="sertifikasi"] option').each(function() {
                            if ($(this).val() === data.data.jenis_periode) {
                                $(this).prop('selected', true);
                            }
                        });
                        $('select[name="sertifikasi"]').select2();

                        var selectedJuzValue = data.data.juz_periode;
                        $('select[name="juz_sertifikasi"]').val(selectedJuzValue).trigger('change');
                        $('select[name="juz_sertifikasi"]').select2();

                        var selectedValue = data.data.sesi_periode;
                        $('select[name="sesi_sertifikasi"]').val(selectedValue).trigger('change');
                        $('select[name="sesi_sertifikasi"]').select2();

                        $('#dataForm input[name="tggl_akhir_penilaian"]').val(data.data.tggl_akhir_penilaian);
                        $('#dataForm input[name="tggl_sertifikasi"]').val(data.data.tggl_periode);
                        $('#dataForm input[name="tanggungjawab_sertifikasi"]').val(data.data.tanggungjawab_periode);
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

        // save dan update data
        $('#saveBtn').on('click', function() {
            var id = $('#id_periode').val();
            var url = '{{ url('admin/periode_sertifikasi/store_periode_sertifikasi') }}';

            if (id) {
                url = '{{ url('admin/periode_sertifikasi/update_periode_sertifikasi') }}/' + id;
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
                    $('.select2').val(null).trigger('change');
                    $('#datatables-ajax').DataTable().ajax.reload();
                    saveBtn.disabled  = true;
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
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('admin/periode_sertifikasi/delete_periode_sertifikasi') }}/' +
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
                }
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
                        url: '{{ url('admin/periode_sertifikasi/status_periode_sertifikasi') }}/' + id + '/' + status,
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

        // view sertifikat
        $(document).on('click', '.viewBtn', function() {
            $('#ModalLabelUpload').text('Sertifkat');
            var id = $(this).data('id');
            const loadingIndicator = $('#loading-indicator');
            const viewImage = $('#view-image');
            // Open the edit modal and populate it with data
            $.ajax({
                url: '{{ url('admin/periode/edit_periode') }}/' + id, // URL to fetch data for the selected row
                type: 'GET',
                success: function(response) {
                    const imageUrl = '{{ asset('storage/sertifikat') }}/' +response.data.file_periode;
                    viewImage.attr('src', imageUrl).on('load', function() {
                        loadingIndicator.hide(); // Hide loading indicator
                        viewImage.show(); // Show the image
                    });
                    $('#viewSertifikat').modal('show');
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
    </script>
@endsection
