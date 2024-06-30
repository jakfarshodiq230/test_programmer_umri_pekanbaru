<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PenilaianModel extends Model
{
    use HasFactory;
    protected $table ="penilaian_kegiatan";
    protected $fillable = [
        'id_penilaian_kegiatan', 'id_peserta_kegiatan', 'tanggal_penilaian_kegiatan', 'jenis_penilaian_kegiatan', 'surah_penilaian_kegiatan', 'ayat_awal_penilaian_kegiatan', 'ayat_akhir_penilaian_kegiatan', 'nilai_tajwid_penilaian_kegiatan', 'nilai_fasohah_penilaian_kegiatan', 'nilai_kelancaran_penilaian_kegiatan', 'nilai_ghunnah_penilaian_kegiatan', 'nilai_mad_penilaian_tahsin', 'nilai_waqof_penilaian_tahsin', 'keterangan_penilaian_kegiatan', 'deleted_at', 'id_user'
    ];

    public static function DataPenialainKegiatan($tahun,$periode,$siswa,$guru,$kelas)
    {
        $data = DB::table('penilaian_kegiatan')
            ->join('peserta_kegiatan', 'penilaian_kegiatan.id_peserta_kegiatan', '=', 'peserta_kegiatan.id_peserta_kegiatan')
            ->select(
                'penilaian_kegiatan.*',
                'peserta_kegiatan.*',
            )
            ->whereNull('penilaian_kegiatan.deleted_at')
            ->where('peserta_kegiatan.id_tahun_ajaran', $tahun)
            ->where('peserta_kegiatan.id_periode', $periode)
            ->where('peserta_kegiatan.id_siswa', $siswa)
            ->where('peserta_kegiatan.id_guru', $guru)
            ->where('peserta_kegiatan.id_kelas', $kelas)
            ->orderBy('penilaian_kegiatan.created_at', 'DESC')
            ->get();
    
        return $data; // Return the result set
    }    
    
    
    
}
