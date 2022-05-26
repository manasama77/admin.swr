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
            <label style="font-size:24px; display:block; width:x; height:y;">Rekap Penjualan</label>
            <label style="display:block; width:x; height:y;">Period : <?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></label>
        </p>
        <table class="table table-bordered">
            <thead>
                <tr style="background-color:#99c0ff; color:white;">
                    <th style="width:5%; text-align:center;">No</th>
                    <th style="width:15%; text-align:center;">Kasir</th>
                    <th style="width:15%; text-align:center;">Nomor Penjualan</th>
                    <th style="width:20%; text-align:center;">Tanggal</th>
                    <th style="width:15%; text-align:center;">Total Transaksi</th>
                    <th style="width:15%; text-align:center;">Disc</th>
                    <th style="width:15%; text-align:center;">Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>

                <?php $branchnameold = 'xx'; ?>
                <?php $branchnamenew = ''; ?>

                <?php $all_price = 0; ?>
                <?php $all_disc = 0; ?>
                <?php $all_trans = 0; ?>
                
                <?php $grand_price = 0; ?>
                <?php $grand_disc = 0; ?>
                <?php $grand_trans = 0; ?>
                
                <?php foreach($report->result() as $row) :?>
                    <?php $branchnamenew = $row->branch_name; ?>

                    <?php if($branchnameold != $branchnamenew){ ?>

                        <?php if($branchnameold != 'xx'){ ?>

                            <tr>
                                <td colspan="4" style="text-align:right;"><strong>Total <?php echo $row->branch_name ?> : </strong></td>
                                <td style="text-align:right;"><strong><?php echo $all_price ?></strong></td>
                                <td style="text-align:right;"><strong><?php echo $all_disc ?></strong></td>
                                <td style="text-align:right;"><strong><?php echo $all_trans ?></strong></td>
                            </tr>

                            <tr><td colspan="7"></td></tr>

                        <?php } ?>

                        <?php $all_price = 0; ?>
                        <?php $all_disc = 0; ?>
                        <?php $all_trans = 0; ?>

                        <tr>
                            <td style="text-align:left;" colspan="7"><strong>Cabang : (<?php echo $row->branch_code ?>) <?php echo $row->branch_name ?></strong></td>
                        </tr>
                            
                    <?php } ?>

                    <tr>
                        <td style="text-align:center;"><?php echo $i ?></td>
                        <td style="text-align:center;"><?php echo $row->cashier_name; ?></td>
                        <td style="text-align:center;"><?php echo $row->sales_number; ?></td>
                        <td style="text-align:center;"><?php echo $row->sales_date; ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->total_price,0,",","."); ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->total_disc,0,",","."); ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->total_transaction,0,",","."); ?></td>
                    </tr>

                    <?php $all_price = $all_price + $row->total_price; ?>
                    <?php $all_disc = $all_disc + $row->total_disc; ?>
                    <?php $all_trans = $all_trans + $row->total_transaction; ?>

                    <?php $grand_price = $grand_price + $row->total_price; ?>
                    <?php $grand_disc = $grand_disc + $row->total_disc; ?>
                    <?php $grand_trans = $grand_trans + $row->total_transaction; ?>

                    <?php $i = $i + 1; ?>
                    <?php $branchnameold = $branchnamenew ?>
                <?php endforeach; ?>

                <tr style="background-color:#99c0ff; color:white;">
                    <td colspan="4" style="text-align:right;"><strong>Total <?php $branchnameold ?> : </strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($all_price,0,",","."); ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($all_disc,0,",","."); ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($all_trans,0,",","."); ?></strong></td>
                </tr>

                <tr style="background-color:#99c0ff; color:white;">
                    <td colspan="4" style="text-align:right;"><strong>Grand Total : </strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($grand_price,0,",","."); ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($grand_disc,0,",","."); ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($grand_trans,0,",","."); ?></strong></td>
                </tr>

            </tbody>
        </table>
    </body>
</html>