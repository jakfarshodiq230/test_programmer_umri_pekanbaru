<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayarModel extends Model
{
    use HasFactory;
    protected $table ="bayar";
    protected $primaryKey = 'id';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'tanggal', 'id_jenis_bayar', 'id_mahasiswa', 'jumlah'
    ];

}
