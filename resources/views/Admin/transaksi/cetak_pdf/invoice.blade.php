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
                <th>Berat Normal</th>
                <th>Berat Potong</th>
                <th>Berat Bersih</th>
                <th>Harga</th>
                <th style="text-align: right;">Total</th>
            </tr>
            @php
                $nomor = 0;
                $total = 0;
            @endphp
            @foreach ($DataRincianPembelian as $item)
                @php
                    $nomor++;
                    $subtotal = $item->berat_bersih * $item->harga_beli;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td style="padding-top: 50px;"><?= $nomor ?></td>
                    <td style="padding-top: 50px;"><?= $item->berat_normal . ' Kg' ?></td>
                    <td style="padding-top: 50px;"><?= $item->berat_potong . ' Kg' ?></td>
                    <td style="padding-top: 50px;"><?= $item->berat_bersih . ' Kg' ?></td>
                    <td style="padding-top: 50px;"><?= 'Rp. ' . number_format($item->harga_beli, 0, ',', '.'); ?></td>
                    <td style="padding-top: 50px; text-align: right;"><?= 'Rp. ' . number_format($subtotal, 0, ',', '.'); ?></td>
                </tr>
            @endforeach
            <tr style="height: 30%; background-color:beige; ">
                <td colspan="5" style="text-align:right; border-top: 1px dashed #0a0a0a"><strong>Total:</strong></td>
                <td style="text-align: right; border-top: 1px dashed #0a0a0a"><strong><?= 'Rp. ' . number_format($total, 0, ',', '.'); ?></strong></td>
            </tr>
        </table> 
</body>

</html>
