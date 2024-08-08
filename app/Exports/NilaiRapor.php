<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Admin\RaporKegiatanModel;

class NilaiRapor implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $idPeriode;
    protected $IdKelas;

    public function __construct($idPeriode, $IdKelas)
    {
        $this->idPeriode = $idPeriode;
        $this->IdKelas = $IdKelas;
    }

    public function collection()
    {
        return RaporKegiatanModel::dataExcel($this->idPeriode, $this->IdKelas);
    }

    public function headings(): array
    {
        return [
            'Periode',
            'Nama',
            'Kelas',
            'Pembimbing',
            'Rapor',
            'Hafalan Baru',
            'Hafalan Lama',
            'Nilai Tajwid Baru',
            'Nilai Fasohah Baru',
            'Nilai Kelancaran Baru',
            'Nilai Kelancaran Baru',
            'Nilai Gunnah Baru',
            'Nilai Mad Baru',
            'Nilai Waqof Baru',
            'Nilai Tajwid Lama',
            'Nilai Fasohah Lama',
            'Nilai Kelancaran Lama',
            'Nilai Kelancaran Lama',
            'Nilai Gunnah Lama',
            'Nilai Mad Lama',
            'Nilai Waqof Lama',
            'Nilai Keaktifan dan Kedisiplinan',
            'Nilai Murajaah Hafalan Mandiri',
            'Nilai Tilawah Al-Quran',
            'Nilai Tahsin Al-Quran',
            'Nilai Tarjim / Tafhim Al-Quran',
            'Nilai Hasil Jumlah Khatam Al-Quran',
        ];
    }
}
