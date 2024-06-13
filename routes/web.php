<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HargaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\SetingEmailController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\KasirController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PembukuanController;
use App\Http\Controllers\Admin\PembukuanBulanController;
use App\Http\Controllers\Admin\PembukuanTahunController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// admin
//  login
Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'login')->name('login')->middleware('guest');
    Route::get('daftar_pelanggan', 'daftar')->middleware('guest');
    Route::post('daftar_pelanggan/store', 'daftarAkun')->middleware('guest');
    Route::get('lupa_password', 'lupa_password')->middleware('guest');
    Route::get('lupa_password/cek_akun/{email}', 'CekAkun')->middleware('guest');
    Route::get('lupa_password/input_data/{id}/{email}', 'lupa_passwordInput')->middleware('guest');
    Route::post('lupa_password/update_password_store', 'update_password')->middleware('guest');
    Route::post('action_login', 'authenticate')->middleware('guest');
    Route::get('actionlogout', 'actionlogout')->middleware('auth');
});
Route::middleware('auth')->group(function () {

Route::controller(HomeController::class)->group(function () {
    Route::get('home', 'index')->name('home');
    Route::get('home/log_akses', 'pelanggan');
    Route::get('home/data_akses_pengguna', 'AjaxDataPengunjung');
    Route::delete('home/hapus_akses_pengguna', 'AjaxHapusPengunjung');
    Route::get('home/pembelian', 'AjaxDataPembelian');
    Route::get('home/penjualan', 'AjaxDataPenjualan');
    Route::get('home/pengeluaran', 'AjaxDataPengeluaran');
    Route::get('home/statistik', 'statistik');
    Route::get('home/ajax_statistik', 'AjaxDataStatistik');
});

// halaman kasir
Route::controller(KasirController::class)->group(function () {
    // pembelian
    Route::get('kasir/pembelian', 'index');
    Route::get('kasir/harga', 'AjaxDataHarga');
    Route::post('kasir/data_pembelian', 'AjaxDataPembelian');
    Route::get('kasir/harga_cek/{id}', 'AjaxHarga');
    Route::post('kasir/proses_pembelian', 'saveDataPembelian');
    // penjualan
    Route::get('kasir/penjualan', 'penjulan');
    Route::post('kasir/proses_penjualan', 'saveDataPenjualan');
    // pengeluaran
    Route::get('kasir/pengeluaran', 'pengeluaran');
    Route::post('kasir/proses_pengeluaran', 'saveDataPengeluaran');
});

// halaman admin
Route::controller(SetingEmailController::class)->group(function () {
    Route::get('email', 'index');
    Route::get('email/data_email', 'AjaxData');
    Route::post('email/update_email/{id}', 'updateData');
});

Route::controller(TransaksiController::class)->group(function () {
    Route::get('transaksi', 'index');
    Route::get('transaksi/data_transaksi', 'AjaxData');
    Route::get('transaksi/data_transaksi_penjualan', 'AjaxDataPenjualan');
    Route::get('transaksi/data_transaksi_Pengeluaran', 'AjaxDataPengeluaran');
    Route::get('transaksi/data_rincian_pembelian/{id}', 'AjaxDataRincianPembelian');
    Route::get('transaksi/data_rincian_penjualan/{id}', 'AjaxDataRincianPenjualan');
    Route::get('transaksi/cetak_rincian_pembelian/{id}', 'CetakRincianPembelian');
    Route::get('transaksi/cetak_rincian_penjualan/{id}', 'CetakRincianPenjualan');
});

Route::controller(PelangganController::class)->group(function () {
    Route::get('pelanggan', 'index');
    Route::get('pelanggan/data_pelanggan', 'AjaxData');
    Route::delete('pelanggan/status_pelanggan/{id}/{status}', 'statusData');
});

Route::controller(PeriodeController::class)->group(function () {
    Route::get('periode', 'index');
    Route::get('periode/data_periode', 'AjaxData');
    Route::get('periode/edit_periode/{id}', 'editData');
    Route::post('periode/store_periode', 'storeData');
    Route::post('periode/update_periode/{id}', 'updateData');
    Route::delete('periode/delete_periode/{id}', 'deleteData');
    Route::delete('periode/status_periode/{id}/{status}', 'statusData');
});

Route::controller(UserController::class)->group(function () {
    Route::get('user', 'index');
    Route::get('user/data_user', 'AjaxData');
    Route::get('user/data_pelanggan', 'AjaxDataPelanggan');
    Route::get('user/data_pelanggan_ajax/{id}', 'AjaxDataPelangganID');
    Route::post('user/store_user', 'storeData');
    Route::delete('user/delete_user/{id}', 'deleteData');
    Route::delete('user/status_user/{id}/{status}', 'statusData');
    // admin
    Route::post('user/store_user_akun', 'storeDataAkun');
    Route::get('user/edit_user_akun/{id}', 'editDataAkun');
    Route::post('user/update_user_akun/{id}', 'updateDataAkun');
    Route::post('user/update_password_akun/{id}', 'updatePasswordAkun');
});

Route::controller(HargaController::class)->group(function () {
    Route::get('harga', 'index');
    Route::get('harga/data_harga', 'AjaxDataHarga');
    Route::get('harga/edit_harga/{id}', 'editDataHarga');
    Route::post('harga/store_harga', 'storeDataHarga');
    Route::post('harga/update_harga/{id}', 'updateDataHarga');
    Route::delete('harga/delete_harga/{id}', 'deleteDataHarga');
});

Route::controller(PembukuanController::class)->group(function () {

    // hari
    Route::get('pembukuan/hari', 'index');
    Route::get('pembukuan/data_periode', 'AjaxDataPeriode');
    Route::get('pembukuan/data_pembukuan_hari_periode', 'AjaxDataHari');
    Route::post('pembukuan/store_pembukuan_hari', 'storeDataPembukuanHari');
    Route::get('pembukuan/data_pembukuan_hari_periode_rincian/{id}/{periode}', 'DataRincianPeriodeHari');
    Route::get('pembukuan/list_data_pembukuan_hari_periode_rincian/{id}/{periode}', 'AjaxDataRincianPeriodeHari');
    Route::get('pembukuan/data_detail_pembukuan_hari_periode_rincian/{id}/{periode}/{tanggal}', 'DataDetailRincianPeriodeHari');
    Route::get('pembukuan/penjualan/list_data_detail_pembukuan_hari_periode_rincian/{id}/{periode}/{tanggal}', 'AjaxListDataRincianPeriodeHarPembelian');
    Route::get('pembukuan/pembelian/list_data_detail_pembukuan_hari_periode_rincian/{id}/{periode}/{tanggal}', 'AjaxListDataRincianPeriodeHariPenjualan');
    Route::get('pembukuan/pengeluaran/list_data_detail_pembukuan_hari_periode_rincian/{id}/{periode}/{tanggal}', 'AjaxListDataRincianPeriodeHariPengeluaran');
    Route::get('pembukuan/cetak_rincian_pdf/{id}/{periode}', 'cetakRincianPdf');
    Route::get('pembukuan/cetak_detail_rincian_pdf/{id}/{periode}/{tanggal}', 'cetakDetailRincianPdf');
    // end hari
});

Route::controller(PembukuanBulanController::class)->group(function () {

    // hari
    Route::get('pembukuan/bulan', 'index');
    Route::get('pembukuan/data_periode', 'AjaxDataPeriode');
    Route::get('pembukuan/data_pembukuan_bulan_periode', 'AjaxDataBulan');
    Route::post('pembukuan/store_pembukuan_bulan', 'storeDataPembukuanBulan');
    Route::get('pembukuan/data_pembukuan_bulan_periode_rincian/{id}/{periode}', 'DataRincianPeriodebulan');
    Route::get('pembukuan/list_data_pembukuan_bulan_periode_rincian/{id}/{periode}', 'AjaxDataRincianPeriodebulan');
    Route::get('pembukuan/data_detail_pembukuan_bulan_periode_rincian/{id}/{periode}/{tanggal}', 'DataDetailRincianPeriodebulan');
    Route::get('pembukuan/bulan/penjualan/list_data_detail_pembukuan_bulan_periode_rincian/{id}/{periode}/{tanggal}', 'AjaxListDataRincianPeriodeBulanPembelian');
    Route::get('pembukuan/bulan/pembelian/list_data_detail_pembukuan_bulan_periode_rincian/{id}/{periode}/{tanggal}', 'AjaxListDataRincianPeriodebulanPenjualan');
    Route::get('pembukuan/bulan/pengeluaran/list_data_detail_pembukuan_bulan_periode_rincian/{id}/{periode}/{tanggal}', 'AjaxListDataRincianPeriodebulanPengeluaran');
    Route::get('pembukuan/bulan/cetak_rincian_pdf/{id}/{periode}/{bulan}', 'cetakRincianPdf');
    Route::get('pembukuan/bulan/cetak_detail_rincian_pdf/{id}/{periode}/{tanggal}', 'cetakDetailRincianPdf');
    // end hari
});

Route::controller(PembukuanTahunController::class)->group(function () {
    // hari
    Route::get('pembukuan/tahun', 'index');
    Route::get('pembukuan/data_periode', 'AjaxDataPeriode');
    Route::get('pembukuan/data_pembukuan_tahun_periode', 'AjaxDatatahun');
    Route::post('pembukuan/store_pembukuan_tahun', 'storeDataPembukuantahun');
    Route::get('pembukuan/data_pembukuan_tahun_periode_rincian/{id}/{periode}/{tahun}', 'DataRincianPeriodetahun');
    Route::get('pembukuan/list_data_pembukuan_tahun_periode_rincian/{id}/{periode}/{tahun}', 'AjaxDataRincianPeriodetahun');
    Route::get('pembukuan/data_detail_pembukuan_tahun_periode_rincian/{id}/{periode}/{tahun}', 'DataDetailRincianPeriodetahun');
    Route::get('pembukuan/tahun/penjualan/list_data_detail_pembukuan_tahun_periode_rincian/{id}/{periode}/{tahun}', 'AjaxListDataRincianPeriodetahunPembelian');
    Route::get('pembukuan/tahun/pembelian/list_data_detail_pembukuan_tahun_periode_rincian/{id}/{periode}/{tahun}', 'AjaxListDataRincianPeriodetahunPenjualan');
    Route::get('pembukuan/tahun/pengeluaran/list_data_detail_pembukuan_tahun_periode_rincian/{id}/{periode}/{tahun}', 'AjaxListDataRincianPeriodetahunPengeluaran');
    Route::get('pembukuan/tahun/cetak_rincian_pdf/{id}/{periode}/{tahun}', 'cetakRincianPdf');
    Route::get('pembukuan/tahun/cetak_detail_rincian_pdf/{id}/{periode}/{tahun}', 'cetakDetailRincianPdf');
    // end hari
});

});