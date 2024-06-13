<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RincianPembukuanModel extends Model
{
    use HasFactory;
    protected $table ="rincian_pembukuan";
    protected $fillable = [
       'id_pembukuan', 'id_periode', 'judul_pembukuan', 'jenis_pembukuan', 'tgl_hari_pembukuan',
       'bulan_pembukuan', 'tahun_pembukuan', 'tanggal_pembukuan', 'total_penjualan', 'total_pembelian',
       'total_pengeluaran', 'total_berat_pembelian', 'total_berat_penjualan', 'pendapatan_bersih','id_pelanggan','id_user'
    ];

    public static function DataPembukuanAll($pelanggan)
    {
        $data = DB::table('rincian_pembukuan')
            ->join('periode', 'rincian_pembukuan.id_periode', '=', 'periode.id_periode')
            ->select('rincian_pembukuan.*','periode.*',) 
            ->where('rincian_pembukuan.id_pelanggan', $pelanggan)
            ->orderBy('rincian_pembukuan.created_at', 'DESC')
            ->get();
        
        return $data;
    }

    public static function DataPembukuanHariRincian($id_periode,$id_pelanggan)
    {
        $data = DB::table('rincian_pembukuan')
            ->select(
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_penjualan),0) as total_penjualan_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_pembelian),0) as total_pembelian_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_pengeluaran),0) as total_pengeluaran_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_berat_pembelian),0) as total_berat_pembelian_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_berat_penjualan),0) as total_berat_penjualan_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.pendapatan_bersih),0) as total_pendapatan_bersih_periode')
            )
            ->where('rincian_pembukuan.jenis_pembukuan', 'hari')
            ->where('rincian_pembukuan.id_periode', $id_periode)
            ->where('rincian_pembukuan.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }

    public static function DataRincianPembukuanHari($id_periode, $id_pembukuan, $pelanggan)
    {
        $data = DB::table('rincian_pembukuan')
            ->join('periode', 'rincian_pembukuan.id_periode', '=', 'periode.id_periode')
            ->select('rincian_pembukuan.*','periode.*',) 
            ->where('rincian_pembukuan.jenis_pembukuan', 'hari')
            ->where('rincian_pembukuan.id_periode', $id_periode)
            ->where('rincian_pembukuan.id_pembukuan', $id_pembukuan)
            ->where('rincian_pembukuan.id_pelanggan', $pelanggan)
            ->orderBy('rincian_pembukuan.created_at', 'DESC')
            ->get();
        
        return $data;
    }

    public static function DataRincianPembukuanBulan($id_pembukuan, $id_periode, $pelanggan)
    {
        $data = DB::table('rincian_pembukuan')
            ->join('periode', 'rincian_pembukuan.id_periode', '=', 'periode.id_periode')
            ->select('rincian_pembukuan.*','periode.*',) 
            ->where('rincian_pembukuan.jenis_pembukuan', 'bulan')
            ->where('rincian_pembukuan.id_pembukuan', $id_pembukuan)
            ->where('rincian_pembukuan.id_periode', $id_periode)
            ->where('rincian_pembukuan.id_pelanggan', $pelanggan)
            ->orderBy('rincian_pembukuan.created_at', 'DESC')
            ->get();
        
        return $data;
    }

    public static function DataRincianPembukuanTahun($id_pembukuan, $id_periode, $tahun, $pelanggan)
    {
        $data = DB::table('rincian_pembukuan')
            ->join('periode', 'rincian_pembukuan.id_periode', '=', 'periode.id_periode')
            ->select('rincian_pembukuan.*','periode.*',) 
            ->where('rincian_pembukuan.jenis_pembukuan', 'tahun')
            ->where('rincian_pembukuan.tahun_pembukuan', $tahun)
            ->where('rincian_pembukuan.id_pembukuan', $id_pembukuan)
            ->where('rincian_pembukuan.id_periode', $id_periode)
            ->where('rincian_pembukuan.id_pelanggan', $pelanggan)
            ->orderBy('rincian_pembukuan.created_at', 'DESC')
            ->get();
        
        return $data;
    }

    public static function DataPembukuanBulanRincian($id_periode,$id_pelanggan)
    {
        $data = DB::table('rincian_pembukuan')
            ->select(
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_penjualan),0) as total_penjualan_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_pembelian),0) as total_pembelian_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_pengeluaran),0) as total_pengeluaran_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_berat_pembelian),0) as total_berat_pembelian_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.total_berat_penjualan),0) as total_berat_penjualan_periode'),
                DB::raw('IFNULL(SUM(rincian_pembukuan.pendapatan_bersih),0) as total_pendapatan_bersih_periode')
            )
            ->where('rincian_pembukuan.jenis_pembukuan', 'bulan')
            ->where('rincian_pembukuan.id_periode', $id_periode)
            ->where('rincian_pembukuan.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }

    

}
