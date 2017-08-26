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
                        <table class="table table-bordered table-striped" id="t_konfirmasi" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>No Transaksi</th>
                                <th>No Invoice</th>
                                <th>Kode Unik</th>
                                <th>Total Bayar</th>
                                <th>Batas Waktu</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($data){
                                $no = 1;
                                foreach($data as $row){
                                    $getInvoice = $this->db->group_by('no_invoice')->get_where('t_transaksi_item',array('id_transaksi'=>$row['id']))->result_array();
                                    $getStatusKonfirmasi = $this->db->get_where('t_transaksi_konfirmasi',array('id_transaksi'=>$row['id']))->row_array();
                            ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $row['id'];?></td>
                                        <td>
                                            <?php
                                            if($getInvoice){
                                                foreach($getInvoice as $data){
                                                    echo "<a style='color:#ff1493;' href='".base_url('mitra/cetak/'.$data['no_invoice'])."' target=_blank>".$data['no_invoice']."</a></br>";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo number_format($row['kode_unik'],0);?></td>
                                        <td><?php echo number_format($row['total_pembayaran'],0);?></td>
                                        <td><?php echo $row['batas_waktu'];?></td>
                                        <td>
                                            <?php if($row['status'] == 1){
                                                echo"<a style='color: #003eff;cursor:pointer;' onclick='konfirmasi(".$row['id'].")'>Konfirmasi</a>";
                                            }else if($getStatusKonfirmasi['status'] == 1){
                                                echo"Sudah di verifikasi";
                                            }else{
                                                echo"Menunggu verifikasi oleh admin";
                                            }?>
                                        </td>
                                    </tr>
                            <?php
                                    $no++;
                                }
                            }
                            ?>
                            </tbody>
                        </table>

                    </div><!-- table responsive -->
                    </br>
                    *Setelah pembayaran di konfirmasi, silahkan cek barang anda pada menu STATUS PENGIRIMAN

                </div><!-- /.box-body -->
            </div><!-- /.box -->



        </div>

</div>
    <script>
        function konfirmasi(id_transaksi){
            var id_transaksi = id_transaksi;
            $("#ModalKonfirmasi").modal('show');
            $("#id_transaksi").val(id_transaksi);
        }
    </script>

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
    <div class="modal fade" id="ModalKonfirmasi" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Konfirmasi Pembayaran
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-11 col-sm-11">
                            <form class="form-horizontal form-without-legend" role="form" id="form-konfirmasi">
                                <div class="form-group">
                                    <label class="col-lg-4" style="margin-top: 7px">Nama Bank Pengirim</label>
                                    <div class="col-lg-8">
                                        <input type="hidden" name="id_transaksi" id="id_transaksi">
                                        <select class="form-control" name="nama_bank_pengirim" id="nama_bank_pengirim">
                                            <option value="">Pilih</option>
                                            <option>Bank BRI (Bank Rakyat Indonesia)</option>
                                            <option>Bank BNI (Bank Negara Indonesia)</option>
                                            <option>Bank BCA (Bank Central Asia)</option>
                                            <option>Bank Mandiri</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4" style="margin-top: 7px">Nama Rekening Pengirim</label>
                                    <div class="col-lg-8">
                                        <input type="hidden" name="id_item" id="id_item">
                                        <input type="text" class="form-control" name="nama_rekening_pengirim" id="nama_rekening_pengirim" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4" style="margin-top: 7px">Nomor Rekening Pengirim</label>
                                    <div class="col-lg-8">
                                        <input type="hidden" name="id_item" id="id_item">
                                        <input type="text" class="form-control" name="nomor_rekening_pengirim" id="nomor_rekening_pengirim">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4" style="margin-top: 7px">Jumlah Transfer</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="jml_transfer" id="jml_transfer">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="col-lg-4" style="margin-top: 7px">Rekening Tujuan</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="nama_bank_tujuan" id="nama_bank_tujuan">
                                            <option value="">Pilih</option>
                                            <option>Bank BRI a/n Dede Irawan</option>
                                            <option>Bank BCA a/n Dede Irawan</option>
                                            <option>Bank BNI a/n Sendy Prasetyo</option>
                                            <option>Bank Mandiri a/n Sendy Prasetyo</option>
                                        </select>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>




                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btn-konfirmasi">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>