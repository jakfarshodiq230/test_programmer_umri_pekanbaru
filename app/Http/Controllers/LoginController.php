<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use App\Models\Admin\User;

class LoginController extends Controller
{

    // index login
    public function index(){
    	return view ('login');
    }

    public function authenticate(Request $request)
    {
        $credentials_mahasiswa = ['nim_mhs' => $request->input('username'), 'password' => $request->input('password')];    
            // Attempt authentication for siswa guard
            if (Auth::guard('mahasiswa')->attempt($credentials_mahasiswa)) {
                $user = Auth::guard('mahasiswa')->user();
                    $request->session()->regenerate();
                    $request->session()->put('user', [
                        'id' => $user->id_guru,
                        'nama_user' => $user->nama_siswa,
                        'level_user' => 'mahasiswa',
                    ]);
                return response()->json([
                    'success' => true,
                    'redirect' => '/admin/dashboard'
                ]);
        }
    
        // If none of the attempts succeed, return JSON with redirect to '/'
        return response()->json(['massage' => 'Username dan Password Salah','redirect' => '/']);
    }
    

    public function logout(Request $request)
    {
        if (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
            $request->session()->invalidate(); // Clear session data
            $request->session()->regenerateToken(); // Regenerate CSRF token
            return response()->json(['redirect' => '/']);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
