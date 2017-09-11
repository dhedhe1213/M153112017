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
                            <th>Nama Seller</th>
                            <th>Nomor Rekening (a/n)</th>
                            <th>Nama Bank</th>
                            <th>Total Komisi Terakhir</th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data){
                            $no = 1;
                            $TotalKomisiKeseluruhan = array();
                            foreach($data as $row){

                                $getDataReseller = $this->db->get_where('m_user',array('id'=>$row['id_seller']))->row_array();

                                $totalKomisi = array();
                                $getTransaksiItem = $this->db->where('id_seller',$row['id_seller'])->where('no_resi <>','0')->where('status','2')->where_in('id_transaksi', $all_id_transaksi)->get('t_transaksi_item')->result_array();
                                //$getTransaksiItem = $this->db->get_where('t_transaksi_item',array('id_seller'=>$row['id_seller']))->result_array();

                                if($getTransaksiItem) {
                                            foreach($getTransaksiItem as $data){
                                                $getHargaItem = $this->db->get_where('m_item_harga',array('id_item'=>$data['id_item'],'id_transaksi'=>$data['id_transaksi']))->result_array();
                                                if($getHargaItem){
                                                    foreach($getHargaItem as $data3){
                                                        $totalKomisi[] = $data3['harga_seller'] * $data['qty'];
                                                    }
                                                }
                                    }
                                }

                                $getOngkir = $this->db->group_by('id_transaksi')->where('id_seller',$row['id_seller'])->where('no_resi <>','0')->where('status','2')->where_in('id_transaksi', $all_id_transaksi)->get('t_transaksi_item')->result_array();
                                $totalOngkir = array();
                                if($getOngkir){
                                    foreach($getOngkir as $dataOngkir){
                                        $totalOngkir[] = $dataOngkir['ongkir'];
                                    }
                                }

                                $totalKomisiCount = array_sum($totalKomisi) + array_sum($totalOngkir);
                        ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $getDataReseller['name'];?></td>
                                    <td><?php echo $getDataReseller['rek']." (".$getDataReseller['an_rek'].")";?></td>
                                    <td><?php echo $getDataReseller['nm_bank'];?></td>
                                    <td><?php
                                        $TotalKomisiKeseluruhan[] = $totalKomisiCount;
                                        echo number_format($totalKomisiCount,0);?></td>
                                    <td><a href="#" onclick="actPaymentSeller('<?php echo $row['id_seller'];?>')">Konfirmasi</a> </td>
                                </tr>
                        <?php
                                $no++;
                            }
                            reset($totalKomisi);
                            reset($totalOngkir);
                        }
                        ?>
                        </tbody>
                    </table>

                </div><!-- table responsive -->

                    <h4>Total Payment Seller Rp. <?php if(!empty($TotalKomisiKeseluruhan)){echo number_format(array_sum($TotalKomisiKeseluruhan),0);}else{ echo "0";}?></h4>

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
                                    <input type="hidden" name="id_seller" id="id_seller">
                                    <input type="text" class="form-control" name="bukti_transfer" id="bukti_transfer">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>




            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-payment-seller">SIMPAN</button>
            </div>
        </div>
    </div>
</div>