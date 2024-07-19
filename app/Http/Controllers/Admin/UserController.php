<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailPendaftaran;
use App\Mail\SendEmailVerifikasi;
use Carbon\Carbon;

use App\Models\User;

class UserController extends Controller
{
    // send email
    private function createMessageData($request, $judul, $title, $password = null, $link = null)
    {
        return [
            'judul' => $judul,
            'title' => $title,
            'nama_user' => $request->nama_user,
            'email_user' => $request->email,
            'alamat_user' => $request->alamat_user,
            'no_hp_user' => $request->no_hp_user,
            'password_user' => $password,
            'tanggal_daftar' => Carbon::now(),
            'link' => $link,
        ];
    }

    public function index(){
        $menu = 'user';
        $submenu= 'user';
        return view ('Admin/users/data_users',compact('menu','submenu'));
    }
    public function AjaxData(Request $request) {
        $DataUser = User::DataAll();
        if ($DataUser == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataUser]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxEditData($id)
    {
        $DataUser = User::where('id',$id)->first();
        if ($DataUser == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataUser]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxStoreData(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|max:255',
                'nama_user' => 'required|string',
                'no_hp_user' => 'required|string|max:15', 
                'alamat_user' => 'required|string|max:255',
                'level_user' => 'required|integer', 
            ]);          

            $data = [
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'nama_user' => $validatedData['nama_user'],
                'no_hp_user' => $validatedData['no_hp_user'],
                'alamat_user' => $validatedData['alamat_user'],
                'level_user' => $validatedData['level_user'],
                'status_user' => session('user')['id_user'],
            ];

            $link = 'link';

            $data_pesan = $this->createMessageData($request,'daftar', 'PENDAFTARAN AKUN MY TAHFIDZ', $request->password,$link);
            $sendEmail = Mail::to($request->email)->send(new SendEmailPendaftaran($data_pesan));

            if ($sendEmail) {
                User::create($data);
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
            } else {
                return response()->json(['error' => true, 'message' => 'Email Tidak Aktif']);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function AjaxUpdateData($id, Request $request)
    {
        try {
            //Validate the request
            if ($request->password != null || $request->password != '') { 
                $validatedData = $request->validate([
                    'password' => 'required|string|max:255',
                ]);
            }
    
            $validatedData = $request->validate([
                'email' => 'required|email',
                'nama_user' => 'required|string',
                'no_hp_user' => 'required|string|max:15', 
                'alamat_user' => 'required|string|max:255',
                'level_user' => 'required|integer', 
            ]);          

            $data = [
                'email' => $validatedData['email'],
                'nama_user' => $validatedData['nama_user'],
                'no_hp_user' => $validatedData['no_hp_user'],
                'alamat_user' => $validatedData['alamat_user'],
                'level_user' => $validatedData['level_user'],
            ];
    
            if (isset($validatedData['password'])) {
                $data['password'] = Hash::make($validatedData['password']);
                $data_pesan = $this->createMessageData($request,'update', "PASSWORD BARU AKUN MY TAHFIDZ", $request->password);
            } else {
                $data_pesan = $this->createMessageData($request,'update', 'PEMBARUI AKUN MY TAHFIDZ');
            }
    
            //Send the email
            Mail::to($request->email)->send(new SendEmailPendaftaran($data_pesan));
    
            User::where('id', $id)->update($data);
            return response()->json(['success' => true, 'message' => 'Berhasil Update Data']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    
    public function AjaxDeleteData($id)
    {
        $DataUser = User::where('id',$id)->first();
        if ($DataUser == true) {
            User::where('id',$id)->delete();
            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data']);
        }
    }

    public function AjaxStatusData($id, $status)
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
}
