<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- BEGIN TOP BAR -->
<!--<div class="pre-header">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- END TOP BAR -->

<!-- BEGIN HEADER -->
<div class="header">
<div class="container">
    <a class="site-logo" href="<?php echo base_url('mitra'); ?>"><img src="<?php echo base_url(); ?>assets/corporate/img/logos/logo-corp-red.png" alt="Metronic FrontEnd"></a>
<a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

    <script>
        base_url = "<?php echo base_url()?>";
            function loadCatalogCartHeader() {
                $.ajax({
                    type: 'GET',
                    url: base_url+'mitra/catalog_count_cart',
                    success: function (html) {
                        $('.top-cart-info').html(html);
                    }
                });
            }
        loadCatalogCartHeader();
    </script>
    <!-- BEGIN CART -->
    <div class="top-cart-block">
        <div class="top-cart-info">

        </div>
        <i class="fa fa-shopping-cart"></i>

<!--        <div class="top-cart-content-wrapper">-->
<!--            <div class="top-cart-content">-->
<!--                <ul class="scroller" style="height: 250px;">-->
<!--                    <li>-->
<!--                        <a href="shop-item.html"><img src="assets/pages/img/cart-img.jpg" alt="Rolex Classic Watch" width="37" height="34"></a>-->
<!--                        <span class="cart-content-count">x 1</span>-->
<!--                        <strong><a href="shop-item.html">Rolex Classic Watch</a></strong>-->
<!--                        <em>$1230</em>-->
<!--                        <a href="javascript:void(0);" class="del-goods">&nbsp;</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="shop-item.html"><img src="assets/pages/img/cart-img.jpg" alt="Rolex Classic Watch" width="37" height="34"></a>-->
<!--                        <span class="cart-content-count">x 1</span>-->
<!--                        <strong><a href="shop-item.html">Rolex Classic Watch</a></strong>-->
<!--                        <em>$1230</em>-->
<!--                        <a href="javascript:void(0);" class="del-goods">&nbsp;</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <div class="text-right">-->
<!--                    <a href="shop-shopping-cart.html" class="btn btn-default">View Cart</a>-->
<!--                    <a href="shop-checkout.html" class="btn btn-primary">Checkout</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
    <!--END CART -->

<!-- BEGIN NAVIGATION -->
<div class="header-navigation">
    <ul>
        <?php
        get_instance()->load->helper('menu_helper');
        echo getMenu();
        echo newItemMenu();
        ?>



        <!-- BEGIN TOP SEARCH -->
<!--        <li class="menu-search">-->
<!--            <span class="sep"></span>-->
<!--            <i class="fa fa-search search-btn"></i>-->
<!--            <div class="search-box">-->
<!--                <form action="#">-->
<!--                    <div class="input-group">-->
<!--                        <input type="text" placeholder="Search" class="form-control">-->
<!--                    <span class="input-group-btn">-->
<!--                      <button class="btn btn-primary" type="submit">Search</button>-->
<!--                    </span>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
<!--        </li>-->
        <!-- END TOP SEARCH -->
    </ul>
</div>
<!-- END NAVIGATION -->
</div>
</div>
<!-- Header END -->