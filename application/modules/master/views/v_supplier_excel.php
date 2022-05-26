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
            header("Content-Disposition: attachment; filename=ListSupplier.xls");

            $table = '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Supplier Code</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Supplier Name</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Contact Name</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Phone</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Handphone</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Email</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">City</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Address</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Description</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach($report->result() as $row) :
                $table .= '<tr>
                    <td style="text-align:center;">' . $row->supplier_code . '</td>
                    <td style="text-align:center;">' . $row->supplier_name . '</td>
                    <td style="text-align:center;">' . $row->contact_name . '</td>
                    <td style="text-align:center;">' . $row->phone . '</td>
                    <td style="text-align:center;">' . $row->handphone . '</td>
                    <td style="text-align:center;">' . $row->email  . '</td>
                    <td style="text-align:center;">' . $row->city . '</td>
                    <td style="text-align:center;">' . $row->address . '</td>
                    <td style="text-align:center;">' . $row->description . '</td>
                </tr>';
            endforeach;

            echo $table;

        ?>
    </body>
</html>