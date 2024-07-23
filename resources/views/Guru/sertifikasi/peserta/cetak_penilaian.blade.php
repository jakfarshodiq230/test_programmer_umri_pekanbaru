<br><br><br><br><br><br>
    <table cellpadding="0">
        <tr >
            <td style="height: 40px;text-align:center;" width="100%"><b>HASIL UJIAN SERTIFIKASI JUZ {{strtoupper($identitas->juz_periode)}} <br> TAHUN PELAJARAN {{ $identitas->nama_tahun_ajaran}}</b></td>
        </tr>
    </table>
<br><br>
<!-- identitas -->
 <div>
    <table cellpadding="0" >
        <tr>
            <th width="15%" style="height: 20px;" >Nama</th>
            <th width="60%" style="height: 20px;" >: <b> {{ ucwords($identitas->nama_siswa) }}</b></th>
            <th width="10%" style="height: 20px;" >Sertifikasi</th>
            <th width="40%" style="height: 20px;" >: <b> Juz {{ $identitas->juz_periode }}</b></th>
        </tr>
        <tr>
            <th width="15%" style="height: 20px;" >Kelas/Program</th>
            <th width="60%" style="height: 20px;" >: <b> {{ $identitas->nama_kelas.' / '.ucwords($identitas->jenis_periode) }}</b></th>
            <th width="10%" style="height: 20px;" >Periode</th>
            <th width="40%" style="height: 20px;" >: <b> {{ $identitas->nama_tahun_ajaran}}</b></th>
        </tr>
        <tr>
            <th width="15%" style="height: 20px;" >Pembimbing</th>
            <th width="60%" style="height: 20px;" >: <b> {{ $identitas->nama_guru }}</b></th>
            <th width="10%" style="height: 20px;" >Penguji</th>
            <th width="40%" style="height: 20px;" >: <b> {{ $identitas->nama_tahun_ajaran}}</b></th>
        </tr>
    </table>
 </div>
<div style="text-align: center; margin-top:0px;">
    <table id="tb-item" cellpadding="2" style="border-collapse: collapse; width: 100%;">
        <tr style="background-color:#a9a9a9">
            <th width="7%" style="height: 30px; text-align:center; vertical-align: middle;" ><strong>No.</strong></th>
            <th width="10%" style="height: 30px;text-align:center; vertical-align: middle;" ><strong>Sesi Ujian</strong></th>
            <th width="20%" style="height: 30px;text-align:center; vertical-align: middle;" ><strong>Surah</strong></th>
            <th width="42%" style="height: 30px;text-align:center; vertical-align: middle;" ><strong>Koreksi dan Saran</strong></th>
            <th width="10%" style="height: 30px;text-align:center; vertical-align: middle;" ><strong>Nilai</strong></th>
            <th width="10%" style="height: 30px;text-align:center; vertical-align: middle;" ><strong>Keterangan</strong></th>
        </tr>
        <?php 
            if (!function_exists('cekKelulusan')) {
                function cekKelulusan($nilai) {
                    if ($nilai >= 0 && $nilai <= 65) {
                        return 'TIDAK LULUS';
                    } else if ($nilai > 65 && $nilai <= 100) {
                        return 'LULUS';
                    } else {
                        return 'Nilai tidak valid';
                    }
                }
            }
            $no = 0; 
            $surah_awal ="";
            $surah_akhir ="";
            $total = 0;
            $total_ahir = 0;
            foreach ($nilai as $key => $value) :  
            $no = $no +1; 
            $surah_awal = ucwords($value->SurahMulai).'['.$value->ayat_awal.']';
            $surah_akhir = ucwords($value->SurahAkhir).'['.$value->ayat_akhir.']';
            $total = $total + $value->nilai_sertifikasi;
        ?>
        <tr>
            <td style="height: 30px; text-align:center; padding-top: 10px; padding-bottom: 10px;">{{ $no; }}</td>
            <td style="height: 30px;text-align:center; padding-top: 10px; padding-bottom: 10px;">SESI KE- {{ $no }}</td>
            <td style="height: 30px;text-align:lefth; padding-top: 10px; padding-bottom: 10px;">{{ $surah_akhir }} s/d {{ $surah_akhir }} </td>
            <td style="height: 30px;text-align:lefth; padding-top: 10px; padding-bottom: 10px;">{{ ucwords($value->koreksi_sertifikasi) }}</td>
            <td style="height: 30px;text-align:center; padding-top: 10px; padding-bottom: 10px;">{{ $value->nilai_sertifikasi }}</td>
            <td style="height: 30px;text-align:center; padding-top: 10px; padding-bottom: 10px;">{{cekKelulusan($value->nilai_sertifikasi)}}</td>
        </tr>
        <?php 
                endforeach; 
                $total_ahir = $total / $identitas->sesi_periode;
        ?>
        <tr style="background-color:#d3d3d3;">
            <td colspan="4" style="height: 30px; text-align:center; padding-top: 10px; ">Dengan INI Dinyatakan <strong>{{cekKelulusan($total_ahir)}}</strong> Sertifikasi Hafalan Juz {{ $identitas->juz_periode }}</td>
            <td style="height: 30px; text-align:center; padding-top: 10px;"><strong>{{$total_ahir}}</strong></td>
            <td style="height: 30px; text-align:center; padding-top: 10px;"><strong>{{cekKelulusan($total_ahir)}}</strong></td>
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