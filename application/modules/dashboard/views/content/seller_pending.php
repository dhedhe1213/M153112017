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
                            <th>Nama Seller</th>
                            <th>No Invoice</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data){
                            $no = 1;
                            foreach($data as $row) {
                                $awal = date_create($row['created']);
                                $akhir = date_create(); // waktu sekarang
                                $diff = date_diff($awal, $akhir);

                                    ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $row['id_seller'];?></td>
                                        <td><?php echo $row['no_invoice'];?></td>
                                        <td><?php echo $row['created'];?></td>
                                        <td>
                                            <?php
                                            if ($diff->d > 3) {
                                                echo "<div style='color: #ff0000;'> > 3 hari </div>";
                                            }else{
                                                echo "<div style='color: #008000;'> < 3 hari </div>";
                                            }
                                            ?></td>
                                        <td>
                                            <?php
                                            if ($diff->d > 3) {
                                            ?>
                                                <a href="<?php echo base_url('dashboard/actCancelSellerPending/'.$row['no_invoice'].'/'.$row['id_seller']);?>" onclick="return confirm('are you sure to cancel?')">Cancel</a>
                                            <?php
                                            }
                                            ?>
                                           </td>
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
