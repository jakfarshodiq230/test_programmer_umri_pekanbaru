<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Pdf\CustomCetak;

use App\Models\Admin\SurahModel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\PesertaKegiatan;
use App\Models\Admin\PesertaSertifikasiModel;
use App\Models\Admin\PenilaianSertifikasiModel;
class SertifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:guru');
    }
    public function index(){
        $menu = 'sertifikasi';
        $submenu= 'penilaian-sertifikasi';
        return view ('Guru/sertifikasi/penilaian/data_peserta_sertifikasi',compact('menu','submenu'));
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
        $submenu= 'penilaian-sertifikasi';
        return view ('Guru/sertifikasi/penilaian/list_penilaian_sertifikasi',compact('menu','submenu','tahun','sertifikasi','periode'));
    }

    public function DataPeserta($tahun,$jenjang,$periode){
        $DataPeriode = PeriodeModel::DataPeriodeRapor($tahun,$jenjang,$periode);
        $sesi = $DataPeriode->sesi_periode;
        $DataPeserta = PesertaSertifikasiModel::DataDaftarPesertaPenilaian($tahun, $jenjang, $periode,$sesi);
        $DataSurah = SurahModel::get();
        if ($DataPeserta ) {
            return response()->json([
                'success' => true,
                'message' => 'Data Ditemukan',
                'peserta' => $DataPeserta,
                'periode' => $DataPeriode,
                'surah' => $DataSurah,
            ]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function StoreData(Request $request) {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'siswa' => 'required|string|not_in:PILIH,other',
                'surah_mulai' => 'required|string|not_in:PILIH,other',
                'surah_akhir' => 'required|string|not_in:PILIH,other',
                'ayat_mulai' => 'required|numeric|not_in:PILIH,other',
                'ayat_akhir' => 'required|numeric|not_in:PILIH,other',
                'nilai' => 'required|numeric',
                'koreksi_saran' => 'required|string|max:255',
            ]);
    
             // Generate unique ID based on current date and count
             $tanggal = now()->format('dmy');
             $nomorUrut = PenilaianSertifikasiModel::whereDate('created_at', now()->toDateString())->count() + 1;
             $id = 'PEN-SERT' . '-' . $tanggal . '-' . $nomorUrut;

            // Prepare data for insertion
            $data = [
                'id_penilaian_sertifikasi' => $id,
                'id_peserta_sertifikasi' => $validatedData['siswa'],
                'surah_mulai' => $validatedData['surah_mulai'],
                'surah_akhir' => $validatedData['surah_akhir'],
                'ayat_awal' => $validatedData['ayat_mulai'],
                'ayat_akhir' => $validatedData['ayat_akhir'],
                'koreksi_sertifikasi' => $validatedData['koreksi_saran'],
                'nilai_sertifikasi' => $validatedData['nilai'],
                'id_user' => session('user')['id'],
            ];

            $Peserta = PenilaianSertifikasiModel::create($data);
            if ($Peserta) {
                return response()->json(['success' => true, 'message' => 'Berhasil Penilaian Sertifikasi']);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Penilaian Sertifikasi']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function AjaxDataNilaiPeserta($tahun,$jenjang,$periode) {
        $DataPeriode = PeriodeModel::DataPeriodeRapor($tahun,$jenjang,$periode);
        $sesi = $DataPeriode->sesi_periode;
        $DataNilai = PesertaSertifikasiModel::DataNilaiPeserta($tahun, $jenjang, $periode,$sesi);
        if ($DataNilai) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataNilai]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    } 

    public function DetailNilaiPeserta($peserta){
        $menu = 'sertifikasi';
        $submenu= 'penilaian-sertifikasi';
        return view ('Guru/sertifikasi/penilaian/detail_penilaian_sertifikasi',compact('menu','submenu','peserta'));
    }

    public function AjaxDataDetailPeserta($peserta){
        $DataPeserta = PesertaSertifikasiModel::DataDetailPesertaSertifikasi($peserta);
        $Nilai = PenilaianSertifikasiModel::DataDetailNilaiPesertaSertifikasi($peserta);
        $DataSurah = SurahModel::get();
        if ($DataPeserta ) {
            return response()->json([
                'success' => true,
                'message' => 'Data Ditemukan',
                'nilai' => $Nilai,
                'identitas' => $DataPeserta,
                'surah' => $DataSurah,
            ]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function deleteData($id){
        try {
            $nilai = PenilaianSertifikasiModel::where('id_penilaian_sertifikasi', $id)->delete();
            if ($nilai) {
                return response()->json(['success' => true, 'message' => 'Data Berhasil Dihapus']);
            } else {
                return response()->json(['error' => true, 'message' => 'Data Tidak Berhasil Dihapus']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Terjadi kesalahan saat menghapus data', 'details' => $e->getMessage()]);
        }
    }

    public function editData($id){
        try {
            $nilai = PenilaianSertifikasiModel::EditNilaiPesertaSertifikasi($id);
            return response()->json([
                'success' => true, 
                'message' => 'Data Ditemukan',
                'nilai' => $nilai,
            ]);
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Terjadi kesalahan saat mencari data', 'details' => $e->getMessage()]);
        }
    }

    public function updateData($id,Request $request) {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'surah_mulai' => 'required|string|not_in:PILIH,other',
                'surah_akhir' => 'required|string|not_in:PILIH,other',
                'ayat_mulai' => 'required|numeric|not_in:PILIH,other',
                'ayat_akhir' => 'required|numeric|not_in:PILIH,other',
                'nilai' => 'required|numeric',
                'koreksi_saran' => 'required|string|max:255',
            ]);

            // Prepare data for insertion
            $data = [
                'surah_mulai' => $validatedData['surah_mulai'],
                'surah_akhir' => $validatedData['surah_akhir'],
                'ayat_awal' => $validatedData['ayat_mulai'],
                'ayat_akhir' => $validatedData['ayat_akhir'],
                'koreksi_sertifikasi' => $validatedData['koreksi_saran'],
                'nilai_sertifikasi' => $validatedData['nilai'],
            ];

            $Peserta = PenilaianSertifikasiModel::where('id_penilaian_sertifikasi', $id)->update($data);
            if ($Peserta) {
                return response()->json(['success' => true, 'message' => 'Berhasil Penilaian Sertifikasi']);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Penilaian Sertifikasi']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function CetakSertifikat($id){
        $pdf = new CustomCetak(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('SERTIFIKAT');

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
        $pdf->AddPage('L', 'A4');

        $pdf->SetY(30);
        // Add content
        $identitas = PesertaSertifikasiModel::DataDetailPesertaSertifikasi($id);
        $nilai = PenilaianSertifikasiModel::DataDetailNilaiPesertaSertifikasi($id);
        
        

        $viewName = 'Guru/sertifikasi/penilaian/cetak_hasil_penilaian' ;
        $html = view($viewName, compact('nilai', 'identitas'));

        
        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');

        // Center the image
        if (file_exists(public_path('storage/siswa/' . $identitas->foto_siswa))) {
            $imagePath = public_path('storage/siswa/' . $identitas->foto_siswa);
        } else {
            $imagePath = public_path('assets/admin/img/avatars/pas_foto.jpg');
        }        
         // Correctly define the image path
        $imageWidth = 30; // Set image width (3 cm)
        $imageHeight = 40; // Set image height (4 cm)
        $x = 230; // Calculate X position for centering
        $y = 52; // Set a fixed Y position from the top
        
        // Place the image
        $pdf->Image($imagePath, $x, $y, $imageWidth, $imageHeight, '', '', '', false, 300, '', false, false, 0, false, false, false);
           

        // Close and output PDF document
        $pdf->Output($identitas->nama_siswa.'.pdf', 'I'); // 'I' for inline display or 'D' for download
    }

}
