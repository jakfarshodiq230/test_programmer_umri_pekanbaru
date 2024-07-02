<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\PesertaKegiatanController;
use App\Http\Controllers\Admin\PenilaianKegiatanController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\SetingEmailController;

// guru
use App\Http\Controllers\Guru\PenilaianKegiatanGuruController;
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
    Route::put('siswa/status_siswa/{id}/{status}', 'statusData');
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
    Route::put('guru/status_guru/{id}/{status}', 'statusData');
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
    Route::put('kelas/status_kelas/{id}/{status}', 'statusData');
});

Route::controller(TahunAjaranController::class)->group(function () {
    Route::get('tahun_ajaran', 'index');
    Route::get('tahun_ajaran/data_tahun_ajaran', 'AjaxData');
    Route::get('tahun_ajaran/edit_tahun_ajaran/{id}', 'editData');
    Route::post('tahun_ajaran/store_tahun_ajaran', 'storeData');
    Route::post('tahun_ajaran/update_tahun_ajaran/{id}', 'updateData');
    Route::delete('tahun_ajaran/delete_tahun_ajaran/{id}', 'deleteData');
    Route::put('tahun_ajaran/status_tahun_ajaran/{id}/{status}', 'statusData');
});

Route::controller(PeriodeController::class)->group(function () {
    Route::get('periode', 'index');
    Route::get('periode/data_tahun', 'AjaxDataTahun');
    Route::get('periode/data_periode', 'AjaxData');
    Route::get('periode/edit_periode/{id}', 'editData');
    Route::post('periode/store_periode', 'storeData');
    Route::post('periode/update_periode/{id}', 'updateData');
    Route::delete('periode/delete_periode/{id}', 'deleteData');
    Route::put('periode/status_periode/{id}/{status}', 'statusData');
});

Route::controller(PesertaKegiatanController::class)->group(function () {
    Route::get('peserta', 'index');
    Route::get('peserta/data_periode_peserta', 'AjaxDataPeriode');
    Route::get('peserta/data_list_periode_peserta/{periode}/{tahun}', 'DataListPesertaKegiatan');
    Route::get('peserta/data_peserta/{periode}/{tahun}', 'AjaxData');
    Route::get('peserta/data_siswa/{tahun}/{periode}', 'AjaxDataSiswa');
    Route::get('peserta/edit_peserta/{id}', 'editData');
    Route::post('peserta/store_peserta', 'storeData');
    Route::post('peserta/update_peserta/{id}', 'updateData');
    Route::delete('peserta/delete_peserta/{id}', 'deleteData');
    Route::put('peserta/status_peserta/{id}/{status}', 'statusData');
    Route::put('peserta/status_peserta_all/{tahun}/{periode}/{status}', 'statusDataAll');
});

Route::controller(PenilaianKegiatanController::class)->group(function () {
    Route::get('penilaian_kegiatan', 'index');
    Route::get('penilaian_kegiatan/data_periode_penilaian_kegiatan', 'AjaxDataPeriode');
    Route::get('penilaian_kegiatan/data_list_periode_penilaian_kegiatan/{periode}/{tahun}', 'DataListPenilaianKegiatan');
    Route::get('penilaian_kegiatan/data_penilaian_kegiatan/{periode}/{tahun}', 'AjaxData');
    Route::get('penilaian_kegiatan/data_detail_periode_penilaian_kegiatan/{tahun}/{periode}/{siswa}/{guru}/{kelas}', 'DataDetailPenilaianKegiatan');
    Route::get('penilaian_kegiatan/data_penilaian_kegiatan_all/{tahun}/{periode}/{siswa}/{guru}/{kelas}', 'AjaxDataDetailPenilaianKegiatan');
});


// guru

Route::prefix('guru/penilaian_kegiatan')->group(function () {
    Route::get('/', [PenilaianKegiatanGuruController::class, 'index'])->name('guru.penilaian_kegiatan.index');
    Route::get('/data_periode_penilaian_kegiatan/{guru}', [PenilaianKegiatanGuruController::class, 'AjaxDataPeriode'])->name('guru.penilaian_kegiatan.data_periode');
    Route::get('/data_list_periode_penilaian_kegiatan/{periode}/{tahun}', [PenilaianKegiatanGuruController::class, 'DataListPenilaianKegiatan'])->name('guru.penilaian_kegiatan.data_list_periode');
    Route::get('/data_penilaian_kegiatan/{periode}/{tahun}/{guru}', [PenilaianKegiatanGuruController::class, 'AjaxData'])->name('guru.penilaian_kegiatan.data_penilaian');
    Route::get('/data_detail_periode_penilaian_kegiatan/{tahun}/{periode}/{siswa}/{guru}/{kelas}', [PenilaianKegiatanGuruController::class, 'DataDetailPenilaianKegiatan'])->name('guru.penilaian_kegiatan.data_detail_periode');
    Route::get('/data_penilaian_kegiatan_all/{tahun}/{periode}/{siswa}/{guru}/{kelas}', [PenilaianKegiatanGuruController::class, 'AjaxDataDetailPenilaianKegiatan'])->name('guru.penilaian_kegiatan.data_penilaian_all');

    Route::get('/add_penilaian_kegiatan/{periode}/{tahun}', [PenilaianKegiatanGuruController::class, 'addPenilaianKegiatan'])->name('add_penialain');
    Route::get('/data_siswa/{periode}/{tahun}/{guru}', [PenilaianKegiatanGuruController::class, 'AjaxDataPesertaPenilaian'])->name('Ajax_Peserta');
    Route::post('/store_penilaian', [PenilaianKegiatanGuruController::class, 'storeData'])->name('storeData');
    Route::get('/data_penilaian_kegiatan_sm/{periode}/{guru}/{kegiatan}', [PenilaianKegiatanGuruController::class, 'AjaxDataPesertaPenilaianSm'])->name('AjaxDataPesertaPenilaianSm');
    Route::delete('/hapus_data_penilaian_kegiatan/{id}', [PenilaianKegiatanGuruController::class, 'deleteData'])->name('deleteData');
    Route::get('/kirim_data_penilaian_kegiatan/{periode}/{guru}/{kegiatan}', [PenilaianKegiatanGuruController::class, 'kirimData'])->name('kirimData');
    Route::delete('/hapus_penilaian_kegiatan/{id}', [PenilaianKegiatanGuruController::class, 'deleteDataPenilaian'])->name('deleteDataPenilaian');
    Route::get('/edit_penilaian_kegiatan/{id}', [PenilaianKegiatanGuruController::class, 'editDataPenilaian'])->name('editDataPenilaian');
    Route::post('/update_penilaian/{id}', [PenilaianKegiatanGuruController::class, 'updateData'])->name('updateData');
});




//});