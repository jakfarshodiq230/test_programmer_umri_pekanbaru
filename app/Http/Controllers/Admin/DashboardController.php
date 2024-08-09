<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin\MahasiswaModel;
use App\Models\Admin\BayarModel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }

    public function index(){
        $menu = 'master';
        $submenu= 'dashboard';
        return view ('Admin/home/dashboard',compact('menu','submenu'));
    }

    public function AjaxData() {
        $mahasiswa = MahasiswaModel::whereNull('deleted_at')->count();
        $pembayaran_now = BayarModel::whereNull('deleted_at')
        ->whereDate('tanggal', Carbon::today())
        ->sum('jumlah');
        $total_bayar = BayarModel::whereNull('deleted_at')->sum('jumlah');
        return response()->json([
            'success' => true, 
            'message' => 'Data Ditemukan', 
            'mahasiswa' => $mahasiswa,
            'pembayaran_now' => $pembayaran_now,
            'total_bayar' => $total_bayar,
        ]);
    }
        
}
