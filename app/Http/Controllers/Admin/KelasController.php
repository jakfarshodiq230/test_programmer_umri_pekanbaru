<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\KelasModel;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }
    public function index(){
        $menu = 'master';
        $submenu= 'kelas';
        return view ('Admin/Kelas/data_kelas',compact('menu','submenu'));
    }
    public function AjaxData(Request $request) {
            $DataKelas = KelasModel::whereNull('deleted_at')->get();
        
        if ($DataKelas == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataKelas]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataKelas = KelasModel::where('id_kelas',$id)->first();
        if ($DataKelas == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataKelas]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'nama_kelas' => 'required|string|unique:Kelas,nama_kelas',
            ]);
    
            // Generate unique ID based on current date and count
            $tanggal = now()->format('dmy');
            $nomorUrut = KelasModel::whereDate('created_at', now()->toDateString())->count() + 1;
            $id = 'KLS' . '-' . $tanggal . '-' . $nomorUrut;
            
            // Prepare data for insertion
            $data = [
                'id_kelas' => $id,
                'nama_kelas' => $validatedData['nama_kelas'],
                'status_kelas' => '0',
                'id_user' => session('user')['id'] ?? null,
            ];

    
            // Store data into database
            $Kelas = KelasModel::create($data);
    
            // Check if data was successfully stored
            if ($Kelas) {
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $Kelas]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
            }
    
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateData($id,Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
               'nama_kelas' => 'required|string',
            ]);

            $KelasCek = KelasModel::where('id_kelas',$request->id_kelas)->first();
            if (!$KelasCek) {
                return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
            }
            // Prepare data for insertion
            $data = [
                'nama_kelas' => $validatedData['nama_kelas'],
            ];

            // Store data into database
            $Kelas = KelasModel::where('id_kelas',$request->id_kelas)->update($data);
    
            // Check if data was successfully stored
            if ($Kelas) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $Kelas]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Edit Data']);
            }
    
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }        
    }

    public function deleteData($id)
    {
        try {
            $Kelas = KelasModel::where('id_kelas',$id);

            $data = [
                'status_Kelas' => 3,
                'deleted_at' => now()->format('Y-m-d h:i:s')
            ];

            $Kelas->update($data);

            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data: ' . $e->getMessage()]);
        }
    }

    public function statusData($id, $status)
    {
        try {
            $Kelas = KelasModel::where('id_kelas',$id); // Cari Kelas berdasarkan ID

            $Kelas->update(['status_kelas' => $status]); // Update status periode Kelas

            if ($status == 1) {
                return response()->json(['success' => true, 'message' => 'Berhasil mengaktifkan data Kelas.']);
            } else {
                return response()->json(['success' => true, 'message' => 'Berhasil menonaktifkan data Kelas.']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal: ' . $e->getMessage()]); // Tangani jika terjadi kesalahan dalam pencarian atau pembaruan
        }
    }
        
}
