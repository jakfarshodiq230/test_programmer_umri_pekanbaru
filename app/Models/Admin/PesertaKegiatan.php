<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PesertaKegiatan extends Model
{
    use HasFactory;
    protected $table ="peserta_kegiatan";
    protected $primaryKey = 'id_peserta_kegiatan';
    public $incrementing = false; 
    protected $keyType = 'string';
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


    // rapor
    public static function DataPesertaRapor($id_tahun_ajaran, $jenisRapor, $tglMulai, $tglAkhir)
    {
        if ($jenisRapor == 'tahfidz') {
            $keterangan_1 = 'tahfidz';
            $keterangan_2 = 'murajaah';
        } else {
            $keterangan_1 = 'tahsin';
            $keterangan_2 = 'materikulasi';
        }
    
        $queryBase = DB::table('peserta_kegiatan')
            ->join('tahun_ajaran', 'peserta_kegiatan.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->join('periode', 'peserta_kegiatan.id_periode', '=', 'periode.id_periode')
            ->join('penilaian_kegiatan', 'peserta_kegiatan.id_peserta_kegiatan', '=', 'penilaian_kegiatan.id_peserta_kegiatan')
            ->select(
                'periode.*',
                'tahun_ajaran.*',
                'peserta_kegiatan.*'
            )
            ->whereNull('peserta_kegiatan.deleted_at')
            ->where('periode.judul_periode', 'setoran')
            ->where('periode.jenis_periode', $jenisRapor)
            ->where('tahun_ajaran.id_tahun_ajaran', $id_tahun_ajaran)
            ->whereBetween('penilaian_kegiatan.tanggal_penilaian_kegiatan', [$tglMulai, $tglAkhir]);
    
        $queryKeterangan = clone $queryBase;
        $queryKeterangan->addSelect(
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_1 . '\' 
                THEN penilaian_kegiatan.nilai_tajwid_penilaian_kegiatan 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_tajwid_penilaian_kegiatan), 0) as nilai_tajwid_barau'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_1 . '\' 
                THEN penilaian_kegiatan.nilai_fasohah_penilaian_kegiatan 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_fasohah_penilaian_kegiatan), 0) as nilai_fasohah_baru'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_1 . '\' 
                THEN penilaian_kegiatan.nilai_kelancaran_penilaian_kegiatan 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_kelancaran_penilaian_kegiatan), 0) as nilai_kelancaran_baru'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_1 . '\' 
                THEN penilaian_kegiatan.nilai_ghunnah_penilaian_kegiatan 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_ghunnah_penilaian_kegiatan), 0) as nilai_ghunnah_baru'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_1 . '\' 
                THEN penilaian_kegiatan.nilai_mad_penilaian_tahsin 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_mad_penilaian_tahsin), 0) as nilai_mad_baru'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_1 . '\' 
                THEN penilaian_kegiatan.nilai_waqof_penilaian_tahsin 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_waqof_penilaian_tahsin), 0) as nilai_waqof_baru'),

            // keterangan 2
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_2 . '\' 
                THEN penilaian_kegiatan.nilai_tajwid_penilaian_kegiatan 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_tajwid_penilaian_kegiatan), 0) as nilai_tajwid_lama'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_2 . '\' 
                THEN penilaian_kegiatan.nilai_fasohah_penilaian_kegiatan 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_fasohah_penilaian_kegiatan), 0) as nilai_fasohah_lama'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_2 . '\' 
                THEN penilaian_kegiatan.nilai_kelancaran_penilaian_kegiatan 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_kelancaran_penilaian_kegiatan), 0) as nilai_kelancaran_lama'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_2 . '\' 
                THEN penilaian_kegiatan.nilai_ghunnah_penilaian_kegiatan 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_ghunnah_penilaian_kegiatan), 0) as nilai_ghunnah_lama'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_2 . '\' 
                THEN penilaian_kegiatan.nilai_mad_penilaian_tahsin 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_mad_penilaian_tahsin), 0) as nilai_mad_lama'),
            DB::raw('SUM(CASE 
                WHEN penilaian_kegiatan.jenis_penilaian_kegiatan = \'' . $keterangan_2 . '\' 
                THEN penilaian_kegiatan.nilai_waqof_penilaian_tahsin 
                ELSE 0 
            END) / NULLIF(COUNT(penilaian_kegiatan.nilai_waqof_penilaian_tahsin), 0) as nilai_waqof_lama'),

            // surah
            DB::raw('(
                SELECT GROUP_CONCAT(DISTINCT namaLatin)
                FROM (
                    SELECT DISTINCT s.namaLatin
                    FROM penilaian_kegiatan pk
                    JOIN surah s ON s.nomor = pk.surah_awal_penilaian_kegiatan
                    WHERE pk.id_peserta_kegiatan = peserta_kegiatan.id_peserta_kegiatan 
                    AND pk.jenis_penilaian_kegiatan = \'' . $keterangan_1 . '\'
                    
                    UNION
                    
                    SELECT DISTINCT s.namaLatin
                    FROM penilaian_kegiatan pk
                    JOIN surah s ON s.nomor = pk.surah_awal_penilaian_kegiatan
                    WHERE pk.id_peserta_kegiatan = peserta_kegiatan.id_peserta_kegiatan 
                    AND pk.jenis_penilaian_kegiatan = \'' . $keterangan_1 . '\'
                ) AS unique_surahs
            ) AS surah_baru'),            
            
            // surah lama
            DB::raw('(
                SELECT GROUP_CONCAT(DISTINCT namaLatin)
                FROM (
                    SELECT DISTINCT s.namaLatin
                    FROM penilaian_kegiatan pk
                    JOIN surah s ON s.nomor = pk.surah_akhir_penilaian_kegiatan
                    WHERE pk.id_peserta_kegiatan = peserta_kegiatan.id_peserta_kegiatan 
                    AND pk.jenis_penilaian_kegiatan = \'' . $keterangan_2 . '\'
                    
                    UNION
                    
                    SELECT DISTINCT s.namaLatin
                    FROM penilaian_kegiatan pk
                    JOIN surah s ON s.nomor = pk.surah_akhir_penilaian_kegiatan
                    WHERE pk.id_peserta_kegiatan = peserta_kegiatan.id_peserta_kegiatan 
                    AND pk.jenis_penilaian_kegiatan = \'' . $keterangan_2 . '\'
                ) AS unique_surahs
            ) AS surah_lama')          

            )
        ->groupBy('peserta_kegiatan.id_peserta_kegiatan', 'periode.id_periode', 'tahun_ajaran.id_tahun_ajaran');
    
        $dataKeterangan = $queryKeterangan->get();
    
        return  $dataKeterangan;
    }
    
    
    
    
    
    
    
    
    
    
}
