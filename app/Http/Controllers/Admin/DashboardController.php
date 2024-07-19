<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(){
        $menu = 'home';
        $submenu= 'home';
        return view ('Admin/home/dashboard',compact('menu','submenu'));
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
