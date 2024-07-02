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
                    Data Peserta Kegiatan
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
                                        <th>Periode</th>
                                        <th>Jumlah Peserta</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Periode</th>
                                        <th>Jumlah Peserta</th>
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
        var guru = "GR-230624-3";
        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('guru/penilaian_kegiatan/data_periode_penilaian_kegiatan') }}/'+guru,
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
                            var formatted_string = nama_tahun_ajaran + ' [ ' + jenis_periode + ' ]';
                            return formatted_string;
                        }

                    },
                    {
                        data: 'total_peserta_kegiatan',
                        name: 'total_peserta_kegiatan',
                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-secondary lihatBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Peserta" data-id_periode="${row.id_periode}" data-tahun_ajaran="${row.id_tahun_ajaran}"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning penilaianBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Penilaian Peserta" data-id_periode="${row.id_periode}" data-tahun_ajaran="${row.id_tahun_ajaran}"><i class="fas fa-user-plus"></i></button>
                            `;
                        }
                    },
                ]
            });
        });

        // lihatData 
        $(document).on('click', '.lihatBtn', function() {
            var id_periode = $(this).data('id_periode');
            var tahun_ajaran = $(this).data('tahun_ajaran');
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
                    var url = "{{ url('guru/penilaian_kegiatan/data_list_periode_penilaian_kegiatan') }}/" + id_periode + "/" +
                        tahun_ajaran;
                    window.location.href = url;
                }
            });
        });

        $(document).on('click', '.penilaianBtn', function() {
            var id_periode = $(this).data('id_periode');
            var tahun_ajaran = $(this).data('tahun_ajaran');
            // Make an Ajax call to delete the record
            Swal.fire({
                title: 'Penilaian',
                text: 'Apakah Anda Ingin Melakukan Penilaian?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya akan melakukan penilaian'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('guru/penilaian_kegiatan/add_penilaian_kegiatan') }}/" + id_periode + "/" +
                        tahun_ajaran;
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
