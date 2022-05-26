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
            header("Content-Disposition: attachment; filename=ListStockUnit.xls");

            $table = '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Stock Unit Code</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Stock Unit Name</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach($report->result() as $row) :
                $table .= '<tr>
                    <td style="text-align:center;">' . $row->unit_code . '</td>
                    <td style="text-align:center;">' . $row->unit_name . '</td>
                </tr>';
            endforeach;

            echo $table;

        ?>
    </body>
</html>