<?php $this->load->view('template/header'); ?>

<?php $this->load->view('template/topbar'); ?>

<?php $this->load->view('template/sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <form action="#" id="form" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">User Profile</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Role</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php echo $profile->UserGroupName ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Fullname</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $profile->Fullname ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $profile->Email ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $profile->Phone ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php echo $profile->Username ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" value="<?php echo $profile->strStatus ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" id="btnSave" onclick="save_data()" class="btn btn-danger pull-right">Update</button>
                </div>
            </div>
        </div>
      </div>
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

    </section>
  </div>

<?php $this->load->view('template/js'); ?>

<script>
    $(".select2").select2();

    $('#btnClose').click(function (e) {
        $('#WarningModal').modal('hide');
    });

    function save_data()
    {
        var frm = $('#form');
        $.ajax({
            url : "<?php echo site_url() ?>home/update_profile",
            type: "POST",
            data: frm.serialize(),
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) //if success close modal and reload ajax table
                {
                  $("#WarningContent").replaceWith("<div id='WarningContent'>Success Add / Edit data</div>");
                  $('#WarningModal').modal('show');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $("#WarningContent").replaceWith("<div id='WarningContent'>Error Add / Edit data</div>");
                $('#WarningModal').modal('show');
            }
        });
    }

</script>

<?php $this->load->view('template/footer'); ?>
