<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin\ProdiModel;

class ProdiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }

    public function index(){
        $menu = 'master';
        $submenu= 'prodi';
        return view ('Admin/prodi/data_prodi',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
        $DataProdi = ProdiModel::whereNull('deleted_at')->get();
        if ($DataProdi == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataProdi]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataProdi = ProdiModel::where('id',$id)->first();
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
                'nama_prodi' => 'required|string|max:255|unique:mtr_prodi,nama_prodi',
            ]);

            $data = [
                'nama_prodi' => $validatedData['nama_prodi'],
            ];

    
            // Store data into database
            $prodi = ProdiModel::create($data);
    
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
                'nama_prodi' => 'required|string|max:255|unique:mtr_prodi,nama_prodi',
            ]);

            $prodiCek = ProdiModel::where('id',$request->id)->first();
            if (!$prodiCek) {
                return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
            }
            $data = [
                'nama_prodi' => $validatedData['nama_prodi'],
            ];
            // Update data into database
            $prodi = ProdiModel::where('id',$request->id)->update($data);
    
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
            $priode = ProdiModel::where('id',$id);

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
