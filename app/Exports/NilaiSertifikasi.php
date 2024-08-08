<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Admin\PesertaSertifikasiModel;

class NilaiSertifikasi implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $idPeriode;

    public function __construct($idPeriode)
    {
        $this->idPeriode = $idPeriode;
    }

    public function collection()
    {
        return PesertaSertifikasiModel::dataExcel($this->idPeriode);
    }

    public function headings(): array
    {
        return [
            'Periode',
            'Nama',
            'Kelas',
            'Pembimbing',
            'Penguji',
            'Sertifikasi',
            'Surah',
            'Nilai',
            'Koreksi dan Saran',
        ];
    }
}
