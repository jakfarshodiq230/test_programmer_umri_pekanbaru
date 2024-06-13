<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RincianModel extends Model
{
    use HasFactory;
    protected $table ="rincian_pembelian";
    protected $primaryKey = "id_rincian_pembelian";
    protected $keyType = 'string';
    protected $fillable = [
       'id_rincian_pembelian', 'id_kegiatan_pembelian', 'id_harga', 'id_periode', 'berat_normal', 'berat_potong', 'berat_bersih', 'nominal_rincian_pembelian','id_pelanggan','id_user'
    ];

    public static function DataRincianAll($id)
    {
        $data = DB::table('rincian_pembelian')
            ->join('harga', 'rincian_pembelian.id_harga', '=', 'harga.id_harga')
            ->join('periode', 'rincian_pembelian.id_periode', '=', 'periode.id_periode')
            ->join('kegiatan_pembelian', 'rincian_pembelian.id_kegiatan_pembelian', '=', 'kegiatan_pembelian.id_pembelian')
            ->select('kegiatan_pembelian.tanggal_transaksi as tgl_pembelian','kegiatan_pembelian.id_pembelian','periode.judul_periode','harga.harga as harga_beli','rincian_pembelian.*') 
            ->where('rincian_pembelian.id_kegiatan_pembelian', $id)
            ->get();
        
        return $data;
    }

    public static function DataPembukuanHari($hari,$id_periode,$id_pelanggan)
    {
        $tahun = date('Y', strtotime($hari));
        $bulan = date('m', strtotime($hari));
        $tanggal = date('d', strtotime($hari));

        $data = DB::table('rincian_pembelian')
        ->join('harga', 'rincian_pembelian.id_harga', '=', 'harga.id_harga')
        ->join('kegiatan_pembelian', 'rincian_pembelian.id_kegiatan_pembelian', '=', 'kegiatan_pembelian.id_pembelian')
        ->select(
            DB::raw('IFNULL(SUM(kegiatan_pembelian.berat_bersih), 0) as total_berat_bersih'),
            DB::raw('IFNULL(SUM(kegiatan_pembelian.nominal_pembelian), 0) as total_nominal_pembelian')
        ) 
        ->whereYear('kegiatan_pembelian.tanggal_transaksi', $tahun)
        ->whereMonth('kegiatan_pembelian.tanggal_transaksi', $bulan)
        ->whereDay('kegiatan_pembelian.tanggal_transaksi', $tanggal)
        ->where('kegiatan_pembelian.id_periode', $id_periode)
        ->where('kegiatan_pembelian.id_pelanggan', $id_pelanggan)
        ->first();
        return $data;
    }

    public static function DataPembukuanBulan($hari,$id_periode,$id_pelanggan)
    {
        list($month, $year) = explode("-", $hari);
        $tahun = $year;
        $bulan = $month;

        $data = DB::table('rincian_pembelian')
        ->join('harga', 'rincian_pembelian.id_harga', '=', 'harga.id_harga')
        ->join('kegiatan_pembelian', 'rincian_pembelian.id_kegiatan_pembelian', '=', 'kegiatan_pembelian.id_pembelian')
        ->select(
            DB::raw('IFNULL(SUM(kegiatan_pembelian.berat_bersih), 0) as total_berat_bersih'),
            DB::raw('IFNULL(SUM(kegiatan_pembelian.nominal_pembelian), 0) as total_nominal_pembelian')
        ) 
        ->whereYear('kegiatan_pembelian.tanggal_transaksi', $tahun)
        ->whereMonth('kegiatan_pembelian.tanggal_transaksi', $bulan)
        ->where('kegiatan_pembelian.id_periode', $id_periode)
        ->where('kegiatan_pembelian.id_pelanggan', $id_pelanggan)
        ->first();
        return $data;
    }

    public static function DataPembukuanTahun($hari,$id_periode,$id_pelanggan)
    {

        $data = DB::table('rincian_pembelian')
        ->join('harga', 'rincian_pembelian.id_harga', '=', 'harga.id_harga')
        ->join('kegiatan_pembelian', 'rincian_pembelian.id_kegiatan_pembelian', '=', 'kegiatan_pembelian.id_pembelian')
        ->select(
            DB::raw('IFNULL(SUM(kegiatan_pembelian.berat_bersih), 0) as total_berat_bersih'),
            DB::raw('IFNULL(SUM(kegiatan_pembelian.nominal_pembelian), 0) as total_nominal_pembelian')
        ) 
        ->whereYear('kegiatan_pembelian.tanggal_transaksi', $hari)
        ->where('kegiatan_pembelian.id_periode', $id_periode)
        ->where('kegiatan_pembelian.id_pelanggan', $id_pelanggan)
        ->first();
        return $data;
    }

    public static function datahariIni($id_pelanggan)
    {
        $data = DB::table('rincian_pembelian')
            ->join('kegiatan_pembelian', 'rincian_pembelian.id_kegiatan_pembelian', '=', 'kegiatan_pembelian.id_pembelian')
            ->join('users', 'rincian_pembelian.id_user', '=', 'users.id')
            ->join('harga', 'rincian_pembelian.id_harga', '=', 'harga.id_harga')
            ->select('users.nama_user', 'harga.harga', 'rincian_pembelian.*')
            ->whereDate('kegiatan_pembelian.tanggal_transaksi', now()->toDateString())
            ->where('rincian_pembelian.id_pelanggan', $id_pelanggan)
            ->orderBy('kegiatan_pembelian.tanggal_transaksi', 'DESC')
            ->get();
        
        return $data;
    }
    


}
