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
    header("Content-Disposition: attachment; filename=RekapPenjualan.xls");

    $table = '<table>
                        <tr>
                            <th colspan="7" style="text-align:center;">Rekap Penjualan</td>
                        </tr>
                        <tr>
                            <th colspan="7" style="text-align:center;">Periode : ' . $header->startperiod . ' - ' . $header->endperiod . '</td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align:center;">&nbsp;</td>
                        </tr>
                        <thead>
                            <tr>
                                <th style="width:5%; text-align:center;">No</th>
                                <th style="width:15%; text-align:center;">Kasir</th>
                                <th style="width:15%; text-align:center;">Nomor Penjualan</th>
                                <th style="width:20%; text-align:center;">Tanggal</th>
                                <th style="width:15%; text-align:center;">Total Transaksi</th>
                                <th style="width:15%; text-align:center;">Disc</th>
                                <th style="width:15%; text-align:center;">Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>';

    $i = 1;

    $branchold = 'xx';
    $branchnew = '';

    $all_price = 0;
    $all_disc = 0;
    $all_trans = 0;

    $grand_price = 0;
    $grand_disc = 0;
    $grand_trans = 0;

    foreach ($report->result() as $row) :
        $branchnew = $row->branch_name;

        if ($branchold != $branchnew) {
            if ($branchold != 'xx') {

                $table .= '<tr>
                            <td colspan="4" style="text-align:right;"><strong>Total ' . $row->branch_name . ' : </strong></td>
                            <td style="text-align:right;"><strong>' . $all_price . '</strong></td>
                            <td style="text-align:right;"><strong>' . $all_disc . '</strong></td>
                            <td style="text-align:right;"><strong>' . $all_trans . '</strong></td>
                            </tr>';

                $all_price = 0;
                $all_disc = 0;
                $all_trans = 0;
            }

            $table .= '<tr>
                        <td style="text-align:left;" colspan="7"><strong>Cabang : (' . $row->branch_code . ') ' . $row->branch_name . '</strong></td>
                        </tr>';
        }

        $table .= '<tr>
                    <td style="text-align:center;">' . $i . '</td>
                    <td style="text-align:center;">' . $row->cashier_name . '</td>
                    <td style="text-align:center;">' . $row->sales_number . '</td>
                    <td style="text-align:center;">' . $row->sales_date . '</td>
                    <td style="text-align:right;">' . $row->total_price . '</td>
                    <td style="text-align:right;">' . $row->total_disc . '</td>
                    <td style="text-align:right;">' . $row->total_transaction . '</td>
                </tr>';

        $all_price = $all_price + $row->total_price;
        $all_disc = $all_disc + $row->total_disc;
        $all_trans = $all_trans + $row->total_transaction;

        $grand_price = $grand_price + $row->total_price;
        $grand_disc = $grand_disc + $row->total_disc;
        $grand_trans = $grand_trans + $row->total_transaction;

        $i = $i + 1;
        $branchold = $branchnew;
    endforeach;

    $table .= '<tr>
                            <td colspan="4" style="text-align:right;"><strong>Total ' . $branchold . ' : </strong></td>
                            <td style="text-align:right;"><strong>' . $all_price . '</strong></td>
                            <td style="text-align:right;"><strong>' . $all_disc . '</strong></td>
                            <td style="text-align:right;"><strong>' . $all_trans . '</strong></td>
                        </tr>';

    $table .= '<tr>
                            <td colspan="4" style="text-align:right;"><strong>Grand Total : </strong></td>
                            <td style="text-align:right;"><strong>' . $grand_price . '</strong></td>
                            <td style="text-align:right;"><strong>' . $grand_disc . '</strong></td>
                            <td style="text-align:right;"><strong>' . $grand_trans . '</strong></td>
                        </tr>
                    </tbody>
                </table>';

    echo $table;

    ?>
</body>

</html>