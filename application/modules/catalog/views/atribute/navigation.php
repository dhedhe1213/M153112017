
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <!-- BEGIN SIDEBAR -->
    <div class="sidebar col-md-3 col-sm-3">
        <div class="list-group margin-bottom-25 sidebar-menu" style="background: white;">
            <center>
            <img src="<?php echo $data_profile['picture_url']; ?>" style="margin-top: 30px;" width="150px" height="180px"/>
            <br><br>
            <?php echo $data_profile['name']; ?><br>
            <img src="<?php echo base_url('assets/images/img/'.$catalog_data['level'].'-medal.png'); ?>" style="margin-top: 5px;" width="60px" height=""/>
            <hr>
                Rating Reseller
                <div class="review">
                    <div class="rateit" data-rateit-value="<?php echo $catalog_review['rate_avg'];?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                </div>
            <br>
            </center>
        </div>
    </div>
    <!-- END SIDEBAR -->