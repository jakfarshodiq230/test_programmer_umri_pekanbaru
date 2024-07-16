<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\SurahModel;

use App\Models\Guru\RaporKegiatanModel;
use App\Models\Guru\PenilaianPengembanganDiriModel;

class PenilaianRaporGuruController extends Controller
{
    public function index(){
        $menu = 'rapor';
        $submenu= 'penilaian-rapor';
        return view ('Guru/rapor/peserta/data_peserta_rapor',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
            $DataPeriode = PeriodeModel::DataPesertaRapor();
        
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }
    
    public function DataPeserta($tahun,$jenjang,$periode){
        $menu = 'rapor';
        $submenu= 'penilaian-rapor';
        return view ('Guru/rapor/peserta/list_pesrta_rapor',compact('menu','submenu','tahun','jenjang','periode'));
    }  

    public function AjaxDataPesertaRapor($tahun,$jenjang,$periode) {
        $selectedIds = PenilaianPengembanganDiriModel::where('id_tahun_ajaran',$tahun)->where('jenis_penilaian_kegiatan',$jenjang)->where('id_periode',$periode)->pluck('id_siswa')->toArray();
        $DataPeserta = RaporKegiatanModel::DataPesertaRapor($tahun,$jenjang,$periode,$selectedIds);

        $DataNilai = RaporKegiatanModel::DataNilaiRapor($tahun,$jenjang,$periode);
        $DataPeriode = PeriodeModel:: DataPeriodeRapor($tahun,$jenjang,$periode);
        $DataSurah = SurahModel::get();
        if ($DataPeriode == true) {
            return response()->json([
                'success' => true, 
                'message' => 'Data Ditemukan', 
                'peserta' => $DataPeserta,
                'periode'=>$DataPeriode,
                'surah' => $DataSurah,
                'nilai' => $DataNilai,
            ]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            // Validate incoming request data
            if ($request->jenis_penilaian_kegiatan === 'tahfidz') {
                $validatedData = $request->validate([
                    'id_rapor' => 'required',
                    'id_tahun_ajaran' => 'required',
                    'id_periode' => 'required',
                    'id_siswa' => 'required',
                    'id_kelas' => 'required',
                    'id_guru' => 'required',
                    'jenis_penilaian_kegiatan' => 'required',
                    'awal_surah_baru' => 'required',
                    'akhir_surah_baru' => 'required',
                    'awal_ayat_baru' => 'required',
                    'akhir_ayat_baru' => 'required',
                    'awal_surah_lama' => 'required',
                    'akhir_surah_lama' => 'required',
                    'awal_ayat_lama' => 'required',
                    'akhir_ayat_lama' => 'required',
                    'n_k_p_k' => 'required',
                    'n_m_p_k' => 'required',
                    'n_t_p_k' => 'required',
                    'n_th_p_k' => 'required',
                    'n_tf_p_k' => 'required',
                    'n_jk_p_k' => 'required',
                    'tggl_penilaian_p' => 'required | date',
                    'ketrangan_p' => 'required|string',
                ]);
            } else {
                $validatedData = $request->validate([
                    'id_rapor' => 'required',
                    'id_tahun_ajaran' => 'required',
                    'id_periode' => 'required',
                    'id_siswa' => 'required',
                    'id_kelas' => 'required',
                    'id_guru' => 'required',
                    'jenis_penilaian_kegiatan' => 'required',
                    'awal_surah_baru' => 'required',
                    'akhir_surah_baru' => 'required',
                    'awal_ayat_baru' => 'required',
                    'akhir_ayat_baru' => 'required',
                    'awal_surah_lama' => 'required',
                    'akhir_surah_lama' => 'required',
                    'awal_ayat_lama' => 'required',
                    'akhir_ayat_lama' => 'required',
                    'n_k_p_k' => 'required',
                    'n_m_p_k' => 'required',
                    'n_t_p_k' => 'required',
                    'n_th_p_k' => 'required',
                    'n_tf_p_k' => 'required',
                    'n_jk_p_k' => 'required',
                    'tggl_penilaian_p' => 'required | date',
                    'ketrangan_p' => 'required|string',
                ]);
            }
            
            
    
            // Generate unique ID based on current date and count
            $tanggal = now()->format('dmy');
            $nomorUrut = PenilaianPengembanganDiriModel::whereDate('created_at', now()->toDateString())->count() + 1;
            $id = 'PNGM' . '-' . $tanggal . '-' . $nomorUrut;

            // Prepare data for insertion
            if ($request->jenis_penilaian_kegiatan === 'tahfidz') {
                $data = [
                    'id_pengembangan_diri' => $id,
                    'id_rapor' => $validatedData['id_rapor'],
                    'id_tahun_ajaran' => $validatedData['id_tahun_ajaran'],
                    'id_periode' => $validatedData['id_periode'],
                    'id_siswa' => $validatedData['id_siswa'],
                    'id_kelas' => $validatedData['id_kelas'],
                    'id_guru' => $validatedData['id_guru'],
                    'jenis_penilaian_kegiatan' => $validatedData['jenis_penilaian_kegiatan'],
                    'awal_surah_baru' => $validatedData['awal_surah_baru'],
                    'akhir_surah_baru' => $validatedData['akhir_surah_baru'],
                    'awal_ayat_baru' => $validatedData['awal_ayat_baru'],
                    'akhir_ayat_baru' => $validatedData['akhir_ayat_baru'],
                    'awal_surah_lama' => $validatedData['awal_surah_lama'],
                    'akhir_surah_lama' => $validatedData['akhir_surah_lama'],
                    'awal_ayat_lama' => $validatedData['awal_ayat_lama'],
                    'akhir_ayat_lama' => $validatedData['akhir_ayat_lama'],
                    'n_k_p' => $validatedData['n_k_p_k'],
                    'n_m_p' => $validatedData['n_m_p_k'],
                    'n_t_p' => $validatedData['n_t_p_k'],
                    'n_th_p' => $validatedData['n_th_p_k'],
                    'n_tf_p' => $validatedData['n_tf_p_k'],
                    'n_jk_p' => $validatedData['n_jk_p_k'],
                    'tggl_penilaian_p' => $validatedData['tggl_penilaian_p'],
                    'ketrangan_p' => $validatedData['ketrangan_p'],
                    'id_user' => 'GR-230624-3',
                ];
            } else {
                $data = [
                    'id_pengembangan_diri',
                    'id_rapor' => $validatedData['id_rapor'],
                    'id_tahun_ajaran' => $validatedData['id_tahun_ajaran'],
                    'id_periode' => $validatedData['id_periode'],
                    'id_siswa' => $validatedData['id_siswa'],
                    'id_kelas' => $validatedData['id_kelas'],
                    'id_guru' => $validatedData['id_guru'],
                    'jenis_penilaian_kegiatan' => $validatedData['jenis_penilaian_kegiatan'],
                    'awal_surah_baru' => $validatedData['awal_surah_baru'],
                    'akhir_surah_baru' => $validatedData['akhir_surah_baru'],
                    'awal_ayat_baru' => $validatedData['awal_ayat_baru'],
                    'akhir_ayat_baru' => $validatedData['akhir_ayat_baru'],
                    'awal_surah_lama' => $validatedData['awal_surah_lama'],
                    'akhir_surah_lama' => $validatedData['akhir_surah_lama'],
                    'awal_ayat_lama' => $validatedData['awal_ayat_lama'],
                    'akhir_ayat_lama' => $validatedData['akhir_ayat_lama'],
                    'n_k_p' => $validatedData['n_k_p_k'],
                    'n_m_p' => $validatedData['n_m_p_k'],
                    'n_t_p' => $validatedData['n_t_p_k'],
                    'n_th_p' => $validatedData['n_th_p_k'],
                    'n_tf_p' => $validatedData['n_tf_p_k'],
                    'n_jk_p' => $validatedData['n_jk_p_k'],
                    'tggl_penilaian_p' => $validatedData['tggl_penilaian_p'],
                    'ketrangan_p' => $validatedData['ketrangan_p'],
                    'id_user' => 'GR-230624-3',
                ];
            }
            

    
            // Store data into database
            $Penialai = PenilaianPengembanganDiriModel::create($data);
    
            // Check if data was successfully stored
            if ($Penialai) {
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $Penialai]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
            }
    
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function DataDetailPeserta($id,$peserta,$tahun,$jenjang,$periode){
        $menu = 'rapor';
        $submenu= 'penilaian-rapor';
        return view ('Guru/rapor/peserta/detail_peserta_rapor',compact('menu','submenu','id','peserta','tahun','jenjang','periode'));
    } 

    public function AjaxDataDetailPesertaRapor($id,$peserta,$tahun,$jenjang,$periode) {
        $DataNilaiPeserta = PenilaianPengembanganDiriModel::DataAjaxPesertaRapor($id,$peserta,$tahun,$jenjang,$periode);
        if ($DataNilaiPeserta) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataNilaiPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }
}
