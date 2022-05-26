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
                <th style="font-size:18px; text-align:center;">Detail Sales Report</td>
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
                    <th style="width:55%; text-align:center;">Product</th>
                    <th style="width:10%; text-align:center;">Qty</th>
                    <th style="width:10%; text-align:center;">Price</th>
                    <th style="width:10%; text-align:center;">Disc</th>
                    <th style="width:10%; text-align:center;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php $salesnumberold = "xx"; ?>
                <?php $salesnumbernew = ""; ?>
                <?php $totalprice = ""; ?>
                <?php $totaldisc = ""; ?>
                <?php $totaltransaction = ""; ?>

                <?php foreach($report->result() as $row) :?>
                    <?php $salesnumbernew = $row->sales_number; ?>

                    <?php if($salesnumberold != $salesnumbernew){ ?>
                        <?php $i = 0; ?>

                        <?php if($salesnumberold != 'xx'){ ?>
                            <tr>
                                <td style="text-align:right;" colspan="5"><strong>Total Transaction : </strong></td><td style="text-align:right;"><?php echo $totalprice; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;" colspan="5"><strong>Total Disc : </strong></td><td style="text-align:right;"><?php echo $totaldisc; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;" colspan="5"><strong>Total Payment : </strong></td><td style="text-align:right;"><?php echo $totaltransaction; ?></td>
                            </tr>
                            <tr><td colspan="6"></td></tr>
                        <?php } ?>

                        <tr>
                            <td style="text-align:left;" colspan="6"><strong>Invoice Date : <?php echo $row->sales_date ?> / Invoice Number : <?php echo $row->sales_number ?> / Member : <?php echo $row->member_code ?> / Cashier : <?php echo $row->username ?></strong></td>
                        </tr>

                    <?php } ?>
                        
                    <tr>
                        <td style="text-align:center;"><?php echo $i ?></td>
                        <td style="text-align:center;"><?php echo $row->item_code; ?> (<?php echo $row->item_name; ?>)</td>
                        <td style="text-align:center;"><?php echo $row->qty; ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->price,0,",","."); ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->disc,0,",","."); ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->subtotal,0,",","."); ?></td>
                    </tr>

                    <?php $salesnumberold = $salesnumbernew; ?>
                    <?php $totalprice = number_format($row->total_price,0,",","."); ?>
                    <?php $totaldisc = number_format($row->total_disc,0,",","."); ?>
                    <?php $totaltransaction = number_format($row->total_transaction,0,",","."); ?>
                    <?php $i = $i + 1; ?>

                <?php endforeach; ?>

                <tr>
                    <td style="text-align:right;" colspan="5"><strong>Total Transaction : </strong></td><td style="text-align:right;"><?php echo $totalprice; ?></td>
                </tr>
                <tr>
                    <td style="text-align:right;" colspan="5"><strong>Total Disc : </strong></td><td style="text-align:right;"><?php echo $totaldisc; ?></td>
                </tr>
                <tr>
                    <td style="text-align:right;" colspan="5"><strong>Total Payment : </strong></td><td style="text-align:right;"><?php echo $totaltransaction; ?></td>
                </tr>
            </tbody>
        </table>
        </div>
    </body>
</html>