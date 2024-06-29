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
    
    
    
    
    
}
