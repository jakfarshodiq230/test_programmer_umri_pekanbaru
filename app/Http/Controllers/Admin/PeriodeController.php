<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\TahunAjaranModel;
class PeriodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }
    public function index(){
        $menu = 'kegiatan';
        $submenu= 'periode';
        return view ('Admin/kegiatan/periode/data_periode',compact('menu','submenu'));
    }

    public function AjaxDataTahun(Request $request) {
        $DataPeriode = TahunAjaranModel::whereNull('deleted_at')->where('status_tahun_ajaran',1)->get();
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxData(Request $request) {
            $DataPeriode = PeriodeModel::DataAll();
        
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataPeriode = PeriodeModel::where('id_periode',$id)->first();
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'tahun_ajaran' => 'required|string',
                'kegiatan' => 'required|string',
            ]);
    
            // Construct the nama_tahun_ajaran
            $cekTahun = PeriodeModel::where('id_tahun_ajaran', $validatedData['tahun_ajaran'])
            ->where('jenis_periode', $validatedData['kegiatan'])
            ->where('judul_periode', 'setoran')
            ->whereNull('deleted_at')->get();
            
            if (!$cekTahun->isEmpty()) {
                // If the tahun_ajaran already exists, respond with a message
                return response()->json(['success' => false, 'message' => 'Data Sudah Terdaftar']);
            } else {
                // Generate unique ID based on current date and count
                $tanggal = now()->format('dmy');
                $nomorUrut = PeriodeModel::whereDate('created_at', now()->toDateString())->count() + 1;
                $id = 'PE' . '-' . $tanggal . '-' . $nomorUrut;
    
                // Prepare data for insertion
                $data = [
                    'id_periode' => $id,
                    'id_tahun_ajaran' => $validatedData['tahun_ajaran'],
                    'jenis_periode' => $validatedData['kegiatan'],
                    'judul_periode' => 'setoran',
                    'status_periode' => '0',
                    'id_user' => session('user')['id'],
                ];
    
                // Store data into database
                $Periode = PeriodeModel::create($data);
    
                // Check if data was successfully stored
                if ($Periode) {
                    return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $Periode]);
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
               'tahun_ajaran' => 'required|string',
                'kegiatan' => 'required|string',
            ]);

            $cekTahun = PeriodeModel::where('id_tahun_ajaran', $validatedData['tahun_ajaran'])
            ->where('jenis_periode', $validatedData['kegiatan'])
            ->where('judul_periode', 'setoran')
            ->whereNull('deleted_at')->get();
            
            if (!$cekTahun->isEmpty()) {
                // If the tahun_ajaran already exists, respond with a message
                return response()->json(['success' => false, 'message' => 'Data Sudah Terdaftar']);
            }

            $data = [
                'id_tahun_ajaran' => $validatedData['tahun_ajaran'],
                'jenis_periode' => $validatedData['kegiatan']
            ];

            // Store data into database
            $Periode = PeriodeModel::where('id_periode',$request->id_periode)->update($data);
    
            // Check if data was successfully stored
            if ($Periode) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $Periode]);
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
            $Periode = PeriodeModel::where('id_periode',$id);

            $data = [
                'status_periode' => 3,
                'deleted_at' => now()->format('Y-m-d h:i:s')
            ];

            $Periode->update($data);

            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data: ' . $e->getMessage()]);
        }
    }

    public function statusData($id, $status)
    {
        try {
            PeriodeModel::where('id_periode',$id)->update(['status_periode' => $status]); // Update status periode Periode
            if ($status == 1) {
                return response()->json(['success' => true, 'message' => 'Berhasil mengaktifkan data Periode Kegiatan.']);
            } else {
                return response()->json(['success' => true, 'message' => 'Berhasil menonaktifkan data Periode Kegiatan.']);
            }
                
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal: ' . $e->getMessage()]); // Tangani jika terjadi kesalahan dalam pencarian atau pembaruan
        }
    }
        
}
