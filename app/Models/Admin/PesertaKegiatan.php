<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PesertaKegiatan extends Model
{
    use HasFactory;
    protected $table ="peserta_kegiatan";
    protected $fillable = [
        'id_peserta_kegiatan', 'id_tahun_ajaran', 'id_periode', 'id_siswa', 'id_kelas', 'id_guru', 'status_peserta_kegiatan', 'deleted_at', 'id_user'
    ];

    public static function DataAll()
    {
        $data = DB::table('periode')
            ->join('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->leftJoin('peserta_kegiatan', 'periode.id_periode', '=', 'peserta_kegiatan.id_periode')
            ->select(
                'periode.id_periode',
                'periode.judul_periode',
                'periode.jenis_periode',
                'periode.status_periode',
                'tahun_ajaran.id_tahun_ajaran',
                'tahun_ajaran.nama_tahun_ajaran',
                'tahun_ajaran.status_tahun_ajaran',
                DB::raw('count(peserta_kegiatan.id_periode) as total_peserta_kegiatan')
            )
            ->whereNull('periode.deleted_at')
            ->whereNull('peserta_kegiatan.deleted_at')
            ->where('periode.judul_periode', 'setoran')
            ->groupBy(
                'periode.id_periode',
                'periode.judul_periode',
                'tahun_ajaran.id_tahun_ajaran',
                'tahun_ajaran.nama_tahun_ajaran',
                'tahun_ajaran.status_tahun_ajaran'
            )
            ->orderBy('periode.created_at', 'DESC')
            ->get();
    
        return $data; // Return the result set
    }

    public static function DataPesertaKegiatanAll($id_periode,$id_tahun_ajaran)
    {
        $data = DB::table('peserta_kegiatan')
            ->join('tahun_ajaran', 'peserta_kegiatan.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->join('periode', 'peserta_kegiatan.id_periode', '=', 'periode.id_periode')
            ->join('siswa', 'peserta_kegiatan.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'peserta_kegiatan.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'peserta_kegiatan.id_guru', '=', 'guru.id_guru')
            ->select(
                'periode.*',
                'tahun_ajaran.*',
                'siswa.*',
                'kelas.*',
                'guru.*',
                'peserta_kegiatan.*'
            )
            ->whereNull('peserta_kegiatan.deleted_at')
            ->where('periode.judul_periode', 'setoran')
            ->where('periode.id_periode', $id_periode)
            ->where('tahun_ajaran.id_tahun_ajaran', $id_tahun_ajaran)
            ->orderBy('peserta_kegiatan.created_at', 'DESC')
            ->get();
    
        return $data; // Return the result set
    }

    public static function DataSiswaProfil($tahun,$periode,$siswa,$guru,$kelas)
    {
        $data = DB::table('peserta_kegiatan')
            ->join('siswa', 'peserta_kegiatan.id_siswa', '=', 'siswa.id_siswa')
            ->join('guru', 'peserta_kegiatan.id_guru', '=', 'guru.id_guru')
            ->join('periode', 'peserta_kegiatan.id_periode', '=', 'periode.id_periode')
            ->join('kelas', 'peserta_kegiatan.id_kelas', '=', 'kelas.id_kelas')
            ->join('tahun_ajaran', 'peserta_kegiatan.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select(
                'siswa.id_siswa',
                'siswa.nama_siswa',
                'siswa.foto_siswa',
                'periode.jenis_periode',
                'guru.nama_guru',
                'kelas.nama_kelas',
                'tahun_ajaran.nama_tahun_ajaran'
            )
            ->whereNull('peserta_kegiatan.deleted_at')
            ->where('tahun_ajaran.id_tahun_ajaran', $tahun)
            ->where('periode.id_periode', $periode)
            ->where('siswa.id_siswa', $siswa)
            ->where('guru.id_guru', $guru)
            ->where('kelas.id_kelas', $kelas)
            ->first();
    
        return $data; // Return the result set
    }

    public static function DataSiswaGuru($tahun,$periode,$guru)  {
        $data = DB::table('peserta_kegiatan')
        ->join('siswa', 'peserta_kegiatan.id_siswa', '=', 'siswa.id_siswa')
        ->join('kelas', 'peserta_kegiatan.id_kelas', '=', 'kelas.id_kelas')
        ->select(
            'siswa.id_siswa',
            'siswa.nama_siswa',
            'siswa.nisn_siswa',
            'kelas.id_kelas',
            'kelas.nama_kelas',
            'peserta_kegiatan.id_peserta_kegiatan',
        )
        ->whereNull('peserta_kegiatan.deleted_at')
        ->whereNull('siswa.deleted_at')
        ->where('peserta_kegiatan.id_tahun_ajaran', $tahun)
        ->where('peserta_kegiatan.id_periode', $periode)
        ->where('peserta_kegiatan.id_guru', $guru)
        ->get();

    return $data; // Return the result set
    }

    public static function DataPesertaKegiatanGuru($id_periode,$id_tahun_ajaran,$guru)
    {
        $data = DB::table('peserta_kegiatan')
            ->join('tahun_ajaran', 'peserta_kegiatan.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->join('periode', 'peserta_kegiatan.id_periode', '=', 'periode.id_periode')
            ->join('siswa', 'peserta_kegiatan.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'peserta_kegiatan.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'peserta_kegiatan.id_guru', '=', 'guru.id_guru')
            ->select(
                'periode.*',
                'tahun_ajaran.*',
                'siswa.*',
                'kelas.*',
                'guru.*',
                'peserta_kegiatan.*'
            )
            ->whereNull('peserta_kegiatan.deleted_at')
            ->where('periode.judul_periode', 'setoran')
            ->where('periode.id_periode', $id_periode)
            ->where('tahun_ajaran.id_tahun_ajaran', $id_tahun_ajaran)
            ->where('peserta_kegiatan.id_guru', $guru)
            ->orderBy('peserta_kegiatan.created_at', 'DESC')
            ->get();
    
        return $data; // Return the result set
    }

    public static function DataAllGuru($guru)
    {
        $data = DB::table('periode')
            ->join('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->leftJoin('peserta_kegiatan', 'periode.id_periode', '=', 'peserta_kegiatan.id_periode')
            ->select(
                'periode.id_periode',
                'periode.judul_periode',
                'periode.jenis_periode',
                'periode.status_periode',
                'tahun_ajaran.id_tahun_ajaran',
                'tahun_ajaran.nama_tahun_ajaran',
                'tahun_ajaran.status_tahun_ajaran',
                DB::raw('count(peserta_kegiatan.id_periode) as total_peserta_kegiatan')
            )
            ->whereNull('periode.deleted_at')
            ->whereNull('peserta_kegiatan.deleted_at')
            ->where('periode.judul_periode', 'setoran')
            ->where('peserta_kegiatan.id_guru', $guru)
            ->groupBy(
                'periode.id_periode',
                'periode.judul_periode',
                'tahun_ajaran.id_tahun_ajaran',
                'tahun_ajaran.nama_tahun_ajaran',
                'tahun_ajaran.status_tahun_ajaran'
            )
            ->orderBy('periode.created_at', 'DESC')
            ->get();
    
        return $data; // Return the result set
    }
    
    
    
    
    
}
