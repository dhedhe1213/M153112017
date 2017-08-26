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
                                <th>Data Transaksi</th>
                                <th>Total Komisi</th>
                                <th>Bukti</th>
                                <th>Tanggal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($data){
                                $no = 1;
                                foreach($data as $row){
                                    $getIdPayment = $this->db->get_where('m_payment_item',array('id_payment'=>$row['id']))->result_array();
                                   ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td>
                                            <table class="table table-bordered table-striped">
                                                <tr><th>No Invoice</th><th>Nama Barang</th><th>Komisi</th></tr>

                                                    <?php
                                                    if($getIdPayment){
                                                        $totalKomisi = array();
                                                        $ongkir = array();
                                                        foreach($getIdPayment as $data){
                                                            #jika refund

                                                                $getIdTransaksi = $this->db->get_where('m_transaksi_item',array('id_transaksi'=>$data['id_transaksi']))->result_array();
                                                                if($getIdTransaksi){

                                                                    foreach($getIdTransaksi as $data2){
                                                                        $getDataItem = $this->db->get_where('m_item',array('id'=>$data2['id_item'],'id_transaksi'=>$data['id_transaksi']))->row_array();
                                                                        $getDataItemHarga = $this->db->get_where('m_item_harga',array('id_item'=>$data2['id_item'],'id_transaksi'=>$data['id_transaksi']))->row_array();
                                                                        $getOngkir = $this->db->get_where('m_transaksi_item_failed', array('no_invoice' => $data2['no_invoice'],'no_resi'=> 0))->row_array();

                                                                        $komisi = array();
                                                                        $count = $getDataItemHarga['reseller_payment'] * $data2['qty'];
                                                                        $komisi[] = $count;
                                                                        $totalKomisi[] = $count;
                                                                        $ongkir[] = $getOngkir['ongkir'];
                                                                        ?>
                                                                        <tr><td><?php echo "<a style='color:#ff1493;' href='".base_url('mitra/cetakHistory/'.$data2['no_invoice'])."' target=_blank>".$data2['no_invoice']."</a></br>";?></td><td><?php echo $getDataItem['nama'];?></td><td><?php echo number_format(array_sum($komisi),0);?></td></tr>
                                                                        <?php
                                                                        reset($komisi);
                                                                    }

                                                                }

                                                        }
                                                    }
                                                    ?>


                                            </table>
                                        </td>
                                        <td><?php echo number_format(array_sum($totalKomisi)+array_sum($ongkir),0); reset($totalKomisi);reset($ongkir); if($row['payment_refund'] == 1){echo" (Payment Refund, Sudah termasuk ongkos kirim)";}?></td>
                                        <td><a href="<?php echo $row['link_images'];?>" target="_blank" style="color: #0000ff;">Lihat Disini</a> </td>
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

                    </div><!-- table responsive -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->



        </div>

</div>