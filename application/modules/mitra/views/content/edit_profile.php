<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>


<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>

<script src="<?php echo base_url(); ?>assets/js_ajax/mitra.js" type="text/javascript"></script>
<!-- End AJAX JS -->

<style type="text/css">
    label.error { color:red; margin-left: 10px; font-weight:1; }
</style>


<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-9">

    <div class="content-form-page">
        <br/>
        <h3>Edit Profile</h3>
        <div class="row">
            <div class="col-md-10 col-sm-10">
                <form enctype="multipart/form-data" class="form-horizontal form-without-legend" id="form_edit_user">
                    <div class="form-group">
                        <label for="name" class="col-lg-4 control-label">Nama Lengkap <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control required" id="name" name="name" value="<?php echo $profile['name']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hp" class="col-lg-4 control-label">No.Handphone <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control required" id="phone" name="phone" value="<?php echo $profile['phone']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="re_password" class="col-lg-4 control-label">Tanggal Lahir <span class="require">*</span></label>
                        <div class="col-lg-2">
                           <select class="form-control required" id="date" name="date">
                               <option value="">Date</option>
                               <?php
                               for ($x = 1; $x <= 31; $x++) {
                               ?>
                               <option <?php if(substr($profile['birthday'],8,2) == $x){echo "selected";}?>><?php echo $x; ?></option>
                               <?php
                               }
                               ?>
                           </select>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-control required" id="month" name="month">
                                <option value="">Month</option>
                                <option value="01" <?php if(substr($profile['birthday'],5,2) == '01'){echo "selected";}?>>Januari</option>
                                <option value="02" <?php if(substr($profile['birthday'],5,2)== '02'){echo "selected";}?>>Februari</option>
                                <option value="03" <?php if(substr($profile['birthday'],5,2) == '03'){echo "selected";}?>>Maret</option>
                                <option value="04" <?php if(substr($profile['birthday'],5,2) == '04'){echo "selected";}?>>April</option>
                                <option value="05" <?php if(substr($profile['birthday'],5,2) == '05'){echo "selected";}?>>Mei</option>
                                <option value="06" <?php if(substr($profile['birthday'],5,2) == '06'){echo "selected";}?>>Juni</option>
                                <option value=07"  <?php if(substr($profile['birthday'],5,2) == '07'){echo "selected";}?>>Juli</option>
                                <option value="08" <?php if(substr($profile['birthday'],5,2) == '08'){echo "selected";}?>>Agustus</option>
                                <option value="09" <?php if(substr($profile['birthday'],5,2) == '09'){echo "selected";}?>>September</option>
                                <option value="10" <?php if(substr($profile['birthday'],5,2) == '10'){echo "selected";}?>>Oktober</option>
                                <option value="12" <?php if(substr($profile['birthday'],5,2) == '11'){echo "selected";}?>>November</option>
                                <option value="12" <?php if(substr($profile['birthday'],5,2) == '12'){echo "selected";}?>>Desember</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select class="form-control required" id="year" name="year">
                                <option value="">Year</option>
                                <?php
                                for ($x = 1970; $x <= 2010; $x++) {
                                    ?>

                                    <option <?php if(substr($profile['birthday'],0,4) == $x){echo "selected";}?>><?php echo $x; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="re_password" class="col-lg-4 control-label">Jenis Kelamin <span class="require">*</span></label>
                        <div class="col-lg-4">
                            <select class="form-control required" id="gender" name="gender">
                                <option value="">Choose</option>
                                <option <?php if($profile['gender'] == "Laki-laki"){echo "selected";}?>>Laki-laki</option>
                                <option <?php if($profile['gender'] == "Perempuan"){echo "selected";}?>>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hp" class="col-lg-4 control-label">No.Rekening <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control required" id="no_rek" name="no_rek" value="<?php echo $profile['rek']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-lg-4 control-label">Atas Nama Rekening <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control required" id="nm_rek" name="nm_rek" value="<?php echo $profile['an_rek']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label">Foto Profile <br>(Format JPG|Max Size 500 Kb) (Size Ideal 150 x 150 Pixel)</label>
                        <div class="col-lg-8">
                        <img id="tampil" src="<?php echo $profile['picture_url']; ?>" alt="" width="150px" height="150px"/>
                        <input type="file" name="foto" id="foto">
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                            <button type="button" class="btn btn-primary" id="btn_edit_user" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Processing">SAVE</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- END CONTENT -->

    