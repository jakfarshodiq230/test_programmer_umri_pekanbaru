<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaranModel extends Model
{
    use HasFactory;
    protected $table ="tahun_ajaran";
    protected $primaryKey = 'id_tahun_ajaran';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'id_tahun_ajaran', 'nama_tahun_ajaran', 'status_tahun_ajaran', 'id_user','deleted_at'
    ];
}
