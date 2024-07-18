<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use TCPDF;

use App\Models\Admin\KopModel;
class KopController extends Controller
{
    public function index(){
        $menu = 'seting';
        $submenu= 'kop';
        return view ('Admin/kop/kop',compact('menu','submenu'));
    }   

    public function storeData(Request $request) {
        try {
            // Validasi input
            $request->validate([
                'file_kop' => 'nullable|image|mimes:jpg|max:2048',
            ]);

            // Cek apakah ada gambar yang di-upload
            if ($request->hasFile('file_kop')) {
                $image = $request->file('file_kop');
                $imagePath = 'public/kop/';
                $imageName = time() . '_' . $image->getClientOriginalName();
                // Simpan data ke database (update jika ada ID, insert jika tidak)
                $data = KopModel::first();
                if ($data) {
                    // Hapus gambar lama jika ada
                    if ($data->image_kop) {
                        Storage::delete($imagePath . $data->image_kop);
                    }
                    // Update jika ID ada
                    $data->image_kop = $imageName;
                    $data->save();
                } else {
                    // Insert jika ID tidak ada
                    $data = new KopModel();
                    $data->image_kop = $imageName;
                    $data->save();
                }
                // Simpan gambar ke storage
                $image->storeAs($imagePath, $imageName);
            }
            return response()->json(['success' => true, 'message' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    } 

    public function AjaxData(Request $request) {
        $gambar = KopModel::first();
    
    if ($gambar) {
        return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $gambar]);
    }else{
        return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
    }
}
       
        
    
}
