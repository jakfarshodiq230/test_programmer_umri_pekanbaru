<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\TahunAjaranModel;
use App\Models\Admin\RaporKegiatanModel;
use App\Models\Admin\PesertaKegiatan;
class PeriodeSertifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }
    public function index(){
        $menu = 'ujian';
        $submenu= 'periode-sertifikasi';
        return view ('Admin/sertifikasi/periode/data_periode',compact('menu','submenu'));
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
            $DataPeriode = PeriodeModel::DataSertifikat();
        
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
                'sertifikasi' => 'required|string',
                'tahun_ajaran' => 'required|string',
                'tggl_akhir_penilaian' => 'required|date',
                'tggl_sertifikasi' => 'required|date',
                'tanggungjawab_sertifikasi' => 'required|string',
                'juz_sertifikasi' => 'required|string',
                'sesi_sertifikasi' => 'required|string',
                'file_sertifikat' => 'nullable|file|mimes:jpeg,jpg|max:2048'
            ]);
    
            // Construct the nama_tahun_ajaran
            $cekTahun = PeriodeModel::where('id_tahun_ajaran', $validatedData['tahun_ajaran'])
            ->where('jenis_periode', $validatedData['sertifikasi'])
            ->where('juz_periode', $validatedData['juz_sertifikasi'])
            ->where('judul_periode', 'sertifikasi')
            ->whereNull('deleted_at')->get();
            
            $tanggal = now()->format('dmy');
            $nomorUrut = PeriodeModel::whereDate('created_at', now()->toDateString())->count() + 1;
            $id = 'PE' . '-' . $tanggal . '-' . $nomorUrut;


            if (!$cekTahun->isEmpty()) {
                // If the tahun_ajaran already exists, respond with a message
                return response()->json(['success' => false, 'message' => 'Sertifikasi Sudah Terdaftar']);
            } else {
                // Prepare data for insertion
                $data = [
                    'id_periode' => $id,
                    'id_tahun_ajaran' => $validatedData['tahun_ajaran'],
                    'jenis_periode' => $validatedData['sertifikasi'],
                    'tggl_akhir_penilaian' => $validatedData['tggl_akhir_penilaian'],
                    'tggl_periode' => $validatedData['tggl_sertifikasi'],
                    'tanggungjawab_periode' => $validatedData['tanggungjawab_sertifikasi'],
                    'juz_periode' => $validatedData['juz_sertifikasi'],
                    'sesi_periode' => $validatedData['sesi_sertifikasi'],
                    'judul_periode' => 'sertifikasi',
                    'status_periode' => '0',
                    'id_user' => session('user')['id'],
                ];

                // Handle file upload if exists
                if ($request->hasFile('file_sertifikat')) {
                    $image = $request->file('file_sertifikat');
                    $imagePath = 'public/sertifikat/';
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    
                    $data['file_periode'] = $imageName;

                    $dataModel = new PeriodeModel(); 
                    $dataModel->fill($data);
                    $dataModel->save();

                    $image->storeAs($imagePath, $imageName);
                } else {
                    $dataModel = new PeriodeModel(); 
                    $dataModel->fill($data);
                    $dataModel->save();
                }
    
                // Check if data was successfully stored
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
            }
    
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    

    public function updateData($id, Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'sertifikasi' => 'required|string',
                'tahun_ajaran' => 'required|string',
                'tggl_akhir_penilaian' => 'required|date',
                'tggl_sertifikasi' => 'required|date',
                'tanggungjawab_sertifikasi' => 'required|string',
                'juz_sertifikasi' => 'required|string',
                'sesi_sertifikasi' => 'required|string',
                'file_sertifikat' => 'nullable|file|mimes:jpeg,jpg|max:2048'
            ]);
    
            $record = PeriodeModel::find($id);
            $data = [
                'id_tahun_ajaran' => $validatedData['tahun_ajaran'],
                'jenis_periode' => $validatedData['sertifikasi'],
                'tggl_akhir_penilaian' => $validatedData['tggl_akhir_penilaian'],
                'tggl_periode' => $validatedData['tggl_sertifikasi'],
                'tanggungjawab_periode' => $validatedData['tanggungjawab_sertifikasi'],
                'juz_periode' => $validatedData['juz_sertifikasi'],
                'sesi_periode' => $validatedData['sesi_sertifikasi'],
                'judul_periode' => 'sertifikasi',
                'status_periode' => '0',
            ];
    
            if ($request->hasFile('file_sertifikat')) {
                $image = $request->file('file_sertifikat');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = 'public/sertifikat/';
    
                // Check if the record has an old file and delete it
                if ($record && $record->file_periode) {
                    $fullPath = $imagePath . basename($record->file_periode);
                    if (Storage::exists($fullPath)) {
                        Storage::delete($fullPath);
                    }
                }
    
                // Update data with new file name
                $data['file_periode'] = $imageName;
                // Store the new file
                $image->storeAs('public/sertifikat', $imageName);
            }
    
            // Store data into database
            $Periode = PeriodeModel::where('id_periode', $id)->update($data);
    
            // Fetch the updated record
            $updatedRecord = PeriodeModel::find($id);
    
            // Check if data was successfully stored
            if ($Periode) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Edit Data',
                    'data' => $updatedRecord
                ]);
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
                return response()->json(['success' => true, 'message' => 'Berhasil mengaktifkan data Periode rapor.']);
            } else {
                return response()->json(['success' => true, 'message' => 'Berhasil menonaktifkan data Periode rapor.']);
            }
                
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal: ' . $e->getMessage()]); // Tangani jika terjadi kesalahan dalam pencarian atau pembaruan
        }
    }
    
        
}
