<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>


<!-- AJAX JS -->

<script> var base_url = '<?php echo base_url();?>'; </script>

<script src="<?php echo base_url(); ?>assets/js_ajax/seller.js" type="text/javascript"></script>
<!-- End AJAX JS -->

<style type="text/css">
    label.error { color:red; margin-left: 10px; font-weight:1; }
</style>


<!-- BEGIN CONTENT -->
<div class="col-md-9 col-sm-9">

    <div class="content-form-page">
        <br/>
        <h3>Edit Password</h3>
        <div class="row">
            <div class="col-md-10 col-sm-10">
                <form class="form-horizontal form-without-legend" role="form" id="form_edit_pass">

                    <div class="form-group">
                        <label for="password" class="col-lg-4 control-label">New Password <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control required" id="password" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="re_password" class="col-lg-4 control-label">Ulangi New Password <span class="require">*</span></label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control required" id="re_password" name="re_password">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                            <button type="button" class="btn btn-primary" id="btn_edit_pass" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Processing">SAVE</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- END CONTENT -->

    