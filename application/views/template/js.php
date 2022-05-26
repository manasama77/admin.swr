<!-- Main Footer -->
<footer class="main-footer">
  <!-- To the right -->
  <div class="pull-right hidden-xs">
    <strong><?php echo $this->session->userdata('branchname') ?></strong>
  </div>
  <!-- Default to the left -->
  <strong>Copyright &copy; 2019.</strong> All rights reserved.
</footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<!-- <script src="<?php echo base_url(); ?>assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/datatables.net-bs/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/datatables.net-bs/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/datatables.net-bs/js/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/datatables.net-bs/js/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/datatables.net-bs/js/vfs_fonts.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/sc-2.0.5/datatables.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Sweetalert 2-->
<!-- <script src="<?php echo base_url(); ?>assets/adminlte/bower_components/sweetalert/sweetalert.min.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Chart.js -->
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/chart.js/Chart.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/adminlte/dist/js/adminlte.min.js"></script>
<!-- CK Editor -->
<script src="<?php echo base_url(); ?>assets/adminlte/bower_components/ckeditor/ckeditor.js"></script>

<script>
  $(document).ready(function() {
    $("input[type='text']").attr("autocomplete", "off");
    $("input[type='password']").attr("autocomplete", "off");
  });
</script>