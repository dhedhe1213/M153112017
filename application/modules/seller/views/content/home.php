
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-7">
    <h1>Welcome, <?php echo $profile['name']; ?></h1>
    <div class="content-page">
        <img src="<?php echo $profile['picture_url']; ?>" style="float: left;margin-right:40px;width: 150px;height:150px;">
        <h3>My Profile</h3>

        <b>ID </b>: <?php echo $profile['oauth_uid']; ?><br>
        <b>Nama </b>: <?php echo $profile['name']; ?> <br>
        <b>Tgl Lahir </b> : <?php echo $profile['birthday']; ?> <br>
        <b>Jenis Kelamin </b> : <?php echo $profile['gender']; ?> <br>
        <b>Email </b> : <?php echo $profile['email']; ?> <br>
        <b>No.Rekening </b> : <?php echo $profile['rek']; ?> a/n <?php echo $profile['an_rek']; ?>
        <br>
        <hr>
        <h3>MENU PROFILE</h3>
        <ul>
            <li><a href="<?php echo base_url('seller/edit_profile');?>">Ubah informasi akun</a></li>
            <li><a href="<?php echo base_url('seller/histTransfer');?>">Riwayat Transfer</a></li>
            <?php if($profile['oauth_provider'] == 'mitrareseller'){ ?>
            <li><a href="<?php echo base_url('seller/edit_password');?>">Ganti password</a></li>
            <?php } ?>
        </ul>
        <hr>


<!--        <h3>Data Transaksi</h3>-->
<!--        <ul>-->
<!--            <li>Total Penjualan</li>-->
<!--            <li>Total Keuntungan</li>-->
<!---->
<!--        </ul>-->

    </div>
</div>
<!-- END CONTENT -->