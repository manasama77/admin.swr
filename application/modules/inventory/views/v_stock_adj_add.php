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
    Stock Adjustment
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Inventory</a></li>
        <li class="active">Stock Adjustment</li>
    </ol>
</section>

<form class="form-horizontal" id="formpage" action="<?php echo site_url('inventory/stock_adj/create_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Item</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="itemid" name="itemid" style="width: 100%;">
                                    <option value=''>Please Choose...</option>
                                    <?php foreach($stockitem->result() as $row) :?>
                                        <?php echo "<option value='". $row->item_id . "'>" . $row->barcode . " (" . $row->item_name . ")</option>"; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Adjustment Qty</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="adjqty" name="adjqty" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Adjustment Type</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="adjtype" name="adjtype" style="width: 100%;">
                                    <option value='1'>Plus</option>
                                    <option value='2'>Minus</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="price" name="price" value="0">
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Expired Date</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="datepicker" name="expireddate">
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-4">
                                <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('inventory/stock_adj') ?>">Back to List</a>
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
      autoclose: true
    });

    $('#SaveButton').click(function (e) {
        var form = $('#formpage');
        var itemid = $('#itemid option:selected').val();
        var adjqty = $('#adjqty').val();
        var expdate = $('#datepicker').val();

        if (itemid == ''){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Please choose product first</div>");
			$('#WarningModal').modal('show');
            return false;
        }
		else if (adjqty <= 0){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Adjustment Qty cannot less or equal 0</div>");
			$('#WarningModal').modal('show');
            return false;
        }
		else if (expdate <= ''){
			$("#WarningContent").replaceWith("<div id='WarningContent'>Expired Date is not set</div>");
			$('#WarningModal').modal('show');
            return false;
        }

        form.submit();
    });

</script>
<?php
$this->load->view('template/footer');
?>