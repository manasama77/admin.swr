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

<form class="form-horizontal" id="formpage" action="<?php echo site_url('master/price/create_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Item<font color="red">*</font></label>
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
                            <label class="col-sm-2 control-label">Start Period<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-right" id="datepicker" name="startperiod" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">End Period<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control pull-righ" id="datepicker2" name="endperiod" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Public Price<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="publicprice" name="publicprice" value="0" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Member Price<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="memberprice" name="memberprice" value="0" required>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/price') ?>">Back to List</a>
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

    $('#SaveButton').click(function (e) {
        var form = $('#formpage');
        var itemid = $('#itemid').val();
        var publicprice = $('#publicprice').val();
        var memberprice = $('#memberprice').val();
        var startperiod = $('#datepicker').val();
        var endperiod = $('#datepicker2').val();

        if (publicprice <= 0){
            $('#publicprice').val("0");
			$("#WarningContent").replaceWith("<div id='WarningContent'>Public Price should not be less or equal to zero</div>");
			$('#WarningModal').modal('show');
            return false;
        }
        if (memberprice <= 0){
            $('#memberprice').val("0");
			$("#WarningContent").replaceWith("<div id='WarningContent'>Member Price should not be less or equal to zero</div>");
			$('#WarningModal').modal('show');
            return false;
        }

        $.ajax({
            type     : 'POST',
            dataType : 'JSON',
            url      : '<?php echo site_url() ?>master/price/price_period_isexist',
            data     :{
                itemid : itemid,
                startperiod : startperiod,
                endperiod : endperiod
            },
            success: function(data){
                if (data == "1"){
					$("#WarningContent").replaceWith("<div id='WarningContent'>Data is already exist, please input different period</div>");
					$('#WarningModal').modal('show');
                    valid = false;
                }
                else{
                    form.submit();
                } 
            }
        });
    });

</script>
<?php
$this->load->view('template/footer');
?>