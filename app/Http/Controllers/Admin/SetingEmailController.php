<?php

namespace App\Http\Controllers\Admin;
use Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailModel;
class SetingEmailController extends Controller
{

    //seting email
    public function index(){
        $menu = 'seting';
        $submenu= 'email';
        $email = MailModel::first();
        return view ('Admin/email/data_email',compact('menu','submenu', 'email'));
    }

    public function updateData($id, Request $request)
    {

        // Cari data surat berdasarkan id
        $email = MailModel::findOrFail($id);
        if($email == true){
        // Update data lainnya jika ada
        $email->mail_mailer = $request->mail_mailer ?? $email->mail_mailer;
        $email->mail_host = $request->mail_host ?? $email->mail_host;
        $email->mail_port = $request->mail_port ?? $email->mail_port;
        $email->mail_username = $request->mail_username ?? $email->mail_username;
        $email->mail_password = $request->mail_password ?? $email->mail_password;
        $email->mail_encryption = $request->mail_encryption ?? $email->mail_encryption;
        $email->mail_from_address = $request->mail_from_address ?? $email->mail_from_address;
        $email->mail_from_name = $request->mail_from_name ?? $email->mail_from_name;
        // Simpan perubahan ke database
        $DataEmail = $email->save();

        if ($DataEmail == true) {
            return response()->json(['success' => true, 'message' => 'Berhasil Rubah Email']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Rubah Email']);
        }
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }

    }
}
