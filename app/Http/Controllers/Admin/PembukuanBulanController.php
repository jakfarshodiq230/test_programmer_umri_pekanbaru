<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pdf\CustomCetak;

use App\Models\Admin\HargaModel;
use App\Models\Admin\PembelianModel;
use App\Models\Admin\RincianModel;
use App\Models\Admin\PenjualanModel;
use App\Models\Admin\RincianPenjualanModel;
use App\Models\Admin\PengeluaranModel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\RincianPembukuanModel;
use App\Models\Admin\PembukuanModel;
class PembukuanBulanController extends Controller
{
    // star hari
    public function index(){
        $menu = 'pembukuan';
        $submenu= 'bulan';
        return view ('Admin/pembukuan/data_pembukuan_bulan',compact('menu','submenu'));
    }

    public function AjaxDataPeriode(Request $request) {
        $Periode = PeriodeModel::where('id_pelanggan',Auth::User()->id_pelanggan)->whereNull('deleted_at')->get();
        if ($Periode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $Periode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataBulan(Request $request) {
        $DataPembukuan = PembukuanModel::DataPembukuanBulan(Auth::User()->id_pelanggan);
        if ($DataPembukuan == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPembukuan]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeDataPembukuanBulan(Request $request) {

        $id_periode = $request->id_periode;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $hari = $bulan.'-'.$tahun;
        $id_pelanggan = Auth::User()->id_pelanggan;

        $tanggal = now()->format('dmy');
        $nomorUrut = RincianPembukuanModel::whereDate('created_at', now()->toDateString())->count() + 1;
        $id = 'LPB-'.$id_pelanggan.'-'.Auth::User()->id.'-'.$tanggal.$nomorUrut;
        $periode = PeriodeModel::where('id_pelanggan',$id_pelanggan)->first();
        $DataPembukuan = '';
        $DataPeriodePembukuan = '';

        // cek periode pembukuan
        $cekPeriode = PembukuanModel::where('jenis_pembukuan','bulan')->where('bulan_pembukuan', $hari)->where('id_periode', $id_periode)->where('id_pelanggan',$id_pelanggan)->first();

        if ($cekPeriode == null) {
            
            $data = [
                'id_pembukuan' => $id,
                'id_periode' => $id_periode,
                'judul_pembukuan' => 'PEMBUKUAN PERHARI',
                'jenis_pembukuan' => 'bulan',
                'bulan_pembukuan' => $hari,
                'tanggal_pembukuan' => now()->format('Y-m-d h:i:s'),
                'total_penjualan' => 0,
                'total_pembelian' => 0,
                'total_pengeluaran' => 0,
                'total_berat_pembelian' => 0,
                'total_berat_penjualan' => 0,
                'pendapatan_bersih' => 0,
                'id_pelanggan' => $id_pelanggan,
                'id_user' => Auth::User()->id
            ];
            PembukuanModel::create($data);
        }
        


        $cekTggl = RincianPembukuanModel::where('jenis_pembukuan','bulan')->where('id_periode', $id_periode)->where('bulan_pembukuan', $hari)->where('id_pelanggan',$id_pelanggan)->first();

        $DataRincianPembelian = RincianModel::DataPembukuanBulan($hari,$id_periode,$id_pelanggan);
        $DataRincianPenjualan = RincianPenjualanModel::DataPembukuanBulan($hari, $id_periode,$id_pelanggan);
        $DataRincianPengeluaran = PengeluaranModel::DataPembukuanBulan($hari, $id_periode,$id_pelanggan);

        if ($cekTggl != null) {
            
            $total_keuntungan = 0;
            $total_keuntungan = $DataRincianPenjualan->total_nominal_penjualan - $DataRincianPembelian->total_nominal_pembelian;
            $total_pendapatan_bersih = 0;
            $total_pendapatan_bersih = $total_keuntungan - $DataRincianPengeluaran->total_pengeluaran;
            $data = [
                'total_penjualan' => $DataRincianPenjualan->total_nominal_penjualan,
                'total_pembelian' => $DataRincianPembelian->total_nominal_pembelian,
                'total_pengeluaran' => $DataRincianPengeluaran->total_pengeluaran,
                'total_berat_pembelian' => $DataRincianPembelian->total_berat_bersih,
                'total_berat_penjualan' => $DataRincianPenjualan->total_berat_bersih_penjualan,
                'pendapatan_bersih' => $total_pendapatan_bersih,
                'id_pelanggan' => $id_pelanggan,
                'id_user' => Auth::User()->id
            ];
            RincianPembukuanModel::where('id_pembukuan',$cekTggl->id_pembukuan)->update($data);
            
        } else {

            $total_keuntungan = 0;
            $total_keuntungan = $DataRincianPenjualan->total_nominal_penjualan - $DataRincianPembelian->total_nominal_pembelian;
            $total_pendapatan_bersih = 0;
            $total_pendapatan_bersih = $total_keuntungan - $DataRincianPengeluaran->total_pengeluaran;
            $data = [
                'id_pembukuan' => $id,
                'id_periode' => $id_periode,
                'judul_pembukuan' => 'PEMBUKUAN PERHARI',
                'jenis_pembukuan' => 'bulan',
                'bulan_pembukuan' => $hari,
                'tanggal_pembukuan' => now()->format('Y-m-d h:i:s'),
                'total_penjualan' => $DataRincianPenjualan->total_nominal_penjualan,
                'total_pembelian' => $DataRincianPembelian->total_nominal_pembelian,
                'total_pengeluaran' => $DataRincianPengeluaran->total_pengeluaran,
                'total_berat_pembelian' => $DataRincianPembelian->total_berat_bersih,
                'total_berat_penjualan' => $DataRincianPenjualan->total_berat_bersih_penjualan,
                'pendapatan_bersih' => $total_pendapatan_bersih,
                'id_pelanggan' => $id_pelanggan,
                'id_user' => Auth::User()->id
            ];
            RincianPembukuanModel::create($data);
            
        }
        $UpdatePendapatan ='';
        $cekID = PembukuanModel::where('jenis_pembukuan','bulan')->where('id_periode', $id_periode)->where('id_pelanggan',$id_pelanggan)->first();
        $DataRincianPembelianPeriode = RincianPembukuanModel::DataPembukuanBulanRincian($id_periode,$id_pelanggan);

        if ($cekID == true) {
            $data = [
                'total_penjualan' => $DataRincianPembelianPeriode->total_penjualan_periode,
                'total_pembelian' => $DataRincianPembelianPeriode->total_pembelian_periode,
                'total_pengeluaran' => $DataRincianPembelianPeriode->total_pengeluaran_periode,
                'total_berat_pembelian' => $DataRincianPembelianPeriode->total_berat_pembelian_periode,
                'total_berat_penjualan' => $DataRincianPembelianPeriode->total_berat_penjualan_periode,
                'pendapatan_bersih' => $DataRincianPembelianPeriode->total_pendapatan_bersih_periode,
                'id_pelanggan' => $id_pelanggan,
                'id_user' => Auth::User()->id
            ];
            $UpdatePendapatan = PembukuanModel::where('id_pembukuan',$cekID->id_pembukuan)->update($data);
        }
        


        if ($UpdatePendapatan == true) {
            return response()->json(['success' => true, 'message' => 'Berhasil Simpan']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Simpan']);
        }
     

       
    }

    // rincian harian
    public function DataRincianPeriodebulan($id,$periode, Request $request) {
        $menu = 'pembukuan';
        $submenu= 'bulan';
        $id_pembukuan = $id;
        $id_periode = $periode;
        $judul_periode = PeriodeModel::where('id_periode',$periode)->where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        $pembukuan = PembukuanModel::where('id_pembukuan',$id)->where('id_periode',$periode)->where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        return view ('Admin/pembukuan/rincian_bulan/rincian_pembukuan',compact('menu','submenu','id_pembukuan','id_periode','pembukuan','judul_periode'));
    }

    public function AjaxDataRincianPeriodebulan($id,$periode) {
        $DataPembukuan = RincianPembukuanModel::DataRincianPembukuanBulan($id, $periode, Auth::User()->id_pelanggan);
        if ($DataPembukuan == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPembukuan]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function DataDetailRincianPeriodebulan($pembukuan,$periode,$tanggal) {
        $menu = 'pembukuan';
        $submenu= 'hari';
        $id_pembukuan = $pembukuan;
        $id_periode = $periode;
        $tanggal = $tanggal;
        $judul_periode = PeriodeModel::where('id_periode',$periode)->where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        $pembukuan = PembukuanModel::where('id_pembukuan',$pembukuan)->where('id_periode',$periode)->where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        return view ('Admin/pembukuan/rincian_bulan/detail_rincian_pembukuan',compact('menu','submenu','id_pembukuan','id_periode','pembukuan','judul_periode','tanggal'));
    }

    public function AjaxListDataRincianPeriodebulanPembelian($id,$periode,$tanggal) {
        $DataPembelian = PembelianModel::ListDataBulan($periode, $tanggal, Auth::User()->id_pelanggan);
        return response()->json([
            'success' => true, 
            'message' => 'Data Ditemukan', 
            'data' => $DataPembelian,
        ]);
    }

    public function AjaxListDataRincianPeriodebulanPenjualan($id,$periode,$tanggal) {
        $DataPenjualan = PenjualanModel::ListDataBulan($periode, $tanggal, Auth::User()->id_pelanggan);
        return response()->json([
            'success' => true, 
            'message' => 'Data Ditemukan', 
            'data' => $DataPenjualan,
        ]);
    }
    public function AjaxListDataRincianPeriodebulanPengeluaran($id,$periode,$tanggal) {
        $DataPengeluaran = PengeluaranModel::ListDataBulan($periode, $tanggal, Auth::User()->id_pelanggan);
        return response()->json([
            'success' => true, 
            'message' => 'Data Ditemukan', 
            'data' => $DataPengeluaran
        ]);
    }

    public function cetakRincianPdf($id,$periode,$bulan) {
        $id_pembukuan = $id;
        $id_periode = $periode;
        $DataPembukuan = RincianPembukuanModel::DataRincianPembukuanBulan($id_pembukuan, $id_periode, Auth::User()->id_pelanggan);
        $Pembukuan = RincianPembukuanModel::where('id_pelanggan', Auth::User()->id_pelanggan)->first();
        // dd($DataPembukuan);
        if ($DataPembukuan == true) {
            $pdf = new CustomCetak(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
            $pdf->AddPage('L', 'A4');
   
            $pdf->SetY(30);
            // Add content
            $html = view('Admin/pembukuan/rincian_bulan/laporan',compact('DataPembukuan'));
   
            // Print text using writeHTMLCell()
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetY(-201);
            // Set font
            $pdf->SetFont('helvetica','', 13);
            // Draw the first cell (left-aligned)
            $pdf->Cell(0, 2,'Pembukuan Bulan : '.date('d F Y', strtotime($Pembukuan->bulan_pembukuan)), 0, 0, 'R', 0);

            $pdf->SetY(-195);
            // Set font
            $pdf->SetFont('helvetica','B', 15);
            // Draw the first cell (left-aligned)
            $pdf->Cell(0, 2,$Pembukuan->id_pembukuan, 0, 0, 'R', 0);

            // Close and output PDF document
            $pdf->Output('Data Rincian'.$Pembukuan->id_pembukuan.'.pdf', 'I'); // 'I' for inline display or 'D' for download
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function cetakDetailRincianPdf($id,$periode,$tanggal) {
        $id_pembukuan = $id;
        $id_periode = $periode;
        $DataPembelian = PembelianModel::ListDataBulan($periode, $tanggal, Auth::User()->id_pelanggan);
        $DataPengeluaran = PengeluaranModel::ListDataBulan($periode, $tanggal, Auth::User()->id_pelanggan);
        $DataPenjualan = PenjualanModel::ListDataBulan($periode,$tanggal, Auth::User()->id_pelanggan);
        $Pembukuan = RincianPembukuanModel::where('id_periode',$periode)->where('id_pembukuan',$id_pembukuan)->where('id_pelanggan', Auth::User()->id_pelanggan)->first();
 
            $pdf = new CustomCetak(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
            $pdf->AddPage('L', 'A4');
   
            $pdf->SetY(30);
            // Add content
            $html = view('Admin/pembukuan/rincian_bulan/detail_laporan',compact('DataPembelian','DataPengeluaran','DataPenjualan'));
   
            // Print text using writeHTMLCell()
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->SetY(-201);
            // Set font
            $pdf->SetFont('helvetica','', 13);
            // Draw the first cell (left-aligned)
            $pdf->Cell(0, 2,'Pembukuan Hari : '.date('d F Y', strtotime($Pembukuan->tgl_hari_pembukuan)), 0, 0, 'R', 0);

            $pdf->SetY(-195);
            // Set font
            $pdf->SetFont('helvetica','B', 15);
            // Draw the first cell (left-aligned)
            $pdf->Cell(0, 2,$Pembukuan->id_pembukuan, 0, 0, 'R', 0);

            // Close and output PDF document
            $pdf->Output('Data Rincian'.$Pembukuan->id_pembukuan.'.pdf', 'I'); // 'I' for inline display or 'D' for download
    }
    // end hari

    
}
