
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-7">
    <h1>Welcome, <?php echo $profile['name']; ?></h1>
    <div class="content-page">
        <img src="<?php echo $profile['picture_url']; ?>" style="float: left;margin-right:40px;width: 150px;height:150px;">
        <h3>My Profile</h3>

        <b>ID </b>: <?php echo $profile['oauth_uid']; ?> <b>(<?php echo $cek_catalog['level']; ?>) </b><br>
        <b>Nama </b>: <?php echo $profile['name']; ?> <br>
        <b>Tgl Lahir </b> : <?php echo $profile['birthday']; ?> <br>
        <b>Jenis Kelamin </b> : <?php echo $profile['gender']; ?> <br>
        <b>Email </b> : <?php echo $profile['email']; ?> <br>
        <b>No.Rekening </b> : <?php echo $profile['rek']; ?> a/n <?php echo $profile['an_rek']; ?>
        <br>
        <hr>
        <h3>MENU PROFILE</h3>
        <ul>
            <li><a href="<?php echo base_url('mitra/edit_profile');?>">Ubah informasi akun</a></li>
            <?php if($profile['oauth_provider'] == 'mitrareseller'){ ?>
            <li><a href="<?php echo base_url('mitra/edit_password');?>">Ganti password</a></li>
            <?php } ?>
            <li><a href="<?php echo base_url('mitra/histTransfer');?>">Riwayat Transfer</a></li>
            <li><a href="<?php echo base_url('mitra/daftarTransaksiRefund');?>">Status Refund</a></li>

<!--            <li><a href="javascript:;">Masukan ID Teman</a></li>-->
            <?php if(!$cek_catalog){?>
            <li><a href="<?php echo base_url('mitra/add_catalog');?>">Buat Catalog</a></li>
            <?php } ?>
        </ul>
        <hr>


<!--        <h3>Data Transaksi</h3>-->
<!--        <ul>-->
<!--            <li>Total Penjualan</li>-->
<!--            <li>Total Keuntungan</li>-->
<!--            <li>Total ID Teman</li>-->
<!--            <li>Peringkat</li>-->
<!---->
<!--        </ul>-->

    </div>
</div>
<!-- END CONTENT -->