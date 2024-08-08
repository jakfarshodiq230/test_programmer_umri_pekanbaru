<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\MahasiswaModel;
use App\Models\Admin\ProdiModel;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }

    public function index(){
        $menu = 'master';
        $submenu= 'dashboard';
        return view ('Admin/home/dashboard',compact('menu','submenu'));
    }
        
}
