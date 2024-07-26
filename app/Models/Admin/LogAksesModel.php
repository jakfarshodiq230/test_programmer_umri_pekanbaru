<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LogAksesModel extends Model
{
    use HasFactory;
    protected $table ="log_login";
    protected $fillable = [
        'id',
        'ip_address',
        'browser',
        'platform',
        'device',
        'negara',
        'id_user',
        'created_at',
        'updated_at'
    ];

    public static function Persentase()
    {
        $data = DB::table('log_login')
            ->select(
                DB::raw('YEAR(log_login.created_at) as tahun'),
                DB::raw('MONTH(log_login.created_at) as bulan'),
                DB::raw('COUNT(DISTINCT log_login.id) as jumlah_log')
            )
            ->groupBy(
                DB::raw('YEAR(log_login.created_at)'),
                DB::raw('MONTH(log_login.created_at)'),
            )
            ->get();
            
        return $data;
    }
}
