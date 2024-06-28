<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PeriodeModel extends Model
{
    use HasFactory;
    protected $table ="periode";
    protected $fillable = [
        'id_periode', 'id_tahun_ajaran', 'judul_periode','jenis_periode','status_periode', 'id_user','deleted_at'
    ];

    public static function DataAll()
    {
        $data = DB::table('periode')
            ->join('tahun_ajaran', 'periode.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select('periode.*','tahun_ajaran.*',) 
            ->orderBy('periode.created_at', 'DESC')
            ->whereNull('periode.deleted_at')
            ->where('judul_periode', 'setoran')
            ->get();
        
        return $data;
    }
}
