<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" size="16x16" href="assets/img/cp.png">
    <title><?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url() ; ?>assets/admin/bootstrap/css/bootstrap.min.css">
    <!-- custom untuk modal -->
    <link rel="stylesheet" href="<?php echo base_url() ; ?>assets/admin/bootstrap/css/custom.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() ; ?>assets/admin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="<?php echo base_url() ; ?>assets/admin/dist/css/skins/skin-blue.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url() ; ?>assets/admin/plugins/datatables/dataTables.bootstrap.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

      <!--JQuery-->
      <script src="<?php echo base_url(); ?>assets/plugins/jquery-3.1.1.min.js" type="text/javascript"></script>
      <!--Sweet Alert-->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweet_alert/sweetalert.css">
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/sweet_alert/sweetalert.min.js"></script>
      <!-- Tinymce -->
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/tinymce/tinymce.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/tinymce/tinymce_config.js"></script>

  </head>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      
      <?php
      $this->load->view('part/header');
      $this->load->view('part/navigation');
      $this->load->view($main_view);
      $this->load->view('part/footer.php');      
      ?>
    

    <!-- REQUIRED JS SCRIPTS -->

    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url() ; ?>assets/admin/bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url() ; ?>assets/admin/dist/js/app.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url() ; ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ; ?>assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url() ; ?>assets/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url() ; ?>assets/admin/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url() ; ?>assets/admin/dist/js/demo.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>

     <!-- iCheck for mailbox-->
     <link rel="stylesheet" href="<?php echo base_url() ; ?>assets/admin/plugins/iCheck/flat/blue.css">
    <script src="<?php echo base_url() ; ?>assets/admin/plugins/iCheck/icheck.min.js"></script>
    <!-- Page Script -->
    <script>
      $(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }
          $(this).data("clicks", !clicks);
        });

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
          e.preventDefault();
          //detect type
          var $this = $(this).find("a > i");
          var glyph = $this.hasClass("glyphicon");
          var fa = $this.hasClass("fa");

          //Switch states
          if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
          }

          if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
          }
        });
      });
    </script>

        <script>
            $('#confirm-delete').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

                $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
            });
        </script>

  </body>
</html>
