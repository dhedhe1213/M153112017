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
            <div style="margin: 2%;">
            <a  href="<?php echo base_url('seller/tambahBarang');?>" class="btn btn-success"><i class="fa fa-plus"></i> Tambah </a>
            </div>
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive"> <!-- table responsive -->
<!--                        <input type="hidden" value="--><?php //echo $category; ?><!--" class="category">-->
                        <table class="table table-bordered table-striped" id="barangku" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Komisi Reseller</th>
                                <th>Platform Payment</th>
                                <th>Stok</th>
                                <th>Min Pesan</th>
                                <th>Terjual</th>
                                <th><i class="fa fa-comment" </th>
                                <th width="7%"></th>

                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($data){
                                    $no = 1;
                                    foreach($data as $row){
                                        $getHarga = $this->db->get_where('t_item_harga',array('id_item'=>$row['id']))->row_array();
                                        $getReview = $this->db->get_where('t_item_review',array('id_item'=>$row['id']))->num_rows();
                                        ?>
                                        <tr>
                                            <td><?php echo $no;?></td>
                                            <td><a href="<?php echo base_url('seller/item_detail/'.$row['id']);?>" style="color: #003eff;"><?php echo $row['nama'];?></a></td>
                                            <td><?php echo number_format($getHarga['harga_seller'],0);?></td>
                                            <td><?php echo number_format($getHarga['reseller_payment'],0);?></td>
                                            <td><?php echo number_format($getHarga['platform_payment'],0);?></td>
                                            <td><?php echo $row['stok'];?></td>
                                            <td><?php echo $row['min_pesan'];?></td>
                                            <td><?php echo $row['terjual'];?></td>
                                            <td><?php echo $getReview;?></td>
                                            <td><a href="<?php echo base_url('seller/ubahBarang/'.$row['id']);?>" style="color: #333;"><div class="fa fa-edit"></div></a> | <a class="fa fa-trash-o" style="color:red;cursor: pointer;" onclick="delete_item('<?php echo $row['id'];?>')"></a> </td>
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
    <div class="modal fade" id="modalInputKurir" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Warning
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-11 col-sm-11">
                            <p>Barang tidak dapat hapus karena sedang di pesan oleh reseller.</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>