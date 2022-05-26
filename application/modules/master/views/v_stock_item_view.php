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

<form class="form-horizontal">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Category</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockcategory" name="stockcategory" value="<?php echo $stockitem->stock_category_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Unit</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockunit" name="stockunit" value="<?php echo $stockitem->unit_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Item Code</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="itemcode" name="itemcode" value="<?php echo $stockitem->item_code; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Item Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="itemname" name="itemname" value="<?php echo $stockitem->item_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Barcode</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="barcode" name="barcode" value="<?php echo $stockitem->barcode; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Total Stock</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $stockitem->total_qty; ?>" id="initialstock" name="initialstock" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Minimum Stock</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $stockitem->minimum_stock; ?>" id="minimumstock" name="minimumstock" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Maximum Stock</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $stockitem->maximum_stock; ?>" id="maximumstock" name="maximumstock" readonly>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/stock_item') ?>">Back to List</a>
            </div>
        </div>
    </section>
</form>

</div>

<?php 
$this->load->view('template/js');
?>
<?php
$this->load->view('template/footer');
?>