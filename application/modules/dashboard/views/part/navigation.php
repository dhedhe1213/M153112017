 <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url() ; ?>assets/admin/dist/img/avatar5.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo substr($this->session->userdata('email'),0,15);?>...</p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

         

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">Navigation</li>
            <!-- Optionally, you can add icons to the links -->

            <li class="treeview">
              <a href="#"><i class="fa fa-building-o"></i> <span>About Us</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('dashboard/about/1'); ?>"><i class="fa fa-briefcase"></i> <span>Tentang Kami</span></a></li>
                <li><a href="<?php echo base_url('dashboard/about/2'); ?>"><i class="fa fa-briefcase"></i> <span>Membership</span></a></li>
                <li><a href="<?php echo base_url('dashboard/about/3'); ?>"><i class="fa fa-briefcase"></i> <span>Syarat & Ketentuan</span></a></li>
                <li><a href="<?php echo base_url('dashboard/about/4'); ?>"><i class="fa fa-briefcase"></i> <span>Kebijakan Privasi</span></a></li>
              </ul>
            </li>
              <li class="treeview">
                  <a href="#"><i class="fa fa-rss"></i> <span>Blog</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                      <li><a href="<?php echo base_url('dashboard/blog/mitra'); ?>"><i class="fa fa-file"></i> <span>Mitra</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/blog/umum'); ?>"><i class="fa fa-file"></i> <span>Umum</span></a></li>
                   </ul>
              </li>
              <li class="treeview">
                  <a href="#"><i class="fa fa-barcode"></i> <span>Product</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                      <li><a href="<?php echo base_url('dashboard/cat_item/0'); ?>"><i class="fa fa-bars"></i> <span>Category Item</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/komentarItem'); ?>"><i class="fa fa-comment"></i> <span>Komentar Item</span></a></li>
                  </ul>
              </li>
              <li class="treeview">
                  <a href="#"><i class="fa fa-shopping-cart"></i> <span>Transaction</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                      <li><a href="<?php echo base_url('dashboard/confPembayaran'); ?>"><i class="fa fa-money"></i> <span>Konfirmasi Pembayaran</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/sellerPending'); ?>"><i class="fa fa-clock-o"></i> <span>Seller Pending</span></a></li>
                  </ul>
              </li>
              <li class="treeview">
                  <a href="#"><i class="fa fa-dollar"></i> <span>Payment</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                      <li><a href="<?php echo base_url('dashboard/paymentReseller'); ?>"><i class="fa fa-money"></i> <span>Payment Reseller</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/paymentSeller'); ?>"><i class="fa fa-money"></i> <span>Payment Seller</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/paymentRefund'); ?>"><i class="fa fa-money"></i> <span>Payment Refund</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/histPaymentReseller'); ?>"><i class="fa fa-money"></i> <span>History Payment Reseller</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/histPaymentSeller'); ?>"><i class="fa fa-money"></i> <span>History Payment Seller</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/histPaymentRefund'); ?>"><i class="fa fa-money"></i> <span>History Payment Refund</span></a></li>
                  </ul>
              </li>
              <li class="treeview">
                  <a href="#"><i class="fa fa-gear"></i> <span>Management</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                      <li><a href="<?php echo base_url('dashboard/memberMitrareseller'); ?>"><i class="fa fa-user"></i> <span>Member Mitrareseller</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/catalogMember'); ?>"><i class="fa fa-list"></i> <span>Catalog Member</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/komentarCatalog'); ?>"><i class="fa fa-comment"></i> <span>Review Catalog</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/paymentPlatform'); ?>"><i class="fa fa-money"></i> <span>Payment Platform</span></a></li>
                      <li><a href="<?php echo base_url('dashboard/backupDatabase'); ?>"><i class="fa fa-copy"></i> <span>Backup Database</span></a></li>
                  </ul>
              </li>
              <li class="treeview">
                  <a href="#"><i class="fa fa-play"></i> <span>Media</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                      <li><a href="<?php echo base_url('dashboard/media'); ?>"><i class="fa fa-picture-o"></i> <span>Images</span></a></li>
                  </ul>
              </li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>