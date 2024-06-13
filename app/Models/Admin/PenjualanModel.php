<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PenjualanModel extends Model
{
    use HasFactory;
    protected $table ="kegiatan_penjualan";
    protected $primaryKey = "id_penjualan";
    protected $keyType = 'string';
    protected $fillable = [
      'id_penjualan','id_periode', 'berat_bersih_penjualan', 'nominal_penjualan','id_pelanggan', 'id_user'
    ];

    public static function DataAll($id)
    {
        $data = DB::table('kegiatan_penjualan')
            ->join('periode', 'kegiatan_penjualan.id_periode', '=', 'periode.id_periode')
            ->select('periode.*', 'kegiatan_penjualan.*') 
            ->where('kegiatan_penjualan.id_user', $id)
            ->orderBy('kegiatan_penjualan.created_at','DESC')
            ->get();
        
        return $data;
    }

    public static function ListDataAll($periode,$tanggal,$pelanggan)
    {
        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $tanggal = date('d', strtotime($tanggal));
        $data = DB::table('kegiatan_penjualan')
            ->join('rincian_penjualan', 'kegiatan_penjualan.id_penjualan', '=', 'rincian_penjualan.id_penjualan')
            ->join('periode', 'kegiatan_penjualan.id_periode', '=', 'periode.id_periode')
            ->select('rincian_penjualan.*') 
            ->where('kegiatan_penjualan.id_periode', $periode)
            ->whereYear('rincian_penjualan.tggl_rincian_penjualan', $tahun)
            ->whereMonth('rincian_penjualan.tggl_rincian_penjualan', $bulan)
            ->whereDay('rincian_penjualan.tggl_rincian_penjualan', $tanggal)
            ->where('rincian_penjualan.id_pelanggan', $pelanggan)
            ->orderBy('rincian_penjualan.created_at','DESC')
            ->get();
        
        return $data;
    }

    public static function ListDataBulan($periode,$tanggal,$pelanggan)
    {
        list($month, $year) = explode("-", $tanggal);
        $tahun = $year;
        $bulan = $month;
        $data = DB::table('kegiatan_penjualan')
            ->join('rincian_penjualan', 'kegiatan_penjualan.id_penjualan', '=', 'rincian_penjualan.id_penjualan')
            ->join('periode', 'kegiatan_penjualan.id_periode', '=', 'periode.id_periode')
            ->select('rincian_penjualan.*') 
            ->where('kegiatan_penjualan.id_periode', $periode)
            ->whereYear('rincian_penjualan.tggl_rincian_penjualan', $tahun)
            ->whereMonth('rincian_penjualan.tggl_rincian_penjualan', $bulan)
            ->where('rincian_penjualan.id_pelanggan', $pelanggan)
            ->orderBy('rincian_penjualan.created_at','DESC')
            ->get();
        
        return $data;
    }


    public static function ListDataTahun($periode,$tahun,$pelanggan)
    {
        $data = DB::table('kegiatan_penjualan')
            ->join('rincian_penjualan', 'kegiatan_penjualan.id_penjualan', '=', 'rincian_penjualan.id_penjualan')
            ->join('periode', 'kegiatan_penjualan.id_periode', '=', 'periode.id_periode')
            ->select('rincian_penjualan.*') 
            ->where('kegiatan_penjualan.id_periode', $periode)
            ->whereYear('rincian_penjualan.tggl_rincian_penjualan', $tahun)
            ->where('rincian_penjualan.id_pelanggan', $pelanggan)
            ->orderBy('rincian_penjualan.created_at','DESC')
            ->get();
        
        return $data;
    }

    public static function SumDashboard($id_pelanggan)
    {
        $data = DB::table('kegiatan_penjualan')
            ->select(
                DB::raw('IFNULL(SUM(kegiatan_penjualan.nominal_penjualan),0) as total_penjualan')
            )
            ->where('kegiatan_penjualan.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }

}
