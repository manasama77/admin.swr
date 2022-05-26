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
        <label style="font-size:24px; display:block; width:x; height:y;">Keuntungan Penjualan</label>
        <label style="display:block; width:x; height:y;">Periode : <?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></label>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:15%; text-align:center;">Tgl Transaksi</th>
                <th style="width:10%; text-align:center;">No Transaksi</th>
                <th style="width:35%; text-align:center;">Barang</th>
                <th style="width:10%; text-align:center;">Jumlah</th>
                <th style="width:10%; text-align:center;">Harga Modal</th>
                <th style="width:10%; text-align:center;">Harga Jual</th>
                <th style="width:10%; text-align:center;">Keuntungan</th>
                <!-- <th style="width:10%; text-align:center;">Pajak</th> -->
            </tr>
        </thead>
        <tbody>
            <?php $branchnew = ""; ?>
            <?php $branchold = "xx"; ?>

            <?php $subtotalhpp = 0; ?>
            <?php $subtotalsellprice = 0; ?>
            <?php $subtotalprofit = 0; ?>
            <?php $subtotalpajak = 0; ?>

            <?php $totalhpp = 0; ?>
            <?php $totalsellprice = 0; ?>
            <?php $totalprofit = 0; ?>
            <?php $totalpajak = 0; ?>

            <?php foreach ($report as $row) : ?>
                <?php $branchnew = $row['branch_code']; ?>

                <?php if ($branchnew != $branchold) { ?>
                    <?php if ($branchold != "xx") { ?>
                        <tr>
                            <td style="text-align:right;" colspan="3"><strong>Total : </strong></td>
                            <td style="text-align:right;"><strong><?php echo number_format($subtotalhpp, 0, ",", "."); ?></strong></td>
                            <td style="text-align:right;"><strong><?php echo number_format($subtotalsellprice, 0, ",", "."); ?></strong></td>
                            <td style="text-align:right;"><strong><?php echo number_format($subtotalprofit, 0, ",", "."); ?></strong></td>
                            <!-- <td style="text-align:right;"><strong><?php echo number_format($subtotalpajak, 0, ",", "."); ?></strong></td> -->
                        </tr>
                    <?php } ?>

                    <?php $subtotalhpp = 0; ?>
                    <?php $subtotalsellprice = 0; ?>
                    <?php $subtotalprofit = 0; ?>
                    <?php $subtotalpajak = 0; ?>

                    <tr>
                        <td style="font-size:16px;" colspan="7"><strong>Cabang : (<?php echo $row['branch_code']; ?>) <?php echo $row['branch_name']; ?></strong></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td style="text-align:left;"><?php echo $row['created_date']; ?></td>
                    <td style="text-align:left;"><?php echo $row['trans_number']; ?></td>
                    <td style="text-align:left;"><?php echo $row['item_name']; ?></td>
                    <td style="text-align:center;"><?php echo $row['qty_now']; ?></td>
                    <td style="text-align:right;"><?php echo number_format($row['tot_hpp'], 0, ",", "."); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row['tot_sell_price'], 0, ",", "."); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row['profit'], 0, ",", "."); ?></td>
                    <!-- <td style="text-align:right;"><?php echo number_format($row['pajak'], 0, ",", "."); ?></td> -->
                </tr>

                <?php $subtotalhpp = intval($subtotalhpp) + intval($row['tot_hpp']); ?>
                <?php $subtotalsellprice = intval($subtotalsellprice) + intval($row['tot_sell_price']); ?>
                <?php $subtotalprofit = intval($subtotalprofit) + intval($row['profit']); ?>
                <?php $subtotalpajak = intval($subtotalpajak) + intval($row['pajak']); ?>

                <?php $totalhpp = intval($totalhpp) + intval($row['tot_hpp']); ?>
                <?php $totalsellprice = intval($totalsellprice) + intval($row['tot_sell_price']); ?>
                <?php $totalprofit = intval($totalprofit) + intval($row['profit']); ?>
                <?php $totalpajak = intval($totalpajak) + intval($row['pajak']); ?>

                <?php $branchold = $branchnew; ?>
            <?php endforeach; ?>
            <tr>
                <td style="text-align:right;" colspan="4"><strong>Total : </strong></td>
                <td style="text-align:right;"><strong><?php echo number_format($subtotalhpp, 0, ",", "."); ?></strong></td>
                <td style="text-align:right;"><strong><?php echo number_format($subtotalsellprice, 0, ",", "."); ?></strong></td>
                <td style="text-align:right;"><strong><?php echo number_format($subtotalprofit, 0, ",", "."); ?></strong></td>
                <!-- <td style="text-align:right;"><strong><?php echo number_format($subtotalpajak, 0, ",", "."); ?></strong></td> -->
            </tr>
            <tr>
                <td style="text-align:right;" colspan="4"><strong>Grand Total : </strong></td>
                <td style="text-align:right;"><strong><?php echo number_format($totalhpp, 0, ",", "."); ?></strong></td>
                <td style="text-align:right;"><strong><?php echo number_format($totalsellprice, 0, ",", "."); ?></strong></td>
                <td style="text-align:right;"><strong><?php echo number_format($totalprofit, 0, ",", "."); ?></strong></td>
                <!-- <td style="text-align:right;"><strong><?php echo number_format($totalpajak, 0, ",", "."); ?></strong></td> -->
            </tr>
        </tbody>
    </table>
</body>

</html>