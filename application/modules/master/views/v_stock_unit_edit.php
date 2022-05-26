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
    Stock Unit
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Stock Unit</li>
    </ol>
</section>

<form class="form-horizontal" id="formpage" action="<?php echo site_url('master/stock_unit/edit_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <input type="hidden" class="form-control" id="stockunitid" name="stockunitid" value="<?php echo $stockunit->unit_id; ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Unit Code<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockunitcode" name="stockunitcode" value="<?php echo $stockunit->unit_code; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Unit Name<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockunitname" name="stockunitname" value="<?php echo $stockunit->unit_name; ?>" required>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/stock_unit') ?>">Back to List</a>
                <input type="button" class="btn btn-info pull-right" id="SaveButton" value="Save" />
            </div>
        </div>
    </section>
</form>

<div class="modal fade" id="WarningModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><strong>Warning</strong></h5>
			</div>
			<div class="modal-body">
				<div id="modalcontent"></div>
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
    $('#SaveButton').click(function (e) {
        var form = $('#formpage');
        var stockunitcode = $('#stockunitcode').val();
        var stockunitname = $('#stockunitname').val();

		if(stockunitcode == ""){
			$("#modalcontent").replaceWith("<div id='modalcontent'>Missing Stock Unit Code</div>");
			$('#WarningModal').modal('show');
			return false;
		}
		if(stockunitname == ""){
			$("#modalcontent").replaceWith("<div id='modalcontent'>Missing Stock Unit Name</div>");
			$('#WarningModal').modal('show');
			return false;
		}
		
        form.submit();
    });

</script>
<?php
$this->load->view('template/footer');
?>