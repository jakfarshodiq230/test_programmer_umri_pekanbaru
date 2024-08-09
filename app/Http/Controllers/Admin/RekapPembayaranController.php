<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Pembayaran;

use App\Models\Admin\BayarModel;

class RekapPembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }

    public function index(){
        $menu = 'master';
        $submenu= 'rekap';
        return view ('Admin/rekap/data_rekap',compact('menu','submenu'));
    }

    public function AjaxData($awal,$akhir) {
        $DataRekap = BayarModel::GetPembayaranRekap($awal,$akhir);
        if ($DataRekap == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataRekap]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function ExportExcel($awal, $akhir)
    {

        try {
            
            $fileName = 'Rekap-Pembayaran-Periode-' . $awal . '-/-' . $akhir . '.xlsx';
            
            $excelFile = Excel::raw(new Pembayaran($awal, $akhir), \Maatwebsite\Excel\Excel::XLSX);
    
            return response($excelFile, 200)
                ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        } catch (\Exception $e) {
            \Log::error('Excel generation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to generate Excel file.'], 500);
        }
    }
        
}
