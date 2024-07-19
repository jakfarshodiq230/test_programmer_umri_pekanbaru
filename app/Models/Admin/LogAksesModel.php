<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
