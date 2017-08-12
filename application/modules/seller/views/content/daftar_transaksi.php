<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>
<script src="<?php echo base_url(); ?>assets/js_ajax/seller.js" type="text/javascript"></script>
<!-- End AJAX JS -->
<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-9">
    <!--    <h1>Pemesanan Behasil</h1>-->
    <div class="content-form-page">
        <div class="row">

            <div class="box">
                <div class="box-body">
                    <div class="table-responsive"> <!-- table responsive -->
                        <!--                        <input type="hidden" value="--><?php //echo $category; ?><!--" class="category">-->
                        <table class="table table-bordered table-striped" id="barangku" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>No Invoice</th>
                                <th>Sub Total</th>
                                <th>Tanggal Transaksi</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $saldoTotal = array();

                            if($data){
                                $no = 1;
                                foreach($data as $row) {
                                    $ongkir = $row['ongkir'];
                                    $getData = $this->db->get_where('t_transaksi_item',array('id_transaksi'=>$row['id_transaksi'],'id_seller'=>$id_seller))->result_array();
                                    if($getData){
                                        $subTotalTmp = array();
                                        foreach($getData as $data){
                                            $getHargaSeller = $this->db->get_where('m_item_harga', array('id_item' => $data['id_item'],'id_transaksi'=>$row['id_transaksi']))->row_array();
                                            $subTotal = $getHargaSeller['harga_seller'] * $data['qty'];
                                            $subTotalTmp[] = $subTotal;
                                        }

                                        $subTotalCountFix = array_sum($subTotalTmp) + $ongkir;
                                        $saldoTotal[] = $subTotalCountFix;
                                        reset($subTotalTmp);
                                    }

                                    ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo "<a style='color:#ff1493;' href='".base_url('seller/cetak/'.$row['no_invoice'])."' target=_blank>".$row['no_invoice']."</a>";?></td>
                                        <td><?php echo number_format($subTotalCountFix,0);?></td>
                                        <td><?php echo $row['created'];?></td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                            }
                            ?>

                            </tbody>
                        </table>
                        </br>
                        <div style="float:left;margin-left:3%;margin-bottom:5%;text-align: center;"> <font style="font-size: 17px;"> Total Saldo     </font> <font style="font-size: 25px;font-weight: bold;">Rp. <?php echo number_format(array_sum($saldoTotal),0);?></font> </div>


                    </div><!-- table responsive -->
                    </br>
                    *Saldo akan di transfer jika > Rp.50.000,-</br>
                    *Biaya transfer ditanggung oleh anda Jika rekening anda selain (BCA,BNI,BRI,Mandiri).</br>
                    *Subtotal diambil dari harga barang (tanpa komisi reseller dan payment platform) X jumlah barang yang terjual + biaya kirim </br>
                    *Data barang di ambil berdasarkan data pada tanggal dan jam yang tertera di invoice
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

