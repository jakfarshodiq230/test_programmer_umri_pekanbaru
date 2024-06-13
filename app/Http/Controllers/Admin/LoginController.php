<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Jenssegers\Agent\Agent;
use GeoIp2\Database\Reader;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLupaPassword;
use App\Mail\SendEmailUpdatePass;
use App\Mail\SendEmail;
use App\Mail\SendEmailPendaftaran;
use App\Models\Admin\PelangganModel;
use App\Models\User;
use App\Models\Admin\AksesModel;

class LoginController extends Controller
{

    // index login
    public function index(){
    	return view ('Admin/login');
    }
    public function login(){
    	return view ('Admin/login');
    }

    public function daftar(){
    	return view ('Admin/daftar_pelanggan');
    }

    public function lupa_password(){
    	return view ('Admin/lupa_password');
    }

    public function CekAkun($id)
    {
        $CekAkun = User::where('email',$id)->first();
        if ($CekAkun == true) {
            $data_pesan = [
                'title' => 'DATA AKUN APKIS',
                'id_pelanggan' => $CekAkun->id_pelanggan,
                'nama_pelanggan' => $CekAkun->nama_user,
                'email_pelanggan' => $CekAkun->email,
                'no_hp_usaha' => $CekAkun->no_hp_user,
                'link' => 'lupa_password/input_data/'.$CekAkun->id.'/'.$CekAkun->id_pelanggan
            ];
            Mail::to($CekAkun->email)->send(new SendLupaPassword($data_pesan));
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $CekAkun]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function lupa_passwordInput($id,$id_pelanggan){
    	return view ('Admin/lupa_password_form', compact('id','id_pelanggan'));
    }

    public function update_password(Request $request)
    {
        $CekAkun = User::where('id',$request->id)->where('id_pelanggan',$request->id_pelanggan)->first();
        if ($CekAkun == true) {
            $data_pesan = [
                'title' => 'DATA AKUN APKIS',
                'id_pelanggan' => $CekAkun->id_pelanggan,
                'nama_pelanggan' => $CekAkun->nama_user,
                'email_pelanggan' => $CekAkun->email,
                'no_hp_usaha' => $CekAkun->no_hp_user,
                'password' => $request->password
            ];
            Mail::to($CekAkun->email)->send(new SendEmailUpdatePass($data_pesan));
            $data = [
                'password' =>$request->password
            ];
            User::where('id',$request->id)->where('id_pelanggan',$request->id_pelanggan)->update($data);
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $CekAkun]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'status_user' => 1])) {
            $CekPelanggan = PelangganModel::where('id_pelanggan',Auth::User()->id_pelanggan)->where('status_pelanggan',1)->first();

            if ($CekPelanggan != null) {
                $request->session()->regenerate();
                Auth::login(Auth::User(), TRUE);

                $dataSession = [
                    'nama_usaha' => $CekPelanggan->nama_usaha,
                    'id_pelanggan' =>$CekPelanggan->id_pelanggan
                ];
                Session($dataSession);
                $agent = new Agent();
                $agent->setUserAgent($request->header('User-Agent'));

                $userBrowser = $agent->browser();
                $browserVersion = $agent->version($userBrowser); 

                $userPlatform = $agent->platform();
                $platformVersion = $agent->version($userPlatform);

                $userIP = $request->ip();
                $deviceName = $agent->device();


                // Gunakan layanan GeoIP untuk mendapatkan informasi negara
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
                    'id_pelanggan' =>Auth::User()->id_pelanggan,
                    'id_user' =>Auth::User()->id
                ];
                AksesModel::create($data);


                if(Auth::User()->level_user === 'kasir'){
                    Alert::success('Success!', 'Selamat Datang');
                    return redirect()->intended('kasir/pembelian');
                }else if(Auth::User()->level_user === 'admin'){
                    Alert::success('Success!', 'Selamat Datang');
                    return redirect()->intended('home');
                }else{
                    Alert::success('Success!', 'Selamat Datang');
                    return redirect()->intended('home/log_akses');
                }

            } else {
                Alert::error('Error!', 'Akun belum aktifasi');
                Auth::logout(); 
                return redirect()->intended('/');
            }
        }
 
        Alert::error('Gagal!', 'Email atau password salah');
        return redirect()->intended('/');
    }

    public function actionlogout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function daftarAkun(Request $request)
    {
        $tanggal = now()->format('dmy');
        $nomorUrut = PelangganModel::whereDate('created_at', now()->toDateString())->count() + 1;
        $id = 'PLG-'.$tanggal.'-'.$nomorUrut;
        // $tanggal_batas = '';
        // if($request->paket == 30){
        //     $tanggal_batas = Carbon::now()->addDays(30);
        // }elseif ($request->paket == 186) {
        //     $tanggal_batas = Carbon::now()->addDays(186);
        // }else{
        //     $tanggal_batas = Carbon::now()->addDays(372);
        // }
        $cekEmail = PelangganModel::where('email_pelanggan',$request->email)->first();
        if ($cekEmail == false) {
            $data = [
                'id_pelanggan' => $id,
                'nama_pelanggan' => $request->nama,
                'email_pelanggan' => $request->email,
                'nama_usaha' => $request->nama_usaha,
                'alamat_usaha' => $request->alamat,
                'no_hp_usaha' => $request->no_hp,
                'status_pelanggan' => 0,
                'tggl_daftar_pelanggan' => Carbon::now(),
                'tggl_batas_pelanggan' => Carbon::now()->addDays(30)
            ];
            $data_pesan = [
                'title' => 'PENDAFTARAN AKUN APKIS',
                'id_pelanggan' => $id,
                'nama_pelanggan' => $request->nama,
                'email_pelanggan' => $request->email,
                'nama_usaha' => $request->nama_usaha,
                'alamat_usaha' => $request->alamat,
                'no_hp_usaha' => $request->no_hp,
                'tanggal_daftar' => Carbon::now()
            ];
            Mail::to($request->email)->send(new SendEmail($data_pesan));
            Mail::to('shodiqsolution@gmail.com')->send(new SendEmail($data_pesan));

            $dataPelanggan = PelangganModel:: create($data);
            if ($dataPelanggan == true) {
                Alert::success('Success!', 'Berhasil Daftar Akun Anda');
                return redirect('/');
            } else {
                Alert::error('Error!', 'Gagal Daftar Akun Anda');
                return redirect('daftar_pelanggan');
            }
        } else {
                Alert::error('Error!', 'Email Sudah Terdaftar');
                return redirect('daftar_pelanggan');
        }
        
        
        
    }
}
