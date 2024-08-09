@extends('Admin.layout')
@section('content')
<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
                Selamat Datang Di Sistem SIP-UKT.
            </h1>
            <p class="header-subtitle">SIP-UKT merupakan sistem informasi dan manajemen pembayaran uang kuliah tunggal (UKT). </p>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Mahasiswa</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="mahasiswa">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Pembayaran Hari Ini</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="pembayaran_now">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Pembayaran</h5>
                            </div>

                            <div class="col-auto">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-dark">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 class="display-5 mt-1 mb-3" id="total_bayar">0</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
<script>
    // rupiah
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        }).format(amount);
    }
    document.addEventListener('DOMContentLoaded', function () {
        $.ajax({
            url: '{{ url('admin/dashboard/data_dashboard') }}',
            type: 'GET',
            success: function(response) {
                console.log(response);
                // Populate the modal fields with the data
                $('#mahasiswa').text(response.mahasiswa);
                $('#pembayaran_now').text(formatCurrency(response.pembayaran_now));
                $('#total_bayar').text(formatCurrency(response.total_bayar));
            },
            error: function(response) {
                alert('error request');
            }
        });
    });
</script>
@endsection
