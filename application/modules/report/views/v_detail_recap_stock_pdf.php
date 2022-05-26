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
                <th style="font-size:18px; text-align:center;">Detail Recap Stock Report</td>
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
                    <th style="width:25%; text-align:center;">Date</th>
                    <th style="width:25%; text-align:center;">Trans Type</th>
                    <th style="width:25%; text-align:center;">Doc Number</th>
                    <th style="width:20%; text-align:center;">Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php $totalqty = 0; ?>
                <?php $itemold = "xx"; ?>
                <?php $itemnew = ""; ?>

                <?php foreach($report->result() as $row) :?>

                    <?php $itemnew = $row->item_code; ?>

                    <?php if($itemold != $itemnew){ ?>
                        <?php $i = 1; ?>

                        <?php if($itemold != 'xx'){ ?>
                            <tr>
                                <td style="text-align:right;" colspan="4"><strong>Total : </strong></td>
                                <td style="text-align:center;"><strong><?php echo $totalqty ?></td>
                            </tr>
                            <tr><td colspan="5"></td></tr>
                        <?php } ?>

                        <tr>
                            <td style="text-align:left;" colspan="5"><strong>Product : <?php echo $row->item_code; ?> (<?php echo $row->item_name; ?>)</strong></td>
                        </tr>

                    <?php } ?>
                        
                    <tr>
                        <td style="text-align:center;"><?php echo $i ?></td>
                        <td style="text-align:center;"><?php echo $row->created_date; ?></td>
                        <td style="text-align:center;"><?php echo $row->trans_type; ?></td>
                        <td style="text-align:center;"><?php echo $row->doc_number; ?></td>
                        <td style="text-align:center;"><?php echo $row->qty; ?></td>
                    </tr>

                    <?php $totalqty = $totalqty + $row->qty; ?>
                    <?php $itemold = $itemnew; ?>
                    <?php $i = $i + 1; ?>

                <?php endforeach; ?>

                <tr>
                    <td style="text-align:right;" colspan="4"><strong>Total : </strong></td>
                    <td style="text-align:center;"><strong><?php echo $totalqty ?></td>
                </tr>
                <tr><td colspan="5"></td></tr>

            </tbody>
        </table>
        </div>
    </body>
</html>