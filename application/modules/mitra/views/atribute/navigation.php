
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <!-- BEGIN SIDEBAR -->
    <div class="sidebar col-md-3 col-sm-3">
        <ul class="list-group margin-bottom-25 sidebar-menu">
            <?php
            $id = $this->session->userdata('id');
            $cek_catalog = $this->db->get_where('t_catalog',array('id_user'=>$id))->num_rows();
            $catalog = $this->db->get_where('t_catalog',array('id_user'=>$id))->row_array();
            if($cek_catalog > 0){
            ?>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('mitra');?>"><i class="fa fa-home"></i> Home</a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('mitra/catalog/'.$catalog['nm_catalog']);?>"><i class="fa fa-list-alt"></i> Catalog</a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('mitra/catalog_cart');?>"><i class="fa fa-shopping-cart"></i> Keranjang Belanja</a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('mitra/catalog_konfirmasi');?>"><i class="fa fa-money"></i> Konfirmasi Pembayaran</a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('mitra/catalog_pengiriman');?>"><i class="fa fa-truck"></i> Status Pengiriman</a></li>
<!--                <li class="list-group-item clearfix"><a href="#"><i class="fa fa-check-circle-o"></i> Konfirmasi Penerimaan</a></li>-->
                <li class="list-group-item clearfix"><a href="<?php echo base_url('mitra/daftar_transaksi');?>"><i class="fa fa-check-circle-o"></i> Daftar Transaksi </a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('katalog/'.$catalog['nm_catalog']);?>" target="_blank"><i class="fa fa-link"></i> Link Catalog</a></li>
            <?php
            }else{
            ?>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('mitra');?>"><i class="fa fa-home"></i> Home</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Membuat Catalog :(', 'Silahkan Buat Catalog Anda Pada Menu Profile!', 'error');"><i class="fa fa-list-alt"></i> Catalog</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Membuat Catalog :(', 'Silahkan Buat Catalog Anda Pada Menu Profile!', 'error');"><i class="fa fa-shopping-cart"></i> Keranjang Belanja</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Membuat Catalog :(', 'Silahkan Buat Catalog Anda Pada Menu Profile!', 'error');"><i class="fa fa-money"></i> Konfirmasi Pembayaran</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Membuat Catalog :(', 'Silahkan Buat Catalog Anda Pada Menu Profile!', 'error');"><i class="fa fa-truck"></i> Status Pengiriman</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Membuat Catalog :(', 'Silahkan Buat Catalog Anda Pada Menu Profile!', 'error');"><i class="fa fa-check-circle-o"></i> Konfirmasi Penerimaan</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Membuat Catalog :(', 'Silahkan Buat Catalog Anda Pada Menu Profile!', 'error');"><i class="fa fa-link"></i> Link Catalog</a></li>
            <?php
            }
            ?>

            <li class="list-group-item clearfix"><a href="<?php echo base_url('dpanel/logout');?>"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </div>
    <!-- END SIDEBAR -->