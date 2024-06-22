<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PeriodeController;
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

Route::controller(PeriodeController::class)->group(function () {
    Route::get('periode', 'index');
    Route::get('periode/data_periode', 'AjaxData');
    Route::get('periode/edit_periode/{id}', 'editData');
    Route::post('periode/store_periode', 'storeData');
    Route::post('periode/update_periode/{id}', 'updateData');
    Route::delete('periode/delete_periode/{id}', 'deleteData');
    Route::delete('periode/status_periode/{id}/{status}', 'statusData');
});



//});