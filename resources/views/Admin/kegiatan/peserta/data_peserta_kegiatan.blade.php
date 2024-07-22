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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Periode</th>
                                        <th>Jumlah Peserta</th>
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
        $('.select2').val(null).trigger('change');

        $(document).ready(function() {
            // menampilkan data
            $('#datatables-ajax').DataTable({
                processing: true,
                serverSide: false,
                retrieve: false,
                destroy: true,
                responsive: true,
                ajax: '{{ url('admin/peserta/data_periode_peserta') }}',
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
                        render: function(data, type, row) {
                            return row.total_peserta_kegiatan + ' Orang';
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
                                <button class="btn btn-sm btn-primary addBtn me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Peserta" data-id_periode="${row.id_periode}" data-tahun_ajaran="${row.id_tahun_ajaran}"><i class="fas fa-users"></i></button>
                            `;
                            } else {
                                return `
                                <button class="btn btn-sm btn-secondary me-1 disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Peserta"><i class="fas fa-users"></i></button>
                            `;
                            }
                        }
                    },
                ]
            });
        });

        // delete 
        $(document).on('click', '.addBtn', function() {
            var id_periode = $(this).data('id_periode');
            var tahun_ajaran = $(this).data('tahun_ajaran');
            // Make an Ajax call to delete the record
            Swal.fire({
                title: 'Tambah Peserta Kegiatan',
                text: 'Apakah Anda Ingin Menambah Peserta Kegiatan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya akan menambah data'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('admin/peserta/data_list_periode_peserta') }}/" + id_periode + "/" + tahun_ajaran;
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
