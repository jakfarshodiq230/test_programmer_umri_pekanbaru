<?php

namespace App\Models\Guru;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PenilaianPengembanganDiriModel extends Model
{
    use HasFactory;
    protected $table ="rapor_pengembangan_diri";
    protected $primaryKey = 'id_pengembangan_diri';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = [
        'id_pengembangan_diri',
        'id_rapor',
        'id_tahun_ajaran',
        'id_periode',
        'id_siswa',
        'id_kelas',
        'id_guru',
        'jenis_penilaian_kegiatan',
        'awal_surah_baru',
        'akhir_surah_baru',
        'awal_ayat_baru',
        'akhir_ayat_baru',
        'awal_surah_lama',
        'akhir_surah_lama',
        'awal_ayat_lama',
        'akhir_ayat_lama',
        'n_k_p',
        'n_m_p',
        'n_t_p',
        'n_th_p',
        'n_tf_p',
        'n_jk_p',
        'tggl_penilaian_p',
        'ketrangan_p',
        'deleted_at',
        'id_user'
    ];


    public static function DataAjaxPesertaRapor($id,$peserta,$tahun,$jenjang,$periode)  {
        
        $data = DB::table('rapor_pengembangan_diri')
        ->leftjoin('siswa', 'rapor_pengembangan_diri.id_siswa', '=', 'siswa.id_siswa')
        ->leftjoin('kelas', 'rapor_pengembangan_diri.id_kelas', '=', 'kelas.id_kelas')
        ->leftjoin('guru', 'rapor_pengembangan_diri.id_guru', '=', 'guru.id_guru')
        ->leftjoin('periode', 'rapor_pengembangan_diri.id_periode', '=', 'periode.id_periode')
        ->leftjoin('rapor_kegiatan', 'rapor_pengembangan_diri.id_rapor', '=', 'rapor_kegiatan.id_rapor')
        ->leftjoin('tahun_ajaran', 'rapor_pengembangan_diri.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
        ->select(
            'siswa.*',
            'kelas.*',
            'guru.*',
            'periode.*',
            'rapor_pengembangan_diri.*',
            'rapor_kegiatan.*',
            'tahun_ajaran.*',
        )
        ->whereNull('rapor_pengembangan_diri.deleted_at')
        ->whereNull('siswa.deleted_at')
        ->where('rapor_pengembangan_diri.id_rapor', $id)
        ->where('rapor_pengembangan_diri.id_siswa', $peserta)
        ->where('rapor_pengembangan_diri.id_tahun_ajaran', $tahun)
        ->where('rapor_pengembangan_diri.jenis_penilaian_kegiatan', $jenjang)
        ->where('rapor_pengembangan_diri.id_periode', $periode)
        ->where('rapor_pengembangan_diri.id_guru', session('user')['id']) // ganti dengan session nantinya
        ->first();

        return $data; // Return the result set
    }

    public static function DataAjaxEditPenilaianRapor($id,$rapor,$peserta,$tahun,$jenjang,$periode)  {
        
        $data = DB::table('rapor_pengembangan_diri')
        ->leftjoin('siswa', 'rapor_pengembangan_diri.id_siswa', '=', 'siswa.id_siswa')
        ->leftjoin('kelas', 'rapor_pengembangan_diri.id_kelas', '=', 'kelas.id_kelas')
        ->leftjoin('guru', 'rapor_pengembangan_diri.id_guru', '=', 'guru.id_guru')
        ->leftjoin('periode', 'rapor_pengembangan_diri.id_periode', '=', 'periode.id_periode')
        ->leftjoin('rapor_kegiatan', 'rapor_pengembangan_diri.id_rapor', '=', 'rapor_kegiatan.id_rapor')
        ->leftjoin('tahun_ajaran', 'rapor_pengembangan_diri.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
        ->select(
            'siswa.*',
            'kelas.*',
            'guru.*',
            'periode.*',
            'rapor_pengembangan_diri.*',
            'rapor_kegiatan.*',
            'tahun_ajaran.*',
        )
        ->whereNull('rapor_pengembangan_diri.deleted_at')
        ->whereNull('siswa.deleted_at')
        ->where('rapor_pengembangan_diri.id_pengembangan_diri', $id)
        ->where('rapor_pengembangan_diri.id_rapor', $rapor)
        ->where('rapor_pengembangan_diri.id_siswa', $peserta)
        ->where('rapor_pengembangan_diri.id_tahun_ajaran', $tahun)
        ->where('rapor_pengembangan_diri.jenis_penilaian_kegiatan', $jenjang)
        ->where('rapor_pengembangan_diri.id_periode', $periode)
        ->where('rapor_pengembangan_diri.id_guru', session('user')['id']) // ganti dengan session nantinya
        ->first();

        return $data; // Return the result set
    }


}
