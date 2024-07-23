<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use GeoIp2\Database\Reader;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use App\Models\Admin\LogAksesModel;
use App\Models\Admin\User;
use App\Models\Admin\Admin\GuruModel;
use App\Models\Admin\Admin\SiswaModel;

class LoginController extends Controller
{

    // index login
    public function index(){
    	return view ('login');
    }

    public function authenticate(Request $request)
    {
        $credentials_user = ['email' => $request->input('username'), 'password' => $request->input('password')];
        $credentials_guru = ['nik_guru' => $request->input('username'), 'password' => $request->input('password')];
        $credentials_siswa = ['nisn_siswa' => $request->input('username'), 'password' => $request->input('password')];
        $agent = new Agent();
        $agent->setUserAgent($request->header('User-Agent'));
    
            // Attempt authentication for users guard
            if (Auth::guard('users')->attempt($credentials_user)) {
                $user = Auth::guard('users')->user();
                if ($user->email_verified_at !== null) {
                    $request->session()->regenerate();
                    $this->storeAccessInfo($request);
                    $request->session()->put('user', [
                        'id' => $user->id,
                        'nama_user' => $user->nama_user,
                        'level_user' => 'admin',
                        'user_level' => $user->level_user,
                    ]);
                    return response()->json([
                        'success' => true,
                        'redirect' => '/admin/dashboard'
                    ]);
                }else{
                    return response()->json([
                        'error' => true,
                        'massage' => 'Akun Belum Verifikasi',
                        'redirect' => '/'
                    ]);
                }
            }
        
            // Attempt authentication for guru guard
            if (Auth::guard('guru')->attempt($credentials_guru)) {
                $user = Auth::guard('guru')->user();
                if ($user->status_guru === 1) {
                    $request->session()->regenerate();
                    $this->storeAccessInfo($request);
                    $request->session()->put('user', [
                        'id' => $user->id_guru,
                        'nama_user' => $user->nama_guru,
                        'level_user' => 'guru',
                    ]);
                    return response()->json([
                        'success' => true,
                        'redirect' => '/guru/dashboard'
                    ]);
                }else{
                    return response()->json([
                        'error' => true,
                        'massage' => 'Akun Belum Verifikasi',
                        'redirect' => '/'
                    ]);
                }
            }
    
            // Attempt authentication for siswa guard
            if (Auth::guard('siswa')->attempt($credentials_siswa)) {
                $user = Auth::guard('siswa')->user();
                if ($user->status_guru !== 0) {
                    $request->session()->regenerate();
                    $this->storeAccessInfo($request);
                    $request->session()->put('user', [
                        'id' => $user->id_guru,
                        'nama_user' => $user->nama_siswa,
                        'level_user' => 'siswa',
                    ]);
                return response()->json([
                    'success' => true,
                    'redirect' => '/siswa/dashboard'
                ]);
            }else{
                return response()->json([
                    'error' => true,
                    'massage' => 'Akun Belum Verifikasi',
                    'redirect' => '/'
                ]);
            }
        }
    
        // If none of the attempts succeed, return JSON with redirect to '/'
        return response()->json(['massage' => 'Username dan Password Salah','redirect' => '/']);
    }
    
    protected function storeAccessInfo(Request $request)
    {
        $agent = new Agent();
        $agent->setUserAgent($request->header('User-Agent'));
    
        $userBrowser = $agent->browser();
        $browserVersion = $agent->version($userBrowser); 
    
        $userPlatform = $agent->platform();
        $platformVersion = $agent->version($userPlatform);
    
        $userIP = $request->ip();
        $deviceName = $agent->device();
    
        // Use GeoIP service to get country information
        $databasePath = storage_path('app/Geoip2/GeoLite2-Country.mmdb');
        $reader = new Reader($databasePath);
        
        if ($userIP != '127.0.0.1') {
            $record = $reader->country($userIP);
            $country = $record->country->name;
        } else {
            $country = 'Local Server - 127.0.0.1';
        }
    
        $data = [
            'ip_address' => $userIP,
            'browser' => $userBrowser.' V.'.$browserVersion,
            'platform' => $userPlatform.' V.'.$platformVersion,
            'device' => $deviceName,
            'negara' => $country,
            'waktu' => now(),
            'id_user' => 'session user'
        ];
    
        LogAksesModel::create($data);
    }

    public function logout($guard, Request $request)
    {
        if (Auth::guard($guard)->check()) {
            Auth::guard($guard)->logout();
            $request->session()->invalidate(); // Clear session data
            $request->session()->regenerateToken(); // Regenerate CSRF token
            return response()->json(['redirect' => '/']);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
