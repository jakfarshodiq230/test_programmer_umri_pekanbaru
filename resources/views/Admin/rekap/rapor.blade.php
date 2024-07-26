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
												<label for="inputEmail4">Periode</label>
												<select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="periode" data-bs-toggle="select2" required>
                                                        <option>PILIH</option>
                                                    </select>
											</div>
											<div class="mb-3 col-md-4">
												<label for="inputEmail4">Kelas</label>
												<select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="kelas" data-bs-toggle="select2" required>
                                                        <option>PILIH</option>
                                                    </select>
											</div>
                                            <div class="mb-3 col-md-4 mt-4 text-center">
                                                <button type="button" class="btn btn-primary downloadBtn" id="downloadBtn">Simpan</button>
                                            </div>
										</div>

									</form>
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
                document.querySelector('select[name="periode"]'),
                document.querySelector('select[name="kelas"]'),
            ];
            const downloadBtn = document.querySelector('#downloadBtn'); // Adjust the selector as needed

            $.ajax({
                url: '{{ url('admin/periode/data_tahun') }}',
                type: 'GET',
                dataType: 'json', 
                success: function(response) {
                    const periode = response.periode; 
                    const periode_list = document.querySelector('select[name="periode"]');
                    periode.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id_periode;
                        option.textContent = item.judul_periode;
                        periode_list.appendChild(option);
                    });
                    $(periode_list).select2();

                    const kelas = response.kelas; 
                    const kelas_list = document.querySelector('select[name="kelas"]');
                    kelas.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id_periode;
                        option.textContent = item.judul_periode;
                        kelas_list.appendChild(option);
                    });
                    $(kelas_list).select2();

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
                ].every(el => el.value.trim() !== '' && el.value.trim() !== 'PILIH');

                saveBtn.disabled = !allInputsFilled;
            }

            [...selectElements, ].forEach(element => {
                element.addEventListener('input', checkInputs);
            });

            checkInputs(); // Initial check
        });
    </script>
@endsection
