<html>

<head>
    <style>
        body {
            font-family: helvetica;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        tr,
        th {
            height: 25px;
            padding: 10px;
            text-align: left;
            font-size: 15px;
            margin-bottom: 1px;
            border-bottom: 1px solid #0a0a0a;
            border-top: 1px solid #0a0a0a;
            /* Set border-bottom to dashed */
        }

        td {
            margin-top: 5px;
            height: 20px;
            padding: 15px;
            text-align: left;
            font-size: 13px;
            //border-bottom: 1px dashed #0a0a0a;
            /* Set border-bottom to dashed */
        }
    </style>
</head>

<body>
    <h2 style="text-align: center; margin-top: -25px;">PEMBELIAN</h2>
    <table>
        <tr style="background-color: beige;">
            <th style="padding: 5px;">Nomor</th>
            <th>Tanggal</th>
            <th>Berat Normal</th>
            <th>Berat Potongan</th>
            <th>Berat Bersih</th>
            <th style="text-align: right;">Pendapatan</th>
        </tr>
        @php
            $nomor = 0;
            $total_pembelian = 0;
        @endphp
        @foreach ($DataPembelian as $item)
            @php
                $nomor++;
                $total_pembelian = $total_pembelian + $item->nominal_rincian_pembelian;
            @endphp
            <tr>
                <td style="padding-top: 50px;"><?= $nomor ?></td>
                <td style="padding-top: 50px;"><?= date('d F Y', strtotime($item->tanggal_transaksi)) ?></td>
                <td style="padding-top: 50px;"><?= $item->berat_normal . ' Kg' ?></td>
                <td style="padding-top: 50px;"><?= $item->berat_potong . ' Kg' ?></td>
                <td style="padding-top: 50px;"><?= $item->berat_bersih . ' Kg' ?></td>
                <td style="padding-top: 50px; text-align: right;">
                    <?= 'Rp. ' . number_format($item->nominal_rincian_pembelian, 0, ',', '.') ?></td>
            </tr>
        @endforeach
        <tr style="height: 30%; background-color:beige; ">
            <td colspan="5"
                style="text-align:right; border-top: 1px dashed #0a0a0a; border-bottom: 1px dashed #0a0a0a">
                <strong>Total:</strong></td>
            <td style="text-align: right; border-top: 1px dashed #0a0a0a; border-bottom: 1px dashed #0a0a0a">
                <strong><?= 'Rp. ' . number_format($total_pembelian, 0, ',', '.') ?></strong></td>
        </tr>
    </table>
    <h2 style="text-align: center; margin-top: -25px;">PENJUALAN</h2>
    <table>
        <tr style="background-color: beige;">
            <th style="padding: 5px;">Nomor</th>
            <th>Tanggal</th>
            <th>Berat Normal</th>
            <th>Berat Potongan</th>
            <th>Berat Bersih</th>
            <th style="text-align: right;">Pendapatan</th>
        </tr>
        @php
            $nomor = 0;
            $total_penjualan = 0;
        @endphp
        @foreach ($DataPenjualan as $item)
            @php
                $nomor++;
                $total_penjualan = $total_penjualan + $item->nominal_rincian_penjualan;
            @endphp
            <tr>
                <td style="padding-top: 50px;"><?= $nomor ?></td>
                <td style="padding-top: 50px;"><?= date('d F Y', strtotime($item->tggl_rincian_penjualan)) ?></td>
                <td style="padding-top: 50px;"><?= $item->berat_normal . ' Kg' ?></td>
                <td style="padding-top: 50px;"><?= $item->berat_potongan . ' Kg' ?></td>
                <td style="padding-top: 50px;"><?= $item->berat_bersih . ' Kg' ?></td>
                <td style="padding-top: 50px; text-align: right;">
                    <?= 'Rp. ' . number_format($item->nominal_rincian_penjualan, 0, ',', '.') ?></td>
            </tr>
        @endforeach
        <tr style="height: 30%; background-color:beige; ">
            <td colspan="5"
                style="text-align:right; border-top: 1px dashed #0a0a0a; border-bottom: 1px dashed #0a0a0a">
                <strong>Total:</strong></td>
            <td style="text-align: right; border-top: 1px dashed #0a0a0a; border-bottom: 1px dashed #0a0a0a">
                <strong><?= 'Rp. ' . number_format($total_penjualan, 0, ',', '.') ?></strong></td>
        </tr>
    </table>
    <h2 style="text-align: center; margin-top: -25px;">PENGELUARAN</h2>
    <table>
        <tr style="background-color: beige;">
            <th style="padding: 5px;">Nomor</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th style="text-align: right;">Nominal</th>
        </tr>
        @php
            $nomor = 0;
            $total_pengeluaran = 0;
        @endphp
        @foreach ($DataPengeluaran as $item)
            @php
                $nomor++;
                $total_pengeluaran = $total_pengeluaran + $item->nominal_pengeluaran;
            @endphp
            <tr>
                <td style="padding-top: 50px;"><?= $nomor ?></td>
                <td style="padding-top: 50px;"><?= date('d F Y', strtotime($item->tgl_pengeluaran)) ?></td>
                <td style="padding-top: 50px;"><?= $item->keterangan_pengeluaran ?></td>
                <td style="padding-top: 50px; text-align: right;">
                    <?= 'Rp. ' . number_format($item->nominal_pengeluaran, 0, ',', '.') ?></td>
            </tr>
        @endforeach
        <tr style="height: 30%; background-color:beige; ">
            <td colspan="3"
                style="text-align:right; border-top: 1px dashed #0a0a0a; border-bottom: 1px dashed #0a0a0a">
                <strong>Total:</strong></td>
            <td style="text-align: right; border-top: 1px dashed #0a0a0a; border-bottom: 1px dashed #0a0a0a">
                <strong><?= 'Rp. ' . number_format($total_pengeluaran, 0, ',', '.') ?></strong></td>
        </tr>
    </table>
    <div style="text-align: right;">
        <div style="margin-bottom: 10px;">
            <strong>Pembelian:</strong> <span style="margin-left: 10px;"><strong>{{ 'Rp. ' . number_format($total_pembelian)}}</strong></span>
        </div>
        <div style="margin-bottom: 10px;">
            <strong>Penjualan:</strong> <span style="margin-left: 10px;"><strong>{{ 'Rp. ' . number_format($total_penjualan)}}</strong></span>
        </div>
        <div style="margin-bottom: 10px;">
            <strong>Pendapatan:</strong> <span style="margin-left: 10px;"><strong>{{ 'Rp. ' . number_format($total_penjualan-$total_pembelian)}}</strong></span>
        </div>
        <div>
            <strong>Pengeluaran:</strong> <span style="margin-left: 10px;"><strong>{{ 'Rp. ' . number_format($total_pengeluaran)}}</strong></span>
        </div>
        @php
           $total_untung = $total_penjualan-$total_pembelian;
           $pendapatan_bersih =  $total_untung-$total_pengeluaran;
        @endphp
        <div>
            <strong>Pendapatan Bersih:</strong> <span style="margin-left: 10px;"><strong>{{ 'Rp. ' . number_format($pendapatan_bersih)}}</strong></span>
        </div>
    </div>
    
    
</body>

</html>
