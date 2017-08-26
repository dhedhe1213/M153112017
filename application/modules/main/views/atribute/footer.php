<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- BEGIN PRE-FOOTER -->
<div class="pre-footer">
    <div class="container">
        <div class="row">
            <!-- BEGIN BOTTOM ABOUT BLOCK -->
            <div class="col-md-4 col-sm-6 pre-footer-col">
                <h2>About us</h2>
                <p>Kami adalah solusi untuk kalian yang ingin menjadi reseller namun terkendala modal atau terkendala hal yang lainya. <br> Ayo manfaatkan media sosial kamu untuk hal yang positif dan menghasilkan. </p>

                <div class="photo-stream">
                    <h2 class="margin-bottom-1">Media Social</h2>
                    <a href="https://www.facebook.com/Mitra-Reseller-1885857768329795/"><img src="<?php echo base_url('assets/images/img/facebook.png');?>"></a>
                    <a href="https://twitter.com/mitra_reseller"><img src="<?php echo base_url('assets/images/img/twitter.png');?>"></a>
                    <a href="https://www.instagram.com/mitrareseller/"><img src="<?php echo base_url('assets/images/img/instagram.png');?>"></a>
                    <a href="https://plus.google.com/u/1/115092471313721493326"><img src="<?php echo base_url('assets/images/img/google.png');?>"></a>
                </div>
            </div>
            <!-- END BOTTOM ABOUT BLOCK -->

            <!-- BEGIN BOTTOM CONTACTS -->
            <div class="col-md-4 col-sm-6 pre-footer-col">
                <h2>Our Contacts</h2>
                <address class="margin-bottom-40">
                    Jl. Merpati raya, Ciputat <br>
                    Tangerang Selatan,Banten - Indonesia<br>
                    Phone: 021 5031 2556<br>
                    Handphone: 0821 1413 7566<br>
                    Whatsapp,Telegram,Line: 0857 1153 8856<br>

                    Email: <a href="mailto:cs.mitrareseller@gmail.com">cs.mitrareseller@gmail.com</a> <br>
                </address>
                    <h2>Security</h2>
                    <a href="#"><img src="<?php echo base_url('assets/images/img/comodo_secure_seal_113x59_transp.png');?>" width="90px"></a>

            </div>
            <!-- END BOTTOM CONTACTS -->

            <!-- BEGIN TWITTER BLOCK -->
            <div class="col-md-4 col-sm-6 pre-footer-col">
                <div class="photo-stream">
                    <h2>New Reseller</h2>
                    <ul class="list-unstyled">
                        <?php
                        if($new_member){
                            foreach($new_member as $row){
                                ?>
                                <li><img title="<?php clean_and_print($row['name']); ?>" src="<?php if(empty($row['picture_url_thumb'])){echo '//mitrareseller.com/assets/images/user/default.png';}else{echo $row['picture_url_thumb'];} ?>"></li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div>

            </div>
            <!-- END TWITTER BLOCK -->
        </div>
    </div>
</div>
<!-- END PRE-FOOTER -->

<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="container">
        <div class="row">
            <!-- BEGIN COPYRIGHT -->
            <div class="col-md-4 col-sm-4 padding-top-10">
                2016 © MitraReseller. ALL Rights Reserved. <a href="javascript:;">Privacy Policy</a> | <a href="javascript:;">Terms of Service</a>
            </div>
            <!-- END COPYRIGHT -->
            <!-- BEGIN PAYMENTS -->
            <div class="col-md-4 col-sm-4">
                <ul class="list-unstyled list-inline pull-right">
                    <li><img src="<?php echo base_url(); ?>assets/images/img/mandiri.jpg" width="50px"  title="Bank Mandiri"></li>
                    <li><img src="<?php echo base_url(); ?>assets/images/img/bca.jpg" width="50px" title="Bank BCA"></li>
                    <li><img src="<?php echo base_url(); ?>assets/images/img/bri.jpg" width="50px" title="Bank BRI"></li>
                    <li><img src="<?php echo base_url(); ?>assets/images/img/bni.jpg" width="50px"  title="Bank BNI"></li>
                </ul>
            </div>
            <!-- END PAYMENTS -->
            <!-- BEGIN POWERED -->
            <div class="col-md-4 col-sm-4 text-right">
                <p class="powered">Powered by KeenThemes</p>
            </div>
            <!-- END POWERED -->
        </div>
    </div>
</div>
<!-- END FOOTER -->