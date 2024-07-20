<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\TahunAjaranModel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\PesertaKegiatan;
use App\Models\Admin\SiswaModel;
use App\Models\Admin\GuruModel;
use App\Models\Admin\KelasModel;
class PesertaKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }
    public function index(){
        $menu = 'kegiatan';
        $submenu= 'peserta';
        return view ('Admin/kegiatan/peserta/data_peserta_kegiatan',compact('menu','submenu'));
    }

    public function AjaxDataPeriode(Request $request) {
        $DataPeserta = PesertaKegiatan::DataAll();
        if ($DataPeserta == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function DataListPesertaKegiatan($id_periode,$id_tahun_ajaran){
        $menu = 'kegiatan';
        $submenu= 'peserta';
        $periode = $id_periode;
        $tahun_ajaran = $id_tahun_ajaran;
        $judul_1 = PeriodeModel::where('id_periode', $id_periode)->whereNull('deleted_at')->first();
        $judul_2 = TahunAjaranModel::where('id_tahun_ajaran', $id_tahun_ajaran)->whereNull('deleted_at')->first();
        $judul_3 = ucfirst($judul_1->jenis_periode).' '. $judul_2->nama_tahun_ajaran;
        return view ('Admin/kegiatan/peserta/data_list_peserta_kegiatan',compact('menu','submenu','periode','tahun_ajaran','judul_1','judul_2','judul_3'));
    }

    public function AjaxData($id_periode,$id_tahun_ajaran) {
        $DataPeserta = PesertaKegiatan::DataPesertaKegiatanAll($id_periode,$id_tahun_ajaran);
        
        if ($DataPeserta == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataSiswa($tahun,$periode)
    {
        $selectedIds = PesertaKegiatan::where('id_tahun_ajaran',$tahun)->where('id_periode',$periode)->pluck('id_siswa')->toArray();
        $siswa = SiswaModel::whereNotIn('id_siswa', $selectedIds)->get();
        if ($siswa->isNotEmpty()) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $siswa]);
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }
    

    public function editData($id)
    {
        $DataPeserta = PesertaKegiatan::where('id_peserta_kegiatan',$id)->first();
        $DataGuru = GuruModel::whereNull('deleted_at')->get();
        $DataSiswa = SiswaModel::whereNull('deleted_at')->get();
        $DataKelas = KelasModel::whereNull('deleted_at')->get();
        if ($DataPeserta == true) {
            return response()->json(
                [
                    'success' => true, 
                    'message' => 'Data Ditemukan', 
                    'data' => $DataPeserta,
                    'data_guru'=>$DataGuru,
                    'data_siswa'=>$DataSiswa,
                    'data_kelas'=>$DataKelas
                ]
            );
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'id_tahun_ajaran' => 'required|string',
                'id_periode' => 'required|string',
                'peserta' => 'required|string',
                'kelas' => 'required|string',
                'guru' => 'required|string',
            ]);

            $CekData = PesertaKegiatan::where('id_tahun_ajaran', $validatedData['id_tahun_ajaran'])
            ->where('id_periode', $validatedData['id_periode'])
            ->where('id_siswa', $validatedData['peserta'])
            ->where('id_kelas', $validatedData['kelas'])
            ->where('id_guru', $validatedData['guru'])
            ->whereNull('deleted_at')->get();
            
            
            if (!$CekData->isEmpty()) {
                // If the tahun_ajaran already exists, respond with a message
                return response()->json(['success' => false, 'message' => 'Data Sudah Terdaftar']);
            } else {
                // Generate unique ID based on current date and count
                $tanggal = now()->format('dmy');
                $nomorUrut = PesertaKegiatan::whereDate('created_at', now()->toDateString())->count() + 1;
                $id = 'PES' . '-' . $tanggal . '-' . $nomorUrut;
    
                // Prepare data for insertion
                $data = [
                    'id_peserta_kegiatan' => $id,
                    'id_tahun_ajaran' => $validatedData['id_tahun_ajaran'],
                    'id_periode' => $validatedData['id_periode'],
                    'id_siswa' => $validatedData['peserta'],
                    'id_kelas' => $validatedData['kelas'],
                    'id_guru' => $validatedData['guru'],
                    'status_peserta_kegiatan' => '0',
                    'id_user' => session('user')['id'],
                ];
    
                // Store data into database
                $Peserta = PesertaKegiatan::create($data);
    
                // Check if data was successfully stored
                if ($Peserta) {
                    return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $Peserta]);
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
                'id_tahun_ajaran' => 'required|string',
                'id_periode' => 'required|string',
                'peserta' => 'required|string',
                'kelas' => 'required|string',
                'guru' => 'required|string',
            ]);

            $CekData = PesertaKegiatan::where('id_tahun_ajaran', $validatedData['id_tahun_ajaran'])
            ->where('id_periode', $validatedData['id_periode'])
            ->where('id_siswa', $validatedData['peserta'])
            ->where('id_kelas', $validatedData['kelas'])
            ->where('id_guru', $validatedData['guru'])
            ->whereNull('deleted_at')->get();
            
            if (!$CekData->isEmpty()) {
                // If the tahun_ajaran already exists, respond with a message
                return response()->json(['success' => false, 'message' => 'Data Sudah Terdaftar']);
            }

            $data = [
                'id_tahun_ajaran' => $validatedData['id_tahun_ajaran'],
                'id_periode' => $validatedData['id_periode'],
                'id_siswa' => $validatedData['peserta'],
                'id_kelas' => $validatedData['kelas'],
                'id_guru' => $validatedData['guru'],
            ];
            // Store data into database
            $Peserta = PesertaKegiatan::where('id_peserta_kegiatan',$request->id_peserta_kegiatan)->update($data);
    
            // Check if data was successfully stored
            if ($Peserta) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $Peserta]);
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
            $Peserta = PesertaKegiatan::where('id_peserta_kegiatan',$id);

            $data = [
                'status_peserta_kegiatan' => 3,
                'deleted_at' => now()->format('Y-m-d h:i:s')
            ];

            $Peserta->update($data);

            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data: ' . $e->getMessage()]);
        }
    }

    public function statusData($id, $status)
    {
        try {
            PesertaKegiatan::where('id_peserta_kegiatan',$id)->update(['status_peserta_kegiatan' => $status]); // Update status Peserta Peserta
            if ($status == 1) {
                return response()->json(['success' => true, 'message' => 'Berhasil mengaktifkan data Peserta Kegiatan.']);
            } else {
                return response()->json(['success' => true, 'message' => 'Berhasil menonaktifkan data Peserta Kegiatan.']);
            }
                
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal: ' . $e->getMessage()]); // Tangani jika terjadi kesalahan dalam pencarian atau pembaruan
        }
    }

    public function statusDataAll($tahun,$periode, $status)
    {
        try {
            $dataCek = PesertaKegiatan::where('id_tahun_ajaran',$tahun)->where('id_periode',$periode)->get(); // Update status Peserta Peserta
            foreach ($dataCek as $key => $value) {
                PesertaKegiatan::where('id_peserta_kegiatan',$value->id_peserta_kegiatan)->update(['status_peserta_kegiatan' => $status]);
            }
            if ($status == 1) {
                return response()->json(['success' => true, 'message' => 'Berhasil mengaktifkan data Peserta Kegiatan.']);
            } else {
                return response()->json(['success' => true, 'message' => 'Berhasil menonaktifkan data Peserta Kegiatan.']);
            }
                
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal: ' . $e->getMessage()]); // Tangani jika terjadi kesalahan dalam pencarian atau pembaruan
        }
    }
        
}
