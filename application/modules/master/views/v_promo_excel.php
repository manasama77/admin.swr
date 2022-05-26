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
            header("Content-Disposition: attachment; filename=ListPromo.xls");

            $table = '<p>
                    <label style="font-size:24px; display:block; width:x; height:y;">List Promo</label>
                </p>
                <br/>
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color:#99c0ff; color:white;">
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Item Code</th>
                            <th style="text-align:center;">Item Name</th>
                            <th style="text-align:center;">Barcode</th>
                            <th style="text-align:center;">Start Period</th>
                            <th style="text-align:center;">End Period</th>
                            <th style="text-align:center;">Promo Type</th>
                            <th style="text-align:center;">Disc Percentage</th>
                            <th style="text-align:center;">Disc Amount</th>
                        </tr>
                    </thead>
                    <tbody>';

            $i = 1;

            foreach($report->result() as $row) :
                $table .= '<tr>
                    <td style="text-align:center;">' . $i . '</td>
                    <td style="text-align:center;">' . $row->item_code . '</td>
                    <td style="text-align:center;">' . $row->item_name . '</td>
                    <td style="text-align:center;">' . $row->barcode . '</td>
                    <td style="text-align:center;">' . $row->start_period . '</td>
                    <td style="text-align:center;">' . $row->end_period . '</td>
                    <td style="text-align:center;">' . $row->strpromo_type . '</td>
                    <td style="text-align:right;">' . $row->disc_percentage . '</td>
                    <td style="text-align:right;">' . number_format($row->disc_amount,2,",",".") . '</td>
                </tr>';
                $i = $i + 1;
            endforeach;

            echo $table;

        ?>
    </body>
</html>