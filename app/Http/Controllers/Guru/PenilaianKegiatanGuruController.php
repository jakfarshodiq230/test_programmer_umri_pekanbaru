<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\TahunAjaranModel;
use App\Models\Admin\PeriodeModel;
use App\Models\Admin\PesertaKegiatan;
use App\Models\Admin\SiswaModel;
use App\Models\Admin\GuruModel;
use App\Models\Admin\KelasModel;
use App\Models\Admin\PenilaianModel;
use App\Models\Admin\PenilaianSmModel;
use App\Models\Admin\SurahModel;

use App\Pdf\CustomPdf;

class PenilaianKegiatanGuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:guru');
    }
    public function index(){
        $menu = 'kegiatan';
        $submenu= 'penilaian';
        return view ('Guru/kegiatan/penilaian/data_penilaian_kegiatan',compact('menu','submenu'));
    }

    public function AjaxDataPeriode($guru) {
        $DataPeserta = PesertaKegiatan::DataAllGuru($guru);
        if ($DataPeserta == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function DataListPenilaianKegiatan($id_periode,$id_tahun_ajaran){
        $menu = 'kegiatan';
        $submenu= 'penilaian';
        $periode = $id_periode;
        $tahun_ajaran = $id_tahun_ajaran;
        $judul_1 = PeriodeModel::where('id_periode', $id_periode)->whereNull('deleted_at')->first();
        $judul_2 = TahunAjaranModel::where('id_tahun_ajaran', $id_tahun_ajaran)->whereNull('deleted_at')->first();
        $judul_3 = ucfirst($judul_1->jenis_periode).' '. $judul_2->nama_tahun_ajaran;
        return view ('Guru/kegiatan/penilaian/data_list_penilaian_kegiatan',compact('menu','submenu','periode','tahun_ajaran','judul_1','judul_2','judul_3'));
    }

    public function AjaxData($id_periode,$id_tahun_ajaran,$guru) {
        $DataPeserta = PesertaKegiatan::DataPesertaKegiatanGuru($id_periode,$id_tahun_ajaran,$guru);
        
        if ($DataPeserta == true) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $DataPeserta]);
        }else{
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function AjaxDataSiswa($tahun,$periode)
    {
        $selectedIds = PesertaKegiatan::where('id_tahun_ajaran',$tahun)->where('id_periode',$periode)->pluck('id_siswa')->toArray();
        $siswa = SiswaModel::whereNotIn('id_siswa', $selectedIds)->get();
        if ($siswa->isNotEmpty()) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data' => $siswa]);
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }


    public function DetailPenilaianKegiatan(){
        $menu = 'kegiatan';
        $submenu= 'penilaian';
        return view ('Guru/kegiatan/penilaian/detail_penilaian_kegiatan',compact('menu','submenu'));
    }

    public function DataDetailPenilaianKegiatan($tahun,$periode,$siswa,$guru,$kelas){
        $menu = 'kegiatan';
        $submenu= 'penilaian';
        $judul_1 = PeriodeModel::where('id_periode', $periode)->whereNull('deleted_at')->first();
        $judul_2 = TahunAjaranModel::where('id_tahun_ajaran', $tahun)->whereNull('deleted_at')->first();
        $judul_3 = ucfirst($judul_1->jenis_periode).' '. $judul_2->nama_tahun_ajaran;
        $kegiatan =$judul_1->jenis_periode;
        return view ('Guru/kegiatan/penilaian/detail_penilaian_kegiatan',compact(
            'menu',
            'submenu',
            'judul_3',
            'tahun',
            'periode',
            'siswa',
            'guru',
            'kelas',
            'kegiatan',
        ));
    }

    public function AjaxDataDetailPenilaianKegiatan($tahun,$periode,$siswa,$guru,$kelas){
        
        $nilai = PenilaianModel::DataPenialainKegiatan($tahun,$periode,$siswa,$guru,$kelas);
        if ($nilai) {
            $siswa = PesertaKegiatan::DataSiswaProfil($tahun,$periode,$siswa,$guru,$kelas);
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'nilai'=> $nilai,'siswa'=> $siswa]);
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function addPenilaianKegiatan($periode,$tahun){
        $menu = 'kegiatan';
        $submenu= 'penilaian';
        $periode = PeriodeModel::where('id_periode', $periode)->whereNull('deleted_at')->first();
        $tahun = TahunAjaranModel::where('id_tahun_ajaran', $tahun)->whereNull('deleted_at')->first();
        $judul_3 = ucfirst($periode->jenis_periode).' '. $tahun->nama_tahun_ajaran;
        return view ('Guru/kegiatan/penilaian/add_penilaian_kegiatan',compact('menu','submenu','tahun','periode','judul_3'));
    }

    public function AjaxDataPesertaPenilaian($tahun,$periode,$guru){
        
        $siswa = PesertaKegiatan::DataSiswaGuru($tahun,$periode,$guru);
        if ($siswa) {
            $surah = SurahModel::get();
            return response()->json(['success' => true, 'message' => 'Data Ditemukan','siswa'=> $siswa, 'surah'=> $surah]);
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function storeData(Request $request)
    {
        try {
            
            // Validate incoming request data
            if ($request->jenis_penilaian_kegiatan === 'tahfidz' || $request->jenis_penilaian_kegiatan === 'murajaah') {
                $validatedData = $request->validate([
                    'siswa' => 'required|not_in:PILIH,other',
                    'id_periode' => 'required',
                    'id_peserta_kegiatan' => 'required',
                    'tanggal_penilaian_kegiatan' => 'required|date',
                    'jenis_penilaian_kegiatan' => 'required|string|max:255|not_in:PILIH,other',
                    'surah_awal_penilaian_kegiatan' => 'required|string',
                    'surah_akhir_penilaian_kegiatan' => 'required|string',
                    'ayat_awal_penilaian_kegiatan' => 'required|numeric',
                    'ayat_akhir_penilaian_kegiatan' => 'required|numeric',
                    'nilai_tajwid_penilaian_kegiatan' => 'required|numeric',
                    'nilai_fasohah_penilaian_kegiatan' => 'required|numeric',
                    'nilai_kelancaran_penilaian_kegiatan_tahfidz' => 'required|numeric',
                    'keterangan_penilaian_kegiatan' => 'required|string',
                ]);
            } else {
                $validatedData = $request->validate([
                    'siswa' => 'required',
                    'id_periode' => 'required',
                    'id_peserta_kegiatan' => 'required',
                    'tanggal_penilaian_kegiatan' => 'required|date',
                    'jenis_penilaian_kegiatan' => 'required|string|max:255|not_in:PILIH,other',
                    'surah_awal_penilaian_kegiatan' => 'required|string',
                    'surah_akhir_penilaian_kegiatan' => 'required|string',
                    'ayat_awal_penilaian_kegiatan' => 'required|numeric',
                    'ayat_akhir_penilaian_kegiatan' => 'required|numeric',
                    'nilai_ghunnah_penilaian_kegiatan' => 'required|numeric',
                    'nilai_mad_penilaian_tahsin' => 'required|numeric',
                    'nilai_waqof_penilaian_tahsin' => 'required|numeric',
                    'nilai_kelancaran_penilaian_kegiatan_tahsin' => 'required|numeric',
                    'keterangan_penilaian_kegiatan' => 'required|string',
                ]);
            }
            
            
    
            // Generate unique ID based on current date and count
            $tanggal = now()->format('dmy');
            $nomorUrut = PenilaianSmModel::whereDate('created_at', now()->toDateString())->count() + 1;
            $id = 'PNI' . '-' . $tanggal . '-' . $nomorUrut;

            // Prepare data for insertion
            if ($request->jenis_penilaian_kegiatan === 'tahfidz' || $request->jenis_penilaian_kegiatan === 'murajaah') {
                $data = [
                    'id_penilaian_kegiatan' => $id,
                    'id_peserta_kegiatan' => $validatedData['id_peserta_kegiatan'],
                    'id_periode' => $validatedData['id_periode'],
                    'tanggal_penilaian_kegiatan' => $validatedData['tanggal_penilaian_kegiatan'],
                    'jenis_penilaian_kegiatan' => $validatedData['jenis_penilaian_kegiatan'],
                    'surah_awal_penilaian_kegiatan' => $validatedData['surah_awal_penilaian_kegiatan'],
                    'surah_akhir_penilaian_kegiatan' => $validatedData['surah_akhir_penilaian_kegiatan'],
                    'ayat_awal_penilaian_kegiatan' => $validatedData['ayat_awal_penilaian_kegiatan'],
                    'ayat_akhir_penilaian_kegiatan' => $validatedData['ayat_akhir_penilaian_kegiatan'],
                    'nilai_tajwid_penilaian_kegiatan' => $validatedData['nilai_tajwid_penilaian_kegiatan'],
                    'nilai_fasohah_penilaian_kegiatan' => $validatedData['nilai_fasohah_penilaian_kegiatan'],
                    'nilai_kelancaran_penilaian_kegiatan' => $validatedData['nilai_kelancaran_penilaian_kegiatan_tahfidz'],
                    'keterangan_penilaian_kegiatan' => $validatedData['keterangan_penilaian_kegiatan'],
                    'id_user' => session('user')['id'],
                ];
            } else {
                $data = [
                    'id_penilaian_kegiatan' => $id,
                    'id_peserta_kegiatan' => $validatedData['id_peserta_kegiatan'],
                    'id_periode' => $validatedData['id_periode'],
                    'tanggal_penilaian_kegiatan' => $validatedData['tanggal_penilaian_kegiatan'],
                    'jenis_penilaian_kegiatan' => $validatedData['jenis_penilaian_kegiatan'],
                    'surah_awal_penilaian_kegiatan' => $validatedData['surah_awal_penilaian_kegiatan'],
                    'surah_akhir_penilaian_kegiatan' => $validatedData['surah_akhir_penilaian_kegiatan'],
                    'ayat_awal_penilaian_kegiatan' => $validatedData['ayat_awal_penilaian_kegiatan'],
                    'ayat_akhir_penilaian_kegiatan' => $validatedData['ayat_akhir_penilaian_kegiatan'], 
                    'nilai_ghunnah_penilaian_kegiatan' => $validatedData['nilai_ghunnah_penilaian_kegiatan'],
                    'nilai_mad_penilaian_tahsin' => $validatedData['nilai_mad_penilaian_tahsin'],
                    'nilai_waqof_penilaian_tahsin' => $validatedData['nilai_waqof_penilaian_tahsin'],
                    'nilai_kelancaran_penilaian_kegiatan' => $validatedData['nilai_kelancaran_penilaian_kegiatan_tahsin'],
                    'keterangan_penilaian_kegiatan' => $validatedData['keterangan_penilaian_kegiatan'],
                    'id_user' => session('user')['id'],
                ];
            }
            // Store data into database
            $PenialaiSM = PenilaianSmModel::create($data);
    
            // Check if data was successfully stored
            if ($PenialaiSM) {
                return response()->json(['success' => true, 'message' => 'Berhasil Tambah Data', 'data' => $PenialaiSM]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Tambah Data']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function AjaxDataPesertaPenilaianSm($periode,$guru,$kegiatan){
        
        $nilai = PenilaianSmModel::DataNilaiSementara($periode,$guru,$kegiatan);
        if ($nilai) {
            return response()->json(['success' => true, 'message' => 'Data Ditemukan','data'=> $nilai]);
        } else {
            return response()->json(['error' => true, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function deleteData($id)
    {
        try {
            $nilai = PenilaianSmModel::where('id_penilaian_kegiatan', $id)->delete();
            if ($nilai) {
                return response()->json(['success' => true, 'message' => 'Data Berhasil Dihapus']);
            } else {
                return response()->json(['error' => true, 'message' => 'Data Tidak Berhasil Dihapus']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Terjadi kesalahan saat menghapus data', 'details' => $e->getMessage()]);
        }
    }

    public function kirimData($periode,$guru,$kegiatan)
    {
        try {
            $nilai = PenilaianSmModel::DataNilaiSementara($periode,$guru,$kegiatan);

            foreach ($nilai as $key => $value) {

                $tanggal = now()->format('dmy');
                $nomorUrut = PenilaianModel::whereDate('created_at', now()->toDateString())->count() + 1;
                $id = 'PNI' . '-' . $tanggal . '-' . $nomorUrut;

                if ($value->jenis_penilaian_kegiatan === 'tahfidz' || $value->jenis_penilaian_kegiatan === 'murajaah') {
                    $data = [
                        'id_penilaian_kegiatan' => $id,
                        'id_peserta_kegiatan' => $value->id_peserta_kegiatan,
                        'tanggal_penilaian_kegiatan' => $value->tanggal_penilaian_kegiatan,
                        'jenis_penilaian_kegiatan' => $value->jenis_penilaian_kegiatan,
                        'surah_awal_penilaian_kegiatan' => $value->surah_awal_penilaian_kegiatan,
                        'surah_akhir_penilaian_kegiatan' => $value->surah_akhir_penilaian_kegiatan,
                        'ayat_awal_penilaian_kegiatan' => $value->ayat_awal_penilaian_kegiatan,
                        'ayat_akhir_penilaian_kegiatan' => $value->ayat_akhir_penilaian_kegiatan,
                        'nilai_tajwid_penilaian_kegiatan' => $value->nilai_tajwid_penilaian_kegiatan,
                        'nilai_fasohah_penilaian_kegiatan' => $value->nilai_fasohah_penilaian_kegiatan,
                        'nilai_kelancaran_penilaian_kegiatan' => $value->nilai_kelancaran_penilaian_kegiatan,
                        'keterangan_penilaian_kegiatan' => $value->keterangan_penilaian_kegiatan,
                        'id_user' => $value->id_user,
                    ];
                }else{
                    $data = [
                        'id_penilaian_kegiatan' => $id,
                        'id_peserta_kegiatan' => $value->id_peserta_kegiatan,
                        'tanggal_penilaian_kegiatan' => $value->tanggal_penilaian_kegiatan,
                        'jenis_penilaian_kegiatan' => $value->jenis_penilaian_kegiatan,
                        'surah_awal_penilaian_kegiatan' => $value->surah_awal_penilaian_kegiatan,
                        'surah_akhir_penilaian_kegiatan' => $value->surah_akhir_penilaian_kegiatan,
                        'ayat_awal_penilaian_kegiatan' => $value->ayat_awal_penilaian_kegiatan,
                        'ayat_akhir_penilaian_kegiatan' => $value->ayat_akhir_penilaian_kegiatan,
                        'nilai_ghunnah_penilaian_kegiatan' => $value->nilai_ghunnah_penilaian_kegiatan,
                        'nilai_mad_penilaian_tahsin' => $value->nilai_mad_penilaian_tahsin,
                        'nilai_waqof_penilaian_tahsin' => $value->nilai_waqof_penilaian_tahsin,
                        'nilai_kelancaran_penilaian_kegiatan' => $value->nilai_kelancaran_penilaian_kegiatan,
                        'keterangan_penilaian_kegiatan' => $value->keterangan_penilaian_kegiatan,
                        'id_user' => $value->id_user,
                    ];
                }
                PenilaianModel::create($data);
            }
            if ($nilai) {
                PenilaianSmModel::where('id_user',$guru)->delete();
                return response()->json(['success' => true, 'message' => 'Berhasil Kirim Data']);
            } else {
                return response()->json(['error' => true, 'message' => 'Tidak Berhasil Kirim Data']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Terjadi kesalahan saat kirim data'.$e->getMessage()]);
        }
    }

    public function deleteDataPenilaian($id)
    {
        try {
            $nilai = PenilaianModel::where('id_penilaian_kegiatan', $id)->delete();
            if ($nilai) {
                return response()->json(['success' => true, 'message' => 'Data Berhasil Dihapus']);
            } else {
                return response()->json(['error' => true, 'message' => 'Data Tidak Berhasil Dihapus']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Terjadi kesalahan saat menghapus data', 'details' => $e->getMessage()]);
        }
    }

    public function editDataPenilaian($id)
    {

        try {
            $nilai = PenilaianModel::DataDetailPenialainKegiatan($id);
            if ($nilai) {
                return response()->json(['success' => true, 'message' => 'Data Ditemukan','data'=>$nilai]);
            } else {
                return response()->json(['error' => true, 'message' => 'Data Tidak Berhasil Ditemukan']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Terjadi kesalahan saat ambil data', 'details' => $e->getMessage()]);
        }
    }

    public function updateData($id, Request $request)
    {
        try {
            // Validate incoming request data
            if ($request->jenis_penilaian_kegiatan === 'tahfidz' || $request->jenis_penilaian_kegiatan === 'murajaah') {
                $validatedData = $request->validate([
                    'tanggal_penilaian_kegiatan' => 'required|date',
                    'jenis_penilaian_kegiatan' => 'required|string|max:255',
                    'surah_awal_penilaian_kegiatan' => 'required|string',
                    'surah_akhir_penilaian_kegiatan' => 'required|string',
                    'ayat_awal_penilaian_kegiatan' => 'required|numeric',
                    'ayat_akhir_penilaian_kegiatan' => 'required|numeric',
                    'nilai_tajwid_penilaian_kegiatan' => 'required|numeric',
                    'nilai_fasohah_penilaian_kegiatan' => 'required|numeric',
                    'nilai_kelancaran_penilaian_kegiatan' => 'required|numeric',
                    'keterangan_penilaian_kegiatan' => 'required|string',
                ]);
            } else {
                $validatedData = $request->validate([
                    'tanggal_penilaian_kegiatan' => 'required|date',
                    'jenis_penilaian_kegiatan' => 'required|string|max:255',
                    'surah_awal_penilaian_kegiatan' => 'required|string',
                    'surah_akhir_penilaian_kegiatan' => 'required|string',
                    'ayat_awal_penilaian_kegiatan' => 'required|numeric',
                    'ayat_akhir_penilaian_kegiatan' => 'required|numeric',
                    'nilai_ghunnah_penilaian_kegiatan' => 'required|numeric',
                    'nilai_mad_penilaian_tahsin' => 'required|numeric',
                    'nilai_waqof_penilaian_tahsin' => 'required|numeric',
                    'keterangan_penilaian_kegiatan' => 'required|string',
                ]);
            }
            

            // Prepare data for insertion
            if ($request->jenis_penilaian_kegiatan === 'tahfidz' || $request->jenis_penilaian_kegiatan === 'murajaah') {
                $data = [
                    'tanggal_penilaian_kegiatan' => $validatedData['tanggal_penilaian_kegiatan'],
                    'jenis_penilaian_kegiatan' => $validatedData['jenis_penilaian_kegiatan'],
                    'surah_awal_penilaian_kegiatan' => $validatedData['surah_awal_penilaian_kegiatan'],
                    'surah_akhir_penilaian_kegiatan' => $validatedData['surah_akhir_penilaian_kegiatan'],
                    'ayat_awal_penilaian_kegiatan' => $validatedData['ayat_awal_penilaian_kegiatan'],
                    'ayat_akhir_penilaian_kegiatan' => $validatedData['ayat_akhir_penilaian_kegiatan'],
                    'nilai_tajwid_penilaian_kegiatan' => $validatedData['nilai_tajwid_penilaian_kegiatan'],
                    'nilai_fasohah_penilaian_kegiatan' => $validatedData['nilai_fasohah_penilaian_kegiatan'],
                    'nilai_kelancaran_penilaian_kegiatan' => $validatedData['nilai_kelancaran_penilaian_kegiatan'],
                    'keterangan_penilaian_kegiatan' => $validatedData['keterangan_penilaian_kegiatan'],
                ];
            } else {
                $data = [
                    'tanggal_penilaian_kegiatan' => $validatedData['tanggal_penilaian_kegiatan'],
                    'jenis_penilaian_kegiatan' => $validatedData['jenis_penilaian_kegiatan'],
                    'surah_awal_penilaian_kegiatan' => $validatedData['surah_awal_penilaian_kegiatan'],
                    'surah_akhir_penilaian_kegiatan' => $validatedData['surah_akhir_penilaian_kegiatan'],
                    'ayat_awal_penilaian_kegiatan' => $validatedData['ayat_awal_penilaian_kegiatan'],
                    'ayat_akhir_penilaian_kegiatan' => $validatedData['ayat_akhir_penilaian_kegiatan'], 
                    'nilai_ghunnah_penilaian_kegiatan' => $validatedData['nilai_ghunnah_penilaian_kegiatan'],
                    'nilai_mad_penilaian_tahsin' => $validatedData['nilai_mad_penilaian_tahsin'],
                    'nilai_waqof_penilaian_tahsin' => $validatedData['nilai_waqof_penilaian_tahsin'],
                    'keterangan_penilaian_kegiatan' => $validatedData['keterangan_penilaian_kegiatan'],
                ];
            }
            

    
            // Store data into database
            $PenialaiSM = PenilaianModel::where('id_penilaian_kegiatan',$id)->update($data);
    
            // Check if data was successfully stored
            if ($PenialaiSM) {
                return response()->json(['success' => true, 'message' => 'Berhasil Edit Data', 'data' => $PenialaiSM]);
            } else {
                return response()->json(['error' => true, 'message' => 'Gagal Edit Data']);
            }
    
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during validation or data insertion
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function CetakKartu($peserta,$tahun,$jenjang,$periode){
        $pdf = new CustomPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Bukti Pembelian');

        // Remove default header/footer
        $pdf->setPrintHeader(true); // Enable custom header
        $pdf->setPrintFooter(true); // Enable custom footer

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('dejavusans', '', 14, '', true);
        $pdf->AddPage('P', 'A4');

        $pdf->SetY(30);
        // Add content
        $nilai = PenilaianModel::DataAjaxNilaiPenilaianKartu($peserta, $tahun, $periode);
        $identitas = PenilaianModel::DataAjaxIdentitasPenilaianKartu($peserta, $tahun, $jenjang, $periode);

        $viewName = ($jenjang === 'tahfidz') ? 'Guru/kegiatan/penilaian/cetak_kartu_tahfidz' : 'Guru/kegiatan/penilaian/cetak_kartu_tahsin';
        $html = view($viewName, compact('nilai', 'identitas'));

        
        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');

        // Center the image
        if (file_exists(public_path('storage/siswa/' . $identitas->foto_siswa))) {
            $imagePath = public_path('storage/siswa/' . $identitas->foto_siswa);
        } else {
            $imagePath = public_path('assets/admin/img/avatars/pas_foto.jpg');
        }        
         // Correctly define the image path
        $imageWidth = 30; // Set image width (3 cm)
        $imageHeight = 40; // Set image height (4 cm)
        $x = 150; // Calculate X position for centering
        $y = 45; // Set a fixed Y position from the top
        
        // Place the image
        $pdf->Image($imagePath, $x, $y, $imageWidth, $imageHeight, '', '', '', false, 300, '', false, false, 0, false, false, false);
           

        // Close and output PDF document
        $pdf->Output($identitas->nama_siswa.'.pdf', 'I'); // 'I' for inline display or 'D' for download
    }
        
}
