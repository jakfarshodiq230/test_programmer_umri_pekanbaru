<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guru\PenilaianKegiatanGuruController;
use App\Http\Controllers\Guru\PenilaianRaporGuruController;
use App\Http\Controllers\Guru\SertifikasiController;
use App\Http\Controllers\Guru\DaftarSertifikasiController;
use App\Http\Controllers\Guru\DashboardController As DashboardControllerGuru;

Route::middleware('auth:guru')->group(function () {

    Route::prefix('guru/dashboard')->group(function () {
        Route::get('/', [DashboardControllerGuru::class, 'index'])->name('guru.home');
    });

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
        Route::get('/cetak_kartu/{peserta}/{tahun}/{rapor}/{periode}', [PenilaianKegiatanGuruController::class, 'CetakKartu'])->name('admin.CetakKartu');
    });

    Route::prefix('guru/penilaian_rapor')->group(function () {
        Route::get('/', [PenilaianRaporGuruController::class, 'index'])->name('guru.penilaian_rapor.index');
        Route::get('/data_peserta_rapor', [PenilaianRaporGuruController::class, 'AjaxData'])->name('guru.penilaian_rapor.AjaxData');
        Route::get('/list_peserta/{tahun}/{rapor}/{periode}', [PenilaianRaporGuruController::class, 'DataPeserta'])->name('guru.penilaian_rapor.DataPeserta');
        Route::get('/ajax_list_peserta/{tahun}/{rapor}/{periode}', [PenilaianRaporGuruController::class, 'AjaxDataPesertaRapor'])->name('guru.penilaian_rapor.AjaxDataPesertaRapor');
        Route::post('/ajax_store_peserta', [PenilaianRaporGuruController::class, 'storeData'])->name('guru.penilaian_rapor.storeData');
        Route::get('/detail_peserta/{id}/{peserta}/{tahun}/{rapor}/{periode}', [PenilaianRaporGuruController::class, 'DataDetailPeserta'])->name('guru.penilaian_rapor.DataDetailPeserta');
        Route::get('/ajax_detail_peserta/{id}/{peserta}/{tahun}/{rapor}/{periode}', [PenilaianRaporGuruController::class, 'AjaxDataDetailPesertaRapor'])->name('guru.penilaian_rapor.AjaxDataDetailPesertaRapor');
        Route::delete('/ajax_delete_penilaian_pengembangan/{id}/{idrapor}/{peserta}/{tahun}/{rapor}/{periode}', [PenilaianRaporGuruController::class, 'AjaxHapusPenilaianPengembanganDiriPesertaRapor'])->name('guru.penilaian_rapor.AjaxHapusPenilaianPengembanganDiriPesertaRapor');
        Route::get('/ajax_edit_penilaian_pengembangan/{id}/{idrapor}/{peserta}/{tahun}/{rapor}/{periode}', [PenilaianRaporGuruController::class, 'AjaxEditPenilaianPengembanganDiriPesertaRapor'])->name('guru.penilaian_rapor.AjaxEditPenilaianPengembanganDiriPesertaRapor');
        Route::post('/ajax_update_penilaian_pengembangan/{id}', [PenilaianRaporGuruController::class, 'updateData'])->name('guru.penilaian_rapor.updateData');
        Route::get('/cetak_rapor/{id}/{idrapor}/{peserta}/{tahun}/{rapor}/{periode}', [PenilaianRaporGuruController::class, 'CetakRapor'])->name('admin.penilaian_rapor.CetakRapor');
    });

    Route::prefix('guru/daftar_sertifikasi')->group(function () {
        Route::get('/', [DaftarSertifikasiController::class, 'index'])->name('guru.daftar_sertifikasi.index');
        Route::get('/data_periode_sertifikasi', [DaftarSertifikasiController::class, 'AjaxData'])->name('guru.daftar_sertifikasi.AjaxData');
        Route::get('/list_daftar_sertifikasi/{tahun}/{sertifikasi}/{periode}', [DaftarSertifikasiController::class, 'listDaftar'])->name('guru.daftar_sertifikasi.listDaftar');
        Route::get('/list_peserta/{tahun}/{sertifikasi}/{periode}', [DaftarSertifikasiController::class, 'DataPeserta'])->name('guru.daftar_sertifikasi.DataPeserta');
        Route::post('/store_daftar', [DaftarSertifikasiController::class, 'storeData'])->name('guru.daftar_sertifikasi.storeData');
        Route::get('/ajax_peserta_daftar/{tahun}/{sertifikasi}/{periode}', [DaftarSertifikasiController::class, 'AjaxDataDaftarPeserta'])->name('guru.daftar_sertifikasi.AjaxDataDaftarPeserta');
        Route::delete('/ajax_delete_peserta/{id}', [DaftarSertifikasiController::class, 'deleteData'])->name('guru.daftar_sertifikasi.deleteData');
        Route::get('/detail_penilaian_sertifikasi/{id}', [DaftarSertifikasiController::class, 'DetailNilaiPeserta'])->name('guru.daftar_sertifikasi.DetailNilaiPeserta');
        Route::get('/ajax_detail_penilaian_peserta/{peserta}', [DaftarSertifikasiController::class, 'AjaxDataDetailPeserta'])->name('guru.daftar_sertifikasi.AjaxDataDetailPeserta');
        Route::get('/download_sertifikat/{id}', [DaftarSertifikasiController::class, 'CetakSertifikatPdf'])->name('guru.daftar_sertifikasi.CetakSertifikatPdf');
    });

    Route::prefix('guru/penilaian_sertifikasi')->group(function () {
        Route::get('/', [SertifikasiController::class, 'index'])->name('guru.penilaian_sertifikasi.index');
        Route::get('/data_peserta_sertifikasi', [SertifikasiController::class, 'AjaxData'])->name('guru.penilaian_sertifikasi.AjaxData');
        Route::get('/list_data_sertifikasi/{tahun}/{sertifikasi}/{periode}', [SertifikasiController::class, 'listDaftar'])->name('guru.penilaian_sertifikasi.list_data_sertifikasi');
        Route::get('/list_peserta/{tahun}/{sertifikasi}/{periode}', [SertifikasiController::class, 'DataPeserta'])->name('guru.penilaian_sertifikasi.DataPeserta');
        Route::post('/store_daftar', [SertifikasiController::class, 'storeData'])->name('guru.penilaian_sertifikasi.storeData');
        Route::get('/ajax_peserta_daftar/{tahun}/{sertifikasi}/{periode}', [SertifikasiController::class, 'AjaxDataNilaiPeserta'])->name('guru.penilaian_sertifikasi.AjaxDataNilaiPeserta');
        Route::get('/detail_penilaian_peserta/{peserta}', [SertifikasiController::class, 'DetailNilaiPeserta'])->name('guru.penilaian_sertifikasi.DetailNilaiPeserta');
        Route::get('/ajax_detail_penilaian_peserta/{peserta}', [SertifikasiController::class, 'AjaxDataDetailPeserta'])->name('guru.penilaian_sertifikasi.AjaxDataDetailPeserta');
        Route::delete('/hapus_penilaian_sertifikasi/{id}', [SertifikasiController::class, 'deleteData'])->name('guru.penilaian_sertifikasi.deleteData');
        Route::get('/edit_penilaian_sertifikasi/{id}', [SertifikasiController::class, 'editData'])->name('guru.penilaian_sertifikasi.editData');
        Route::post('/update_penilaian_sertifikasi/{id}', [SertifikasiController::class, 'updateData'])->name('guru.penilaian_sertifikasi.updateData');
        Route::get('/cetak_sertifikat/{id}', [SertifikasiController::class, 'CetakSertifikat'])->name('guru.penilaian_sertifikasi.CetakSertifikat');
    });
});