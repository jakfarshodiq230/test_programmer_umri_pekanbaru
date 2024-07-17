<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopModel extends Model
{
    use HasFactory;
    protected $table ="kop";
    protected $fillable = [
        'id', 'image_kop'
    ];
}
