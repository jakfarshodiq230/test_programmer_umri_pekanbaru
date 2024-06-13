<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: helvetica;
        }

        .kop_surat {
            text-align: center;
            font-size: 14pt;
            text-decoration: underline;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kalimat_isi,
        .kalimat_pembuka,
        .kalimat_penutup {
            text-align: justify;
            font-size: 12pt;
        }

        .kelulusan {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
        }

        .nomor {
            margin-top: -1000px !important;
            text-align: center !important;
            font-size: 13pt;
            font-weight: bold;
        }

        .label {
            width: 35%;
            font-size: 10pt;
            text-align: left;
        }

        .colon {
            width: 5%;
            text-align: center;
        }

        .isi_label {
            width: 65%;
            font-size: 10pt;
        }


        .tandatangan {
            font-size: 12pt;
            text-align: right;
        }

        .namakepsek {
            font-size: 12pt;
            text-align: right;
        }

        .catatan {
            text-align: left;
            font-size: 8pt;
            font-style: italic;
            color: brown;
        }
    </style>
</head>

<body>
    <span class="kalimat_pembuka">PASSWORD AKUN APKIS BARU</span>
    <br><br>
    {{-- isi --}}
    <table>
        <tr>
            <th class="label">Kode Pendaftaran</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['id_pelanggan']}}</td>
        </tr>
        <tr>
            <th class="label">Nama</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['nama_pelanggan']}}</td>
        </tr>
        <tr>
            <th class="label">Email</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['email_pelanggan']}}</td>
        </tr>
        <tr>
            <th class="label">No. HP</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['no_hp_usaha']}}</td>
        </tr>
        <tr>
            <th class="label">Username</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['email_pelanggan']}}</td>
        </tr>
        <tr>
            <th class="label">Password</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['password']}}</td>
        </tr>
        
    </table>
    {{-- end isi --}}
    <br><br>
    <span class="kalimat_isi">silahkan login dengan menggunakan username dan password anda, terimakasih sudah mendaftar 
        dan jika ada kendala silahkan hubungi melalui Email: shodiqsolution@gmail.com</span>

</body>

</html>
