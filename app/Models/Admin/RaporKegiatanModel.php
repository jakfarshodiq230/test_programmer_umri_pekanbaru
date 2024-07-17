<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RaporKegiatanModel extends Model
{
    use HasFactory;
    protected $table ="rapor_kegiatan";
    protected $primaryKey = 'id_rapor';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = [
        'id_rapor', 'id_tahun_ajaran', 'id_periode', 'id_siswa', 'id_kelas', 'id_guru', 'jenis_penilaian_kegiatan', 'surah_baru', 'surah_lama', 'n_j_baru', 'n_f_baru', 'n_k_baru', 'n_g_baru', 'n_m_baru', 'n_w_baru', 'n_j_lama', 'n_f_lama', 'n_k_lama', 'n_g_lama', 'n_m_lama', 'n_w_lama','id_user','deleted_at'
    ];

    public static function DataPesertaRapor($tahun,$jenjang,$periode)  {
        
        $data = DB::table('rapor_kegiatan')
        ->join('siswa', 'rapor_kegiatan.id_siswa', '=', 'siswa.id_siswa')
        ->join('kelas', 'rapor_kegiatan.id_kelas', '=', 'kelas.id_kelas')
        ->join('guru', 'rapor_kegiatan.id_guru', '=', 'guru.id_guru')
        ->join('periode', 'rapor_kegiatan.id_periode', '=', 'periode.id_periode')
        ->select(
            'siswa.*',
            'kelas.*',
            'guru.*',
            'periode.*',
            'rapor_kegiatan.*',
        )
        ->whereNull('rapor_kegiatan.deleted_at')
        ->whereNull('siswa.deleted_at')
        ->where('rapor_kegiatan.id_tahun_ajaran', $tahun)
        ->where('rapor_kegiatan.jenis_penilaian_kegiatan', $jenjang)
        ->where('rapor_kegiatan.id_periode', $periode)
        ->get();

        return $data; // Return the result set
    }

    public static function DataAjaxPesertaRapor($id,$peserta, $tahun,$jenjang,$periode)  {
        
        $data = DB::table('rapor_kegiatan')
        ->join('siswa', 'rapor_kegiatan.id_siswa', '=', 'siswa.id_siswa')
        ->join('kelas', 'rapor_kegiatan.id_kelas', '=', 'kelas.id_kelas')
        ->join('guru', 'rapor_kegiatan.id_guru', '=', 'guru.id_guru')
        ->join('periode', 'rapor_kegiatan.id_periode', '=', 'periode.id_periode')
        ->join('tahun_ajaran', 'rapor_kegiatan.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
        ->leftjoin('rapor_pengembangan_diri', 'rapor_kegiatan.id_rapor', '=', 'rapor_pengembangan_diri.id_rapor')
        ->select(
            'siswa.*',
            'kelas.*',
            'guru.*',
            'periode.*',
            'rapor_kegiatan.*',
            'tahun_ajaran.*',
            'rapor_pengembangan_diri.*',
        )
        ->whereNull('rapor_kegiatan.deleted_at')
        ->whereNull('siswa.deleted_at')
        ->where('rapor_kegiatan.id_rapor', $id)
        ->where('rapor_kegiatan.id_siswa', $peserta)
        ->where('rapor_kegiatan.id_tahun_ajaran', $tahun)
        ->where('rapor_kegiatan.jenis_penilaian_kegiatan', $jenjang)
        ->where('rapor_kegiatan.id_periode', $periode)
        ->first();

        return $data; // Return the result set
    }

}
