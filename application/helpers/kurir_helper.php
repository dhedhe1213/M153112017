<?php
/**
 * Created by PhpStorm.
 * User: Dede Irawan,S.kom
 * Date: 24/12/2016
 * Time: 21.42
 */

function cekHarga($tipeKurir = false,$berat = false,$kotaAsal = false,$kotaTujuan = false){
    //Setting Ongkir Otomatis Memanfaat akun starter RajaOngkir.Com
    //$SetPropinsi = "9"; //9 Propinsi Jawa Barat
    $AsalKiriman = $kotaAsal; //115 Kota Bekasi Jawa Barat
    $TujuanKiriman = $kotaTujuan; //419 Kab Sleman Yk
    $BeratProduk = $berat; //1kg Berat Produk
    $TipeOngkir = strtolower($tipeKurir); //Jenis Ongkir jne / tiki / pos
    $APIKeyRaja = "484e9ee9d378b9f59b585ecf6acd67de"; //API Key Raja

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://rajaongkir.com/api/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=$AsalKiriman&destination=$TujuanKiriman&weight=$BeratProduk&courier=$TipeOngkir",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: $APIKeyRaja"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $ci = &get_instance();
        $ci->load->model('mitra_model', 'mitra');
        $ci->mitra->create('m_api_monitoring',array('name'=>'Raja Ongkir','bug'=>$err));
        //echo "cURL Error #:" . $err;
        echo "<option>Maaf terjadi masalah pada server...</option>";
    } else {
        $hasil = json_decode($response, true);
        echo "<option value=''>Pilih Layanan</option>";
        for($i=0; $i<count($hasil['rajaongkir']['results'][0]['costs']); $i++) {
           if($hasil['rajaongkir']['results'][0]['costs'][$i]['description'] <> 'JNE Trucking') {
               for ($ix = 0; $ix < count($hasil['rajaongkir']['results'][0]['costs'][$i]['cost']); $ix++) {
                   echo "<option value='".$hasil['rajaongkir']['results'][0]['costs'][$i]['cost'][$ix]['value']*$BeratProduk."|".$hasil['rajaongkir']['results'][0]['costs'][$i]['service']."'>";
                   if($hasil['rajaongkir']['results'][0]['costs'][$i]['service'] == 'CTC'){
                       echo "Regular";
                   }else{
                       echo str_replace('CTC','',$hasil['rajaongkir']['results'][0]['costs'][$i]['service']) . " (" . $hasil['rajaongkir']['results'][0]['costs'][$i]['description'] . ") ";
                   }
//                   echo ($hasil['rajaongkir']['results'][0]['costs'][$i]['cost'][$ix]['value']*$BeratProduk)." - ".$hasil['rajaongkir']['results'][0]['costs'][$i]['cost'][$ix]['etd']."<br/>";
                   echo "</option>";
               }
           }
        }

    }
}

