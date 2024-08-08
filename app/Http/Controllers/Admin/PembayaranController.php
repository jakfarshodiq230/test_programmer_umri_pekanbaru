<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin\BayarModel;
use App\Models\Admin\MahasiswaModel;
use App\Models\Admin\JenisBayarModel;

class PembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }

    public function index(){
        $menu = 'master';
        $submenu= 'pembayaran';
        return view ('Admin/pembayaran/data_pembayaran',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
        $DataProdi = BayarModel::GetPembayaranAll();
        $DataJenisBayar = JenisBayarModel::get();
        if ($DataProdi == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataProdi,'JenisBayar' => $DataJenisBayar ]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function DataMahasiswaID($id)
    {
        $DataMahasiswa = MahasiswaModel::GetMahasiswaID($id);
        if ($DataMahasiswa == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataMahasiswa]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataBayar = BayarModel::GetPembayaranID($id);
        if ($DataBayar == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataBayar]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'tanggal' => 'required|date',
                'id_jenis_bayar' => 'required|not_in:PILIH',
                'id_mahasiswa' => 'required|not_in:PILIH',
                'jumlah' => 'required|numeric|min:0',
            ]);            

            $data = [
                'tanggal' => $validatedData['tanggal'],
                'id_jenis_bayar' => $validatedData['id_jenis_bayar'],
                'id_mahasiswa' => $validatedData['id_mahasiswa'],
                'jumlah' => $validatedData['jumlah'],
            ];

    
            // Store data into database
            $Bayar = BayarModel::create($data);
    
            // Check if data was successfully stored
            if ($Bayar) {
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $Bayar]);
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
                'tanggal' => 'required|date',
                'id_jenis_bayar' => 'required|not_in:PILIH',
                'id_mahasiswa' => 'required|not_in:PILIH',
                'jumlah' => 'required|numeric|min:0',
            ]);            

            

            $CekBayar = BayarModel::where('id',$request->id)->first();
            if (!$CekBayar) {
                return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
            }
            $data = [
                'tanggal' => $validatedData['tanggal'],
                'id_jenis_bayar' => $validatedData['id_jenis_bayar'],
                'id_mahasiswa' => $validatedData['id_mahasiswa'],
                'jumlah' => $validatedData['jumlah'],
            ];
            // Update data into database
            $Bayar = BayarModel::where('id',$request->id)->update($data);
    
            // Check if data was successfully Update
            if ($Bayar) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $Bayar]);
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
            $priode = BayarModel::where('id',$id);

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
