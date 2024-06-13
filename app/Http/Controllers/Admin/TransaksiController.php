<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Pdf\CustomPdf;
use App\Models\Admin\PembelianModel;
use App\Models\Admin\PenjualanModel;
use App\Models\Admin\PengeluaranModel;
use App\Models\Admin\RincianModel;
use App\Models\Admin\RincianPenjualanModel;
use App\Models\Admin\PelangganModel;
class TransaksiController extends Controller
{
    public function index(){
        $menu = 'transaksi';
        $submenu= 'transaksi';
        return view ('Admin/transaksi/data_transaksi',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
        
        if(Auth::User()->level_user == 'superadmin'){
            $DataPembelian = PembelianModel::orderBy('created_at','DESC')->get();
        }else{
            $DataPembelian = PembelianModel::where('id_pelanggan',Auth::User()->id_pelanggan)->orderBy('created_at','DESC')->get();
        }
        if ($DataPembelian == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPembelian]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataPenjualan(Request $request) {
        if(Auth::User()->level_user == 'superadmin'){
            $DataPenjualan = PenjualanModel::orderBy('created_at','DESC')->get();
        }else{
            $DataPenjualan = PenjualanModel::where('id_pelanggan',Auth::User()->id_pelanggan)->orderBy('created_at','DESC')->get();
        }
        
        if ($DataPenjualan == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPenjualan]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataPengeluaran(Request $request) {
        if(Auth::User()->level_user == 'superadmin'){
            $DataPengeluaran = PengeluaranModel::orderBy('created_at','DESC')->get();
        }else{
            $DataPengeluaran = PengeluaranModel::where('id_pelanggan',Auth::User()->id_pelanggan)->orderBy('created_at','DESC')->get();
        }
        
        if ($DataPengeluaran == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPengeluaran]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    // data rincian
    public function AjaxDataRincianPembelian($id) {
        $DataRincianPembelian = RincianModel::DataRincianAll($id);
        if ($DataRincianPembelian == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataRincianPembelian]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataRincianPenjualan($id) {
        $DataRincianPembelian = RincianPenjualanModel::DataRincianAll($id);
        if ($DataRincianPembelian == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataRincianPembelian]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function CetakRincianPembelian($id) {
        $DataRincianPembelian = RincianModel::DataRincianAll($id);
        $DataPembelian = PembelianModel:: where('id_pembelian',$id)->first();
        $pelanggan = PelangganModel::where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        if ($DataRincianPembelian == true) {
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
            $pdf->AddPage('L', 'A5');
   
           $pdf->SetY(30);
            // Add content
            $html = view('Admin/transaksi/cetak_pdf/invoice',compact('DataRincianPembelian'));
   
            // Print text using writeHTMLCell()
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetY(-130);
            // Set font
            $pdf->SetFont('helvetica','', 13);
            // Draw the first cell (left-aligned)
            $pdf->Cell(0, 2,$DataPembelian->tanggal_transaksi, 0, 0, 'R', 0);

            $pdf->SetY(-137);
            // Set font
            $pdf->SetFont('helvetica','B', 15);
            // Draw the first cell (left-aligned)
            $pdf->Cell(0, 2,$id, 0, 0, 'R', 0);

            // Close and output PDF document
            $pdf->Output('Bukti Pembelian'.$id.'.pdf', 'I'); // 'I' for inline display or 'D' for download
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function CetakRincianPenjualan($id) {
        $DataRincianPenjualan = RincianPenjualanModel::DataRincianAll($id);
        $DataPenjualan = PenjualanModel:: where('id_penjualan',$id)->first();
        $pelanggan = PelangganModel::where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        if ($DataRincianPenjualan == true) {
            $pdf = new CustomPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // Set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('Bukti Penjualan');
    
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
            $pdf->AddPage('L', 'A5');
   
           $pdf->SetY(30);
            // Add content
            $html = view('Admin/transaksi/cetak_pdf/kuitansi',compact('DataRincianPenjualan'));
   
            // Print text using writeHTMLCell()
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetY(-130);
            // Set font
            $pdf->SetFont('helvetica','', 13);
            // Draw the first cell (left-aligned)
            $pdf->Cell(0, 2,$DataPenjualan->id_periode, 0, 0, 'R', 0);

            $pdf->SetY(-137);
            // Set font
            $pdf->SetFont('helvetica','B', 15);
            // Draw the first cell (left-aligned)
            $pdf->Cell(0, 2,$id, 0, 0, 'R', 0);

            // Close and output PDF document
            $pdf->Output('Bukti Penjualan'.$id.'.pdf', 'I'); // 'I' for inline display or 'D' for download
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }
}
