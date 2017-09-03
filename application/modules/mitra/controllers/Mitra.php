<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Mitra extends MY_Controller
{
	public $data = array('title' => 'Mitra Reseller | Mau Jadi Reseller Tanpa Modal?Kami Punya Solusinya',
						 'main_view' => 'content/home');

	public function __construct()
	{
		parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
		$this->load->model('mitra_model','mitra');
        $this->load->model('catalog/catalog_model','catalog');//call catalog model biar hemat coding
        $this->load->library(array('ajax_pagination','datatables'));
        $this->load->helper(array('role_form_helper','xss_helper','filepath_helper'));
        $this->cekLoginReseller();

	}

	public function index()
	{
        $id = $this->session->userdata('id');
        $profile = $this->mitra->getwhere('m_user',array('id'=>$id));
        if($profile) {
            $this->data['cek_catalog'] = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));
            $this->data['profile'] = $profile;
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
	}

    public function edit_profile()
    {
        $id = $this->session->userdata('id');

        $this->data['main_view'] = 'content/edit_profile';
        $profile = $this->mitra->getwhere('m_user',array('id'=>$id));
        if($profile) {
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

        // config upload
        $config['upload_path'] = $this->config->item('path_images_user');
        $config['allowed_types'] = 'jpg|jpeg|png'; //sebenernya udah di filter lagi oleh mime.php bawaan ci to xss
        $config['max_size'] = '500'; // 1MB
        $config['encrypt_name'] = true; // to clean xss in name of file
        $this->load->library('upload', $config);
        //$this->upload->initialize($config);

        $get_old_images = $this->mitra->getwhere('m_user',array('id'=>$id));
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

        if (validation_edit_user()) {
            $edit_review = $this->mitra->update('m_user', array('id'=>$id),array('name' => $name, 'phone' => $phone,'gender' => $gender,'birthday'=> $year . '-' . $month . '-' . $date, 'rek'=> $no_rek, 'an_rek'=>$nm_rek,'picture_url'=>$url_images,'picture_url_thumb'=>$url_images_thumb));
            if ($edit_review) {
                #kirim email
                error_reporting(0);
                $email = $this->session->userdata('email');
                $date_now = date("Y-m-d h:i:sa");
                $subject = "Info Profile User MitraReseller.com";
                $message = "Akun anda telah melakukan perubahan profile pada waktu & tanggal {$date_now}. <br><br>
                            Jaga selalu akun anda dari pihak yang tidak bertanggung jawab.";

                $send = kirim_email($email,$subject,$message);
                if(!$send){
                    #kirim email gagal ke db
                    $this->mitra->create('m_email_monitoring',array('email'=>$email,'bug'=>$this->email->print_debugger()));
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
            $edit_review = $this->mitra->update('m_user', array('id'=>$id),array('password' => $password));
            if ($edit_review) {
                #kirim email
                error_reporting(0);
                $email = $this->session->userdata('email');
                $date_now = date("Y-m-d h:i:sa");
                $subject = "Info Profile User MitraReseller.com";
                $message = "Akun anda telah melakukan perubahan password menjadi {$pass} pada waktu & tanggal {$date_now}. <br><br>
                            Jaga selalu akun anda dari pihak yang tidak bertanggung jawab.";

                $send = kirim_email($email,$subject,$message);
                if(!$send){
                    #kirim email gagal ke db
                    $this->mitra->create('m_email_monitoring',array('email'=>$email,'bug'=>$this->email->print_debugger()));
                }

                $response = array('error'=>false,'title'=>'Update Success','pesan'=>'');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Update Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function item($kat1 = false,$kat2 = false,$kat3 = false){
        #protect category
        if($kat1 == false or $kat2 == false or $kat3 == false){
            show_404();
        }else{

            $kat1_clean = strip_tags(str_replace('_', ' ', $kat1));
            $kat2_clean = strip_tags(str_replace('_', ' ', $kat2));
            $kat3_clean = strip_tags(str_replace('_', ' ', $kat3));
        }

        #start pagination

        $per_page = 9;
        #count data
        $totalRec = count($this->mitra->getlike('t_item',array('kat1'=>$kat1_clean,'kat2'=>$kat2_clean,'kat3'=>$kat3_clean)));
        #pagination configuration
        $config['target']      = '.product-list';
        $config['base_url']    = base_url('mitra/item_filter');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        #create link
        $this->data['halaman'] = $this->ajax_pagination->create_links();

        #End Pagination

        $data = $this->mitra->getlikejoin('t_item','t_item_harga',false,'id','id_item',false,array('kat1'=>$kat1_clean,'kat2'=>$kat2_clean,'kat3'=>$kat3_clean),false,array('limit'=>$per_page,'start'=>false));

        if($data) {
            $this->data['main_view'] = 'content/item';
            $this->data['category'] = array('cat1'=>$kat1_clean,'cat2'=>$kat2_clean,'cat3'=>$kat3_clean);
            $this->data['data'] = $data;
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
    }

    function item_filter(){

        $kat1 = strip_tags($this->input->post('cat1'));
        $kat2 = strip_tags($this->input->post('cat2'));
        $kat3 = strip_tags($this->input->post('cat3'));


        #set offset number
        $page = strip_tags($this->input->post('page'));
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        #set conditions for search
        $keywords = strip_tags($this->input->post('keywords'));
        $sortBy = strip_tags($this->input->post('sortBy'));
        $show = strip_tags($this->input->post('show'));

        if(empty($keywords)){
            $keywords = false;
        }
        if(empty($sortBy)){
            $sortBy = false;
        }
        if(empty($show)){
            $show = 9;
        }

        $per_page = $show;

        #total rows count
        $totalRec = count($this->mitra->getlike('t_item',array('kat1'=>$kat1,'kat2'=>$kat2,'kat3'=>$kat3),array('param'=>'nama','value'=>$keywords)));

        #pagination configuration
        $config['target']      = '.product-list';
        $config['base_url']    = base_url('mitra/item_filter');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get posts data
        $this->data['data'] = $this->mitra->getlikejoin('t_item','t_item_harga',false,'id','id_item',false,array('kat1'=>$kat1,'kat2'=>$kat2,'kat3'=>$kat3),array('param'=>'nama','value'=>$keywords),array('limit'=>$per_page,'start'=>$offset),false,array('param'=>'id','by'=>$sortBy));
        $this->data['halaman'] = $this->ajax_pagination->create_links();

        //load the view
        $this->load->view('content/item_filter', $this->data, false);
    }

    public function autocomplete_item($kat1 = false,$kat2 = false,$kat3 = false)
    {
        $kat1_clean = strip_tags($kat1);
        $kat2_clean = strip_tags($kat2);
        $kat3_clean = strip_tags($kat3);
        $get = strip_tags($this->input->get('term'));

        $data = $this->mitra->getlike('t_item',array('kat1'=>$kat1_clean,'kat2'=>$kat2_clean,'kat3'=>$kat3_clean),array('param'=>'nama','value'=>$get),10);
        if($data) {
            foreach ($data as $row) {
                $row_set[] = $row['nama'];
            }
            echo json_encode($row_set);
        }

    }


    public function item_detail($id = false)
    {
        $id_clean = strip_tags($id);

        $item = $this->mitra->getwhere('t_item',array('id'=>$id_clean));
        $item_harga = $this->mitra->getwhere('t_item_harga',array('id_item'=>$id_clean));
        $item_images_big = $this->mitra->getwhere('t_item_images',array('id_item'=>$id_clean));
        $item_images = $this->mitra->getwhere('t_item_images',array('id_item'=>$id_clean),1);
        $item_review = $this->mitra->getwhereCustom('t_item_review','AVG(rate) rate_avg',array('id_item'=>$id_clean));

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
        $totalRec = count($this->mitra->getwhere('t_item_review',array('id_item'=>$id_clean),1));

        #pagination configuration
        $config['target']      = '.product-list';
        $config['base_url']    = base_url('mitra/item_review');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = 5;
        $config['link_func']   = 'viewRewiew';
        $this->ajax_pagination->initialize($config);


        $this->data['data'] = $this->mitra->getwhereCustom('t_item_review',false,array('id_item'=>$id_clean),1,array('limit'=>$config['per_page'],'start'=>$offset),false,array('param'=>'id_review','by'=>'DESC'));
        $this->data['halaman'] = $this->ajax_pagination->create_links();

        $this->load->view('content/item_review', $this->data, false);
    }

    public function act_add_review()
    {
        $id = strip_tags($this->input->post('id_item'));
        $name = strip_tags($this->input->post('name'));
        $rate = strip_tags($this->input->post('backing5'));
        $review = strip_tags($this->input->post('review'));



        if (validation_add_review()) {
            $add_review = $this->mitra->create('t_item_review', array('id_item'=>$id,'name' => $name, 'review' => $review,'rate' => $rate));
            if ($add_review) {
                $response = array('error'=>false,'title'=>'Success','pesan'=>'Terimakasih Telah Mengisi Review Untuk Produk Ini');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function add_catalog()
    {
        $id = $this->session->userdata('id');
        $cek_catalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));
        if(!$cek_catalog){
            $this->data['main_view'] = 'content/add_catalog';
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }

    }

    public function act_add_catalog()
    {
        $id = $this->session->userdata('id');
        $nm_catalog = strip_tags($this->input->post('nm_catalog'));


        if (validation_add_catalog()) {
            $add_catalog = $this->mitra->create('t_catalog', array('id_user'=>$id,'nm_catalog' => $nm_catalog,'level'=>'silver'));
            if ($add_catalog) {
                $response = array('error'=>false,'title'=>'Success','pesan'=>'Link Catalog akan aktif setelah anda add barang pada catalog.');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function act_add_to_catalog()
    {
        $id = $this->session->userdata('id');
        $id_item = strip_tags($this->input->post('id_item'));

        if(empty($id_item)){
            show_404();
        }


        $cekCatalog = $this->db->get_where('t_catalog',array('id_user'=>$id))->num_rows();
        if($cekCatalog < 1){
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>'Anda belum membuat catalog');
            echo json_encode($response);
            exit;
        }

        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));
        $cek_item = $this->db->get_where('t_catalog_item',array('nm_catalog'=>$GetCatalog['nm_catalog'],'id_item'=>$id_item))->num_rows();
        $count_item = $this->db->get_where('t_catalog_item',array('nm_catalog'=>$GetCatalog['nm_catalog']))->num_rows();


        if($GetCatalog['level'] == 'gold'){
            $maks_item = 18;
        }else if($GetCatalog['level'] == 'platinum'){
            $maks_item = 36;
        }else{
            $maks_item = 9;
        }

        if($count_item == $maks_item){
            $response = array('error'=>true,'title'=>'Catalog Full!','pesan'=>'Maksimum produk untuk level '.$GetCatalog['level'].' adalah '.$maks_item);
            echo json_encode($response);
            exit;
        }

        if ($cek_item > 0) {
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>'Produk sudah ada pada catalog anda');
            echo json_encode($response);
            exit;
        }

        $add_catalog = $this->mitra->create('t_catalog_item', array('id_item'=>$id_item,'nm_catalog' => $GetCatalog['nm_catalog']));
        if ($add_catalog) {
            $response = array('error'=>false,'title'=>'Success','pesan'=>'Produk sudah di tambahkan ke catalog');
            echo json_encode($response);
        }else{
            $response = array('error'=>false,'title'=>'Failed','pesan'=>'Insert Database Failed!');
            echo json_encode($response);
        }

    }

    public function catalog($nm_catalog = false){
        #protect category
        if($nm_catalog == false){
            show_404();
        }else{
            $nm_catalog_clean = strip_tags($nm_catalog);
        }
        $validNmCatalog = $this->db->get_where('t_catalog',array('nm_catalog'=>$nm_catalog))->num_rows();
        $getID = $this->catalog->getwhere('t_catalog_item',array('nm_catalog'=>$nm_catalog_clean),1);
        if($getID){
            foreach($getID as $row){
                $id_item[] =  $row['id_item'];
            }
        }else{
            if($validNmCatalog){
                echo"<script>alert('Catalog Masih Kosong!');window.location.href='".base_url('mitra')."'</script>";
            }else{
                show_404();
            }

        }

        #start pagination
        $per_page = 9;
        #count data
        $totalRec = count($this->catalog->getwherein('t_item',$id_item,1));

        #pagination configuration
        $config['target']      = '.product-list';
        $config['base_url']    = base_url('catalog/item_filter');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        #create link
        $this->data['halaman'] = $this->ajax_pagination->create_links();

        #End Pagination


        $getIdUser = $this->catalog->getwhere('t_catalog',array('nm_catalog'=>$nm_catalog_clean));
        $getProfile = $this->catalog->getwhere('m_user',array('id'=>$getIdUser['id_user']));
        #update hits
        $hitsPlus = $getIdUser['hits'] + 1;
        $this->catalog->update('t_catalog',array('nm_catalog'=>$nm_catalog_clean),array('hits'=>$hitsPlus));

        $catalog_review = $this->catalog->getwhereCustom('t_catalog_review','AVG(rate) rate_avg',array('nm_catalog'=>$nm_catalog_clean));
        $data = $this->catalog->getlikejoinin('t_item','t_item_harga',false,'id','id_item',false,$id_item,false,array('limit'=>$per_page,'start'=>false));

        if($data && $getProfile && $catalog_review) {
            $this->data['main_view'] = 'content/catalog_item';
            $this->data['catalog_data'] = $getIdUser;
            $this->data['catalog_review'] = $catalog_review;
            $this->data['nm_catalog'] = $nm_catalog_clean;
            $this->data['data_profile'] = $getProfile;
            $this->data['data'] = $data;
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
    }

    public function catalog_detail($id = false)
    {
        $idUser = $this->session->userdata('id');
        $cek_catalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$idUser));


        $id_clean = strip_tags($id);

        $item = $this->mitra->getwhere('t_item',array('id'=>$id_clean));
        $item_harga = $this->mitra->getwhere('t_item_harga',array('id_item'=>$id_clean));
        $item_images_big = $this->mitra->getwhere('t_item_images',array('id_item'=>$id_clean));
        $item_images = $this->mitra->getwhere('t_item_images',array('id_item'=>$id_clean),1);
        $item_review = $this->mitra->getwhereCustom('t_item_review','AVG(rate) rate_avg',array('id_item'=>$id_clean));

        if($item && $item_harga && $item_images) {
            $this->data['nm_catalog'] = $cek_catalog['nm_catalog'];
            $this->data['main_view'] = 'content/catalog_detail';
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

    function catalog_filter(){
        $nm_catalog_clean = strip_tags($this->input->post('nm_catalog'));
        $getID = $this->catalog->getwhere('t_catalog_item',array('nm_catalog'=>$nm_catalog_clean),1);
        if($getID) {
            foreach ($getID as $row) {
                $id_item[] = $row['id_item'];
            }
        }else{
            show_404();
        }



        #set offset number
        $page = strip_tags($this->input->post('page'));
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        #set conditions for search
        $keywords = strip_tags($this->input->post('keywords'));
        $sortBy = strip_tags($this->input->post('sortBy'));
        $show = strip_tags($this->input->post('show'));

        if(empty($keywords)){
            $keywords = false;
        }
        if(empty($sortBy)){
            $sortBy = false;
        }
        if(empty($show)){
            $show = 9;
        }

        $per_page = $show;

        #total rows count
        $totalRec = count($this->catalog->getlikein('t_item',$id_item,array('param'=>'nama','value'=>$keywords)));



        #pagination configuration
        $config['target']      = '.product-list';
        $config['base_url']    = base_url('mitra/catalog_filter');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get posts data
        $this->data['data'] = $this->catalog->getlikejoinin('t_item','t_item_harga',false,'id','id_item',false,$id_item,array('param'=>'nama','value'=>$keywords),array('limit'=>$per_page,'start'=>$offset),false,array('param'=>'id','by'=>$sortBy));
        $this->data['nm_catalog'] = $nm_catalog_clean;
        $this->data['halaman'] = $this->ajax_pagination->create_links();

        //load the view
        $this->load->view('content/catalog_filter', $this->data, false);
    }

    public function autocomplete_catalog($nm_catalog = false)
    {
        $nm_catalog_clean = strip_tags($nm_catalog);
        $getID = $this->catalog->getwhere('t_catalog_item',array('nm_catalog'=>$nm_catalog_clean),1);
        if($getID) {
            foreach ($getID as $row) {
                $id_item[] = $row['id_item'];
            }
        }else{
            show_404();
        }

        $get = strip_tags($this->input->get('term'));

        $data = $this->catalog->getlikein('t_item',$id_item,array('param'=>'nama','value'=>$get),10);
        if($data) {
            foreach ($data as $row) {
                $row_set[] = $row['nama'];
            }
            echo json_encode($row_set);
        }

    }



    public function act_replay_review()
    {

        $nm_catalog = strip_tags($this->input->post('nm_catalog'));
        $name = strip_tags($this->input->post('name'));
        $rate = strip_tags($this->input->post('backing5'));
        $review = strip_tags($this->input->post('review'));

        if (validation_add_review()) {
            $add_review = $this->catalog->create('t_catalog_review', array('nm_catalog'=>$nm_catalog,'name' => $name, 'review' => $review,'rate' => $rate));
            if ($add_review) {
                $response = array('error'=>false,'title'=>'Success','pesan'=>'Terimakasih Telah Membalas Review');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function catalog_review()
    {
        $nm_catalog_clean = strip_tags($this->input->post('nm_catalog'));
        $page = strip_tags($this->input->post('page'));

        #set offset number
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        #total rows count
        $totalRec = count($this->catalog->getwhere('t_catalog_review',array('nm_catalog'=>$nm_catalog_clean),1));

        #pagination configuration
        $config['target']      = '.product-list';
        $config['base_url']    = base_url('catalog/catalog_review');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = 5;
        $config['link_func']   = 'viewRewiewCatalog';
        $this->ajax_pagination->initialize($config);


        $this->data['data'] = $this->catalog->getwhereCustom('t_catalog_review',false,array('nm_catalog'=>$nm_catalog_clean),1,array('limit'=>$config['per_page'],'start'=>$offset),false,array('param'=>'id_review','by'=>'DESC'));
        $this->data['halaman'] = $this->ajax_pagination->create_links();

        $this->load->view('content/catalog_review', $this->data, false);
    }

    public function catalog_cart()
    {
        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));

       $getIdItem = $this->mitra->getwhereCustom('t_catalog_cart','id_item',array('nm_catalog'=>$GetCatalog['nm_catalog']),1);
       if($getIdItem){
           $id_item = array();
           foreach ($getIdItem as $row) {
               $id_item[] = $row['id_item'];
           }
           $getItemOnCart = $this->catalog->getwherein('t_item',$id_item,1);
           $this->data['data_item'] = $getItemOnCart;
           $this->data['nm_catalog'] = $GetCatalog['nm_catalog'];
       }else{
           $this->data['data_item'] = false;
       }

        $this->data['main_view'] = 'content/catalog_cart';
        $this->load->view('template', $this->data);

    }


    public function catalog_cart_load()
    {
        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));

        $getIdItem = $this->mitra->getwhereCustom('t_catalog_cart','id_item',array('nm_catalog'=>$GetCatalog['nm_catalog']),1);
        if($getIdItem){
            $id_item = array();
            foreach ($getIdItem as $row) {
                $id_item[] = $row['id_item'];
            }
            $getItemOnCart = $this->catalog->getwherein('t_item',$id_item,1);
            $this->data['data_item'] = $getItemOnCart;
            $this->data['nm_catalog'] = $GetCatalog['nm_catalog'];
        }else{
            $this->data['data_item'] = false;
        }

        $this->load->view('content/catalog_cart_load', $this->data, false);

    }

    public function catalog_count_cart()
    {
        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));

        $getIdItem = $this->db->get_where('t_catalog_cart',array('nm_catalog'=>$GetCatalog['nm_catalog']))->num_rows();
        if($getIdItem > 0){
            echo "<a href='".base_url('mitra/catalog_cart')."' class='top-cart-info-value'>".$getIdItem." Produk</a>";
        }else{
            echo "<a href='".base_url('mitra/catalog_cart')."' class='top-cart-info-value'>0 Produk</a>";
        }

    }

    public function act_add_to_cart()
    {
        $nm_catalog = strip_tags($this->input->post('nm_catalog'));
        $id_item = strip_tags($this->input->post('id_item'));

        $cekItem = $this->db->get_where('t_catalog_cart', array('nm_catalog'=>$nm_catalog,'id_item'=>$id_item))->num_rows();
        if($cekItem > 0){
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>'Produk sudah ada dalam keranjang belanja anda!');
            echo json_encode($response);
            exit;
        }

        $getItem = $this->mitra->getwhere('t_item',array('id'=>$id_item));
        if($getItem['stok'] == 0 ){
            $response = array('error'=>true,'title'=>'Buy Failed!','pesan'=>'Mohon  Maaf Stok untuk produk ini habis');
            echo json_encode($response);
            exit;
        }

        $getHarga = $this->db->get_where('t_item_harga',array('id_item'=>$id_item))->row_array();
        if (!empty($nm_catalog) && !empty($id_item)) {
            $subTotal = $getItem['min_pesan'] * $getHarga['harga_fix'];
            $add_item_to_cart = $this->mitra->create('t_catalog_cart', array('nm_catalog'=>$nm_catalog,'id_seller'=>$getItem['id_user'],'id_item' => $id_item, 'qty' => $getItem['min_pesan'],'subtotal'=>$subTotal));
            if ($add_item_to_cart) {
                $response = array('error'=>false,'title'=>'Success','pesan'=>'Produk Sudah ditambahkan ke keranjang belanja anda');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>'');
            echo json_encode($response);
        }
    }


    public function act_edit_jumlah()
    {

        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));

        $jumlah = strip_tags($this->input->post('jumlah'));
        $id_item = strip_tags($this->input->post('id_item'));

        $getItem = $this->mitra->getwhere('t_item',array('id'=>$id_item));
        if($getItem['min_pesan'] > $jumlah ){
            $response = array('error'=>true,'title'=>'Update Gagal!','pesan'=>'Batas minimum pesanan untuk produk ini adalah '.$getItem['min_pesan'].' produk');
            echo json_encode($response);
            exit;
        }

        if($getItem['stok'] < $jumlah ){
            $response = array('error'=>true,'title'=>'Update Gagal!','pesan'=>'Batas maximum pesanan untuk produk ini adalah '.$getItem['stok'].' produk');
            echo json_encode($response);
            exit;
        }

        $getHarga = $this->db->get_where('t_item_harga',array('id_item'=>$id_item))->row_array();

        if (validation_edit_jumlah()) {
            $subTotal = $getHarga['harga_fix'] * $jumlah;
            $edit_jumlah = $this->mitra->update('t_catalog_cart', array('id_item'=>$id_item,'nm_catalog'=>$GetCatalog['nm_catalog']),array('qty' => $jumlah,'subtotal'=>$subTotal));
            if ($edit_jumlah) {
                $response = array('error'=>false,'title'=>'Success','pesan'=>'Jumlah Sudah Dirubah');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Update Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function catalog_checkout()
    {
        $this->load->helper('kurir_helper');

        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));

        $getIdItem = $this->mitra->getwhereCustom('t_catalog_cart','id_item,qty,subtotal',array('nm_catalog'=>$GetCatalog['nm_catalog']),1);

        if($getIdItem){
            $id_item = array();
            foreach ($getIdItem as $row) {
                $id_item[] = $row['id_item'];
                $qty[$row['id_item']] = $row['qty'];
                $subtotal[$row['id_item']] = $row['subtotal'];
            }
            $getItemOnCart = $this->catalog->getwherein('t_item',$id_item,1,false,'id_user');
            $this->data['data_item'] = $getItemOnCart;
            $this->data['id_item'] = $id_item;
            $this->data['qty'] = $qty;

            $this->data['subtotal'] = $subtotal;
            $this->data['nm_catalog'] = $GetCatalog['nm_catalog'];
        }else{
            show_404();
        }

        $this->data['data_provinsi'] = $this->mitra->get('r_provinsi',1);

        $this->data['main_view'] = 'content/catalog_checkout';
        $this->load->view('template', $this->data);

    }

    public function catalog_finish()
    {
        $this->load->helper('kurir_helper');
        $this->load->helper('email_helper');

        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));


        $kodeUnik = rand(100,999);
        $kodeUnikInvoice = rand(1000,9999);
        $kodeUnikTransaksi = rand(10000,99999);
        #generate invoice
        $prefix = "MSL-".date('ymd');
        $noInvoice = $prefix.$kodeUnikInvoice;
        #end

        #create id transaksi#
        $idTransaksi = $kodeUnikTransaksi.$id;
        #end create id transaksi#

        $getDataOnCart = $this->mitra->getwhere('t_catalog_cart',array('nm_catalog'=>$GetCatalog['nm_catalog']),1);

        if($getDataOnCart){

            $seller = array();

            $ongkir = array();
            $subtotal = array();
            foreach ($getDataOnCart as $row) {
                if($row['ongkir'] == ''){
                    echo"<script>alert('Mohon lengkapi alamat dan jasa pengiriman terlebih dahulu!');window.location.href='".base_url('mitra/catalog_checkout')."';</script>";
                    exit;
                }

                if(!in_array($row['id_seller'],$seller)){
                    $seller[] = $row['id_seller'];
                    $ongkir[] = $row['ongkir'];
                }


                $subtotal[] = $row['subtotal'];
            }
            $countSubtotal = array_sum($subtotal);
            $ongkirCount = array_sum($ongkir);
            $totalPembayaran = $countSubtotal + $ongkirCount + $kodeUnik;


            #batas waktu
            $batasWaktu=date("d-m-Y H:m:s", strtotime('+24 hours', time()));
            #end batas waktu


            $insertTransaksi = $this->mitra->create('t_transaksi',array('id'=>$idTransaksi,'nm_catalog'=>$GetCatalog['nm_catalog'],'kode_unik'=>$kodeUnik,'total_pembayaran'=>$totalPembayaran,'status'=>'1','batas_waktu'=>$batasWaktu));



            #noInvoiceForEmail
            $noInvoiceEmail = array();

            foreach($getDataOnCart as $row){

                #update stok
                    $getStokItem = $this->mitra->getwhere('t_item',array('id'=>$row['id_item']));
                    $countStok = $getStokItem['stok'] - $row['qty'];
                    $this->mitra->update('t_item',array('id'=>$row['id_item']),array('stok'=>$countStok));

                #end update stok
                $insertItemTransaksi = $this->mitra->create('t_transaksi_item',array('no_invoice'=>$noInvoice.$row['id_seller'],'id_transaksi'=>$idTransaksi,'id_seller'=>$row['id_seller'],'id_item'=>$row['id_item'],'qty'=>$row['qty'],'id_alamat'=>$row['id_alamat'],'tipe_kurir'=>$row['tipe_kurir'],'tipe_layanan'=>$row['tipe_layanan'],'ongkir'=>$row['ongkir'],'subtotal'=>$row['subtotal']));

                #Masterdata
                $getDataItem = $this->mitra->getwhere('t_item',array('id'=>$row['id_item']));
                $getDataHargaItem = $this->mitra->getwhere('t_item_harga',array('id_item'=>$row['id_item']));

                $inputMasterItem = $this->mitra->create('m_item', array('id'=>$getDataItem['id'],'id_transaksi'=>$idTransaksi,'id_user'=>$getDataItem['id_user'],'kat1' => $getDataItem['kat1'],'kat2' => $getDataItem['kat2'],'kat3' => $getDataItem['kat3'], 'nama' => $getDataItem['nama'],'deskripsi'=>$getDataItem['deskripsi'],'berat'=>$getDataItem['berat'],'stok'=>$getDataItem['stok'],'min_pesan'=>$getDataItem['min_pesan']));
                $inputMasterItemHarga = $this->mitra->create('m_item_harga', array('id_item' => $getDataItem['id'],'id_transaksi'=>$idTransaksi,'harga_seller'=>$getDataHargaItem['harga_seller'],'harga_coret'=>$getDataHargaItem['harga_coret'],'reseller_payment'=>$getDataHargaItem['reseller_payment'],'platform_payment'=>$getDataHargaItem['platform_payment'],'harga_fix'=>$getDataHargaItem['harga_fix']));

            }
            $deleteCatalogCart = $this->mitra->delete('t_catalog_cart',array('nm_catalog'=>$GetCatalog['nm_catalog']));

            if($insertTransaksi && $insertItemTransaksi && $deleteCatalogCart && $inputMasterItem && $inputMasterItemHarga){

                #kirim email
                error_reporting(0);
                $email = $this->session->userdata('email');

                $subject = "Info Tagihan Pembayaran Mitrareseller.com";
                $message = "Anda memiliki tagihan untuk nomor Transaksi <b>".$idTransaksi."</b> Sebesar :<br><h3> Rp.".number_format($totalPembayaran,0)."</h3><br><br>
                            Segera Lakukan pembayaran sebelum tanggal & jam <b>".$batasWaktu." </b><br>
                            Rekening Kami :<br>
                            <table>
                            <tr><th>Bank Mandiri</th><th>Bank BNI</th><th>Bank BCA</th><th>Bank BRI</th></tr>
                            <tr><td align='center'>a/n</td><td align='center'>a/n</td><td align='center'>a/n</td><td align='center'>a/n</td></tr>
                            <tr><td align='center'>Sendy Prasetyo</td><td align='center'>Sendy Prasetyo</td><td align='center'>Dede Irawan</td><td align='center'>Dede Irawan</td></tr>
                            <tr><td align='center'>1640002106054</td><td align='center'>0573489917</td><td align='center'>0710084513</td><td align='center'>762001003079536</td></tr>
                            </table>
                            <br><br>

                            Terimakasih atas kepercayaan anda.";

                $send = kirim_email($email,$subject,$message);
                if(!$send){
                    #kirim email gagal ke db
                    $this->mitra->create('m_email_monitoring',array('email'=>$email,'bug'=>$this->email->print_debugger()));
                }
                #end kirim email

                $this->data['total_pembayaran'] = $totalPembayaran;
                $this->data['batas_waktu'] = $batasWaktu;
                $this->data['main_view'] = 'content/catalog_finish';
                $this->load->view('template', $this->data);
            }
        }else{
            show_404();
        }

    }

    public function catalog_konfirmasi()
    {
        #Delete yang batas waktu pembayaranya habis
        $getBatasWaktu = $this->mitra->getwhere('t_transaksi',array('status'=>1),1);
        if($getBatasWaktu){
            foreach($getBatasWaktu as $row){
                $startdate = new DateTime($row['batas_waktu']);
                $today   = new DateTime();
                if($today >= $startdate){
                    $getDataItem = $this->mitra->getwhere('t_transaksi_item',array('id_transaksi'=>$row['id']),1);
                    if($getDataItem){
                        foreach($getDataItem as $data){
                            $getStok = $this->mitra->getwhere('t_item',array('id'=>$data['id_item']));
                            $countStok = $getStok['stok'] + $data['qty'];
                            $this->mitra->update('t_item',array('id'=>$data['id_item']),array('stok'=>$countStok));
                        }
                    }
                    $this->mitra->delete('t_transaksi',array('id'=>$row['id']));
                    $this->mitra->delete('t_transaksi_item',array('id_transaksi'=>$row['id']));
                }
            }
        }

        #end delete batas waktu

        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));
        $this->data['main_view'] = 'content/catalog_konfirmasi';

        $this->data['data'] = $this->mitra->getwhere('t_transaksi',array('nm_catalog'=>$GetCatalog['nm_catalog']),1);
        $this->load->view('template', $this->data);
    }

    public function catalog_pengiriman()
    {
        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));
        $this->data['main_view'] = 'content/catalog_pengiriman';
        $this->data['data'] = $this->mitra->getwhere('t_transaksi',array('nm_catalog'=>$GetCatalog['nm_catalog'],'status'=>3),1);
        $this->load->view('template', $this->data);
    }

    public function act_konfirmasi(){
        $id_transaksi = strip_tags($this->input->post('id_transaksi'));
        $nmBankPengirim = strip_tags($this->input->post('nama_bank_pengirim'));
        $nmRekeningPengirim = strip_tags($this->input->post('nama_rekening_pengirim'));
        $jmlTransfer = strip_tags($this->input->post('jml_transfer'));
        $noRekeningPengirim = strip_tags($this->input->post('nomor_rekening_pengirim'));
        $nmBankTujuan = strip_tags($this->input->post('nama_bank_tujuan'));

        if (validation_konfirmasi()) {
            $insertData = $this->mitra->create('t_transaksi_konfirmasi',array('id_transaksi'=>$id_transaksi,'nm_bank_pengirim'=>$nmBankPengirim,'nm_rek_pengirim'=>$nmRekeningPengirim,'no_rek_pengirim'=>$noRekeningPengirim,'jml_transfer'=>$jmlTransfer,'nm_bank_penerima'=>$nmBankTujuan));
            $updateData = $this->mitra->update('t_transaksi',array('id'=>$id_transaksi),array('status'=>2));
            if($insertData && $updateData){
                #generate kode unik untuk review catalog
                $getNoInvoice = $this->mitra->getwhere('t_transaksi_item',array('id_transaksi'=>$id_transaksi),1,false,'no_invoice');
                if($getNoInvoice){
                    $randomNomor = rand(90000,100000);
                    foreach($getNoInvoice as $row){
                        $this->mitra->create('t_catalog_review_code',array('no_invoice'=>$row['no_invoice'],'code'=>$randomNomor,'status'=>'true'));
                    }
                }

                #kirim email
                $this->load->helper('email_helper');
                error_reporting(0);
                $email = 'cs.mitrareseller@gmail.com';

                $subject = "Info Pembayaran Mitrareseller.com";
                $message = "Anda memiliki konfirmasi pembayaran dengan nomor transaksi <b> {$id_transaksi} </b> yang harus di proses, Segera check pada dahsboard anda.</br>
                            harap teliti dalam melakukan verifikasi, pastikan uang telah benar benar masuk pada rekening.
                            <br><br>
                            Tetap semangat dalam bertugas.";
                $send = kirim_email($email,$subject,$message);
                if(!$send){
                    #kirim email gagal ke db
                    $this->mitra->create('m_email_monitoring',array('email'=>$email,'bug'=>$this->email->print_debugger()));
                }
                #end kirim email

                $response = array('error'=>false,'title'=>'Konfirmasi Berhasil','pesan'=>'','link'=>base_url('mitra/catalog_konfirmasi'));
            }
        }else{
            $response = array('error'=>true,'title'=>'Konfirmasi Gagal!','pesan'=>strip_tags(validation_errors()));
        }
        echo json_encode($response);

    }

    public function act_konfirmasi_terima(){
        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));


        $no_invoice = strip_tags($this->input->post('id'));
        $getIdTransaksi = $this->mitra->getwhere('t_transaksi_item',array('no_invoice'=>$no_invoice));
        $id_transaksi = $getIdTransaksi['id_transaksi'];
        $cekKepemilikanTransaksi = $this->db->get_where('t_transaksi',array('id'=>$id_transaksi,'nm_catalog'=>$GetCatalog['nm_catalog']))->num_rows();
        if ($cekKepemilikanTransaksi >  0) {

        #jika barang ditolak
        if($getIdTransaksi['no_resi'] == '0'){
            $getDataTransaksi = $this->mitra->getwhere('t_transaksi',array('id'=>$id_transaksi));
            $getDataTransaksiItem = $this->mitra->getwhere('t_transaksi_item',array('no_invoice'=>$no_invoice),1);

            $insertDataTransaksiFailed = $this->mitra->create('t_transaksi_failed',array('id'=>$getDataTransaksi['id'],'nm_catalog'=>$getDataTransaksi['nm_catalog'],'kode_unik'=>$getDataTransaksi['kode_unik'],'total_pembayaran'=>$getDataTransaksi['total_pembayaran'],'batas_waktu'=>$getDataTransaksi['batas_waktu'],'status'=>$getDataTransaksi['status'],'payment_reseller'=>1,'created'=>$getDataTransaksi['created']));
            if($getDataTransaksiItem){
                foreach($getDataTransaksiItem as $row){
                    $insertDataTransaksiItemFailed = $this->mitra->create('t_transaksi_item_failed',array('id'=>$row['id'],'no_invoice'=>$row['no_invoice'],'id_transaksi'=>$row['id_transaksi'],'id_item'=>$row['id_item'],'id_seller'=>$row['id_seller'],'qty'=>$row['qty'],'id_alamat'=>$row['id_alamat'],'tipe_kurir'=>$row['tipe_kurir'],'tipe_layanan'=>$row['tipe_layanan'],'ongkir'=>$row['ongkir'],'subtotal'=>$row['subtotal'],'no_resi'=>$row['no_resi'],'status'=>$row['status'],'created'=>$row['created']));
                }
            }

            $cekTotalInvoice = $this->db->get_where('t_transaksi_item',array('id_transaksi'=>$id_transaksi,'no_invoice <>'=>$no_invoice))->num_rows();
            if($cekTotalInvoice > 0){

                $this->mitra->delete('t_transaksi_item',array('no_invoice'=>$no_invoice));

                $cekAllItem = $this->db->get_where('t_transaksi_item',array('id_transaksi'=>$id_transaksi,'status <'=>2))->num_rows();
                if($cekAllItem == 0){
                    $this->mitra->update('t_transaksi',array('id'=>$id_transaksi),array('status'=>4));
                }

                if($insertDataTransaksiFailed && $insertDataTransaksiItemFailed){
                    $response = array('error'=>false,'title'=>'Konfirmasi Berhasil','pesan'=>'','link'=>base_url('mitra/catalog_pengiriman'));
                    echo json_encode($response);
                }
            }else{
                $this->mitra->delete('t_transaksi',array('id'=>$id_transaksi));
                $this->mitra->delete('t_transaksi_item',array('id_transaksi'=>$id_transaksi));

                if($insertDataTransaksiFailed && $insertDataTransaksiItemFailed){
                    $response = array('error'=>false,'title'=>'Konfirmasi Berhasil','pesan'=>'','link'=>base_url('mitra/catalog_pengiriman'));
                    echo json_encode($response);
                }
            }
        }else{
                $updateData = $this->mitra->update('t_transaksi_item',array('no_invoice'=>$no_invoice),array('status'=>2));
                $cekAllItem = $this->db->get_where('t_transaksi_item',array('id_transaksi'=>$id_transaksi,'status'=>1))->num_rows();
                if($updateData){
                    if($cekAllItem == 0){
                        $this->mitra->update('t_transaksi',array('id'=>$id_transaksi),array('status'=>4));
                    }

                    #Send Email Confirm
                    $getEmailSeller = $this->mitra->getwhere('m_user',array('id'=>$getIdTransaksi['id_seller']));
                    #kirim email
                    $this->load->helper('email_helper');
                    error_reporting(0);
                    $email = 'cs.mitrareseller@gmail.com';
                    $subject = "Info Penerimaan Barang Mitrareseller.com";
                    $message = "Barang anda dengan Nomor Invoice <b> {$no_invoice} </b> telah diterima reseller.
                                <br><br>
                                Terimakasih atas kerjasama anda.";
                    $send = kirim_email($getEmailSeller['email'],$subject,$message);
                    if(!$send){
                        #kirim email gagal ke db
                        $this->mitra->create('m_email_monitoring',array('email'=>$getEmailSeller['email'],'bug'=>$this->email->print_debugger()));
                    }
                    #end kirim email

                    $response = array('error'=>false,'title'=>'Konfirmasi Berhasil','pesan'=>'','link'=>base_url('mitra/catalog_pengiriman'));
                    echo json_encode($response);
                }
            }

        }else{
            $response = array('error'=>true,'title'=>'Konfirmasi Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }

    }

    public function daftar_transaksi()
    {
        $id = $this->session->userdata('id');
        #cek rekening
        $cekRekening = $this->mitra->getwhere('m_user',array('id'=>$id));
        if($cekRekening['rek'] == null && $cekRekening['rek'] == null){
            echo"<script>alert('Mohon lengkapi data rekening anda!');window.location.href='".base_url('mitra')."'</script>";
            exit;
        }

        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));
        $this->data['main_view'] = 'content/daftar_transaksi';

        $this->data['data'] = $this->mitra->getwhere('t_transaksi',array('nm_catalog'=>$GetCatalog['nm_catalog'],'status'=>4,'payment_reseller'=>null),1);
        $this->load->view('template', $this->data);
    }

    public function daftarTransaksiRefund()
    {
        $id = $this->session->userdata('id');
        #cek rekening
        $cekRekening = $this->mitra->getwhere('m_user',array('id'=>$id));
        if($cekRekening['rek'] == null && $cekRekening['rek'] == null){
            echo"<script>alert('Mohon lengkapi data rekening anda!');window.location.href='".base_url('mitra')."'</script>";
            exit;
        }

        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));
        $this->data['main_view'] = 'content/daftar_transaksi_refund';

        $this->data['data'] = $this->mitra->getwhere('t_transaksi_failed',array('nm_catalog'=>$GetCatalog['nm_catalog']),1,false,'id');
        $this->load->view('template', $this->data);
    }

    public function histTransfer()
    {
        $id = $this->session->userdata('id');

        $this->data['main_view'] = 'content/hist_transfer';
        $this->data['data'] = $this->mitra->getwhere('m_payment',array('id_user'=>$id,'role'=>'reseller','payment_refund'=>'0'),1,false,false,array('param'=>'id','by'=>'desc'));
        $this->load->view('template', $this->data);
    }

    public function histTransferRefund()
    {
        $id = $this->session->userdata('id');

        $this->data['main_view'] = 'content/hist_transfer_refund';
        $this->data['data'] = $this->mitra->getwhere('m_payment',array('id_user'=>$id,'role'=>'reseller','payment_refund'=>'1'),1,false,false,array('param'=>'id','by'=>'desc'));
        $this->load->view('template', $this->data);
    }



    public function getDataAlamat()
    {
        $id = strip_tags($this->session->userdata('id'));
        $getAlamat = $this->mitra->getwhere('r_reseller_alamat',array('id_user'=>$id),1,false,false,array('param'=>'id','by'=>'desc'));


        echo "<option value=''>pilih</option>";
        if($getAlamat){
            foreach($getAlamat as $row){
                echo "<option value='".$row['id']."'>".'('.$row['nama'].') '.$row['alamat']."</option>";
            }
        }
    }

    public function getKabupaten()
    {
        $id = strip_tags($this->input->post('id'));
        $html = '';
        if(empty($id)){
            echo $html;
        }else {
            $getKabupaten = $this->mitra->getwhere('r_kabupaten', array('id_prov' => $id),1);

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
            $getKecamatan = $this->mitra->getwhere('r_kecamatan', array('id_kabupaten' => $id),1);

            if($getKecamatan){
                foreach($getKecamatan as $row){
                    echo "<option value='".$row['nama']."'>".$row['nama']."</option>";
                }
            }
        }

    }

    public function getAlamat()
    {
        $id = strip_tags($this->input->post('select_alamat'));

        $id_user = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id_user));
        $updateAlamatCart = $this->mitra->update('t_catalog_cart', array('nm_catalog' => $GetCatalog['nm_catalog']),array('id_alamat'=>$id));

        $html = '';
        if(empty($id)){
            echo $html;
        }else if($updateAlamatCart){
            $getAlamat = $this->mitra->getwhere('r_reseller_alamat', array('id' => $id));
            $getProv = $this->mitra->getwhere('r_provinsi', array('id' => $getAlamat['provinsi']));
            $getKab = $this->mitra->getwhere('r_kabupaten', array('id' => $getAlamat['kabupaten']));
            $this->data['data_alamat'] = $getAlamat;
            $html .= "<b>" . strtoupper($getAlamat['nama']) . "</b><br>" . $getAlamat['alamat'] . "<br>" . "Kecamatan " . $getAlamat['kecamatan'] . ", Kota/Kabupaten " . $getKab['nama'] . "<br>Provinsi " . $getProv['nama'] . ", " . $getAlamat['kd_pos'] . "<br> Phone : " . $getAlamat['phone'];
            $html .= "<div style='float: right;'>";
            $html .= "<a href='#' class='delete_alamat' data-id='".$getAlamat['id']."' style='color: #3e4d5c;'> <i class='fa fa-trash fa-1x'> HAPUS</i></a></div>";
            echo $html;
        }

    }

    public function getPos()
    {
        $kecamatan = strip_tags($this->input->post('kecamatan'));

        $html = '';
        if(empty($kecamatan)){
            echo $html;
        }else{
            $getKdPos = $this->mitra->getwhere('r_kodepos', array('kecamatan' => $kecamatan),1);
            if($getKdPos){
                foreach($getKdPos as $row){
                    echo "<option value='".$row['kodepos']."'>".$row['kodepos']."</option>";
                }
            }
        }

    }

    public function selectKurir()
    {
        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));

        $id_tmp = $this->input->post('id_tmp');
        $id_tipe_kurir = $this->input->post('cek_tipe_'.$id_tmp);
        $id_jenis_layanan = $this->input->post('select_kurir_'.$id_tmp);


        $cekAlamatOnCart = $this->mitra->getwhere('t_catalog_cart',array('nm_catalog' => $GetCatalog['nm_catalog']));
        if($cekAlamatOnCart['id_alamat'] == ''){
            echo"<script>alert('Mohon isi alamat terlebih dahulu')</script>";
            exit;
        }
        $getAlamatAsal = $this->mitra->getwhere('r_reseller_alamat',array('id' => $cekAlamatOnCart['id_alamat']));
        $getAlamatTujuan = $this->mitra->getwhere('r_seller_alamat',array('id_user' => $id_tmp));



        $getIdItem = $this->mitra->getwhere('t_item',array('id_user'=>$id_tmp),1);
        $in = array();
        foreach ($getIdItem as $row) {
            $in[] = $row['id'];
        }

        $updateKurir = $this->db->where('nm_catalog',$GetCatalog['nm_catalog'])->where_in('id_item', $in)->update('t_catalog_cart', array('tipe_kurir'=>$id_tipe_kurir));
        $getIdItemOnCart = $this->db->where('nm_catalog',$GetCatalog['nm_catalog'])->where_in('id_item', $in)->get('t_catalog_cart')->result_array();
        $berat = array();

        if($getIdItemOnCart){
            foreach($getIdItemOnCart as $row){
                $getDataItem = $this->mitra->getwhere('t_item',array('id' => $row['id_item']));
                $countBerat = $row['qty'] * $getDataItem['berat'];
                $berat[] = $countBerat;
            }
        }

        $beratOnGram = array_sum($berat) / 1000;
        $beratOnKgDecimal = number_format($beratOnGram,0);
        if($beratOnKgDecimal < 1){
            $beratOnKgDecimalfix = 1;
        }else{
            $beratOnKgDecimalfix = $beratOnKgDecimal;
        }


        if($updateKurir) {
            $this->load->helper('kurir_helper');
            cekHarga($id_tipe_kurir,$beratOnKgDecimalfix,$getAlamatAsal['kabupaten'],$getAlamatTujuan['kabupaten']);
        }else{
            echo "Maaf terjadi kesalahan...";
        }
    }

    public function selectLayanan()
    {
        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));

        $id_tmp = $this->input->post('id_tmp');
        //$id_tipe_kurir = $this->input->post('cek_tipe_'.$id_tmp);
        $id_jenis_layanan = $this->input->post('select_kurir_'.$id_tmp);

        $getIdItem = $this->mitra->getwhere('t_item',array('id_user'=>$id_tmp),1);
        $in = array();
        foreach ($getIdItem as $row) {
            $in[] = $row['id'];
        }



        $jenis_layanan = explode("|", $id_jenis_layanan);

        $updateKurir = $this->db->where('nm_catalog',$GetCatalog['nm_catalog'])->where_in('id_item', $in)->update('t_catalog_cart', array('tipe_layanan'=>$jenis_layanan[1]));
        $updateOngkir = $this->db->where('nm_catalog',$GetCatalog['nm_catalog'])->where_in('id_item', $in)->update('t_catalog_cart', array('ongkir'=>$jenis_layanan[0]));

        $getIdItemOnCart = $this->db->where('nm_catalog',$GetCatalog['nm_catalog'])->where_in('id_item', $in)->get('t_catalog_cart')->result_array();
        $hargaBarang = array();

        if($getIdItemOnCart){
            foreach($getIdItemOnCart as $row){
                $hargaBarang[] = $row['subtotal'];
            }
        }

        $hargaBarangFix = array_sum($hargaBarang);
        $Total = $hargaBarangFix + $jenis_layanan[0];

        $html='';
        $html .="<table align='right'>
                  <tr>
                      <td><p>Harga Barang</p></td><td><font style='float: right'><p style='margin-left: 15px;'> Rp.".number_format($hargaBarangFix,0)." </p></font></td>
                  </tr>
                   <tr>
                        <td><p>Biaya Kirim</p></td><td><font style='float: right'><p>Rp. ".number_format($jenis_layanan[0],0)."</p></font></td>
                    </tr>
                    <tr>
                    <td><p>Sub Total</p></td><td><font style='float: right'><p><b style='font-size: 15px;'> Rp.".number_format($Total,0)." </b></p></font></td>
                   </tr>
                </table>";

        if($updateKurir && $updateOngkir){
            echo $html;
        }else{
            echo"Maaf terjadi kesalahan pada server";
        }


    }

    public function act_tambah_alamat()
    {
        $id = $this->session->userdata('id');
        $nama = strip_tags($this->input->post('nama'));
        $phone = strip_tags($this->input->post('phone'));
        $alamat = strip_tags($this->input->post('alamat'));
        $kec = strip_tags($this->input->post('kecamatan'));
        $kab = strip_tags($this->input->post('kabupaten'));
        $prov = strip_tags($this->input->post('provinsi'));
        $kdPosDef = strip_tags($this->input->post('kd_pos_def'));
        $kdPosTam = strip_tags($this->input->post('kd_pos_tam'));

        if(!empty($kdPosTam)){
            $kdPos = $kdPosTam;
        }else{
            $kdPos = $kdPosDef;
        }
        if(empty($kdPos)){
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>'Kode pos tidak boleh kosong');
            echo json_encode($response);
        }

        $getNmKab = $this->mitra->getwhere('r_kabupaten',array('id'=>$kab));
        $getNmProv = $this->mitra->getwhere('r_provinsi',array('id'=>$prov));

        if (validation_TambahAlamat()) {
            $add_review = $this->catalog->create('r_reseller_alamat', array('id_user'=>$id,'nama' => $nama,'phone'=>$phone,'alamat' => $alamat,'provinsi' => $getNmProv['id'],'kabupaten'=>$getNmKab['id'],'kecamatan'=>$kec,'kd_pos'=>$kdPos));
            if ($add_review) {
                $response = array('error'=>false,'title'=>'Success','pesan'=>'Alamat Berhasil ditambah');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

//    public function sendEmail()
//    {
//        $this->load->helper('email_helper');
//                $email = "dede.irawan1213@gmail.com";
//                #Send Email Confirm
//                error_reporting(0);
//                $subject = "Info Registrasi MitraReseller.com";
//                $message = "tester";
//                $send = kirim_email($email, $subject, $message);
//                if (!$send) {
//                    #kirim email gagal ke db
//                    $this->main->create('m_email_monitoring', array('email' => $email, 'bug' => $this->email->print_debugger()));
//                }
//
//
//    }

    //  +++++++++++++++++++++++++ Function cetak invoice +++++++++++++++++++++++++++++
    public function cetak($noInvoice = false)
    {
        if(!$noInvoice){
            show_404();
        }

        $getData = $this->mitra->getwhere('t_transaksi_item',array('no_invoice'=>$noInvoice));
        $getDataTransaksi = $this->mitra->getwhere('t_transaksi',array('id'=>$getData['id_transaksi']));
        $getIdUser = $this->mitra->getwhere('t_catalog',array('nm_catalog'=>$getDataTransaksi['nm_catalog']));
        $getDataUser = $this->mitra->getwhere('m_user',array('id'=>$getIdUser['id_user']));

        if($getData) {
            $this->data['nama_reseller'] = $getDataUser['name'];
            $this->data['data_transaksi_item'] = $getData;
            $this->data['data_transaksi'] = $getDataTransaksi;
            $this->data['data'] = $this->mitra->getwhere('t_transaksi_item', array('no_invoice' => $noInvoice), 1);
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

        $getData = $this->mitra->getwhere('m_transaksi_item',array('no_invoice'=>$noInvoice));
        $getDataTransaksi = $this->mitra->getwhere('m_transaksi',array('id'=>$getData['id_transaksi']));
        $getIdUser = $this->mitra->getwhere('t_catalog',array('nm_catalog'=>$getDataTransaksi['nm_catalog']));
        $getDataUser = $this->mitra->getwhere('m_user',array('id'=>$getIdUser['id_user']));

        if($getData) {
            $this->data['nama_reseller'] = $getDataUser['name'];
            $this->data['data_transaksi_item'] = $getData;
            $this->data['data_transaksi'] = $getDataTransaksi;
            $this->data['data'] = $this->mitra->getwhere('m_transaksi_item', array('no_invoice' => $noInvoice), 1);
            $this->load->view('content/cetak', $this->data);
        }else{
            show_404();
        }
    }

    public function cetakHistoryRefund($noInvoice = false)
    {
        if(!$noInvoice){
            show_404();
        }

        $getData = $this->mitra->getwhere('m_transaksi_item_failed',array('no_invoice'=>$noInvoice));
        $getDataTransaksi = $this->mitra->getwhere('m_transaksi_failed',array('id'=>$getData['id_transaksi']));
        $getIdUser = $this->mitra->getwhere('t_catalog',array('nm_catalog'=>$getDataTransaksi['nm_catalog']));
        $getDataUser = $this->mitra->getwhere('m_user',array('id'=>$getIdUser['id_user']));

        if($getData) {
            $this->data['nama_reseller'] = $getDataUser['name'];
            $this->data['data_transaksi_item'] = $getData;
            $this->data['data_transaksi'] = $getDataTransaksi;

            $this->data['data'] = $this->mitra->getwhere('m_transaksi_item_failed', array('no_invoice' => $noInvoice), 1);
            $this->load->view('content/cetak', $this->data);
        }else{
            show_404();
        }
    }

    public function cetakDaftarRefund($noInvoice = false)
    {
        if(!$noInvoice){
            show_404();
        }

        $getData = $this->mitra->getwhere('t_transaksi_item_failed',array('no_invoice'=>$noInvoice));
        $getDataTransaksi = $this->mitra->getwhere('t_transaksi_failed',array('id'=>$getData['id_transaksi']));
        $getIdUser = $this->mitra->getwhere('t_catalog',array('nm_catalog'=>$getDataTransaksi['nm_catalog']));
        $getDataUser = $this->mitra->getwhere('m_user',array('id'=>$getIdUser['id_user']));


        if($getData) {
            $this->data['nama_reseller'] = $getDataUser['name'];
            $this->data['data_transaksi_item'] = $getData;
            $this->data['data_transaksi'] = $getDataTransaksi;
            $this->data['data'] = $this->mitra->getwhere('t_transaksi_item_failed', array('no_invoice' => $noInvoice), 1);
            $this->load->view('content/cetak', $this->data);
        }else{
            show_404();
        }
    }



    //  +++++++++++++++++++++++++ Function DELETE +++++++++++++++++++++++++++++
    public function deleteItemCatalog($idItem = false, $nmCatalog = false)
    {
        $idItemClean = strip_tags($idItem);
        $nmCatalogClean = strip_tags($nmCatalog);

        $delete = $this->mitra->delete('t_catalog_item',array('id_item'=>$idItemClean,'nm_catalog'=>$nmCatalogClean));

        if ($delete) {
            echo"<script>alert('Hapus Berhasil!');window.location.href='".base_url('mitra/catalog/'.$nmCatalogClean)."'</script>";
        }else{
            echo"<script>alert('Hapus Gagal!');window.location.href='".base_url('mitra/catalog/'.$nmCatalogClean)."'</script>";
        }
    }

    public function deleteCart($id_cart = false)
    {
        $id = $this->session->userdata('id');
        $GetCatalog = $this->mitra->getwhere('t_catalog',array('id_user'=>$id));
        $GetDataCatalogCart = $this->mitra->getwhere('t_catalog_cart',array('id'=>$id_cart));

        if($GetDataCatalogCart){
            if($GetCatalog['nm_catalog'] == $GetDataCatalogCart['nm_catalog']){
                $delete = $this->mitra->delete('t_catalog_cart',array('id'=>$id_cart));
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

    public function deleteAlamat($idAlamat = false)
    {
        $id = $this->session->userdata('id');
        $GetDataAlamat = $this->mitra->getwhere('r_reseller_alamat',array('id'=>$idAlamat));

        if($GetDataAlamat){
            if($GetDataAlamat['id_user'] == $id){
                $delete = $this->mitra->delete('r_reseller_alamat',array('id'=>$idAlamat));
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


}