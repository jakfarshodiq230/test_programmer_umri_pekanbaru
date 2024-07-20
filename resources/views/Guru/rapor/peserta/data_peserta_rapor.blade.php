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
                    Data Penilaian Rapor
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
                                        <th>Tanggal</th>
                                        <th>Peserta</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Periode</th>
                                        <th>Tanggal</th>
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
                ajax: '{{ url('guru/penilaian_rapor/data_peserta_rapor') }}',
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
                            var jenis_kegiatan = row.jenis_kegiatan.trim().toUpperCase();
                            var tanggal = new Date(row.tggl_periode);
                            var options = { day: 'numeric', month: 'long', year: 'numeric' };
                            var tanggal_formatted = tanggal.toLocaleDateString('id-ID', options);
                            return 'Periode : ' + nama_tahun_ajaran + '<br>' +
                            'Rapor : ' +  jenis_periode +' '+ jenis_kegiatan +
                            '<br> Penanggung Jawab : ' + row.tanggungjawab_periode +
                            '<br> Tanggal Rapor : ' + tanggal_formatted;
                        }

                    },
                    
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            var tanggal_mulai = new Date(row.tggl_awal_periode);
                            var tanggal_akhir = new Date(row.tggl_akhir_periode);
                            var tanggal = new Date(row.tggl_akhir_penilaian);
                            var options = { day: 'numeric', month: 'long', year: 'numeric' };
                            var tanggal_mulai_1 = tanggal_mulai.toLocaleDateString('id-ID', options);
                            var tanggal_akhir_2 = tanggal_akhir.toLocaleDateString('id-ID', options);
                            var tanggal_formatted = tanggal.toLocaleDateString('id-ID', options);
                            return 'Mulai Rapor : ' + tanggal_mulai_1 + '<br>' +
                            'Akhir Rapor : ' + tanggal_akhir_2 +
                            '<br> Akhir Penilaian : ' + tanggal_formatted;
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
                        data: 'siswa_count',
                        name: 'siswa_count',
                        render: function(data, type, row) {
                            
                                return `
                                <button class="btn btn-sm btn-primary pesertaBtn me-1 ${row.siswa_count === 0 ? 'disabled' : ''} " data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Peserta Rapor" 
                                data-tahun="${row.id_tahun_ajaran}" data-rapor="${row.jenis_periode}" data-periode="${row.id_periode}"><i class="fas fa-users"></i></button>
                            `;
                        }
                    },
                ]
            });
        });

        // lihat data
        $(document).on('click', '.pesertaBtn', function() {
            var tahun = $(this).data('tahun');
            var rapor = $(this).data('rapor');
            var periode = $(this).data('periode');
            var url= '{{ url('guru/penilaian_rapor/list_peserta') }}/' + tahun + '/' + rapor + '/' + periode;
            window.location.href = url;
        });
    </script>
@endsection
