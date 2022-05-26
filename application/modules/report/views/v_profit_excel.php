<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>POS Apps</title>
    <link href="<?php echo base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=KeuntunganPenjualan.xls");

    $table = '<table>
                <tr>
                    <th colspan="7" style="text-align:center;">Keuntungan Penjualan</td>
                </tr>
                <tr>
                    <th colspan="7" style="text-align:center;">Periode : ' . $header->startperiod . ' - ' . $header->endperiod . '</td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align:center;">&nbsp;</td>
                </tr>
                <thead>
                    <tr>
                        <th style="width:15%; text-align:center;">Tgl Transaksi</th>
                        <th style="width:10%; text-align:center;">No Transaksi</th>
                        <th style="width:35%; text-align:center;">Barang</th>
                        <th style="width:10%; text-align:center;">Jumlah</th>
                        <th style="width:10%; text-align:center;">Harga Modal</th>
                        <th style="width:10%; text-align:center;">Harga Jual</th>
                        <th style="width:10%; text-align:center;">Keuntungan</th>
                    </tr>
                </thead>
                <tbody>';

    $branchold = 'xx';
    $branchnew = '';

    $subtotalhpp = 0;
    $subtotalsellprice = 0;
    $subtotalprofit = 0;
    $subtotalpajak = 0;

    $totalhpp = 0;
    $totalsellprice = 0;
    $totalprofit = 0;
    $totalpajak = 0;

    foreach ($report as $row) :
        $branchnew = $row['branch_code'];

        if ($branchold != $branchnew) {
            if ($branchold != 'xx') {

                $table .= '<tr>
                        <td style="text-align:right;" colspan="4"><strong>Total : </strong></td>
                        <td style="text-align:right;">' . $subtotalhpp . '</strong></td>
                        <td style="text-align:right;">' . $subtotalsellprice . '</strong></td>
                        <td style="text-align:right;">' . $subtotalprofit . '</strong></td>
                        </tr>';

                $subtotalhpp = 0;
                $subtotalsellprice = 0;
                $subtotalprofit = 0;
                $subtotalpajak = 0;
            }

            $table .= '<tr>
                    <td style="text-align:left;" colspan="7"><strong>Cabang : (' . $row['branch_code'] . ') ' . $row['branch_name'] . '</strong></td>
                    </tr>';
        }

        $table .= '<tr>
                <td style="text-align:left;">' . $row['created_date'] . '</td>
                <td style="text-align:left;">' . $row['trans_number'] . '</td>
                <td style="text-align:left;">' . $row['item_name'] . '</td>
                <td style="text-align:center;">' . $row['qty_now'] . '</td>
                <td style="text-align:right;">' . $row['tot_hpp'] . '</td>
                <td style="text-align:right;">' . $row['tot_sell_price'] . '</td>
                <td style="text-align:right;">' . $row['profit'] . '</td>
                </tr>';

        $subtotalhpp = $subtotalhpp + $row['tot_hpp'];
        $subtotalsellprice = $subtotalsellprice + $row['tot_sell_price'];
        $subtotalprofit = $subtotalprofit + $row['profit'];
        $subtotalpajak = $subtotalpajak + $row['pajak'];

        $totalhpp = $totalhpp + $row['tot_hpp'];
        $totalsellprice = $totalsellprice + $row['tot_sell_price'];
        $totalprofit = $totalprofit + $row['profit'];
        $totalpajak = $totalpajak + $row['pajak'];

        $branchold = $branchnew;
    endforeach;

    $table .= '<tr>
                            <td style="text-align:right;" colspan="4"><strong>Total : </strong></td>
                            <td style="text-align:right;">' . $subtotalhpp . '</strong></td>
                            <td style="text-align:right;">' . $subtotalsellprice . '</strong></td>
                            <td style="text-align:right;">' . $subtotalprofit . '</strong></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;" colspan="4"><strong>Grand Total : </strong></td>
                            <td style="text-align:right;">' . $totalhpp . '</strong></td>
                            <td style="text-align:right;">' . $totalsellprice . '</strong></td>
                            <td style="text-align:right;">' . $totalprofit . '</strong></td>
                        </tr>
                    </tbody>
                </table>';

    echo $table;

    ?>
</body>

</html>