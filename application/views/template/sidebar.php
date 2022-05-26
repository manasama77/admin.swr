<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url();?>assets/adminlte/dist/img/avatar3.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('fullname') ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <?php if($this->session->userdata('usergroupid') == 1){ ?>
        <?php echo $this->session->userdata('menu_admin') ?>
      <?php }else if($this->session->userdata('usergroupid') == 9){ ?>
        <?php echo $this->session->userdata('menu_supervisor') ?>
      <?php }else if($this->session->userdata('usergroupid') == 10){ ?>
        <?php echo $this->session->userdata('menu_kasir') ?>
      <?php }else if($this->session->userdata('usergroupid') == 11){ ?>
        <?php echo $this->session->userdata('menu_pramuniaga') ?>
      <?php } ?>

      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
