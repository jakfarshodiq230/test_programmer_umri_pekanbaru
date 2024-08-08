<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiModel extends Model
{
    use HasFactory;
    protected $table ="mtr_prodi";
    // protected $primaryKey = 'id';
    // public $incrementing = false; 
    // protected $keyType = 'string';
    protected $fillable = [
        'nama_prodi'
    ];


}
