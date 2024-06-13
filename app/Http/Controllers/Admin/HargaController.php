<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\HargaModel;
use Illuminate\Support\Facades\Auth;

class HargaController extends Controller
{
    public function index(){
        $menu = 'master';
        $submenu= 'harga';
        return view ('Admin/harga/data_harga',compact('menu','submenu'));
    }
    public function AjaxDataHarga(Request $request) {
        if(Auth::User()->level_user == 'superadmin'){
            $DataHarga = HargaModel::whereNull('deleted_at')->get();
        }else{
            $DataHarga = HargaModel::where('id_pelanggan',Auth::User()->id_pelanggan)->whereNull('deleted_at')->get();
        }
        
        if ($DataHarga == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataHarga]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editDataHarga($id)
    {
        $DataHarga = HargaModel::where('id_harga',$id)->first();
        if ($DataHarga == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataHarga]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeDataHarga(Request $request)
    {
       // Mendapatkan tanggal saat ini
       $tanggal = now()->format('dmy');
       // Mendapatkan nomor urut terakhir + 1 (gunakan Eloquent atau Query Builder)
       $nomorUrut = HargaModel::where('id_pelanggan',Auth::User()->id_pelanggan)->whereDate('created_at', now()->toDateString())->count() + 1;

       // Membuat ID 
        if(!$nomorUrut){
            $id = Auth::User()->id_pelanggan.'-'.$tanggal.'-1';
        }else{
            $id = Auth::User()->id_pelanggan.'-'.$tanggal . '-' . $nomorUrut;
        }
       $data = [
            'id_harga' => $id,
            'judul_harga' => $request->judul_harga,
            'harga' => $request->harga,
            'id_user' => Auth::User()->id,
            'id_pelanggan' => Auth::User()->id_pelanggan
       ];
       $DataHarga = HargaModel::create($data);
        if ($DataHarga == true) {
            return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
        }
    }

    public function updateDataHarga($id,Request $request)
    {
        $cekData = HargaModel::where('id_harga',$id)->first();
        if ( $cekData == true) {
            $data = [
                'judul_harga' => $request->judul_harga,
                'harga' => $request->harga,
            ];
            $DataHarga = HargaModel::where('id_harga',$id)->update($data);
             if ($DataHarga == true) {
                 return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
             }else{
                 return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
             }
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
        
        
     }

    public function deleteDataHarga($id)
    {
        $DataHarga = HargaModel::where('id_harga',$id)->first();
        if ($DataHarga == true) {
        $data = [
            'deleted_at' => now()->format('Y-m-d h:i:s')
        ];
            HargaModel::where('id_harga',$id)->update($data);
            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data']);
        }
    }
}
