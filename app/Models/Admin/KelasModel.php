<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
    use HasFactory;
    protected $table ="kelas";
    protected $fillable = [
        'id_kelas', 'nama_kelas', 'status_kelas', 'id_user','deleted_at'
    ];
}
