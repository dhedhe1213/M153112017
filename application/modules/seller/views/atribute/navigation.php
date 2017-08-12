
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <!-- BEGIN SIDEBAR -->
    <div class="sidebar col-md-3 col-sm-3">
        <ul class="list-group margin-bottom-25 sidebar-menu">
            <?php
            $id = $this->session->userdata('id');
            $cekAlamat = $this->db->get_where('r_seller_alamat',array('id_user'=>$id))->num_rows();
            if($cekAlamat > 0){
                ?>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('seller');?>"><i class="fa fa-home"></i> Home</a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('seller/barangKu/');?>"><i class="fa fa-building-o"></i> Barang Ku</a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('seller/pesananBarang');?>"><i class="fa fa-shopping-cart"></i> Pesanan Barang</a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('seller/barangDikirim');?>"><i class="fa fa-truck"></i> Status Barang Dikirim</a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('seller/daftarTransaksi');?>"><i class="fa fa-check-circle-o"></i> Daftar Transaksi </a></li>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('seller/daftarKurir');?>"><i class="fa fa-gear"></i> Pengaturan Kurir </a></li>

            <?php
            }else{
                ?>
                <li class="list-group-item clearfix"><a href="<?php echo base_url('seller');?>"><i class="fa fa-home"></i> Home</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Melengkapi Alamat :(', 'Silahkan Lengkapi Alamat Anda Pada Menu Profile!', 'error');"><i class="fa fa-building-o"></i> Barang Ku</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Melengkapi Alamat :(', 'Silahkan Lengkapi Alamat Anda Pada Menu Profile!', 'error');"><i class="fa fa-shopping-cart"></i> Pesanan Barang</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Melengkapi Alamat :(', 'Silahkan Lengkapi Alamat Anda Pada Menu Profile!', 'error');"><i class="fa fa-truck"></i> Status Barang Dikirim</a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Melengkapi Alamat :(', 'Silahkan Lengkapi Alamat Anda Pada Menu Profile!', 'error');"><i class="fa fa-check-circle-o"></i> Daftar Transaksi </a></li>
                <li class="list-group-item clearfix"><a href="#" onclick="sweetAlert('Maaf Anda Belum Melengkapi Alamat :(', 'Silahkan Lengkapi Alamat Anda Pada Menu Profile!', 'error');"><i class="fa fa-gear"></i> Pengaturan Kurir </a></li>
            <?php
            }
            ?>




            <li class="list-group-item clearfix"><a href="<?php echo base_url('dpanel/logout');?>"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </div>
    <!-- END SIDEBAR -->