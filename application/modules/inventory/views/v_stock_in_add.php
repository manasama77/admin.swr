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
    Stock In
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Inventory</a></li>
        <li class="active">Stock In</li>
    </ol>
</section>

<form class="form-horizontal" id="formpage" action="<?php echo site_url('inventory/stock_in/create_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
					<input type="hidden" class="form-control" id="totalitem" name="totalitem" value="0">
					<div class="form-group">
						<label class="col-sm-2 control-label">Doc Number</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="docnumber" name="docnumber">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Stock In Date</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="datepicker" name="stockdate">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select class="form-control select2" id="status" name="status" style="width: 100%;">
								<option value='0'>Draft</option>
								<option value='1'>Publish</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-4">
							<textarea class="form-control" rows="3" id="description" name="description"></textarea>
						</div>
					</div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Buying Price</th>
                                    <th>Expired Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemlist">
                                <tr>
                                    <td style="width:65%">
                                        <select class="form-control select2" id="item" name="item" style="width: 100%;">
                                            <option value='0'>Please Choose...</option>
                                            <?php foreach($stockitem->result() as $row) :?>
                                                <?php echo "<option value='". $row->item_id . "'>" . $row->item_code . " (" . $row->item_name . ")</option>"; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" class="form-control" id="itemid" name="itemid" value="0">
                                        <input type="hidden" class="form-control" id="itemname" name="itemname" value="">
                                    </td>
                                    <td style="width:10%">
                                        <input type="text" class="form-control" id="qty" name="qty" value="0">
                                    </td>
                                    <td style="width:10%">
                                        <input type="text" class="form-control" id="buyingprice" name="buyingprice" value="0">
                                    </td>
                                    <td style="width:10%">
										<input type="text" class="form-control" id="datepicker2" name="expireddate">
                                    </td>
                                    <td style="width:5%">
                                        <button type="button" class="btn btn-block btn-info" id="AddButton">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('inventory/stock_in') ?>">Back to List</a>
                <input type="button" class="btn btn-info pull-right" id="SaveButton" value="Save" />
            </div>
        </div>
    </section>
</form>

<div class="modal fade" id="WarningModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" style="text-align:center;"><strong>Warning</strong></h3>
			</div>
			<div class="modal-body">
				<div id="WarningContent"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success pull-right" data-dismiss="modal">Close</button>
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

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      startDate: new Date()
    });

	$('#datepicker2').datepicker({
      autoclose: true,
      startDate: new Date()
    });

    $("tbody#itemlist").on("click", "#hapus", function () {
		var totalitem = $("#totalitem").val();
		$("#totalitem").val(totalitem-1);
		$(this).parent().parent().remove();
	});

    $(document).ready(function(){
        $("#item").change(function () {
            if ($(this).val != "0"){
                $("#itemid").val($(this).find('option:selected').val());
                $("#itemname").val($(this).find('option:selected').text());
            }
        });

        $('#AddButton').click(function (e) {
            e.preventDefault();
			var totalitem = $("#totalitem").val();
			var itemid = $("#itemid").val();
			var itemname = $("#itemname").val();
			var qty = $("#qty").val();
			var buyingprice = $("#buyingprice").val();
			var expireddate = $("#datepicker2").val();
			
            if (itemid == 0){
                alert("Please Choose Product first");
            }
			else if (qty <= 0){
                alert("Qty cannot less or equal 0");
            }
			else if (expireddate == ""){
                alert("Please input Expired Date");
            }
			else{                
                var items = "";
                items += "<tr>";
                items += "<td style='width:65%'><input type='hidden' name='item[itemid][]' value='" + itemid + "'>" + itemname + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='item[qty][]' value='" + qty + "'>" + qty + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='item[buyingprice][]' value='" + buyingprice + "'>" + buyingprice + "</td>";
                items += "<td style='width:10%'><input type='hidden' name='item[expireddate][]' value='" + expireddate + "'>" + expireddate + "</td>";
                items += "<td style='width:5%'><a href='javascript:void(0);' id='hapus'>Remove</a></td>";
                items += "</tr>";
                
                $("#itemlist").append(items);
				
				$("#totalitem").val(totalitem+1);
                $("#item").val("");
                $("#itemid").val("0");
                $("#itemname").val("");
				$("#qty").val("0");
				$("#buyingprice").val("0");
				$("#datepicker2").val("");
            }
        });
    });

    $('#SaveButton').click(function (e) {
        var form = $('#formpage');
        var docnumber = $('#docnumber').val();
        var datepicker = $('#datepicker').val();
		var totalitem = $("#totalitem").val();
		var docnumber_exist = 0;
		
		$.ajax({
			type     : 'POST',
			dataType : 'JSON',
			url      : '<?php echo site_url() ?>inventory/stock_in/docnumber_isexist',
			data     :{
                docnumber : docnumber
            },
            success: function(data){
                docnumber_exist = data;
            }
		});

        if (docnumber == ''){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Please input Doc Number first</div>");
			$('#WarningModal').modal('show');
            return false;
        }
		else if(docnumber_exist != 0){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Doc Number already exist</div>");
			$('#WarningModal').modal('show');
            return false;
		}
		else if (datepicker == ''){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Please input Stock In Date first</div>");
			$('#WarningModal').modal('show');
            return false;
        }
		else if (totalitem == 0){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Please input Product first</div>");
			$('#WarningModal').modal('show');
            return false;
        }

        form.submit();
    });

</script>
<?php
$this->load->view('template/footer');
?>