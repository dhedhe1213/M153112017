<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<!-- AJAX JS -->

<script>
    var base_url = '<?php echo base_url();?>';
</script>

<script src="<?php echo base_url(); ?>assets/js_ajax/dashboard.js" type="text/javascript"></script>
<!-- End AJAX JS -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $page_title; ?>
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="dashboard"><i class="fa fa-dashboard"></i><?php echo $page_title;?></a></li>
            <li class="active"><a href="#">Data</a></li>
            <!--
            <li><a href="#">Tables</a></li>
            <li class="active">Data tables</li>
            -->
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- general form elements disabled -->
                    <div class="box-body">
                        <form id="form_edit">

                            <!-- text input -->

                            <div class="form-group">
                                <label>Email</label>
                                <input type="hidden" name="id" id="id" value="<?php clean_and_print($data['id']);?>">
                                <input type="text" name="email" id="email" class="form-control" placeholder="please write something" value="<?php clean_and_print($data['email']);?>">
                            </div>


                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="please insert new Password">
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="re_password" id="re_password" class="form-control" placeholder="please confirm new password">
                            </div>
                            <button type="button" class="btn btn-primary btn-block btn-flat" id="edit_user_admin">Save</button>
                        </form>
                        <span class="loading"></span>
                    </div><!-- /.box-body -->

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

