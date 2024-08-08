<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class MahasiswaModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table ="mtr_mahasiswa";
    protected $primaryKey = 'nim_mhs';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = [
        'nim_mhs', 'nama_mhs', 'id_program_studi', 'password', 'tanggal_lahir','deleted_at'
    ];

    public static function GetMahasiswaAll()
    {
        $data = DB::table('mtr_mahasiswa')
            ->leftJoin('mtr_prodi', 'mtr_mahasiswa.id_program_studi', '=', 'mtr_prodi.id')
            ->select(
                'mtr_mahasiswa.*',
                'mtr_prodi.*',
            )
            ->whereNull('mtr_prodi.deleted_at')
            ->whereNull('mtr_mahasiswa.deleted_at')
            ->orderBy('mtr_mahasiswa.nim_mhs', 'DESC')
            ->get();
    
        return $data; // Return the result set
    }

    public static function GetMahasiswaID($id)
    {
        $data = DB::table('mtr_mahasiswa')
            ->leftJoin('mtr_prodi', 'mtr_mahasiswa.id_program_studi', '=', 'mtr_prodi.id')
            ->select(
                'mtr_mahasiswa.*',
                'mtr_prodi.*',
            )
            ->whereNull('mtr_prodi.deleted_at')
            ->whereNull('mtr_mahasiswa.deleted_at')
            ->where('mtr_mahasiswa.nim_mhs', $id)
            ->first();
    
        return $data; // Return the result set
    }
     
}
