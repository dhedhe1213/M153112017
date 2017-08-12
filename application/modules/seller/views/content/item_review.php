
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!--Style Paging-->
<style>
    .halaman
    {
        margin:10px;
        font-size:15px;

    }

    .halaman a
    {

        margin-left: 5px;
        padding:6px;
        background:#ff8c00;
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border:1px solid #ff8c00;
        font-size:12px;
        font-weight:bold;
        color:#FFF;
        text-decoration:none;

    }
    .halaman strong
    {

        margin-left: 5px;
        padding:6px;
        background:cornflowerblue;

        border:1px solid cornflowerblue;
        font-size:12px;
        font-weight:bold;
        color:#FFF;
        text-decoration:none;

    }
</style>
<!--di load lagi berguna untuk review pada saat paging-->
<script src="<?php echo base_url(); ?>assets/plugins/rateit/src/jquery.rateit.js" type="text/javascript"></script>

<?php
if($data){
foreach($data as $row){
?>
<div class="review-item clearfix">
    <div class="review-item-submitted">
        <strong><?php echo $row['name']?></strong>
        <em><?php echo $row['created']?></em>
        <div class="rateit" data-rateit-value="<?php echo $row['rate']?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
    </div>
    <div class="review-item-content">
        <p><?php echo $row['review']?></p>
    </div>
</div>

<?php }?>
    <?php ?>

    <!-- BEGIN PAGINATOR -->
    <div class="row">
        <div class="col-md-7 col-md-offset-4">
            <div class="halaman">
                <?php echo $halaman;?>
            </div>
        </div>
    </div>

    <hr class="blog-post-sep">
    <!-- END PAGINATOR -->

<?php }else{ ?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="halaman">
                <p>There are no reviews for this product.</p>
            </div>
        </div>
    </div>

<?php } ?>