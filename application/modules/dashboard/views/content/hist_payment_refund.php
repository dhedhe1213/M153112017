<script>
    var base_url = '<?php echo base_url();?>';
</script>

<script src="<?php echo base_url(); ?>assets/js_ajax/dashboard.js" type="text/javascript"></script>
<!-- End AJAX JS -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $page_title;?>
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-dashboard"></i><?php echo $page_title;?></a></li>
            <li class="active"><a href="#">Data</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                <div class="box-body">
                <div class="table-responsive"> <!-- table responsive -->
                    <table class="table table-bordered table-striped" id="conf_pembayaran" width="100%">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Reseller</th>
                            <th>Data Transaksi</th>
                            <th>Total Harga</th>
                            <th>Bukti</th>
                            <th>Tanggal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($data){
                            $no = 1;
                            foreach($data as $row){
                                $getIdPayment = $this->db->group_by('id_transaksi')->get_where('m_payment_item',array('id_payment'=>$row['id']))->result_array();
                                $getDataSeller = $this->db->get_where('m_user',array('id'=>$row['id_user']))->row_array();
                                ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $getDataSeller['name'];?></td>
                                    <td>
                                        <table class="table table-bordered table-striped">
                                            <tr><th>No Invoice</th><th>Nama Barang</th><th>Harga</th></tr>

                                            <?php
                                            if($getIdPayment){
                                                $totalKomisi = array();
                                                $ongkir = array();
                                                foreach($getIdPayment as $data){
                                                    #cek transaksi tunggal atau ada invoice lain
                                                    $cekTransaksi = $this->db->get_where('t_transaksi',array('id'=>$data['id_transaksi']))->num_rows();
                                                    $cekMTransaksi = $this->db->get_where('m_transaksi',array('id'=>$data['id_transaksi']))->num_rows();
                                                    $getDataTransaksi = $this->db->get_where('m_transaksi_failed',array('id'=>$data['id_transaksi']))->row_array();
                                                    #---
                                                    $getIdTransaksi = $this->db->get_where('m_transaksi_item_failed',array('id_transaksi'=>$data['id_transaksi']))->result_array();
                                                    if($getIdTransaksi){
                                                        foreach($getIdTransaksi as $data2){
                                                            $getOngkir = $this->db->get_where('m_transaksi_item_failed', array('no_invoice' => $data2['no_invoice'],'no_resi'=> 0))->row_array();
                                                            $getDataItem = $this->db->get_where('m_item',array('id'=>$data2['id_item']))->row_array();
                                                            $getDataItemHarga = $this->db->get_where('m_item_harga',array('id_item'=>$data2['id_item']))->row_array();

                                                            $komisi = array();
                                                            $count = $getDataItemHarga['harga_fix'] * $data2['qty'];
                                                            $komisi[] = $count;
                                                            $ongkir[] = $getOngkir['ongkir'];
                                                            $totalKomisi[] = $count;
                                                            ?>
                                                            <tr><td><?php echo $data2['no_invoice'];?></td><td><?php echo $getDataItem['nama'];?></td><td><?php echo number_format(array_sum($komisi),0);?></td></tr>
                                                            <?php
                                                            reset($komisi);


                                                        }

                                                    }
                                                    if($cekTransaksi < 1 && $cekMTransaksi < 1){
                                                        $totalKomisi[] = $getDataTransaksi['kode_unik'];
                                                    }
                                                }

                                            }
                                            ?>


                                        </table>
                                    </td>
                                    <td><?php echo number_format(array_sum($totalKomisi)+array_sum($ongkir),0)." (sudah termasuk biaya kirim + kode unik jika transaksi tunggal)"; reset($totalKomisi);reset($ongkir);?></td>
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

                </div><!-- table responsive -->

                </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

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
</style>
<!-- MODAL BOOTSRAP -->
<div class="modal fade" id="modalPayment" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Masukan URL Bukti Transfer
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-sm-11">
                        <form class="form-horizontal form-without-legend" role="form" id="form-payment">

                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">URL Bukti Transfer</label>
                                <div class="col-lg-8">
                                    <input type="hidden" name="nm_catalog" id="nm_catalog">
                                    <input type="text" class="form-control" name="bukti_transfer" id="bukti_transfer">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>




            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-payment-reseller">SIMPAN</button>
            </div>
        </div>
    </div>
</div>