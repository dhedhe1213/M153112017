<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- BEGIN TOP BAR -->
<div class="pre-header">
    <div class="container">
        <div class="row">
            <!-- BEGIN TOP BAR LEFT PART -->
            <div class="col-md-6 col-sm-6 additional-shop-info">
                <ul class="list-unstyled list-inline">
<!--                    <li><i class="fa fa-phone"></i><span>+1 456 6717</span></li>-->
                    <li><i class="fa fa-envelope-o"></i><span>cs@mitrareseller.com</span></li>
                    <li><i class="fa fa-user"></i><a href="<?php echo base_url('main/register');?>">Registration</a></li>

                </ul>
            </div>
<!--             END TOP BAR LEFT PART -->
<!--             BEGIN TOP BAR MENU -->
            <div class="col-md-6 col-sm-6 additional-nav">
                <ul class="list-unstyled list-inline pull-right">
                    <li ><a href="<?php echo base_url('main/loginSeller');?>">affiliate Member</a></li>
                </ul>
            </div>
<!--             END TOP BAR MENU -->
        </div>
    </div>
</div>
<!-- END TOP BAR -->
<!-- BEGIN HEADER -->
<div class="header">
    <div class="container">
        <a class="site-logo" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/corporate/img/logos/logo-corp-red.png" alt="Metronic FrontEnd"></a>

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation pull-right font-transform-inherit">
            <ul>
                <li class="<?php if($menu == 'home'){echo 'active';}?>">
                    <a href="<?php echo base_url(); ?>">
                        Home
                    </a>
                </li>

                <li class="<?php if($menu == 'about'){echo 'active';}?>">
                    <a href="<?php echo base_url('main/about'); ?>">
                        Tentang Kami
                    </a>
                </li>

                <li class="<?php if($menu == 'blog'){echo 'active';}?>">
                    <a href="<?php echo base_url('main/blog'); ?>">
                        Blog
                    </a>
                </li>


                <!-- BEGIN TOP SEARCH -->
                <li class="menu-search">
                    <span class="sep"></span>
                     <i class="fa search-btn"><a href="<?php echo base_url();?>"> LOGIN</a></i>

<!---->
<!--                    <div class="search-box">-->
<!--                        <form action="#">-->
<!---->
<!--                                <div style="margin-bottom: 10px;">-->
<!--                                <input type="text" placeholder="E-Mail" class="form-control">-->
<!--                                    </div>-->
<!--                                    <div style="margin-bottom: 10px;">-->
<!--                                <input type="password" placeholder="Password" class="form-control">-->
<!--                                </div>-->
<!---->
<!--                             <button class="btn btn-primary" type="submit">LOGIN</button>-->
<!---->
<!---->
<!--                        </form>-->
<!--                        <hr>-->
<!--                        <div class="login-socio">-->
                            <!--                                <p class="text-muted">Or Login Using</p>-->
<!--                            <ul class="social-icons">-->
<!--                                <a class="btn btn-block btn-social btn-google">-->
<!--                                    <span class="fa fa-google"></span> Login Dengan Akun Google-->
<!--                                </a>-->
<!--                                <a class="btn btn-block btn-social btn-facebook">-->
<!--                                    <span class="fa fa-facebook"></span> Login Dengan Akun Facebook-->
<!--                                </a>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
                </li>

                <!-- END TOP SEARCH -->
            </ul>
        </div>
        <!-- END NAVIGATION -->
    </div>
</div>
<!-- Header END -->