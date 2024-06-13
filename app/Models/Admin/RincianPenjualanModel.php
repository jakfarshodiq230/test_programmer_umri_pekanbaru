<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RincianPenjualanModel extends Model
{
    use HasFactory;
    protected $table ="rincian_penjualan";
    protected $primaryKey = "id_rincian_penjualan";
    protected $keyType = 'string';
    protected $fillable = [
       'id_rincian_penjualan', 'id_penjualan', 'berat_normal', 'berat_potongan', 'berat_bersih', 'harga_jual', 'nominal_rincian_penjualan', 'keterangan_penjualan', 'tggl_rincian_penjualan','id_pelanggan','id_user'
    ];

    public static function DataRincianAll($id)
    {
        $data = DB::table('rincian_penjualan')
            ->join('kegiatan_penjualan', 'rincian_penjualan.id_penjualan', '=', 'kegiatan_penjualan.id_penjualan')
            ->select('kegiatan_penjualan.created_at as tggl_penjualan','rincian_penjualan.*') 
            ->where('rincian_penjualan.id_penjualan', $id)
            ->get();
        
        return $data;
    }


    public static function DataPembukuanHari($hari,$id_periode,$id_pelanggan)
    {
        $tahun = date('Y', strtotime($hari));
        $bulan = date('m', strtotime($hari));
        $tanggal = date('d', strtotime($hari));

        $data = DB::table('rincian_penjualan')
            ->join('kegiatan_penjualan', 'rincian_penjualan.id_penjualan', '=', 'kegiatan_penjualan.id_penjualan')
            ->select(
                DB::raw('IFNULL(SUM(kegiatan_penjualan.berat_bersih_penjualan),0) as total_berat_bersih_penjualan'),
                DB::raw('IFNULL(SUM(kegiatan_penjualan.nominal_penjualan),0) as total_nominal_penjualan')
            )
            ->whereYear('rincian_penjualan.tggl_rincian_penjualan', $tahun)
            ->whereMonth('rincian_penjualan.tggl_rincian_penjualan', $bulan)
            ->whereDay('rincian_penjualan.tggl_rincian_penjualan', $tanggal)
            ->where('kegiatan_penjualan.id_periode', $id_periode)
            ->where('kegiatan_penjualan.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }

    public static function DataPembukuanBulan($hari,$id_periode,$id_pelanggan)
    {
        list($month, $year) = explode("-", $hari);
        $tahun = $year;
        $bulan = $month;

        $data = DB::table('rincian_penjualan')
            ->join('kegiatan_penjualan', 'rincian_penjualan.id_penjualan', '=', 'kegiatan_penjualan.id_penjualan')
            ->select(
                DB::raw('IFNULL(SUM(kegiatan_penjualan.berat_bersih_penjualan),0) as total_berat_bersih_penjualan'),
                DB::raw('IFNULL(SUM(kegiatan_penjualan.nominal_penjualan),0) as total_nominal_penjualan')
            )
            ->whereYear('rincian_penjualan.tggl_rincian_penjualan', $tahun)
            ->whereMonth('rincian_penjualan.tggl_rincian_penjualan', $bulan)
            ->where('kegiatan_penjualan.id_periode', $id_periode)
            ->where('kegiatan_penjualan.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }


    public static function DataPembukuanTahun($hari,$id_periode,$id_pelanggan)
    {

        $data = DB::table('rincian_penjualan')
            ->join('kegiatan_penjualan', 'rincian_penjualan.id_penjualan', '=', 'kegiatan_penjualan.id_penjualan')
            ->select(
                DB::raw('IFNULL(SUM(kegiatan_penjualan.berat_bersih_penjualan),0) as total_berat_bersih_penjualan'),
                DB::raw('IFNULL(SUM(kegiatan_penjualan.nominal_penjualan),0) as total_nominal_penjualan')
            )
            ->whereYear('rincian_penjualan.tggl_rincian_penjualan', $hari)
            ->where('kegiatan_penjualan.id_periode', $id_periode)
            ->where('kegiatan_penjualan.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }

    public static function datahariIni($id_pelanggan)
    {
        $data = DB::table('rincian_penjualan')
            ->join('kegiatan_penjualan', 'rincian_penjualan.id_penjualan', '=', 'kegiatan_penjualan.id_penjualan')
            ->join('users', 'rincian_penjualan.id_user', '=', 'users.id')
            ->select('users.nama_user','rincian_penjualan.*' )
            ->where('rincian_penjualan.tggl_rincian_penjualan',now()->toDateString())
            ->where('rincian_penjualan.id_pelanggan', $id_pelanggan)
            ->orderBy('rincian_penjualan.tggl_rincian_penjualan','DESC')
            ->get();
        
        return $data;
    }

}
