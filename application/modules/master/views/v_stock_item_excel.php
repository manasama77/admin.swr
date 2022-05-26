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
            header("Content-Disposition: attachment; filename=ListStockItem.xls");

            $table = '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Supplier Code</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Stock Category Code</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Stock Unit Code</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Item Code</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Item Name</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Barcode</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Minimum Qty</th>
                            <th style="text-align:center; background-color:#99c0ff; color:white;">Maximum Qty</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach($report->result() as $row) :
                $table .= '<tr>
                    <td style="text-align:center;">' . $row->supplier_code . '</td>
                    <td style="text-align:center;">' . $row->stock_category_code . '</td>
                    <td style="text-align:center;">' . $row->unit_code . '</td>
                    <td style="text-align:center;">' . $row->item_code . '</td>
                    <td style="text-align:left;">' . $row->item_name . '</td>
                    <td style="text-align:center;">' . $row->barcode  . '</td>
                    <td style="text-align:center;">' . $row->minimum_stock . '</td>
                    <td style="text-align:center;">' . $row->maximum_stock . '</td>
                </tr>';
            endforeach;

            echo $table;

        ?>
    </body>
</html>