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
    Price
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Price</li>
    </ol>
</section>
 
<form class="form-horizontal">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Item</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="stockitem" name="stockitem" value="<?php echo $price->item_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Start Period</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="datepicker" name="startperiod" value="<?php echo date('m/d/Y',strtotime($price->start_period)); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">End Period</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-righ" id="datepicker2" name="endperiod" value="<?php echo date('m/d/Y',strtotime($price->end_period)); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Public Price</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="publicprice" name="publicprice" value="<?php echo number_format($price->public_price,2,",","."); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Member Price</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="memberprice" name="memberprice" value="<?php echo number_format($price->member_price,2,",","."); ?>" readonly>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/price') ?>">Back to List</a>
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