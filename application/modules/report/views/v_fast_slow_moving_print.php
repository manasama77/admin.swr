<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>POSapps</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    </head>
    <body onload="window.print();">
        <p>
            <label style="font-size:24px;">PT Nestle Indonesia</label>
            <br/>
            Jl. Surya Madya V Kav I, 37-39 ABC
            <br/>
            Kawasan Suya Cipta, Ciampel, Desa Kuta Negara
            <br/>
            Karawang, 41363
        </p>
        <table width="100%">
            <tr>
                <td style="font-size:24px;"><strong>Fast Slow Moving Report</strong></td>
                <td style="text-align: right;">Period : <?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></td>
            </tr>
        </table>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:10%; text-align:center;">Product ID</th>
                    <th style="width:40%; text-align:left;">Product Name</th>
                    <th style="width:5%; text-align:center;">Unit</th>
                    <th style="width:5%; text-align:center;">Qty</th>
                    <th style="width:10%; text-align:right;">Amount</th>
                    <th style="width:10%; text-align:right;">Disc</th>
                    <th style="width:10%; text-align:right;">Tax</th>
                    <th style="width:10%; text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php $itemnew = ""; ?>
                <?php $itemold = "xx"; ?>

                <?php $totalqty = 0; ?>
                <?php $totalamount = 0; ?>
                <?php $totaldisc = 0; ?>
                <?php $totaltax = 0; ?>
                <?php $totaltotal = 0; ?>

                <?php $grandqty = 0; ?>
                <?php $grandamount = 0; ?>
                <?php $granddisc = 0; ?>
                <?php $grandtax = 0; ?>
                <?php $grandtotal = 0; ?>

                <?php foreach($report->result() as $row) :?>
                    <?php $itemnew = $row->stock_category_name; ?>

                    <?php if($itemnew != $itemold){ ?>
                        <?php $i = 1; ?>
                        <?php if($itemold != "xx"){ ?>
                            <tr>
                                <td style="text-align:right;" colspan="3"><strong>Subtotal : </strong></td>
                                <td style="text-align:center;"><strong><?php echo intval($totalqty) ?></strong></td>
                                <td style="text-align:right;"><strong><?php echo intval($totalamount) ?></strong></td>
                                <td style="text-align:right;"><strong><?php echo intval($totaldisc) ?></strong></td>
                                <td style="text-align:right;"><strong><?php echo intval($totaltax) ?></strong></td>
                                <td style="text-align:right;"><strong><?php echo intval($totaltotal) ?></strong></td>
                            </tr>
                        <?php } ?>

                        <?php $totalqty = 0; ?>
                        <?php $totalamount = 0; ?>
                        <?php $totaldisc = 0; ?>
                        <?php $totaltax = 0; ?>
                        <?php $totaltotal = 0; ?>

                        <tr>
                            <td style="font-size:16px;" colspan="8"><strong><?php echo $row->stock_category_name; ?></strong></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td style="text-align:center;"><?php echo $row->barcode; ?></td>
                        <td style="text-align:left;"><?php echo $row->item_name; ?></td>
                        <td style="text-align:center;"><?php echo $row->unit_code; ?></td>
                        <td style="text-align:center;"><?php echo $row->total_qty; ?></td>
                        <td style="text-align:right;"><?php echo $row->public_price; ?></td>
                        <td style="text-align:right;"><?php echo $row->disc; ?></td>
                        <td style="text-align:right;"><?php echo $row->tax; ?></td>
                        <td style="text-align:right;"><?php echo $row->total; ?></td>
                    </tr>

                    <?php $totalqty = intval($totalqty) + intval($row->total_qty); ?>
                    <?php $totalamount = intval($totalamount) + intval($row->public_price); ?>
                    <?php $totaldisc = intval($totaldisc) + intval($row->disc); ?>
                    <?php $totaltax = intval($totaltax) + intval($row->tax); ?>
                    <?php $totaltotal = intval($totaltotal) + intval($row->total); ?>

                    <?php $grandqty = intval($grandqty) + intval($row->total_qty); ?>
                    <?php $grandamount = intval($grandamount) + intval($row->public_price); ?>
                    <?php $granddisc = intval($granddisc) + intval($row->disc); ?>
                    <?php $grandtax = intval($grandtax) + intval($row->tax); ?>
                    <?php $grandtotal = intval($grandtotal) + intval($row->total); ?>

                    <?php $itemold = $itemnew; ?>
                    <?php $i = $i + 1; ?>
                <?php endforeach; ?>
                <tr>
                    <td style="text-align:right;" colspan="3"><strong>Subtotal : </strong></td>
                    <td style="text-align:center;"><strong><?php echo intval($totalqty) ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo intval($totalamount) ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo intval($totaldisc) ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo intval($totaltax) ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo intval($totaltotal) ?></strong></td>
                </tr>
                <tr>
                    <td style="text-align:right;" colspan="3"><strong>Grand Total : </strong></td>
                    <td style="text-align:center;"><strong><?php echo intval($grandqty) ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo intval($grandamount) ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo intval($granddisc) ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo intval($grandtax) ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo intval($grandtotal) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>