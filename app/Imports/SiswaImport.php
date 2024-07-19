<?php

namespace App\Imports;

use App\Models\Admin\SiswaModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $tanggal = now()->format('dmy');
        $nomorUrut = SiswaModel::whereDate('created_at', now()->toDateString())->count() + 1;
        $id = 'SW' . '-' . $tanggal . '-' . $nomorUrut;
        return new SiswaModel([
            'id_siswa' => $id,
            'nisn_siswa' => $row['nisn_siswa'],
            'nama_siswa' => $row['nama_siswa'],
            'tanggal_lahir_siswa' => $row['tanggal_lahir_siswa'],
            'tempat_lahir_siswa' => $row['tempat_lahir_siswa'],
            'jenis_kelamin_siswa' => $row['jenis_kelamin_siswa'],
            'no_hp_siswa' => $row['no_hp_siswa'],
            'email_siswa' => $row['email_siswa'],
            'tahun_masuk_siswa' => $row['tahun_masuk_siswa'],
            'status_siswa' => '0',
            'id_user' => session('user')['id_user'],
        ]);
    }
}
