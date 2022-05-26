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
    Stock In
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Inventory</a></li>
        <li class="active">Stock In</li>
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
                    <input type="hidden" class="form-control" id="stockinid" name="stockinid" value="<?php echo $stockinmaster->stock_in_id; ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Doc Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="docnumber" name="docnumber" value="<?php echo $stockinmaster->doc_number; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Stock In Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="datepicker" name="stockdate" value="<?php echo date('m/d/Y',strtotime($stockinmaster->stock_date)); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="status" name="status" value="<?php echo $stockinmaster->strstatus; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" id="description" name="description" disabled><?php echo $stockinmaster->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Buying Price</th>
                                    <th>Expired Date</th>
                                </tr>
                            </thead>
                            <tbody id="itemlist">
                                <?php foreach($stockindetail->result() as $row) :?>
                                    <tr>
                                        <td style="width:70%"><?php echo $row->barcode; ?> - <?php echo $row->item_code; ?> (<?php echo $row->item_name; ?>)</td>
                                        <td style="width:10%" align="center"><?php echo $row->qty; ?></td>
                                        <td style="width:10%" align="right"><?php echo number_format($row->buying_price,0,",","."); ?></td>
                                        <td style="width:10%" align="center"><?php echo date('d M Y',strtotime($row->expired_date)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('inventory/stock_in') ?>">Back to List</a>
                <?php if($stockinmaster->status == 1){ ?>
                <button class="btn btn-info pull-right" id="ExportButton">Export to Excel</button>
                <?php } ?>
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
        var stockinid = $('#stockinid').val();

        var win = window.open('<?php echo site_url() ?>inventory/stock_in/get_export_detail/'+stockinid, '_blank');
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