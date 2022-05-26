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
            header("Content-Disposition: attachment; filename=StockOut$stockoutmaster->doc_number.xls");

            $table = '<p>
                    Doc Number : ' . $stockoutmaster->doc_number . '
                    <br/>
                    Stock Out Date : ' . date('d M Y',strtotime($stockoutmaster->stock_date)) . '
                    <br/>
                    Status : ' . $stockoutmaster->strstatus . '
                    <br/>
                    Description : ' . $stockoutmaster->description . '
                </p>
                <br/>
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color:#99c0ff; color:white;">
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Item Code</th>
                            <th style="text-align:center;">Barcode</th>
                            <th style="text-align:center; ">Item Name</th>
                            <th style="text-align:center;">Qty</th>
                        </tr>
                    </thead>
                    <tbody>';

            $i = 1;

            foreach($stockoutdetail->result() as $row) :
                $table .= '<tr>
                    <td style="text-align:center;">' . $i . '</td>
                    <td style="text-align:center;">' . $row->item_code . '</td>
                    <td style="text-align:center;">' . $row->barcode . '</td>
                    <td style="text-align:left;">' . $row->item_name . '</td>
                    <td style="text-align:center;">' . $row->qty . '</td>
                </tr>';
                $i = $i + 1;
            endforeach;
			
			$table .= '</tbody></table>';

            echo $table;

        ?>
    </body>
</html>