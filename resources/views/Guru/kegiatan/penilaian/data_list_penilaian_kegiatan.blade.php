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
                <h1 class="header-title" id="judul_header">
                    Data Penialian Kegiatan {{ $judul_3 }}
                </h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body">
                            <table id="datatables-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Guru</th>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Guru</th>
                                        <th>Siswa</th>
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
        var periode = "{{ $periode }}";
        var tahun_ajaran = "{{ $tahun_ajaran }}";
        var guru = "{{ session('user')['id']}}";

        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: {
                    url: "{{ url('guru/penilaian_kegiatan/data_penilaian_kegiatan') }}/" + periode + "/" + tahun_ajaran + '/' + guru,
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
                        data: 'nama_guru',
                        name: 'nama_guru',
                        render: function(data, type, row) {
                            return row.nama_guru.trim().toUpperCase();
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
                        data: 'nama_kelas',
                        name: 'nama_kelas',
                        render: function(data, type, row) {
                            return row.nama_kelas.trim().toUpperCase();
                        }
                    },
                    {
                        data: 'status_peserta_kegiatan',
                        name: 'status_peserta_kegiatan',
                        render: function(data, type, row) {
                                return `
                                <button class="btn btn-sm btn-info detailBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Data" 
                                data-id_tahun="${row.id_tahun_ajaran}"
                                data-id_periode="${row.id_periode}"
                                data-id_siswa="${row.id_siswa}"
                                data-id_guru="${row.id_guru}"
                                data-id_kelas="${row.id_kelas}"
                                >
                                <i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-secondary printBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Cettak Kartu Kegiatan" 
                                data-peserta="${row.id_siswa}" 
                                data-tahun="${row.id_tahun_ajaran}" 
                                data-jenjang="${row.jenis_periode}" 
                                data-periode="${row.id_periode}"
                                >
                                <i class="fas fa-print"></i></button>
                            `;
                        }
                    },
                ]
            });
        });

        // detail nilai
        $(document).on('click', '.detailBtn', function() {
            var id_tahun = $(this).data('id_tahun');
            var id_periode = $(this).data('id_periode');
            var id_siswa = $(this).data('id_siswa');
            var id_guru = $(this).data('id_guru');
            var id_kelas = $(this).data('id_kelas');
            // Make an Ajax call to delete the record
            Swal.fire({
                title: 'Penilaian',
                text: 'Apakah Anda Ingin Melihat Penilaian?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya akan melihat data penilaian'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('guru/penilaian_kegiatan/data_detail_periode_penilaian_kegiatan') }}/"
                    + id_tahun + "/" 
                    + id_periode + "/"
                    + id_siswa + "/"
                    + id_guru + "/"
                    + id_kelas ;
                    window.location.href = url;
                }
            });
        });

                // cetak rapor
        $(document).on('click', '.printBtn', function() {
            var peserta = $(this).data('peserta');
            var tahun = $(this).data('tahun');
            var jenjang = $(this).data('jenjang');
            var periode = $(this).data('periode');
            var url= '{{ url('guru/penilaian_kegiatan/cetak_kartu') }}/'+ peserta + '/'+ tahun + '/' + jenjang + '/' + periode;
            window.location.href = url;
        });
    </script>
@endsection
