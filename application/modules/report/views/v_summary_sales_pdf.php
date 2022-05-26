<!DOCTYPE html>
<html>
    <head>
        <title>POSapps</title>
        <style type="text/css">
            #outtable{
            border:1px solid #e3e3e3;
            }
        
            table{
            border-collapse: collapse;
            font-family: arial;
            font-size: 10px;
            color:#5E5B5C;
            }
        
            thead th{
            padding: 10px;
            background:#99c0ff;
            }
        
            tbody td{
            border-top: 1px solid #e3e3e3;
            padding: 5px;
            }

            tfoot td{
            padding: 10px;
            background:#99c0ff;
            }
        
        </style>
    </head>
    <body>
        <table style="width:100%">
            <tr>
                <th style="font-size:18px; text-align:center;">Rangkuman Penjualan</td>
            </tr>
            <tr>
                <th style="text-align:center;">Period : <?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></td>
            </tr>
        </table>
        <br/>
        <br/>
        <div  id="outtable">
        <table style="width:100%;">
            <thead>
                <tr>
                    <th style="width:5%; text-align:center;">No</th>
                    <th style="width:10%; text-align:center;">Kasir</th>
                    <th style="width:15%; text-align:center;">Cabang</th>
                    <th style="width:10%; text-align:center;">Nomor Penjualan</th>
                    <th style="width:15%; text-align:center;">Tanggal</th>
                    <th style="width:15%; text-align:center;">Total Transaksi</th>
                    <th style="width:15%; text-align:center;">Disc</th>
                    <th style="width:15%; text-align:center;">Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php $all_price = 0; ?>
                <?php $all_disc = 0; ?>
                <?php $all_trans = 0; ?>
                <?php foreach($report->result() as $row) :?>
                    <tr>
                        <td style="text-align:center;"><?php echo $i ?></td>
                        <td style="text-align:center;"><?php echo $row->cashier_name; ?></td>
                        <td style="text-align:center;">(<?php echo $row->branch_code; ?>) <?php echo $row->branch_name; ?></td>
                        <td style="text-align:center;"><?php echo $row->sales_number; ?></td>
                        <td style="text-align:center;"><?php echo $row->sales_date; ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->total_price,0,",","."); ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->total_disc,0,",","."); ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->total_transaction,0,",","."); ?></td>
                    </tr>
                    <?php $i = $i + 1; ?>
                    <?php $all_price = $all_price + $row->total_price; ?>
                    <?php $all_disc = $all_disc + $row->total_disc; ?>
                    <?php $all_trans = $all_trans + $row->total_transaction; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align:right;"><strong>Total : </strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($all_price,0,",","."); ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($all_disc,0,",","."); ?></strong></td>
                    <td style="text-align:right;"><strong><?php echo number_format($all_trans,0,",","."); ?></strong></td>
                </tr>
            </tfoot>
        </table>
        </div>
    </body>
</html>