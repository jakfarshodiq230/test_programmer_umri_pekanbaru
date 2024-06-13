<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AksesModel extends Model
{
    use HasFactory;
    protected $table ="akses_pengguna";
    protected $fillable = [
       'ip_address', 'browser', 'platform', 'device', 'negara', 'waktu', 'id_pelanggan', 'id_user'
    ];

    public static function DataPelangganAkses()
    {
        $data = DB::table('akses_pengguna')
            ->join('pelanggan', 'akses_pengguna.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->join('users', 'akses_pengguna.id_user', '=', 'users.id')
            ->select('akses_pengguna.*','pelanggan.*','users.nama_user') 
            ->orderBy('akses_pengguna.created_at', 'DESC')
            ->get();
        
        return $data;
    }
}
