<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>

<script src="<?php echo base_url(); ?>assets/js_ajax/main.js" type="text/javascript"></script>
<!-- End AJAX JS -->
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-sm-12">

    <div class="content-page">
        <div class="row">

            <!-- BEGIN LEFT SIDEBAR -->
            <div class="col-md-9 col-sm-9 blog-item">
                <div class="blog-item-img">
                    <!-- BEGIN CAROUSEL -->
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img alt="" src="<?php echo base_url('assets/images/thumbnail').'/'.$data['thumbnail'];?>">
                        </div>
                    </div>
                    <!-- END CAROUSEL -->
                </div>
                <h2><?php clean_and_print($data['title']);?></h2>
                <p>
                    <?php echo $data['description'];?>
                </p>
                <ul class="blog-info">
                    <li><i class="fa fa-user"></i> By admin</li>
                    <li><i class="fa fa-calendar"></i> <?php echo $data['created'];?></li>
                    <li> Share On &nbsp
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url('mitra/blog_detail/'.$data['id'])?>" target="_blank" >
                            <img src="<?php echo base_url('assets/images/img/facebook.png')?>" alt="Facebook" width="20px" />
                        </a>
                        <a href="https://plus.google.com/share?url=<?php echo base_url('mitra/blog_detail/'.$data['id'])?>" target="_blank" >
                            <img src="<?php echo base_url('assets/images/img/google.png')?>" alt="Google" width="20px" />
                        </a>
                        <a href="https://twitter.com/share?url=<?php echo base_url('mitra/blog_detail/'.$data['id'])?>" target="_blank" >
                            <img src="<?php echo base_url('assets/images/img/twitter.png')?>" alt="Twitter" width="20px" />
                        </a>
                    </li>
                </ul>

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
                                    <h4><a href="javascript:;"><font color="#ff8c00"><?php clean_and_print($recent['title']);?></font></a></h4>
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