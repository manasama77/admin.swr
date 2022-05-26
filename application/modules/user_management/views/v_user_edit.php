<?php 
$this->load->view('template/head');
?>
<!--tambahkan custom css disini-->
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        User
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User Management</a></li>
        <li class="active">User</li>
    </ol>
</section>

<form class="form-horizontal" action="<?php echo site_url('user_management/user/create_post'); ?>" method="post">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                        <input type="hidden" class="form-control" id="userid" name="userid" value="<?php echo $user->user_id; ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">User Group</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="usergroup" value="<?php echo $user->usergrou; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fullname</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $user->fullname; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user->phone; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->email; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $user->address; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="username" value="<?php echo $user->username; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <?php if($user->status == 1): ?>
                                    <label>
                                        <input type="checkbox" class="flat-red" checked> Active
                                    </label>
                                    <?php else: ?>
                                    <label>
                                        <input type="checkbox" class="flat-red"> Active
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('user_management/user') ?>">Back to List</a>
                <input type="submit" class="btn btn-info pull-right" value="Save" />
            </div>
        </div>
    </section>
</form>

<?php 
$this->load->view('template/js');
?>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
  });
</script>
<?php
$this->load->view('template/foot');
?>