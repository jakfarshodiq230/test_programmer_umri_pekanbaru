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
                    Rekap Rapor
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
                                                        name="periode" id="periode" data-bs-toggle="select2" required>
                                                        <option value="PILIH">PILIH</option>
                                                    </select>
											</div>
											<div class="mb-3 col-md-4">
												<label for="inputEmail4">Kelas</label>
												<select class="form-control select2 mb-4 me-sm-2 mt-0"
                                                        name="kelas" id="kelas" data-bs-toggle="select2" required>
                                                        <option value="PILIH">PILIH</option>
                                                    </select>
											</div>
                                            <div class="mb-3 col-md-4 mt-4 text-center">
                                                <button type="button" class="btn btn-primary downloadBtn" id="downloadBtn">Proses</button>
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
            const downloadBtn = document.querySelector('#downloadBtn');

            $.ajax({
                url: '{{ url('admin/rekap/rapor/periode') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    populateSelect('periode', response.periode, item => `${item.nama_tahun_ajaran} [ ${item.jenis_periode.toUpperCase()} ${item.jenis_kegiatan.toUpperCase()} ]`);
                    populateSelect('kelas', response.kelas, item => item.nama_kelas.toUpperCase());
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to load data tahun',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            function populateSelect(name, data, formatText) {
                const selectElement = document.querySelector(`select[name="${name}"]`);
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = name === 'periode' ? item.id_periode : item.id_kelas;
                    option.textContent = formatText(item);
                    selectElement.appendChild(option);
                });
                $(selectElement).select2();
            }
        });
        // save dan update data
        $('#downloadBtn').on('click', function() {
            var idPeriode = $('#periode').val();
            var idKelas = $('#kelas').val();
            var url = '{{ url('admin/rekap/rapor/download') }}/' + idPeriode + '/' + idKelas;
            Swal.fire({
                title: 'Mendownload...',
                text: 'Sedang mendownload data, harap tunggu.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: url,
                type: 'GET',
                xhrFields: {
                    responseType: 'blob' // important for file downloads
                },
                success: function(data, status, xhr) {
                    // Extract filename from content-disposition header
                    var disposition = xhr.getResponseHeader('Content-Disposition');
                    var filename = disposition ? disposition.split('filename=')[1] : 'default.xlsx';
                    
                    // Create a link element
                    var link = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    link.href = url;
                    link.download = filename; // Use the filename from header
                    
                    document.body.appendChild(link);
                    link.click();
                    
                    // Cleanup
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(link);
                    Swal.close();
                },
                error: function(xhr, status, error) {
                    console.error('Download failed:', error);
                }
            });
        });

    </script>
@endsection
