<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailPendaftaran;
use App\Mail\SendEmailVerifikasi;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Admin\PelangganModel;

class UserController extends Controller
{
    public function index(){
        $menu = 'pelanggan';
        $submenu= 'user';
        return view ('Admin/user/data_user',compact('menu','submenu'));
    }
    public function AjaxData(Request $request) {
        if(Auth::User()->level_user == 'superadmin'){
            $DataUser = User::DataAll();
        }else if(Auth::User()->level_user == 'admin'){
            $DataUser = User::DataAllId(Auth::User()->id_pelanggan);
        }
        
        if ($DataUser == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataUser]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataUser = User::where('id',$id)->first();
        if ($DataUser == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataUser]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
       $data = [
           'id_pelanggan' =>  $request->pelanggan,
           'email' => $request->email_user,
           'password' => Hash::make($request->password),
           'nama_user' => $request->nama_user,
           'no_hp_user' => $request->no_hp_user,
           'alamat_user' => $request->alamat_user,
           'level_user' => $request->level_user,
           'status_user' => 1,
           
       ];

        //kirim email
        $data_pesan = [
            'title' => 'AKUN APKIS',
            'id_pelanggan' => $request->pelanggan,
            'nama_pelanggan' => $request->nama_user,
            'email_pelanggan' => $request->email_user,
            'nama_usaha' => $request->nama_usaha,
            'alamat_usaha' => $request->alamat_user,
            'no_hp_usaha' => $request->no_hp_user,
            'password' => $request->password,
            'tanggal_aktifasi' => Carbon::now()
        ];
        dd($data);
        //Mail::to($request->email_user)->send(new SendEmailPendaftaran($data_pesan));
        $DataUser = User::create($data);
        if ($DataUser == true) {
            return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
        }
    }


    public function deleteData($id)
    {
        $DataUser = User::where('id',$id)->first();
        if ($DataUser == true) {
            User::where('id',$id)->delete();
            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data']);
        }
    }

    public function statusData($id, $status)
    {
        $DataUser = User::where('id',$id)->first();
        if ($DataUser == true) {
        $data = [
            'status_user' => $status
        ];
            User::where('id',$id)->update($data);
            if ($status === 1) {
                return response()->json(['success' => true, 'message' => 'Berhasil Aktifkan Data']);
            } else {
                return response()->json(['success' => true, 'message' => 'Berhasil Tidak Aktifkan Data']);
            }
            
            
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Proses Data']);
        }
    }

    public function AjaxDataPelanggan(Request $request) {
        $DataPelanggan = PelangganModel::all();
        if ($DataPelanggan->isNotEmpty()) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPelanggan]);
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataPelangganID($id) {
        $DataPelanggan = PelangganModel::where('id_pelanggan', $id)->first();
        if ($DataPelanggan == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPelanggan]);
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }


    // admin
    public function storeDataAkun(Request $request)
    {
       $data = [
           'id_pelanggan' =>  Auth::User()->id_pelanggan,
           'email' => $request->email_user_akun,
           'password' => Hash::make($request->password_user_akun),
           'nama_user' => $request->nama_user_akun,
           'no_hp_user' => $request->no_hp_user_akun,
           'alamat_user' => $request->alamat_user_akun,
           'level_user' => $request->level_user_akun,
           'status_user' => 0,
           
       ];
       $DataPelanggan = PelangganModel::where('id_pelanggan', Auth::User()->id_pelanggan)->first();
       //kirim email
       $data_pesan = [
            'title' => 'AKUN APKIS',
            'id_pelanggan' => Auth::User()->id_pelanggan,
            'nama_pelanggan' => $request->nama_user_akun,
            'email_pelanggan' => $request->email_user_akun,
            'nama_usaha' => $DataPelanggan->nama_usaha,
            'alamat_usaha' => $request->alamat_user_akun,
            'no_hp_usaha' => $request->no_hp_user_akun,
            'password' => $request->password_user_akun,
            'tanggal_aktifasi' => Carbon::now(),
            'link' => 'verivikasi_akun/'.$request->email_user_akun
        ];
        Mail::to($request->email_user_akun)->send(new SendEmailPendaftaran($data_pesan));
        $DataUser = User::create($data);
        if ($DataUser == true) {
            return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
        }
    }

    public function editDataAkun($id)
    {
        $DataUser = User::where('id',$id)->first();
        if ($DataUser == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataUser]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function updateDataAkun($id,Request $request)
    {
        $cekData = User::where('id',$id)->first();
        if ( $cekData == true) {
            $data = [
                'email' => $request->email_user_akun,
                'nama_user' => $request->nama_user_akun,
                'no_hp_user' => $request->no_hp_user_akun,
                'alamat_user' => $request->alamat_user_akun                
            ];
            $DataUser = User::where('id',$id)->update($data);
             if ($DataUser == true) {
                 return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
             }else{
                 return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
             }
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
        
        
    }

    public function updatePasswordAkun($id,Request $request)
    {
        $cekData = User::where('id',$id)->first();
        if ( $cekData == true) {
            $data = [
                'password' => Hash::make($request->password_user_akun),              
            ];
            $DataUser = User::where('id',$id)->update($data);
             if ($DataUser == true) {
                 return response()->json(['success' => true, 'message' => 'Berhasil Upadate Password']);
             }else{
                 return response()->json(['error' => true, 'message' => 'Gagal Upadate Password']);
             }
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
        
        
    }    

    public function kirimEmailVerifikasi($email)
    {
        $user = User::where('email',$email)->first();
       //kirim email
       $data_pesan = [
            'title' => 'AKUN APKIS',
            'link' => 'verivikasi_akun/'.$email
        ];
        
        Mail::to($email)->send(new SendEmailVerifikasi($data_pesan));
    }

    public function verifikasi_akun($id)
    {
        $cekData = User::where('email',$id)->first();
        if ( $cekData == true) {
            $data = [
                'email_verified_at' => Carbon::now(), 
                'status_user' => 1             
            ];
            $DataUser = User::where('id',$cekData->id)->update($data);
             if ($DataUser == true) {
                Alert::success('Success!', 'Berhasil Aktifasi Akun');
                return redirect()->intended('/');
             }else{
                Alert::error('Errorr!', 'Gagal Aktifasi Akun');
                return redirect()->intended('/');
             }
        } else {
            Alert::error('Errorr!', 'Gagal Aktifasi Akun');
            return redirect()->intended('/');
        }
    }
}
