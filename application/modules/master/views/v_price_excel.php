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
            header("Content-Disposition: attachment; filename=ListPrice.xls");

            $table = '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Item Code</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Item Name</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Barcode</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Start Period</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">End Period</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Public Price</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Member Price</th>
                        </tr>
                    </thead>
                    <tbody>';

            $i = 1;

            foreach($report->result() as $row) :
                $table .= '<tr>
                    <td style="text-align:center;">' . $row->item_code . '</td>
                    <td style="text-align:center;">' . $row->item_name . '</td>
                    <td style="text-align:center;">' . $row->barcode . '</td>
                    <td style="text-align:center;">' . $row->start_period . '</td>
                    <td style="text-align:center;">' . $row->end_period . '</td>
                    <td style="text-align:right;">' . $row->public_price . '</td>
                    <td style="text-align:right;">' . $row->member_price . '</td>
                </tr>';
                $i = $i + 1;
            endforeach;

            echo $table;

        ?>
    </body>
</html>