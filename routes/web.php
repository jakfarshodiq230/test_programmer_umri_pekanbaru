<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiswaController;
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



//});