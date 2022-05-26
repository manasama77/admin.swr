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
        User Group
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User Management</a></li>
        <li class="active">User Group</li>
    </ol>
</section>

<form class="form-horizontal" action="<?php echo site_url('user_management/user_group/create_post'); ?>" method="post">
<section class="content">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Add Data</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">User Group Code</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="usergroupcode" name="usergroupcode">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">User Group Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="usergroupname" name="usergroupname">
          </div>
        </div>
      </div>
      <div class="box-footer">
        <a class="btn btn-default" href="<?php echo site_url('user_management/user_group') ?>">Back to List</a>
        <input type="submit" class="btn btn-info pull-right" value="Save" />
      </div>
    </div>
</section>
</form>

<?php 
$this->load->view('template/js');
?>
<!--tambahkan custom js disini-->
<?php
$this->load->view('template/foot');
?>