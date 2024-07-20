<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasModel extends Model
{
    use HasFactory;
    protected $table ="kelas";
    protected $primaryKey = 'id_kelas';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'id_kelas', 'nama_kelas', 'status_kelas', 'id_user','deleted_at'
    ];
}
