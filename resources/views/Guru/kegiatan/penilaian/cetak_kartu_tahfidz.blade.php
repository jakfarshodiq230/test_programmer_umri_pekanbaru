<br><br>
    <table cellpadding="0">
        <tr >
            <td style="height: 10px;text-align:center;" width="100%"><b>KARTU {{strtoupper($nilai->jenis_periode)}} <br> TAHUN PELAJARAN {{ $nilai->nama_tahun_ajaran}}</b></td>
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
<div style="text-align: center;">
    <table id="tb-item" cellpadding="2" style="border-collapse: collapse; width: 100%;">
        <tr style="background-color:#a9a9a9">
            <th width="7%" style="height: 20px; text-align:center; vertical-align: middle;" rowspan="2"><strong>No.</strong></th>
            <th width="55%" style="height: 20px;text-align:center; vertical-align: middle;" rowspan="2"><strong>Penilaian</strong></th>
            <th width="55%" style="height: 20px;text-align:center; vertical-align: middle;" rowspan="2"><strong>Surah</strong></th>
            <th colspan="3" width="35%" style="height: 20px; text-align:center"><strong>Nilai</strong></th>
            <th width="55%" style="height: 20px;text-align:center; vertical-align: middle;" rowspan="2"><strong>Keterangan</strong></th>
        </tr>
        <tr style="background-color:#a9a9a9">
            <td style="height: 20px; text-align:center">Gunnah</td>
            <td style="height: 20px; text-align:center">Mad</td>
            <td style="height: 20px; text-align:center">Waqof</td>
        </tr>
        <tr>
            <td style="height: 20px; text-align:center">01</td>
            <td style="height: 20px;text-align:lefth">Kelancaran</td>
            <td style="height: 20px;text-align:lefth">Kelancaran</td>
            <td style="height: 20px;text-align:lefth">Kelancaran</td>
            <td style="height: 20px;text-align:lefth">Kelancaran</td>
            <td style="height: 20px;text-align:lefth">Kelancaran</td>
            <td style="height: 20px;text-align:lefth">Kelancaran</td>
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