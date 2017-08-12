
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- AJAX JS -->

<script>
    var base_url = '<?php echo base_url();?>';
</script>
<script src="<?php echo base_url(); ?>assets/js_ajax/catalog.js" type="text/javascript"></script>
<!-- End AJAX JS -->

<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-7">
    <div class="product-page">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="product-main-image">
                    <img src="<?php echo base_url('assets/images/products/'.$item_images_big['img']);?>" alt="Cool green dress with red bell" class="img-responsive" data-BigImgsrc="<?php echo base_url('assets/images/products');?>/model7.jpg">
                </div>
                <div class="product-other-images">
                    <?php
                    if($item_images){
                        foreach($item_images as $row){
                            $getHarga = $this->db->get_where('t_item_harga',array('id_item'=>$item['id']))->row_array();
                            ?>
                            <a href="<?php echo base_url('assets/images/products/'.$row['img']);?>" class="fancybox-button" rel="photos-lib"><img alt="" src="<?php echo base_url('assets/images/products/'.$row['img_thumb']);?>"></a>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <h1><?php echo $item['nama'];?></h1>
                <div class="price-availability-block clearfix">
                    <div class="price">
                        <strong><span>Rp </span><?php echo number_format($getHarga['harga_fix'],0);?></strong>
                        <?php if($getHarga['harga_coret'] <> null){echo"<em>Rp <span>".number_format($getHarga['harga_coret'],0)."</span></em>";}?>
                    </div>
                    <div class="availability">
                        Stok Tersedia : <strong><?php echo $item['stok'];?></strong>
                    </div>
                </div>
                <div class="description">
                    <p><?php echo $item['deskripsi'];?></p>
                </div>
<!--                <div class="product-page-options">-->
<!--                    <div class="pull-left">-->
<!--                        <label class="control-label">Size:</label>-->
<!--                        <select class="form-control input-sm">-->
<!--                            <option>L</option>-->
<!--                            <option>M</option>-->
<!--                            <option>XL</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="pull-left">-->
<!--                        <label class="control-label">Color:</label>-->
<!--                        <select class="form-control input-sm">-->
<!--                            <option>Red</option>-->
<!--                            <option>Blue</option>-->
<!--                            <option>Black</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="product-page-cart">
<!--                    <button class="btn btn-primary" type="submit">Add to Catalog</button>-->
                </div>
                <div class="review">
                    <div class="rateit" data-rateit-value="<?php echo $item_review['rate_avg'];?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                </div>
                <div class="padding-top-20">
                    <a href="<?php echo base_url('katalog/'.$nm_catalog);?>"><button type="button" class="btn btn-primary">Kembali ke Katalog</button></a>
                </div>
<!--                <ul class="social-icons">-->
<!--                    <li><a class="facebook" data-original-title="facebook" href="javascript:;"></a></li>-->
<!--                    <li><a class="twitter" data-original-title="twitter" href="javascript:;"></a></li>-->
<!--                    <li><a class="googleplus" data-original-title="googleplus" href="javascript:;"></a></li>-->
<!--                    <li><a class="evernote" data-original-title="evernote" href="javascript:;"></a></li>-->
<!--                    <li><a class="tumblr" data-original-title="tumblr" href="javascript:;"></a></li>-->
<!--                </ul>-->
            </div>


            <?php if($item['stok'] == 0){ ?>
                <div class="sticker sticker-sold"></div>
            <?php }else{?>
                <div class="sticker sticker-sale"></div>
            <?php } ?>

        </div>

    </div>
</div>
<!-- END CONTENT -->

<!--Load review pertama buka-->
<script>
   // viewRewiew();
</script>