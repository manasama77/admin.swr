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
        Stock Item
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master</a></li>
        <li class="active">Stock Item</li>
    </ol>
</section>

<form class="form-horizontal" id="formpage" action="<?php echo site_url('master/stock_item/import_post'); ?>" method="post">
<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Import From Excel</h3>
        </div>
        <div class="box-body">
			<input type="hidden" class="form-control" id="filename" name="filename" value="<?php echo $filename; ?>">
			<table id="example1" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Supplier Code</th>
						<th>Stock Category Code</th>
						<th>Stock Unit Code</th>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Barcode</th>
						<th>Minimum Qty</th>
						<th>Maximum Qty</th>
					</tr>
				</thead>
				<tbody>
					 <?php foreach($data_excell as $row=>$innerArray) :?>
						<tr>
							<td><?php echo $innerArray['suppliercode']; ?></td>
							<td><?php echo $innerArray['stockcategorycode']; ?></td>
							<td><?php echo $innerArray['unitcode']; ?></td>
							<td><?php echo $innerArray['itemcode']; ?></td>
							<td><?php echo $innerArray['itemname']; ?></td>
							<td><?php echo $innerArray['barcode']; ?></td>
							<td><?php echo $innerArray['minimumqty']; ?></td>
							<td><?php echo $innerArray['maximumqty']; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
        </div>
        <div class="box-footer">
            <a class="btn btn-default" href="<?php echo site_url('master/stock_item') ?>">Back to List</a>
			<button type="submit" id="SaveButton" class="btn btn-info pull-right">Save</button>
        </div>
    </div>
</section>
</form>

</div>

<?php 
$this->load->view('template/js');
?>
<script>
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
</script>
<?php
$this->load->view('template/footer');
?>
