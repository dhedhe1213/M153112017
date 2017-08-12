<script>
    var base_url = '<?php echo base_url();?>';
</script>

<script src="<?php echo base_url(); ?>assets/js_ajax/dashboard.js" type="text/javascript"></script>
<!-- End AJAX JS -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $page_title;?>
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
                    <div class="box-body">
                        <table id="r_cat_item" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th width="20%"></th>
                            </tr>
                            </thead>
                            <tbody>

                                <?php
                                if($data){
                                    $no = 1;
                                    foreach($data as $row){
                                ?>

                                <tr class="<?php echo $row['id']; ?>">
                                        <td width="5%"><?php echo $no; ?></td>

                                        <td><?php if($link){ echo"<a href=".base_url('dashboard/cat_item/'.$row['id']).">".$row['menu']."</a>";}else{echo $row['menu'];}?></td>
                                        <td align="center">

                                            <?php if($link) { ?>
                                            <a href="<?php echo base_url('dashboard/add_cat/' . $row['id']); ?>" class="edit-record btn btn-default fa fa-plus"> </a>
                                            <?php } ?>

                                            <a href="<?php echo base_url('dashboard/edit_cat/'. $row['id']);?>" class="edit-record btn btn-default fa fa-pencil" > </a>
                                            <a href="#" data-table="r_cat_item" onclick="delete_global(<?php echo $row['id']; ?>);" class="edit-record btn btn-default fa fa-trash-o" > </a>
                                                </td>
                                </tr>

                                <?php
                                        $no++;
                                    }
                                }
                                ?>



                            </tfoot>
                        </table>
                        <br>
                        <div class="col-md-2">
                            <?php if($cat == 0){
                            ?>
                                <a href="<?php echo base_url('dashboard/add_cat/'.$cat);?>" class="btn btn-block btn-primary">+Add New</a>
                            <?php
                            }?>
                        </div>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

