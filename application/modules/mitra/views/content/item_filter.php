
    <?php if($data){ ?>

        <div class="row">
    <?php
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
                            <a href="<?php echo base_url('mitra/item_detail/'.$row['id'])?>" class="btn btn-default">View</a>
                        </div>
                    </div>
                    <h3><a href="<?php echo base_url('mitra/item_detail/'.$row['id'])?>"><?php echo $row['nama'];?></a></h3>
                    <div class="pi-price">Rp <?php echo number_format($row['harga_fix'],0);?></div>
                    <a href="javascript:;" class="btn btn-default add2cart" onclick="add_to_catalog(<?php echo $row['id'];?>)">Add to Catalog</a>
                    <div class="sticker sticker-sale"></div>
                </div>
            </div>
            <!-- PRODUCT ITEM END -->
        <?php }  ?>
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
    <?php }else{ ?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="halaman">
                </br></br>
                <h3>SORRY, Product Not Found!</h3>
            </div>
        </div>
    </div>

    <?php } ?>

