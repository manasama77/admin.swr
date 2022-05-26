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
                <th style="font-size:18px; text-align:center;">Member Transaction Report</td>
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
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">Date</th>
                    <th style="text-align:center;">Doc Number</th>
                    <th style="text-align:center;">Total Transaction</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php $memberold = "xx"; ?>
                <?php $membernew = ""; ?>
                <?php $currentlimit = 0; ?>

                <?php foreach($report->result() as $row) :?>

                    <?php $membernew = $row->member_code; ?>

                    <?php if($memberold != $membernew){ ?>
                        <?php $i = 1; ?>

                        <?php if($memberold != 'xx'){ ?>
                            <tr>
                                <td style="text-align:right;" colspan="3"><strong>Current Limit : </strong></td>
                                <td style="text-align:right;"><strong><?php echo $currentlimit ?></td>
                            </tr>
                            <tr><td colspan="5"></td></tr>
                        <?php } ?>

                        <tr>
                            <td style="text-align:left;" colspan="5"><strong>Member : <?php echo $row->member_code; ?> (<?php echo $row->fullname; ?>)</strong></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;" colspan="5"><strong>Limit Transaction : <?php echo number_format($row->limit_transaction,2,",","."); ?></strong></td>
                        </tr>

                    <?php } ?>
                        
                    <tr>
                        <td style="text-align:center;"><?php echo $i ?></td>
                        <td style="text-align:center;"><?php echo $row->sales_date; ?></td>
                        <td style="text-align:center;"><?php echo $row->sales_number; ?></td>
                        <td style="text-align:right;"><?php echo number_format($row->total_transaction,2,",","."); ?></td>
                    </tr>

                    <?php $memberold = $membernew; ?>
                    <?php $currentlimit = number_format($row->current_limit,2,",","."); ?>
                    <?php $i = $i + 1; ?>

                <?php endforeach; ?>

                <tr>
                    <td style="text-align:right;" colspan="3"><strong>Current Limit : </strong></td>
                    <td style="text-align:right;"><strong><?php echo $currentlimit ?></td>
                </tr>
                <tr><td colspan="5"></td></tr>

            </tbody>
        </table>
        </div>
    </body>
</html>