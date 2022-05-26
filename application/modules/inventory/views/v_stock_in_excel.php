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
            header("Content-Disposition: attachment; filename=StockIn$stockinmaster->doc_number.xls");

            $table = '<p>
                    <label style="font-size:24px; display:block; width:x; height:y;">Stock In</label>
                    <br/>
                    <br/>
                    <label style="font-size:24px; display:block; width:x; height:y;">Doc Number : ' . $stockinmaster->doc_number . '</label>
                    <br/>
                    <label style="font-size:24px; display:block; width:x; height:y;">Stock In Date : ' . date('m/d/Y',strtotime($stockinmaster->stock_date)) . '</label>
                    <br/>
                    <label style="font-size:24px; display:block; width:x; height:y;">Status : ' . $stockinmaster->strstatus . '</label>
                    <br/>
                    <label style="font-size:24px; display:block; width:x; height:y;">Description : ' . $stockinmaster->description . '</label>
                </p>
                <br/>
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color:#99c0ff; color:white;">
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Item Code</th>
                            <th style="text-align:center;">Item Name</th>
                            <th style="text-align:center;">Qty</th>
                            <th style="text-align:center;">Buying Price</th>
                            <th style="text-align:center;">Information</th>
                        </tr>
                    </thead>
                    <tbody>';

            $i = 1;

            foreach($stockindetail->result() as $row) :
                $table .= '<tr>
                    <td style="text-align:center;">' . $i . '</td>
                    <td style="text-align:center;">' . $row->item_code . '</td>
                    <td style="text-align:center;">' . $row->item_name . '</td>
                    <td style="text-align:center;">' . $row->qty . '</td>
                    <td style="text-align:right;">' . number_format($row->buying_price,2,",",".") . '</td>
                    <td style="text-align:center;">' . $row->information . '</td>
                </tr>';
                $i = $i + 1;
            endforeach;

            echo $table;

        ?>
    </body>
</html>