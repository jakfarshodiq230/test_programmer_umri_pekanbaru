<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\TahunAjaranModel;

class TahunAjaranController extends Controller
{
    public function index(){
        $menu = 'master';
        $submenu= 'tahun_ajaran';
        return view ('Admin/tahun_ajaran/data_tahun_ajaran',compact('menu','submenu'));
    }
    public function AjaxData(Request $request) {
            $DataTahunAjaran = TahunAjaranModel::whereNull('deleted_at')->orderBy('status_tahun_ajaran','DESC')->get();
        
        if ($DataTahunAjaran == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataTahunAjaran]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataTahunAjaran = TahunAjaranModel::where('id_tahun_ajaran',$id)->first();
        if ($DataTahunAjaran == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataTahunAjaran]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'awal_nama_tahun_ajaran' => 'required|string',
                'akhir_nama_tahun_ajaran' => 'required|string',
            ]);
    
            // Construct the nama_tahun_ajaran
            $tahun_ajaran = $validatedData['awal_nama_tahun_ajaran'].'/'.$validatedData['akhir_nama_tahun_ajaran'];
            $cekTahun = TahunAjaranModel::where('nama_tahun_ajaran', $tahun_ajaran)->whereNull('deleted_at')->get();
            
            if (!$cekTahun->isEmpty()) {
                // If the tahun_ajaran already exists, respond with a message
                return response()->json(['success' => false, 'message' => 'Data Sudah Terdaftar']);
            } else {
                // Generate unique ID based on current date and count
                $tanggal = now()->format('dmy');
                $nomorUrut = TahunAjaranModel::whereDate('created_at', now()->toDateString())->count() + 1;
                $id = 'TA' . '-' . $tanggal . '-' . $nomorUrut;
    
                // Prepare data for insertion
                $data = [
                    'id_tahun_ajaran' => $id,
                    'nama_tahun_ajaran' => $tahun_ajaran,
                    'status_tahun_ajaran' => '0',
                    'id_user' => session('user')['id_user'],
                ];
    
                // Store data into database
                $TahunAjaran = TahunAjaranModel::create($data);
    
                // Check if data was successfully stored
                if ($TahunAjaran) {
                    return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $TahunAjaran]);
                } else {
                    return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
                }
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
               'awal_nama_tahun_ajaran' => 'required|string',
                'akhir_nama_tahun_ajaran' => 'required|string',
            ]);

            $TahunAjaranCek = TahunAjaranModel::where('id_tahun_ajaran',$request->id_tahun_ajaran)->first();
            if (!$TahunAjaranCek) {
                return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
            }
            // Prepare data for insertion
            $tahun_ajaran = $validatedData['awal_nama_tahun_ajaran'].'/'.$validatedData['akhir_nama_tahun_ajaran'];
            $data = [
                'nama_tahun_ajaran' => $tahun_ajaran,
            ];

            // Store data into database
            $TahunAjaran = TahunAjaranModel::where('id_tahun_ajaran',$request->id_tahun_ajaran)->update($data);
    
            // Check if data was successfully stored
            if ($TahunAjaran) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $TahunAjaran]);
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
            $TahunAjaran = TahunAjaranModel::where('id_tahun_ajaran',$id);

            $data = [
                'status_tahun_ajaran' => 3,
                'deleted_at' => now()->format('Y-m-d h:i:s')
            ];

            $TahunAjaran->update($data);

            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data: ' . $e->getMessage()]);
        }
    }

    public function statusData($id, $status)
    {
        try {
            if ($status == 1) {
                $CekTahunAjaran = TahunAjaranModel::where('status_tahun_ajaran','1')->get();
                if (!$CekTahunAjaran->isEmpty()) {
                    return response()->json(['error' => true, 'message' => 'Tahun Ajaran Hanya Bisa 1 Yang Di Aktif']);
                }else{
                    TahunAjaranModel::where('id_tahun_ajaran',$id)->update(['status_tahun_ajaran' => $status]); // Update status periode TahunAjaran
                    if ($status == 1) {
                        return response()->json(['success' => true, 'message' => 'Berhasil mengaktifkan data Tahun Ajaran.']);
                    } else {
                        return response()->json(['success' => true, 'message' => 'Berhasil menonaktifkan data Tahun Ajaran.']);
                    }
                }
            }else{
                TahunAjaranModel::where('id_tahun_ajaran',$id)->update(['status_tahun_ajaran' => $status]); // Update status periode TahunAjaran

                if ($status == 1) {
                    return response()->json(['success' => true, 'message' => 'Berhasil mengaktifkan data Tahun Ajaran.']);
                } else {
                    return response()->json(['success' => true, 'message' => 'Berhasil menonaktifkan data Tahun Ajaran.']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal: ' . $e->getMessage()]); // Tangani jika terjadi kesalahan dalam pencarian atau pembaruan
        }
    }
        
}
