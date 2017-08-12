<?php
if($data_item){
    ?>
    <div class="goods-data clearfix">
        <div class="table-wrapper-responsive">
            <table summary="Shopping cart">
                <tr>

                    <th class="goods-page-image"></th>
                    <th class="goods-page-description">Barang</th>
                    <th class="goods-page-ref-no">Code Area</th>
                    <th class="goods-page-quantity">Qty</th>
                    <th class="goods-page-price">Harga</th>
                    <th class="goods-page-total" colspan="2">Sub Total</th>
                    </center>
                </tr>
                <?php
                $total = array();
                foreach($data_item as $row){
                    $getCatalogCart = $this->db->get_where('t_catalog_cart',array('id_item'=>$row['id'],'nm_catalog'=>$nm_catalog))->row_array();
                    $getItemImages = $this->db->get_where('t_item_images',array('id_item'=>$row['id']))->row_array();
                    $getHarga = $this->db->get_where('t_item_harga',array('id_item'=>$row['id']))->row_array();
                    ?>
                    <tr>
                        <td class="goods-page-image">
                            <a href="javascript:;"><img src="<?php if($getItemImages){ echo base_url('assets/images/products/'.$getItemImages['img']);} ?>"></a>
                        </td>
                        <td class="goods-page-description" width="25%">
                            <h3><a href="<?php echo base_url('mitra/item_detail/'.$row['id']);?>"><?php echo $row['nama'];?></a></h3>
                            <!--                            <p><strong>Item 1</strong> - Color: Green; Size: S</p>-->
                            <!--                            <em>More info is here</em>-->
                        </td>
                        <td class="goods-page-price">
                            <center><strong><?php echo $row['id_user'];?></strong></center>
                        </td>
                        <td class="goods-page-price">
                            <center><strong><?php echo $getCatalogCart['qty'];?></strong></center>
                        </td>
                        <!--                                <td class="goods-page-quantity">-->
                        <!--                                    <div class="product-quantity">-->
                        <!--                                        <input id="product-quantity" type="text" value="--><?php //echo $row['min_pesan'];?><!--" readonly class="form-control input-sm">-->
                        <!--                                    </div>-->
                        <!--                                </td>-->
                        <td class="goods-page-price">
                            <strong><?php echo number_format($getHarga['harga_fix'],0,'','.');?></strong>
                        </td>
                        <td class="goods-page-total">
                            <strong><?php $total[]=$getCatalogCart['subtotal']; echo number_format($getCatalogCart['subtotal'],0,'','.');?></strong>
                        </td>
                        <td class="del-goods-col" width="21%">
                            <a class="fa fa-edit edit-jumlah" href="javascript:;" data-nama="<?php echo $row['nama'];?>" data-jumlah="<?php echo $getCatalogCart['qty'];?>" data-id="<?php echo $row['id'];?>"> Ubah Jumlah</a> |
                            <a class="fa fa-trash" href="javascript:;" onclick="deleteCart(<?php echo $getCatalogCart['id']?>)"> Hapus</a>
                        </td>
                    </tr>

                <?php
                }
                ?>

            </table>
        </div>

        <div class="shopping-total">
            <ul>
                <li class="shopping-total-price">
                    <em>Total</em>

                    <strong class="price"><span>Rp. </span><?php echo number_format(array_sum($total),0,'','.'); ?></strong>
                </li>
            </ul>
        </div>
    </div>
    <!--        <button class="btn btn-default" type="submit">Continue shopping <i class="fa fa-shopping-cart"></i></button>-->
    <a href="<?php echo base_url('mitra/catalog_checkout');?>" class="btn btn-primary" type="submit">Checkout <i class="fa fa-check"></i></a>
<?php
}else{
    echo"<div class='goods-data clearfix'>";
    echo"Shoping Cart Masih Kosong";
    echo "</div>";
}
?>