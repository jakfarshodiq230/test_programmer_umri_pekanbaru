<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin\HargaModel;
use App\Models\Admin\PembelianModel;
use App\Models\Admin\RincianModel;
use App\Models\Admin\PenjualanModel;
use App\Models\Admin\RincianPenjualanModel;
use App\Models\Admin\PengeluaranModel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\RincianPembukuanModel;
use App\Models\Admin\PembukuanModel;
use App\Models\Admin\PelangganModel;
use App\Models\Admin\AksesModel;
use App\Models\User;
class HomeController extends Controller
{
    // home
    public function index(){
        $menu = 'main';
        $submenu= 'home';
        $Pengeluaran = PengeluaranModel:: SumDashboard(Auth::User()->id_pelanggan);
        $Pembelian = PembelianModel:: SumDashboard(Auth::User()->id_pelanggan);
        $Penjualan = PenjualanModel:: SumDashboard(Auth::User()->id_pelanggan);
    	return view ('Admin/home/home',compact('menu','submenu','Pengeluaran','Pembelian','Penjualan'));
    }

    public function pelanggan(){
        $menu = 'main';
        $submenu= 'akses_pelanggan';
        $PelangganAktif = PelangganModel::where('status_pelanggan',1)->count();
        $PelangganTidakAktif = PelangganModel::where('status_pelanggan',0)->count();
        $UserAktif = User::where('status_user',1)->count();
        $UserTidakAktif = User::where('status_user',0)->count();
    	return view ('Admin/home/akses_pelanggan',compact('menu','submenu','PelangganAktif','PelangganTidakAktif','UserAktif','UserTidakAktif'));
    }

    public function AjaxDataPengunjung(Request $request) {
        $DataPengunjung = AksesModel::DataPelangganAkses();
        
        if ($DataPengunjung == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPengunjung]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxHapusPengunjung(Request $request) {
        $DataPengunjung = AksesModel::truncate();
        
        if ($DataPengunjung == true) {
            return response()->json(['success' => true, 'message' => 'Data Berhasil Dihapus']);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataPembelian(Request $request) {
        $DataPembelian = RincianModel::datahariIni(Auth::User()->id_pelanggan);
        
        if ($DataPembelian == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPembelian]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataPenjualan(Request $request) {
        $DataPenjualan = RincianPenjualanModel::datahariIni(Auth::User()->id_pelanggan);
        
        if ($DataPenjualan == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPenjualan]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataPengeluaran(Request $request) {
        $DataPengeluaran = PengeluaranModel::datahariIni(Auth::User()->id_pelanggan);
        
        if ($DataPengeluaran == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPengeluaran]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function statistik(){
        $menu = 'main';
        $submenu= 'home';
    	return view ('Admin/home/statistik',compact('menu','submenu'));
    }

    public function AjaxDataStatistik(Request $request) {
        $DataStatistik = PembukuanModel::DataStatistikPembukuan(Auth::User()->id_pelanggan);
        if ($DataStatistik == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataStatistik]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }
}
