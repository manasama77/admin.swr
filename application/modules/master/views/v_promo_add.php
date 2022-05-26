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

<form class="form-horizontal" action="<?php echo site_url('master/promo/create_post'); ?>" method="post" onsubmit="return val_form(this);">
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
                                <?php foreach($stockitem->result() as $row) :?>
                                    <?php echo "<option value='". $row->item_id . "'>" . $row->item_name . "</option>"; ?>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Start Period</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="datepicker" name="startperiod">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">End Period</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-righ" id="datepicker2" name="endperiod">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Promo Type</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="promotype" name="promotype" style="width: 100%;">
                                    <option value='1'>Member</option>
                                    <option value='2'>Public</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Disc. Percentage</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="discpercentage" name="discpercentage" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Disc. Amount</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="discamount" name="discamount" value="0">
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
    //Initialize Select2 Elements
    $(".select2").select2();

    $('#datepicker').datepicker({
      autoclose: true,
      startDate: new Date()
    }).on('changeDate', function(){
        $('#datepicker2').datepicker('setStartDate', new Date($(this).val()));
    });

    $('#datepicker2').datepicker({
      autoclose: true,
      startDate: new Date()
    }).on('changeDate', function(){
        $('#datepicker').datepicker('setEndDate', new Date($(this).val()));
    });

    function val_form(){
        var itemid = $('#itemid').val();
        var startperiod = $('#datepicker').val();
        var endperiod = $('#datepicker2').val();
        var promotype = $('#promotype').val();
        var discpercentage = parseFloat($('#discpercentage').val());
        var discamount = parseFloat($('#discamount').val());

        if((discpercentage != 0) && (discamount != 0)){
            alert("Disc Percentage and Amount cannot 0");
            return false;
        }
        if((discpercentage != 0) && (discamount != 0)){
            alert("Disc Percentage and Amount cannot be set together");
            return false;
        }
        if((discpercentage < 0) && (discpercentage > 0)){
            alert("Disc Percentage out of range");
            return false;
        }
        if(discamount < 0){
            alert("Disc Amount cannot less than 0");
            return false;
        }
    }
</script>
<?php
$this->load->view('template/footer');
?>