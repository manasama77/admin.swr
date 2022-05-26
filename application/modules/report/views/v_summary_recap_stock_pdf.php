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
                <th style="font-size:18px; text-align:center;">Summary Recap Stock Report</td>
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
                    <th style="width:15%; text-align:center;">Item Code</th>
                    <th style="width:40%; text-align:center;">Item Name</th>
                    <th style="width:10%; text-align:center;">Begining Qty</th>
                    <th style="width:10%; text-align:center;">Qty In</th>
                    <th style="width:10%; text-align:center;">Qty Out</th>
                    <th style="width:10%; text-align:center;">Remaining Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach($report->result() as $row) :?>
                    <tr>
                        <td style="text-align:center;"><?php echo $i ?></td>
                        <td style="text-align:center;"><?php echo $row->item_code; ?></td>
                        <td style="text-align:left;"><?php echo $row->item_name; ?></td>
                        <td style="text-align:center;"><?php echo $row->begining_qty; ?></td>
                        <td style="text-align:center;"><?php echo $row->stock_in; ?></td>
                        <td style="text-align:center;"><?php echo $row->stock_out; ?></td>
                        <td style="text-align:center;"><?php echo $row->total_qty; ?></td>
                    </tr>
                    <?php $i = $i + 1; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </body>
</html>