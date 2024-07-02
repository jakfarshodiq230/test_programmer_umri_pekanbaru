<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SurahModel
 extends Model
{
    use HasFactory;
    protected $table ="surah";
    protected $fillable = [
        'nomor', 'namaLatin', 'jumlahAyat', 'tempatTurun', 'arti'
    ];
}
