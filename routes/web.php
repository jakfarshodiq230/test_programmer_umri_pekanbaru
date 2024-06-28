<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\SetingEmailController;
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

//Route::middleware('auth')->group(function () {

// halaman admin
Route::controller(SetingEmailController::class)->group(function () {
    Route::get('email', 'index');
    Route::get('email/data_email', 'AjaxData');
    Route::post('email/update_email/{id}', 'updateData');
});

Route::controller(SiswaController::class)->group(function () {
    Route::get('siswa', 'index');
    Route::get('siswa/data_siswa', 'AjaxData');
    Route::get('siswa/edit_siswa/{id}', 'editData');
    Route::post('siswa/store_siswa', 'storeData');
    Route::post('siswa/update_siswa/{id}', 'updateData');
    Route::delete('siswa/delete_siswa/{id}', 'deleteData');
    Route::delete('siswa/status_siswa/{id}/{status}', 'statusData');
    Route::post('siswa/import_siswa', 'importExcel');
    Route::post('siswa/seting_siswa', 'setingData');
});

Route::controller(GuruController::class)->group(function () {
    Route::get('guru', 'index');
    Route::get('guru/data_guru', 'AjaxData');
    Route::get('guru/edit_guru/{id}', 'editData');
    Route::post('guru/store_guru', 'storeData');
    Route::post('guru/update_guru/{id}', 'updateData');
    Route::delete('guru/delete_guru/{id}', 'deleteData');
    Route::delete('guru/status_guru/{id}/{status}', 'statusData');
    Route::post('guru/import_guru', 'importExcel');
    Route::post('guru/seting_guru', 'setingData');
});

Route::controller(KelasController::class)->group(function () {
    Route::get('kelas', 'index');
    Route::get('kelas/data_kelas', 'AjaxData');
    Route::get('kelas/edit_kelas/{id}', 'editData');
    Route::post('kelas/store_kelas', 'storeData');
    Route::post('kelas/update_kelas/{id}', 'updateData');
    Route::delete('kelas/delete_kelas/{id}', 'deleteData');
    Route::delete('kelas/status_kelas/{id}/{status}', 'statusData');
});

Route::controller(TahunAjaranController::class)->group(function () {
    Route::get('tahun_ajaran', 'index');
    Route::get('tahun_ajaran/data_tahun_ajaran', 'AjaxData');
    Route::get('tahun_ajaran/edit_tahun_ajaran/{id}', 'editData');
    Route::post('tahun_ajaran/store_tahun_ajaran', 'storeData');
    Route::post('tahun_ajaran/update_tahun_ajaran/{id}', 'updateData');
    Route::delete('tahun_ajaran/delete_tahun_ajaran/{id}', 'deleteData');
    Route::delete('tahun_ajaran/status_tahun_ajaran/{id}/{status}', 'statusData');
});



//});