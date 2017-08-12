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
                                <th>Resi</th>
                                <th>Tanggal Transaksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($data){
                                    $no = 1;
                                    foreach($data as $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $no;?></td>
                                            <td><?php echo "<a style='color:#ff1493;' href='".base_url('seller/cetak/'.$row['no_invoice'])."' target=_blank>".$row['no_invoice']."</a>";?></td>
                                            <td><?php
                                                if($row['no_resi'] == '0'){
                                                    echo "Transaksi Ditolak";
                                                }else{
                                                    echo $row['no_resi'];
                                                }
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


                    </div><!-- table responsive -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
</div>

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
    <div class="modal fade" id="modalInputResi" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Masukan Nomor Resi Pengiriman
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-11 col-sm-11">
                            <form class="form-horizontal form-without-legend" role="form" id="form-input-resi">

                                <div class="form-group">
                                    <label class="col-lg-4" style="margin-top: 7px">Nomor Resi</label>
                                    <div class="col-lg-8">
                                        <input type="hidden" name="id_transaksi" id="id_transaksi">
                                        <input type="text" name="no_resi" id="no_resi" class="form-control" size="5">
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btn-input-resi">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>