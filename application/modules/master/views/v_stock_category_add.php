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
    Stock Category
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Stock Category</li>
    </ol>
</section>

<form class="form-horizontal" action="<?php echo site_url('master/stock_category/create_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Category Code<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockcategorycode" name="stockcategorycode" value="<?php echo $stockcategorycode; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Stock Category Name<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="stockcategoryname" name="stockcategoryname">
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/stock_category') ?>">Back to List</a>
                <input type="submit" class="btn btn-info pull-right" value="Save" />
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