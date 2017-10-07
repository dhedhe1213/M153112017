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
                        <table id="catalogMember" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Catalog</th>
                                <th>Level</th>
                                <th>Hits</th>
                                <th>Point</th>
                                <th width="10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($data){
                                $no = 1;
                                foreach($data as $row){
                                    $getIdUser = $this->db->get_where('t_catalog',array('nm_catalog'=>$row['nm_catalog']))->row_array();
                                    $getPoint = $this->db->get_where('t_point',array('id_user'=>$getIdUser['id_user']))->row_array();

                                    ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $row['nm_catalog'];?></td>
                                        <td><?php echo $row['level'];?></td>
                                        <td><?php echo $row['hits'];?></td>
                                        <td><?php echo $getPoint['point'];?></td>
                                        <td align="center">
                                                                                        <a href="<?php echo base_url('dashboard/editCatalogMember/'.$row['nm_catalog']);?>" class="edit-record btn btn-default fa fa-pencil" > </a>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                            }
                            ?>


                            </tfoot>
                        </table>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

