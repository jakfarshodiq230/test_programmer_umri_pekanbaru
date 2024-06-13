<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\PelangganModel;

class PelangganController extends Controller
{
    public function index(){
        $menu = 'pelanggan';
        $submenu= 'pelanggan';
        return view ('Admin/pelanggan/data_pelanggan',compact('menu','submenu'));
    }
    public function AjaxData(Request $request) {
        $DataPelanggan = PelangganModel::all();
        if ($DataPelanggan == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPelanggan]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }


    public function deleteData($id)
    {
        $DataPelanggan = PelangganModel::where('id_pelanggan',$id)->first();
        if ($DataPelanggan == true) {
        $data = [
            'deleted_at' => now()->format('Y-m-d h:i:s')
        ];
            PelangganModel::where('id_pelanggan',$id)->update($data);
            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data']);
        }
    }

    public function statusData($id, $status)
    {
        $DataPelanggan = PelangganModel::where('id_pelanggan',$id)->first();
        if ($DataPelanggan == true) {
        $data = [
            'status_pelanggan' => $status
        ];
            PelangganModel::where('id_pelanggan',$id)->update($data);
            if ($status === 1) {
                return response()->json(['success' => true, 'message' => 'Berhasil Aktifkan Data']);
            } else {
                return response()->json(['success' => true, 'message' => 'Berhasil Tidak Aktifkan Data']);
            }
            
            
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Proses Data']);
        }
    }
}
