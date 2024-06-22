<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin\SiswaModel;

class SiswaController extends Controller
{
    public function index(){
        $menu = 'master';
        $submenu= 'siswa';
        return view ('Admin/siswa/data_siswa',compact('menu','submenu'));
    }
    public function AjaxData(Request $request) {
            $DataSiswa = SiswaModel::whereNull('deleted_at')->get();
        
        if ($DataSiswa == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataSiswa]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataSiswa = SiswaModel::where('id_siswa',$id)->first();
        if ($DataSiswa == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataSiswa]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
       // Mendapatkan tanggal saat ini
        $tanggal = now()->format('dmy');
        // Mendapatkan nomor urut terakhir + 1 (gunakan Eloquent atau Query Builder)
        $nomorUrut = SiswaModel::whereDate('created_at', now()->toDateString())->count() + 1;
        if(!$nomorUrut){
            $id = Auth::User()->id_pelanggan.'-'.$tanggal.'-1';
        }else{
            $id = Auth::User()->id_pelanggan.'-'.$tanggal . '-' . $nomorUrut;
        }
        $data = [
                'id_siswa' => $id,
                'judul_periode' => $request->judul_periode,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'status_periode' => '0',
                'id_user' => Auth::User()->id,
                'id_pelanggan' => Auth::User()->id_pelanggan
        ];

       $DataSiswa = SiswaModel::create($data);
        if ($DataSiswa == true) {
            return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
        }
    }

    public function updateData($id,Request $request)
    {
        $cekData = SiswaModel::where('id_siswa',$id)->first();
        if ( $cekData == true) {
            $data = [
                'judul_periode' => $request->judul_periode,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'status_periode' => 0,
                'id_user' => 1
            ];
            $DataSiswa = SiswaModel::where('id_siswa',$id)->update($data);
             if ($DataSiswa == true) {
                 return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
             }else{
                 return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
             }
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
        
        
    }

    public function deleteData($id)
    {
        $DataSiswa = SiswaModel::where('id_siswa',$id)->first();
        if ($DataSiswa == true) {
        $data = [
            'deleted_at' => now()->format('Y-m-d h:i:s')
        ];
            SiswaModel::where('id_siswa',$id)->update($data);
            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data']);
        }
    }

    public function statusData($id, $status)
    {
        if ($status == 1) {
            $cekPeriode = SiswaModel::where('id_pelanggan',Auth::User()->id_pelanggan)->where('status_periode',1)->first();
            if ($cekPeriode == true) {
                return response()->json(['error' => true, 'message' => 'Periode hanya satu Periode yang bisa AKTIF']);
            } else {
                $DataSiswa = SiswaModel::where('id_siswa',$id)->first();
                if ($DataSiswa == true) {
                    $data = [
                        'status_periode' => $status
                    ];
                    SiswaModel::where('id_siswa',$id)->update($data);
                    if ($status == 1) {
                        return response()->json(['error' => false, 'message' => 'Berhasil Aktifkan Data']);
                    } else {
                        return response()->json(['error' => false, 'message' => 'Berhasil Tidak Aktifkan Data']);
                    }
                    
                }else{
                    return response()->json(['error' => true, 'message' => 'Gagal Ditemukan']);
                }
            }
        } else {
            $DataSiswa = SiswaModel::where('id_siswa',$id)->first();
            if ($DataSiswa == true) {
                $data = [
                    'status_periode' => $status
                ];
                SiswaModel::where('id_siswa',$id)->update($data);
                if ($status === 1) {
                    return response()->json(['success' => false, 'message' => 'Berhasil Aktifkan Data']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Berhasil Tidak Aktifkan Data']);
                }
                
            }else{
                return response()->json(['error' => true, 'message' => 'Gagal Ditemukan']);
            }
        }
        
        
        
        
    }
}
