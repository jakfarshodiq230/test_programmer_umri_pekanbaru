<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PenilaianSmModel extends Model
{
    use HasFactory;
    protected $table ="sm_penilaian_kegiatan";
    protected $primaryKey = 'id_penilaian_kegiatan';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'id_penilaian_kegiatan', 'id_peserta_kegiatan', 'id_periode', 'surah_awal_penilaian_kegiatan', 'surah_akhir_penilaian_kegiatan', 'tanggal_penilaian_kegiatan', 'jenis_penilaian_kegiatan', 'surah_penilaian_kegiatan', 'ayat_awal_penilaian_kegiatan', 'ayat_akhir_penilaian_kegiatan', 'nilai_tajwid_penilaian_kegiatan', 'nilai_fasohah_penilaian_kegiatan', 'nilai_kelancaran_penilaian_kegiatan', 'nilai_ghunnah_penilaian_kegiatan', 'nilai_mad_penilaian_tahsin', 'nilai_waqof_penilaian_tahsin', 'keterangan_penilaian_kegiatan', 'deleted_at', 'id_user'
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
    
    public static function DataNilaiSementara($periode, $guru, $kegiatan)
    {
        $data = DB::table('sm_penilaian_kegiatan')
            ->join('surah as surah_awal', 'sm_penilaian_kegiatan.surah_awal_penilaian_kegiatan', '=', 'surah_awal.nomor')
            ->join('surah as surah_akhir', 'sm_penilaian_kegiatan.surah_akhir_penilaian_kegiatan', '=', 'surah_akhir.nomor')
            ->join('peserta_kegiatan', 'sm_penilaian_kegiatan.id_peserta_kegiatan', '=', 'peserta_kegiatan.id_peserta_kegiatan')
            ->join('siswa', 'peserta_kegiatan.id_siswa', '=', 'siswa.id_siswa')
            ->select(
                'sm_penilaian_kegiatan.*',
                'siswa.nama_siswa',
                'siswa.nisn_siswa',
                'surah_awal.namaLatin as namaLatin_awal',
                'surah_akhir.namaLatin as namaLatin_akhir'
            )
           ->whereNull('sm_penilaian_kegiatan.deleted_at')
            ->where('sm_penilaian_kegiatan.id_user', $guru);

        if ($kegiatan === 'tahfidz') {
            $data = $data->where(function($query) {
                $query->where('sm_penilaian_kegiatan.jenis_penilaian_kegiatan', 'tahfidz')
                    ->orWhere('sm_penilaian_kegiatan.jenis_penilaian_kegiatan', 'murajaah');
            });
        } else {
            $data = $data->where(function($query) {
                $query->where('sm_penilaian_kegiatan.jenis_penilaian_kegiatan', 'tahsin')
                    ->orWhere('sm_penilaian_kegiatan.jenis_penilaian_kegiatan', 'materikulasi');
            });
        }

        $data = $data->where('sm_penilaian_kegiatan.id_periode', $periode)
                    ->orderBy('sm_penilaian_kegiatan.created_at', 'DESC')
                    ->get();

        return $data;
    }

    
    
}
