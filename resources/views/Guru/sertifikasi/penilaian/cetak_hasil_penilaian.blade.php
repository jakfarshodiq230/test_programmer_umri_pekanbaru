<br><br><br>
    <table cellpadding="0">
        <tr >
            <td style="height: 10px;text-align:center;" width="100%"><b>HASIL UJIAN SERTIFIKASI JUZ {{strtoupper($identitas->juz_periode)}} <br> TAHUN PELAJARAN {{ $identitas->nama_tahun_ajaran}}</b></td>
        </tr>
    </table>
<br><br>
<!-- identitas -->
 <div>
    <table cellpadding="0" >
        <tr>
            <th width="15%" style="height: 20px;";>Nama</th>
            <th width="60%" style="height: 20px;";>: <b> {{ ucwords($identitas->nama_siswa) }}</b></th>
        </tr>
        <tr>
            <th width="15%" style="height: 20px;";>Program</th>
            <th width="60%" style="height: 20px;";>: <b> {{ ucwords($identitas->judul_periode) }}</b></th>
        </tr>
        <tr>
            <th width="15%" style="height: 20px;";>Kelas</th>
            <th width="60%" style="height: 20px;";>: <b> {{ $identitas->nama_kelas }}</b></th>
        </tr>
        <tr>
            <th width="15%" style="height: 20px;";>Periode</th>
            <th width="60%" style="height: 20px;";>: <b> {{ $identitas->nama_tahun_ajaran}}</b></th>
        </tr>
    </table>
 </div>
<div style="text-align: center; margin-top:0px;">
    <table id="tb-item" cellpadding="2" style="border-collapse: collapse; width: 100%;">
        <tr style="background-color:#a9a9a9">
            <th width="7%" style="height: 20px; text-align:center; vertical-align: middle;" ><strong>No.</strong></th>
            <th width="10%" style="height: 20px;text-align:center; vertical-align: middle;" ><strong>Sesi Ujian</strong></th>
            <th width="20%" style="height: 20px;text-align:center; vertical-align: middle;" ><strong>Surah</strong></th>
            <th width="42%" style="height: 20px;text-align:center; vertical-align: middle;" ><strong>Koreksi dan Saran</strong></th>
            <th width="10%" style="height: 20px;text-align:center; vertical-align: middle;" ><strong>Nilai</strong></th>
            <th width="10%" style="height: 20px;text-align:center; vertical-align: middle;" ><strong>Keterangan</strong></th>
        </tr>
        <?php 
            $no = 0; 
            $surah_awal ="";
            $surah_akhir ="";
            foreach ($nilai as $key => $value) :  
            $no = $no +1; 
            $surah_awal = ucwords($value->SurahMulai).'['.$value->ayat_awal.']';
            $surah_akhir = ucwords($value->SurahAkhir).'['.$value->ayat_akhir.']';
        ?>
        <tr>
            <td style="height: 30px; text-align:center; padding-top: 10px; padding-bottom: 10px;">{{ $no; }}</td>
            <td style="height: 30px;text-align:center; padding-top: 10px; padding-bottom: 10px;">SESI KE- {{ $no }}</td>
            <td style="height: 30px;text-align:lefth; padding-top: 10px; padding-bottom: 10px;">{{ $surah_akhir }} s/d {{ $surah_akhir }} </td>
            <td style="height: 30px;text-align:lefth; padding-top: 10px; padding-bottom: 10px;">{{ ucwords($value->koreksi_sertifikasi) }}</td>
            <td style="height: 30px;text-align:center; padding-top: 10px; padding-bottom: 10px;">{{ ucwords($value->nilai_sertifikasi) }}</td>
            <td style="height: 30px;text-align:center; padding-top: 10px; padding-bottom: 10px;">BAIK</td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br><br><br>
    <table cellpadding="2">
        <tr>
            <th style="width: 30%; height: 20px; text-align: center;">Mengetahui<br> Kepala Madrasah</th>
            <th style="width: 40%; height: 20px; text-align: center;"></th>
            <th style="width: 30%; height: 20px; text-align: center;">Pekanbaru,....,...............,20.....<br> Pembimbing, </th>
        </tr>
        <tr>
            <td colspan="3" style="height: 20px;">
                <br><br><br><br><br>
            </td>
        </tr>
        <tr>
            <th style="height: 20px; text-align: center;">______________________________</th>
            <th style="height: 20px; text-align: center;"></th>
            <th style="height: 20px; text-align: center;"><b>{{ $identitas->nama_guru}}</b></th>
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