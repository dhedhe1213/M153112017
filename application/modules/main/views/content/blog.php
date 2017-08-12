<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>

<script src="<?php echo base_url(); ?>assets/js_ajax/main.js" type="text/javascript"></script>
<!-- End AJAX JS -->

<!-- BEGIN CONTENT -->
<div class="col-md-12 col-sm-12">
<br>
<div class="content-page">
<div class="row">
<!-- BEGIN LEFT SIDEBAR -->
<div class="col-md-9 col-sm-9 blog-posts">

    <?php
    if($data){
        foreach($data as $row){
    ?>
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <!-- BEGIN CAROUSEL -->
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img alt="" src="<?php echo base_url('assets/images/thumbnail').'/'.$row['thumbnail'];?>">
                        </div>
                    </div>
                    <!-- END CAROUSEL -->
                </div>
                <div class="col-md-8 col-sm-8">
                    <h2><a href="<?php echo base_url('blog_detail').'/'.$row['id'];?>"><?php echo clean_and_print($row['title']);?></a></h2>
                    <hr>
                    <ul class="blog-info">
                        <li><i class="fa fa-calendar"></i> <?php echo $row['created'];?></li>
                        <li><i class="fa fa-share"></i> Share On
                            <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url('mitra/blog_detail/'.$row['id'])?>" target="_blank" >
                                <img src="<?php echo base_url('assets/images/img/facebook.png')?>" alt="Facebook" width="15px" />
                            </a>
                            <a href="https://plus.google.com/share?url=<?php echo base_url('mitra/blog_detail/'.$row['id'])?>" target="_blank" >
                                <img src="<?php echo base_url('assets/images/img/google.png')?>" alt="Google" width="15px" />
                            </a>
                            <a href="https://twitter.com/share?url=<?php echo base_url('mitra/blog_detail/'.$row['id'])?>" target="_blank" >
                                <img src="<?php echo base_url('assets/images/img/twitter.png')?>" alt="Twitter" width="15px" />
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <p><?php echo substr($row['description'],0,250);?> ...</p>
                    <a href="<?php echo base_url('blog_detail').'/'.$row['id'];?>" class="more">Read more <i class="icon-angle-right"></i></a>
                </div>
            </div>
            <hr class="blog-post-sep">
    <?php
        }
    }
    ?>

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
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
            <div class="halaman">
                <?php echo $halaman;?>
            </div>
        </div>
    </div>

    <hr class="blog-post-sep">

</div>
<!-- END LEFT SIDEBAR -->

<!-- BEGIN RIGHT SIDEBAR -->
<div class="col-md-3 col-sm-3 blog-sidebar">
    <!-- CATEGORIES START -->
    <h2 class="no-top-space">Categories</h2>
    <ul class="nav sidebar-categories margin-bottom-40">
        <li><a href="<?php echo base_url('main/blog_cat/umum')?>">Umum</a></li>
        <li><a href="<?php echo base_url('main/blog_cat/mitra')?>">Mitrareseller</a></li>
    </ul>
    <!-- CATEGORIES END -->

    <!-- BEGIN RECENT NEWS -->
    <h2>Other Article</h2>
    <div class="recent-news margin-bottom-10">

        <?php
        if($data_recent){
            foreach($data_recent as $recent){

        ?>
                <div class="row margin-bottom-10">
                    <div class="col-md-3">
                        <img class="img-responsive" alt="" src="<?php echo base_url('assets/images/thumbnail').'/'.$recent['thumbnail'];?>">
                    </div>
                    <div class="col-md-9 recent-news-inner">
                        <h4><a href="<?php echo base_url('blog_detail').'/'.$recent['id'];?>"><font color="#ff8c00"><?php clean_and_print($recent['title']);?></font></a></h4>
                        <p><?php echo substr($recent['description'],0,50);?>....</p>
                    </div>
                </div>

        <?php
            }
        }
        ?>


    </div>
    <!-- END RECENT NEWS -->





</div>
<!-- END RIGHT SIDEBAR -->
</div>
</div>
</div>
<!-- END CONTENT -->