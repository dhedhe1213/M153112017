<!DOCTYPE html>
<!--
Template: Metronic Frontend Freebie - Responsive HTML Template Based On Twitter Bootstrap 3.3.4
Version: 1.0.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase Premium Metronic Admin Theme: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Head BEGIN -->
<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="Metronic Shop UI description" name="description">
    <meta content="Metronic Shop UI keywords" name="keywords">
    <meta content="keenthemes" name="author">

    <meta property="og:site_name" content="Mitrareseller.com">
    <meta property="og:title" content="Mitrareseller">
    <meta property="og:description" content="Ingin Jadi Reseller Tanpa Modal?Kami Solusinya">
    <meta property="og:type" content="website">
    <meta property="og:image" content="-CUSTOMER VALUE-"><!-- link to image for socio -->
    <meta property="og:url" content="-CUSTOMER VALUE-">

    <link rel="shortcut icon" href="<?php echo base_url('assets/images/img/icon_title.png');?>" />

    <!-- Fonts START -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">
    <!-- Fonts END -->

    <!-- Global styles START -->
    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Global styles END -->

    <!-- Page level plugin styles START -->
    <link href="<?php echo base_url(); ?>assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/owl.carousel/assets/owl.carousel.css" rel="stylesheet">
    <!-- Page level plugin styles END -->

    <!-- Theme styles START -->
    <link href="<?php echo base_url(); ?>assets/pages/css/components.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/corporate/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/pages/css/style-shop.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/corporate/css/style-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/corporate/css/themes/red.css" rel="stylesheet" id="style-color">
    <link href="<?php echo base_url(); ?>assets/corporate/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/rateit/src/rateit.css" rel="stylesheet" type="text/css">
    <!-- Theme styles END -->

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url() ; ?>assets/admin/plugins/datatables/dataTables.bootstrap.css">
    <!--JQuery-->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-3.1.1.min.js" type="text/javascript"></script>

    <!--Sweet Alert-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweet_alert/sweetalert.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/sweet_alert/sweetalert.min.js"></script>

</head>
<!-- Head END -->

<!-- Body BEGIN -->
<body class="ecommerce">
<?php
######################### HEADER ##########################

$this->load->view('atribute/header');

###########################################################
?>


<div class="main">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">My Account Page</li>
        </ul>
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <?php
            ######################### NAVIGATION LEFT && CONTENT ##########################

            $this->load->view('atribute/navigation');
            $this->load->view($main_view);

            ###########################################################
            ?>

        </div>
        <!-- END SIDEBAR & CONTENT -->
    </div>
</div>

<?php
######################### NAVIGATION LEFT ##########################

$this->load->view('atribute/footer');

###########################################################
?>

<!-- Load javascripts at bottom, this will reduce page load time -->
<!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/plugins/respond.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>assets/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/corporate/scripts/back-to-top.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- DataTables -->
<script src="<?php echo base_url() ; ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ; ?>assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script src="<?php echo base_url();?>assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script><!-- Quantity -->

<!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
<script src="<?php echo base_url(); ?>assets/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
<script src="<?php echo base_url(); ?>assets/plugins/owl.carousel/owl.carousel.min.js" type="text/javascript"></script><!-- slider for products -->
<script src="<?php echo base_url(); ?>assets/plugins/rateit/src/jquery.rateit.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/corporate/scripts/layout.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();
        Layout.initOWL();
        Layout.initTwitter();
        Layout.initTouchspin();
    });
</script>

<!-- END PAGE LEVEL JAVASCRIPTS -->

<!-- JQUERY UI untuk autocomplete ditaro bawah biar ga bentrok-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui.js"></script>
<!--End Jquery UI-->

<!--bootsrap js taro di bawah karena bentrok sama jquery UI-->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/plugins/jquery.form.min.js" type="text/javascript"></script>


<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-101612759-1', 'auto');
    ga('send', 'pageview');

</script>

</body>
<!-- END BODY -->
</html>