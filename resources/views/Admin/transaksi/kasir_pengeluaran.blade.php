@extends('Admin.app_kasir')
@section('content')
    <main class="content">
        <div class="row ">
            @if ($status_periode == null)
                <div class="row justify-content-center align-items-center" style="height: 50vh;">
                    <div class="col-md-12 col-lg-6">
                        <div class="card text-center">
                            <div class="card-body bg-warning">
                                <h1>PERIODE SEDANG DI TUTUP OLEH ADMIN</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-header" style="margin-bottom: -30px;">
                            <h4>PENGELUARAN</h4>
                        </div>
                        <div class="card-body">
                            <div class="card" id="formInput">
                                <form id="dataForm" action="">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Jumlah Pengeluaran</label>
                                                    <input type="text" class="form-control" name="harga" id="harga"
                                                        onkeypress="return hanyaAngka(event)" required></input>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal" id="tanggal"
                                                        required></input>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Keterangan</label>
                                                    <textarea class="form-control" name="ketarangan" id="ketarangan"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                            <button type="button" id="submitBtn" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <table id="dataTabel-ajax" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Ketrangan</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Pengeluaran</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="dataTableBody"></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align: right">Total :</th>
                                        <th colspan="2" id="totalPayment">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div style="text-align: right;">
                                <button type="button" id="simpanBtn" onclick="saveDataToDatabase()"
                                    class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        // format rupiah
        $('#dataForm')[0].reset();
        $('#simpanBtn').hide();
        localStorage.clear();

        function formatRupiah(angka) {
            var number_string = angka.toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }
        // delete localstorage
        function deleteData(index) {
            let dataArray = JSON.parse(localStorage.getItem('data_array')) || [];
            dataArray.splice(index, 1);
            localStorage.setItem('data_array', JSON.stringify(dataArray));
            displayData();
        };
        // tampilkan data
        function displayData() {
            const dataArray = JSON.parse(localStorage.getItem('data_array')) || [];
            const tableBody = document.getElementById('dataTableBody');
            tableBody.innerHTML = '';
            let totalPayment = 0;
            dataArray.forEach((data, index) => {
                let row = document.createElement('tr');
                let jumlah_uang = parseFloat(data.jumlah_uang); // Parse data.jumlah_uang as a number
                totalPayment += jumlah_uang; // Add parsed jumlah_uang to totalPayment
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${data.keterangan}</td>
                    <td>${data.tanggal}</td>
                    <td>${formatRupiah(data.jumlah_uang)}</td>
                    <td><button class="btn btn-sm btn-danger" onclick="deleteData(${index})"><i class="fas fa-trash"></i></button></td>
                `;
                tableBody.appendChild(row);
            });
            document.getElementById('totalPayment').innerText = formatRupiah(totalPayment);
            if (totalPayment !== 0) {
                $('#simpanBtn').show();
            } else {
                $('#simpanBtn').hide();
            }
        };

        // hitung otomatis
        document.addEventListener('DOMContentLoaded', (event) => {
            const hargaInput = document.getElementById('harga');
            const tanggalBersihInput = document.getElementById('tanggal');
            const keteranganBersihInput = document.getElementById('ketarangan');

            // simpan localstoreage
            submitBtn.addEventListener('click', () => {
                let jumlah_uang = hargaInput.value;
                let tanggal = tanggalBersihInput.value;
                let keterangan = keteranganBersihInput.value;

                if (harga) {
                    let data = {
                        jumlah_uang: jumlah_uang,
                        tanggal: tanggal,
                        keterangan: keterangan
                    };

                    let dataArray = JSON.parse(localStorage.getItem('data_array')) || [];
                    dataArray.push(data);
                    localStorage.setItem('data_array', JSON.stringify(dataArray));
                    displayData();
                    $('#dataForm')[0].reset();
                } else {
                    $('#dataForm')[0].reset();
                }
            });


        });


        // simpan database
        function saveDataToDatabase() {
            const dataArray = JSON.parse(localStorage.getItem('data_array')) || [];
            const xhr = new XMLHttpRequest();
            const url = '{{ url('kasir/proses_pengeluaran') }}';
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            // Ambil token CSRF dari meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Tambahkan token CSRF ke header permintaan
            xhr.setRequestHeader('X-CSRF-Token', csrfToken);
            xhr.onreadystatechange = function() {

                if (xhr.readyState === 4 && xhr.status === 200) {
                    $('#dataForm')[0].reset();
                    localStorage.clear();
                    displayData();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Berhasil Simpan Data',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                } else {
                    displayData();
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal Simpan Data',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                }
            };
            xhr.send(JSON.stringify({
                dataArray: dataArray
            }));
            localStorage.clear();
        }
    </script>
@endsection
