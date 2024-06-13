<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin\SiswaModel;

class CekLulus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id'); // Ambil ID dari rute jika diperlukan
        $nisn = $request->input('nisn');
        $nomor_ujian = $request->input('nomor_ujian');

        // Cek apakah NISN dan nomor ujian ada di tabel mahasiswa dan sudah lulus
        $Siswa = SiswaModel::where('id_periode', $id)
                            ->where('nomor_ujian_siswa', $nomor_ujian)
                            ->where('nisn', $nisn)
                            ->first();

        if (!$Siswa) {
            return redirect('/cari_data');
        }

        return $next($request);
    }
}
