<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $DataSiswa = SiswaModel::where('nisn_siswa',$id)->first();
        if ($DataSiswa == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataSiswa]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'nisn_siswa' => 'required|numeric|digits:10|unique:siswa,nisn_siswa',
                'nama_siswa' => 'required|string|max:255',
                'tanggal_lahir_siswa' => 'required|date',
                'tempat_lahir_siswa' => 'required|string|max:255',
                'jenis_kelamin_siswa' => 'required|in:L,P',
                'no_hp_siswa' => 'required|numeric|digits_between:10,15',
                'email_siswa' => 'required|email|max:255|unique:siswa,email_siswa,NULL,id',
                'tahun_masuk_siswa' => 'required|numeric|digits:4|min:2000|max:' . date('Y')
            ]);
    
            // Generate unique ID based on current date and count
            $tanggal = now()->format('dmy');
            $nomorUrut = SiswaModel::whereDate('created_at', now()->toDateString())->count() + 1;
            $id = 'SW' . '-' . $tanggal . '-' . $nomorUrut;
    
            // Prepare data for insertion
            $data = [
                'id_siswa' => $id,
                'nisn_siswa' => $validatedData['nisn_siswa'],
                'nama_siswa' => $validatedData['nama_siswa'],
                'tanggal_lahir_siswa' => $validatedData['tanggal_lahir_siswa'],
                'tempat_lahir_siswa' => $validatedData['tempat_lahir_siswa'],
                'jenis_kelamin_siswa' => $validatedData['jenis_kelamin_siswa'],
                'no_hp_siswa' => $validatedData['no_hp_siswa'],
                'email_siswa' => $validatedData['email_siswa'],
                'tahun_masuk_siswa' => $validatedData['tahun_masuk_siswa'],
                'status_siswa' => '0',
                'id_user' => 1,
            ];
    
            // Store data into database
            $siswa = SiswaModel::create($data);
    
            // Check if data was successfully stored
            if ($siswa) {
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $siswa]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
            }
    
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function updateData($id,Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'nisn_siswa' => 'required|numeric|digits:10',
                'nama_siswa' => 'required|string|max:255',
                'tanggal_lahir_siswa' => 'required|date',
                'tempat_lahir_siswa' => 'required|string|max:255',
                'jenis_kelamin_siswa' => 'required|in:L,P',
                'no_hp_siswa' => 'required|numeric|digits_between:10,15',
                'email_siswa' => 'required|email|max:255',
                'tahun_masuk_siswa' => 'required|numeric|digits:4|min:2000|max:' . date('Y')
            ]);
    
            // Prepare data for insertion
            $data = [
                'nisn_siswa' => $validatedData['nisn_siswa'],
                'nama_siswa' => $validatedData['nama_siswa'],
                'tanggal_lahir_siswa' => $validatedData['tanggal_lahir_siswa'],
                'tempat_lahir_siswa' => $validatedData['tempat_lahir_siswa'],
                'jenis_kelamin_siswa' => $validatedData['jenis_kelamin_siswa'],
                'no_hp_siswa' => $validatedData['no_hp_siswa'],
                'email_siswa' => $validatedData['email_siswa'],
                'tahun_masuk_siswa' => $validatedData['tahun_masuk_siswa']
            ];

            // Store data into database
            $siswa = SiswaModel::where('id_siswa',$request->id_siswa)->update($data);
    
            // Check if data was successfully stored
            if ($siswa) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $siswa]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Edit Data']);
            }
    
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }        
    }

    public function deleteData($id)
    {
        try {
            $siswa = SiswaModel::where('nisn_siswa',$id);

            $data = [
                'status_siswa' => 3,
                'deleted_at' => now()->format('Y-m-d h:i:s')
            ];

            $siswa->update($data);

            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data: ' . $e->getMessage()]);
        }
    }

    public function statusData($id, $status)
    {
        try {
            $siswa = SiswaModel::where('nisn_siswa',$id); // Cari siswa berdasarkan ID

            $siswa->update(['status_siswa' => $status]); // Update status periode siswa

            if ($status == 1) {
                return response()->json(['success' => true, 'message' => 'Berhasil mengaktifkan data siswa.']);
            } else {
                return response()->json(['success' => true, 'message' => 'Berhasil menonaktifkan data siswa.']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal: ' . $e->getMessage()]); // Tangani jika terjadi kesalahan dalam pencarian atau pembaruan
        }
    }

    public function fotoUpdate(){
        $menu = 'master';
        $submenu= 'siswa';
        return view ('Admin/siswa/data_foto_siswa',compact('menu','submenu'));
    }

    public function AjaxDataFoto(Request $request) {
        $DataSiswa = SiswaModel::whereNotNull('foto_siswa')->whereNull('deleted_at')->get();
        if ($DataSiswa == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataSiswa]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function updateDataFoto(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'foto_siswa' => 'required|file|mimes:jpeg,png,jpg|max:2048', // Example: allow JPEG and PNG files, max size 2MB
            ]);

            if ($request->hasFile('foto_siswa')) {
                $file = $request->file('foto_siswa');
                $nama_siswa = $request->nama_siswa; 
                $originalFileName = $file->getClientOriginalName();
                $customFileName = $nama_siswa . '-' . $originalFileName;
                $path = $file->storeAs('public/siswa', $customFileName);
                //$path = $file->move('siswa', $customFileName);
            }

            $data = [
                'foto_siswa' => 'siswa/'.$customFileName
            ];
            $siswa = SiswaModel::where('nisn_siswa', $request->nama_siswa)->update($data);

            if ($siswa) {
                return response()->json(['success' => true, 'message' => 'Berhasil Upload Foto', 'data' => $siswa]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Upload Foto']);
            }
    
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }        
    }
    
    
}
