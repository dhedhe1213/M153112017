<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Seller extends MY_Controller
{
	public $data = array('title' => 'seller | Mau Jadi Reseller Tanpa Modal?Kami Punya Solusinya',
						 'main_view' => 'content/home');

	public function __construct()
	{
		parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
		$this->load->model('seller_model','seller');
        $this->load->model('catalog/catalog_model','catalog');//call catalog model biar hemat coding
        $this->load->library(array('ajax_pagination','datatables'));
        $this->load->helper(array('role_form_helper','xss_helper','filepath_helper'));
        $this->cekLoginSeller();
	}



	public function index()
	{
        $id = $this->session->userdata('id');
        $profile = $this->seller->getwhere('m_user',array('id'=>$id));
        if($profile) {
            $this->data['cek_catalog'] = $this->seller->getwhere('t_catalog',array('id_user'=>$id));
            $this->data['profile'] = $profile;
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
	}

    public function edit_profile()
    {
        $id = $this->session->userdata('id');

        $this->data['data_provinsi'] = $this->seller->get('r_provinsi',1);
        $this->data['main_view'] = 'content/edit_profile';
        $profile = $this->seller->getwhere('m_user',array('id'=>$id));
        if($profile) {
            $cekAlamat = $this->seller->getwhere('r_seller_alamat',array('id_user'=>$id));
            if($cekAlamat){
                $this->data['data_alamat'] = $cekAlamat;
            }else{
                $this->data['data_alamat'] = false;
            }
            $this->data['profile'] = $profile;
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
    }


    public function act_edit_user()
    {
        $this->load->helper('email_helper');

        $id = $this->session->userdata('id');
        $name = strip_tags($this->input->post('name'));
        $phone = strip_tags($this->input->post('phone'));
        $date = strip_tags($this->input->post('date'));
        $month = strip_tags($this->input->post('month'));
        $year = strip_tags($this->input->post('year'));
        $gender = strip_tags($this->input->post('gender'));
        $no_rek = strip_tags($this->input->post('no_rek'));
        $nm_rek = strip_tags($this->input->post('nm_rek'));

        $alamat = strip_tags($this->input->post('alamat'));
        $provinsi = strip_tags($this->input->post('provinsi'));
        $kabupaten = strip_tags($this->input->post('kabupaten'));
        $kecamatan = strip_tags($this->input->post('kecamatan'));



        // config upload
        $config['upload_path'] = $this->config->item('path_images_user');
        $config['allowed_types'] = 'jpg|jpeg|png'; //sebenernya udah di filter lagi oleh mime.php bawaan ci to xss
        $config['max_size'] = '500'; // 1MB
        $config['encrypt_name'] = true; // to clean xss in name of file
        $this->load->library('upload', $config);
        //$this->upload->initialize($config);

        $get_old_images = $this->seller->getwhere('m_user',array('id'=>$id));
        #filepath untuk memecah url
        $old_images = filePath($get_old_images['picture_url']);
        $old_images_thumb = filePath($get_old_images['picture_url_thumb']);

     if(!empty($_FILES['foto']['name'])) {
            if (!$this->upload->do_upload('foto')) {
                $error = strip_tags($this->upload->display_errors());
                $response = array('error' => true, 'title' => 'Add Gagal', 'pesan' => $error);
                echo json_encode($response);
                exit;
            }else {
                $name_images = $this->upload->data('file_name');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $config['upload_path'].$name_images;
                $config['create_thumb'] = TRUE;
                $config['width']         = 54;
                $config['height']       = 54;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $url_images = base_url('assets/images/user/'.$name_images);
                $url_images_thumb = base_url('assets/images/user/'.$this->upload->data('raw_name').'_thumb'.$this->upload->data('file_ext'));

                if($old_images['basename'] <> 'default.png'){
                    unlink($config['upload_path']. $old_images['basename']);
                    if($old_images['basename'] <> $old_images_thumb['basename']){
                        unlink($config['upload_path']. $old_images_thumb['basename']);
                    }
                }
            }
        } else {
            $url_images = $get_old_images['picture_url'];
            $url_images_thumb = $get_old_images['picture_url_thumb'];
        }
        #end Olah Images

        #cek Kurir
            $getKurir = $this->seller->getwhere('r_seller_kurir',array('id_user'=>$id));
            if(!$getKurir){
                $this->seller->create('r_seller_kurir',array('id_user'=>$id,'kurir'=>'JNE'));
            }
        #end cek kurir

        if (validation_edit_user()) {

            #cek Kurir
            $getALamat = $this->seller->getwhere('r_seller_alamat',array('id_user'=>$id));
            if(!$getALamat){
                $this->seller->create('r_seller_alamat',array('id_user'=>$id,'alamat'=>$alamat,'kabupaten'=>$kabupaten,'kecamatan'=>$kecamatan,'provinsi'=>$provinsi));
            }else{
                $this->seller->update('r_seller_alamat',array('id_user'=>$id),array('alamat'=>$alamat,'kabupaten'=>$kabupaten,'kecamatan'=>$kecamatan,'provinsi'=>$provinsi));
            }
            #end cek kurir

            $edit_review = $this->seller->update('m_user', array('id'=>$id),array('name' => $name, 'phone' => $phone,'gender' => $gender,'birthday'=> $year . '-' . $month . '-' . $date, 'rek'=> $no_rek, 'an_rek'=>$nm_rek,'picture_url'=>$url_images,'picture_url_thumb'=>$url_images_thumb));
            if ($edit_review) {

                #Send Email Confirm
                error_reporting(0);
                $email = $this->session->userdata('email');
                $date_now = date("Y-m-d h:i:sa");
                $subject = "Info Profile User Mitrareseller.com";
                $message = "Akun anda telah melakukan perubahan profile pada waktu & tanggal {$date_now}. <br><br>
                            Jaga selalu akun anda dari pihak yang tidak bertanggung jawab.";

                $send = kirim_email($email,$subject,$message);
                if(!$send){
                    #kirim email gagal ke db
                    $this->seller->create('m_email_monitoring',array('email'=>$email,'bug'=>$this->email->print_debugger()));
                }

                $response = array('error'=>false,'title'=>'Update Success','pesan'=>'');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Update Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function edit_password()
    {
        $this->data['main_view'] = 'content/edit_password';
        $this->load->view('template', $this->data);
    }

    public function act_edit_pass()
    {
        $this->load->helper('email_helper');

        $id = $this->session->userdata('id');
        $pass = strip_tags($this->input->post('password'));
        $password = hash('sha256',$this->input->post('password'));




        if (validation_edit_pass()) {
            $edit_review = $this->seller->update('m_user', array('id'=>$id),array('password' => $password));
            if ($edit_review) {

                #Send Email Confirm
                error_reporting(0);
                $email = $this->session->userdata('email');
                $date_now = date("Y-m-d h:i:sa");
                $subject = "Info Profile User MitraReseller.com";
                $message = "Akun anda telah melakukan perubahan password menjadi {$pass} pada waktu & tanggal {$date_now}. <br><br>
                            Jaga selalu akun anda dari pihak yang tidak bertanggung jawab.";

                $send = kirim_email($email,$subject,$message);
                if(!$send){
                    #kirim email gagal ke db
                    $this->seller->create('m_email_monitoring',array('email'=>$email,'bug'=>$this->email->print_debugger()));
                }

                $response = array('error'=>false,'title'=>'Update Success','pesan'=>'');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Update Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function barangKu()
    {
        $id = $this->session->userdata('id');
        $this->data['main_view'] = 'content/barangku';

        $this->data['data'] = $this->seller->getwhere('t_item',array('id_user'=>$id),1);
        $this->load->view('template', $this->data);
    }


    public function item_detail($id = false)
    {
        $id_clean = strip_tags($id);

        $item = $this->seller->getwhere('t_item',array('id'=>$id_clean));
        $item_harga = $this->seller->getwhere('t_item_harga',array('id_item'=>$id_clean));
        $item_images_big = $this->seller->getwhere('t_item_images',array('id_item'=>$id_clean));
        $item_images = $this->seller->getwhere('t_item_images',array('id_item'=>$id_clean),1);
        $item_review = $this->seller->getwhereCustom('t_item_review','AVG(rate) rate_avg',array('id_item'=>$id_clean));

        if($item && $item_harga && $item_images) {
            $this->data['main_view'] = 'content/item_detail';
            $this->data['nama_reseller'] = $this->session->userdata('name');
            $this->data['item'] = $item;
            $this->data['item_harga'] = $item_harga;
            $this->data['item_images'] = $item_images;
            $this->data['item_images_big'] = $item_images_big;
            $this->data['item_review'] = $item_review;
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
    }

    public function item_review()
    {
        $id_clean = strip_tags($this->input->post('id'));
        $page = strip_tags($this->input->post('page'));

        #set offset number
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        #total rows count
        $totalRec = count($this->seller->getwhere('t_item_review',array('id_item'=>$id_clean),1));

        #pagination configuration
        $config['target']      = '.product-list';
        $config['base_url']    = base_url('mitra/item_review');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = 5;
        $config['link_func']   = 'viewRewiew';
        $this->ajax_pagination->initialize($config);


        $this->data['data'] = $this->seller->getwhereCustom('t_item_review',false,array('id_item'=>$id_clean),1,array('limit'=>$config['per_page'],'start'=>$offset),false,array('param'=>'id_review','by'=>'DESC'));
        $this->data['halaman'] = $this->ajax_pagination->create_links();

        $this->load->view('content/item_review', $this->data, false);
    }


    public function pesananBarang(){

        $id = $this->session->userdata('id');
        $this->data['main_view'] = 'content/pesanan_barang';


        $this->data['data'] = $this->db->group_by('no_invoice')->get_where('t_transaksi_item',array('status'=>1,'no_resi'=>'','id_seller'=>$id))->result_array();
        $this->load->view('template', $this->data);

    }

    public function act_input_resi()
    {
        $id = $this->session->userdata('id');

        $id_transaksi = strip_tags($this->input->post('id_transaksi'));
        $noResi = strip_tags($this->input->post('no_resi'));


        if (validation_input_resi()) {

            #update data terjual
                $getIdItem = $this->seller->getwhere('t_transaksi_item',array('id_transaksi'=>$id_transaksi),1);
                if($getIdItem){
                    foreach($getIdItem as $row){
                        $getDataItem = $this->seller->getwhere('t_item',array('id'=>$row['id_item']));
                        $countTerjual = $getDataItem['terjual']+$row['qty'];
                        $this->seller->update('t_item',array('id'=>$row['id_item']),array('terjual'=>$countTerjual));
                    }
                }
            #end update data terjual

            $inputResi = $this->db->where('id_transaksi',$id_transaksi)->where_in('id_seller', $id)->update('t_transaksi_item', array('no_resi'=>$noResi));
            if($inputResi) {

                #Send Email Confirm
                $getNmCatalog = $this->seller->getwhere('t_transaksi',array('id'=>$id_transaksi));
                $getIdReseller = $this->seller->getwhere('t_catalog',array('nm_catalog'=>$getNmCatalog['nm_catalog']));
                $getEmailSeller = $this->seller->getwhere('m_user',array('id'=>$getIdReseller['id_user']));

                $this->load->helper('email_helper');
                error_reporting(0);
                $subject = "Info Pengiriman Barang Mitrareseller.com";
                $message = "Pesanan anda dengan nomor transaksi <b> {$id_transaksi} </b> telah dikirim.
                            dengan nomor resi : {$noResi} <br><br>
                            Terimakasih atas kepercayaan anda.";

                $send = kirim_email($getEmailSeller['email'],$subject,$message);
                if(!$send){
                    #kirim email gagal ke db
                    $this->seller->create('m_email_monitoring',array('email'=>$getEmailSeller['email'],'bug'=>$this->email->print_debugger()));
                }

                $response = array('error' => false, 'title' => 'No Resi berhasil di input', 'pesan' => '');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Input Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function actTolakPesanan($noInvoice = false)
    {
        if($noInvoice == false){
            show_404();
        }
        $id_user = $this->session->userdata('id');
        $noInvoice_clean = strip_tags($noInvoice);
        $getItemData = $this->seller->getwhere('t_transaksi_item',array('no_invoice'=>$noInvoice_clean));


        if ($getItemData['id_seller'] == $id_user) {

            $updateTransaksiItem = $this->seller->update('t_transaksi_item',array('no_invoice'=>$noInvoice_clean),array('no_resi'=>0));
            if($updateTransaksiItem) {

                #get Email Reseller
                $getNmCatalog = $this->seller->getwhere('t_transaksi',array('id'=>$getItemData['id_transaksi']));
                $getIdReseller = $this->seller->getwhere('t_catalog',array('nm_catalog'=>$getNmCatalog['nm_catalog']));
                $getEmailReseller = $this->seller->getwhere('m_user',array('id'=>$getIdReseller['id_user']));

                $getNameSeller = $this->seller->getwhere('m_user',array('id'=>$id_user));
                #Send Email Confirm
                error_reporting(0);
                $this->load->helper('email_helper');
                $email_admin = "cs.mitrareseller@gmail.com";
                $email_reseller = $getEmailReseller['email'];
                $subjectToAdmin = "Info Penolakan Barang Mitrareseller.com";
                $subjectToReseller = "Info Pengiriman Barang Mitrareseller.com";
                $messageToAdmin = "Seller <b>".$getNameSeller['name']."</b> Telah menolak pesanan barang untuk nomor invoice ".$noInvoice_clean.", mohon di tindak lanjuti. <br><br> Terimakasih atas kerjasama anda.";
                $messageToReseller = "Mohon maaf pesanan barang dengan nomor invoice ".$noInvoice_clean." di tolak,segera lakukan konfirmasi dan uang akan kami transfer pada rekening anda,<br> anda bisa pantau pada riwayat transfer akun. <br><br> Mohon maaf dan terimakasih atas kerjasama anda.";

                $sendToAdmin = kirim_email($email_admin,$subjectToAdmin,$messageToAdmin);
                $sendToReseller = kirim_email($email_reseller,$subjectToReseller,$messageToReseller);

                if(!$sendToAdmin){
                    #kirim email gagal ke db
                    $this->seller->create('m_email_monitoring',array('email'=>$email_admin,'bug'=>$this->email->print_debugger()));
                }
                if(!$sendToReseller){
                    #kirim email gagal ke db
                    $this->seller->create('m_email_monitoring',array('email'=>$email_reseller,'bug'=>$this->email->print_debugger()));
                }

                $response = array('error' => false, 'title' => 'Pesanan Berhasil Ditolak', 'pesan' => '');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Input Gagal!','pesan'=>'You cannot access this function!');
            echo json_encode($response);
        }
    }


    public function barangDikirim(){

        $id = $this->session->userdata('id');
        $this->data['main_view'] = 'content/barang_dikirim';


        $this->data['data'] = $this->db->where('no_resi <>','')->where('status','1')->where('id_seller', $id)->group_by('id_transaksi')->get('t_transaksi_item')->result_array();
        $this->load->view('template', $this->data);

    }

    public function daftarTransaksi()
    {
        $id = $this->session->userdata('id');
        $this->data['main_view'] = 'content/daftar_transaksi';

        $this->data['id_seller'] = $id;
        $this->data['data'] = $this->db->group_by('id_transaksi')->get_where('t_transaksi_item',array('status'=>2,'id_seller'=>$id))->result_array();
        $this->load->view('template', $this->data);
    }

    public function daftarKurir()
    {
        $id = $this->session->userdata('id');
        $this->data['main_view'] = 'content/daftar_kurir';
        $this->data['data'] = $this->db->where('id_user',$id)->get('r_seller_kurir')->result_array();
        $this->data['data_kurir'] = $this->seller->get('r_kurir_list',1);
        $this->load->view('template', $this->data);
    }

    public function act_input_kurir()
    {
        $id = $this->session->userdata('id');
        $nmKurir = strip_tags($this->input->post('nm_kurir'));

        $cekKurir = $this->db->get_where('r_seller_kurir',array('id_user'=>$id,'kurir'=>$nmKurir))->num_rows();

        if($cekKurir == 0) {

            $inputKurir = $this->seller->create('r_seller_kurir', array('id_user' => $id, 'kurir' => $nmKurir));
            if ($inputKurir) {
                $response = array('error' => false, 'title' => 'Kurir berhasil di simpan', 'pesan' => '');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Input Gagal!','pesan'=>'Maaf kurir sudah ada gunakan!');
            echo json_encode($response);
        }
    }

    public function tambahBarang()
    {
        $id = $this->session->userdata('id');

        $this->data['main_view'] = 'content/tambah_barang';
        $getCategory = $this->seller->getwhere('r_cat_item',array('parent_id'=>0),1);
        $getPaymentPresentase = $this->db->get('r_platform_payment')->row_array();
        if($getCategory) {
            $this->data['data'] = $getCategory;
            $this->data['payment_presentase'] = $getPaymentPresentase['payment_presentase'];
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
    }

    public function ubahBarang($id_item = false)
    {
        if($id_item == false){
            show_404();
        }

        $this->data['main_view'] = 'content/edit_barang';
        $getCategory = $this->seller->getwhere('r_cat_item',array('parent_id'=>0),1);
        $getItem = $this->seller->getwhere('t_item',array('id'=>$id_item));
        $getItemHarga = $this->seller->getwhere('t_item_harga',array('id_item'=>$id_item));
        $getItemImages = $this->seller->getwhere('t_item_images',array('id_item'=>$id_item),1);
        $getPaymentPresentase = $this->db->get('r_platform_payment')->row_array();
        if($getCategory && $getItem && $getItemHarga && $getItemImages) {
            $this->data['id_item'] = $id_item;
            $this->data['category'] = $getCategory;
            $this->data['dataItem'] = $getItem;
            $this->data['dataItemImages'] = $getItemImages;
            $this->data['dataItemHarga'] = $getItemHarga;
            $this->data['payment_presentase'] = $getPaymentPresentase['payment_presentase'];
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
    }



    public function getKategori2()
    {
        $id = strip_tags($this->input->post('id'));

        $html = '';
        if(empty($id)){
            echo $html;
        }else{
            $getKategori2 = $this->seller->getwhere('r_cat_item', array('parent_id'=>$id),1);
            if($getKategori2){
                echo "<option value=''>Pilih</option>";
                foreach($getKategori2 as $row){
                    echo "<option value='".$row['id']."'>".$row['menu']."</option>";
                }
            }
        }

    }

    public function getKategori3()
    {
        $id = strip_tags($this->input->post('id'));

        $html = '';
        if(empty($id)){
            echo $html;
        }else{
            $getKategori3 = $this->seller->getwhere('r_cat_item', array('parent_id'=>$id),1);
            if($getKategori3){
                echo "<option value=''>Pilih</option>";
                foreach($getKategori3 as $row){
                    echo "<option value='".$row['id']."'>".$row['menu']."</option>";
                }
            }
        }

    }

    public function act_input_barang()
    {
        $id_user = $this->session->userdata('id');

        $namaBarang = strip_tags($this->input->post('nama_barang'));
        $berat = strip_tags($this->input->post('berat'));
        $stok = strip_tags($this->input->post('stok'));
        $minPesan = strip_tags($this->input->post('min_pesan'));
        $cat1 = strip_tags($this->input->post('category1'));
        $cat2 = strip_tags($this->input->post('category2'));
        $cat3 = strip_tags($this->input->post('category3'));
        $deskripsi = strip_tags(nl2br($this->input->post('deskripsi')),'<br>');
        $hargaBarang = strip_tags($this->input->post('harga_barang'));
        $hargaCoret = strip_tags($this->input->post('harga_coret'));
        $komisiReseller = strip_tags($this->input->post('komisi_reseller'));

        $getNmCat1 = $this->seller->getwhere('r_cat_item', array('id'=>$cat1));
        $getNmCat2 = $this->seller->getwhere('r_cat_item', array('id'=>$cat2));
        $getNmCat3 = $this->seller->getwhere('r_cat_item', array('id'=>$cat3));

        $getPlatformPayment = $this->seller->get('r_platform_payment');
        $countPlatPayment = $hargaBarang * $getPlatformPayment['payment_presentase']/ 100;
        $harga_fix = $hargaBarang+$komisiReseller+$countPlatPayment;


        // config upload
        $config['upload_path'] = $this->config->item('path_images_products');
        $config['allowed_types'] = 'jpg|png|jpeg'; //sebenernya udah di filter lagi oleh mime.php bawaan ci to xss
        $config['max_size'] = '1024'; // 1MB
        $config['encrypt_name'] = true; // to clean xss in name of file
        $this->load->library('upload', $config);
        //$this->upload->initialize($config);

        if(empty($_FILES['images1']['name']) && empty($_FILES['images2']['name']) && empty($_FILES['images3']['name'] )) {
            $response = array('error' => true, 'title' => 'Tambah Barang Gagal!', 'pesan' => 'Foto barang harus diisi minimal 1');
            echo json_encode($response);
            exit;
        }

        if(!empty($_FILES['images1']['name'])) {
            if (!$this->upload->do_upload('images1')) {
                $error = strip_tags($this->upload->display_errors());
                $response = array('error' => true, 'title' => 'Upload Failed! (Foto Barang ke 1)', 'pesan' => $error);
                echo json_encode($response);
                exit;
            } else {
                $name_images1 = $this->upload->data('file_name');
                $file_size1 = $this->upload->data('file_size');

                $configThumbnail['image_library'] = 'gd2';
                $configThumbnail['source_image'] = $config['upload_path'].$name_images1;
                $configThumbnail['create_thumb'] = TRUE;
                $configThumbnail['width']         = 239;
                $configThumbnail['height']       = 239;
                $this->load->library('image_lib');
                $this->image_lib->initialize($configThumbnail);
                $this->image_lib->resize();

                $name_images1_thumb = $this->upload->data('raw_name').'_thumb'.$this->upload->data('file_ext');

            }
        }

        if(!empty($_FILES['images2']['name'])) {
            if (!$this->upload->do_upload('images2')) {
                $error = strip_tags($this->upload->display_errors());
                $response = array('error' => true, 'title' => 'Upload Failed! (Foto Barang ke 2)', 'pesan' => $error);
                echo json_encode($response);
                exit;
            } else {
                $name_images2 = $this->upload->data('file_name');
                $file_size2 = $this->upload->data('file_size');

                $configThumbnail['image_library'] = 'gd2';
                $configThumbnail['source_image'] = $config['upload_path'].$name_images2;
                $configThumbnail['create_thumb'] = TRUE;
                $configThumbnail['width']         = 239;
                $configThumbnail['height']       = 239;
                $this->load->library('image_lib');
                $this->image_lib->initialize($configThumbnail);
                $this->image_lib->resize();

                $name_images2_thumb = $this->upload->data('raw_name').'_thumb'.$this->upload->data('file_ext');

            }
        }

        if(!empty($_FILES['images3']['name'])) {
            if (!$this->upload->do_upload('images3')) {
                $error = strip_tags($this->upload->display_errors());
                $response = array('error' => true, 'title' => 'Upload Failed! (Foto Barang ke 3)', 'pesan' => $error);
                echo json_encode($response);
                exit;
            } else {
                $name_images3 = $this->upload->data('file_name');
                $file_size3 = $this->upload->data('file_size');

                $configThumbnail['image_library'] = 'gd2';
                $configThumbnail['source_image'] = $config['upload_path'].$name_images3;
                $configThumbnail['create_thumb'] = TRUE;
                $configThumbnail['width']         = 239;
                $configThumbnail['height']       = 239;
                $this->load->library('image_lib');
                $this->image_lib->initialize($configThumbnail);
                $this->image_lib->resize();

                $name_images3_thumb = $this->upload->data('raw_name').'_thumb'.$this->upload->data('file_ext');

            }
        }


        #end Olah Images

        if(validation_tambah_barang()) {

            $inputTbItem = $this->seller->create('t_item', array('id_user'=>$id_user,'kat1' => $getNmCat1['menu'],'kat2' => $getNmCat2['menu'],'kat3' => $getNmCat3['menu'], 'nama' => $namaBarang,'deskripsi'=>$deskripsi,'berat'=>$berat,'stok'=>$stok,'min_pesan'=>$minPesan));
            $id_item = $this->db->insert_id();
            $inputTbItemHarga = $this->seller->create('t_item_harga', array('id_item' => $id_item,'harga_seller'=>$hargaBarang,'harga_coret'=>$hargaCoret,'reseller_payment'=>$komisiReseller,'platform_payment'=>$countPlatPayment,'harga_fix'=>$harga_fix));

            if(!empty($_FILES['images1']['name'])) {
                $inputTbItemImages1 = $this->seller->create('t_item_images', array('id_item' => $id_item, 'img' => $name_images1, 'img_thumb' => $name_images1_thumb, 'size' => $file_size1));
            }
            if(!empty($_FILES['images2']['name'])) {
                $inputTbItemImages2 = $this->seller->create('t_item_images', array('id_item' => $id_item,'img'=>$name_images2, 'img_thumb' => $name_images2_thumb,'size'=>$file_size2));
            }
            if(!empty($_FILES['images3']['name'])) {
                $inputTbItemImages3 = $this->seller->create('t_item_images', array('id_item' => $id_item,'img'=>$name_images3, 'img_thumb' => $name_images3_thumb,'size'=>$file_size3));
            }

            if ($inputTbItem && $inputTbItemHarga) {
                $response = array('error' => false, 'title' => 'Barang berhasil di simpan', 'pesan' => '');
                echo json_encode($response);
            }

        }else{
            if(!empty($_FILES['images1']['name'])) {
                unlink($config['upload_path']. $name_images1);
                unlink($config['upload_path']. $name_images1_thumb);
            }
            if(!empty($_FILES['images2']['name'])) {
                unlink($config['upload_path']. $name_images2);
                unlink($config['upload_path']. $name_images2_thumb);
            }
            if(!empty($_FILES['images3']['name'])) {
                unlink($config['upload_path']. $name_images3);
                unlink($config['upload_path']. $name_images3_thumb);
            }

            $response = array('error'=>true,'title'=>'Input Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function actUbahBarang()
    {
        $id_user = $this->session->userdata('id');

        $id_item = strip_tags($this->input->post('id_item'));
        $namaBarang = strip_tags($this->input->post('nama_barang'));
        $berat = strip_tags($this->input->post('berat'));
        $stok = strip_tags($this->input->post('stok'));
        $minPesan = strip_tags($this->input->post('min_pesan'));
        $cat1 = strip_tags($this->input->post('category1'));
        $cat2 = strip_tags($this->input->post('category2'));
        $cat3 = strip_tags($this->input->post('category3'));
        $deskripsi = strip_tags(nl2br($this->input->post('deskripsi')),'<br>');
        $hargaBarang = strip_tags($this->input->post('harga_barang'));
        $hargaCoret = strip_tags($this->input->post('harga_coret'));
        $komisiReseller = strip_tags($this->input->post('komisi_reseller'));
        $oldImages1 = strip_tags($this->input->post('old_images1'));
        $oldImages2 = strip_tags($this->input->post('old_images2'));
        $oldImages3 = strip_tags($this->input->post('old_images3'));


        $getNmCat1 = $this->seller->getwhere('r_cat_item', array('id'=>$cat1));
        $getNmCat2 = $this->seller->getwhere('r_cat_item', array('id'=>$cat2));
        $getNmCat3 = $this->seller->getwhere('r_cat_item', array('id'=>$cat3));

        $getPlatformPayment = $this->seller->get('r_platform_payment');
        $countPlatPayment = $hargaBarang * $getPlatformPayment['payment_presentase']/ 100;
        $harga_fix = $hargaBarang+$komisiReseller+$countPlatPayment;


        // config upload
        $config['upload_path'] = $this->config->item('path_images_products');
        $config['allowed_types'] = 'jpg|png|jpeg'; //sebenernya udah di filter lagi oleh mime.php bawaan ci to xss
        $config['max_size'] = '1024'; // 1MB
        $config['encrypt_name'] = true; // to clean xss in name of file
        $this->load->library('upload', $config);
        //$this->upload->initialize($config);


        if(!empty($_FILES['images1']['name'])) {
            if (!$this->upload->do_upload('images1')) {
                $error = strip_tags($this->upload->display_errors());
                $response = array('error' => true, 'title' => 'Upload Failed! (Foto Barang ke 1)', 'pesan' => $error);
                echo json_encode($response);
                exit;
            } else {
                $name_images1 = $this->upload->data('file_name');
                $file_size1 = $this->upload->data('file_size');

                $configThumbnail['image_library'] = 'gd2';
                $configThumbnail['source_image'] = $config['upload_path'].$name_images1;
                $configThumbnail['create_thumb'] = TRUE;
                $configThumbnail['width']         = 239;
                $configThumbnail['height']       = 239;
                $this->load->library('image_lib');
                $this->image_lib->initialize($configThumbnail);
                $this->image_lib->resize();

                $name_images1_thumb = $this->upload->data('raw_name').'_thumb'.$this->upload->data('file_ext');


                $path = pathinfo($oldImages1);
                $oldthumbnail = $path['filename'].'_thumb.'.$path['extension'];
                $cekThumbnail = $this->db->get_where('t_item_images',array('id_item'=>$id_item,'img_thumb'=>$oldthumbnail))->num_rows();
                if ($oldImages1 <> 'default.jpg') {
                    $deleteImg = unlink($config['upload_path'] . $oldImages1);
                    if($cekThumbnail > 0){
                        $deleteImgThumb = unlink($config['upload_path'] . $oldthumbnail);
                    }
                }
            }
        }

        if(!empty($_FILES['images2']['name'])) {
            if (!$this->upload->do_upload('images2')) {
                $error = strip_tags($this->upload->display_errors());
                $response = array('error' => true, 'title' => 'Upload Failed! (Foto Barang ke 2)', 'pesan' => $error);
                echo json_encode($response);
                exit;
            } else {
                $name_images2 = $this->upload->data('file_name');
                $file_size2 = $this->upload->data('file_size');

                $configThumbnail['image_library'] = 'gd2';
                $configThumbnail['source_image'] = $config['upload_path'].$name_images2;
                $configThumbnail['create_thumb'] = TRUE;
                $configThumbnail['width']         = 239;
                $configThumbnail['height']       = 239;
                $this->load->library('image_lib');
                $this->image_lib->initialize($configThumbnail);
                $this->image_lib->resize();

                $name_images2_thumb = $this->upload->data('raw_name').'_thumb'.$this->upload->data('file_ext');



                $path = pathinfo($oldImages2);
                $oldthumbnail = $path['filename'].'_thumb.'.$path['extension'];
                $cekThumbnail = $this->db->get_where('t_item_images',array('id_item'=>$id_item,'img_thumb'=>$oldthumbnail))->num_rows();
                if ($oldImages2 <> 'default.jpg') {
                    $deleteImg = unlink($config['upload_path'] . $oldImages2);
                    if($cekThumbnail > 0){
                        $deleteImgThumb = unlink($config['upload_path'] . $oldthumbnail);
                    }
                }
            }
        }

        if(!empty($_FILES['images3']['name'])) {
            if (!$this->upload->do_upload('images3')) {
                $error = strip_tags($this->upload->display_errors());
                $response = array('error' => true, 'title' => 'Upload Failed! (Foto Barang ke 3)', 'pesan' => $error);
                echo json_encode($response);
                exit;
            } else {
                $name_images3 = $this->upload->data('file_name');
                $file_size3 = $this->upload->data('file_size');

                $configThumbnail['image_library'] = 'gd2';
                $configThumbnail['source_image'] = $config['upload_path'].$name_images3;
                $configThumbnail['create_thumb'] = TRUE;
                $configThumbnail['width']         = 239;
                $configThumbnail['height']       = 239;
                $this->load->library('image_lib');
                $this->image_lib->initialize($configThumbnail);
                $this->image_lib->resize();

                $name_images3_thumb = $this->upload->data('raw_name').'_thumb'.$this->upload->data('file_ext');


                $path = pathinfo($oldImages3);
                $oldthumbnail = $path['filename'].'_thumb.'.$path['extension'];
                $cekThumbnail = $this->db->get_where('t_item_images',array('id_item'=>$id_item,'img_thumb'=>$oldthumbnail))->num_rows();
                if ($oldImages3 <> 'default.jpg') {
                    $deleteImg = unlink($config['upload_path'] . $oldImages3);
                    if($cekThumbnail > 0){
                        $deleteImgThumb = unlink($config['upload_path'] . $oldthumbnail);
                    }
                }
            }
        }


        #end Olah Images

        if(validation_tambah_barang()) {

            $inputTbItem = $this->seller->update('t_item',array('id'=>$id_item,'id_user'=>$id_user),array('kat1' => $getNmCat1['menu'],'kat2' => $getNmCat2['menu'],'kat3' => $getNmCat3['menu'], 'nama' => $namaBarang,'deskripsi'=>$deskripsi,'berat'=>$berat,'stok'=>$stok,'min_pesan'=>$minPesan));
            $inputTbItemHarga = $this->seller->update('t_item_harga',array('id_item'=>$id_item), array('harga_seller'=>$hargaBarang,'harga_coret'=>$hargaCoret,'reseller_payment'=>$komisiReseller,'platform_payment'=>$countPlatPayment,'harga_fix'=>$harga_fix));

            if(!empty($_FILES['images1']['name'])) {
                if ($oldImages1 == 'default.jpg') {
                    $inputTbItemImages1 = $this->seller->create('t_item_images', array('id_item' => $id_item, 'img' => $name_images1, 'img_thumb' => $name_images1_thumb, 'size' => $file_size1));
                } else {
                    $inputTbItemImages1 = $this->seller->update('t_item_images', array('id_item' => $id_item, 'img' => $oldImages1), array('img' => $name_images1, 'img_thumb' => $name_images1_thumb, 'size' => $file_size1));
                }
            }

            if(!empty($_FILES['images2']['name'])) {
                if ($oldImages2 == 'default.jpg') {
                    $inputTbItemImages2 = $this->seller->create('t_item_images', array('id_item' => $id_item, 'img' => $name_images2, 'img_thumb' => $name_images2_thumb, 'size' => $file_size2));
                } else {
                    $inputTbItemImages2 = $this->seller->update('t_item_images', array('id_item' => $id_item, 'img' => $oldImages2), array('img' => $name_images2, 'img_thumb' => $name_images2_thumb, 'size' => $file_size2));
                }
            }

            if(!empty($_FILES['images3']['name'])) {
                if ($oldImages3 == 'default.jpg') {
                    $inputTbItemImages3 = $this->seller->create('t_item_images', array('id_item' => $id_item, 'img' => $name_images3, 'img_thumb' => $name_images3_thumb, 'size' => $file_size3));
                } else {
                    $inputTbItemImages3 = $this->seller->update('t_item_images', array('id_item' => $id_item, 'img' => $oldImages3), array('img' => $name_images3, 'img_thumb' => $name_images3_thumb, 'size' => $file_size3));
                }
            }

            if ($inputTbItem && $inputTbItemHarga) {
                $response = array('error' => false, 'title' => 'Barang berhasil di ubah', 'pesan' => '');
                echo json_encode($response);
            }else{
                $response = array('error' => false, 'title' => 'query failed', 'pesan' => '');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Ubah Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function getKabupaten()
    {
        $id = strip_tags($this->input->post('id'));
        $html = '';
        if(empty($id)){
            echo $html;
        }else {
            $getKabupaten = $this->seller->getwhere('r_kabupaten', array('id_prov' => $id),1);

            if($getKabupaten){
                foreach($getKabupaten as $row){
                    echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                }
            }
        }

    }

    public function getKecamatan()
    {
        $id = strip_tags($this->input->post('id'));
        $html = '';
        if(empty($id)){
            echo $html;
        }else {
            $getKecamatan = $this->seller->getwhere('r_kecamatan', array('id_kabupaten' => $id),1);

            if($getKecamatan){
                foreach($getKecamatan as $row){
                    echo "<option value='".$row['nama']."'>".$row['nama']."</option>";
                }
            }
        }

    }

    public function histTransfer()
    {
        $id = $this->session->userdata('id');

        $this->data['main_view'] = 'content/hist_transfer';
        $this->data['data'] = $this->seller->getwhere('m_payment',array('id_user'=>$id,'role'=>'seller'),1,false,false,array('param'=>'id','by'=>'desc'));
        $this->load->view('template', $this->data);
    }


//  +++++++++++++++++++++++++ Function cetak invoice +++++++++++++++++++++++++++++
    public function cetak($noInvoice = false)
    {
        if(!$noInvoice){
            show_404();
        }

        $getData = $this->seller->getwhere('t_transaksi_item',array('no_invoice'=>$noInvoice));
        $getDataTransaksi = $this->seller->getwhere('t_transaksi',array('id'=>$getData['id_transaksi']));
        $getIdUser = $this->seller->getwhere('t_catalog',array('nm_catalog'=>$getDataTransaksi['nm_catalog']));
        $getDataUser = $this->seller->getwhere('m_user',array('id'=>$getIdUser['id_user']));

        if($getData) {
            $this->data['nama_reseller'] = $getDataUser['name'];
            //$this->data['data_transaksi_item'] = $getData;
            $this->data['data_transaksi'] = $getDataTransaksi;
            $this->data['kode_unik'] = $this->seller->getwhere('t_catalog_review_code', array('no_invoice' => $noInvoice));
            $this->data['data'] = $this->seller->getwhere('t_transaksi_item', array('no_invoice' => $noInvoice), 1);
            $this->load->view('content/cetak', $this->data);
        }else{
            show_404();
        }
    }

    public function cetakHistory($noInvoice = false)
    {
        if(!$noInvoice){
            show_404();
        }

        $getData = $this->seller->getwhere('m_transaksi_item',array('no_invoice'=>$noInvoice));
        $getDataTransaksi = $this->seller->getwhere('m_transaksi',array('id'=>$getData['id_transaksi']));
        $getIdUser = $this->seller->getwhere('t_catalog',array('nm_catalog'=>$getDataTransaksi['nm_catalog']));
        $getDataUser = $this->seller->getwhere('m_user',array('id'=>$getIdUser['id_user']));

        if($getData) {
            $this->data['nama_reseller'] = $getDataUser['name'];
            $this->data['data_transaksi_item'] = $getData;
            $this->data['data_transaksi'] = $getDataTransaksi;
            $this->data['kode_unik'] = $this->seller->getwhere('t_catalog_review_code', array('no_invoice' => $noInvoice));
            $this->data['data'] = $this->seller->getwhere('m_transaksi_item', array('no_invoice' => $noInvoice), 1);
            $this->load->view('content/cetak', $this->data);
        }else{
            show_404();
        }
    }
    //  +++++++++++++++++++++++++ Function DELETE+++++++++++++++++++++++++++++
    public function actDeleteKurir($idKurir = false)
    {
        $id = $this->session->userdata('id');
        $GetDataKurir = $this->seller->getwhere('r_seller_kurir',array('id'=>$idKurir));

        if($GetDataKurir){
            if($GetDataKurir['id_user'] == $id){
                $delete = $this->seller->delete('r_seller_kurir',array('id'=>$idKurir));
                if ($delete) {
                    $response = array('error'=>false,'title'=>'Hapus Berhasil','pesan'=>'');
                    echo json_encode($response);
                }else{
                    $response = array('error'=>true,'title'=>'Hapus Gagal!','pesan'=>'Query Failed');
                    echo json_encode($response);
                }
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

    public function act_delete_item($id = false)
    {
        $id_user = $this->session->userdata('id');

        $cekUser = $this->seller->getwhere('t_item',array('id_user' => $id_user));
        $cekItemOntransaction = $this->db->get_where('t_transaksi_item',array('id_item' => $id))->num_rows();

            if($cekItemOntransaction > 0){
                $response = array('error' => true, 'title' => 'Delete Gagal!', 'pesan' => 'Barang sedang dalam transaksi');
                echo json_encode($response);
                die;
            }

            if ($cekUser) {
                $getImages = $this->seller->getwhere('t_item_images',array('id_item'=>$id),1);
                if($getImages){
                    $path = $this->config->item('path_images_products');
                    foreach($getImages as $row){
                        if($row['img'] <> 'default.jpg') {
                            $deleteImages = unlink($path . $row['img']);
                            if($row['img'] <> $row['img_thumb']){
                                $deleteImagesThumb = unlink($path . $row['img_thumb']);
                            }

                        }
                    }
                }
                $deleteItem = $this->seller->delete('t_item', array('id' => $id));
                $deleteItemImages = $this->seller->delete('t_item_images', array('id_item' => $id));
                $deleteItemHarga = $this->seller->delete('t_item_harga', array('id_item' => $id));
                $deleteItemReview = $this->seller->delete('t_item_review', array('id_item' => $id));
                $deleteItemOnCartReseller = $this->seller->delete('t_catalog_cart', array('id_item' => $id));
                $deleteItemOnCatalogReseller = $this->seller->delete('t_catalog_item', array('id_item' => $id));

                if ($deleteItem && $deleteItemImages && $deleteItemHarga) {
                    $response = array('error' => false, 'title' => 'Hapus Berhasil', 'pesan' => '');
                    echo json_encode($response);
                } else {
                    $response = array('error' => true, 'title' => 'Delete Gagal!', 'pesan' => 'Query Failed');
                    echo json_encode($response);
                }
            } else {
                show_404();
            }

    }
//  +++++++++++++++++++++++++ End Function Delete Global +++++++++++++++++++++++++++


}