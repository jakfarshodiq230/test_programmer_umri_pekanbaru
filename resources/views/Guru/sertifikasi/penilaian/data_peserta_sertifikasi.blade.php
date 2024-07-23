@extends('Guru.layout')
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
                    Data Penilaian Sertifikasi
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Periode</th>
                                        <th>Peserta</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Periode</th>
                                        <th>Peserta</th>
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

        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('guru/daftar_sertifikasi/data_periode_sertifikasi') }}',
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
                            
                            return `Periode : ${nama_tahun_ajaran} <br>
                            Sertifikasi : ${jenis_periode} JUZ ${row.juz_periode}
                            <br> <span class="badge ${row.tggl_akhir_penilaian < new Date() ? 'bg-danger' : 'bg-success'}">
                                ${row.tggl_akhir_penilaian < new Date() ? 'TUTUP PENILAIAN' : 'BUKA PENILAIAN'}
                            </span>`;

                        }
                    },
                    {
                        data: 'siswa_count',
                        name: 'siswa_count',
                        render: function(data, type, row) {
                            return  row.siswa_count + ' Orang';
                        }

                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            
                                return `
                                <button class="btn btn-sm btn-primary pesertaBtn me-1 " data-bs-toggle="tooltip" data-bs-placement="top" title="Daftar Sertifikasi" 
                                data-tahun="${row.id_tahun_ajaran}" 
                                data-sertifikasi="${row.jenis_periode}" 
                                data-periode="${row.id_periode}"><i class="fas fa-users"> </i></button>
                            `;
                        }
                    },
                ]
            });
        });

        // lihat data
        $(document).on('click', '.pesertaBtn', function() {
            var tahun = $(this).data('tahun');
            var sertifikasi = $(this).data('sertifikasi');
            var periode = $(this).data('periode');
            var url= '{{ url('guru/penilaian_sertifikasi/list_data_sertifikasi') }}/' + tahun + '/' + sertifikasi + '/' + periode;
            window.location.href = url;
        });
    </script>
@endsection
