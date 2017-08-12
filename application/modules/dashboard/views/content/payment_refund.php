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
                    <table class="table table-bordered table-striped" id="conf_pembayaran">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Reseller</th>
                            <th>Nomor Rekening (a/n)</th>
                            <th>Nama Bank</th>
                            <th>Biaya Refund</th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data){
                            $no = 1;
                            foreach($data as $row){
                                $getIdReseller = $this->db->get_where('t_catalog',array('nm_catalog'=>$row['nm_catalog']))->row_array();
                                $getDataReseller = $this->db->get_where('m_user',array('id'=>$getIdReseller['id_user']))->row_array();

                                $totalKomisi = array();
                                $seller = array();
                                $ongkir = array();
                                $getTransaksi = $this->db->get_where('t_transaksi_failed',array('nm_catalog'=>$row['nm_catalog']))->result_array();
                                if($getTransaksi) {
                                    foreach($getTransaksi as $data){
                                        $getTransaksiItem = $this->db->get_where('t_transaksi_item_failed', array('id_transaksi' => $data['id']))->result_array();

                                        if($getTransaksiItem){
                                            foreach($getTransaksiItem as $data2){
                                                $getOngkir = $this->db->get_where('t_transaksi_item_failed', array('no_invoice' => $data2['no_invoice'],'no_resi'=> 0))->row_array();
                                                $getDataItem = $this->db->get_where('m_item_harga',array('id_item'=>$data2['id_item'],'id_transaksi'=> $data['id']))->result_array();
                                                if($getDataItem){
                                                    foreach($getDataItem as $data3){
                                                        $totalKomisi[] = $data3['harga_fix'] * $data2['qty'];
                                                    }
                                                }

                                                if(!in_array($data2['id_seller'],$seller)){
                                                    $ongkir[] = $getOngkir['ongkir'];
                                                    $seller[] = $data2['id_seller'];
                                                }


                                            }

                                        }

                                    }
                                }
                        ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $getDataReseller['name'];?></td>
                                    <td><?php echo $getDataReseller['rek']." (".$getDataReseller['an_rek'].")";?></td>
                                    <td><?php echo $getDataReseller['nm_bank'];?></td>
                                    <td><?php echo number_format(array_sum($totalKomisi) + array_sum($ongkir),0);?></td>
                                    <td><a href="#" onclick="actPayment('<?php echo $row['nm_catalog'];?>')">Konfirmasi</a> </td>
                                </tr>
                        <?php
                                $no++;
                            }
                            reset($totalKomisi);
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
                <button type="button" class="btn btn-primary" id="btn-payment-refund">SIMPAN</button>
            </div>
        </div>
    </div>
</div>