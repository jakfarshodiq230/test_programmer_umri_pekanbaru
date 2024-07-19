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
use App\Models\Admin\SiswaModel;
use App\Models\Admin\GuruModel;
use App\Models\Admin\KelasModel;
use App\Models\Admin\PenilaianModel;
use App\Models\Admin\PenilaianSmModel;
use App\Models\Admin\SurahModel;

class DashboardController extends Controller
{
    public function index(){
        $menu = 'home';
        $submenu= 'home';
        return view ('Guru/home/dashboard',compact('menu','submenu'));
    }

    public function AjaxDataPeriode($guru) {
        $DataPeserta = PesertaKegiatan::DataAllGuru($guru);
        if ($DataPeserta == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }
}
