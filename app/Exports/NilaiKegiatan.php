<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Admin\PenilaianModel;

class NilaiKegiatan implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $idPeriode;
    protected $IdKelas;
    protected $idSiswa;

    public function __construct($idPeriode, $IdKelas, $idSiswa)
    {
        $this->idPeriode = $idPeriode;
        $this->IdKelas = $IdKelas;
        $this->idSiswa = $idSiswa;
    }

    public function collection()
    {
        return PenilaianModel::dataExcel($this->idPeriode, $this->IdKelas, $this->idSiswa);
    }

    public function headings(): array
    {
        return [
            'Periode',
            'Nama',
            'Kelas',
            'Pembimbing',
            'Rapor',
            'Surah Baru',
            'Ayat Baru',
            'Surah Lama',
            'Ayat Lama',
            'Nilai Tajwid',
            'Nilai Fasohah',
            'Nilai Kelancaran',
            'Nilai Gunnah',
            'Nilai Mad',
            'Nilai Waqof',
            'Keterangan',
            'Tanggal Penilaian',
        ];
    }
}
