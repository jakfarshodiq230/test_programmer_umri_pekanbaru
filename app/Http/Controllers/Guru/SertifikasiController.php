<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Pdf\CustomPdf;

use App\Models\Admin\PeriodeModel;
use App\Models\Admin\SurahModel;

use App\Models\Guru\RaporKegiatanModel;
use App\Models\Guru\PenilaianPengembanganDiriModel;

class SertifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:guru');
    }
    public function index(){
        $menu = 'sertifikasi';
        $submenu= 'penilaian-sertifikasi';
        return view ('Guru/sertifikasi/peserta/data_peserta_sertifikasi',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
            $DataPeriode = PeriodeModel::DataPesertaSertifikasi();
        
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    } 
}
