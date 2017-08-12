<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>


<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>

<script src="<?php echo base_url(); ?>assets/js_ajax/seller.js" type="text/javascript"></script>
<!-- End AJAX JS -->

<style type="text/css">
    label.error { color:red; margin-left: 10px; font-weight:bold; }
</style>
<style>
    #progress-bar {background-color: lightskyblue;height:20px;color: #FFFFFF;width:0%;-webkit-transition: width .3s;-moz-transition: width .3s;transition: width .3s;}
    #progress-div {border:dodgerblue 1px solid;padding: 5px 0px;margin:30px 0px;border-radius:4px;text-align:center;}
    #targetLayer{width:100%;text-align:center;}

</style>


<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-9">

    <div class="content-form-page">
        <br/>
        <h3>Tambah Barang</h3>
        <div class="row">
            <div class="col-md-11 col-sm-10">
                <form method="post" action="<?php echo base_url('seller/act_input_barang');?>" enctype="multipart/form-data" class="form-horizontal form-without-legend" id="form_tambah_barang">
                    <div class="form-group">
                        <label for="name" class="col-lg-3 control-label">Nama Barang <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control required" id="nama_barang" name="nama_barang" placeholder="Berikan nama barang dengan keywords terbaik">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="re_password" class="col-lg-3 control-label">Kategori <span class="require">*</span></label>
                        <div class="col-lg-2">
                            <select class="form-control required" id="category1" name="category1">
                                <option value="">Pilih</option>
                                <?php
                                if($data){
                                    foreach($data as $row){
                                        echo"<option value='".$row['id']."'>".$row['menu']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select class="form-control required" id="category2" name="category2">
                                <option value="">-</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-control required" id="category3" name="category3">
                                <option value="">-</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hp" class="col-lg-3 control-label">Stok <span class="require">*</span></label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control required" id="stok" name="stok">
                        </div>
                        <label for="hp" class="col-lg-1 control-label">Berat <span class="require">*</span></label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control required" id="berat" name="berat" placeholder="Per Gram">
                        </div>
                        <label for="hp" class="col-lg-2 control-label">minimal Pesan<span class="require">*</span></label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control required" id="min_pesan" name="min_pesan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hp" class="col-lg-3 control-label">Deskripsi <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <textarea class="form-control required" id="deskripsi" name="deskripsi" placeholder="Deskripsikan barang kamu selengkap mungkin, namun tidak perlu mengulangi yang sudah ada pada form. "></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hp" class="col-lg-3 control-label">Harga Barang <span class="require">*</span></label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control required" id="harga_barang" name="harga_barang" >
                        </div>
                        <label for="hp" class="col-lg-2 control-label">Harga Coret <span class="require">*</span></label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control required" id="harga_coret" name="harga_coret">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hp" class="col-lg-3 control-label">Komisi Reseller <span class="require">*</span></label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control required" id="komisi_reseller" name="komisi_reseller" >
                        </div>
                        <div class="col-lg-4">
                            <button type="button" style="margin-top: 4px;" data-toggle="modal" data-target="#ModalInfo"> <i class="fa fa-info-circle" style="padding: 4px;color:green;"> Panduan pengisian harga</i></button>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="hp" class="col-lg-3 control-label">Harga Fix</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control required" id="harga_fix"  readonly>
                        </div>
                        <div class="col-lg-4">
                            <button type="button" style="margin-top: 4px;" id="btn_harga_fix"> <i class="fa fa-info-circle" style="padding: 4px;color:green;"> Cek Harga Fix</i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">Foto Profile <br>(Format JPG|Max Size 1 MB) (Size Ideal 150 x 150 Pixel)</label>

                        <div class="col-lg-3">
                            <div id="deletetampil1">
                            <img id="tampil1" src="<?php echo base_url('assets/images/img/default.jpg'); ?>" alt="" width="150px" height="150px"/>
                            </div>
                            <input type="file" name="images1" id="images1">
                            <button type="button" id="btndeletetampil1"><i class="fa fa-trash"></i> </button>
                        </div>

                        <div class="col-lg-3">
                            <div id="deletetampil2">
                            <img id="tampil2" src="<?php echo base_url('assets/images/img/default.jpg'); ?>" alt="" width="150px" height="150px"/>
                            </div>
                                <input type="file" name="images2" id="images2">
                            <button type="button" id="btndeletetampil2"><i class="fa fa-trash"></i> </button>
                        </div>

                        <div class="col-lg-3">
                            <div id="deletetampil3">
                                <img id="tampil3" src="<?php echo base_url('assets/images/img/default.jpg'); ?>" alt="" width="150px" height="150px"/>
                            </div>
                            <input type="file" name="images3" id="images3">
                            <button type="button" id="btndeletetampil3"><i class="fa fa-trash"></i> </button>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"></label>
                        <div class="col-lg-9">
                        <div id="progress-div"><div id="progress-bar"></div></div>
                        <div id="targetLayer"></div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-offset-3 padding-left-0 padding-top-20">
                            <button type="submit" class="btn btn-primary" id="btn_tambah_barang" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Processing">SIMPAN</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- END CONTENT -->

<script>
    $("#btn_harga_fix").click(function(){
        var paymentPresentase = "<?php echo $payment_presentase;?>";
        var komisi = $("#komisi_reseller").val();
        var hargaBarang = $("#harga_barang").val();
        var countPresentase = parseInt(hargaBarang) * parseInt(paymentPresentase) / 100;
        var hargaFix = parseInt(hargaBarang) + parseInt(komisi) + parseInt(countPresentase);
        if(!komisi){
            alert('komisi reseller harus diisi!');
        }else if(!hargaBarang){
            alert('harga Barang harus diisi');
        }else{
            $("#harga_fix").val(hargaFix);
        }
    });

</script>


<style>

    .modal-dialog{
        width: 60%;
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
<div class="modal fade" id="ModalInfo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Panduan Pengisian Harga
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <b>HARGA BARANG</b> </br>
                        Harga dari barang yang akan anda jual
                        </br></br><b>HARGA CORET</b> </br>
                        Harga barang di pasaran yang serupa dengan anda namun memiliki nominal yang lebih tinggi, harga coret bersifat opsional namun ini sangat di perlukan untuk menarik minat pembeli.
                        </br></br><b>KOMISI RESELLER</b></br>
                        Komisi yang harus anda berikan untuk para reseller kami yang telah menjual kan barang anda ( Semakin besar komisi yang anda berikan semakin tertarik para reseller untuk menjualkan barang anda).
                        </br></br>
                        <b>NOTE :</b> </br>
                        Dalam menentukan HARGA BARANG harus anda pertimbangkan juga dengan KOMISI RESELLER, karena harga fix yang akan kami tampilkan adalah HARGA BARANG + KOMISI RESELLER + PLATFORM PAYMENT (Biaya yang kami kenakan untuk maintenance dan pengembangan situs www.mitrareseller.com) yaitu <?php echo $payment_presentase;?>% dari HARGA BARANG.
                    </div>
                </div>




            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>