<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>
<script src="<?php echo base_url(); ?>assets/js_ajax/mitra_catalog.js" type="text/javascript"></script>
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
                        <table class="table table-bordered table-striped" id="daftar_transaksi" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>ID Transaksi</th>
                                <th>No Invoice</th>
                                <th>Komisi</th>
                                <th>Tanggal Transaksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $komisi_total = array();
                            if($data){
                                $no = 1;
                                foreach($data as $row){
                                    $getIdInvoice = $this->db->group_by('no_invoice')->get_where('t_transaksi_item',array('id_transaksi'=>$row['id']))->result_array();
                                    $getIdItem = $this->db->get_where('t_transaksi_item',array('id_transaksi'=>$row['id'],'no_resi <>'=>'0'))->result_array();
                                    ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $row['id'];?></td>
                                        <td>
                                            <?php
                                            if($getIdInvoice){
                                                foreach($getIdInvoice as $data){
                                                    echo "<a style='color:#ff1493;' href='".base_url('mitra/cetak/'.$data['no_invoice'])."' target=_blank>".$data['no_invoice']."</a></br>";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($getIdItem){
                                                $subKomisi = array();
                                                foreach($getIdItem as $data2){
                                                        $getKomisi = $this->db->get_where('m_item_harga', array('id_item' => $data2['id_item'],'id_transaksi'=>$row['id']))->row_array();
                                                        $subKomisi[] = $getKomisi['reseller_payment'] * $data2['qty'];
                                                        $komisi_total[] = $getKomisi['reseller_payment'] * $data2['qty'];
                                                }
                                            }
                                            echo number_format(array_sum($subKomisi),0);
                                            reset($subKomisi);
                                            ?>

                                            </td>
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
                        <div style="float:left;margin-left:3%;margin-bottom:5%;text-align: center;"> <font style="font-size: 17px;"> Total Komisi     </font> <font style="font-size: 25px;font-weight: bold;">Rp. <?php echo number_format(array_sum($komisi_total),0);?></font> </div>

                    </div><!-- table responsive -->
                    </br>
                    *Komisi baru akan di transfer jika > Rp.50.000,-</br>
                    *Biaya transfer ditanggung oleh anda Jika rekening anda selain (BCA,BNI,BRI,Mandiri).</br>
                    *Komisi diambil dari komisi tiap barang X jumlah barang yang terjual.</br>
                    *Data barang di ambil berdasarkan data pada tanggal dan jam yang tertera di invoice.
                </div><!-- /.box-body -->
            </div><!-- /.box -->



        </div>

</div>