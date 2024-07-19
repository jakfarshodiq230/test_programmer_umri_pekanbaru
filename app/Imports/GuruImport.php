<?php

namespace App\Imports;

use App\Models\Admin\GuruModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $tanggal = now()->format('dmy');
        $nomorUrut = GuruModel::whereDate('created_at', now()->toDateString())->count() + 1;
        $id = 'GR' . '-' . $tanggal . '-' . $nomorUrut;
        return new GuruModel([
            'id_guru' => $id,
            'nik_guru' => $row['nik_guru'],
            'nama_guru' => $row['nama_guru'],
            'tanggal_lahir_guru' => $row['tanggal_lahir_guru'],
            'tempat_lahir_guru' => $row['tempat_lahir_guru'],
            'jenis_kelamin_guru' => $row['jenis_kelamin_guru'],
            'no_hp_guru' => $row['no_hp_guru'],
            'email_guru' => $row['email_guru'],
            'status_guru' => '0',
            'id_user' => session('user')['id_user'],
        ]);
    }
}
