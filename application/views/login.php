<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS Apps</title>
  <link rel="icon" href="<?php echo base_url(); ?>assets/img/toko_trijaya.jpg" type="image/png">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/iCheck/square/blue.css">
  <link href="<?= base_url('assets/css/unsplash.css'); ?>" rel="stylesheet" type="text/css" id="app-stylesheet" />

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page unsplash-bg-random">
  <div class="login-box">

    <div class="login-box-body">
      <div class="login-logo">
        <img src="<?php echo base_url(); ?>assets/img/toko_trijaya.jpg" height="200" width="250">
        <br>
        <span style="color:#000;"><strong>Login Aplikasi</strong></span>
      </div>

      <?php if ($this->session->flashdata('flash_login') != '') { ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Alert!</h4>
          <?php echo $this->session->flashdata('flash_login') ?>
        </div>
      <?php } ?>

      <form action="<?php echo site_url('home/login'); ?>" method="post">

        <div class="form-group has-feedback">
          <input id="username" name="username" type="text" class="form-control" placeholder="Username" autocomplete="off" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input id="password" name="password" type="password" class="form-control" placeholder="Password" autocomplete="off" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-info btn-block btn-flat">Login</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  <!-- jQuery 3 -->
  <script src="<?php echo base_url(); ?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url(); ?>assets/adminlte/plugins/iCheck/icheck.min.js"></script>
</body>

</html>