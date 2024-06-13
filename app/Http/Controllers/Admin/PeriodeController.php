<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin\PeriodeModel;

class PeriodeController extends Controller
{
    public function index(){
        $menu = 'master';
        $submenu= 'periode';
        return view ('Admin/periode/data_periode',compact('menu','submenu'));
    }
    public function AjaxData(Request $request) {
        if(Auth::User()->level_user == 'superadmin'){
            $DataPeriode = PeriodeModel::whereNull('deleted_at')->get();
        }else{
            $DataPeriode = PeriodeModel::where('id_pelanggan',Auth::User()->id_pelanggan)->whereNull('deleted_at')->get();
        }
        
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataPeriode = PeriodeModel::where('id_periode',$id)->first();
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeriode]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
       // Mendapatkan tanggal saat ini
        $tanggal = now()->format('dmy');
        // Mendapatkan nomor urut terakhir + 1 (gunakan Eloquent atau Query Builder)
        $nomorUrut = PeriodeModel::whereDate('created_at', now()->toDateString())->count() + 1;
        if(!$nomorUrut){
            $id = Auth::User()->id_pelanggan.'-'.$tanggal.'-1';
        }else{
            $id = Auth::User()->id_pelanggan.'-'.$tanggal . '-' . $nomorUrut;
        }
        $data = [
                'id_periode' => $id,
                'judul_periode' => $request->judul_periode,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'status_periode' => '0',
                'id_user' => Auth::User()->id,
                'id_pelanggan' => Auth::User()->id_pelanggan
        ];

       $DataPeriode = PeriodeModel::create($data);
        if ($DataPeriode == true) {
            return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
        }
    }

    public function updateData($id,Request $request)
    {
        $cekData = PeriodeModel::where('id_periode',$id)->first();
        if ( $cekData == true) {
            $data = [
                'judul_periode' => $request->judul_periode,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'status_periode' => 0,
                'id_user' => 1
            ];
            $DataPeriode = PeriodeModel::where('id_periode',$id)->update($data);
             if ($DataPeriode == true) {
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
        $DataPeriode = PeriodeModel::where('id_periode',$id)->first();
        if ($DataPeriode == true) {
        $data = [
            'deleted_at' => now()->format('Y-m-d h:i:s')
        ];
            PeriodeModel::where('id_periode',$id)->update($data);
            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        }else{
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data']);
        }
    }

    public function statusData($id, $status)
    {
        if ($status == 1) {
            $cekPeriode = PeriodeModel::where('id_pelanggan',Auth::User()->id_pelanggan)->where('status_periode',1)->first();
            if ($cekPeriode == true) {
                return response()->json(['error' => true, 'message' => 'Periode hanya satu Periode yang bisa AKTIF']);
            } else {
                $DataPeriode = PeriodeModel::where('id_periode',$id)->first();
                if ($DataPeriode == true) {
                    $data = [
                        'status_periode' => $status
                    ];
                    PeriodeModel::where('id_periode',$id)->update($data);
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
            $DataPeriode = PeriodeModel::where('id_periode',$id)->first();
            if ($DataPeriode == true) {
                $data = [
                    'status_periode' => $status
                ];
                PeriodeModel::where('id_periode',$id)->update($data);
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
