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
                        <form method="post" action="<?php echo base_url('dashboard/act_editCatalog');?>">

                            <!-- text input -->

                            <div class="form-group">
                                <label>Level Catalog</label>
                                <input type="hidden" name="nm_catalog" value="<?php clean_and_print($data['nm_catalog']);?>">
                                <select class="form-control" name="level">
                                <option><?php clean_and_print($data['level']);?></option>
                                    <option>silver</option>
                                    <option>gold</option>
                                    <option>platinum</option>
                                </select>
                            </div>


                            <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
                        </form>
                        <span class="loading"></span>
                    </div><!-- /.box-body -->

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

