<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class GuruModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table ="guru";
    protected $primaryKey = 'id_guru';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = [
        'id_guru', 'nik_guru', 'nama_guru', 'tempat_lahir_guru', 'tanggal_lahir_guru', 'jenis_kelamin_guru', 'no_hp_guru', 'email_guru', 'foto_guru','status_guru', 'password', 'id_user'
    ];
}
