<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\TahunAjaranModel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\PesertaKegiatan;
use App\Models\Admin\PenilaianModel;
use App\Models\Admin\PenilaianSertifikasiModel;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:guru');
    }
    public function index(){
            $menu = 'home';
            $submenu= 'home';
            return view ('Guru/home/dashboard',compact('menu','submenu'));
    }

    public function AjaxData() {
        $Periode = PeriodeModel::Dashboard();
        if ($Periode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $Periode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function statistik(){
        $menu = 'home';
        $submenu= 'statistik';
        return view ('Guru/home/statistik',compact('menu','submenu'));
    }

    public function AjaxStatistikTahun() {
        $data = TahunAjaranModel::whereNull('deleted_at')->get();
        return response()->json($data);
    }

    public function AjaxStatistikPeserta($tahun) {
        $guru = session('user')['id'];
        $peserta = PesertaKegiatan::DataDashbordGuru($tahun,$guru);
        return response()->json($peserta);
    }

    public function AjaxDataStatistik($peserta, $tahun) {
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
