<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PeriodeModel extends Model
{
    use HasFactory;
    protected $table ="periode";
    protected $primaryKey = 'id_periode';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = [
        'id_periode', 'id_tahun_ajaran', 'judul_periode', 'jenis_periode', 'jenis_kegiatan', 'tggl_awal_periode', 'tggl_akhir_periode', 'tggl_akhir_penilaian', 'tggl_periode', 'tanggungjawab_periode', 'pesan_periode', 'status_periode', 'id_user','deleted_at'
    ];

    public static function DataAll()
    {
        $data = DB::table('periode')
            ->join('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select('periode.*','tahun_ajaran.*',) 
            ->orderBy('periode.created_at', 'DESC')
            ->whereNull('periode.deleted_at')
            ->where('judul_periode', 'setoran')
            ->get();
        
        return $data;
    }

    public static function DataRapor()
    {
        $data = DB::table('periode')
            ->join('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select('periode.*','tahun_ajaran.*',) 
            ->orderBy('periode.created_at', 'DESC')
            ->whereNull('periode.deleted_at')
            ->where('judul_periode', 'rapor')
            ->get();
        
        return $data;
    }

    public static function DataPesertaRapor()
    {
        $data = DB::table('periode')
            ->leftJoin('rapor_kegiatan', 'periode.id_periode', '=', 'rapor_kegiatan.id_periode')
            ->leftJoin('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select('periode.*', 'tahun_ajaran.*', 
                     DB::raw('COALESCE(COUNT(rapor_kegiatan.id_siswa), 0) as siswa_count'))
            ->whereNull('periode.deleted_at')
            ->where('judul_periode', 'rapor')
            ->groupBy('periode.id_periode', 'tahun_ajaran.id_tahun_ajaran') // Group by unique identifiers
            ->orderBy('periode.created_at', 'DESC')
            ->get();
    
        return $data;
    }


    public static function DataPeriodeRapor($tahun,$jenjang,$periode)
    {
        $data = DB::table('periode')
            ->Join('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select('*')
            ->whereNull('periode.deleted_at')
            ->where('periode.id_periode',$periode)
            ->where('periode.id_tahun_ajaran',$tahun)
            ->where('periode.jenis_periode', $jenjang)
            ->first();
    
        return $data;
    }
    

}
