
<body class="hold-transition skin-black sidebar-collapse sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>POS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>POS</b>apps</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="<?php echo base_url();?>assets/adminlte/dist/img/avatar3.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $this->session->userdata('fullname') ?></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo site_url('dashboard/profile'); ?>">Profil</a></li>
                <li><a href="<?php echo site_url('dashboard/change_pass'); ?>">Ganti Password</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo site_url('home/logout'); ?>">Sign Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  