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
use App\Models\Admin\PesertaSertifikasiModel;
use App\Models\Guru\PenilaianPengembanganDiriModel;
use App\Models\Admin\GuruModel;
use App\Pdf\CustomPdf;

class PesertaSertifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }
    public function index(){
        $menu = 'ujian';
        $submenu= 'peserta-sertifikasi';
        return view ('Admin/sertifikasi/peserta/data_peserta_sertifikasi',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
            $DataPeriode = PeriodeModel::DataPesertaSertifikasi();
        
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }
    
    public function DataPeserta($tahun,$jenjang,$periode){
        $menu = 'ujian';
        $submenu= 'peserta-sertifikasi';
        return view ('Admin/sertifikasi/peserta/list_pesrta_sertifikasi',compact('menu','submenu','tahun','jenjang','periode'));
    }  

    public function AjaxDataPesertaSertifikasi($tahun,$jenjang,$periode) {
        $DataPeserta = PesertaSertifikasiModel::DataPesertaSertifikasi($tahun,$jenjang,$periode);
        $DataPeriode = PeriodeModel:: DataPeriodeRapor($tahun,$jenjang,$periode);
        // peserta
        $DataPesertaPenguji = PesertaSertifikasiModel::DataDaftarPeserta($tahun, $jenjang, $periode);
        $DataGuru = GuruModel::get();

        if ($DataPeriode) {
            return response()->json([
                'success' => true,
                'message' => 'Data Ditemukan', 
                'peserta' => $DataPeserta,
                'periode'=>$DataPeriode,
                'listPeserta' => $DataPesertaPenguji,
                'guru' => $DataGuru
            ]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function StoreData(Request $request) {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'peserta' => 'required|string',
                'penguji' => 'required|string',
            ]);
    
            // Prepare data for insertion
            $data = [
                'id_peserta_sertifikasi' => $validatedData['peserta'],
                'id_penguji' => $validatedData['penguji'],
                'id_user' => session('user')['id'],
            ];

            $Peserta = PesertaSertifikasiModel::where('id_peserta_sertifikasi', $validatedData['peserta'])->update($data);
            if ($Peserta) {
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Penguji Sertifikasi']);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Tambah Penguji Sertifikasi']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function ResetData($id,$peserta,$tahun,$periode,Request $request) {
        try {
            $Peserta = PesertaSertifikasiModel::where([
                ['id_peserta_sertifikasi', $id],
                ['id_siswa', $peserta],
                ['id_tahun_ajaran', $tahun],
                ['id_periode', $periode]
            ])->first();
        
            if ($Peserta) {
                // Update the record if it exists
                PesertaSertifikasiModel::where('id_peserta_sertifikasi', $id)
                    ->update(['id_penguji' => null]);
                    
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Reset Penguji Sertifikasi'
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Gagal Reset Penguji Sertifikasi'
                ]);
            }
        
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }        
    }


    public function DataDetailPeserta($id,$peserta,$tahun,$jenjang,$periode){
        $menu = 'rapor';
        $submenu= 'peserta-rapor';
        return view ('Admin/rapor/peserta/detail_peserta_rapor',compact('menu','submenu','id','peserta','tahun','jenjang','periode'));
    } 

    public function AjaxDataDetailPesertaRapor($id,$peserta,$tahun,$jenjang,$periode) {
        $DataPeserta = RaporKegiatanModel::DataAjaxPesertaRapor($id,$peserta,$tahun,$jenjang,$periode);
        if ($DataPeserta) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }
}
