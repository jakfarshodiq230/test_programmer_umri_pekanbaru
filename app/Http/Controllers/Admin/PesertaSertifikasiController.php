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

    public function AjaxDataPesertaRapor($tahun,$jenjang,$periode) {
        $DataPeserta = PesertaSertifikasiModel::DataPesertaSertifikasi($tahun,$jenjang,$periode);
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

    public function CetakRaporPdf($idRapor,$peserta,$tahun,$jenjang,$periode){
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
        //Add content
        $nilai = PenilaianPengembanganDiriModel::DataAjaxPenilaianPengembanganRapor($idRapor,$peserta,$tahun,$jenjang,$periode);
        if ($jenjang === 'tahfidz') {
            $html = view('Admin/rapor/peserta/cetak_rapor_tahfidz',compact('nilai'));
        } else {
            $html = view('Admin/rapor/peserta/cetak_rapor_tahsin',compact('nilai'));
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
