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
                            <th>Nama Barang</th>
                            <th>Komentar</th>
                            <th>Rate</th>
                            <th>Tanggal</th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data){
                            $no = 1;
                            foreach($data as $row) {
                                $getNamaBarang = $this->db->get_where('t_item',array('id'=>$row['id_item']))->row_array();
                                    ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $getNamaBarang['nama'];?></td>
                                        <td><?php echo $row['review'];?></td>
                                        <td><?php echo $row['rate'];?></td>
                                        <td><?php echo $row['created'];?></td>
                                        <td><a href="<?php echo base_url('dashboard/deleteReviewItem/'.$row['id_review']);?>" onclick="return confirm('are you sure to delete?')"><i class="fa fa-trash"></i> </a></td>
                                    </tr>
                                    <?php
                                    $no++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>

                </div><!-- table responsive -->

                </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
