<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PembukuanModel extends Model
{
    use HasFactory;
    protected $table ="pembukuan";
    protected $primaryKey = "id_pembukuan";
    protected $keyType = 'string';
    protected $fillable = [
       'id_pembukuan', 'id_periode', 'judul_pembukuan', 'jenis_pembukuan', 'tgl_hari_pembukuan',
       'bulan_pembukuan', 'tahun_pembukuan', 'tanggal_pembukuan', 'total_penjualan', 'total_pembelian',
       'total_pengeluaran', 'total_berat_pembelian', 'total_berat_penjualan', 'pendapatan_bersih','id_pelanggan', 'id_user'
    ];

    public static function DataPembukuanAll($pelanggan)
    {
        $data = DB::table('pembukuan')
            ->join('periode', 'pembukuan.id_periode', '=', 'periode.id_periode')
            ->select('pembukuan.*','periode.*',) 
            ->where('pembukuan.jenis_pembukuan', 'hari')
            ->where('pembukuan.id_pelanggan', $pelanggan)
            ->orderBy('pembukuan.created_at', 'DESC')
            ->get();
        
        return $data;
    }

    public static function DataPembukuanBulan($pelanggan)
    {
        $data = DB::table('pembukuan')
            ->join('periode', 'pembukuan.id_periode', '=', 'periode.id_periode')
            ->select('pembukuan.*','periode.*',) 
            ->where('pembukuan.jenis_pembukuan', 'bulan')
            ->where('pembukuan.id_pelanggan', $pelanggan)
            ->orderBy('pembukuan.created_at', 'DESC')
            ->get();
        
        return $data;
    }


    public static function DataPembukuanTahun($pelanggan)
    {
        $data = DB::table('pembukuan')
            ->join('periode', 'pembukuan.id_periode', '=', 'periode.id_periode')
            ->select('pembukuan.*','periode.*',) 
            ->where('pembukuan.jenis_pembukuan', 'tahun')
            ->where('pembukuan.id_pelanggan', $pelanggan)
            ->orderBy('pembukuan.created_at', 'DESC')
            ->get();
        
        return $data;
    }

    public static function DataStatistikPembukuan($pelanggan)
    {
        $data = DB::table('pembukuan')
            ->join('periode', 'pembukuan.id_periode', '=', 'periode.id_periode')
            ->join('users', 'pembukuan.id_user', '=', 'users.id')
            ->select('pembukuan.*','periode.*','users.nama_user') 
            ->where('pembukuan.id_pelanggan', $pelanggan)
            ->orderBy('pembukuan.created_at', 'DESC')
            ->get();
        
        return $data;
    }
}
