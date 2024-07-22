
<?php
if (!function_exists('getRating')) {
    function getRating($rata_baru) {
        if ($rata_baru >= 96 && $rata_baru <= 100) {
            return "Sangat Baik";
        } elseif ($rata_baru >= 86 && $rata_baru <= 95) {
            return "Baik";
        } elseif ($rata_baru >= 80 && $rata_baru <= 85) {
            return "Cukup";
        } else {
            return "Kurang";
        }
    }
}


?>
<br><br>
    <table cellpadding="0">
        <tr >
            <td style="height: 10px;text-align:center;" width="100%"><b>LAPORAN HASIL BELAJAR {{strtoupper($nilai->jenis_periode)}} <br> TAHUN PELAJARAN {{ $nilai->nama_tahun_ajaran}}</b></td>
        </tr>
    </table>
<br><br>
<!-- identitas -->
<table cellpadding="2" >
    <tr>
        <th width="15%">Nama</th>
        <th width="50%">: <b> {{ ucwords($nilai->nama_siswa) }}</b></th>
        <th width="10%">Semester</th>
        <th width="40%">: <b> {{ ucwords($nilai->jenis_kegiatan) }}</b></th>
    </tr>
    <tr>
        <th width="15%">Kelas/Program</th>
        <th width="50%">: <b> {{ $nilai->nama_kelas.' / '.ucwords($nilai->jenis_periode) }}</b></th>
        <th width="10%">Periode</th>
        <th width="40%">: <b> {{ $nilai->nama_tahun_ajaran}}</b></th>
    </tr>
</table>
<br>
<!-- end tabel -->
<span>Hafalan Baru</span>
<div style="text-align: center;">
    <table id="tb-item" cellpadding="2" style="border-collapse: collapse; width: 100%;">
        <tr style="background-color:#a9a9a9">
            <th width="7%" style="height: 20px; text-align:center; vertical-align: middle;" rowspan="2"><strong>No.</strong></th>
            <th width="55%" style="height: 20px;text-align:center; vertical-align: middle;" rowspan="2"><strong>Materi/Aspek Penilaian</strong></th>
            <th colspan="2" width="35%" style="height: 20px; text-align:center"><strong>Nilai</strong></th>
        </tr>
        <tr style="background-color:#a9a9a9">
            <td style="height: 20px; text-align:center">Angka</td>
            <td style="height: 20px; text-align:center">Prediket</td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center">01</td>
            <td style="height: 20px;text-align:lefth">Kelancaran</td>
            <td style="height: 20px; text-align:center">{{ $nilai->n_k_baru === null ? 0 : $nilai->n_k_baru}}</td>
            <td style="height: 20px;text-align:center"><?= getRating($nilai->n_k_baru) ?></td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center">02</td>
            <td style="height: 20px;text-align:lefth">Fashohah</td>
            <td style="height: 20px; text-align:center">{{ $nilai->n_f_baru === null ? 0 : $nilai->n_f_baru}}</td>
            <td style="height: 20px;text-align:center"><?= getRating($nilai->n_f_baru) ?></td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center">03</td>
            <td style="height: 20px;text-align:lefth">Tajwid</td>
            <td style="height: 20px; text-align:center">{{ $nilai->n_j_baru === null ? 0 : $nilai->n_j_baru}}</td>
            <td style="height: 20px;text-align:center"><?= getRating($nilai->n_j_baru) ?></td>
        </tr>
        <?php
            $rata_baru = 0;
            $rata_baru = floor(($nilai->n_k_baru + $nilai->n_f_baru + $nilai->n_j_baru) / 3);
        ?>
        <tr style="border:1px solid #000">
            <td colspan="2" style="height: 20px; text-align:center"><strong>Nilai Rata-Rata</strong></td>
            <td style="height: 20px;text-align:center"><b>{{ $rata_baru }}</b></td>
            <td style="height: 20px;text-align:center"><b><?= getRating($rata_baru) ?></b></td>
        </tr>
    </table>
    <table id="tb-item" cellpadding="2">
    <?php
            if (!function_exists('formatHafalan')) {
                function formatHafalan($nilai, $type) {
                    if (!is_array($nilai) && !is_object($nilai)) {
                        return ''; // Handle unsupported type
                    }

                    if ($type === 'baru') {
                        $awal_surah = isset($nilai['awal_surah_baru']) ? ($nilai['awal_ayat_baru'] === 0 ? $nilai['awal_surah_baru'] : $nilai['awal_surah_baru'] . '[' . $nilai['awal_ayat_baru'] . ']') : '-';
                        $akhir_surah = isset($nilai['akhir_surah_baru']) ? ($nilai['akhir_ayat_baru'] === 0 ? $nilai['akhir_surah_baru'] : $nilai['akhir_surah_baru'] . '[' . $nilai['akhir_ayat_baru'] . ']') : '-';
                    } elseif ($type === 'lama') {
                        $awal_surah = isset($nilai['awal_surah_lama']) ? ($nilai['awal_ayat_lama'] === 0 ? $nilai['awal_surah_lama'] : $nilai['awal_surah_lama'] . '[' . $nilai['awal_ayat_lama'] . ']') : '-';
                        $akhir_surah = isset($nilai['akhir_surah_lama']) ? ($nilai['akhir_ayat_lama'] === 0 ? $nilai['akhir_surah_lama'] : $nilai['akhir_surah_lama'] . '[' . $nilai['akhir_ayat_lama'] . ']') : '-';
                    } else {
                        return ''; // Handle unsupported type
                    }
                
                    $ktr = $awal_surah . ' s/d ' . $akhir_surah;
                
                    return $ktr;
                }
            }

            // Example usage with $row_baru and $row_lama
            $row_baru = [
                'awal_ayat_baru' => isset($nilai->awal_ayat_baru) ? $nilai->awal_ayat_baru : null,
                'awal_surah_baru' => isset($nilai->awal_surah_baru) ? $nilai->awal_surah_baru : null,
                'akhir_ayat_baru' => isset($nilai->akhir_ayat_baru) ? $nilai->akhir_ayat_baru : null,
                'akhir_surah_baru' => isset($nilai->akhir_surah_baru) ? $nilai->akhir_surah_baru : null,
            ];

            $row_lama = [
                'awal_ayat_lama' => isset($nilai->awal_ayat_lama) ? $nilai->awal_ayat_lama : null,
                'awal_surah_lama' => isset($nilai->awal_surah_lama) ? $nilai->awal_surah_lama : null,
                'akhir_ayat_lama' => isset($nilai->akhir_ayat_lama) ? $nilai->akhir_ayat_lama : null,
                'akhir_surah_lama' => isset($nilai->akhir_surah_lama) ? $nilai->akhir_surah_lama : null,
            ];

            // Menggunakan fungsi formatHafalan untuk mendapatkan teks format hafalan
            $teks_baru = formatHafalan($row_baru, 'baru');
            $teks_lama = formatHafalan($row_lama, 'lama');
        ?>
        <tr >
            <td style="height: 20px;text-align:lefth; background-color:#a9a9a9" width="20%">Surah</td>
            <td style="height: 20px; text-align:lefth" width="77%"> {{ $teks_baru}}</td>
        </tr>
    </table>
</div>
<span>Hafalan Lama</span>
<div style="text-align: center;">
    <table id="tb-item" cellpadding="2">
        <tr style="background-color:#a9a9a9">
            <th width="7%" style="height: 20px; text-align:center" rowspan="2"><strong>No.</strong></th>
            <th width="55%" style="height: 20px;text-align:center" rowspan="2"><strong>Materi/Aspek Penilaian</strong></th>
            <th colspan="2" width="35%" style="height: 20px; text-align:center"><strong>Nilai</strong></th>
        </tr>
        <tr style="background-color:#a9a9a9">
            <td style="height: 20px; text-align:center">Angka</td>
            <td style="height: 20px; text-align:center">Prediket</td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center">01</td>
            <td style="height: 20px;text-align:lefth">Kelancaran</td>
            <td style="height: 20px; text-align:center">{{ $nilai->n_k_lama === null ? 0 : $nilai->n_k_lama}}</td>
            <td style="height: 20px;text-align:center"><?= getRating($nilai->n_k_lama) ?></td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center">02</td>
            <td style="height: 20px;text-align:lefth">Fashohah</td>
            <td style="height: 20px; text-align:center">{{ $nilai->n_f_lama === null ? 0 : $nilai->n_f_lama}}</td>
            <td style="height: 20px;text-align:center"><?= getRating($nilai->n_f_lama) ?></td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center">03</td>
            <td style="height: 20px;text-align:lefth">Tajwid</td>
            <td style="height: 20px; text-align:center">{{ $nilai->n_j_lama === null ? 0 : $nilai->n_j_lama}}</td>
            <td style="height: 20px; text-align:center"><?= getRating($nilai->n_j_lama) ?></td>
        </tr>
        <?php
            $rata_lama = 0;
            $rata_lama= floor(($nilai->n_k_lama+$nilai->n_f_lama+$nilai->n_j_lama)/3);
        ?>
        <tr style="border:1px solid #000">
            <td colspan="2" style="height: 20px; text-align:center"><strong>Nilai Rata-Rata</strong></td>
            <td style="height: 20px;text-align:center"><b>{{ $rata_lama }}</b></td>
            <td style="height: 20px;text-align:center"><b><?= getRating($rata_lama) ?></b></td>
        </tr>
    </table>
    <table id="tb-item" cellpadding="2">
        <tr >
            <td style="height: 20px;text-align:lefth; background-color:#a9a9a9" width="20%">Surah</td>
            <td style="height: 20px; text-align:lefth" width="77%"> {{ $teks_lama }}</td>
        </tr>
    </table>
    <br><br>
    <table id="tb-item" cellpadding="2">
        <tr style="background-color:#a9a9a9">
            <th colspan="2" width="62%" style="height: 20px;text-align:center" ><strong>Pengembangan Diri</strong></th>
            <th  width="35%" style="height: 20px; text-align:center"><strong>Prediket</strong></th>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center" width="5%">01</td>
            <td style="height: 20px;text-align:lefth" width="57%">Keaktifan dan Kedisiplinan</td>
            <td style="height: 20px; text-align:center"><?= getRating($nilai->n_k_p) ?></td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center" width="5%">02</td>
            <td style="height: 20px;text-align:lefth" width="57%">Murojaah Hafalan Mandiri</td>
            <td style="height: 20px; text-align:center"><?= getRating($nilai->n_m_p) ?></td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center" width="5%">03</td>
            <td style="height: 20px;text-align:lefth" width="57%">Tilawah Al-Quran Mandiri</td>
            <td style="height: 20px; text-align:center"><?= getRating($nilai->n_t_p) ?></td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center" width="5%">04</td>
            <td style="height: 20px;text-align:lefth" width="57%">Tahsin Al-Qur'an</td>
            <td style="height: 20px; text-align:center"><?= getRating($nilai->n_th_p) ?></td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center" width="5%">05</td>
            <td style="height: 20px;text-align:lefth" width="57%">Tarjim / Tafhim Al-Quran</td>
            <td style="height: 20px; text-align:center"><?= getRating($nilai->n_tf_p) ?></td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center" width="5%">06</td>
            <td style="height: 20px;text-align:lefth" width="57%">Jumlah Khatam Al-Qur'an</td>
            <td style="height: 20px; text-align:center"><?= getRating($nilai->n_jk_p) ?></td>
        </tr>
    </table>

    <table id="tb-item" cellpadding="2">
        <tr >
            <td style="height: 20px;text-align:center; background-color:#a9a9a9" width="97%"><b>Pesan Pembimbing</b></td>
        </tr>
        <tr >
            <td style="height: 20px;text-align:center;" width="97%">{{ ucwords($nilai->pesan_periode) }}</td>
        </tr>
    </table>
    <br><br>
    <table cellpadding="2">
        <tr>
            <th style="width: 30%; height: 20px; text-align: center;">Mengetahui<br> Kepala Madrasah</th>
            <th style="width: 40%; height: 20px; text-align: center;"></th>
            <?php $tanggal_periode = isset($nilai->tggl_periode) ? strftime('%d %B %Y', strtotime($nilai->tggl_periode)) : ''; ?>
            <th style="width: 30%; height: 20px; text-align: center;">Pekanbaru, {{ $tanggal_periode }}<br> Pembimbing, </th>
        </tr>
        <tr>
            <td colspan="3" style="height: 20px;">
                <br><br><br><br><br>
            </td>
        </tr>
        <tr>
            <th style="height: 20px; text-align: center;"><b>{{ $nilai->tanggungjawab_periode}}</b></th>
            <th style="height: 20px; text-align: center;"></th>
            <th style="height: 20px; text-align: center;"><b>{{ $nilai->nama_guru}}</b></th>
        </tr>
    </table>

</div>

<style>
    p, span, table { font-size: 12px}
    table { width: 100%; border: 1px solid #dee2e6;  }
    table#tb-item tr th, table#tb-item tr td {
        border:1px solid #000
    }
    
</style>