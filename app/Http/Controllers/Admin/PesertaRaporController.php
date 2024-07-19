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

class PesertaRaporController extends Controller
{
    public function index(){
        $menu = 'rapor';
        $submenu= 'peserta-rapor';
        return view ('Admin/rapor/peserta/data_peserta_rapor',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
            $DataPeriode = PeriodeModel::DataPesertaRapor();
        
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function SyncRapor($tahun, $jenisRapor, $periode)
    {
        try {
            // List data periode
            $dataPeriode = PeriodeModel::where('id_periode', $periode)
            ->where('id_tahun_ajaran', $tahun)
            ->first();
            $DataPesertaPeriode = PesertaKegiatan::DataPesertaRapor($tahun, $jenisRapor, $dataPeriode->tggl_awal_periode, $dataPeriode->tggl_akhir_periode);
    
            // Convert stdClass objects to arrays
            $DataPesertaPeriode = json_decode(json_encode($DataPesertaPeriode), true);
    
            foreach ($DataPesertaPeriode as $value) {
                $tanggal = now()->format('dmy');
                $nomorUrut = RaporKegiatanModel::whereDate('created_at', now()->toDateString())->count() + 1;
                $id = 'RAP' . '-' . $tanggal . '-' . $nomorUrut;
            
                // Example of checking and setting default values for missing keys
                $data = [
                    'id_rapor' => $id,
                    'id_tahun_ajaran' => $value['id_tahun_ajaran'] ?? null,
                    'id_periode' => $periode ?? null,
                    'id_siswa' => $value['id_siswa'] ?? null,
                    'id_kelas' => $value['id_kelas'] ?? null,
                    'id_guru' => $value['id_guru'] ?? null,
                    'jenis_penilaian_kegiatan' => $value['jenis_periode'] ?? null,
                    'surah_baru' => $value['surah_baru'] ?? null,
                    'surah_lama' => $value['surah_lama'] ?? null,
                    'n_j_baru' => $value['nilai_tajwid_baru'] ?? null,
                    'n_f_baru' => $value['nilai_fasohah_baru'] ?? null,
                    'n_k_baru' => $value['nilai_kelancaran_baru'] ?? null,
                    'n_g_baru' => $value['nilai_ghunnah_baru'] ?? null,
                    'n_m_baru' => $value['nilai_mad_baru'] ?? null,
                    'n_w_baru' => $value['nilai_waqof_baru'] ?? null,
                    'n_j_lama' => $value['nilai_tajwid_lama'] ?? null,
                    'n_f_lama' => $value['nilai_fasohah_lama'] ?? null,
                    'n_k_lama' => $value['nilai_kelancaran_lama'] ?? null,
                    'n_g_lama' => $value['nilai_ghunnah_lama'] ?? null,
                    'n_m_lama' => $value['nilai_mad_lama'] ?? null,
                    'n_w_lama' => $value['nilai_waqof_lama'] ?? null,
                    'id_user' => session('user')['id_user'],
                ];
            
                // Ensure necessary keys are present and valid before processing
                if (isset($value['id_tahun_ajaran'], $periode, $value['id_siswa'])) {
                    try {
                        // Check if the record already exists
                        $existingRecord = RaporKegiatanModel::where('id_siswa', $value['id_siswa'])
                            ->where('id_periode', $periode)
                            ->where('id_tahun_ajaran', $value['id_tahun_ajaran'])
                            ->first();
            
                        if ($existingRecord) {
                            // Update the existing record
                            $existingRecord->update($data);
                        } else {
                            // Insert a new record
                            RaporKegiatanModel::create($data);
                        }
                    } catch (\Exception $e) {
                        // Handle exceptions
                        return response()->json(['error' => true, 'message' => $e->getMessage()]);
                    }
                }
            }
    
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    
    public function DataPeserta($tahun,$jenjang,$periode){
        $menu = 'rapor';
        $submenu= 'peserta-rapor';
        return view ('Admin/rapor/peserta/list_pesrta_rapor',compact('menu','submenu','tahun','jenjang','periode'));
    }  

    public function AjaxDataPesertaRapor($tahun,$jenjang,$periode) {
        $DataPeserta = RaporKegiatanModel::DataPesertaRapor($tahun,$jenjang,$periode);
        $DataPeriode = PeriodeModel:: DataPeriodeRapor($tahun,$jenjang,$periode);
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'peserta' => $DataPeserta,'periode'=>$DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
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
