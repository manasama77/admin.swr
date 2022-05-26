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
        Member
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Member</li>
    </ol>
</section>

<form class="form-horizontal" id="formpage" action="<?php echo site_url('master/member/create_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Member Code<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="membercode" name="membercode" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fullname<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="fullname" name="fullname" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-4">
                                <textarea class="form-control" rows="3" id="address" name="address"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Identity Type</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="identitytype" name="identitytype" style="width: 100%;">
                                    <option value='1'>KTP</option>
                                    <option value='2'>SIM</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Identity ID</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="identityid" name="identityid">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Limit Transaction<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="limittransaction" name="limittransaction" required>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/member') ?>">Back to List</a>
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
<script type="text/javascript">
    //Initialize Select2 Elements
    $(".select2").select2();

    $('#SaveButton').click(function (e) {
        var form = $('#formpage');
        var membercode = $('#membercode').val();
        var limittransaction = $('#limittransaction').val();

        if (limittransaction <= 0){
            $('#limittransaction').val("0");
			$("#WarningContent").replaceWith("<div id='WarningContent'>Limit Transaction cannot equal or less than 0</div>");
			$('#WarningModal').modal('show');
            return false;
        }

        var valid = true;
        $.ajax({
            type     : 'POST',
            dataType : 'JSON',
            url      : '<?php echo site_url() ?>master/member/membercode_isexist',
            data     :{
                membercode : membercode
            },
            success: function(data){
                if (data == "1"){
					$("#WarningContent").replaceWith("<div id='WarningContent'>Member Code is already exist, please input different Code</div>");
					$('#WarningModal').modal('show');
                    valid = false;
                }
                if (valid){
                    form.submit();
                } 
            }
        });
    });

</script>
<?php
$this->load->view('template/footer');
?>