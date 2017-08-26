<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(empty($authUrl)) {
    $cekSession = $this->session->userdata('role_id');
    if($cekSession == 2){
        redirect('seller');
    }else{
        //reset userdata dulu biar aman
        $this->session->set_userdata(array('id' => '','role_id' => '','email' => '','login' => '','name'=>'','token'=>''));
        //end
        redirect('main/loginSeller');
    }
}
?>


<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>

<script src="<?php echo base_url(); ?>assets/js_ajax/dpanel.js" type="text/javascript"></script>
<!-- End AJAX JS -->

<!--  BEGIN BREADCUM -->
<ul class="breadcrumb">
    <li><a href="<?php echo base_url();?>">Home</a></li>
<!--    <li><a href="javascript:;">Pages</a></li>-->
    <li class="active">Login</li>
</ul>
<!-- END BREADCUM -->


<!-- BEGIN CONTENT -->
<div class="col-md-12 col-sm-12">
    <?php
    $getStatusSystem = $this->db->get('m_maintenance')->row_array();
    if($getStatusSystem['status'] == '1'){
        echo "Mohon maaf, Kami sedang melakukan perbaikan system...";
        echo"</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>";
    }else{
    ?>
    <h1>Login Affiliate Member</h1>
    <div class="content-form-page">
        <div class="row">
            <div class="col-md-7 col-sm-7">
                <form id="login-form-content" class="form-horizontal form-without-legend" role="form">
                    <div class="form-group">
                        <label for="email" class="col-lg-4 control-label">Email <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-lg-4 control-label">Password <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" id="password_seller" name="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-offset-4 padding-left-0">
                            <div class=""> Lupa Password? Segera hubungi CS kami!</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                            <button type="button" class="btn btn-primary" id="btn-login-seller">Login Affiliate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-10 padding-right-30">
                            <hr>
                            <div class="login-socio">
<!--                                <p class="text-muted">Or Login Using</p>-->
                                <ul class="social-icons">
                                    <a href="<?php echo $authUrl;?>" class="btn btn-block btn-social btn-google">
                                        <span class="fa fa-google"></span> Login Dengan Akun Google
                                    </a>
                                    </br>
<!--                                    <a class="btn btn-block btn-social btn-facebook">-->
<!--                                        <span class="fa fa-facebook"></span> Login Dengan Akun Facebook-->
<!--                                    </a>-->
<!--                                    <li><a href="javascript:;" data-original-title="facebook" class="facebook" title="facebook"></a></li>-->
<!--                                    <li><a href="javascript:;" data-original-title="Google Plus" class="googleplus" title="Google Plus"></a></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5 col-sm-5 pull-right">
                <div class="form-info">
                    <h2><em>BELUM</em> Punya Akun MitraReseller?</h2>
                    <p>Silahkan anda klik REGISTER untuk melakukan Registrasi.</p>

                   <a href="<?php echo base_url('main/register');?>"> <button type="button" class="btn btn-default">REGISTER</button></a>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>
<!-- END CONTENT -->
         
    