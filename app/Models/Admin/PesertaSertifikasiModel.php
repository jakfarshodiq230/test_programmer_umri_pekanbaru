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

}
