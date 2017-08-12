<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>
<script src="<?php echo base_url(); ?>assets/js_ajax/mitra_catalog.js" type="text/javascript"></script>
<!-- End AJAX JS -->
<!-- BEGIN CONTENT -->

<div class="col-md-9 col-sm-9">
    <h1>Keranjang Belanja</h1>
    <div class="goods-page">
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

                                </td>
                                <td class="goods-page-price">
                                    <center><strong><?php echo $row['id_user'];?></strong></center>
                                </td>
                                <td class="goods-page-price">
                                    <center><strong><?php echo $getCatalogCart['qty'];?></strong></center>
                                </td>
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
                    <div class="table table-responsive">
                    <ul>
                        <li class="shopping-total-price">
                            <em>Total</em>

                            <strong class="price"><span>Rp. </span><?php echo number_format(array_sum($total),0,'','.'); ?></strong>
                        </li>
                    </ul>
                        </div>
                </div>
            </div>
            <!--        <button class="btn btn-default" type="submit">Continue shopping <i class="fa fa-shopping-cart"></i></button>-->
            <a href="<?php echo base_url('mitra/catalog_checkout');?>" class="btn btn-primary" type="submit">SELESAI dan Lanjut ke Pengiriman <i class="fa fa-check"></i></a>
        <?php
        }else{
            echo"<div class='goods-data clearfix'>";
            echo"Keranjang Belanja Masih Kosong";
            echo "</div>";
        }
        ?>

    </div>
</div>
<!-- END CONTENT -->
<style>
    .modal-dialog{
        width: 40%;
        padding-top: 100px;
        border-radius:0;
    }

    .modal-footer{
        border-top: none; /* Menghilangkan garis di atas kaki modal */
        margin-top: 0;
    }

    @media screen and (max-width: 500px) {
        .modal-dialog{
            width: 100%;
            border-radius:0;
            padding-right: 15px;
            padding-top: 5px;
        }

        .modal-footer{
            border-top: none; /* Menghilangkan garis di atas kaki modal */
            margin-top: 0;
        }
    }
</style>
<!-- MODAL BOOTSRAP -->
<div class="modal fade" id="ModalJumlah" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Masukan Jumlah Produk
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-sm-11">
                        <form class="form-horizontal form-without-legend" role="form" id="form-edit-jumlah">

                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Nama Produk</label>
                                <div class="col-lg-8">
                                    <input type="hidden" name="id_item" id="id_item">
                                    <input type="text" class="form-control" name="nama" id="nama" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Jumlah</label>
                                <div class="col-lg-8">
                                    <input type="text" name="jumlah" id="jumlah" class="form-control" size="5">
                                </div>

                            </div>
                        </form>
                    </div>

                </div>




            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-ubah-jumlah">SIMPAN</button>
            </div>
        </div>
    </div>
</div>