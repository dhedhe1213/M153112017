
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Invoice</title>
</head>

<body style="font-family: open sans, tahoma, sans-serif; margin: 0; -webkit-print-color-adjust: exact">
<table width="790" cellspacing="0" cellpadding="0" class="container" style="width: 790px; padding: 20px;">
    <tr>
        <td>
            <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; padding-bottom: 20px;">
                <tbody>
                <tr style="margin-top: 8px; margin-bottom: 8px;">
                    <td>
                        <img src="<?php echo base_url('assets/images/img/logo-corp-red.png')?>"  width="40%" alt="Tokopedia">
                    </td>
                    <td style="text-align: right; padding-right: 15px;">
                        <a style="color: #42B549; font-size: 14px; text-decoration: none;" href="javascript:window.print()">
                            <img src="<?php echo base_url('assets/images/img/print.png')?>" width="20%" alt="Print" style="vertical-align: middle;">
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; padding-bottom: 20px;">
                <tbody>
                <tr style="font-size: 20px; font-weight: 600;">
                    <td style="padding-bottom: 5px;">
                        <span>Invoice</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-right: 10px;">
                        <table style="width: 100%; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0">
                            <tr style="font-size: 13px;">
                                <td>
                                    <table style="width: 100%; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td style="width: 80px; font-weight: 600; padding: 3px 20px 3px 0;" width="80">Gudang</td>
                                            <td style="padding: 3px 0;">
                                                <?php
                                                $getkota = $this->db->get_where('r_seller_alamat',array('id_user'=>$data_transaksi_item['id_seller']))->row_array();
                                                $getNmKota = $this->db->get_where('r_kabupaten',array('id'=>$getkota['kabupaten']))->row_array();
                                                echo $data_transaksi_item['id_seller']." ( ".$getNmKota['nama']." )";
                                                ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr style="font-size: 13px;">
                                <td>
                                    <table style="width: 100%; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td style="width: 80px; font-weight: 600; padding: 3px 20px 3px 0;" width="80">Nomor</td>
                                            <td style="padding: 3px 0;"><?php echo $data_transaksi_item['no_invoice']; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr style="font-size: 13px;">
                                <td>
                                    <table style="width: 100%; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td style="width: 80px; font-weight: 600; padding: 3px 20px 3px 0;" width="80">Tanggal</td>
                                            <td style="padding: 3px 0;"><?php echo $data_transaksi_item['created']; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <table style="width: 100%; text-align: center; border-top: 1px solid #F1F1F2; border-bottom: 1px solid #F1F1F2; padding: 15px 0;" width="100%" cellspacing="0" cellpadding="0">
                <thead style="font-size: 14px;">
                <tr><th style="font-weight: 600; text-align: left; padding: 0 5px 15px 15px;">Nama Produk</th>
                    <th style="width: 120px; font-weight: 600; padding: 0 5px 15px;" width="120">Jumlah Barang</th>
                    <th style="width: 65px; font-weight: 600; padding: 0 5px 15px;" width="65">Berat</th>
                    <th style="width: 115px; font-weight: 600; padding: 0 5px 15px;" width="115">Harga Barang</th>
                    <th style="width: 115px; font-weight: 600; text-align: right; padding: 0 30px 15px 5px;" width="115">Subtotal</th>
                </tr></thead>
                <tbody>

                <?php
                if($data){
                    $subTotalItem = array();
                    $beratTotal = array();
                    foreach($data as $row){
                        $getItem = $this->db->get_where('m_item',array('id'=>$row['id_item'],'id_transaksi'=>$data_transaksi['id']))->row_array();
                        $getItemHarga = $this->db->get_where('m_item_harga',array('id_item'=>$row['id_item'],'id_transaksi'=>$data_transaksi['id']))->row_array();
                        $subTotalItem[] = $getItemHarga['harga_fix']*$row['qty'];
                        $beratTotal[] = $getItem['berat']*$row['qty'];
                ?>
                        <tr style="font-size: 13px;">
                            <td style="text-align: left; padding: 8px 5px 8px 15px;"><?php echo $getItem['nama']; ?></td>
                            <td style="width: 120px; padding: 8px 5px;" width="120"><?php echo $data_transaksi_item['qty']; ?></td>
                            <td style="width: 65px; padding: 8px 5px;" width="65"><?php $beratKg = $getItem['berat']/1000 * $row['qty'];echo $beratKg." Kg"; ?></td>
                            <td style="width: 115px; padding: 8px 5px;" width="115"><?php echo number_format($getItemHarga['harga_fix'],0); ?></td>
                            <td style="width: 115px; text-align: right; padding: 8px 30px 8px 5px;" width="115"><?php echo number_format($row['subtotal'],0); ?></td>
                        </tr>
                <?php
                    }
                }
                ?>





                <tr style="font-size: 13px; background-color: #F1F1F1;" bgcolor="#F1F1F1">
                    <td colspan="4" style="font-weight: 600; text-align: left; padding: 8px 5px 8px 15px;">Subtotal</td>
                    <td style="width: 115px; font-weight: 600; text-align: right; padding: 8px 30px 8px 5px;" width="115"><?php echo number_format(array_sum($subTotalItem),0); ?></td>
                </tr>
                </tbody>
            </table>
            <table style="width: 100%; text-align: center; padding: 15px 0;" width="100%" cellspacing="0" cellpadding="0">
                <tbody>
                <tr style="font-size: 13px;">
                    <td style="font-weight: 600; text-align: left; padding: 8px 0 8px 15px;"><?php echo $data_transaksi_item['tipe_kurir']." - ".$data_transaksi_item['tipe_layanan']; ?></td>
                    <td style="width: 120px; padding: 8px 5px;" width="120"></td>
                    <td style="width: 65px; padding: 8px 5px;" width="65"><?php $totalBeratKg = array_sum($beratTotal)/1000; echo $totalBeratKg." Kg";?></td>
                    <td style="width: 115px; padding: 8px 5px;" width="115"></td>
                    <td style="width: 115px; text-align: right; padding: 8px 30px 8px 5px;" width="115"><?php echo number_format($data_transaksi_item['ongkir'],0); ?></td>
                </tr>

                <tr style="font-size: 13px;">


                </tr>
                <tr style="font-size: 13px; background-color: #F1F1F1;" bgcolor="#F1F1F1">
                    <td colspan="4" style="font-weight: 600; text-align: left; padding: 8px 5px 8px 15px;">Subtotal</td>
                    <td style="width: 115px; font-weight: 600; text-align: right; padding: 8px 30px 8px 5px;" width="115"><?php echo number_format($data_transaksi_item['ongkir'],0); ?></td>
                </tr>

                </tbody>
            </table>

            <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; padding: 0 0 20px;">
                <tbody>
                <tr>
                    <td width="35%" valign="top" style="width: 35%; vertical-align: top; padding-right: 5px;"></td>
                    <td width="65%" valign="top" style="width: 65%; vertical-align: top; padding-left: 5px;">
                        <table width="100%" cellspacing="0" cellpadding="0" width="100%" style="width: 100%; border-collapse: collapse;">
                            <tr bgcolor="#F1F1F1" style="font-size: 15px; color: #ff1493; background-color: #F1F1F1;">
                                <td style="padding: 15px 0 15px 30px; font-weight: 600;">Total</td>
                                <td style="padding: 15px 30px 15px 0; font-weight: 600; text-align: right; "><?php $total = array_sum($subTotalItem) + $data_transaksi_item['ongkir']; echo number_format($total,0);  ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="35%" valign="top" style="width: 35%; vertical-align: top; padding-right: 5px;"></td>
                </tr>
                </tbody>
            </table>

            <table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; border-top: 1px dashed #DDD; padding: 25px 0px;">
                <thead>
                <th style="text-align: left; padding: 0;">
                    <h3 style="font-size: 15px; font-weight: 600; margin: 0;">Tujuan Pengiriman</h3>
                </th>
                </thead>
                <tbody>
                <tr>
                    <td style="font-size: 13px; line-height: 20px; padding: 10px 0;">
                        <?php
                        echo $nama_reseller."</br>";
                        $getAlamatTujuan = $this->db->get_where('r_reseller_alamat',array('id'=>$data_transaksi_item['id_alamat']))->row_array();
                        $getKabupaten = $this->db->get_where('r_kabupaten',array('id'=>$getAlamatTujuan['kabupaten']))->row_array();
                        $getProvinsi = $this->db->get_where('r_provinsi',array('id'=>$getAlamatTujuan['provinsi']))->row_array();

                        echo $getAlamatTujuan['alamat']."</br>";
                        echo $getAlamatTujuan['kecamatan'].", ".$getKabupaten['nama'].", ".$getAlamatTujuan['kd_pos']."</br>";
                        echo $getProvinsi['nama']."</br>";
                        echo $getAlamatTujuan['phone'].'</br>';
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>
</body>

</html>
