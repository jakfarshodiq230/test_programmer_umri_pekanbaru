<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class BayarModel extends Model
{
    use HasFactory;
    protected $table ="bayar";
    protected $primaryKey = 'id';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'tanggal', 'id_jenis_bayar', 'id_mahasiswa', 'jumlah'
    ];


    public static function GetPembayaranAll()
    {
        $data = DB::table('bayar')
            ->leftJoin('mtr_mahasiswa', 'bayar.id_mahasiswa', '=', 'mtr_mahasiswa.nim_mhs')
            ->leftJoin('jenis_bayar', 'bayar.id_jenis_bayar', '=', 'jenis_bayar.id')
            ->select(
                'mtr_mahasiswa.*',
                'jenis_bayar.*',
                'bayar.*'
            )
            ->whereNull('bayar.deleted_at')
            ->orderBy('bayar.created_at', 'DESC')
            ->get();
    
        return $data; // Return the result set
    }

    public static function GetPembayaranID($id)
    {
        $data = DB::table('bayar')
            ->leftJoin('mtr_mahasiswa', 'bayar.id_mahasiswa', '=', 'mtr_mahasiswa.nim_mhs')
            ->leftJoin('jenis_bayar', 'bayar.id_jenis_bayar', '=', 'jenis_bayar.id')
            ->leftJoin('mtr_prodi', 'mtr_mahasiswa.id_program_studi', '=', 'mtr_prodi.id')
            ->select(
                'mtr_mahasiswa.*',
                'bayar.id AS IDBayar', 
                'bayar.tanggal', 
                'bayar.id_jenis_bayar', 
                'bayar.id_mahasiswa', 
                'bayar.jumlah', 
                'jenis_bayar.*',
                'mtr_prodi.*'
            )
            ->whereNull('bayar.deleted_at')
            ->where('bayar.id', $id)
            ->first();
    
        return $data; // Return the result set
    }

    public static function GetPembayaranRekap($awal,$akhir)
    {
        $awal = Carbon::parse($awal)->startOfDay()->format('Y-m-d H:i:s');
        $akhir = Carbon::parse($akhir)->endOfDay()->format('Y-m-d H:i:s');

        $data = DB::table('bayar')
            ->leftJoin('mtr_mahasiswa', 'bayar.id_mahasiswa', '=', 'mtr_mahasiswa.nim_mhs')
            ->leftJoin('jenis_bayar', 'bayar.id_jenis_bayar', '=', 'jenis_bayar.id')
            ->leftJoin('mtr_prodi', 'mtr_mahasiswa.id_program_studi', '=', 'mtr_prodi.id')
            ->select(
                'mtr_mahasiswa.*',
                'bayar.id AS IDBayar', 
                'bayar.tanggal', 
                'bayar.id_jenis_bayar', 
                'bayar.id_mahasiswa', 
                'bayar.jumlah', 
                'jenis_bayar.*',
                'mtr_prodi.*'
            )
            ->whereNull('bayar.deleted_at')
            ->whereBetween('bayar.tanggal', [$awal, $akhir])
            ->get();
    
        return $data; // Return the result set
    }

    public static function DataExcel($awal,$akhir)
    {
        $awal = Carbon::parse($awal)->startOfDay()->format('Y-m-d H:i:s');
        $akhir = Carbon::parse($akhir)->endOfDay()->format('Y-m-d H:i:s');

        $data = DB::table('bayar')
            ->leftJoin('mtr_mahasiswa', 'bayar.id_mahasiswa', '=', 'mtr_mahasiswa.nim_mhs')
            ->leftJoin('jenis_bayar', 'bayar.id_jenis_bayar', '=', 'jenis_bayar.id')
            ->leftJoin('mtr_prodi', 'mtr_mahasiswa.id_program_studi', '=', 'mtr_prodi.id')
            ->select(
                'mtr_mahasiswa.nim_mhs',
                'mtr_mahasiswa.nama_mhs',
                'bayar.tanggal', 
                'jenis_bayar.nama_pembayaran', 
                'bayar.jumlah', 
            )
            ->whereNull('bayar.deleted_at')
            ->whereBetween('bayar.tanggal', [$awal, $akhir])
            ->get();
    
        return $data; // Return the result set
    }
}
