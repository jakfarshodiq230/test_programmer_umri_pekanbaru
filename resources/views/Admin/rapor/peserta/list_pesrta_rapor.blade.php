@extends('Admin.layout')
@section('content')
    <style>
        .border-navy {
            border: 2px solid navy;
            /* Adjust the border width as needed */
            border-radius: 5px;
            /* Optional: Adjust the border radius as needed */
        }

        .profile {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-item {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 10px;
        }

        .profile-item span.label {
            font-weight: bold;
            margin-right: 10px;
        }

        .profile-item span.separator {
            margin-right: 10px;
        }

        .profile-item span.value {
            margin-left: 10px;
        }
    </style>
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title" id="judul_header">
                    Data Peserta Rapor
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body ">
                            <form>
                                <div class="row border-navy">
                                    <div class="col-md-6 profile">
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Tahun Ajaran</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="tahun_ajaran" style="flex: 1;">Andi</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Rapor</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="rapor" style="flex: 1;">Andi</span>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6 profile">
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Jenjang</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="jenjang" style="flex: 1;">Andi</span>
                                        </div>
                                        <div class="profile-item mb-3 d-flex justify-content-between">
                                            <span class="label text-end" style="flex: 1;">Tanggal</span>
                                            <span class="separator">:</span>
                                            <span class="value text-start" id="tanggal" style="flex: 1;">Andi</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card" id="tahfidz">
                        <div class="card-body">
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Pembimbing</th>
                                        <th>Kelas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>No.</th>
                                        <th>Nama</th>
                                        <th>Pembimbing</th>
                                        <th>Kelas</th>
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
        var periode = '{{ $periode }}';
        var jenjang = '{{ $jenjang }}';
        var tahun = '{{ $tahun }}';

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        $(document).ready(function() {
            // identitas
            $.ajax({
                url: '{{ url('peserta_rapor/ajax_list_peserta') }}/' + tahun + '/' + jenjang + '/' + periode,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                   // Ensure data.periode and its properties exist
                    var periode = data.periode || {};
                    var nama_tahun_ajaran = periode.nama_tahun_ajaran || '';
                    var jenis_kegiatan = periode.jenis_periode || '';
                    var jenis_periode = periode.jenis_periode || '';
                    var jenis_jenjang = periode.jenis_kegiatan || '';
                    var tanggal = periode.tggl_periode || '';

                    // Update the HTML elements
                    $('#tahun_ajaran').text(capitalizeFirstLetter(nama_tahun_ajaran));
                    $('#rapor').text(capitalizeFirstLetter(jenis_kegiatan));
                    $('#tanggal').text(capitalizeFirstLetter(tanggal));
                    $('#jenjang').text(capitalizeFirstLetter(jenis_jenjang));
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                }
            });

            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: {
                        url: '{{ url('peserta_rapor/ajax_list_peserta') }}/' +tahun+'/'+jenjang+'/'+periode,
                        dataSrc: 'peserta' // Specify the data source as 'nilai'
                    },
                columns: [{
                        "data": null,
                        "name": "rowNumber",
                        "render": function(data, type, row, meta) {
                            return meta.row +
                                1;
                        }
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                        render: function(data, type, row) {
                            return row.nama_siswa.trim().toUpperCase();
                        }
                    },
                    {
                        data: 'nama_guru',
                        name: 'nama_guru',
                        render: function(data, type, row) {
                            return row.nama_guru.trim().toUpperCase();
                        }
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas',
                        render: function(data, type, row) {
                            return row.nama_kelas.trim().toUpperCase();
                        }
                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            
                                return `
                                <button class="btn btn-sm btn-primary lihatBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Peserta Rapor" 
                                data-id="${row.id_rapor}" data-peserta="${row.id_siswa}" 
                                data-tahun="${row.id_tahun_ajaran}" data-rapor="${row.jenis_periode}" 
                                data-periode="${row.id_periode}"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning downloadBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Rapor" 
                                data-id="${row.id_rapor}" data-peserta="${row.id_siswa}" 
                                data-tahun="${row.id_tahun_ajaran}" data-rapor="${row.jenis_periode}" 
                                data-periode="${row.id_periode}"><i class="fas fa-download"></i></button>
                            `;
                        }
                    },
                ]
            });
        });

        // lihat data
        $(document).on('click', '.lihatBtn', function() {
            var id = $(this).data('id');
            var peserta = $(this).data('peserta');
            var tahun = $(this).data('tahun');
            var rapor = $(this).data('rapor');
            var periode = $(this).data('periode');
            var url= '{{ url('peserta_rapor/detail_peserta') }}/' + id + '/'+ peserta + '/'+ tahun + '/' + rapor + '/' + periode;
            window.location.href = url;
        });
    </script>
@endsection
