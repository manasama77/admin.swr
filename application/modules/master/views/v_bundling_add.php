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

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Promo & Bundling
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Promo & Bundling</li>
    </ol>
</section>

<form class="form-horizontal" action="<?php echo site_url('master/bundling/create_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-sm-2 control-label">Promo & Bundling Code</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="bundlingcode" name="bundlingcode" value="<?php echo $bundlingcode; ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Promo & Bundling Name</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="bundlingname" name="bundlingname">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Start Period</label>
							<div class="col-sm-4">
								<input type="text" class="form-control pull-right" id="datepicker" name="startperiod" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">End Period</label>
							<div class="col-sm-4">
								<input type="text" class="form-control pull-righ" id="datepicker2" name="endperiod" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Customer Type</label>
							<div class="col-sm-4">
								<select class="form-control select2" id="customertype" name="customertype" style="width: 100%;">
									<option value='1'>Public & Member</option>
									<option value='2'>Public</option>
									<option value='3'>Member</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-4">
								<select class="form-control select2" id="status" name="status" style="width: 100%;">
									<option value='0'>Draft</option>
									<option value='1'>Active</option>
									<option value='2'>InActive</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Information</label>
							<div class="col-sm-4">
								<textarea class="form-control" rows="5" id="information" name="information"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Promo Object</label>
							<div class="col-sm-4">
								<select class="form-control select2" id="promoobject" name="promoobject" style="width: 100%;">
									<option value='0' selected>Please Choose...</option>
									<option value='1'>Total Transaction</option>
									<option value='2'>Product</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Promo Gift</label>
							<div class="col-sm-4">
								<select class="form-control select2" id="promogift" name="promogift" style="width: 100%;">
									
								</select>
							</div>
						</div>
					</div>
                </div>
			</div>
		</div>
		<div class="box box-info">
			<div class="box-header with-border">
                <h3 class="box-title">Promo Object</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
						<div id="ObjectTransaction" style="display: none;">
							<div class="form-group">
								<label class="col-sm-2 control-label">Min Trans Amount</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="mintransamount" name="mintransamount" value="0">
								</div>
							</div>
						</div>
						<div id="ObjectProduct" style="display: none;">
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-4">
									<label>
										<input type="checkbox" class="flat-red" checked>&nbsp;&nbsp; Is Multiply
									</label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Object Product Type</label>
								<div class="col-sm-4">
									<select class="form-control select2" id="objectproducttype" name="objectproducttype" style="width: 100%;">
										<option value=''>Please Choose...</option>
										<option value='1'>Single</option>
										<option value='2'>Multi</option>
									</select>
								</div>
							</div>
							<div id="ObjectProductSingle" style="display: none;">
								<div class="form-group">
									<label class="col-sm-2 control-label">Product Item</label>
									<div class="col-sm-4">
										<select class="form-control select2" id="itempromo" name="itempromo" style="width: 100%;">
											<option value='0'>Please Choose...</option>
											<?php foreach($stockitem->result() as $row) :?>
												<?php echo "<option value='". $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Qty</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="qtysingle" name="qtysingle">
									</div>
								</div>
							</div>
							<div id="ObjectProductMulti" style="display: none;">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Remark</th>
											<th>Product</th>
											<th>Qty</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="tablepromo">
										<tr>
											<td style="width:15%">
												<select class="form-control select2" id="remarkpromo" name="remarkpromo" style="width: 100%;">
													<option value=''>Please Choose...</option>
													<option value='AND'>AND</option>
													<option value='OR'>OR</option>
												</select>
											</td>
											<td style="width:60%">
												<select class="form-control select2" id="itempromo" name="itempromo" style="width: 100%;">
													<option value='0'>Please Choose...</option>
													<?php foreach($stockitem->result() as $row) :?>
														<?php echo "<option value='". $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
													<?php endforeach; ?>
												</select>
											</td>
											<td style="width:15%">
												<input type="text" class="form-control" id="qtypromo" name="qtypromo" value="0">
											</td>
											<td style="width:10%">
												<button type="button" class="btn btn-block btn-success" id="AddPromoButton">Add</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
                    </div>
                </div>
			</div>
		</div>
		<div class="box box-info">
			<div class="box-header with-border">
                <h3 class="box-title">Promo Gift</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
						<div id="GiftFixPrice" style="display: none;">
							<div class="form-group">
								<label class="col-sm-2 control-label">Fix Price</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="fixprice" name="fixprice" value="0">
								</div>
							</div>
						</div>
						<div id="GiftDiscount" style="display: none;">
							<div class="form-group">
								<label class="col-sm-2 control-label">Discount Percentage</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="discountpercentage" name="discountpercentage" value="0">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Discount Amount</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="discountamount" name="discountamount" value="0">
								</div>
							</div>
						</div>
						<div id="GiftCashback" style="display: none;">
							<div class="form-group">
								<label class="col-sm-2 control-label">Cashback Amount</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="cashback" name="cashback" value="0">
								</div>
							</div>
						</div>
						<div id="GiftProduct" style="display: none;">
							<div class="form-group">
								<label class="col-sm-2 control-label">Gift Product Type</label>
								<div class="col-sm-4">
									<select class="form-control select2" id="giftproducttype" name="giftproducttype" style="width: 100%;">
										<option value=''>Please Choose...</option>
										<option value='1'>Single</option>
										<option value='2'>Multi</option>
									</select>
								</div>
							</div>
							<div id="GiftProductSingle" style="display: none;">
								<div class="form-group">
									<label class="col-sm-2 control-label">Product Item</label>
									<div class="col-sm-4">
										<select class="form-control select2" id="itempromo" name="itempromo" style="width: 100%;">
											<option value='0'>Please Choose...</option>
											<?php foreach($stockitem->result() as $row) :?>
												<?php echo "<option value='". $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Qty</label>
									<div class="col-sm-4">
										<input type="text" class="form-control" id="bundlingname" name="bundlingname">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Disc Type</label>
									<div class="col-sm-4">
										<select class="form-control select2" id="disctype" name="disctype" style="width: 100%;">
											<option value=''>Please Choose...</option>
											<option value='1'>Percentage</option>
											<option value='2'>Cashback</option>
											<option value='3'>Fix Price</option>
										</select>
									</div>
								</div>
							</div>
							<div id="GiftProductMulti" style="display: none;">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Remark</th>
											<th>Product</th>
											<th>Qty</th>
											<th>Disc Percent</th>
											<th>Disc Amount</th>
											<th>Fix Price</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="tableprize">
										<tr>
											<td style="width:10%">
												<select class="form-control select2" id="remarkprize" name="remarkprize" style="width: 100%;">
													<option value=''>Please Choose...</option>
													<option value='AND'>AND</option>
													<option value='OR'>OR</option>
												</select>
											</td>
											<td style="width:40%">
												<select class="form-control select2" id="itemprize" name="itemprize" style="width: 100%;">
													<option value='0'>Please Choose...</option>
													<?php foreach($stockitem->result() as $row) :?>
														<?php echo "<option value='". $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
													<?php endforeach; ?>
												</select>
											</td>
											<td style="width:10%">
												<input type="text" class="form-control" id="qtyprize" name="qtyprize" value="0">
											</td>
											<td style="width:10%">
												<input type="text" class="form-control" id="discpercent" name="discpercent" value="0">
											</td>
											<td style="width:10%">
												<input type="text" class="form-control" id="discamount" name="discamount" value="0">
											</td>
											<td style="width:10%">
												<input type="text" class="form-control" id="fixprice" name="fixprice" value="0">
											</td>
											<td style="width:10%">
												<button type="button" class="btn btn-block btn-success" id="AddPrizeButton">Add</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/bundling') ?>">Back to List</a>
				<input type="button" class="btn btn-info pull-right" id="SaveButton" value="Save" />
            </div>
        </div>
    </section>
</form>

<div class="modal fade" id="WarningModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" style="text-align:center;"><strong>Notification</strong></h3>
			</div>
			<div class="modal-body">
				<div id="WarningContent"></div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btnClose" class="btn btn-success pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

</div>

<?php 
$this->load->view('template/js');
?>
<script>
    //Initialize Select2 Elements
    $(".select2").select2();

    $('#datepicker').datepicker({
		autoclose: true,
		startDate: new Date()
    }).on('changeDate', function(){
        $('#datepicker2').datepicker('setStartDate', new Date($(this).val()));
    });
	$("#datepicker").datepicker().datepicker("setDate", new Date());
	
    $('#datepicker2').datepicker({
		autoclose: true,
		startDate: new Date()
    }).on('changeDate', function(){
        $('#datepicker').datepicker('setEndDate', new Date($(this).val()));
    });
	
	//Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    $("tbody#tablepromo").on("click", "#hapus", function () {
		$(this).parent().parent().remove();
	});

    $("tbody#tableprize").on("click", "#hapus", function () {
		$(this).parent().parent().remove();
	});

    $(document).ready(function(){
		$("#promoobject").change(function () {
			var promoobject = $('#promoobject option:selected').val();
			if(promoobject == "1"){
				$('#promogift')
					.empty()
					.append('<option value="">Please Choose...</option>')
					.append('<option value="3">Cashback</option>')
					.append('<option value="4">Product</option>')
					
				$("#ObjectTransaction").show();
				$("#ObjectProduct").hide();
				
				$("#GiftFixPrice").hide();
				$("#GiftDiscount").hide();
				$("#GiftProduct").hide();
			}
			else if(promoobject == "2"){
				$('#promogift')
					.empty()
					.append('<option value="">Please Choose...</option>')
					.append('<option value="1">Fix Price</option>')
					.append('<option value="2">Discount</option>')
					.append('<option value="4">Product</option>')
					
				$("#ObjectTransaction").hide();
				$("#ObjectProduct").show();
				
				$("#GiftFixPrice").hide();
				$("#GiftDiscount").hide();
				$("#GiftProduct").hide();
			}
        });
		
		$("#promogift").change(function () {
			var promogift = $('#promogift option:selected').val();
			if(promogift == "1"){
				$("#GiftFixPrice").show();
				$("#GiftDiscount").hide();
				$("#GiftCashback").hide();
				$("#GiftProduct").hide();
			}
			else if(promogift == "2"){
				$("#GiftFixPrice").hide();
				$("#GiftDiscount").show();
				$("#GiftCashback").hide();
				$("#GiftProduct").hide();
			}
			else if(promogift == "3"){
				$("#GiftFixPrice").hide();
				$("#GiftDiscount").hide();
				$("#GiftCashback").show();
				$("#GiftProduct").hide();
			}
			else if(promogift == "4"){
				$("#GiftFixPrice").hide();
				$("#GiftDiscount").hide();
				$("#GiftCashback").hide();
				$("#GiftProduct").show();
			}
        });
		
		$("#objectproducttype").change(function () {
			var objectproducttype = $('#objectproducttype option:selected').val();
			if(objectproducttype == "1"){
				$("#ObjectProductSingle").show();
				$("#ObjectProductMulti").hide();
			}
			else if(objectproducttype == "2"){
				$("#ObjectProductSingle").hide();
				$("#ObjectProductMulti").show();
			}
		});
		
		$("#giftproducttype").change(function () {
			var giftproducttype = $('#giftproducttype option:selected').val();
			if(giftproducttype == "1"){
				$("#GiftProductSingle").show();
				$("#GiftProductMulti").hide();
			}
			else if(giftproducttype == "2"){
				$("#GiftProductSingle").hide();
				$("#GiftProductMulti").show();
			}
		});
		
		$("#promogift").change(function () {
            get_member();
        });
		
        $('#AddPromoButton').click(function (e) {
            e.preventDefault();
			var remarkpromo = $("#remarkpromo option:selected").val();
			var itemidpromo = $("#itempromo option:selected").val();
			var itemnamepromo = $("#itempromo option:selected").text();
			var qtypromo = $("#qtypromo").val();
			
            if (itemidpromo == "0"){
                alert("Please Choose Product first");
            }else if (qtypromo <= "0"){
                alert("Qty product cannot 0");
            }else{
                var items = "";
                items += "<tr>";
                items += "<td style='width:10%'><input type='hidden' name='listpromo[remarkpromo][]' value='" + remarkpromo + "'>" + remarkpromo + "</td>";
                items += "<td style='width:35%'><input type='hidden' name='listpromo[itemidpromo][]' value='" + itemidpromo + "'>" + itemnamepromo + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listpromo[qtypromo][]' value='" + qtypromo + "'>" + qtypromo + "</td>";
                items += "<td style='width:5%'><a href='javascript:void(0);' id='hapus'>Remove</a></td>";
                items += "</tr>";
                
                $("#tablepromo").append(items);
                $("#itempromo option:selected").remove();
				$("#remarkpromo").val("").change();
				$("#itempromo").val("0").change();
				$("#qtypromo").val("0");
            }
        });

        $('#AddPrizeButton').click(function (e) {
            e.preventDefault();
			var remarkprize = $("#remarkprize option:selected").val();
			var itemidprize = $("#itemprize option:selected").val();
			var itemnameprize = $("#itemprize option:selected").text();
			var qtyprize = $("#qtyprize").val();
			var discpercent = $("#discpercent").val();
			var discamount = $("#discamount").val();
			var fixprice = $("#fixprice").val();
			
            if ((discpercent <= 0) && (discamount <= 0) && (fixprice <= 0)){
                alert("Please Set Promo");
            }else{
                var items = "";
                items += "<tr>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[remarkprize][]' value='" + remarkprize + "'>" + remarkprize + "</td>";
                items += "<td style='width:25%'><input type='hidden' name='listprize[itemidprize][]' value='" + itemidprize + "'>" + itemnameprize + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[qtyprize][]' value='" + qtyprize + "'>" + qtyprize + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[discpercent][]' value='" + discpercent + "'>" + discpercent + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[discamount][]' value='" + discamount + "'>" + discamount + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='listprize[fixprice][]' value='" + fixprice + "'>" + fixprice + "</td>";
                items += "<td style='width:5%'><a href='javascript:void(0);' id='hapus'>Remove</a></td>";
                items += "</tr>";
                
                $("#tableprize").append(items);
                $("#itemprize option:selected").remove();
				$("#remarkprize").val("").change();
				$("#itemprize").val("0").change();
				$("#qtyprize").val("0");
				$("#discpercent").val("0");
				$("#discamount").val("0");
				$("#fixprice").val("0");
            }
        });
    });
	
	$('#SaveButton').click(function (e) {
        var bundlingname = $('#bundlingname').val();
        var startperiod = $('#datepicker').val();
        var endperiod = $('#datepicker2').val();
		var promoobject = $('#promoobject option:selected').val();
		var promogift = $('#promogift option:selected').val();
		
        var mintransamount = $('#mintransamount').val();
		var objectproducttype = $('#objectproducttype option:selected').val();
		
        var cashback = $('#cashback').val();
		
        if (bundlingname == ''){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Please input Promo & Bundling Name</div>");
			$('#WarningModal').modal('show');
            return false;
        }
        else if (endperiod == ''){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Please input End Period</div>");
			$('#WarningModal').modal('show');
            return false;
        }
        else if (promoobject == 0){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Please choose Promo Object</div>");
			$('#WarningModal').modal('show');
            return false;
        }
        else if (promogift == ''){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Please choose Promo Gift</div>");
			$('#WarningModal').modal('show');
            return false;
        }
		
		if(promoobject == 1){ // total transaction
			if(mintransamount <= 0){
				$("#WarningContent").replaceWith("<div id='WarningContent'>Min Trans Amount should not be less or equal to zero</div>");
				$('#WarningModal').modal('show');
				return false;
			}
		}
		else if(promoobject == 2){ // product
			if(objectproducttype == ''){
				$("#WarningContent").replaceWith("<div id='WarningContent'>Please choose Object Product Type</div>");
				$('#WarningModal').modal('show');
				return false;
			}
			else{
				
			}
		}
		
		if(promogift == 1){ // fix price
			
		}
		else if(promogift == 2){ // discount
			
		}
		else if(promogift == 3){ // cashback
			if(cashback <= 0){
				$("#WarningContent").replaceWith("<div id='WarningContent'>Cashback Amount should not be less or equal to zero</div>");
				$('#WarningModal').modal('show');
				return false;
			}
		}
		else if(promogift == 4){ // product
			
		}
		
		if((promoobject == 1)&&(promogift == 3)){
			if(mintransamount < cashback){
				$("#WarningContent").replaceWith("<div id='WarningContent'>Min Trans Amount should not be less than Cashback Amount</div>");
				$('#WarningModal').modal('show');
				return false;
			}
		}

    });

</script>
<?php
$this->load->view('template/footer');
?>