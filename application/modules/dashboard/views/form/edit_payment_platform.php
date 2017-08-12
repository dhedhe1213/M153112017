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
                        <form method="post" action="<?php echo base_url('dashboard/act_paymentPlatform');?>">

                            <!-- text input -->

                            <div class="form-group">
                                <label>Presentase Payment</label>
                                <select class="form-control" name="presentase_payment">
                                <option value="<?php clean_and_print($data['payment_presentase']);?>"><?php clean_and_print($data['payment_presentase']);?> %</option>
                                    <option value="1">1 %</option>
                                    <option value="2">2 %</option>
                                    <option value="3">3 %</option>
                                    <option value="4">4 %</option>
                                    <option value="5">5 %</option>
                                    <option value="6">6 %</option>
                                    <option value="7">7 %</option>
                                    <option value="8">8 %</option>
                                    <option value="9">9 %</option>
                                    <option value="10">10 %</option>
                                </select>
                            </div>


                            <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
                        </form>
                        <span class="loading"></span>
                    </div><!-- /.box-body -->

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

