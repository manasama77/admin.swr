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
    Promo
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Promo</li>
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
                                <input type="text" class="form-control pull-right" id="datepicker" name="startperiod" value="<?php echo $promo->item_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Start Period</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="startperiod" name="startperiod" value="<?php echo $promo->start_period; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">End Period</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-righ" id="datepicker2" name="endperiod" value="<?php echo $promo->end_period; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Promo Type</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="promotype" name="promotype" value="<?php echo $promo->strpromo_type; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Disc. Percentage</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="discpercentage" name="discpercentage" value="<?php echo $promo->disc_percentage; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Disc. Amount</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="discamount" name="discamount" value="<?php echo $promo->disc_amount; ?>" readonly>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/promo') ?>">Back to List</a>
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

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    });

  });
</script>
<?php
$this->load->view('template/footer');
?>