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

<form class="form-horizontal">
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <input type="hidden" class="form-control" id="memberid" name="memberid" value="<?php echo $member->member_id; ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Member Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="membercode" name="membercode" value="<?php echo $member->member_code; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Fullname</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $member->fullname; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $member->phone; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $member->email; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" id="address" name="address" disabled><?php echo $member->address; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Identity Type</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="identitytype" name="identitytype" value="<?php echo $member->stridentity_type; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Identity ID</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="identityid" name="identityid" value="<?php echo $member->identity_id; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Limit Transaction</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="limittransaction" name="limittransaction" value="<?php echo number_format($member->limit_transaction,0,",","."); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Current Limit</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="currentlimit" name="currentlimit" value="<?php echo number_format($member->current_limit,0,",","."); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="identityid" name="identityid" value="<?php echo $member->strstatus; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/member') ?>">Back to List</a>
                <button class="btn btn-info pull-right" id="ResetButton">Reset Limit</button>
            </div>
        </div>
    </section>
</form>

</div>

<?php 
$this->load->view('template/js');
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#ResetButton').click(function (e) {
            reset_limit();
        });
    });

    function reset_limit(){
        if(confirm('Are you sure reset current limit this member?')){
            var memberid = $('#memberid').val();
            $.ajax({
                type     : 'POST',
                dataType : 'JSON',
                url      : '<?php echo site_url() ?>master/member/reset_limit',
                data     :{
                    memberid : memberid
                },
                success: function(data){
                    alert(data);
                    $('#currentlimit').val($('#limittransaction').val());
                },
            });
        }
    }
</script>
<?php
$this->load->view('template/footer');
?>