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
    <span class="kalimat_pembuka"> {{ $data['title'] }}</span>
    <br><br>
    {{-- isi --}}
    <table>
        <tr>
            <th class="label">Nama</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['nama_user']}}</td>
        </tr>
        <tr>
            <th class="label">Email</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['email_user']}}</td>
        </tr>
        <tr>
            <th class="label">No. HP</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['no_hp_user']}}</td>
        </tr>
        <tr>
            <th class="label">Alamat</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['alamat_user']}}</td>
        </tr>
        <tr>
            <th class="label">Username</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['email_user']}}</td>
        </tr>
        <?php if ($data['password_user'] != 'null') { ?>
        <tr>
            <th class="label">Password</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['password_user']}}</td>
        </tr>
        <?php } ?>
        <tr>
            <th class="label">Tanggal Daftar</th>
            <td class="colon">:</td>
            <td class="isi_label">{{$data['tanggal_daftar']}}</td>
        </tr>
    </table>
    {{-- end isi --}}
    <?php if ($data['judul'] === 'daftar') { ?>
        <br><br>
        <span class="kalimat_isi">silahkan aktifasi akun anda dengan <a href="{{$data['link']}}">klik</a> agar bisa login dengan menggunakan username dan password anda</span>
    <?php } ?>

</body>

</html>