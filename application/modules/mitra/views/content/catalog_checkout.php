<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- AJAX JS -->

<script xmlns="http://www.w3.org/1999/html"> var base_url = '<?php echo base_url();?>'; </script>
<script src="<?php echo base_url(); ?>assets/js_ajax/mitra_catalog.js" type="text/javascript"></script>
<!-- End AJAX JS -->
<style>
    fieldset.checkout {
        border: 1px dashed #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
        box-shadow:  0px 0px 0px 0px #000;
    }

</style>
<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-12">
    <h3>Isi Data Pembelian</h3>
    <div class="content-form-page">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <form class="form-horizontal form-without-legend" role="form" id="form_alamat">

                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Alamat Pengiriman</label>
                        <div class="col-lg-9">
                            <select class="form-control required" id="select_alamat" name="select_alamat">
                                <script>
                                    loadAlamat();
                                </script>
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <button type="button" class="btn btn-gray" id="tambah_alamat"><i class="fa fa-plus"></i> </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label"></label>
                        <div class="col-lg-9">
                            <fieldset class="checkout">
                                <div style="margin-top: 10px" class="alamat_checkout">

                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Barang Belanja</label>
                        <div class="col-lg-10">

                                    <?php

                                    if($data_item){
                                        $id_tmp = 1;
                                        foreach($data_item as $row){
                                            $getDataKurir = $this->db->get_where('r_seller_kurir',array('id_user'=>$row['id_user']))->result_array();
                                            $getAlamatSeller = $this->db->get_where('r_seller_alamat',array('id_user'=>$row['id_user']))->row_array();
                                            $getNamaKabupaten = $this->db->get_where('r_kabupaten',array('id'=>$getAlamatSeller['kabupaten']))->row_array();
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">Kode Gudang : GDG-1101<?php echo $row['id_user']." ( ".$getNamaKabupaten['nama']." )";?></div>
                                                <div class="panel-body">
                                                    <div class="table table-responsive">
                                                    <table class="table-condensed" width="100%">
                                                        <tr>
                                                        <th>Produk</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Berat (Kg)</th>
                                                        <th>Subtotal</th>
                                                        </tr>


                                    <?php
                                            $harga = array();
                                            $getItemByIdUser = $this->catalog->getwherein2('t_item',$id_item,$row['id_user'],1);
                                            if($getItemByIdUser) {
                                                foreach ($getItemByIdUser as $data) {
                                                    $getItemImages = $this->db->get_where('t_item_images',array('id_item'=>$data['id']))->row_array();
                                                    $getHarga = $this->db->get_where('t_item_harga',array('id_item'=>$data['id']))->row_array();
                                                   ?>

                                                        <tr>
                                                            <td width="50%"><a href="<?php echo base_url('mitra/item_detail/'.$row['id']);?>" style="color: #3e4d5c;"><img src="<?php if($getItemImages){ echo base_url('assets/images/products/'.$getItemImages['img']);} ?>" style="width: 40px;float:left;margin: 3px;"><?php echo $data['nama'];?></p></a></td>
                                                            <td width="10%"><?php echo number_format($getHarga['harga_fix'],0,'','.');?></td>
                                                            <td width="10%"><?php echo $qty[$data['id']];?></td>
                                                            <td width="10%"><?php $kg = $data['berat']/1000; echo $kg;?></td>
                                                            <td width="10%"><?php echo number_format($subtotal[$data['id']],0,'','.');?></td>

                                                        </tr>
                                                    <?php
                                                    $harga[] = $subtotal[$data['id']];
                                                }
                                            }
                                    ?>
                                                    </table>
                                                    </div>
                                                    <hr>
                                                    <label for="" class="col-lg-3 control-label">Jasa Pengiriman</label>



                                                    <form name="form_kurir" id="form_kurir_<?php echo $row['id_user'];?>">
                                                    <input type="hidden" id="id_tmp" name="id_tmp" value="<?php echo $row['id_user'];?>">
                                                    <div class="col-lg-7">
                                                        <select class="form-control required" id="cek_tipe_<?php echo $row['id_user'];?>" name="cek_tipe_<?php echo $row['id_user'];?>">
                                                            <option>Choose</option>
                                                            <?php
                                                            if($getDataKurir){
                                                                foreach($getDataKurir as $row){
                                                            echo"<option>".$row['kurir']."</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    </br></br></br>
                                                    <label for="" class="col-lg-3 control-label"></label>
                                                    <div class="col-lg-7">
                                                        <select class="form-control required" id="select_kurir_<?php echo $row['id_user'];?>" name="select_kurir_<?php echo $row['id_user'];?>">
                                                            <option>Choose</option>
                                                        </select>
                                                    </div>
                                                    </form>

                                                    </br></br><hr>

                                                        <div class="table table-responsive">
                                                            <div id="resume_harga_<?php echo $row['id_user'];?>">
                                                                <table align="right">
                                                                <tr>
                                                                    <td><p>Harga Barang</p></td><td><font style="float: right"><p style="margin-left: 15px;"> Rp.<?php echo number_format(array_sum($harga),0);?> </p></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p>Biaya Kirim</p></td><td><font style="float: right"><p>-</p></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p>Sub Total</p></td><td><font style="float: right"><p><b style="font-size: 15px;"> Rp.<?php echo number_format(array_sum($harga),0);?> </b></p></font></td>
                                                                </tr>

                                                                </table>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#cek_tipe_<?php echo $row['id_user'];?>').change(function () {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: base_url + 'mitra/selectKurir',
                                                        data: $('#form_kurir_<?php echo $row['id_user'];?>').serialize(),
                                                        beforeSend: function () {
                                                            $('#select_kurir_<?php echo $row['id_user'];?>').html('<option>Mohon Tunggu...</option>');
                                                        },
                                                        success: function (html) {
                                                            $('#select_kurir_<?php echo $row['id_user'];?>').html(html);
                                                        }
                                                    });
                                                });

                                                $('#select_kurir_<?php echo $row['id_user'];?>').change(function () {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: base_url + 'mitra/selectLayanan',
                                                        data: $('#form_kurir_<?php echo $row['id_user'];?>').serialize(),
                                                        beforeSend: function () {
                                                            $('#resume_harga_<?php echo $row['id_user'];?>').html('Mohon Tunggu...');
                                                        },
                                                        success: function (html) {
                                                            $('#resume_harga_<?php echo $row['id_user'];?>').html(html);
                                                        }
                                                    });
                                                });

                                            </script>
                                       <?php
                                            $id_tmp++;
                                        }

                                    }
                                    ?>
                            <div style="float:right;"> <a href="<?php echo base_url('mitra/catalog_finish');?>" class="btn btn-primary" type="submit">Selesai dan Bayar <i class="fa fa-check"></i></a></div>

                        </div>
                    </div>

            </div>

        </div>


    </div>
</div>
<!-- END CONTENT -->
<style>
    .modal-dialog{
        width: 40%;
        padding-top: 0px;
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
<div class="modal fade" id="ModalJumlah" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Masukan Jumlah Produk
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-sm-11">
                        <form class="form-horizontal form-without-legend" role="form" id="form-edit-jumlah">

                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Nama Produk</label>
                                <div class="col-lg-8">
                                    <input type="hidden" name="id_item" id="id_item">
                                    <input type="text" class="form-control" name="nama" id="nama" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Jumlah</label>
                                <div class="col-lg-8">
                                    <input type="text" name="jumlah" id="jumlah" class="form-control" size="5">
                                </div>

                            </div>
                        </form>
                    </div>

                </div>




            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-ubah-jumlah">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL BOOTSRAP -->
<div class="modal fade" id="ModalTambahAlamat" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Masukan Data Penerima Barang
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-11 col-sm-11">
                        <form class="form-horizontal form-without-legend" role="form" id="form-tambah-alamat">

                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Nama</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="nama" id="nama">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">No.Handphone</label>
                                <div class="col-lg-8">
                                    <input type="text" name="phone" id="phone" class="form-control" size="5">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Provinsi</label>
                                <div class="col-lg-8">
                                    <select class="form-control required" id="provinsi" name="provinsi">
                                        <option value="">Pilih</option>
                                        <?php
                                        if($data_provinsi){
                                            foreach($data_provinsi as $row){
                                                ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Kabupaten/Kota</label>
                                <div class="col-lg-8">
                                    <select class="form-control required" id="kabupaten" name="kabupaten">
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Kecamatan</label>
                                <div class="col-lg-8">
                                    <select class="form-control required" id="kecamatan" name="kecamatan">
                                        <option value="">Pilih</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4" style="margin-top: 7px">Alamat</label>
                                <div class="col-lg-8">
                                    <textarea name="alamat" id="alamat" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group" id="kd_pos_default">
                                <label class="col-lg-4" style="margin-top: 7px">Kode Pos</label>
                                <div class="col-lg-8">
                                    <select class="form-control required" name="kd_pos_def" id="kd_pos">
                                        <option>Pilih</option>
                                    </select>
                                    <a href="#" class="tambah_kode" style="margin-top: 10px;float: right;">Tambah kode pos</a>
                                </div>
                            </div>
                            <div class="form-group" id="kd_pos_tambah">
                                <label class="col-lg-4" style="margin-top: 7px">Kode Pos</label>
                                <div class="col-lg-8">
                                    <input type="text" name="kd_pos_tam" id="kd_tambah" class="form-control" size="5">
                                </div>
                            </div>

                        </form>
                    </div>

                </div>




            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="tutup">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-tambah-alamat">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

