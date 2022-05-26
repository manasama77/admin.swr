<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>POS Apps</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <style type="text/css" media="print">
        @page {
            size: landscape;
        }
    </style>
</head>

<body onload="window.print();">
    <p style="text-align:center;">
        <label style="font-size:24px; display:block; width:x; height:y;">Detail Penjualan</label>
        <label style="display:block; width:x; height:y;">Period : <?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></label>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr style="background-color:#99c0ff; color:white;">
                <th style="width:5%; text-align:center;">No</th>
                <th style="width:55%; text-align:center;">Nama Barang</th>
                <th style="width:10%; text-align:center;">Harga</th>
                <th style="width:10%; text-align:center;">Diskon</th>
                <th style="width:10%; text-align:center;">Jumlah</th>
                <th style="width:10%; text-align:center;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php $salesnumberold = "xx"; ?>
            <?php $salesnumbernew = ""; ?>
            <?php $totalprice = ""; ?>
            <?php $totaldisc = ""; ?>
            <?php $totaltransaction = ""; ?>

            <?php foreach ($report->result() as $row) : ?>

                <?php $salesnumbernew = $row->sales_number; ?>

                <?php if ($salesnumberold != $salesnumbernew) { ?>
                    <?php $i = 1; ?>
                    <?php if ($salesnumberold != "xx") { ?>
                        <tr>
                            <td style="text-align:right;" colspan="5"><strong>Total Transaksi : </strong></td>
                            <td style="text-align:right;"><?php echo $totalprice; ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;" colspan="5"><strong>Total Disc : </strong></td>
                            <td style="text-align:right;"><?php echo $totaldisc; ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;" colspan="5"><strong>Total Penjualan : </strong></td>
                            <td style="text-align:right;"><?php echo $totaltransaction; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="text-align:left;" colspan="5"><strong>Tanggal Penjualan : <?php echo $row->sales_date; ?> / Nomor Penjualan : <?php echo $row->sales_number; ?> / Cabang : (<?php echo $row->branch_code; ?>) <?php echo $row->branch_name; ?> / Kasir : <?php echo $row->cashier_name; ?></strong></td>
                    </tr>
                <?php } ?>

                <?php if ($i == 1) { ?>

                <?php } ?>

                <tr>
                    <td style="text-align:center;"><?php echo $i ?></td>
                    <td style="text-align:left;">(<?php echo $row->barcode; ?>) <?php echo $row->item_name; ?></td>
                    <td style="text-align:center;"><?php echo number_format($row->price, 0, ",", "."); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->extra_disc, 0, ",", "."); ?></td>
                    <td style="text-align:center;"><?php echo $row->qty; ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->subtotal, 0, ",", "."); ?></td>
                </tr>

                <?php $salesnumberold = $salesnumbernew; ?>
                <?php $totalprice = number_format($row->total_price, 0, ",", "."); ?>
                <?php $totaldisc = number_format($row->total_disc, 0, ",", "."); ?>
                <?php $totaltransaction = number_format($row->total_transaction, 0, ",", "."); ?>
                <?php $i = $i + 1; ?>

            <?php endforeach; ?>

            <tr>
                <td style="text-align:right;" colspan="5"><strong>Total Transaksi : </strong></td>
                <td style="text-align:right;"><?php echo $totalprice; ?></td>
            </tr>
            <tr>
                <td style="text-align:right;" colspan="5"><strong>Total Disc : </strong></td>
                <td style="text-align:right;"><?php echo $totaldisc; ?></td>
            </tr>
            <tr>
                <td style="text-align:right;" colspan="5"><strong>Total Penjualan : </strong></td>
                <td style="text-align:right;"><?php echo $totaltransaction; ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>