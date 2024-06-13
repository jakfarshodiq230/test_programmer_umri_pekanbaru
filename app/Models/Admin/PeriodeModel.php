<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    use HasFactory;
    protected $table ="periode";
    protected $primaryKey = "id_periode";
    protected $keyType = 'string';
    protected $fillable = [
        'id_periode', 'judul_periode', 'tanggal_mulai', 'tanggal_akhir', 'status_periode','id_pelanggan','id_user'
    ];
}
