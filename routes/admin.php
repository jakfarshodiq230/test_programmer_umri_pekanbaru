<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdiController;
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

    Route::prefix('admin')->controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index');
    });

});
