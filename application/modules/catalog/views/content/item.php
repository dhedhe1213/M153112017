
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>
<script src="<?php echo base_url(); ?>assets/js_ajax/catalog.js" type="text/javascript"></script>
<!-- End AJAX JS -->

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

<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-7">
<div class="content-search margin-bottom-20">
    <div class="row">
        <div class="col-md-6">

            <h1>Cari Produk</h1>

        </div>
        <div class="col-md-6">

                <div class="input-group">
                    <input type="text" name="value" id="keywords" placeholder="Search Product" class="form-control"/>
                      <span class="input-group-btn">
                        <button class="btn btn-primary" id="btn_search" type="button" >Search</button>
                      </span>
                </div>
        </div>
    </div>
</div>



        <div class="row list-view-sorting clearfix">
            <div class="col-md-2 col-sm-2 list-view">
                <a href="javascript:;"><i class="fa fa-th-large"></i></a>
                <a href="javascript:;"><i class="fa fa-th-list"></i></a>
            </div>
            <div class="col-md-10 col-sm-10">
                <div class="pull-right">
                    <label class="control-label">Show:</label>
                    <select id="showOn" class="form-control input-sm">
                        <option value="9" selected="selected">9</option>
                        <option value="18" >18</option>
                        <option value="36" >36</option>
                    </select>
                </div>
                <div class="pull-right">
                    <label class="control-label">Sort&nbsp;By:</label>
                    <select id="sortBy" class="form-control input-sm">
                        <option value="" selected="selected">Default</option>
                        <option value="asc">Name (A - Z)</option>
                        <option value="desc">Name (Z - A)</option>
                    </select>
                </div>
            </div>
        </div>

    <input type="hidden" value="<?php echo $nm_catalog ;?>" id="nm_catalog"/>
    <div class="loading" style="display: none;margin-left:280px;"><br/><br/><br/><img src="<?php echo base_url('assets/images/img/loading.gif');?>"/><br/><br/><br/></div>
<!-- BEGIN PRODUCT LIST -->
    <div class="product-list">
<div class="row">

    <?php
    if($data){
        foreach($data as $row){
            $getItemImages = $this->db->get_where('t_item_images',array('id_item'=>$row['id']))->row_array();
    ?>
            <!-- PRODUCT ITEM START -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="product-item">
                    <div class="pi-img-wrapper">
                        <img src="<?php echo base_url('assets/images/products/'.$getItemImages['img_thumb'])?>" class="img-responsive" alt="" width="238px" height="318px">
                        <div>
                            <a href="<?php echo base_url('assets/images/products/'.$getItemImages['img'])?>" class="btn btn-default fancybox-button">Zoom</a>
                            <a href="<?php echo base_url('katalog/'.$nm_catalog.'/'.$row['id'])?>" class="btn btn-default">View</a>
                        </div>
                    </div>
                    <h3><a href="<?php echo base_url('katalog/'.$nm_catalog.'/'.$row['id'])?>"><?php echo $row['nama'];?></a></h3>
                    <div class="pi-price">Rp <?php echo number_format($row['harga_fix'],0);?></div>
                    <?php if($row['stok'] == 0){ ?>
                        <div class="sticker sticker-sold"></div>
                    <?php }else{?>
                        <div class="sticker sticker-sale"></div>
                    <?php } ?>

                </div>
            </div>
            <!-- PRODUCT ITEM END -->
    <?php
        }
    }
    ?>
</div>

<!-- BEGIN PAGINATOR -->
    <hr class="blog-post-sep">

    <div class="row">
        <div class="col-md-5 col-md-offset-4">
            <div class="halaman">
                <?php echo $halaman;?>
            </div>
        </div>
    </div>

    <hr class="blog-post-sep">
<!-- END PAGINATOR -->

    </div>
    <div class="row">
        <div class="product-page-content">

            <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="#Reviews" data-toggle="tab">Ulasan Reseller</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">

                <div class="loading-catalog" style="display: none;margin-left:280px;"><br/><br/><br/><img src="<?php echo base_url('assets/images/img/loading.gif');?>"/><br/><br/><br/></div>

                <div class="tab-pane fade in active">

                    <div id="Reviews">

                    </div>
                    <!-- BEGIN FORM-->
                    <form id="form_add" class="reviews-form">
                        <h2>Write a review for <?php echo $nm_catalog;?></h2>
                        <div class="form-group">
                            <label for="name">Kode Unik<span class="require">*</span></label>
                            <input type="text" class="form-control" name="kode" id="kode" placeholder="Cek kode anda pada invoice pembelian">
                        </div>

                        <div class="form-group">
                            <label for="name">Nama <span class="require">*</span></label>
                            <input type="hidden" name="nm_catalog" id="nm_catalog" value="<?php echo $nm_catalog;?>">
                            <input type="text" class="form-control" name="name" id="name">
                        </div>

                        <div class="form-group">
                            <label for="review">Ulasan <span class="require">*</span></label>
                            <textarea class="form-control" rows="8" name="review" id="review"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="email">Rating</label>
                            <input type="range" value="4" step="0.25" id="backing5" name="backing5">
                            <div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
                            </div>
                        </div>

                        <div class="padding-top-20">
                            <button type="button" id="add_review" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                    <span class="loading"></span>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>

</div>
<!-- END CONTENT -->
<!--Load review pertama buka-->
<script>
    viewRewiewCatalog();
</script>