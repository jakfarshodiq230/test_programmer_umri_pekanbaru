<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    use HasFactory;
    protected $table ="siswa";
    protected $fillable = [
        'id_siswa', 'nisn_siswa', 'nama_siswa', 'tanggal_lahir_siswa', 'tempat_lahir_siswa', 'jenis_kelamin_siswa', 'no_hp_siswa', 'email_siswa', 'tahun_masuk_siswa', 'foto_siswa','status_siswa','id_user','deleted_at'
    ];

}
