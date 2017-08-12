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
            <li class="active"><a href="#"><i class="fa fa-dashboard"></i><?php echo $page_title;?></a></li>
            <li class="active"><a href="#">Data</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                <div class="box-body">
                <div class="table-responsive"> <!-- table responsive -->
                    <table class="table table-bordered table-striped" id="conf_pembayaran">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Title</th>
                            <th>Link File</th>
                            <th>Size</th>
                            <th>Created</th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($data){
                            $no = 1;
                            foreach($data as $row){
                        ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $row['title'];?></td>
                                    <td><?php echo "<a href='".base_url('assets/images/media')."/".$row['name_file']."'>Link</a>";?></td>
                                    <td><?php echo $row['size'];?> kB</td>
                                    <td><?php echo $row['created'];?></td>
                                    <td><a href="<?php echo base_url('dashboard/actDeleteMedia/'.$row['id'].'/'.$row['name_file']);?>" onclick="return confirm('are you sure to delete?')" class="edit-record btn btn-default fa fa-trash-o"></a></td>
                                </tr>

                            <?php
                                $no++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>

                </div><!-- table responsive -->
                    <br>
                    <div class="col-md-2">

                        <button class="btn btn-block btn-primary" type="button" data-toggle="modal" data-target="#modalMedia">+Add New</button>
                    </div>
                </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- END CONTENT -->
<style>
    .modal-dialog{
        width: 40%;
        padding-top: 100px;
        border-radius:0;
    }

    .modal-footer{
        border-top: none; /* Menghilangkan garis di atas kaki modal */
        margin-top: 0;
    }
</style>
<!-- MODAL BOOTSRAP -->
<div class="modal fade" id="modalMedia" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Insert File To Media
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-sm-11">
                        <form method="post" action="actInsertMedia" enctype="multipart/form-data" class="form-horizontal form-without-legend" role="form">
                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Title</label>
                                <div class="col-lg-8">
                                    <input type="text" class="" style="margin-top: 3px;" name="title">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Choose File(jpg|png|pdf) Maks.500kb</label>
                                <div class="col-lg-8">
                                    <input type="file" class="" style="margin-top: 3px;" name="media">
                                </div>
                            </div>


                    </div>

                </div>




            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </div>
            </form>
        </div>
    </div>
</div>