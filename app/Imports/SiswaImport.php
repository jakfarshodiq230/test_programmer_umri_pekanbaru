<?php

namespace App\Imports;

use App\Models\Admin\SiswaModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    private $importedCount = 0;
    private $skippedCount = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if the nisn already exists in the database
        $existingSiswa = SiswaModel::where('nisn', $row['nisn'])->first();

        if ($existingSiswa) {
            $this->skippedCount++;
            return null;
        }
        $this->importedCount++;
        $tanggal = now()->format('dmY');
        // If the nisn does not exist, create a new record
        return new SiswaModel([
            'nisn' => $row['nisn'],
            'id_periode' => $row['id_periode'],
            'nomor_ujian_siswa' => $row['nomor_ujian_siswa'],
            'nomor_surat' => $row['nomor_surat'],
            'tanggal_surat' => $row['tanggal_surat'], 
            'tandat_angan_surat' => $row['tandat_angan_surat'],
            'nama_siswa' => $row['nama_siswa'],
            'orang_tua' => $row['orang_tua'],
            'alamat_siswa' => $row['alamat_siswa'],
            'email_siswa' => $row['email_siswa'],
            'no_hp_siswa' => $row['no_hp_siswa'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir_siswa' => $row['tanggal_lahir_siswa'],
            'jenis_kelamin_siswa' => $row['jenis_kelamin_siswa'],
            'keterangan_siswa' => $row['keterangan_siswa'],
            'kode_verifikasi_siswa' => $tanggal.$row['nisn'].mt_rand(100000, 999999),
        ]);

    }
     /**
     * Get the total imported count.
     *
     * @return int
     */
    public function getImportedCount()
    {
        return $this->importedCount;
    }

    /**
     * Get the total skipped count.
     *
     * @return int
     */
    public function getSkippedCount()
    {
        return $this->skippedCount;
    }
}
