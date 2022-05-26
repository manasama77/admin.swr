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

	<form id="frmSales" class="form">

		<section class="content">
			<div id="sales_form" class="box box-solid">
				<div class="box-header with-border">
					<button type="button" class="btn bg-navy btn-flat btn-lg" id="CheckStockButton">Cek Stok Barang</button>
					<button type="button" class="btn bg-navy btn-flat btn-lg" id="CheckPriceButton">Cek Harga Barang</button>
					<button type="button" class="btn bg-navy btn-flat btn-lg" id="CancelButton">Batal Penjualan</button>
					<button type="button" class="btn bg-navy btn-flat btn-lg pull-right" id="PaymentButton">Pembayaran</button>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>No. Nota</label>
								<input type="text" class="form-control" id="salesnumber" name="salesnumber" readonly>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Tanggal</label>
								<input type="text" class="form-control" id="salesdate" name="salesdate" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<label style="font-size:50px; color:red; display:block; width:x; height:y; text-align:right;" id="strtotaltrans" name="strtotaltrans">0</label>
							<input type="hidden" class="form-control" id="totaltrans" name="totaltrans" value="0">
							<input type="hidden" class="form-control" id="payment" name="payment" value="0">
							<input type="hidden" class="form-control" id="noitem" name="noitem" value="0">
							<input type="hidden" class="form-control" id="intpaymenttype" name="intpaymenttype" value="0">
							<input type="hidden" class="form-control" id="intbankid" name="intbankid" value="0">
							<input type="hidden" class="form-control" id="strcardholder" name="strcardholder" value="">
							<input type="hidden" class="form-control" id="strcardnumber" name="strcardnumber" value="">
							<input type="hidden" class="form-control" id="strnotes" name="strnotes" value="">
							<input type="hidden" class="form-control" id="cashierid" name="cashierid" value="">
						</div>
					</div>
					<div class="row">
						<div class="col-md-11">
							<div class="form-group has-error">
								<select class="form-control select2" id="barcode" name="barcode" style="width: 100%;">
									<option value='0' selected>Silahkan Pilih</option>
									<?php foreach ($item->result() as $row) : ?>
										<?php echo "<option value='" . $row->barcode . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-1">
							<button type="button" class="btn btn-info" id="btnAddItem">Tambah</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="direct-chat-messages">
								<table class="table">
									<thead>
										<tr style="font-weight:bold">
											<td style="width:70%">Nama Barang</td>
											<td style="width:10%; text-align:right">Harga</td>
											<td style="width:5%; text-align:center">Jumlah</td>
											<td style="width:10%; text-align:right">Total</td>
											<td style="width:5%; text-align:center">Opsi</td>
										</tr>
									</thead>
									<tbody id="itemlist">

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div id="loading_sign_form" class="overlay">
					<i class="fa fa-refresh fa-spin"></i>
				</div>
			</div>

		</section>
	</form>

	<div class="modal fade" id="EditModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" style="text-align:center;"><strong>Edit</strong></h4>
				</div>
				<form class="form-horizontal">
					<div class="modal-body">
						<input type="hidden" class="form-control" id="orderitemmodal" name="orderitemmodal" value="0">
						<input type="hidden" class="form-control" id="barcodemodal" name="barcodemodal" value="0">
						<input type="hidden" class="form-control" id="pricemodal" name="pricemodal" value="0">
						<input type="hidden" class="form-control" id="discmodal" name="discmodal" value="0">
						<input type="hidden" class="form-control" id="extdiscmodal" name="extdiscmodal" value="0">
						<input type="hidden" class="form-control" id="minpricemodal" name="minpricemodal" value="0">

						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Barang</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="namabarangmodal" name="namabarangmodal" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Tambahan Disc</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="editextdisc" name="editextdisc">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Jumlah Barang</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="editqty" name="editqty">
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success pull-left" data-dismiss="modal">Cancel</button>
						<button type="button" id="btnChange" class="btn btn-danger pull-right">Change</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="PaymentModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" style="text-align:center;"><strong>Pembayaran</strong></h4>
				</div>
				<form class="form-horizontal">
					<div class="modal-body">
						<div class="form-group">
							<label class="col-sm-4 control-label">Nomor Nota</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nomornota" name="nomornota" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Tanggal</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="tanggalnota" name="tanggalnota" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Total Pembelian</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="total" name="total" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Cara Bayar</label>
							<div class="col-sm-6">
								<select class="form-control select2" id="paymenttype" name="paymenttype" style="width: 100%;">
									<option value='1' selected>Tunai</option>
									<option value='2'>Kartu Debit</option>
									<option value='3'>Kartu Kredit</option>
									<option value='4'>Transfer</option>
								</select>
							</div>
						</div>
						<div id="bayarTunai">
							<div class="form-group">
								<label class="col-sm-4 control-label">Pembayaran</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="modalpayment" name="modalpayment" value="0">
								</div>
							</div>
						</div>
						<div id="bayarNonTunai">
							<div class="form-group">
								<label class="col-sm-4 control-label">Bank</label>
								<div class="col-sm-6">
									<select class="form-control select2" id="bankid" name="bankid" style="width: 100%;">
										<option value='0' selected>Silahkan Pilih</option>
										<?php foreach ($bank->result() as $row) : ?>
											<?php echo "<option value='" . $row->bank_id . "'>(" . $row->bank_code . ") " . $row->bank_name . "</option>"; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Nama Pemegang Kartu</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="cardholder" name="cardholder">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Nomor Kartu</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="cardnumber" name="cardnumber">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Catatan</label>
								<div class="col-sm-6">
									<textarea style="width:100%" rows="4" id="notes" name="notes"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success pull-left" data-dismiss="modal">Batal</button>
						<button type="button" id="btnSave" class="btn btn-danger pull-right">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="CheckStockModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" style="text-align:center;"><strong>Cek Stok Barang</strong></h4>
				</div>
				<form action="#" id="form" class="form-horizontal">
					<div class="modal-body">
						<div class="col-md-12">
							<div class="form-group">
								<label>Jenis Barang</label>
								<select class="form-control select2" id="searchstockitemid" name="searchstockitemid" style="width: 100%;">
									<option value='0' selected>Silahkan Pilih</option>
									<?php foreach ($item->result() as $row) : ?>
										<?php echo "<option value='" . $row->item_id . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button type="button" class="btn btn-success" data-dismiss="modal">Kembali</button>
								<button type="button" id="btnSearchStock" class="btn btn-danger">Cari</button>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped">
									<thead>
										<tr>
											<th style="width:80%">Cabang</th>
											<th style="width:20%">Jumlah</th>
										</tr>
									</thead>
									<tbody id="itemSearchStock"></tbody>
								</table>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="CheckPriceModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" style="text-align:center;"><strong>Cek Harga Barang</strong></h4>
				</div>
				<form action="#" id="form" class="form-horizontal">
					<div class="modal-body">

						<div class="form-group">
							<label class="col-sm-4 control-label">Jenis Barang</label>
							<div class="col-sm-6">
								<select class="form-control select2" id="searchpriceitemid" name="searchpriceitemid" style="width: 100%;">
									<option value='0' selected>Silahkan Pilih</option>
									<?php foreach ($item->result() as $row) : ?>
										<?php echo "<option value='" . $row->item_id . "'>(" . $row->barcode . ") " . $row->item_name . "</option>"; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label"></label>
							<div class="col-sm-6">
								<button type="button" class="btn btn-success" data-dismiss="modal">Kembali</button>
								<button type="button" id="btnSearchPrice" class="btn btn-danger">Cari</button>
							</div>
						</div>

						<div id="searchpriceresult">
							<div class="form-group">
								<label class="col-sm-4 control-label">Mulai Berlaku</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="searchstartdate" name="searchstartdate" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Harga Penjualan</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="searchsellingprice" name="searchsellingprice" readonly>
								</div>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>

</div>

<?php
$this->load->view('template/js');
?>
<script type="text/javascript">
	//Initialize Select2 Elements
	$(".select2").select2();

	$("tbody#itemlist").on("click", "#edit", function() {
		$('#orderitemmodal').val($(this).parent().parent().find('#orderitem').val());
		$('#barcodemodal').val($(this).parent().parent().find('#barcode').val());

		$('#minpricemodal').val($(this).parent().parent().find('#minprice').val());
		$('#namabarangmodal').val($(this).parent().parent().find('.itemName').html());

		var pricemodal = $(this).parent().parent().find('.itemPrice').html();
		$('#pricemodal').val(pricemodal.replace(/[^0-9-,]/g, ''));

		var discmodal = $(this).parent().parent().find('.itemDisc').html();
		$('#discmodal').val(discmodal.replace(/[^0-9-,]/g, ''));

		var extdiscmodal = $(this).parent().parent().find('.itemExtDisc').html();
		$('#extdiscmodal').val(extdiscmodal.replace(/[^0-9-,]/g, ''));
		$('#editextdisc').val(extdiscmodal.replace(/[^0-9-,]/g, ''));

		$('#editqty').val($(this).parent().parent().find('.itemQty').html());

		$('#EditModal').modal('show');
		$('#editqty').focus();
	});

	$("tbody#itemlist").on("click", "#hapus", function() {
		var totaltrans = $("#totaltrans").val();
		var amount = $(this).parent().parent().find('.itemAmount').html();
		var newtotaltrans = parseFloat(totaltrans.replace(/[^0-9-,]/g, '')) - parseFloat(amount.replace(/[^0-9-,]/g, ''));

		$('#strtotaltrans').text(thousandmaker(newtotaltrans));
		$('#totaltrans').val(newtotaltrans);

		$(this).parent().parent().remove();
	});

	$(document).ready(function() {
		prepare_page();

		var salesT = $("#SalesTable").DataTable({
			'searching': false,
			'ordering': false,
			'paging': false,
			'pageLength': 10
		});

		$('#CheckStockButton').click(function(e) {
			$('#CheckStockModal').modal('show');
		});

		$('#CheckPriceButton').click(function(e) {
			$('#searchpriceresult').hide();
			$('#CheckPriceModal').modal('show');
		});

		$('#CancelButton').click(function(e) {
			location.reload();
		});
		/*
		        $("#barcode").on('keydown', function (e) {
					var barcode = $('#barcode').val();
		            if ((e.keyCode == 9) || (e.keyCode == 13)) {
						if ((barcode != "") && (barcode >= 0)){
							$("#newqty").val(barcode);
							add_item();
						}
						$("#barcode").val("");
						$("#barcode").focus();
		            }
		        });
		*/
		$('#btnAddItem').click(function() {
			var barcode = $('#barcode :selected').val();
			if (barcode != '0') {
				add_item();
			} else {
				Swal.fire({
					icon: 'warning',
					title: "Peringatan",
					text: "Silahkan Pilih Barang Yang Dibeli",
				})
			}
		});

		/*
		$("#editqty").on('keydown', function (e) {
			if ((e.keyCode == 9) || (e.keyCode == 13)) {
				edit_item();
			}
		});
		
		function alignModal() {
            var modalDialog = $(this).find(".modal-dialog");
            modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        
        $(".modal").on("shown.bs.modal", alignModal);
        
        $(window).on("resize", function () {
            $(".modal:visible").each(alignModal);
        });
		*/
		$('#btnChange').click(function() {
			edit_item();
		});

		$('#btnSearchStock').click(function() {
			search_stock();
		});

		$('#CheckStockModal').on('hidden.bs.modal', function() {
			//alert('tutup');
		})

		$('#btnSearchPrice').click(function() {
			search_price();
		});

		$('#PaymentButton').click(function(e) {
			e.preventDefault();
			var frm = $('#frmSales');
			var tottrans = $("#totaltrans").val();
			$("#total").val(thousandmaker(tottrans));

			if (tottrans > 0) {
				//$('#modalpayment').focus();
				$("#bayarTunai").show();
				$("#bayarNonTunai").hide();
				$('#PaymentModal').modal('show');
			}
		});

		$("#paymenttype").change(function() {
			var paymenttype = $("#paymenttype option:selected").val();
			var total = $("#total").val();

			if (paymenttype == 1) {
				$('#modalpayment').val(0);
				$("#bayarTunai").show();
				$("#bayarNonTunai").hide();
			} else {
				$('#modalpayment').val(total.replace(/[^0-9-,]/g, ''));
				$("#bayarTunai").hide();
				$("#bayarNonTunai").show();
			}
		});

		$('#btnSave').click(function() {
			var paymenttype = $("#paymenttype option:selected").val();
			$("#intpaymenttype").val(paymenttype);

			var bankid = $("#bankid option:selected").val();
			$("#intbankid").val(bankid);

			var cardholder = $("#cardholder").val();
			$("#strcardholder").val(cardholder);

			var cardnumber = $("#cardnumber").val();
			$("#strcardnumber").val(cardnumber);

			var notes = $("#notes").val();
			$("#strnotes").val(notes);

			var frm = $('#frmSales');
			var tottrans = $("#totaltrans").val();
			//var translimit = $("#translimit").val();
			var modalpayment = $('#modalpayment').val();
			var salesnumber = $('#salesnumber').val();

			$('#PaymentModal').modal('hide');

			if (parseFloat(tottrans) > parseFloat(modalpayment)) {
				Swal.fire({
					icon: 'warning',
					title: "Peringatan",
					text: "Pembayaran kurang dari Total Pembelian",
				})
			} else {
				$('#loading_sign_form').show();
				$('#payment').val(modalpayment);

				$.ajax({
					type: 'POST',
					url: '<?php echo site_url() ?>sales/sales/create_post',
					dataType: 'JSON',
					data: frm.serialize(),
					success: function(data) {
						if (data != "-1") {
							var win = window.open('<?php echo site_url() ?>sales/sales/get_print/' + salesnumber, '_blank');
							if (win) {
								//Browser has allowed it to be opened
								win.focus();
							} else {
								//Browser has blocked it
								alert('Please allow popups for this website');
							}
							location.reload();
						} else {
							Swal.fire({
								icon: 'warning',
								title: "Peringatan",
								text: "Gagal menyimpan data transaksi penjualan",
							})
						}
					},
					error: function() {
						Swal.fire({
							icon: 'warning',
							title: "Peringatan",
							text: "Gagal menyimpan data transaksi penjualan",
						})
					}
				});

				$('#loading_sign_form').hide();
			}
		});
	});

	function prepare_page() {
		$('#loading_sign_form').show();
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo site_url() ?>sales/sales/validate_logincode',
			success: function(data) {
				var userid = Number(data.userid);
				$('#cashierid').val(userid);

				$('#salesnumber').val(data.transnumber);
				$('#salesdate').val(data.transdate);

				$('#nomornota').val(data.transnumber);
				$('#tanggalnota').val(data.transdate);

				$("#CheckStockButton").prop('disabled', false);
				$("#CheckPriceButton").prop('disabled', false);
				$("#CancelButton").prop('disabled', false);
				$("#PaymentButton").prop('disabled', false);

				$('#barcode').focus();

			},
		});
		$('#loading_sign_form').hide();
	}

	function add_item() {
		$('#loading_sign_form').show();

		var barcode = $('#barcode :selected').val();
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo site_url() ?>sales/sales/get_item_price_promo',
			data: {
				barcode: barcode
			},
			success: function(data) {
				var totalqty = Number(data.totalqty);
				var sellingprice = Number(data.sellingprice);

				if (totalqty <= 0) {
					Swal.fire({
						icon: 'warning',
						title: "Peringatan",
						text: "Jumlah Barang di Sistem tidak cukup untuk melakukan penjualan",
					})
				} else if (sellingprice <= 0) {
					Swal.fire({
						icon: 'warning',
						title: "Peringatan",
						text: "Harga Barang untuk hari ini belum diset",
					})
				} else {
					var totaltrans = $("#totaltrans").val();
					var noitem = $("#noitem").val();

					var discamount = Number(data.discamount);
					var amount = Number(sellingprice) - Number(discamount);

					totaltrans = Number(totaltrans) + Number(amount);

					noitem = parseInt(noitem) + 1;

					var items = "";
					items += "<tr id='product" + noitem + "'>";
					items += "<td style='width:60%' class='itemName'> " + data.itemname + "</td>";
					items += "<td style='width:10%; text-align:right;' class='itemPrice'>" + thousandmaker(sellingprice) + "</td>";
					items += "<td style='width:5%; text-align:right;' class='itemQty'><input style='text-align:center;' onkeyup='count_qty(" + noitem + ")' type='text' id='itemQty" + noitem + "' name='item[itemQty][]' value='1' autocomplete='off'></td>";
					items += "<td style='width:10%; text-align:right;' class='itemAmount'>" + thousandmaker(amount) + "</td>";
					items += "<td style='width:5%; text-align:center;'>" +
						"<input type='hidden' id='orderitem' name='orderitem' value='" + noitem + "'> " +
						"<input type='hidden' id='barcode" + noitem + "' name='barcode' value='" + barcode + "'> " +
						"<input type='hidden' id='sellingprice" + noitem + "' name='sellingprice' value='" + sellingprice + "'> " +
						"<input type='hidden' id='itemId" + noitem + "' name='item[itemId][]' value='" + data.itemid + "'> " +
						"<input type='hidden' id='itemPrice" + noitem + "' name='item[itemPrice][]' value='" + sellingprice + "'> " +
						"<input type='hidden' id='itemExtDisc" + noitem + "' name='item[itemExtDisc][]' value='0'> " +
						"<input type='hidden' id='itemAmount" + noitem + "' name='item[itemAmount][]' value='" + amount + "'> " +
						"<button type='button' class='btn btn-sm btn-white' id='hapus'><i class='fa fa-trash'></i></button></td>";
					items += "</tr>";

					$("#itemlist").append(items);

					$('#strtotaltrans').text(thousandmaker(totaltrans));
					$('#totaltrans').val(totaltrans);
					$('#noitem').val(noitem);
					$('#lastitemid').val(data.itemid);
				}
				$('#barcode').focus();
			},
			error: function(data) {
				console.log('error');
				/*
								var newqty = $('#newqty').val();
								var itemid = $("#lastitemid").val();
								
								if (newqty <= 0){
									$("#WarningContent").replaceWith("<div id='WarningContent'>Please Input Qty more than 1</div>");
									$('#WarningModal').modal('show');
								}
								else{
									$.ajax({
										type     : 'POST',
										dataType : 'JSON',
										url      : '<?php echo site_url() ?>sales/sales/check_qty',
										data     :{
											itemid : itemid
										},
										success: function(data){
											var totalqty = data.totalqty;
										
											if(parseFloat(totalqty) < parseFloat(newqty)){
												$("#WarningContent").replaceWith("<div id='WarningContent'>Item Qty in System is not enought for Sales</div>");
												$('#WarningModal').modal('show');
											}
											else{
												var totaltrans = $("#totaltrans").val();
								
												var noitem = $("#noitem").val();
												var qty = $("#product" + noitem + " td.qty").html();
												var itemprice = $("#product" + noitem + " td.itemprice").html();
												var amount = $("#product" + noitem + " td.amount").html();
												
												var selisih = newqty - qty;
												var selisihharga = itemprice * selisih;
												var newsubtotal = itemprice * newqty;
												
												$("#product" + noitem + " td.qty").html(newqty);
												$("#qty" + noitem).val(newqty);
												
												$("#product" + noitem + " td.amount").html(newsubtotal);
												$("#amount" + noitem).val(newsubtotal);
												
												var totaltrans = parseFloat(totaltrans.replace(/[^0-9-,]/g, '')) + parseFloat(selisihharga);
												
												$('#strtotaltrans').text(thousandmaker(totaltrans));
												$('#totaltrans').val(totaltrans);
											}
										}
									});
								}*/
			}
		});

		$('#loading_sign_form').hide();
		$("#barcode").val('0').change();
		$("#barcode").focus();
	}

	function count_ext_disc(noitemnow) {
		var wholesaleprice = $('#wholesaleprice' + noitemnow).val();
		var minprice = $('#minprice' + noitemnow).val();
		var itemPrice = $('#itemPrice' + noitemnow).val();
		var itemExtDisc = $('#itemExtDisc' + noitemnow).val();
		var itemQty = $('#itemQty' + noitemnow).val();
		var allowedDisc = 0
		var totAllowedDisc = 0;

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo site_url() ?>sales/sales/wholesale_limit',
			success: function(data) {
				var wholesalelimit = data.wholesalelimit;

				if (parseInt(itemQty) >= parseInt(wholesalelimit)) {
					allowedDisc = parseFloat(itemPrice) - parseFloat(wholesaleprice);
					totAllowedDisc = allowedDisc * itemQty;
				} else {
					allowedDisc = parseFloat(itemPrice) - parseFloat(minprice);
					totAllowedDisc = allowedDisc * itemQty;
				}

				var newsubtotal = 0;
				if (parseFloat(totAllowedDisc) < parseFloat(itemExtDisc)) {
					$('#itemExtDisc' + noitemnow).val(0);
					Swal.fire({
						icon: 'warning',
						title: "Peringatan",
						text: "Harga Jual tidak bisa kurang dari Harga Terendah",
					})
					newsubtotal = (parseFloat(itemPrice) * itemQty);
				} else {
					newsubtotal = (parseFloat(itemPrice) * itemQty) - parseFloat(itemExtDisc);
				}

				$("#product" + noitemnow + " td.itemAmount").html(thousandmaker(newsubtotal));
				$("#itemAmount" + noitemnow).val(newsubtotal);

				var totaltrans = 0;
				var noitem = $("#noitem").val();
				for (ii = 1; ii <= noitem; ii++) {
					amount = $("#itemAmount" + ii).val();
					totaltrans = parseFloat(totaltrans) + parseFloat(amount);
				}

				$('#strtotaltrans').text(thousandmaker(totaltrans));
				$('#totaltrans').val(totaltrans);
			},
			error: function(data) {
				//console.log(data);
			}
		});

	}

	function count_qty(noitemnow) {
		var barcode = $('#barcode' + noitemnow).val();
		var itemQty = $('#itemQty' + noitemnow).val();

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo site_url() ?>sales/sales/check_qty',
			data: {
				barcode: barcode
			},
			success: function(data) {
				var totalqty = data.totalqty;

				if (parseFloat(totalqty) < parseFloat(itemQty)) {
					$('#itemQty' + noitemnow).val(1);
					Swal.fire({
						icon: 'warning',
						title: "Peringatan",
						text: "Jumlah Barang di Sistem tidak cukup untuk melakukan penjualan",
					})
					count_qty(noitemnow);
				} else {
					$("#itemExtDisc" + noitemnow).val(0);

					//var newitemprice = parseFloat(itemPrice) - parseFloat(itemExtDisc);
					var itemPrice = $('#itemPrice' + noitemnow).val();
					var newsubtotal = parseFloat(itemPrice) * itemQty;

					$("#product" + noitemnow + " td.itemAmount").html(thousandmaker(newsubtotal));
					$("#itemAmount" + noitemnow).val(newsubtotal);

					var totaltrans = 0;
					var noitem = $("#noitem").val();
					for (ii = 1; ii <= noitem; ii++) {
						amount = $("#itemAmount" + ii).val();
						totaltrans = parseFloat(totaltrans) + parseFloat(amount);
					}

					$('#strtotaltrans').text(thousandmaker(totaltrans));
					$('#totaltrans').val(totaltrans);
				}
			}
		});
	}

	/*
	function edit_item(){
		
		var noitem = $("#orderitemmodal").val();
		var barcode = $("#barcodemodal").val();
		var itemprice = $("#pricemodal").val();
		var disc = $("#discmodal").val();
		var extdisc = $("#extdiscmodal").val();
		var minprice = $("#minpricemodal").val();
		
		var newextdisc = $("#editextdisc").val();
		var newqty = $("#editqty").val();
		
		$('#EditModal').modal('hide');
		
		if(newqty > 0){
			$.ajax({
				type     : 'POST',
				dataType : 'JSON',
				url      : '<?php echo site_url() ?>sales/sales/check_qty',
				data     :{
					barcode : barcode
				},
				success: function(data){
					var totalqty = data.totalqty;
					var newitemprice = (parseFloat(itemprice) - parseFloat(disc) - parseFloat(newextdisc));
					
					if(parseFloat(totalqty) < parseFloat(newqty)){
						Swal.fire({
							icon: 'warning',
							title: "Peringatan",
							text: "Jumlah Barang di Sistem tidak cukup untuk melakukan penjualan",
						})
					}
					else if(parseFloat(newitemprice) < parseFloat(minprice)){
						Swal.fire({
							icon: 'warning',
							title: "Peringatan",
							text: "Harga Jual tidak bisa kurang dari Harga Terendah",
						})
					}
					else{
						var totaltrans = $("#totaltrans").val();
			
						var qty = $("#product" + noitem + " td.itemQty").html();
						//var itemprice = $("#product" + noitem + " td.itemprice").html();
						var amount = $("#product" + noitem + " td.itemAmount").html();
						
						var selisihharga = 0;
						var selisih = newqty - qty;
						var newsubtotal = (parseFloat(itemprice) - parseFloat(disc) - parseFloat(newextdisc)) * newqty;

						amount = amount.replace(/[^0-9-,]/g, '');
						selisihharga = newsubtotal - amount;
						
						$("#product" + noitem + " td.itemExtDisc").html(thousandmaker(newextdisc));
						$("#itemExtDisc" + noitem).val(newextdisc);
						
						$("#product" + noitem + " td.itemQty").html(newqty);
						$("#itemQty" + noitem).val(newqty);
						
						$("#product" + noitem + " td.itemAmount").html(thousandmaker(newsubtotal));
						$("#itemAmount" + noitem).val(newsubtotal);
						
						totaltrans = parseFloat(totaltrans) + parseFloat(selisihharga);
						
						$('#strtotaltrans').text(thousandmaker(totaltrans));
						$('#totaltrans').val(totaltrans);
					}
				}
			});
		}
		else {
			Swal.fire({
				icon: 'warning',
				title: "Peringatan",
				text: "Jumlah Barang harus lebih dari 0",
			})
		}
	}
*/
	function search_stock() {
		var itemid = $("#searchstockitemid option:selected").val();
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo site_url() ?>sales/sales/search_stock',
			data: {
				itemid: itemid
			},
			success: function(data) {
				var html = '';
				$.each(data, function(i, item) {
					html += "<tr>" +
						"<td style='width:80%' class='itemStockItem'>" + item.branch_name + "</td>" +
						"<td style='width:20%' class='itemQty'>" + item.qty + "</td>" +
						"</tr>";
				});
				$("#itemSearchStock").empty();
				$("#itemSearchStock").append(html);

			},
			error: function(data) {}
		});
	}

	function search_price() {
		var itemid = $("#searchpriceitemid option:selected").val();
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo site_url() ?>sales/sales/search_price',
			data: {
				itemid: itemid
			},
			success: function(data) {
				if (data.start_period != '') {
					$("#searchpriceresult").show();
					$("#searchstartdate").val(data.start_period);
					$("#searchsellingprice").val(thousandmaker(data.selling_price));
				} else {
					$("#searchpriceresult").hide();
					$("#searchstartdate").val('');
					$("#searchsellingprice").val('');
					Swal.fire({
						icon: 'warning',
						title: "Peringatan",
						text: "Data Harga Barang tidak ditemukan. Silahkan Cek Master Data Harga Barang",
					})
				}

			},
			error: function(data) {}
		});
	}

	function thousandmaker(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}
</script>
<?php
$this->load->view('template/footer');
?>