<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Catalog extends CI_Controller
{
	public $data = array('title' => 'catalog Reseller | Mau Jadi Reseller Tanpa Modal?Kami Punya Solusinya',
						 'main_view' => 'content/home');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('catalog_model','catalog');
        $this->load->library(array('ajax_pagination','datatables'));
        $this->load->helper(array('role_form_helper','xss_helper','filepath_helper'));
	}


    public function item($nm_catalog = false){
        #protect category
        if($nm_catalog == false){
            show_404();
        }else{
            $nm_catalog_clean = strip_tags($nm_catalog);
        }

        $getID = $this->catalog->getwhere('t_catalog_item',array('nm_catalog'=>$nm_catalog_clean),1);
        if($getID){
            foreach($getID as $row){

                 $id_item[] =  $row['id_item'];
                 }
        }else{
            show_404();
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
            $this->data['main_view'] = 'content/item';
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

    function item_filter(){

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
        $config['base_url']    = base_url('catalog/item_filter');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $per_page;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get posts data
        $this->data['data'] = $this->catalog->getlikejoinin('t_item','t_item_harga',false,'id','id_item',false,$id_item,array('param'=>'nama','value'=>$keywords),array('limit'=>$per_page,'start'=>$offset),false,array('param'=>'id','by'=>$sortBy));

        $this->data['halaman'] = $this->ajax_pagination->create_links();

        //load the view
        $this->data['nm_catalog'] = $nm_catalog_clean;
        $this->load->view('content/item_filter', $this->data, false);
    }

    public function autocomplete_item($nm_catalog = false)
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


    public function item_detail($nm_catalog = false,$id = false)
    {
        #protect category
        if($nm_catalog == false && $id == false){
            show_404();
        }else{
            $nm_catalog_clean = strip_tags($nm_catalog);
        }

        $nm_catalog_clean = strip_tags($nm_catalog);
        $id_clean = strip_tags($id);

        $getID = $this->catalog->getwhere('t_catalog_item',array('nm_catalog'=>$nm_catalog_clean),1);
        if($getID){
            foreach($getID as $row){
                $id_item[] =  $row['id_item'];
            }
        }else{
            show_404();
        }

        $getIdUser = $this->catalog->getwhere('t_catalog',array('nm_catalog'=>$nm_catalog_clean));
        $getProfile = $this->catalog->getwhere('m_user',array('id'=>$getIdUser['id_user']));
        $catalog_review = $this->catalog->getwhereCustom('t_catalog_review','AVG(rate) rate_avg',array('nm_catalog'=>$nm_catalog_clean));


        $item = $this->catalog->getwhere('t_item',array('id'=>$id_clean));
        $item_harga = $this->catalog->getwhere('t_item_harga',array('id_item'=>$id_clean));
        $item_images_big = $this->catalog->getwhere('t_item_images',array('id_item'=>$id_clean));
        $item_images = $this->catalog->getwhere('t_item_images',array('id_item'=>$id_clean),1);
        $item_review = $this->catalog->getwhereCustom('t_item_review','AVG(rate) rate_avg',array('id_item'=>$id_clean));

        if($item && $item_harga && $item_images) {
            $this->data['main_view'] = 'content/item_detail';
            $this->data['item'] = $item;
            $this->data['item_harga'] = $item_harga;
            $this->data['item_images'] = $item_images;
            $this->data['item_images_big'] = $item_images_big;
            $this->data['item_review'] = $item_review;

            $this->data['nm_catalog'] = $nm_catalog_clean;
            $this->data['catalog_data'] = $getIdUser;
            $this->data['catalog_review'] = $catalog_review;
            $this->data['data_profile'] = $getProfile;
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
    }

    public function act_add_review()
    {
        $kode = strip_tags($this->input->post('kode'));
        $nm_catalog = strip_tags($this->input->post('nm_catalog'));
        $name = strip_tags($this->input->post('name'));
        $rate = strip_tags($this->input->post('backing5'));
        $review = strip_tags($this->input->post('review'));

        $cek_kode = $this->catalog->getwhere('t_catalog_review_code',array('code'=>$kode,'status'=>'true'));
        if(!$cek_kode){
            $response = array('error'=>true,'title'=>'Kode Salah!','pesan'=>'Periksa kembali kode yang terdapat di invoice anda.');
            echo json_encode($response);
            exit;
        }

        if($nm_catalog == $name){
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>'Maaf Nama tidak dapat digunakan!');
            echo json_encode($response);
            exit;
        }

        if (validation_add_review()) {
            $add_review = $this->catalog->create('t_catalog_review', array('nm_catalog'=>$nm_catalog,'name' => $name, 'review' => $review,'rate' => $rate));
            if ($add_review) {
                $update_code = $this->catalog->update('t_catalog_review_code',array('code'=>$kode),array('status'=>'false'));
                $response = array('error'=>false,'title'=>'Success','pesan'=>'Terimakasih Telah Mengisi Review Untuk '.$nm_catalog);
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

        $this->load->view('content/item_review', $this->data, false);
    }
	
}