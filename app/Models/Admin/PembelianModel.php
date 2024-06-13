<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PembelianModel extends Model
{
    use HasFactory;
    protected $table ="kegiatan_pembelian";
    protected $primaryKey = "id_transaksi";
    protected $keyType = 'string';
    protected $fillable = [
       'id_pembelian','id_periode', 'tanggal_transaksi', 'berat_bersih', 'nominal_pembelian','id_pelanggan','id_user'
    ];

    public static function DataAll($id)
    {
        $data = DB::table('kegiatan_pembelian')
            ->join('harga', 'kegiatan_pembelian.id_harga', '=', 'harga.id_harga')
            ->join('periode', 'kegiatan_pembelian.id_periode', '=', 'periode.id_periode')
            ->select('periode.*', 'kegiatan_pembelian.*','harga.*') 
            ->where('kegiatan_pembelian.id_user', $id)
            ->orderBy('kegiatan_pembelian.created_at','DESC')
            ->get();
        
        return $data;
    }

    public static function ListDataAll($periode,$tanggal,$pelanggan)
    {
        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $tanggal = date('d', strtotime($tanggal));

        $data = DB::table('kegiatan_pembelian')
            ->join('rincian_pembelian', 'kegiatan_pembelian.id_pembelian', '=', 'rincian_pembelian.id_kegiatan_pembelian')
            ->join('periode', 'kegiatan_pembelian.id_periode', '=', 'periode.id_periode')
            ->select('rincian_pembelian.*','kegiatan_pembelian.tanggal_transaksi') 
            ->where('rincian_pembelian.id_periode', $periode)
            ->whereYear('kegiatan_pembelian.tanggal_transaksi', $tahun)
            ->whereMonth('kegiatan_pembelian.tanggal_transaksi', $bulan)
            ->whereDay('kegiatan_pembelian.tanggal_transaksi', $tanggal)
            ->where('rincian_pembelian.id_pelanggan', $pelanggan)
            ->orderBy('rincian_pembelian.created_at','DESC')
            ->get();
        
        return $data;
    }

    public static function ListDataBulan($periode,$tanggal,$pelanggan)
    {
        list($month, $year) = explode("-", $tanggal);
        $tahun = $year;
        $bulan = $month;

        $data = DB::table('kegiatan_pembelian')
            ->join('rincian_pembelian', 'kegiatan_pembelian.id_pembelian', '=', 'rincian_pembelian.id_kegiatan_pembelian')
            ->join('periode', 'kegiatan_pembelian.id_periode', '=', 'periode.id_periode')
            ->select('rincian_pembelian.*','kegiatan_pembelian.tanggal_transaksi') 
            ->where('rincian_pembelian.id_periode', $periode)
            ->whereYear('kegiatan_pembelian.tanggal_transaksi', $tahun)
            ->whereMonth('kegiatan_pembelian.tanggal_transaksi', $bulan)
            ->where('rincian_pembelian.id_pelanggan', $pelanggan)
            ->orderBy('rincian_pembelian.created_at','DESC')
            ->get();
        
        return $data;
    }


    public static function ListDataTahun($periode,$tahun,$pelanggan)
    {

        $data = DB::table('kegiatan_pembelian')
            ->join('rincian_pembelian', 'kegiatan_pembelian.id_pembelian', '=', 'rincian_pembelian.id_kegiatan_pembelian')
            ->join('periode', 'kegiatan_pembelian.id_periode', '=', 'periode.id_periode')
            ->select('rincian_pembelian.*','kegiatan_pembelian.tanggal_transaksi') 
            ->where('rincian_pembelian.id_periode', $periode)
            ->whereYear('kegiatan_pembelian.tanggal_transaksi', $tahun)
            ->where('rincian_pembelian.id_pelanggan', $pelanggan)
            ->orderBy('rincian_pembelian.created_at','DESC')
            ->get();
        
        return $data;
    }

    public static function SumDashboard($id_pelanggan)
    {
        $data = DB::table('kegiatan_pembelian')
            ->select(
                DB::raw('IFNULL(SUM(kegiatan_pembelian.nominal_pembelian),0) as total_pembelian')
            )
            ->where('kegiatan_pembelian.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }

    
    

    

}
