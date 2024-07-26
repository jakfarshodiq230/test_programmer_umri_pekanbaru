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
        'id_periode', 'id_tahun_ajaran', 'judul_periode', 'jenis_periode', 'jenis_kegiatan', 
        'tggl_awal_periode', 'tggl_akhir_periode', 'tggl_akhir_penilaian', 'tggl_periode',
        'tanggungjawab_periode', 'pesan_periode', 'status_periode', 'file_periode', 'id_user','deleted_at',
        'juz_periode', 'sesi_periode'
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

    public static function DataSertifikat()
    {
        $data = DB::table('periode')
            ->join('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select('periode.*','tahun_ajaran.*',) 
            ->orderBy('periode.created_at', 'DESC')
            ->whereNull('periode.deleted_at')
            ->where('judul_periode', 'sertifikasi')
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

    public static function DataPesertaSertifikasi()
    {
        $data = DB::table('periode')
            ->leftJoin('peserta_sertifikasi', 'periode.id_periode', '=', 'peserta_sertifikasi.id_periode')
            ->leftJoin('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select('periode.*', 'tahun_ajaran.*', 
                     DB::raw('COALESCE(COUNT(peserta_sertifikasi.id_siswa), 0) as siswa_count'))
            ->whereNull('periode.deleted_at')
            ->whereNull('peserta_sertifikasi.deleted_at')
            ->where('judul_periode', 'sertifikasi')
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

    public static function PresentasePeriode()
    {
        $data = DB::table('periode')
            ->leftJoin('peserta_kegiatan', 'periode.id_periode', '=', 'peserta_kegiatan.id_periode')
            ->leftJoin('peserta_sertifikasi', 'periode.id_periode', '=', 'peserta_sertifikasi.id_periode')
            ->leftJoin('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select(
                'periode.judul_periode',
                'periode.jenis_periode',
                'periode.juz_periode',
                'tahun_ajaran.nama_tahun_ajaran',
                DB::raw('COUNT(DISTINCT peserta_kegiatan.id_siswa) as jumlah_siswa_setoran'),
                DB::raw('COUNT(DISTINCT peserta_sertifikasi.id_siswa) as jumlah_siswa_sertifikasi'),
            )
            ->whereNull('periode.deleted_at')
            ->where('periode.judul_periode', '!=', 'rapor')
            ->groupBy(
                'periode.id_periode',
            )
            ->get();
            
        return $data;
    }

    public static function Dashboard()
    {
        $data = DB::table('periode')
            ->select('*')
            ->whereNull('periode.deleted_at')
            ->where('periode.judul_periode', '!=', 'setoran')
            ->where('periode.status_periode', '=', 1)
            ->orderBy('periode.tggl_akhir_penilaian','ASC')
            ->get();
            
        return $data;
    }
    
}
