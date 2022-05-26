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
    Stock Out
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Inventory</a></li>
        <li class="active">Stock Out</li>
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
                    <input type="hidden" class="form-control" id="stockoutid" name="stockoutid" value="<?php echo $stockoutmaster->stock_out_id; ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Doc Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="docnumber" name="docnumber" value="<?php echo $stockoutmaster->doc_number; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="datepicker" name="stockdate" value="<?php echo date('m/d/Y',strtotime($stockoutmaster->stock_date)); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control" id="datepicker" name="stockdate" value="<?php echo $stockoutmaster->strstatus; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" id="information" name="information" disabled><?php echo $stockoutmaster->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($stockoutdetail->result() as $row) :?>
                                    <tr>
                                        <td><?php echo $row->item_code; ?></td>
                                        <td><?php echo $row->item_name; ?></td>
                                        <td><?php echo $row->qty; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('inventory/stock_out') ?>">Back to List</a>
                <button class="btn btn-info pull-right" id="ExportButton">Export to Excel</button>
            </div>
        </div>
    </section>
</form>

</div>

<?php 
$this->load->view('template/js');
?>
<script>
    $(document).ready(function(){
        $('#ExportButton').click(function (e) {
            get_export();
        });
    });

    function get_export(){
        var stockoutid = $('#stockoutid').val();

        var win = window.open('<?php echo site_url() ?>inventory/stock_out/get_export/'+stockoutid, '_blank');
        if (win) {
            win.focus();
        } else {
            alert('Please allow popups for this website');
        }
    }
</script>
<?php
$this->load->view('template/footer');
?>