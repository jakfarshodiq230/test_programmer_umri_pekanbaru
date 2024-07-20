<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\TahunAjaranModel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\PesertaKegiatan;
use App\Models\Admin\SiswaModel;
use App\Models\Admin\GuruModel;
use App\Models\Admin\KelasModel;
use App\Models\Admin\PenilaianModel;

class PenilaianKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }
    public function index(){
        $menu = 'kegiatan';
        $submenu= 'penilaian';
        return view ('Admin/kegiatan/penilaian/data_penilaian_kegiatan',compact('menu','submenu'));
    }

    public function AjaxDataPeriode(Request $request) {
        $DataPeserta = PesertaKegiatan::DataAll();
        if ($DataPeserta == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function DataListPenilaianKegiatan($id_periode,$id_tahun_ajaran){
        $menu = 'kegiatan';
        $submenu= 'penilaian';
        $periode = $id_periode;
        $tahun_ajaran = $id_tahun_ajaran;
        $judul_1 = PeriodeModel::where('id_periode', $id_periode)->whereNull('deleted_at')->first();
        $judul_2 = TahunAjaranModel::where('id_tahun_ajaran', $id_tahun_ajaran)->whereNull('deleted_at')->first();
        $judul_3 = ucfirst($judul_1->jenis_periode).' '. $judul_2->nama_tahun_ajaran;
        return view ('Admin/kegiatan/penilaian/data_list_penilaian_kegiatan',compact('menu','submenu','periode','tahun_ajaran','judul_1','judul_2','judul_3'));
    }

    public function AjaxData($id_periode,$id_tahun_ajaran) {
        $DataPeserta = PesertaKegiatan::DataPesertaKegiatanAll($id_periode,$id_tahun_ajaran);
        
        if ($DataPeserta == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataSiswa($tahun,$periode)
    {
        $selectedIds = PesertaKegiatan::where('id_tahun_ajaran',$tahun)->where('id_periode',$periode)->pluck('id_siswa')->toArray();
        $siswa = SiswaModel::whereNotIn('id_siswa', $selectedIds)->get();
        if ($siswa->isNotEmpty()) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $siswa]);
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }


    public function DetailPenilaianKegiatan(){
        $menu = 'kegiatan';
        $submenu= 'penilaian';
        return view ('Admin/kegiatan/penilaian/detail_penilaian_kegiatan',compact('menu','submenu'));
    }

    public function DataDetailPenilaianKegiatan($tahun,$periode,$siswa,$guru,$kelas){
        $menu = 'kegiatan';
        $submenu= 'penilaian';
        $judul_1 = PeriodeModel::where('id_periode', $periode)->whereNull('deleted_at')->first();
        $judul_2 = TahunAjaranModel::where('id_tahun_ajaran', $tahun)->whereNull('deleted_at')->first();
        $judul_3 = ucfirst($judul_1->jenis_periode).' '. $judul_2->nama_tahun_ajaran;
        $kegiatan =$judul_1->jenis_periode;
        return view ('Admin/kegiatan/penilaian/detail_penilaian_kegiatan',compact(
            'menu',
            'submenu',
            'judul_3',
            'tahun',
            'periode',
            'siswa',
            'guru',
            'kelas',
            'kegiatan',
        ));
    }

    public function AjaxDataDetailPenilaianKegiatan($tahun,$periode,$siswa,$guru,$kelas){
        
        $nilai = PenilaianModel::DataPenialainKegiatan($tahun,$periode,$siswa,$guru,$kelas);
        if ($nilai) {
            $siswa = PesertaKegiatan::DataSiswaProfil($tahun,$periode,$siswa,$guru,$kelas);
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'nilai'=> $nilai,'siswa'=> $siswa]);
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }
        
}
