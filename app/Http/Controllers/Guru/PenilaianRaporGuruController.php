<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Pdf\CustomPdf;

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
                    'n_th_p_k' => 'required',
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
                    'n_th_p' => $validatedData['n_th_p_k'],
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

    public function AjaxHapusPenilaianPengembanganDiriPesertaRapor($id,$idRapor,$peserta,$tahun,$jenjang,$periode) {
        $DataNilaiPeserta = PenilaianPengembanganDiriModel::where('id_pengembangan_diri',$id)
        ->where('id_rapor',$idRapor)
        ->where('id_siswa',$peserta)
        ->where('id_tahun_ajaran',$tahun)
        ->where('jenis_penilaian_kegiatan',$jenjang)
        ->where('id_periode',$periode)
        ->first();
        if ($DataNilaiPeserta) {
            PenilaianPengembanganDiriModel::where('id_pengembangan_diri',$id)->delete();
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataNilaiPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }


    public function AjaxEditPenilaianPengembanganDiriPesertaRapor($id,$idRapor,$peserta,$tahun,$jenjang,$periode) {
        $DataNilaiPeserta = PenilaianPengembanganDiriModel::DataAjaxEditPenilaianRapor($id,$idRapor,$peserta,$tahun,$jenjang,$periode);

        $DataSurah = SurahModel::get();

        if ($DataNilaiPeserta) {
            return response()->json([
                'success' => true,
                'message' => 'Data Ditemukan', 
                'data' => $DataNilaiPeserta,
                'surah' => $DataSurah,
            ]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function updateData($id, Request $request)
    {
        try {
            // Validate incoming request data
            if ($request->jenis_penilaian_kegiatan === 'tahfidz') {
                $validatedData = $request->validate([
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
                    'awal_surah_baru' => 'required',
                    'akhir_surah_baru' => 'required',
                    'awal_ayat_baru' => 'required',
                    'akhir_ayat_baru' => 'required',
                    'awal_surah_lama' => 'required',
                    'akhir_surah_lama' => 'required',
                    'awal_ayat_lama' => 'required',
                    'akhir_ayat_lama' => 'required',
                    'n_k_p_k' => 'required',
                    'n_th_p_k' => 'required',
                    'n_jk_p_k' => 'required',
                    'tggl_penilaian_p' => 'required | date',
                    'ketrangan_p' => 'required|string',
                ]);
            }

            // Prepare data for insertion
            if ($request->jenis_penilaian_kegiatan === 'tahfidz') {
                $data = [
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
                    'awal_surah_baru' => $validatedData['awal_surah_baru'],
                    'akhir_surah_baru' => $validatedData['akhir_surah_baru'],
                    'awal_ayat_baru' => $validatedData['awal_ayat_baru'],
                    'akhir_ayat_baru' => $validatedData['akhir_ayat_baru'],
                    'awal_surah_lama' => $validatedData['awal_surah_lama'],
                    'akhir_surah_lama' => $validatedData['akhir_surah_lama'],
                    'awal_ayat_lama' => $validatedData['awal_ayat_lama'],
                    'akhir_ayat_lama' => $validatedData['akhir_ayat_lama'],
                    'n_k_p' => $validatedData['n_k_p_k'],
                    'n_th_p' => $validatedData['n_th_p_k'],
                    'n_jk_p' => $validatedData['n_jk_p_k'],
                    'tggl_penilaian_p' => $validatedData['tggl_penilaian_p'],
                    'ketrangan_p' => $validatedData['ketrangan_p'],
                    'id_user' => 'GR-230624-3',
                ];
            }
            
            // Store data into database
            $Penialai = PenilaianPengembanganDiriModel::where('id_pengembangan_diri',$id)->update($data);
    
            // Check if data was successfully stored
            if ($Penialai) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $Penialai]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Edit Data']);
            }
    
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function CetakRapor($id,$idRapor,$peserta,$tahun,$jenjang,$periode){
        $pdf = new CustomPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Bukti Pembelian');

        // Remove default header/footer
        $pdf->setPrintHeader(true); // Enable custom header
        $pdf->setPrintFooter(true); // Enable custom footer

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('dejavusans', '', 14, '', true);
        $pdf->AddPage('P', 'A4');

        $pdf->SetY(30);
        // Add content
        $nilai = PenilaianPengembanganDiriModel::DataAjaxEditPenilaianRapor($id,$idRapor,$peserta,$tahun,$jenjang,$periode);
        if ($jenjang === 'tahfidz') {
            $html = view('Guru/rapor/peserta/cetak_rapor_tahfidz',compact('nilai'));
        } else {
            $html = view('Guru/rapor/peserta/cetak_rapor_tahsin',compact('nilai'));
        }
        
        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');

        // Center the image
        if (file_exists(public_path('storage/siswa/' . $nilai->foto_siswa))) {
            $imagePath = public_path('storage/siswa/' . $nilai->foto_siswa);
        } else {
            $imagePath = public_path('assets/admin/img/avatars/pas_foto.jpg');
        }        
         // Correctly define the image path
        $imageWidth = 30; // Set image width (3 cm)
        $imageHeight = 40; // Set image height (4 cm)
        $x = ($pdf->getPageWidth() - $imageWidth) / 2; // Calculate X position for centering
        $y = 230; // Set a fixed Y position from the top
        
        // Place the image
        $pdf->Image($imagePath, $x, $y, $imageWidth, $imageHeight, '', '', '', false, 300, '', false, false, 0, false, false, false);
           

        // Close and output PDF document
        $pdf->Output($nilai->nama_siswa.'.pdf', 'I'); // 'I' for inline display or 'D' for download
    }
}
