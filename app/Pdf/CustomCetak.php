<?php
namespace App\Pdf;

use TCPDF;

use App\Models\Admin\PelangganModel;
use Illuminate\Support\Facades\Auth;
class CustomCetak extends TCPDF
{
    // Page header
    public function Header()
    {
        $pelanggan = PelangganModel::where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        // Logo
        // $image_file = public_path('storage/'.$Sistem->logo_sistem);  // Path to the logo file
        // $this->Image($image_file, 15, 10, 24, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        $this->SetX(18); // Set X position to 60
        $this->Cell(0, 2, strtoupper($pelanggan->nama_usaha), 0, 1, 'L'); // 'C' for center alignment
        $this->SetFont('helvetica', 'B', 9);
        $this->SetX(18);
        $this->Cell(0, 2, 'Alamat : '.strtoupper($pelanggan->alamat_usaha),0, 1, 'L');
        $this->SetFont('helvetica', 'B', 9);
        $this->SetX(18);
        $this->Cell(0, 2, 'No. HP : '.strtoupper($pelanggan->no_hp_usaha),0, 1, 'L');


        $style = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
        $this->Line(18, 25, 282, 25, $style);
    }
    

    // Page footer
    public function Footer()
    {
        $pelanggan = PelangganModel::where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        //$this->SetTextColor(255, 0, 0);

        $this->SetTextColor(255, 0, 0);
        $this->SetY(-25);
        $this->SetX(18);
        $this->SetFont('helvetica','i', 10);
        $this->Cell(0, 2,'Laporan ini merupakan bukti tanda sah atas transaksi', 0, 0, 'L', 0);
        $this->SetY(-20);
        $this->SetX(18);
        $this->SetFont('helvetica','i', 10);
        $this->Cell(0, 2,'pembelian, penjualan dan pengeluaran yang telah dilakukan.', 0, 0, 'L', 0);
        $this->SetTextColor(0, 0, 0);

        // Draw dashed line
        $this->SetY(-13);
        $this->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '2,2', 'color' => array(0, 0, 0)));
        $this->Line(18, $this->GetY(), 282, $this->GetY());    

        // Position at 15 mm from bottom
        $this->SetY(-10);
        $this->SetX(17);
        $this->SetFont('helvetica','', 8);
        // Draw the first cell (left-aligned)
        $this->Cell(0, 2,' APKIS - '.strtoupper($pelanggan->nama_usaha), 0, 0, 'L', 0);
        // Move to the right
        $this->Cell(0, 2, strtoupper('Dicetak pada tanggal: '). date('d F Y, h:i:s '), 0, 0, 'R', 0);
    }
}
