<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    </head>
    <body onload="window.print();window.close();">
        <div style="font-size:8px; font-family:'Verdana'; width:58mm;">
			<label style="font-size:8px; display:block; width:x; height:y; text-align:center;"><strong><?php echo $header->branch_name; ?></strong></label>
			<p style="text-align:center;"><strong><?php echo $header->branch_address; ?></strong></p>
            <table style="width:100%">
                <tr>
                    <td style="width:50%"><?php echo $header->sales_number; ?></td>
                    <td style="width:50%; text-align:right;"><?php echo $header->sales_date; ?></td>
                </tr>
                <tr>
                    <td style="width:50%">Payment : CASH</td>
                    <td style="width:50%; text-align:right;">Cashier : <?php echo $header->cashier_name; ?></td>
                </tr>
            </table>
            <br/>
            <table style="width:100%">
				<tr><td colspan="4" style="border:1px solid;"></td></tr>
				<tr>
					<th style="width:60%">Barang</th>
					<th style="width:10%; text-align:right;">Jumlah</th>
					<th style="width:15%; text-align:right;">Harga</th>
					<th style="width:15%; text-align:right;">Total</th>
				</tr>
				<tr><td colspan="4" style="border:1px solid;"></td></tr>
                <?php foreach($detail->result() as $row) :?>
                    <tr>
                        <td style="width:60%"><?php echo $row->item_name; ?></td>
                        <td style="width:10%; text-align:right;"><?php echo $row->qty; ?></td>
                        <td style="width:15%; text-align:right;"><?php echo number_format($row->price,0,",","."); ?></td>
                        <td style="width:15%; text-align:right;"><?php echo number_format($row->subtotal,0,",","."); ?></td>
                    </tr>
                <?php endforeach; ?>
				<tr><td colspan="4" style="border:1px solid;"></td></tr>
            </table>
            <table style="width:100%">
				<tr>
					<td style="width:80%; text-align:right;">SUBTOTAL</td>
					<td style="width:5%; text-align:right;"> : </td>
					<td style="width:15%; text-align:right;"><?php echo number_format($header->total_price,0,",","."); ?></td>
				</tr>
				<tr>
					<td style="width:80%; text-align:right;">DISCOUNT</td>
					<td style="width:5%; text-align:right;"> : </td>
					<td style="width:15%; text-align:right;"><?php echo number_format($header->total_disc,0,",","."); ?></td>
				</tr>
				<tr>
					<td colspan="3" style="border:1px solid;"></td>
				</tr>
				<tr>
					<td style="width:80%; text-align:right;">TOTAL</td>
					<td style="width:5%; text-align:right;"> : </td>
					<td style="width:15%; text-align:right;"><?php echo number_format($header->total_transaction,0,",","."); ?></td>
				</tr>
				<tr>
					<td style="width:80%; text-align:right;">PEMBAYARAN</td>
					<td style="width:5%; text-align:right;"> : </td>
					<td style="width:15%; text-align:right;"><?php echo number_format($header->payment,0,",","."); ?></td>
				</tr>
				<tr>
					<td style="width:80%; text-align:right;">KEMBALIAN</td>
					<td style="width:5%; text-align:right;"> : </td>
					<td style="width:15%; text-align:right;"><?php echo number_format($header->exchange,0,",","."); ?></td>
				</tr>
			</table>
            
            <br/>
            
            <br/>
            <label style="display:block; width:x; height:y; text-align:center;"> === Terima Kasih === </label>
        </div>
    </body>
</html>