<?php
$this->load->view('template/header');
?>
<!--tambahkan custom css disini-->
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<form class="form">
		<section class="content">
			<div class="box box-info">
				<div class="box-header with-border">
					<button type="button" class="btn btn-info" id="PrintButton">Print</button>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div style="font-size:10px; font-family:'Verdana'; width:150mm;">
								<p style="text-align:center;"><strong><?php echo $header->branch_name; ?></strong></p>
								<p style="text-align:center;"><strong><?php echo $header->branch_address; ?></strong></p>
								<table style="width:100%">
									<tr>
										<td style="width:50%"><?php echo $header->sales_number; ?><input type="hidden" class="form-control" id="salesnumber" name="salesnumber" value="<?php echo $header->sales_number; ?>"></td>
										<td style="width:50%; text-align:right;"><?php echo $header->sales_date; ?></td>
									</tr>
									<tr>
										<td style="width:50%">Payment : CASH</td>
										<td style="width:50%; text-align:right;">Cashier : <?php echo $header->cashier_name; ?></td>
									</tr>
								</table>
								<br />
								<table style="width:100%">
									<tr>
										<td colspan="4" style="border:1px solid;"></td>
									</tr>
									<tr>
										<th style="width:60%">Barang</th>
										<th style="width:10%; text-align:right;">Jumlah</th>
										<th style="width:15%; text-align:right;">Harga</th>
										<th style="width:15%; text-align:right;">Total</th>
									</tr>
									<tr>
										<td colspan="4" style="border:1px solid;"></td>
									</tr>
									<?php foreach ($detail->result() as $row) : ?>
										<tr>
											<td style="width:60%"><?php echo $row->item_name; ?></td>
											<td style="width:10%; text-align:right;"><?php echo $row->qty; ?></td>
											<td style="width:15%; text-align:right;"><?php echo number_format($row->price, 0, ",", "."); ?></td>
											<td style="width:15%; text-align:right;"><?php echo number_format($row->subtotal, 0, ",", "."); ?></td>
										</tr>
									<?php endforeach; ?>
									<tr>
										<td colspan="4" style="border:1px solid;"></td>
									</tr>
								</table>
								<table style="width:100%">
									<tr>
										<td style="width:80%; text-align:right;">SUBTOTAL</td>
										<td style="width:5%; text-align:right;"> : </td>
										<td style="width:15%; text-align:right;"><?php echo number_format($header->total_price, 0, ",", "."); ?></td>
									</tr>
									<tr>
										<td style="width:80%; text-align:right;">DISCOUNT</td>
										<td style="width:5%; text-align:right;"> : </td>
										<td style="width:15%; text-align:right;"><?php echo number_format($header->total_disc, 0, ",", "."); ?></td>
									</tr>
									<tr>
										<td colspan="3" style="border:1px solid;"></td>
									</tr>
									<tr>
										<td style="width:80%; text-align:right;">TOTAL</td>
										<td style="width:5%; text-align:right;"> : </td>
										<td style="width:15%; text-align:right;"><?php echo number_format($header->total_transaction, 0, ",", "."); ?></td>
									</tr>
									<tr>
										<td style="width:80%; text-align:right;">PEMBAYARAN</td>
										<td style="width:5%; text-align:right;"> : </td>
										<td style="width:15%; text-align:right;"><?php echo number_format($header->payment, 0, ",", "."); ?></td>
									</tr>
									<tr>
										<td style="width:80%; text-align:right;">KEMBALIAN</td>
										<td style="width:5%; text-align:right;"> : </td>
										<td style="width:15%; text-align:right;"><?php echo number_format($header->exchange, 0, ",", "."); ?></td>
									</tr>
								</table>

								<br />

								<br />
								<label style="display:block; width:x; height:y; text-align:center;"> === Terima Kasih === </label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</form>

</div>

<?php
$this->load->view('template/js');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#PrintButton').click(function(e) {
			get_print();
		});
	});

	function get_print() {
		var salesnumber = $('#salesnumber').val();
		var win = window.open('<?php echo site_url() ?>sales/sales_hist/get_print/' + salesnumber, '_blank');
		if (win) {
			win.focus();
		} else {
			Swal.fire({
				icon: 'warning',
				title: "Peringatan",
				text: "Please allow popups for this website",
			})
		}
	}
</script>
<?php
$this->load->view('template/footer');
?>