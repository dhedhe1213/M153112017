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
                                <label>Title</label>
                                <input type="hidden" name="id" id="id" class="form-control" value="<?php clean_and_print($data['id']);?>" placeholder="please write something">
                                <input type="hidden" name="category" id="category" class="form-control" value="<?php clean_and_print($data['category']);?>" placeholder="please write something">
                                <input type="text" name="title" id="title" class="form-control" placeholder="please write something" value="<?php clean_and_print($data['title']);?>">
                            </div>


                            <!-- textarea  -->
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="please write something"><?php clean_and_print($data['description']);?></textarea>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="old_thumbnail" id="old_thumbnail" value="<?php clean_and_print($data['thumbnail']);?>">
                                <label>Thumbnail (JPG|Max Size 500 Kb | Ideal 840 x 490 Pixel)</label><br>
                                <img id="tampil" src="<?php echo base_url('assets/images/thumbnail/'.$data['thumbnail'])?>" alt="" width="150px" height="150px"/>
                                <input type="file" name="thumbnail" id="thumbnail">


                            </div>

                            <button type="button" class="btn btn-primary btn-block btn-flat" id="edit_blog">Save</button>
                        </form>
                        <!--                        <span class="loading"></span>-->
                    </div><!-- /.box-body -->

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

