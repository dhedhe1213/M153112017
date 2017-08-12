 
<!-- Main Header -->
<header class="main-header">

        <!-- Logo -->
        <a href="<?php echo base_url() ; ?>dashboard" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>Dp</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Dpanel</b> LTE  3.0</span>
       
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">



              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?php echo base_url() ; ?>assets/admin/dist/img/avatar5.png" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $this->session->userdata('email'); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                 
                    <img src="<?php echo base_url() ; ?>assets/admin/dist/img/avatar5.png" class="img-circle" alt="User Image">
                    <p>
                      <?php echo substr($this->session->userdata('email'),0,15); ?>... - Web Admin
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="<?php echo base_url('dpanel/logout');?>" class="btn btn-default btn-flat fa fa-sign-out"> Sign out</a>
                    </div>
                    <div class="pull-left">
                      <a href="<?php echo base_url() ; ?>dashboard/user" class="btn btn-default btn-flat fa fa-gear"> Setting</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      