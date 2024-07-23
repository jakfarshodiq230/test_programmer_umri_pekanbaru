<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PesertaSertifikasiModel extends Model
{
    use HasFactory;
    protected $table ="peserta_sertifikasi";
    protected $primaryKey = 'id_peserta_sertifikasi';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = [
        'id_peserta_sertifikasi',
        'id_tahun_ajaran',
        'id_periode',
        'id_siswa',
        'id_kelas',
        'id_guru',
        'id_penguji',
        'status_peserta_sertifikasi',
        'created_at',
        'updated_at',
        'deleted_at',
        'id_user'
    ];

    public static function DataPesertaSertifikasi($tahun,$jenjang,$periode)  {
        
        $data = DB::table('peserta_sertifikasi')
        ->join('siswa', 'peserta_sertifikasi.id_siswa', '=', 'siswa.id_siswa')
        ->join('kelas', 'peserta_sertifikasi.id_kelas', '=', 'kelas.id_kelas')
        ->join('guru as pembimbing', 'peserta_sertifikasi.id_guru', '=', 'pembimbing.id_guru')
        ->join('periode', 'peserta_sertifikasi.id_periode', '=', 'periode.id_periode')
        ->leftjoin('guru as penguji', 'peserta_sertifikasi.id_penguji', '=', 'penguji.id_guru')
        ->select(
            'siswa.*',
            'kelas.*',
            'periode.*',
            'peserta_sertifikasi.*',
            'pembimbing.nama_guru as pembimbing_nama',
            'penguji.nama_guru as penguji_nama'
        )
        ->whereNull('peserta_sertifikasi.deleted_at')
        ->whereNull('siswa.deleted_at')
        ->where('peserta_sertifikasi.id_tahun_ajaran', $tahun)
        ->where('periode.jenis_periode', $jenjang)
        ->where('peserta_sertifikasi.id_periode', $periode)
        ->get();

        return $data; // Return the result set
    }

    public static function DataDaftarPeserta($tahun, $jenjang, $periode)
    {
        $data = DB::table('peserta_sertifikasi')
            ->join('tahun_ajaran', 'peserta_sertifikasi.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->join('periode', 'peserta_sertifikasi.id_periode', '=', 'periode.id_periode')
            ->join('siswa', 'peserta_sertifikasi.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'peserta_sertifikasi.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'peserta_sertifikasi.id_guru', '=', 'guru.id_guru')
            ->select(
                'periode.*',
                'tahun_ajaran.*',
                'siswa.*',
                'kelas.*',
                'guru.*',
                'peserta_sertifikasi.*'
            )
            ->whereNull('periode.deleted_at')
            ->whereNull('peserta_sertifikasi.deleted_at')
            ->where('tahun_ajaran.id_tahun_ajaran', $tahun)
            ->where('periode.jenis_periode', $jenjang)
            ->whereNull('id_penguji')
            ->orderBy('siswa.nama_siswa', 'DESC')
            ->get();

        return $data; // Return the result set
    }

    public static function DataDaftarPesertaPenilaian($tahun, $jenjang, $periode, $sesi)
    {
        $data = DB::table('peserta_sertifikasi')
            ->join('tahun_ajaran', 'peserta_sertifikasi.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->join('periode', 'peserta_sertifikasi.id_periode', '=', 'periode.id_periode')
            ->join('siswa', 'peserta_sertifikasi.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'peserta_sertifikasi.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'peserta_sertifikasi.id_guru', '=', 'guru.id_guru')
            ->leftJoin('penilaian_sertifikasi', 'peserta_sertifikasi.id_peserta_sertifikasi', '=', 'penilaian_sertifikasi.id_peserta_sertifikasi')
            ->select(
                'periode.*',
                'tahun_ajaran.*',
                'siswa.*',
                'kelas.*',
                'guru.*',
                'peserta_sertifikasi.*',
                DB::raw('COUNT(penilaian_sertifikasi.id_peserta_sertifikasi) as count_penilaian'),
            )
            ->whereNull('periode.deleted_at')
            ->whereNull('peserta_sertifikasi.deleted_at')
            ->where('tahun_ajaran.id_tahun_ajaran', $tahun)
            ->where('periode.jenis_periode', $jenjang)
            ->where('id_penguji', session('user')['id'])
            ->groupBy(
                'peserta_sertifikasi.id_peserta_sertifikasi'
            )
            ->havingRaw('COUNT(penilaian_sertifikasi.id_peserta_sertifikasi) < ?', [$sesi])
            ->orderBy('siswa.nama_siswa', 'DESC')
            ->get();
    
        return $data; // Return the result set
    }

    public static function DataNilaiPeserta($tahun, $jenjang, $periode, $sesi)
    {
        $data = DB::table('peserta_sertifikasi')
            ->join('tahun_ajaran', 'peserta_sertifikasi.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->join('periode', 'peserta_sertifikasi.id_periode', '=', 'periode.id_periode')
            ->join('siswa', 'peserta_sertifikasi.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'peserta_sertifikasi.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'peserta_sertifikasi.id_guru', '=', 'guru.id_guru')
            ->leftJoin('penilaian_sertifikasi', 'peserta_sertifikasi.id_peserta_sertifikasi', '=', 'penilaian_sertifikasi.id_peserta_sertifikasi')
            ->select(
                'periode.*',
                'tahun_ajaran.*',
                'siswa.*',
                'kelas.*',
                'guru.*',
                'peserta_sertifikasi.*',
                DB::raw('COUNT(penilaian_sertifikasi.id_peserta_sertifikasi) as count_penilaian'),
                DB::raw('SUM(penilaian_sertifikasi.nilai_sertifikasi) / ' . (int)$sesi . ' as avg_penilaian')
            )
            ->whereNull('periode.deleted_at')
            ->whereNull('peserta_sertifikasi.deleted_at')
            ->where('tahun_ajaran.id_tahun_ajaran', $tahun)
            ->where('periode.jenis_periode', $jenjang)
            ->where('id_penguji', session('user')['id'])
            ->groupBy(
                'peserta_sertifikasi.id_peserta_sertifikasi'
            )
            ->orderBy('siswa.nama_siswa', 'DESC')
            ->get();
    
        return $data; // Return the result set
    }

    public static function DataDetailPesertaSertifikasi($id)
    {
        $data = DB::table('peserta_sertifikasi')
            ->join('tahun_ajaran', 'peserta_sertifikasi.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->join('periode', 'peserta_sertifikasi.id_periode', '=', 'periode.id_periode')
            ->join('siswa', 'peserta_sertifikasi.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'peserta_sertifikasi.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'peserta_sertifikasi.id_guru', '=', 'guru.id_guru')
            ->select(
                'periode.*',
                'tahun_ajaran.*',
                'siswa.*',
                'kelas.*',
                'guru.*',
                'peserta_sertifikasi.*',
            )
            ->whereNull('periode.deleted_at')
            ->whereNull('peserta_sertifikasi.deleted_at')
            ->where('peserta_sertifikasi.id_peserta_sertifikasi', $id)
            ->where('id_penguji', session('user')['id'])
            ->first();
    
        return $data; // Return the result set
    }


    

}