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

<form class="form-horizontal" id="formpage" action="<?php echo site_url('master/stock_unit/create_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Unit Code<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockunitcode" name="stockunitcode" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Unit Name<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockunitname" name="stockunitname" required>
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
			alert("Missing Stock Unit Code");
			return false;
		}
		if(stockunitname == ""){
			alert("Missing Stock Unit Name");
			return false;
		}
		
        var valid = true;
        $.ajax({
            type     : 'POST',
            dataType : 'JSON',
            url      : '<?php echo site_url() ?>master/stock_unit/stockunitcode_isexist',
            data     :{
                stockunitcode : stockunitcode
            },
            success: function(data){
                if (data == "1"){
                    alert("Stock Unit Code is already exist, please input different Code");
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