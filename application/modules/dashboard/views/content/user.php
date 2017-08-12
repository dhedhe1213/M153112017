
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
                                <th>Email</th>
                                <th>Password</th>
                                <th width="10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo $data['email'];?></td>
                                <td><?php echo $data['password'];?></td>
                                <td align="center">
                                    <a href="<?php echo base_url('dashboard/edit_user/');?>" class="edit-record btn btn-default fa fa-pencil" > </a>
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

