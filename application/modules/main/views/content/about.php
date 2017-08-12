<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- BEGIN CONTENT -->
<div class="col-md-12 col-sm-12">

<div class="content-page">
<div class="row">
<div class="col-md-3 col-sm-3">
    <ul class="tabbable faq-tabbable">
        <li class="active"><a href="#tab_1" data-toggle="tab">Tentang Kami</a></li>
        <li><a href="#tab_2" data-toggle="tab">Membership</a></li>
        <li><a href="#tab_3" data-toggle="tab">Syarat & Ketentuan</a></li>
        <li><a href="#tab_4" data-toggle="tab">Kebijakan Privasi</a></li>

    </ul>
</div>
    <br>
<div class="col-md-9 col-sm-9">
<div class="tab-content" style="padding:0; background: #fff;">
<!-- START TAB 1 -->
<div class="tab-pane active" id="tab_1">
    <div class="panel-group" id="accordion1">
        <?php
        if($data_about){
            $a = 1;
            foreach($data_about as $about){
                ?>

        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#accordion1_<?php echo $a; ?>" data-parent="#accordion1" data-toggle="collapse" class="accordion-toggle">
                        <?php clean_and_print($about['title']);?>
                    </a>
                </h4>
            </div>
            <div class="panel-collapse collapse <?php if($a == 1){ echo 'in';}?>" id="accordion1_<?php echo $a; ?>">
                <div class="panel-body">
                    <?php echo $about['description'];?>
                </div>
            </div>
        </div>

            <?php
                $a++;
            }
        }
        ?>

    </div>
</div>
<!-- END TAB 1 -->
<!-- START TAB 2 -->
<div class="tab-pane" id="tab_2">
    <div class="panel-group" id="accordion2">

        <?php
        if($data_member){
            $b = 1;
            foreach($data_member as $member){
                ?>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion2_<?php echo $b; ?>" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">
                                <?php clean_and_print($member['title']);?>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse <?php if($b == 1){ echo 'in';}?>" id="accordion2_<?php echo $b; ?>">
                        <div class="panel-body">
                            <?php echo $member['description'];?>
                        </div>
                    </div>
                </div>

                <?php
                $b++;
            }
        }
        ?>


    </div>
</div>
<!-- END TAB 3 -->
<!-- START TAB 3 -->
<div class="tab-pane" id="tab_3">
    <div class="panel-group" id="accordion3">

        <?php
        if($data_syarat){
            $c = 1;
            foreach($data_syarat as $syarat){
                ?>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion3_<?php echo $c; ?>" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle">
                                <?php clean_and_print($syarat['title']);?>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse <?php if($c == 1){ echo 'in';}?>" id="accordion3_<?php echo $c; ?>">
                        <div class="panel-body">
                            <?php echo $syarat['description'];?>
                        </div>
                    </div>
                </div>

                <?php
                $c++;
            }
        }
        ?>

    </div>
</div>
<!-- END TAB 3 -->
<!-- START TAB 3 -->
<div class="tab-pane" id="tab_4">
    <div class="panel-group" id="accordion4">

        <?php
        if($data_kebijakan){
            $d = 1;
            foreach($data_kebijakan as $kebijakan){
                ?>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion4_<?php echo $d; ?>" data-parent="#accordion4" data-toggle="collapse" class="accordion-toggle">
                                <?php clean_and_print($kebijakan['title']);?>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse <?php if($d == 1){ echo 'in';}?>" id="accordion4_<?php echo $d; ?>">
                        <div class="panel-body">
                            <?php echo $kebijakan['description'];?>
                        </div>
                    </div>
                </div>

                <?php
                $d++;
            }
        }
        ?>


    </div>
</div>
<!-- END TAB 3 -->
</div>
</div>
</div>
</div>
</div>
<!-- END CONTENT -->
         
    