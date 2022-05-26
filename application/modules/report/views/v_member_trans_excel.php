<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>POSapps</title>
        <link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php 
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=MemberTransactionReport.xls");

            $table = '<p style="text-align:center;">
                    <label style="font-size:24px; display:block; width:x; height:y;">Member Transaction Report</label>
                    <br/>
                    <label style="display:block; width:x; height:y;">Period : ' . $header->startperiod . ' - ' . $header->endperiod . '</label>
                </p>
                <br/>
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color:#99c0ff; color:white;">
                            <th style="width:5%; text-align:center;">No</th>
                            <th style="width:25%; text-align:center;">Date</th>
                            <th style="width:25%; text-align:center;">Doc Number</th>
                            <th style="width:20%; text-align:center;">Total Transaction</th>
                        </tr>
                    </thead>
                    <tbody>';

            $i = 1;
            $memberold = 'xx';
            $membernew = '';
            $currentlimit = "";

            foreach($report->result() as $row) :

                $membernew = $row->member_code;

                if($memberold != $membernew){
                    $i = 1;
                    
                    if($memberold != 'xx'){
                        $table .= '<tr>
                        <td style="text-align:right;" colspan="3"><strong>Current Limit : </strong></td>
                        <td style="text-align:right;"><strong>' . $currentlimit . '</td>
                        </tr>
                        <tr><td colspan="4"></td></tr>';
                    }
                    
                    $table .= '<tr>
                    <td style="text-align:left;" colspan="4"><strong>Member : ' . $row->member_code . ' (' . $row->fullname . ')</strong></td>
                    </tr>
                    <tr>
                    <td style="text-align:left;" colspan="4"><strong>Limit Transaction : ' . number_format($row->limit_transaction,2,",",".") . '</strong></td>
                    </tr>';
                }
                
                $table .= '<tr>
                    <td style="text-align:center;">' . $i . '</td>
                    <td style="text-align:center;">' . $row->sales_date . '</td>
                    <td style="text-align:center;">' . $row->sales_number . '</td>
                    <td style="text-align:right;">' . number_format($row->total_transaction,2,",",".") . '</td>
                </tr>';

                $currentlimit = number_format($row->current_limit,2,",",".");
                $memberold = $membernew;
                $i = $i + 1;

            endforeach;

            $table .= '<tr>
                        <td style="text-align:right;" colspan="3"><strong>Current Limit : </strong></td>
                        <td style="text-align:right;"><strong>' . $currentlimit . '</td>
                        </tr>';

            echo $table;

        ?>
    </body>
</html>