<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin\JenisBayarModel;

class JenisPembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }

    public function index(){
        $menu = 'master';
        $submenu= 'jenis';
        return view ('Admin/jenis_pembayaran/data_jenis_pembayaran',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
        $DataProdi = JenisBayarModel::whereNull('deleted_at')->get();
        if ($DataProdi == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataProdi]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataProdi = JenisBayarModel::where('id',$id)->first();
        if ($DataProdi == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataProdi]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'nama_pembayaran' => 'required|string|max:255|unique:jenis_bayar,nama_pembayaran',
            ]);

            $data = [
                'nama_pembayaran' => $validatedData['nama_pembayaran'],
            ];

    
            // Store data into database
            $prodi = JenisBayarModel::create($data);
    
            // Check if data was successfully stored
            if ($prodi) {
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $prodi]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }      
    }

    public function updateData($id,Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_pembayaran' => 'required|string|max:255|unique:jenis_bayar,nama_pembayaran',
            ]);

            $prodiCek = JenisBayarModel::where('id',$request->id)->first();
            if (!$prodiCek) {
                return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
            }
            $data = [
                'nama_pembayaran' => $validatedData['nama_pembayaran'],
            ];
            // Update data into database
            $prodi = JenisBayarModel::where('id',$request->id)->update($data);
    
            // Check if data was successfully Update
            if ($prodi) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $prodi]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Edit Data']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }        
    }

    public function deleteData($id)
    {
        try {
            $priode = JenisBayarModel::where('id',$id);

            $data = [
                'deleted_at' => now()->format('Y-m-d h:i:s')
            ];

            $priode->update($data);

            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data: ' . $e->getMessage()]);
        }
    }
        
}
