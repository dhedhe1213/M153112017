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
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-social.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-social.less" rel="stylesheet">
    <!-- Global styles END -->

    <!-- Page level plugin styles START -->
    <link href="<?php echo base_url(); ?>assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin styles END -->

    <!-- Theme styles START -->
    <link href="<?php echo base_url(); ?>assets/pages/css/components.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/corporate/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/corporate/css/style-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/corporate/css/themes/red.css" rel="stylesheet" id="style-color">
    <link href="<?php echo base_url(); ?>assets/corporate/css/custom.css" rel="stylesheet">
    <!-- Theme styles END -->

    <!--JQuery-->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-3.1.1.min.js" type="text/javascript"></script>


    <!--Sweet Alert-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweet_alert/sweetalert.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/sweet_alert/sweetalert.min.js"></script>


</head>
<!-- Head END -->

<!-- Body BEGIN -->
<body class="corporate">

<?php
######################### HEADER ##########################

$this->load->view('atribute/header');

###########################################################
?>
<div class="main">
    <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
<?php
############### NAVIGATION LEFT & CONTENT #################

$this->load->view($main_view);

###########################################################
?>

        </div>
        <!-- END SIDEBAR & CONTENT -->
    </div>
</div>

<?php
######################### HEADER ##########################

$this->load->view('atribute/footer');

###########################################################
?>

<!-- Load javascripts at bottom, this will reduce page load time -->
<!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/plugins/respond.min.js"></script>
<![endif]-->
<script src="<?php echo base_url(); ?>assets/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/corporate/scripts/back-to-top.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
<script src="<?php echo base_url(); ?>assets/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/corporate/scripts/layout.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();
        Layout.initUniform();
        Layout.initTwitter();
    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->


<!-- Jquery Validation -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery.validate.min.js" type="text/javascript"></script>

</body>
<!-- END BODY -->
</html>