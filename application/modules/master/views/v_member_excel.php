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
            header("Content-Disposition: attachment; filename=ListMember.xls");

            $table = '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Member Code</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Fullname</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Phone</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Email</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Address</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Identity Type</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Identity ID</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Limit Transaction</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Status</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach($report->result() as $row) :
                $table .= '<tr>
                    <td style="text-align:center;">' . $row->member_code . '</td>
                    <td style="text-align:left;">' . $row->fullname . '</td>
                    <td style="text-align:center;">' . $row->phone . '</td>
                    <td style="text-align:center;">' . $row->email . '</td>
                    <td style="text-align:left;">' . $row->address . '</td>
                    <td style="text-align:center;">' . $row->identity_type  . '</td>
                    <td style="text-align:center;">' . $row->identity_id . '</td>
                    <td style="text-align:right;">' . $row->limit_transaction . '</td>
                    <td style="text-align:center;">' . $row->strstatus . '</td>
                </tr>';
            endforeach;

            echo $table;

        ?>
    </body>
</html>