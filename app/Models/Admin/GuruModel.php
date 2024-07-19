<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruModel extends Model
{
    use HasFactory;
    protected $table ="guru";
    protected $fillable = [
        'id_guru', 'nik_guru', 'nama_guru', 'tempat_lahir_guru', 'tanggal_lahir_guru', 'jenis_kelamin_guru', 'no_hp_guru', 'email_guru', 'foto_guru','status_guru', 'password', 'id_user'
    ];
}
