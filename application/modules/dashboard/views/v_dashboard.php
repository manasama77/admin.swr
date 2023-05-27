<?php $this->load->view('template/header'); ?>

<?php $this->load->view('template/topbar'); ?>

<?php $this->load->view('template/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Dashboard
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li>Dashboard</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-md-12">
				<div class="box box-solid">
					<div class="box-header with-border">
						<h4 class="box-title">Penjualan 30 Hari Terakhir</h4>
						<div class="box-tools pull-right">
							<h4><?php echo $header->startperiod; ?> - <?php echo $header->endperiod; ?></h4>
						</div>
						<input type="hidden" id="graphlabel" name="graphlabel" value="<?php echo $label; ?>">
						<input type="hidden" id="graphsales" name="graphsales" value="<?php echo $sales; ?>">
					</div>
					<div class="box-body">
						<div class="chart">
							<canvas id="salesGraph" style="height:300px"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
		    <div class="col-sm-12 col-md-4">
	            <div class="box box-solid">
        	        <div class="box-header with-border bg-success text-center">
        	            <h4 class="box-title"><strong>Top 15</strong></h4>
        	        </div>
        	        <div class="box-body">
        	            <div class="table-responsive">
                	        <table class="table table-bordered">
                	            <thead>
                	                <tr>
                	                    <th>Item</th>
                	                    <th>Qty</th>
                	                </tr>
                	            </thead>
                	            <tbody>
                	                <?php foreach($top15s->result() as $top15){ ?>
                	                <tr>
                	                    <td><?=$top15->item_name;?></td>
                	                    <td><?=$top15->qty;?></td>
                	                </tr>
                	                <?php } ?>
                	            </tbody>
                	        </table>
                	    </div>
        	        </div>
        	    </div>
	        </div>
			<div class="col-sm-12 col-md-4">
				<div class="box box-solid">
					<div class="box-header with-border bg-danger text-center">
						<h4 class="box-title"><strong>Stock Kosong</strong></h4>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped bg-danger">
								<thead>
									<tr>
										<th>Kategori Barang</th>
										<th>Nama Barang</th>
									</tr>
								</thead>
								<tbody>
									<?php if ($stock_kosong->num_rows() == 0) { ?>
										<tr>
											<td colspan="2" class="text-center">Tidak ada Data</td>
										</tr>
										<?php
									} else {
										foreach ($stock_kosong->result() as $key) {
										?>
											<tr>
												<td><?= $key->stock_category_name; ?></td>
												<td><?= $key->item_name; ?></td>
											</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-4">
				<div class="box box-solid">
					<div class="box-header with-border bg-warning text-center">
						<h4 class="box-title"><strong>Stock Minimum</strong></h4>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped bg-warning">
								<thead>
									<tr>
										<th>Kategori Barang</th>
										<th>Nama Barang</th>
										<th class="text-right">Qty</th>
									</tr>
								</thead>
								<tbody>
									<?php if ($stock_minimum->num_rows() == 0) { ?>
										<tr>
											<td colspan="2" class="text-center">Tidak ada Data</td>
										</tr>
										<?php
									} else {
										foreach ($stock_minimum->result() as $key) {
										?>
											<tr>
												<td><?= $key->stock_category_name; ?></td>
												<td><?= $key->item_name; ?></td>
												<td class="text-right"><?= $key->qty; ?></td>
											</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section><!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('template/js'); ?>
<script>
	$(function() {

		var graphlabel = $('#graphlabel').val();
		var arrgraphlabel = graphlabel.split(",");

		var graphsales = $('#graphsales').val();
		var arrgraphsales = graphsales.split(",");

		// Get context with jQuery - using jQuery's .get() method.
		var areaChartCanvas = $('#salesGraph').get(0).getContext('2d')
		// This will get the first returned node in the jQuery collection.
		var areaChart = new Chart(areaChartCanvas)

		var areaChartData = {
			labels: arrgraphlabel,
			datasets: [{
				label: 'Digital Goods',
				fillColor: 'rgba(60,141,188,0.9)',
				strokeColor: 'rgba(60,141,188,0.8)',
				pointColor: '#3b8bba',
				pointStrokeColor: 'rgba(60,141,188,1)',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(60,141,188,1)',
				data: arrgraphsales
			}]
		}

		var areaChartOptions = {
			//Boolean - If we should show the scale at all
			showScale: true,
			//Number - Tension of the bezier curve between points
			bezierCurveTension: 0,
			//Boolean - Whether to show a dot for each point
			pointDot: true,
			//Boolean - Whether to fill the dataset with a color
			datasetFill: true,
			//Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
			maintainAspectRatio: true,
			//Boolean - whether to make the chart responsive to window resizing
			responsive: true
		}

		//Create the line chart
		areaChart.Line(areaChartData, areaChartOptions)

	})
</script>
<?php $this->load->view('template/footer'); ?>