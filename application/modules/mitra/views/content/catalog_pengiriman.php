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
                        <table class="table table-bordered table-striped" id="t_pengiriman" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>ID Transaksi</th>
                                <th>No Invoice</th>
                                <th>Nama Kurir</th>
                                <th>Tipe layanan</th>
                                <th>No resi</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($data){
                                $no = 1;
                                foreach($data as $row){
                                    $getInvoice = $this->db->group_by('no_invoice')->get_where('t_transaksi_item',array('id_transaksi'=>$row['id']))->result_array();
                                    foreach($getInvoice as $data) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no;?></td>
                                            <td><?php echo $row['id'];?></td>
                                            <td><?php echo "<a style='color:#ff1493;' href='".base_url('mitra/cetak/'.$data['no_invoice'])."' target=_blank>".$data['no_invoice']."</a></br>";?></td>
                                            <td><?php echo $data['tipe_kurir'];?></td>
                                            <td><?php echo $data['tipe_layanan'];?></td>
                                            <td><?php if($data['no_resi']== '0'){echo "Pemesanan ditolak";}elseif($data['no_resi']== ''){echo "Sedang di proses";}else{echo $data['no_resi'];}?></td>
                                            <td>
                                                <?php
                                                if($data['status'] == '2'){
                                                    echo "Sudah di konfirmasi";
                                                }else if($data['no_resi'] == ''){
                                                    echo "-";
                                                }else{
                                                    ?>

                                                    <a style="color: #003eff;cursor:pointer;" onclick="konfirmasi('<?php echo $data['no_invoice'];?>')">Konfirmasi</a>
                                                <?php
                                                    }
                                                ?>

                                            </td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>

                    </div><!-- table responsive -->
                </div><!-- /.box-body -->
                <br>
               *Silahkan cek menu DAFTAR TRANSAKSI setelah anda konfirmasi pengiriman barang
            </div><!-- /.box -->



        </div>

</div>
    <script>
        function konfirmasi(no_invoice){
            var no_invoice = no_invoice;
            $("#ModalKonfirmasi").modal('show');
            $("#id").val(no_invoice);
            $("#no_invoice").html(no_invoice);
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
                    Konfirmasi Penerimaan Barang
                </div>

                <div class="modal-body">
                        <center>
                            Apakah anda yakin sudah menerima barang dengan no invoice: <h2></b><div style="margin-top: 5%;" id="no_invoice"></div></h2>
                        </center>

                        <form class="form-horizontal form-without-legend" role="form" id="form-konfirmasi">
                            <div class="form-group">
                                <div class="col-lg-8">
                                    <input type="hidden" name="id" id="id">
                                </div>
                            </div>
                        </form>
                    <hr/>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
                    <button type="button" class="btn btn-primary" id="btn-terima-barang">KONFIRMASI</button>
                </div>
            </div>
        </div>
    </div>