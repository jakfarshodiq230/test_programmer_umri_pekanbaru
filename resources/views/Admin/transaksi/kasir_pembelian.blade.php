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
                            <h4>PEMBELIAN</h4>
                        </div>
                        <div class="card-body">
                            <div class="card" id="formInput">
                                <form id="dataForm" action="">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Harga</label>
                                                    <select class="form-control select2" name="id_harga" id="id_harga"
                                                        onchange="updateHarga(this)" required>
                                                        <option selected>PILIH</option>
                                                    </select>
                                                    <input type="text" class="form-control" name="harga" id="harga"
                                                        hidden></input>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Berat Normal (Kg)</label>
                                                    <input type="text" class="form-control" name="berat_normal"
                                                        id="berat_normal" onkeypress="return hanyaAngka(event)"
                                                        required></input>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Berat Potongan (Kg)</label>
                                                    <input type="text" class="form-control" name="berat_potongan"
                                                        id="berat_potongan" onkeypress="return hanyaAngka(event)"
                                                        required></input>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Berat Bersih (Kg)</label>
                                                    <input type="text" class="form-control" name="berat_bersih"
                                                        id="berat_bersih" readonly></input>
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
                                        <th>Berat Normal</th>
                                        <th>Berat Potongan</th>
                                        <th>Berat Bersih</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="dataTableBody"></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align: right">Total :</th>
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
    <iframe id="printIframe" style="display: none;"></iframe>
@endsection
@section('scripts')
    <script>
        // format rupiah
        $('#dataForm')[0].reset();
        $('#simpanBtn').hide();
        localStorage.clear();
        // format rupiah
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
                let total = data.harga * data.beratBersih;
                totalPayment += total;
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${data.beratNormal+' Kg'}</td>
                    <td>${data.beratPotongan+' Kg'}</td>
                    <td>${data.beratBersih+' Kg'}</td>
                    <td>${formatRupiah(data.harga)}</td>
                    <td>${formatRupiah(data.beratBersih*data.harga)}</td>
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

        // update harga option
        function updateHarga(select) {
            var selectedOption = select.value;
            var hargaInput = document.getElementById('harga');
            $.ajax({
                url: '{{ url('kasir/harga_cek') }}/' + selectedOption,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data.harga !== "") {
                        hargaInput.value = response.data.harga;
                    } else {
                        hargaInput.value = "";
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }
        // hitung otomatis
        document.addEventListener('DOMContentLoaded', (event) => {
            const IdhargaInput = document.getElementById('id_harga');
            const hargaInput = document.getElementById('harga');
            const beratNormalInput = document.getElementById('berat_normal');
            const beratPotonganInput = document.getElementById('berat_potongan');
            const beratBersihInput = document.getElementById('berat_bersih');

            beratPotonganInput.addEventListener('input', () => {
                let beratPotongan = parseFloat(beratPotonganInput.value);
                let totalWeight = parseFloat(beratNormalInput.value);
                if (!isNaN(beratPotongan)) {
                    let beratBersih = totalWeight - beratPotongan;
                    beratBersihInput.value = beratBersih;
                } else {
                    beratBersihInput.value = '';
                }
            });
            // simpan localstoreage
            submitBtn.addEventListener('click', () => {
                let id_harga = IdhargaInput.value;
                let harga = hargaInput.value;
                let beratNormal = beratNormalInput.value;
                let beratPotongan = beratPotonganInput.value;
                let beratBersih = beratBersihInput.value;

                if (harga && beratNormal && beratPotongan && beratBersih) {
                    let data = {
                        id_harga: id_harga,
                        harga: harga,
                        beratNormal: beratNormal,
                        beratPotongan: beratPotongan,
                        beratBersih: beratBersih
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

        // data harga
        $(document).ready(function() {
            $.ajax({
                url: '{{ url('kasir/harga') }}', // Ganti dengan URL skrip PHP Anda
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Hapus semua opsi kecuali yang pertama (PILIH)
                    $('select[name="id_harga"]').find('option:not(:first)').remove();

                    // Tambahkan opsi baru berdasarkan data yang diterima dari server
                    $.each(response.data, function(index, value) {
                        $('select[name="id_harga"]').append('<option value="' + value.id_harga +
                            '">' + value.judul_harga.toUpperCase() + ' - ' + formatRupiah(
                                value.harga) +
                            '</option>');
                    });

                    // Aktifkan kembali plugin Select2 setelah memperbarui opsi
                    $('.select2').select2();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // simpan database
        function saveDataToDatabase() {
            const dataArray = JSON.parse(localStorage.getItem('data_array')) || [];
            const xhr = new XMLHttpRequest();
            const url = '{{ url('kasir/proses_pembelian') }}';
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            // Ambil token CSRF dari meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Tambahkan token CSRF ke header permintaan
            xhr.setRequestHeader('X-CSRF-Token', csrfToken);
            xhr.onreadystatechange = function() {

                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    $('#dataForm')[0].reset();
                    localStorage.clear();
                    displayData();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Berhasil Simpan Data',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Lanjutkan?',
                                text: 'Apakah Anda ingin cetak bukti pembelian?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var lin_cetak = '{{ url('transaksi/cetak_rincian_pembelian') }}/' +
                                    response.id_pembelian;
                                    let iframe = document.getElementById('printIframe');
                                    iframe.src = lin_cetak;

                                    iframe.onload = function() {
                                        iframe.contentWindow.focus();
                                        iframe.contentWindow.print();
                                    };
                                }
                            });
                        }
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
