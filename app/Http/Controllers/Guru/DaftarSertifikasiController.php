<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Pdf\CustomPdf;

use App\Models\Admin\PeriodeModel;
use App\Models\Admin\PesertaKegiatan;
use App\Models\Admin\PesertaSertifikasiModel;

class DaftarSertifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:guru');
    }
    public function index(){
        $menu = 'sertifikasi';
        $submenu= 'daftar-sertifikasi';
        return view ('Guru/sertifikasi/peserta/data_peserta_sertifikasi',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
        $DataPeriode = PeriodeModel::DataPesertaSertifikasi();
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    } 

    public function listDaftar($tahun,$sertifikasi,$periode){
        $menu = 'sertifikasi';
        $submenu= 'daftar-sertifikasi';
        return view ('Guru/sertifikasi/peserta/list_daftar_sertifikasi',compact('menu','submenu','tahun','sertifikasi','periode'));
    }

    public function DataPeserta($tahun,$sertifikasi,$periode){
        $selectedIds = PesertaSertifikasiModel::where('id_tahun_ajaran', $tahun)
            ->where('id_periode', $periode)
            ->whereNull('deleted_at')
            ->pluck('id_siswa') // Ensure 'id_siswa' is the correct column name
            ->toArray();
        $DataPeserta = PesertaKegiatan::DataDaftarPeserta($tahun, $sertifikasi, $periode, $selectedIds);

        $DataPeriode = PeriodeModel::DataPeriodeRapor($tahun,$sertifikasi,$periode);
        if ($DataPeserta == true) {
            return response()->json([
                'success' => true,
                'message' => 'Data Ditemukan',
                'peserta' => $DataPeserta,
                'periode' => $DataPeriode,
            ]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            
            $validatedData = $request->validate([
                'siswa' => 'required|not_in:PILIH,other',
                'id_tahun' => 'required',
                'id_periode' => 'required',
                'id_kelas' => 'required',
                'id_guru' => 'required',
            ]);
            
            
            // Generate unique ID based on current date and count
            $tanggal = now()->format('dmy');
            $nomorUrut = PesertaSertifikasiModel::whereDate('created_at', now()->toDateString())->count() + 1;
            $id = 'PES-SERT' . '-' . $tanggal . '-' . $nomorUrut;
            $data = [
                'id_peserta_sertifikasi' => $id,
                'id_tahun_ajaran' => $validatedData['id_tahun'],
                'id_periode' => $validatedData['id_periode'],
                'id_siswa' => $validatedData['siswa'],
                'id_kelas' => $validatedData['id_kelas'],
                'id_guru' => $validatedData['id_guru'],
                'status_peserta_sertifikasi' => 0,
                'id_user' => session('user')['id'],
            ];
            // Store data into database
            $DaftarPeserta = PesertaSertifikasiModel::create($data);
    
            // Check if data was successfully stored
            if ($DaftarPeserta) {
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function AjaxDataDaftarPeserta($tahun,$sertifikasi,$periode) {
        $ListPeserta = PesertaSertifikasiModel::DataPesertaSertifikasi($tahun,$sertifikasi,$periode);
        if ($ListPeserta) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $ListPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    } 

    public function deleteData($id)
    {
        try {
            $Peserta = PesertaSertifikasiModel::where('id_peserta_sertifikasi',$id);

            $data = [
                'status_peserta_sertifikasi' => 3,
                'deleted_at' => now()->format('Y-m-d h:i:s')
            ];

            $Peserta->update($data);

            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data: ' . $e->getMessage()]);
        }
    }
}
