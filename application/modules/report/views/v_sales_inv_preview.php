<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>POS Nestle</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url();?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <p style="width:2500px; text-align:center;">
            <label style="font-size:24px; display:block; width:x; height:y;">Sales Inventory Report</label>
            <label style="display:block; width:x; height:y;">Period : <?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></label>
        </p>
        <br/>
        <?php date_default_timezone_set("Asia/Bangkok"); ?>
        <?php echo "Created Date : " . date('Y-m-d H:i:s'); ?>
        <br/>
        <table class="table table-bordered" style="width:2500px;">
            <thead>
                <tr style="background-color:#99c0ff; color:white;">
                    <th style="width:300px; text-align:center; vertical-align: middle;" rowspan="3">Product Category</th>
                    <th style="width:400px; text-align:center; vertical-align: middle;" rowspan="3">Product ID</th>
                    <th style="width:1000px; text-align:center; vertical-align: middle;" rowspan="3">Product Name</th>
                    <th style="width:300px; text-align:center; vertical-align: middle;" rowspan="3">UoM</th>
                    <th style="text-align:center; vertical-align: middle;" rowspan="2" colspan="3">Opening Stock</th>
                    <th style="text-align:center; vertical-align: middle;" rowspan="2" colspan="3">Stock In</th>
                    <th style="text-align:center; vertical-align: middle;" rowspan="2" colspan="3">Stock Adjustment</th>
                    <th style="text-align:center;" colspan="6">Sales</th>
                    <th style="text-align:center; vertical-align: middle;" rowspan="2" colspan="2">All Sales</th>
                    <th style="text-align:center; vertical-align: middle;" rowspan="2" colspan="3">Closing Stock</th>
                </tr>
                <tr style="background-color:#99c0ff; color:white;">
                    <th style="text-align:center;" colspan="3">Member</th>
                    <th style="text-align:center;" colspan="3">Public</th>
                </tr>
                <tr style="background-color:#99c0ff; color:white;">
                    <th style="width:50px; text-align:center;">Qty</th>
                    <th style="width:200px; text-align:center;">Price</th>
                    <th style="width:200px; text-align:center;">Total</th>
                    <th style="width:50px; text-align:center;">Qty</th>
                    <th style="width:200px; text-align:center;">Price</th>
                    <th style="width:200px; text-align:center;">Total</th>
                    <th style="width:50px; text-align:center;">Qty</th>
                    <th style="width:200px; text-align:center;">Price</th>
                    <th style="width:200px; text-align:center;">Total</th>
                    <th style="width:50px; text-align:center;">Qty</th>
                    <th style="width:200px; text-align:center;">Price</th>
                    <th style="width:200px; text-align:center;">Total</th>
                    <th style="width:50px; text-align:center;">Qty</th>
                    <th style="width:200px; text-align:center;">Price</th>
                    <th style="width:200px; text-align:center;">Total</th>
                    <th style="width:50px; text-align:center;">Qty</th>
                    <th style="width:200px; text-align:center;">Total</th>
                    <th style="width:50px; text-align:center;">Qty</th>
                    <th style="width:200px; text-align:center;">Price</th>
                    <th style="width:200px; text-align:center;">Total</th>
                </tr>
            </thead>
            <tbody id="show_data">
            <?php foreach($report as $row) :?>
                <tr>
                    <td style="text-align:left;"><?php echo $row->stock_category_name; ?></td>
                    <td style="text-align:left;"><?php echo $row->barcode; ?> - <?php echo $row->item_code; ?></td>
                    <td style="text-align:left;"><?php echo $row->item_name; ?></td>
                    <td style="text-align:center;"><?php echo $row->unit_name; ?></td>
                    <td style="text-align:center;"><?php echo $row->beginning_qty; ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->beginning_price,0,",","."); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->beginning_total,0,",","."); ?></td>
                    <td style="text-align:center;"><?php echo $row->stock_in_qty; ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->stock_in_price,0,",","."); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->stock_in_total,0,",","."); ?></td>
                    <td style="text-align:center;"><?php echo $row->stock_adj_qty; ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->stock_adj_price,0,",","."); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->stock_adj_total,0,",","."); ?></td>
                    <td style="text-align:center;"><?php echo $row->sales_mem_qty; ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->sales_mem_price,0,",","."); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->sales_mem_total,0,",","."); ?></td>
                    <td style="text-align:center;"><?php echo $row->sales_pub_qty; ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->sales_pub_price,0,",","."); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->sales_pub_total,0,",","."); ?></td>
                    <td style="text-align:center;"><?php echo $row->all_sales_qty; ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->all_sales_total,0,",","."); ?></td>
                    <td style="text-align:center;"><?php echo $row->remaining_qty; ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->remaining_price,0,",","."); ?></td>
                    <td style="text-align:right;"><?php echo number_format($row->remaining_total,0,",","."); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>