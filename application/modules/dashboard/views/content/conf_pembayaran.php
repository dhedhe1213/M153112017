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
                            <th>ID Transaksi</th>
                            <th>Total Tagihan</th>
                            <th>Nama Bank Pengirim</th>
                            <th>Nama Rekening Pengirim</th>
                            <th>Nomor Rekening Pengirim</th>
                            <th>Jumlah Transfer</th>
                            <th>Nama Bank Penerima</th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data){
                            $no = 1;
                            $TotalMasuk = array();
                            foreach($data as $row){
                                $cekDataTransaksi = $this->db->get_where('t_transaksi',array('id'=>$row['id_transaksi']))->num_rows();
                                $getDataTransaksi = $this->db->get_where('t_transaksi',array('id'=>$row['id_transaksi']))->row_array();
                        ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php
                                        if($cekDataTransaksi > 0){
                                            if($getDataTransaksi['status'] != '4'){
                                                echo "<font color='#ff8c00'>".$row['id_transaksi']."</font>";
                                            }else{
                                                echo $row['id_transaksi'];
                                            }
                                        }else{
                                            echo $row['id_transaksi'];
                                        }

                                        ?></td>
                                    <td><?php echo number_format($getDataTransaksi['total_pembayaran'],0);?></td>
                                    <td><?php echo $row['nm_bank_pengirim'];?></td>
                                    <td><?php echo $row['nm_rek_pengirim'];?></td>
                                    <td><?php echo $row['no_rek_pengirim'];?></td>
                                    <td><?php
                                        if($getDataTransaksi['total_pembayaran'] != $row['jml_transfer']){
                                            echo "<font color='red'>".number_format($row['jml_transfer'],0)."</font>";
                                        }else{
                                            echo number_format($row['jml_transfer'],0);
                                        }

                                        ?></td>
                                    <td><?php echo $row['nm_bank_penerima'];?></td>
                                    <td>
                                        <?php
                                        if($row['status'] == '1'){
                                            echo"Sudah di konfirmasi";
                                        }else{
                                            ?>
                                            <a href="#" onclick="sweet_confirm('<?php echo $row['id_transaksi'];?>')">Konfirmasi</a>
                                        <?php
                                        }
                                        if($cekDataTransaksi > 0){
                                            if($getDataTransaksi['status'] == '4'){
                                                $TotalMasuk[] = $getDataTransaksi['total_pembayaran'];
                                            }
                                        }else{
                                            $cekDataTransaksiFailed = $this->db->get_where('t_transaksi_failed',array('id'=>$row['id_transaksi']))->num_rows();
                                            if($cekDataTransaksiFailed > 0) {
                                                $TotalMasuk[] = $getDataTransaksi['total_pembayaran'];
                                            }
                                        }

                                        ?>
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

                    <h4>Total Pemasukan Rp. <?php if(!empty($TotalMasuk)){echo number_format(array_sum($TotalMasuk),0);}else{ echo "0";}?></h4>
                    *Total pemasukan di ambil dari semua transaksi yang telah selesai ID berwarna hitam bukan orange </br>
                    *jumlah transfer yang berwarna merah hanya sebagai pembeda dengan total tagihan, acuan utama tetap yang berada di rekening<br>
                    *Konfirmasi pembayaran akan hilang(yang ID berwarna hitam) otomatis pada saat admin melakukan payment
                </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

