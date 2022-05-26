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

<form class="form-horizontal" action="<?php echo site_url('user_management/user_group/edit_post'); ?>" method="post">
<section class="content">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Data</h3>
      </div>
      <div class="box-body">
      <input type="hidden" class="form-control" id="usergroupid" name="usergroupid" value="<?php echo $usergroup->user_group_id; ?>">
        <div class="form-group">
          <label class="col-sm-2 control-label">User Group Code</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="usergroupcode" name="usergroupcode" value="<?php echo $usergroup->user_group_code; ?>" readonly>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">User Group Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="usergroupname" name="usergroupname" value="<?php echo $usergroup->user_group_name; ?>">
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-default">Back to List</button>
        <button type="submit" class="btn btn-info pull-right">Save</button>
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