<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
</head>

<body onload="window.print();">
	<div style="font-size:6px; font-family:'Verdana'; width:50mm;">
		<label style="font-size:8px; display:block; width:x; height:y; text-align:center;"><strong><?php echo $header->branch_name; ?></strong></label>
		<p style="text-align:center;"><strong><?php echo $header->branch_address; ?></strong></p>
		<br>
		<br>
		<table style="width:100%">
			<tr>
				<td style="width:50%"><?php echo $header->sales_number; ?></td>
				<td style="width:50%; text-align:right;"><?php echo $header->sales_date; ?></td>
			</tr>
			<tr>
				<td style="width:50%">Pembayaran : <?php echo $header->payment_type; ?></td>
				<td style="width:50%; text-align:right;">Kasir : <?php echo $header->cashier_name; ?></td>
			</tr>
		</table>
		<br>
		<table style="width:100%">
			<tr>
				<td colspan="3" style="border:1px solid;"></td>
			</tr>
			<tr>
				<th style="width:30%; text-align:center;">ITEM(s)</th>
				<th style="width:35%; text-align:right;">HARGA</th>
				<th style="width:35%; text-align:right;">TOTAL</th>
			</tr>
			<tr>
				<td colspan="3" style="border:1px solid;"></td>
			</tr>
			<?php foreach ($detail->result() as $row) : ?>

				<tr>
					<td colspan="3" style="width:100%"><?php echo $row->item_name; ?></td>
				</tr>
				<tr>
					<td style="width:30%; text-align:center;"><?php echo $row->qty; ?> X</td>
					<td style="width:35%; text-align:right;"><?php echo number_format($row->price, 0, ",", "."); ?></td>
					<td style="width:35%; text-align:right;"><?php echo number_format($row->subtotal, 0, ",", "."); ?></td>
				</tr>

			<?php endforeach; ?>
			<tr>
				<td colspan="3" style="border:1px solid;"></td>
			</tr>
		</table>
		<table style="width:100%">
			<tr>
				<td style="width:65%; text-align:right;">JUMLAH</td>
				<td style="width:5%; text-align:right;"> : </td>
				<td style="width:30%; text-align:right;"><?php echo number_format($header->total_price, 0, ",", "."); ?></td>
			</tr>
			<tr>
				<td style="width:65%; text-align:right;">TOTAL HARGA</td>
				<td style="width:5%; text-align:right;"> : </td>
				<td style="width:30%; text-align:right;"><?php echo number_format($header->total_transaction, 0, ",", "."); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td style="width:65%; text-align:right;">BAYAR</td>
				<td style="width:5%; text-align:right;"> : </td>
				<td style="width:30%; text-align:right;"><?php echo number_format($header->payment, 0, ",", "."); ?></td>
			</tr>
			<tr>
				<td style="width:65%; text-align:right;">KEMBALI</td>
				<td style="width:5%; text-align:right;"> : </td>
				<td style="width:30%; text-align:right;"><?php echo number_format($header->exchange, 0, ",", "."); ?></td>
			</tr>
		</table>

		<br />
		<label><?php echo $header->sales_notes; ?></label>
	</div>
</body>

</html>