<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\TahunAjaranModel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\SiswaModel;
use App\Models\Admin\GuruModel;
use App\Models\Admin\KelasModel;
use App\Models\Admin\LogAksesModel;
use App\Models\Admin\PesertaKegiatan;
use App\Models\Admin\PenilaianModel;
use App\Models\Admin\PenilaianSertifikasiModel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }
    public function index(){
        $menu = 'home';
        $submenu= 'home';
        return view ('Admin/home/dashboard',compact('menu','submenu'));
    }

    public function AjaxDataPeriode() {
        $Peserta = SiswaModel::whereNull('deleted_at')->count();
        $Guru = GuruModel::whereNull('deleted_at')->count();
        $Tahsin = PeriodeModel::where('judul_periode','setoran')->where('jenis_periode','tahsin')->whereNull('deleted_at')->count();
        $Tahfidz = PeriodeModel::where('judul_periode','setoran')->where('jenis_periode','tahfidz')->whereNull('deleted_at')->count();
        $Sertifikasi = PeriodeModel::where('judul_periode','sertifikasi')->whereNull('deleted_at')->count();
        $Periode = PeriodeModel::whereNull('deleted_at')->count();
        $TahunAjaran = TahunAjaranModel::whereNull('deleted_at')->count();
        $Kelas = KelasModel::whereNull('deleted_at')->count();
        $PresentaseSetoran = PeriodeModel::PresentasePeriode();
        return response()->json([
            'success' => true, 
            'message' => 'Data Ditemukan', 
            'peserta' => $Peserta,
            'guru' => $Guru,
            'tahsin' => $Tahsin,
            'tahfidz' => $Tahfidz,
            'sertifikasi' => $Sertifikasi,
            'periode' => $Periode,
            'tahun' => $TahunAjaran,
            'kelas' => $Kelas,
            'PresentaseSetoran' => $PresentaseSetoran
        ]);
    }

    public function LogLogin(){
        $menu = 'home';
        $submenu= 'log';
        return view ('Admin/home/logLogin',compact('menu','submenu'));
    }

    public function AjaxDataLog() {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();


        $Log = LogAksesModel::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->orderBy('created_at', 'DESC')
                ->get();
        $Persentase = LogAksesModel::Persentase();
        return response()->json([
            'success' => true, 
            'message' => 'Data Ditemukan', 
            'Log' => $Log,
            'Persentase' => $Persentase,
        ]);
    }

    public function Histori(){
        $menu = 'home';
        $submenu= 'histori';
        return view ('admin/home/histori',compact('menu','submenu'));
    }

    public function AjaxHistoriTahun() {
        $data = TahunAjaranModel::whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function AjaxHistoriPeserta($tahun) {
        $guru = session('user')['level_user'] === 'guru' ? session('user')['id'] : null;
        $peserta = PesertaKegiatan::DataDashbordGuru($tahun,$guru);
        return response()->json($peserta);
    }

    public function AjaxDataHistori($peserta, $tahun) {
        $tahfidz_baru = PenilaianModel::DataAjaxDashbort($peserta, $tahun,'tahfidz');
        $tahfidz_lama = PenilaianModel::DataAjaxDashbort($peserta, $tahun,'murajaah');
        $tahsin_baru = PenilaianModel::DataAjaxDashbort($peserta, $tahun,'tahsin');
        $tahsin_lama = PenilaianModel::DataAjaxDashbort($peserta, $tahun,'materikulasi');
        $sertifikasi = PenilaianSertifikasiModel::DataSertifDashbord($peserta, $tahun);
        return response()->json([
            'success' => true, 
            'message' => 'Data Ditemukan', 
            'tahfidz_baru' => $tahfidz_baru,
            'tahfidz_lama' => $tahfidz_lama,
            'tahsin_baru' => $tahsin_baru,
            'tahsin_lama' => $tahsin_lama,
            'sertifikasi' => $sertifikasi,
        ]);
    }
}
