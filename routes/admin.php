<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\JenisPembayaranController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\RekapPembayaranController;

Route::group(['middleware' => ['auth:mahasiswa']], function () {

    Route::prefix('admin')->controller(MahasiswaController::class)->group(function () {
        Route::get('mahasiswa', 'index');
        Route::get('mahasiswa/data_mahasiswa', 'AjaxData');
        Route::get('mahasiswa/edit_mahasiswa/{id}', 'editData');
        Route::post('mahasiswa/store_mahasiswa', 'storeData');
        Route::post('mahasiswa/update_mahasiswa/{id}', 'updateData');
        Route::delete('mahasiswa/delete_mahasiswa/{id}', 'deleteData');
    });

    Route::prefix('admin')->controller(ProdiController::class)->group(function () {
        Route::get('prodi', 'index');
        Route::get('prodi/data_prodi', 'AjaxData');
        Route::get('prodi/edit_prodi/{id}', 'editData');
        Route::post('prodi/store_prodi', 'storeData');
        Route::post('prodi/update_prodi/{id}', 'updateData');
        Route::delete('prodi/delete_prodi/{id}', 'deleteData');
    });

    Route::prefix('admin')->controller(JenisPembayaranController::class)->group(function () {
        Route::get('jenis', 'index');
        Route::get('jenis/data_jenis', 'AjaxData');
        Route::get('jenis/edit_jenis/{id}', 'editData');
        Route::post('jenis/store_jenis', 'storeData');
        Route::post('jenis/update_jenis/{id}', 'updateData');
        Route::delete('jenis/delete_jenis/{id}', 'deleteData');
    });

    Route::prefix('admin')->controller(PembayaranController::class)->group(function () {
        Route::get('pembayaran', 'index');
        Route::get('pembayaran/data_pembayaran', 'AjaxData');
        Route::get('pembayaran/data_mahasiswa_bayar/{id}', 'DataMahasiswaID');
        Route::get('pembayaran/edit_pembayaran/{id}', 'editData');
        Route::post('pembayaran/store_pembayaran', 'storeData');
        Route::post('pembayaran/update_pembayaran/{id}', 'updateData');
        Route::delete('pembayaran/delete_pembayaran/{id}', 'deleteData');
    });

    Route::prefix('admin')->controller(RekapPembayaranController::class)->group(function () {
        Route::get('rekap', 'index');
        Route::get('rekap/data_bayar/{awal}/{akhir}', 'AjaxData');
        Route::get('rekap/download_excel/{awal}/{akhir}', 'ExportExcel');
    });

    Route::prefix('admin')->controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index');
        Route::get('dashboard/data_dashboard', 'AjaxData');
    });

});
