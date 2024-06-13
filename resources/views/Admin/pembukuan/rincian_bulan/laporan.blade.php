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
        <table>
            <tr style="background-color: beige;">
                <th style="padding: 5px;">Nomor</th>
                <th>Pembelian</th>
                <th>Penjualan</th>
                <th>Pengeluaran</th>
                <th>Total Berat Pembelian</th>
                <th>Total Berat Penjualan</th>
                <th style="text-align: right;">Pendapatan</th>
            </tr>
            @php
                $nomor = 0;
            @endphp
            @foreach ($DataPembukuan as $item)
                @php
                    $nomor++;
                @endphp
                <tr>
                    <td style="padding-top: 50px;"><?= $nomor ?></td>
                    <td style="padding-top: 50px;"><?= 'Rp. ' . number_format($item->total_pembelian, 0, ',', '.'); ?></td>
                    <td style="padding-top: 50px;"><?= 'Rp. ' . number_format($item->total_penjualan, 0, ',', '.'); ?></td>
                    <td style="padding-top: 50px;"><?= 'Rp. ' . number_format($item->total_pengeluaran, 0, ',', '.'); ?></td>
                    <td style="padding-top: 50px;"><?= $item->total_berat_pembelian . ' Kg' ?></td>
                    <td style="padding-top: 50px;"><?= $item->total_berat_penjualan . ' Kg' ?></td>
                    <td style="padding-top: 50px; text-align: right;"><?= 'Rp. ' . number_format($item->pendapatan_bersih, 0, ',', '.'); ?></td>
                </tr>
            @endforeach
        </table> 
</body>

</html>
