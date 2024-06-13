<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PengeluaranModel extends Model
{
    use HasFactory;
    protected $table ="kegiatan_pengeluaran";
    protected $primaryKey = "id_pengeluaran";
    protected $keyType = 'string';
    protected $fillable = [
      'id_pengeluaran','id_periode', 'keterangan_pengeluaran', 'nominal_pengeluaran','tgl_pengeluaran','id_pelanggan','id_user'
    ];

    public static function DataAll($id)
    {
        $data = DB::table('kegiatan_pengeluaran')
            //->join('periode', 'kegiatan_pengeluaran.id_periode', '=', 'periode.id_periode')
            //->join('periode', 'kegiatan_pengeluaran.id_periode', '=', 'periode.id_periode')
            ->select('periode.*', 'kegiatan_pengeluaran.*') 
            ->where('kegiatan_pengeluaran.id_user', $id)
            ->orderBy('kegiatan_pengeluaran.created_at','DESC')
            ->get();
        
        return $data;
    }

    public static function SumDashboard($id_pelanggan)
    {
        $data = DB::table('kegiatan_pengeluaran')
            ->select(
                DB::raw('IFNULL(SUM(kegiatan_pengeluaran.nominal_pengeluaran),0) as total_pengeluaran')
            )
            ->where('kegiatan_pengeluaran.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }

    public static function DataPembukuanHari($hari,$id_periode,$id_pelanggan)
    {
        $tahun = date('Y', strtotime($hari));
        $bulan = date('m', strtotime($hari));
        $tanggal = date('d', strtotime($hari));

        $data = DB::table('kegiatan_pengeluaran')
            ->select(
                DB::raw('IFNULL(SUM(kegiatan_pengeluaran.nominal_pengeluaran),0) as total_pengeluaran')
            )
            ->whereYear('kegiatan_pengeluaran.tgl_pengeluaran', $tahun)
            ->whereMonth('kegiatan_pengeluaran.tgl_pengeluaran', $bulan)
            ->whereDay('kegiatan_pengeluaran.tgl_pengeluaran', $tanggal)
            ->where('kegiatan_pengeluaran.id_periode', $id_periode)
            ->where('kegiatan_pengeluaran.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }

    public static function ListDataAll($periode,$tanggal,$pelanggan)
    {
        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $tanggal = date('d', strtotime($tanggal));

        $data = DB::table('kegiatan_pengeluaran')
            ->select('kegiatan_pengeluaran.*') 
            ->where('kegiatan_pengeluaran.id_periode', $periode)
            ->whereYear('kegiatan_pengeluaran.tgl_pengeluaran', $tahun)
            ->whereMonth('kegiatan_pengeluaran.tgl_pengeluaran', $bulan)
            ->whereDay('kegiatan_pengeluaran.tgl_pengeluaran', $tanggal)
            ->where('kegiatan_pengeluaran.id_pelanggan', $pelanggan)
            ->orderBy('kegiatan_pengeluaran.created_at','DESC')
            ->get();
        
        return $data;
    }

    public static function DataPembukuanBulan($hari,$id_periode,$id_pelanggan)
    {
        list($month, $year) = explode("-", $hari);
        $tahun = $year;
        $bulan = $month;

        $data = DB::table('kegiatan_pengeluaran')
            ->select(
                DB::raw('IFNULL(SUM(kegiatan_pengeluaran.nominal_pengeluaran),0) as total_pengeluaran')
            )
            ->whereYear('kegiatan_pengeluaran.tgl_pengeluaran', $tahun)
            ->whereMonth('kegiatan_pengeluaran.tgl_pengeluaran', $bulan)
            ->where('kegiatan_pengeluaran.id_periode', $id_periode)
            ->where('kegiatan_pengeluaran.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }

    public static function ListDataBulan($periode,$tanggal,$pelanggan)
    {
        list($month, $year) = explode("-", $tanggal);
        $tahun = $year;
        $bulan = $month;

        $data = DB::table('kegiatan_pengeluaran')
            ->select('kegiatan_pengeluaran.*') 
            ->where('kegiatan_pengeluaran.id_periode', $periode)
            ->whereYear('kegiatan_pengeluaran.tgl_pengeluaran', $tahun)
            ->whereMonth('kegiatan_pengeluaran.tgl_pengeluaran', $bulan)
            ->where('kegiatan_pengeluaran.id_pelanggan', $pelanggan)
            ->orderBy('kegiatan_pengeluaran.created_at','DESC')
            ->get();
        
        return $data;
    }

    public static function ListDataTahun($periode,$tahun,$pelanggan)
    {

        $data = DB::table('kegiatan_pengeluaran')
            ->select('kegiatan_pengeluaran.*') 
            ->where('kegiatan_pengeluaran.id_periode', $periode)
            ->whereYear('kegiatan_pengeluaran.tgl_pengeluaran', $tahun)
            ->where('kegiatan_pengeluaran.id_pelanggan', $pelanggan)
            ->orderBy('kegiatan_pengeluaran.created_at','DESC')
            ->get();
        
        return $data;
    }


    public static function DataPembukuanTahun($hari,$id_periode,$id_pelanggan)
    {
        $data = DB::table('kegiatan_pengeluaran')
            ->select(
                DB::raw('IFNULL(SUM(kegiatan_pengeluaran.nominal_pengeluaran),0) as total_pengeluaran')
            )
            ->whereYear('kegiatan_pengeluaran.tgl_pengeluaran', $hari)
            ->where('kegiatan_pengeluaran.id_periode', $id_periode)
            ->where('kegiatan_pengeluaran.id_pelanggan', $id_pelanggan)
            ->first();
        
        return $data;
    }


    public static function datahariIni($id_pelanggan)
    {
        $data = DB::table('kegiatan_pengeluaran')
            ->join('users', 'kegiatan_pengeluaran.id_user', '=', 'users.id')
            ->select('users.nama_user','kegiatan_pengeluaran.*' )
            ->where('kegiatan_pengeluaran.tgl_pengeluaran',now()->toDateString())
            ->where('kegiatan_pengeluaran.id_pelanggan', $id_pelanggan)
            ->orderBy('kegiatan_pengeluaran.tgl_pengeluaran','DESC')
            ->get();
        
        return $data;
    }
}
