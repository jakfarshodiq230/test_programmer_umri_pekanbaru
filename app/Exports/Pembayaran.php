<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Admin\BayarModel;

class Pembayaran implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $Awal;
    protected $Akhir;

    public function __construct($Awal, $Akhir)
    {
        $this->Awal = $Awal;
        $this->Akhir = $Akhir;
    }

    public function collection()
    {
        return BayarModel::DataExcel($this->Awal, $this->Akhir);
    }

    public function headings(): array
    {
        return [
            'NIM',
            'NAMA',
            'TANGGAL',
            'PEMBAYARAN',
            'JUMLAH BAYAR',
        ];
    }
}
