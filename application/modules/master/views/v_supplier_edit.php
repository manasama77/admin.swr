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
        Supplier
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Supplier</li>
    </ol>
</section>

<form class="form-horizontal" action="<?php echo site_url('master/Supplier/edit_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <input type="hidden" class="form-control" id="supplierid" name="supplierid" value="<?php echo $supplier->supplier_id; ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Supplier Code<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="suppliercode" name="suppliercode" value="<?php echo $supplier->supplier_code; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Supplier Name<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="suppliername" name="suppliername" value="<?php echo $supplier->supplier_name; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contact Name<font color="red">*</font></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="contactname" name="contactname" value="<?php echo $supplier->contact_name; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $supplier->phone; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Handphone</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="handphone" name="handphone" value="<?php echo $supplier->handphone; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $supplier->email; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">City</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="city" name="city" value="<?php echo $supplier->city; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-4">
                                <textarea class="form-control" rows="3" id="address" name="address"><?php echo $supplier->address; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-4">
                                <textarea class="form-control" rows="3" id="description" name="description"><?php echo $supplier->description; ?></textarea>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/supplier') ?>">Back to List</a>
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