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
                        <form id="form_add" enctype="multipart/form-data">
                            <!-- text input -->

                            <div class="form-group">
                                <label>Category</label>
                                <input type="hidden" name="id" id="id" class="form-control" value="<?php echo $data['id'];?>" placeholder="please write something">
                                <input type="hidden" name="parent_id" id="parent_id" class="form-control" value="<?php echo $data['parent_id'];?>" placeholder="please write something">
                                <input type="text" name="category" id="category" class="form-control" value="<?php echo $data['menu'];?>" placeholder="please write something">
                               </div>
                            <div class="form-group">
                                <label>Menu Order</label>
                                     <input type="text" name="menu_order" id="menu_order" class="form-control" value="<?php echo $data['menu_order'];?>" placeholder="please write something">
                            </div>

                            <button type="button" class="btn btn-primary btn-block btn-flat" id="edit_cat">Save</button>
                        </form>
<!--                        <span class="loading"></span>-->
                    </div><!-- /.box-body -->

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

