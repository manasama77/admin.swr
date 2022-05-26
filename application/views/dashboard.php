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
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Expired Product Warning</h3>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                    <tr>
                      <th>Product</th>
                      <th style="text-align:center;">Qty</th>
                      <th style="text-align:center;">Status</th>
                      <th style="text-align:center;">Expired Date</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php foreach($expproductwarn->result() as $row) :?>
              <tr>
                <td><?php echo $row->item_name; ?></td>
                <td style="text-align:center;"><?php echo $row->qty_now; ?></td>
                <?php if($row->diff <= 0){ ?>
                <td style="text-align:center;"><span class="label label-danger">Expired</span></td>
                <?php }else{ ?>
                <td style="text-align:center;"><span class="label label-warning">Warning</span></td>
                <?php } ?>
                <td style="text-align:center;"><?php echo date('d M Y',strtotime($row->expired_date)); ?></td>
              </tr>
            <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Stock Product Warning</h3>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                    <tr>
                      <th>Product</th>
                      <th style="text-align:center;">Qty</th>
                      <th style="text-align:center;">Status</th>
                    </tr>
                    </thead>
                    <tbody>
            <?php foreach($stockproductwarn->result() as $row) :?>
              <tr>
                <td><?php echo $row->item_name; ?></td>
                <td style="text-align:center;"><?php echo $row->total_qty; ?></td>
                <?php if($row->total_qty <= 0){ ?>
                <td style="text-align:center;"><span class="label label-danger">No Stock</span></td>
                <?php }else{ ?>
                <td style="text-align:center;"><span class="label label-warning">Warning</span></td>
                <?php } ?>
              </tr>
            <?php endforeach; ?>
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
<?php $this->load->view('template/footer'); ?>