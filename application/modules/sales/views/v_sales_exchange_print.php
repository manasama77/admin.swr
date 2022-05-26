<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    </head>
    <body onload="window.print();window.close();">
        <div style="font-size:9px; font-family:'Verdana'; width:80mm;">
			<label style="font-size:12px; display:block; width:x; height:y; text-align:center;"><strong><?php echo $header->branch_name; ?></strong></label>
			<label><strong><?php echo $header->branch_address; ?></strong></label>
			<br>
			<br>
            <table style="width:100%">
                <tr>
                    <td style="width:50%"><?php echo $header->sales_exchange_number; ?></td>
                    <td style="width:50%; text-align:right;"><?php echo $header->sales_exchange_date; ?></td>
                </tr>
                <tr>
                    <td style="width:50%">Pembayaran : TUNAI</td>
                    <td style="width:50%; text-align:right;">Kasir : <?php echo $header->cashier_name; ?></td>
                </tr>
            </table>
			<br>
            <table style="width:100%">
				<tr><td colspan="3" style="border:1px solid;"></td></tr>
				<tr>
					<th style="width:30%; text-align:right;">ITEM(s)</th>
					<th style="width:35%; text-align:right;">PENAMBAHAN</th>
					<th style="width:35%; text-align:right;">TOTAL</th>
				</tr>
				<tr><td colspan="3" style="border:1px solid;"></td></tr>
				<?php foreach($detail->result() as $row) :?>

                    <tr>
						<td colspan="3"><?php echo $row->item_origin; ?></td>
					</tr>
                    <tr>
						<td colspan="3"><?php echo $row->item_exchange; ?></td>
					</tr>
					<tr>
                        <td style="width:30%; text-align:right;"><?php echo $row->qty_exchange; ?></td>
                        <td style="width:35%; text-align:right;"><?php echo number_format($row->single_extra,0,",","."); ?></td>
                        <td style="width:35%; text-align:right;"><?php echo number_format($row->extra_payment,0,",","."); ?></td>
					</tr>
                    
                <?php endforeach; ?>
				<tr><td colspan="3" style="border:1px solid;"></td></tr>
            </table>
            <table style="width:100%">
				<tr>
					<td style="width:65%; text-align:right;">TOTAL PENAMBAHAN</td>
					<td style="width:5%; text-align:right;"> : </td>
					<td style="width:30%; text-align:right;"><?php echo number_format($header->total_transaction,0,",","."); ?></td>
				</tr>
				<tr>
					<td style="width:65%; text-align:right;">BAYAR</td>
					<td style="width:5%; text-align:right;"> : </td>
					<td style="width:30%; text-align:right;"><?php echo number_format($header->payment,0,",","."); ?></td>
				</tr>
				<tr>
					<td style="width:65%; text-align:right;">KEMBALI</td>
					<td style="width:5%; text-align:right;"> : </td>
					<td style="width:30%; text-align:right;"><?php echo number_format($header->exchange,0,",","."); ?></td>
				</tr>
			</table>
            
            <br/>
            
            <br/>
            <label><?php echo $header->sales_notes; ?></label>
        </div>
    </body>
</html>