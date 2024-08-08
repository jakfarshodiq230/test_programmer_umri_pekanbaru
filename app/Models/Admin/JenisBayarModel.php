<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBayarModel extends Model
{
    use HasFactory;
    protected $table ="jenis_bayar";
    protected $fillable = [
        'id', 'nama_pembayaran'
    ];
}
