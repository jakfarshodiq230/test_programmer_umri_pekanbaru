<?php
namespace App\Pdf;

use TCPDF;

use App\Models\Admin\KopModel;
use Illuminate\Support\Facades\Auth;
class CustomCetak extends TCPDF
{
    // Page header
    public function Header()
    {
        $kop = KopModel::first();
        
        // Define the image file path
        $image_file = public_path('storage/kop/' . $kop->image_kop); // Path to the logo file
        
        // Header positioning
        $pageWidth = 287; // A4 width in mm
        $imageWidth = 310; // Desired image width in mm
        $imageHeight = 45; // Desired image height in mm
        $headerHeight = 2; // Height offset from the top of the page
        
        // Calculate the X position to center the image
        $xPosition = ($pageWidth - $imageWidth) / 2;
        
        // Set the Y position for the header
        $this->SetY($headerHeight);
        
        // Set the image in the header
        $this->Image($image_file, $xPosition, $headerHeight, $imageWidth, $imageHeight, '', '', 'T', false, 300, '', false, false, 0, false, false, false); 
    }
    

    // Page footer
    public function Footer()
    {
       
    }
}
