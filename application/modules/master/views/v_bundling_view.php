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
    Bundling
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Bundling</li>
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
					<div class="form-group">
						<label class="col-sm-2 control-label">Bundling Code</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="bundlingcode" name="bundlingcode" value="<?php echo $bundlingmaster->bundling_code; ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Bundling Name</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="bundlingname" name="bundlingname" value="<?php echo $bundlingmaster->bundling_name; ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Start Period</label>
						<div class="col-sm-4">
							<input type="text" class="form-control pull-right" id="datepicker" name="startperiod" value="<?php echo date('m/d/Y',strtotime($bundlingmaster->start_period)); ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">End Period</label>
						<div class="col-sm-4">
							<input type="text" class="form-control pull-righ" id="datepicker2" name="endperiod" value="<?php echo date('m/d/Y',strtotime($bundlingmaster->end_period)); ?>" readonly>
						</div>
					</div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Information</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" id="information" name="information" disabled><?php echo $bundlingmaster->information; ?></textarea>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="bundlingname" name="bundlingname" value="<?php echo $bundlingmaster->strstatus; ?>" readonly>
						</div>
					</div>
                </div>
				<hr>
				<h3>Bundled Product</h3>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Remark</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody id="tablepromo">
                                <?php foreach($bundlingpromo->result() as $row) :?>
									<tr>
                                        <td style="width:15%"><?php echo $row->remark; ?></td>
                                        <td style="width:70%"><?php echo $row->item_name; ?></td>
                                        <td style="width:15%"><?php echo $row->qty; ?></td>
									</tr>
								<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
				<hr>
				<h3>Promo</h3>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Remark</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Disc Percent</th>
                                    <th>Disc Amount</th>
                                    <th>Fix Price</th>
                                </tr>
                            </thead>
                            <tbody id="tableprize">
                                <?php foreach($bundlingprize->result() as $row) :?>
									<tr>
                                        <td style="width:10%"><?php echo $row->remark; ?></td>
                                        <td style="width:50%"><?php echo $row->item_name; ?></td>
                                        <td style="width:10%"><?php echo $row->qty; ?></td>
                                        <td style="width:10%"><?php echo $row->disc_percentage; ?></td>
                                        <td style="width:10%"><?php echo number_format($row->disc_amount,0,",","."); ?></td>
                                        <td style="width:10%"><?php echo number_format($row->fix_price,0,",","."); ?></td>
									</tr>
								<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('master/bundling') ?>">Back to List</a>
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