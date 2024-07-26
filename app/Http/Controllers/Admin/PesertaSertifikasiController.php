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
use App\Models\Admin\SurahModel;
use App\Models\Admin\PenilaianSertifikasiModel;
use App\Pdf\CustomPdf;
use TCPDF;
use App\Pdf\CustomCetak;

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


    public function DataDetailPeserta($peserta){
        $menu = 'rapor';
        $submenu= 'peserta-rapor';
        return view ('Admin/sertifikasi/peserta/detail_peserta_sertifikasi',compact('menu','submenu','peserta'));
    } 

    public function AjaxDataDetailPesertaSertif($peserta) {
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

    public function CetakSertifikatPdf($id) {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(330.2, 215.9), true, 'UTF-8', false);
    
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('SERTIFIKAT');
    
        // Remove default header/footer
        $pdf->setPrintHeader(false); // Disable default header
        $pdf->setPrintFooter(false); // Disable default footer
    
        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
        // Set margins
        $pdf->SetMargins(0, 0, 0, 0);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
    
        // Set auto page breaks
        $pdf->SetAutoPageBreak(FALSE, 0);
    
        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
        // Set font
        $pdf->SetFont('dejavusans', '', 14, '', true);
    
        // Add a page with F4 landscape size
        $pdf->AddPage('L', array(330.2, 215.9));

        // Set background image
        $backgroundImagePath = public_path('assets/admin/img/avatars/dicoding.jpg');
        $pdf->Image($backgroundImagePath, 0, 0, 330.2, 215.9, '', '', '', false, 300, '', false, false, 0);

        $pdf->AddPage('L', array(330.2, 215.9));

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $identitas = PesertaSertifikasiModel::DataDetailPesertaSertifikasi($id);
        $nilai = PenilaianSertifikasiModel::DataDetailNilaiPesertaSertifikasi($id);
        $viewName = 'Guru/sertifikasi/peserta/cetak_penilaian' ;
        $html = view($viewName, compact('nilai', 'identitas'));

        
        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');
        // Output PDF
        $pdf->Output('sertifikat.pdf', 'I');
    }
}
