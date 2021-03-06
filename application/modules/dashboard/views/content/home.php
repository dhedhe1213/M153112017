
<!-- Load Javascript On Template-->

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>
                <p>Bounce Rate</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>44</h3>
                <p>User Registrations</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>65</h3>
                <p>Unique Visitors</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->
<!-- Main row -->
<div class="row">
<!-- Left col -->
<section class="col-lg-7 connectedSortable">


    <!-- Map box -->
    <div class="box box-solid bg-light-blue-gradient">
        <div class="box-header">
            <!-- tools box -->
            <div class="pull-right box-tools">
                <button class="btn btn-primary btn-sm pull-right" data-widget="remove"><i class="fa fa-times"></i></button>
                <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
            </div><!-- /. tools -->

            <i class="fa fa-map-marker"></i>
            <h3 class="box-title">
                Visitors
            </h3>
        </div>
        <div class="box-body">
            <div id="world-map" style="height: 250px; width: 100%;"></div>
        </div><!-- /.box-body-->
    </div>
    <!-- /.box -->


</section><!-- /.Left col -->
<!-- right col (We are only adding the ID to make the widgets sortable)-->
<section class="col-lg-5 connectedSortable">

    <!-- solid sales graph -->
    <div class="box box-solid bg-yellow-gradient">
        <div class="box-header">
            <i class="fa fa-th"></i>
            <h3 class="box-title">Transaction Graph</h3>
            <div class="box-tools pull-right">
                <button class="btn bg-yellow btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn bg-yellow btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body border-radius-none">
            <div class="chart" id="line-chart" style="height: 250px;"></div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->



</section><!-- right col -->
</div><!-- /.row (main row) -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->