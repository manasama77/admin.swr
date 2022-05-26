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
        <p style="text-align:center;">
            <label style="font-size:24px; display:block; width:x; height:y;">Member Transaction Report</label>
            <label style="display:block; width:x; height:y;">Period : <?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></label>
        </p>
        <table class="table table-bordered">
            <thead>
                <tr style="background-color:#99c0ff; color:white;">
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">Date</th>
                    <th style="text-align:center;">Doc Number</th>
                    <th style="text-align:center;">Total Transaction</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php $membernew = ""; ?>
                <?php $memberold = "xx"; ?>
                <?php $currentlimit = ""; ?>

                <?php foreach($report->result() as $row) :?>

                    <?php $membernew = $row->member_code; ?>

                    <?php if($membernew != $memberold){ ?>
                        <?php $i = 1; ?>
                        <?php if($memberold != "xx"){ ?>
                            <tr>
                                <td style="text-align:right;" colspan="3"><strong>Current Limit : </strong></td>
                                <td style="text-align:right;"><strong><?php echo $currentlimit ?></strong></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td style="text-align:left;" colspan="4"><strong>Member : <?php echo $row->member_code; ?> (<?php echo $row->fullname; ?>)</strong></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;" colspan="4"><strong>Limit Transaction : <?php echo number_format($row->limit_transaction,2,",","."); ?></strong></td>
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
                    <td style="text-align:right;"><strong><?php echo $currentlimit; ?></strong></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>