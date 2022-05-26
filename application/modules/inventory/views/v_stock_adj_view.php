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

<form class="form-horizontal">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Adjustment Date</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="adjdate" name="adjdate" value="<?php echo $stockadj->adj_date; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Item</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="adjdate" name="adjdate" value="<?php echo $stockadj->item_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Adjustment Qty</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="adjqty" name="adjqty" value="<?php echo $stockadj->adj_number; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Adjustment Type</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="adjnumber" name="adjnumber" value="<?php echo $stockadj->stradj_type; ?>" readonly>
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Expired Date</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="datepicker" name="expireddate" value="<?php echo date('m/d/Y',strtotime($stockadj->expired_date)); ?>" readonly>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-4">
                                <textarea class="form-control" rows="3" id="description" name="description" disabled><?php echo $stockadj->description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">By User</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="userid" name="userid" value="<?php echo $stockadj->adj_user; ?>" readonly>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('inventory/stock_adj') ?>">Back to List</a>
            </div>
        </div>
    </section>
</form>

</div>

<?php 
$this->load->view('template/js');
?>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>
<?php
$this->load->view('template/footer');
?>