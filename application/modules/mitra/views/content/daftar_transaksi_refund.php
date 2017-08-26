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
                                <th>Biaya refund</th>
                                <th>Tanggal Transaksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $komisi_total = array();
                            if($data){
                                $no = 1;
                                foreach($data as $row){
                                    #cek transaksi tunggal atau ada invoice lain
                                    $cekTransaksi = $this->db->get_where('t_transaksi',array('id'=>$row['id']))->num_rows();
                                    $cekMTransaksi = $this->db->get_where('m_transaksi',array('id'=>$row['id']))->num_rows();
                                    #---
                                    $getIdInvoice = $this->db->group_by('no_invoice')->get_where('t_transaksi_item_failed',array('id_transaksi'=>$row['id']))->result_array();
                                    $getIdItem = $this->db->get_where('t_transaksi_item_failed',array('id_transaksi'=>$row['id']))->result_array();
                                    ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $row['id'];?></td>
                                        <td>
                                            <?php
                                            if($getIdInvoice){
                                                foreach($getIdInvoice as $data){
                                                    echo "<a style='color:#ff1493;' href='".base_url('mitra/cetakDaftarRefund/'.$data['no_invoice'])."' target=_blank>".$data['no_invoice']."</a></br>";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($getIdItem){
                                                $subKomisi = array();
                                                $ongkir = array();
                                                foreach($getIdItem as $data2){
                                                        $getOngkir = $this->db->get_where('t_transaksi_item_failed', array('no_invoice' => $data2['no_invoice'],'no_resi'=> 0))->row_array();
                                                        $getKomisi = $this->db->get_where('t_item_harga', array('id_item' => $data2['id_item']))->row_array();
                                                        $subKomisi[] = $getKomisi['harga_fix'] * $data2['qty'] + $getOngkir['ongkir'];
                                                        $komisi_total[] = $getKomisi['harga_fix'] * $data2['qty'] + $getOngkir['ongkir'];
                                                }
                                            }

                                            if($cekTransaksi < 1 && $cekMTransaksi <1){
                                                $komisi_total[] = $row['kode_unik'];
                                                $subKomisiCount = array_sum($subKomisi) + $row['kode_unik'];

                                            }else{
                                                $subKomisiCount = array_sum($subKomisi);
                                            }

                                            echo number_format($subKomisiCount,0);
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
                        <div style="float:left;margin-left:3%;margin-bottom:5%;text-align: center;"> <font style="font-size: 17px;"> Total Biaya Refund     </font> <font style="font-size: 25px;font-weight: bold;">Rp. <?php echo number_format(array_sum($komisi_total),0);?></font> </div>

                    </div><!-- table responsive -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->



        </div>

</div>