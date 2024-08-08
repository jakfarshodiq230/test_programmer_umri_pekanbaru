<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PenilaianSertifikasiModel extends Model
{
    use HasFactory;
    protected $table ="penilaian_sertifikasi";
    protected $primaryKey = 'id_penilaian_sertifikasi';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'id_penilaian_sertifikasi',
        'id_peserta_sertifikasi',
        'surah_mulai',
        'surah_akhir',
        'ayat_awal',
        'ayat_akhir',
        'koreksi_sertifikasi',
        'nilai_sertifikasi',
        'created_at',
        'updated_at',
        'deleted_at',
        'id_user'
    ];

    public static function DataDetailNilaiPesertaSertifikasi($id)
    {
        $query = DB::table('penilaian_sertifikasi')
            ->leftjoin('surah as surahMulai', 'penilaian_sertifikasi.surah_mulai', '=', 'surahMulai.nomor')
            ->leftjoin('surah as surahAkhir', 'penilaian_sertifikasi.surah_akhir', '=', 'surahAkhir.nomor')
            ->select(
                'surahMulai.namaLatin as SurahMulai',
                'surahAkhir.namaLatin as SurahAkhir',
                'penilaian_sertifikasi.*',
            )
            ->whereNull('penilaian_sertifikasi.deleted_at')
            ->where('penilaian_sertifikasi.id_peserta_sertifikasi', $id);
            if(session('user')['level_user'] === 'admin') {
                $data= $query->get();
            } else {
                $data= $query->where('penilaian_sertifikasi.id_user', session('user')['id'])
                ->get();
            }
        return $data; // Return the result set
    }

    public static function DataRenkNilaiPesertaSertifikasi($id)
    {
        // Build the initial query
        $query = DB::table('penilaian_sertifikasi')
            ->select(DB::raw('SUM(nilai_sertifikasi) as total_nilai, COUNT(*) as count'))
            ->whereNull('deleted_at')
            ->where('id_peserta_sertifikasi', $id);
        
        // Modify the query based on user level
        if (session('user')['level_user'] === 'admin') {
            $data = $query->first(); // Get a single result with SUM and COUNT
        } else {
            $data = $query->where('id_user', session('user')['id'])->first(); // Get a single result with SUM and COUNT with filter
        }
    
        // Calculate average
        $rata = ($data->total_nilai ?? 0) / ($data->count ?? 1); // Avoid division by zero
    
        // Determine grade based on average
        if ($rata >= 94 && $rata <= 100) {
            $ktr = "A";
        } elseif ($rata >= 87 && $rata < 94) {
            $ktr = "B";
        } elseif ($rata >= 80 && $rata < 87) {
            $ktr = "C";
        } else {
            $ktr = "D";
        }
    
        // Return both the total score and the grade
        return [
            'total_nilai' => $data->total_nilai ?? 0,
            'rata' => $rata,
            'grade' => $ktr
        ];
    }
    
    public static function EditNilaiPesertaSertifikasi($id)
    {
        $data = DB::table('penilaian_sertifikasi')
            ->leftjoin('peserta_sertifikasi', 'penilaian_sertifikasi.id_peserta_sertifikasi', '=', 'peserta_sertifikasi.id_peserta_sertifikasi')
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
                'penilaian_sertifikasi.*'
            )
            ->whereNull('penilaian_sertifikasi.deleted_at')
            ->where('penilaian_sertifikasi.id_penilaian_sertifikasi', $id)
            ->where('penilaian_sertifikasi.id_user', session('user')['id'])
            ->first();
    
        return $data; // Return the result set
    }

    public static function DataSertifDashbord($peserta, $tahun)
    {
        // Start the query
        $query = DB::table('penilaian_sertifikasi')
            ->leftJoin('peserta_sertifikasi', 'penilaian_sertifikasi.id_peserta_sertifikasi', '=', 'peserta_sertifikasi.id_peserta_sertifikasi')
            ->leftJoin('periode', 'peserta_sertifikasi.id_periode', '=', 'periode.id_periode')
            ->leftJoin('surah as surahMulai', 'penilaian_sertifikasi.surah_mulai', '=', 'surahMulai.nomor')
            ->leftJoin('surah as surahAkhir', 'penilaian_sertifikasi.surah_akhir', '=', 'surahAkhir.nomor')
            ->select(
                'surahMulai.namaLatin as SurahMulai',
                'surahAkhir.namaLatin as SurahAkhir',
                'periode.juz_periode',
                'periode.judul_periode',
                'periode.jenis_periode',
                DB::raw('SUM(penilaian_sertifikasi.nilai_sertifikasi) / COUNT(penilaian_sertifikasi.id_peserta_sertifikasi) as total_nilai_sertifikasi')
            )
            ->whereNull('peserta_sertifikasi.deleted_at')
            ->where([
                ['peserta_sertifikasi.id_siswa', $peserta],
                ['peserta_sertifikasi.id_tahun_ajaran', $tahun]
            ]);
    
        // Add the additional condition if the user level is 'guru'
        if (session('user')['level_user'] === 'guru') {
            $query->where('peserta_sertifikasi.id_guru', session('user')['id']);
        }
    
        // Group by statement
        $query->groupBy('penilaian_sertifikasi.id_peserta_sertifikasi');
    
        // Execute the query and return the results
        return $query->get();
    }


    
    
    
    
}
