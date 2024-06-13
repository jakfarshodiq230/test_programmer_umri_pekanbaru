<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganModel extends Model
{
    use HasFactory;
    protected $table ="pelanggan";
    protected $primaryKey = "id_pelanggan";
    protected $keyType = 'string';
    protected $fillable = [
       'id_pelanggan', 'nama_pelanggan', 'email_pelanggan', 'nama_usaha', 'alamat_usaha', 'no_hp_usaha', 'status_pelanggan','tggl_daftar_pelanggan', 'tggl_batas_pelanggan'
    ];
}
