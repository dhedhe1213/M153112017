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
                        <table id="member" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th width="25%">Nama</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th >Password</th>
                                <th>Media Daftar</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Tanggal Daftar</th>
                                <th width="10%"></th>
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
                                        <td><?php echo $row['name'];?></td>
                                        <td><?php echo $row['phone'];?></td>
                                        <td><?php echo $row['email'];?></td>
                                        <td><?php echo substr($row['password'],0,15);?>****</td>
                                        <td><?php echo $row['oauth_provider'];?></td>
                                        <td><?php if($row['confirm'] == 'true'){echo "Aktif";}else{echo "Belum Aktif";}?></td>
                                        <td><?php
                                            if($row['role_id'] == 1){
                                                echo "Reseller";
                                            }else{
                                                echo "Reseller + Seller";
                                            }
                                            ?></td>
                                        <td><?php echo $row['created'];?></td>

                                        <td align="center">
                                            <?php
                                            if($row['oauth_provider'] == 'mitrareseller'){
                                                ?>
                                                <a href="<?php echo base_url('dashboard/resetPasswordMember/'.$row['id']);?>" onclick="return confirm('Are you sure you want to Reset this password?');" class="edit-record btn btn-default" > Reset Password</a>
                                            <?php
                                            }
                                            ?>
                                            <a href="<?php echo base_url('dashboard/changeRole/'.$row['id']);?>" onclick="return confirm('Are you sure you want to change this role?');" class="edit-record btn btn-default" > Jadikan Seller</a>
                                            <?php
                                            if($row['confirm'] == 'false'){
                                                ?>
                                                <a href="<?php echo base_url('dashboard/deleteMember/'.$row['id']);?>" onclick="return confirm('Are you sure you want to Delete this member?');" class="edit-record btn btn-default" > Hapus</a>
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


                            </tfoot>
                        </table>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


