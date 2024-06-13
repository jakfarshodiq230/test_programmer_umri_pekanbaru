<?php

namespace App\Exports;

use App\Models\Admin\SiswaModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiswaExport implements FromCollection
{
    protected $id;

    // Constructor to initialize the ID
    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SiswaModel::DataAll($this->id);
    }
}
