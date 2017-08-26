
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
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php
                                    if($data['status'] == '0'){
                                        echo "Maintenance OFF";
                                    }else{
                                        echo "Maintenance ON";
                                    }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php
                                    if($data['status'] == '0'){?>

                                        <a onclick="return confirm('Are you sure to maintenance this system?');" href="<?php echo base_url('dashboard/act_maintenance/1');?>" class="" > Mode ON</a>
                                    <?php
                                    }else{
                                        ?>
                                        <a href="<?php echo base_url('dashboard/act_maintenance/0');?>" class="" > Mode OFF</a>
                                    <?php
                                    }
                                    ?>

                                </td>
                            </tr>

                            </tfoot>
                        </table>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

