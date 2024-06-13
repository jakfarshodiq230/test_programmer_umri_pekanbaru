<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaModel extends Model
{
    use HasFactory;
    protected $table ="harga";
    protected $primaryKey = "id_harga";
    protected $keyType = 'string';
    protected $fillable = [
       'id_harga','judul_harga','harga','id_pelanggan','id_user','deleted_at'
    ];
}
