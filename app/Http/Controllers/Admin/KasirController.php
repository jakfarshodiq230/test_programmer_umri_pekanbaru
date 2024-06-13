<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin\HargaModel;

use App\Models\Admin\PembelianModel;
use App\Models\Admin\RincianModel;

use App\Models\Admin\PenjualanModel;
use App\Models\Admin\RincianPenjualanModel;
use App\Models\Admin\PengeluaranModel;
use App\Models\Admin\PeriodeModel;

class KasirController extends Controller
{
    public function index(){
        $menu = 'pembelian';
        $status_periode = PeriodeModel::where('id_pelanggan',Auth::User()->id_pelanggan)->where('status_periode',1)->first();
        return view ('Admin/transaksi/kasir_pembelian', compact('menu','status_periode'));
    }

    public function AjaxDataHarga(Request $request) {
        $Harga = HargaModel::where('id_pelanggan',Auth::User()->id_pelanggan)->whereNull('deleted_at')->get();
        if ($Harga == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $Harga]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxHarga($id) {
        $Harga = HargaModel::where('id_harga',$id)->where('id_pelanggan',Auth::User()->id_pelanggan)->where('deleted_at',null)->first();
        if ($Harga == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $Harga]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function saveDataPembelian(Request $request)
    {
        $dataArray = $request->input('dataArray');
        
        // Loop through $dataArray and save each item to the database
        $jumlah_total_berat_bersih = 0;
        $jumlah_total_nominal = 0;
        $total_nominal = 0;
        $tanggal = now()->format('dmy');
        $nomorUrut = PembelianModel::whereDate('created_at', now()->toDateString())->count() + 1;
        $id = 'PB-'.Auth::User()->id_pelanggan.'-'.Auth::User()->id.'-'.$tanggal.$nomorUrut;
        $periode = PeriodeModel::where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        foreach ($dataArray as $data) {
            // kegiatan pembeli
            $total = 0;
            $jumlah_total_berat_bersih = $jumlah_total_berat_bersih + $data['beratBersih'];
            $jumlah_total_nominal = $data['beratBersih'] * $data['harga'];
            $total_nominal = $total_nominal + $jumlah_total_nominal;
            
            // rincian pembeli
            RincianModel::create([
                'id_kegiatan_pembelian' => $id,
                'id_harga' => $data['id_harga'],
                'id_periode' => $periode->id_periode,
                'berat_normal' => $data['beratNormal'],
                'berat_potong' => $data['beratPotongan'],
                'berat_bersih' => $data['beratBersih'],
                'nominal_rincian_pembelian' => $data['beratBersih'] * $data['harga'],
                'id_user' => Auth::User()->id,
                'id_pelanggan' => Auth::User()->id_pelanggan
                // Add more fields as needed
            ]);
        }

        
        PembelianModel::create([
            'id_pembelian' => $id,
            'tanggal_transaksi' => now()->format('Y-m-d h:i:s'),
            'berat_bersih' => $jumlah_total_berat_bersih,
            'nominal_pembelian' => $total_nominal,
            'id_user' => Auth::User()->id,
            'id_pelanggan' => Auth::User()->id_pelanggan,
            'id_periode' => $periode->id_periode
            // Add more fields as needed
        ]);

        return response()->json(['success' => true,'id_pembelian' => $id], 200);
    }

    public function penjulan(){
        $menu = 'penjualan';
        $status_periode = PeriodeModel::where('id_pelanggan',Auth::User()->id_pelanggan)->where('status_periode',1)->first();
        return view ('Admin/transaksi/kasir_penjualan', compact('menu','status_periode'));
    }

    public function saveDataPenjualan(Request $request)
    {
        $dataArray = $request->input('dataArray');
        
        // Loop through $dataArray and save each item to the database
        $jumlah_total_berat_bersih = 0;
        $jumlah_total_nominal = 0;
        $total_nominal = 0;
        $tanggal = now()->format('dmy');
        $nomorUrut = PenjualanModel::whereDate('created_at', now()->toDateString())->count() + 1;
        $id = 'PJ-1'.Auth::User()->id_pelanggan.'-'.Auth::User()->id.'-'.$tanggal.$nomorUrut;

        foreach ($dataArray as $data) {
            // kegiatan pembeli
            $total = 0;
            $jumlah_total_berat_bersih = $jumlah_total_berat_bersih + $data['beratBersih'];
            $jumlah_total_nominal = $data['beratBersih'] * $data['harga'];
            $total_nominal = $total_nominal + $jumlah_total_nominal;
            
            // rincian pembeli
            RincianPenjualanModel::create([
                'id_penjualan' => $id,
                'berat_normal' => $data['beratPotongan'],
                'berat_potongan' => $data['beratNormal'],
                'berat_bersih' => $data['beratBersih'],
                'harga_jual' => $data['harga'],
                'nominal_rincian_penjualan' => $data['beratBersih'] * $data['harga'],
                'keterangan_penjualan' => $data['keterangan'],
                'tggl_rincian_penjualan' => $data['tanggal'],
                'id_user' => Auth::User()->id,
                'id_pelanggan' => Auth::User()->id_pelanggan
                // Add more fields as needed
            ]);
        }
        $periode = PeriodeModel::where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        PenjualanModel::create([
            'id_penjualan' => $id,
            'berat_bersih_penjualan' => $jumlah_total_berat_bersih,
            'nominal_penjualan' => $total_nominal,
            'id_user' => Auth::User()->id,
            'id_pelanggan' => Auth::User()->id_pelanggan,
            'id_periode' => $periode->id_periode
            // Add more fields as needed
        ]);

        return response()->json(['success' => true,'id_pembelian'=>$id], 200);
    }

    public function pengeluaran(){
        $menu = 'pengeluaran';
        $status_periode = PeriodeModel::where('id_pelanggan',Auth::User()->id_pelanggan)->where('status_periode',1)->first();
        return view ('Admin/transaksi/kasir_pengeluaran', compact('menu','status_periode'));
    }

    public function saveDataPengeluaran(Request $request)
    {
        $dataArray = $request->input('dataArray');
        
        $tanggal = now()->format('dmy');
        $nomorUrut = PengeluaranModel::whereDate('created_at', now()->toDateString())->count() + 1;
        $id = 'PG-1'.Auth::User()->id_pelanggan.'-'.Auth::User()->id.'-'.$tanggal.$nomorUrut;
        $periode = PeriodeModel::where('id_pelanggan',Auth::User()->id_pelanggan)->first();
        foreach ($dataArray as $data) {            
            // rincian pembeli
            PengeluaranModel::create([
                'id_pengeluaran' => $id,
                'nominal_pengeluaran' => $data['jumlah_uang'],
                'keterangan_pengeluaran' => $data['keterangan'],
                'tgl_pengeluaran' => $data['tanggal'],
                'id_user' => Auth::User()->id,
                'id_pelanggan' => Auth::User()->id_pelanggan,
                'id_periode' => $periode->id_periode,
                // Add more fields as needed
            ]);
        }

        return response()->json(['success' => true], 200);
    }

}
