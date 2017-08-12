<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>
<script src="<?php echo base_url(); ?>assets/js_ajax/mitra_catalog.js" type="text/javascript"></script>
<!-- End AJAX JS -->
<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-9">
<!--    <h1>Pemesanan Behasil</h1>-->
    <div class="content-form-page">
        <div class="row">
            </br>
        <div style="text-align:center;">
            <h2>Pemesanan Berhasil</h2>
            <p>Transfer dana anda sebelum Tanggal dan Jam <b><h4><?php echo $batas_waktu;?></h4></b></p>
            <hr/>
            <p>Jumlah yang harus di bayar:</p>
            <div style="font-size: 35px;background-color: #FDD7D4;">Rp <?php echo number_format($total_pembayaran,0);?></div>
            <p>Mohon transfer sesuai dengan jumlah yang tertera</p>
            <p>(termasuk 3 digit Terakhir)</p>
            <hr/>
            <p>Silahkan Transfer ke salah satu rekening kami :</p>

            <div class="col-md-3 col-sm-3">
                <img src="<?php echo base_url('assets/images/img/mandiri.jpg');?>" width="140">
                <h4>1640002106054</br>
                    a/n </br> Sendy Prasetyo</h4>
            </div>

            <div class="col-md-3 col-sm-3">
                <img src="<?php echo base_url('assets/images/img/bni.jpg');?>" width="120px">
                <div style="margin-top: 5%;"><h4>0573489917 </br> a/n </br> Sendy Prasetyo</h4></div>
            </div>

            <div class="col-md-3 col-sm-3">
                <img src="<?php echo base_url('assets/images/img/bri.jpg');?>" width="140px">
                <h4>762001003079536 </br> a/n </br> Dede Irawan</h4>
            </div>

            <div class="col-md-3 col-sm-3">
                <img src="<?php echo base_url('assets/images/img/bca.jpg');?>" width="120px">
                <div style="margin-top: 5%;"> <h4>0710084513 </br> a/n </br> Dede Irawan</h4></div>
            </div>



        </div>

        </div>
    </div>

</div>