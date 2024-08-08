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

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }

    public function index(){
        $menu = 'master';
        $submenu= 'Mahasiswa';
        return view ('Admin/siswa/data_siswa',compact('menu','submenu'));
    }

    public function AjaxData(Request $request) {
        $DataSiswa = MahasiswaModel::GetMahasiswaAll();
        $DataProdi = ProdiModel::whereNull('deleted_at')->get();
        if ($DataSiswa == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataSiswa, 'prodi' => $DataProdi]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function editData($id)
    {
        $DataSiswa = MahasiswaModel::where('nim_mhs',$id)->first();
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
                'nim_mhs' => 'required|numeric|digits:9|unique:mtr_mahasiswa,nim_mhs',
                'nama_mhs' => 'required|string|max:255',
                'id_program_studi' => 'required',
                'password' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
            ]);

            // Prepare data for insertion
            $date = new \DateTime($validatedData['tanggal_lahir']);
            $formatTanggal = $date->format('dmy');

            $data = [
                'nim_mhs' => $validatedData['nim_mhs'],
                'nama_mhs' => $validatedData['nama_mhs'],
                'id_program_studi' => $validatedData['id_program_studi'],
                'password' =>  Hash::make($validatedData['password']),
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
            ];

    
            // Store data into database
            $siswa = MahasiswaModel::create($data);
    
            // Check if data was successfully stored
            if ($siswa) {
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $siswa]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }      
    }

    public function updateData($id,Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_mhs' => 'required|string|max:255',
                'id_program_studi' => 'required',
                'tanggal_lahir' => 'required|date',
            ]);

            $siswaCek = MahasiswaModel::where('nim_mhs',$request->nim_mhs)->first();
            if (!$siswaCek) {
                return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
            }
            // Prepare data for insertion
            $date = new \DateTime($validatedData['tanggal_lahir']);
            $formatTanggal = $date->format('dmy');

            $data = [
                'nama_mhs' => $validatedData['nama_mhs'],
                'id_program_studi' => $validatedData['id_program_studi'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
            ];
            // Update data into database
            $siswa = MahasiswaModel::where('nim_mhs',$request->nim_mhs)->update($data);
    
            // Check if data was successfully Update
            if ($siswa) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $siswa]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Edit Data']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }        
    }

    public function deleteData($id)
    {
        try {
            $siswa = MahasiswaModel::where('nim_mhs',$id);

            $data = [
                'deleted_at' => now()->format('Y-m-d h:i:s')
            ];

            $siswa->update($data);

            return response()->json(['success' => true, 'message' => 'Berhasil Hapus Data']);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Gagal Hapus Data: ' . $e->getMessage()]);
        }
    }
        
}
