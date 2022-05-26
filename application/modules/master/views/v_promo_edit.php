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

<form class="form-horizontal" action="<?php echo site_url('master/promo/edit_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                <input type="hidden" class="form-control" id="itempromoid" name="itempromoid" value="<?php echo $promo->item_promo_id; ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Item</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="datepicker" name="startperiod" value="<?php echo $promo->item_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Start Period</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="startperiod" name="startperiod" value="<?php echo date('m/d/Y',strtotime($promo->start_period)); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">End Period</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-righ" id="datepicker2" name="endperiod" value="<?php echo date('m/d/Y',strtotime($promo->end_period)); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Promo Type</label>
                            <div class="col-sm-4">
                                <?php if($promo->promo_type == 1): ?>
                                <select class="form-control select2" id="promotype" name="promotype" style="width: 100%;">
                                    <option value='1' selected>Member</option>
                                    <option value='2'>Public</option>
                                </select>
                                <?php elseif($promo->promo_type == 2): ?>
                                <select class="form-control select2" id="promotype" name="promotype" style="width: 100%;">
                                    <option value='1'>Member</option>
                                    <option value='2' selected>Public</option>
                                </select>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Disc. Percentage</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="discpercentage" name="discpercentage" value="<?php echo $promo->disc_percentage; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Disc. Amount</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="discamount" name="discamount" value="<?php echo $promo->disc_amount; ?>">
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/promo') ?>">Back to List</a>
                <input type="submit" class="btn btn-info pull-right" value="Save" />
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