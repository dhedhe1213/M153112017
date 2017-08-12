<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>


<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>

<script src="<?php echo base_url(); ?>assets/js_ajax/main.js" type="text/javascript"></script>
<!-- End AJAX JS -->

<style type="text/css">
    label.error { color:red; margin-left: 10px; font-weight:1; }
</style>

<?php echo $script_captcha; // javascript recaptcha ?>

<!-- BEGIN CONTENT -->
<div class="col-md-12 col-sm-12">
    <h3>REGISTRASI</h3>
    <div class="content-form-page">
        <div class="row">
            <div class="col-md-7 col-sm-7">
                <form class="form-horizontal form-without-legend" role="form" id="form_register">
                    <div class="form-group">
                        <label for="name" class="col-lg-4 control-label">Nama Lengkap <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control required" id="name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hp" class="col-lg-4 control-label">No.Handphone <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control required" id="phone" name="phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-lg-4 control-label">Email <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control required" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-lg-4 control-label">Password <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control required" id="password" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="re_password" class="col-lg-4 control-label">Ulangi Password <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control required" id="re_password" name="re_password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="re_password" class="col-lg-4 control-label">Tanggal Lahir <span class="require">*</span></label>
                        <div class="col-lg-2">
                           <select class="form-control required" id="date" name="date">
                               <option value="">Date</option>
                               <?php
                               for ($x = 1; $x <= 31; $x++) {
                                   echo "<option>$x</option>";
                               }
                               ?>
                           </select>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-control required" id="month" name="month">
                                <option value="">Month</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value=07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="12">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select class="form-control required" id="year" name="year">
                                <option value="">Year</option>
                                <?php
                                for ($x = 1970; $x <= 2010; $x++) {
                                echo "<option>$x</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="re_password" class="col-lg-4 control-label">Jenis Kelamin <span class="require">*</span></label>
                        <div class="col-lg-4">
                            <select class="form-control required" id="gender" name="gender">
                                <option value="">Choose</option>
                                <option>Laki-laki</option>
                                <option>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label"></label>
                        <div class="col-lg-1">
                        <?php echo $captcha // tampilkan recaptcha ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-offset-4 padding-left-0">
                            <font style="color: gray"> By clicking Register Account, I confirm I have agreed to
                                Terms & Condition, and Security Privacy of MitraReseller.  </font>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                            <button type="submit" class="btn btn-primary" id="register" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Processing">Register</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-5 col-sm-5 pull-right">

<!--                <div class="form-info">-->
<!--                <div class="login-socio">-->
<!--                                                    <p class="text-muted">Or Login Using</p>-->
<!--                    <ul class="social-icons">-->
<!--                        <a class="btn btn-block btn-social btn-google">-->
<!--                            <span class="fa fa-google"></span> Register Dengan Akun Google-->
<!--                        </a>-->
<!--                        <a class="btn btn-block btn-social btn-facebook">-->
<!--                            <span class="fa fa-facebook"></span> Register Dengan Akun Facebook-->
<!--                        </a>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                    </div>-->
                <hr>
                <div class="form-info">
                    <h2><em>SUDAH</em> Punya Akun MitraReseller?</h2>
                    <p>Silahkan anda klik LOGIN untuk masuk.</p>

                    <a href="<?php echo base_url();?>"><button type="button" class="btn btn-default">LOGIN</button></a>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->

    