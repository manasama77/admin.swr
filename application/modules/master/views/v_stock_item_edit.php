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
    Stock Item
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Stock Item</li>
    </ol>
</section>

<form class="form-horizontal" id="formpage" action="<?php echo site_url('master/stock_item/edit_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <input type="hidden" class="form-control" id="itemid" name="itemid" value="<?php echo $stockitem->item_id; ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Category<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockcategory" name="stockcategory" value="<?php echo $stockitem->stock_category_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Unit<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockunit" name="stockunit" value="<?php echo $stockitem->unit_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Item Code<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="itemcode" name="itemcode" value="<?php echo $stockitem->item_code; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Item Name<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="itemname" name="itemname" value="<?php echo $stockitem->item_name; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Barcode<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="barcode" name="barcode" value="<?php echo $stockitem->barcode; ?>"  readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Minimum Stock<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $stockitem->minimum_stock; ?>" id="minimumstock" name="minimumstock" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Maximum Stock<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $stockitem->maximum_stock; ?>" id="maximumstock" name="maximumstock" required>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/stock_item') ?>">Back to List</a>
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

    $('#SaveButton').click(function (e) {
        var form = $('#formpage');
        var itemcode = $('#itemcode').val();
        var barcode = $('#barcode').val();
        var minimumstock = $('#minimumstock').val();
        var maximumstock = $('#maximumstock').val();

        if (parseInt(maximumstock) <= parseInt(minimumstock)){
            $('#minimumstock').val("0");
            $('#maximumstock').val("0");
			$("#WarningContent").replaceWith("<div id='WarningContent'>Maximum Stock cannot equal or less than Minimum Stock</div>");
			$('#WarningModal').modal('show');
            return false;
        }

		form.submit();
    });

</script>
<?php
$this->load->view('template/footer');
?>