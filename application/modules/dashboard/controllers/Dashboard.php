<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Dashboard extends My_Controller
{

    public $data = array(
        'title' => 'Dpanel Version 3.0',
        'main_view' => 'content/home',
        'page_title' => '',
    );

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('dashboard_model','dashboard');
        $this->load->helper(array('role_form_helper','xss_helper'));
        $this->load->library('datatables');
        $this->cekLoginAdmin();
    }

    #+++++++++++++++++++++++++++++ CORE Content To Next Project ++++++++++++++++++++++++++#
    public function index()
    {
        $this->load->view('template_home', $this->data);
    }

    public function user()
    {
        $this->data['page_title'] = 'Manage User';
        $this->data['main_view'] = 'content/user';
        $this->data['data'] = $this->dashboard->getwhere('m_admin',array('email'=>$this->session->userdata('email')));
        $this->load->view('template_content', $this->data);
    }
    public function edit_user()
    {

        $this->data['page_title'] = 'Manage User';
        $this->data['main_view'] = 'form/edit_user';
        $this->data['data'] = $this->dashboard->getwhere('m_admin',array('email'=>$this->session->userdata('email')));
        $this->load->view('template_content', $this->data);
    }

    public function act_edit_user()
    {
        $id = strip_tags($this->input->post('id'));
        $email = strip_tags($this->input->post('email'));
        $pass = strip_tags(hash('sha256',$this->input->post('password')));


        if (validation_edit_admin()) {
            $update_user = $this->dashboard->update('m_admin', array('id' => $id), array('email' => $email, 'password' => $pass));
            if ($update_user) {
                $response = array('error'=>false,'title'=>'Update Berhasil','pesan'=>'');
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Update Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }
    }

    public function paymentPlatform()
    {

        $this->data['page_title'] = 'Manage Payment Platform';
        $this->data['main_view'] = 'form/edit_payment_platform';
        $this->data['data'] = $this->dashboard->get('r_platform_payment');
        $this->load->view('template_content', $this->data);
    }

    public function act_paymentPlatform()
    {
        $paymentPresentase = strip_tags($this->input->post('presentase_payment'));

            $update_user = $this->dashboard->update('r_platform_payment', array('id' => '1'), array('payment_presentase' => $paymentPresentase));
            if ($update_user) {
                echo "<script>alert('Presentase Payment Berhasil Dirubah');window.location.href= '".base_url('dashboard/paymentPlatform')."'</script>";
            }else{
                echo "<script>alert('Presentase Payment Gagal Dirubah');window.location.href= '".base_url('dashboard/paymentPlatform')."'</script>";
            }

    }

    public function memberMitrareseller()
    {
        $this->data['page_title'] = 'Manage Member Mitrareseller.com';
        $this->data['main_view'] = 'content/member';
        $this->data['data'] = $this->dashboard->get('m_user',1,false,false,array('param'=>'id','by'=>'DESC'));
        $this->load->view('template_content', $this->data);
    }

    public function resetPasswordMember($idMember)
    {
        $idMember = strip_tags($idMember);

        $length = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $genPass = $randomString;
        $genPassEncrypt = hash('sha256',$genPass);

        $update_user = $this->dashboard->update('m_user', array('id' => $idMember), array('password' => $genPassEncrypt));
        if ($update_user) {
            #kirim email
            $this->load->helper('email_helper');
            error_reporting(0);

            $getEmailSeller = $this->dashboard->getwhere('m_user',array('id'=>$idMember));
            $subject = "Reset Password Akun Mitrareseller.com";
            $message = "Berikut adalah password baru anda <b>".$genPass."</b>
                            Jaga baik-baik akun anda jangan sampai disalahgunakan oleh orang yang tidak bertanggung jawab .</b>

                            <br><br>

                            Terimakasih atas kerjasama anda.";

            $send = kirim_email($getEmailSeller['email'],$subject,$message);

            if(!$send){
                #kirim email gagal ke db
                $this->dashboard->create('m_email_monitoring',array('email'=>$getEmailSeller['email'],'bug'=>$this->email->print_debugger()));
            }
            #end kirim email
            echo "<script>alert('Password Berhasil Direset');window.location.href= '".base_url('dashboard/memberMitrareseller')."'</script>";
        }else{
            echo "<script>alert('Password Gagal Direset');window.location.href= '".base_url('dashboard/memberMitrareseller')."'</script>";
        }

    }

    public function changeRole($idMember)
    {
        $idMember = strip_tags($idMember);

        $update_user = $this->dashboard->update('m_user', array('id' => $idMember), array('role_id' => '2'));
        if ($update_user) {
            #kirim email
            $this->load->helper('email_helper');
            error_reporting(0);

            $getEmailSeller = $this->dashboard->getwhere('m_user',array('id'=>$idMember));
            $subject = "Info Afilliate Akun Mitrareseller.com";
            $message = "Admin telah menjadikan akun anda ber Afilliate dengan kami, jadilah Seller yang memiliki integritas yang baik.
                            <br><br>

                            Terimakasih atas kerjasama anda.";

            $send = kirim_email($getEmailSeller['email'],$subject,$message);

            if(!$send){
                #kirim email gagal ke db
                $this->dashboard->create('m_email_monitoring',array('email'=>$getEmailSeller['email'],'bug'=>$this->email->print_debugger()));
            }
            #end kirim email
            echo "<script>alert('Role Berhasil Dirubah');window.location.href= '".base_url('dashboard/memberMitrareseller')."'</script>";
        }else{
            echo "<script>alert('Role Gagal Dirubah');window.location.href= '".base_url('dashboard/memberMitrareseller')."'</script>";
        }

    }

    public function catalogMember()
    {
        $this->data['page_title'] = 'Manage Catalog Member';
        $this->data['main_view'] = 'content/catalog_member';
        $this->data['data'] = $this->dashboard->get('t_catalog',1);
        $this->load->view('template_content', $this->data);
    }

    public function editCatalogMember($nm_catalog)
    {

        $this->data['page_title'] = 'Manage Catalog Member';
        $this->data['main_view'] = 'form/edit_catalog';
        $this->data['data'] = $this->dashboard->getwhere('t_catalog',array('nm_catalog'=>$nm_catalog));
        $this->load->view('template_content', $this->data);
    }

    public function act_editCatalog()
    {
        $nm_catalog = strip_tags($this->input->post('nm_catalog'));
        $level = strip_tags($this->input->post('level'));

        if($level == 'gold'){
            $hargaPoint = 1000;
        }elseif($level == 'platinum'){
            $hargaPoint = 2000;
        }else{
            $hargaPoint = 0;
        }

        $getIdUser = $this->dashboard->getwhere('t_catalog',array('nm_catalog'=>$nm_catalog));
        $getPoint = $this->dashboard->getwhereCustom2('t_point','point',array('id_user'=>$getIdUser['id_user']));

        if($getIdUser['level'] == $level){
            echo "<script>alert('Sudah berada pada level yang diinginkan!');window.location.href= '".base_url('dashboard/catalogMember')."'</script>";
            exit;
        }

        if($getPoint){
            if($getPoint['point'] < $hargaPoint){
                echo "<script>alert('Point member tidak cukup Min = {$hargaPoint} Point');window.location.href= '".base_url('dashboard/catalogMember')."'</script>";
                exit;
            }else{
                $kurangPoint = $getPoint['point'] - $hargaPoint;
                $this->dashboard->update('t_point',array('id_user'=>$getIdUser['id_user']),array('point'=>$kurangPoint));
            }
        }else{
            echo "<script>alert('Point member tidak cukup Min = {$hargaPoint} Point');window.location.href= '".base_url('dashboard/catalogMember')."'</script>";
            exit;
        }



        $update_user = $this->dashboard->update('t_catalog', array('nm_catalog' => $nm_catalog), array('level' => $level));
        if ($update_user) {
            echo "<script>alert('Edit Catalog Berhasil Dirubah');window.location.href= '".base_url('dashboard/catalogMember')."'</script>";
        }else{
            echo "<script>alert('Edit Catalog Gagal Dirubah');window.location.href= '".base_url('dashboard/catalogMember')."'</script>";
        }
    }

    public function about($cat)
    {
        if($cat == 1){
            $title = 'Tentang Kami';
        }elseif($cat == 2){
            $title = 'Membership';
        }elseif($cat == 3){
            $title = 'Syarat & Ketentuan';
        }elseif($cat == 4){
            $title = 'Kebijakan Privasi';
        }else{
            show_404();
        }

        $this->data['category'] = $cat;
        $this->data['page_title'] = 'Manage '.$title;
        $this->data['main_view'] = 'content/about';
        $this->load->view('template_content', $this->data);
    }

    function load_tb_about($cat) {
        header('Content-Type: application/json');
        echo $this->dashboard->load_tb_about($cat);
    }

    public function add_about($cat = false)
    {
        //protect function from error
        $cat == 1 or $cat == 2 or $cat == 3 or $cat == 4 ?true: show_404();

        $this->data['category'] = $cat;
        $this->data['page_title'] = 'Manage About';
        $this->data['main_view'] = 'form/add_about';
        $this->load->view('template_content', $this->data);
    }

    public function act_add_about()
    {
        $category = strip_tags($this->input->post('category'));
        $title = strip_tags($this->input->post('title'));
        $description = $this->input->post('description');


        if (validation_add_about()) {
            $add_about = $this->dashboard->create('t_about', array('category' => $category, 'title' => $title,'description' => $description));
            if ($add_about) {
                $response = array('error'=>false,'title'=>'Add Berhasil','pesan'=>'','category'=>$category);
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>strip_tags(validation_errors()),'category'=>$category);
            echo json_encode($response);
        }
    }

    public function edit_about($id)
    {
        $this->data['page_title'] = 'Edit About';
        $this->data['main_view'] = 'form/edit_about';
        $data = $this->dashboard->getwhere('t_about',array('id'=>$id));
        $this->data['data'] = $data;
        if($data) {
            $this->load->view('template_content', $this->data);
        }else{
            show_404();
        }
    }

    public function act_edit_about()
    {
        $id = strip_tags($this->input->post('id'));
        $category = strip_tags($this->input->post('category'));
        $title = strip_tags($this->input->post('title'));
        $description = $this->input->post('description');


        if (validation_add_about()) {
            $update_about = $this->dashboard->update('t_about',array('id'=>$id), array('title' => $title,'description' => $description));
            if ($update_about) {
                $response = array('error'=>false,'title'=>'Update Berhasil','pesan'=>'','category'=>$category);
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Update Gagal!','pesan'=>strip_tags(validation_errors()),'category'=>$category);
            echo json_encode($response);
        }
    }





    public function blog($cat)
    {
        if($cat == 'umum'){
            $title = 'Blog Umum';
        }elseif($cat == 'mitra'){
            $title = 'Blog Mitra';
        }else{
            show_404();
        }

        $this->data['category'] = $cat;
        $this->data['page_title'] = 'Manage '.$title;
        $this->data['main_view'] = 'content/blog';
        $this->load->view('template_content', $this->data);
    }

    function load_tb_blog($cat) {
        header('Content-Type: application/json');
        echo $this->dashboard->load_tb_blog($cat);
    }

    public function add_blog($cat = false)
    {
        //protect function from error
        $cat == 'umum' or $cat == 'mitra'?true: show_404();

        $this->data['category'] = $cat;
        $this->data['page_title'] = 'Add Blog';
        $this->data['main_view'] = 'form/add_blog';
        $this->load->view('template_content', $this->data);
    }

    public function act_add_blog()
    {

        $category = strip_tags($this->input->post('category'));
        $title = strip_tags($this->input->post('title'));
        $description = $this->input->post('description');

        // config upload
        $config['upload_path'] = $this->config->item('path_images_thumbnail');
        $config['allowed_types'] = 'jpg'; //sebenernya udah di filter lagi oleh mime.php bawaan ci to xss
        $config['max_size'] = '500'; // 1MB
        $config['encrypt_name'] = true; // to clean xss in name of file
        $this->load->library('upload', $config);
        //$this->upload->initialize($config);


            if (!$this->upload->do_upload('thumbnail')) {
                $error = strip_tags($this->upload->display_errors());
                $response = array('error' => true, 'title' => 'Add Gagal', 'pesan' => $error, 'category' => $category);
                echo json_encode($response);
            }else{
                $name_thumbnail = $this->upload->data('file_name');
                if (validation_add_about()) {
                    $add_blog = $this->dashboard->create('t_blog', array('category' => $category, 'title' => $title, 'description' => $description, 'thumbnail' => $name_thumbnail));
                    if ($add_blog) {
                        $response = array('error' => false, 'title' => 'Add Berhasil', 'pesan' => '', 'category' => $category);
                        echo json_encode($response);
                    }

                } else {
                    $response = array('error' => true, 'title' => 'Add Gagal!', 'pesan' => strip_tags(validation_errors()), 'category' => $category);
                    echo json_encode($response);
                }
            }
    }

    public function edit_blog($id)
    {
        $this->data['page_title'] = 'Edit Blog';
        $this->data['main_view'] = 'form/edit_blog';
        $data = $this->dashboard->getwhere('t_blog',array('id'=>$id));
        $this->data['data'] = $data;
        if($data) {
            $this->load->view('template_content', $this->data);
        }else{
            show_404();
        }
    }

    public function act_edit_blog()
    {

        $id = strip_tags($this->input->post('id'));
        $category = strip_tags($this->input->post('category'));
        $title = strip_tags($this->input->post('title'));
        $description = $this->input->post('description');
        $old_thumbnail = strip_tags($this->input->post('old_thumbnail'));

        // config upload
        $config['upload_path'] = $this->config->item('path_images_thumbnail');
        $config['allowed_types'] = 'jpg'; //sebenernya udah di filter lagi oleh mime.php bawaan ci to xss
        $config['max_size'] = '500'; // 1MB
        $config['encrypt_name'] = true; // to clean xss in name of file
        $this->load->library('upload', $config);
        //$this->upload->initialize($config);


        if (!$this->upload->do_upload('thumbnail')) {
            $name_thumbnail = $old_thumbnail;
        }else{
            $path = $this->config->item('path_images_thumbnail').$old_thumbnail;
            unlink($path);
            $name_thumbnail = $this->upload->data('file_name');
        }
            if (validation_add_about()) {
                $add_blog = $this->dashboard->update('t_blog', array('id' => $id), array('title' => $title, 'description' => $description, 'thumbnail' => $name_thumbnail));
                if ($add_blog) {
                    $response = array('error' => false, 'title' => 'Update Berhasil', 'pesan' => '', 'category' => $category);
                    echo json_encode($response);
                }

            } else {
                $response = array('error' => true, 'title' => 'Update Gagal!', 'pesan' => strip_tags(validation_errors()), 'category' => $category);
                echo json_encode($response);
            }

    }

    public function cat_item($cat = false)
    {
        $this->data['page_title'] = 'Category Item';
        $this->data['main_view'] = 'content/cat_item';

        #cek parent nya klo bukan nol berarti link nya habis
        if($cat != 0) {
            $cek_parent = $this->dashboard->getwhere('r_cat_item', array('id' => $cat));
            if($cek_parent['parent_id'] == 0){
                $this->data['link'] = true;
            }else{
                $this->data['link'] = false;
            }
        }else{
            $this->data['link'] = true;
        }

        $data = $this->dashboard->getwhere('r_cat_item', array('parent_id' => $cat), 1);
        if($data) {
            $this->data['cat'] = $cat;
            $this->data['data'] = $data;
            $this->load->view('template_content', $this->data);
        }else{
            echo "<script>alert('Sub Category Kosong...');window.location.href= '".base_url('dashboard/cat_item/0')."'</script>";

        }
    }

    public function add_cat($cat = false)
    {
        $this->data['cat'] = $cat;
        $this->data['page_title'] = 'Add Category';
        $this->data['main_view'] = 'form/add_cat';
        $this->load->view('template_content', $this->data);
    }

    public function act_add_cat()
    {
        $category = strip_tags($this->input->post('category'));
        $parent = strip_tags($this->input->post('parent'));

        $link = '';
        if($parent <> 0){
            $getParent = $this->dashboard->getwhere('r_cat_item',array('id'=>$parent));
            if($getParent['parent_id'] <> 0){
                $getParentAgain = $this->dashboard->getwhere('r_cat_item',array('id'=>$getParent['parent_id']));
                $link = $getParentAgain['menu']."/".$getParent['menu']."/".$category;
            }
        }


        if (validation_add_cat()) {
            $add_cat = $this->dashboard->create('r_cat_item', array('menu' => $category, 'parent_id' => $parent,'link' => $link));
            if ($add_cat) {
                $response = array('error'=>false,'title'=>'Add Berhasil','pesan'=>'','category'=>$parent);
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Add Gagal!','pesan'=>strip_tags(validation_errors()),'category'=>$category);
            echo json_encode($response);
        }
    }

    public function edit_cat($cat)
    {
        $this->data['page_title'] = 'Edit Category';
        $this->data['main_view'] = 'form/edit_cat';

        $data = $this->dashboard->getwhere('r_cat_item',array('id'=>$cat));
        $this->data['data'] = $data;
        if($data) {
            $this->load->view('template_content', $this->data);
        }else{
            show_404();
        }
    }

    public function act_edit_cat()
    {
        $category = strip_tags($this->input->post('category'));
        $id = strip_tags($this->input->post('id'));
        $parent_id = strip_tags($this->input->post('parent_id'));
        $menuOrder = strip_tags($this->input->post('menu_order'));


        if (validation_add_cat()) {
            $update_cat = $this->dashboard->update('r_cat_item',array('id'=>$id), array('menu' => $category,'menu_order'=>$menuOrder));
            if ($update_cat) {
                $response = array('error'=>false,'title'=>'Update Berhasil','pesan'=>'','category'=>$parent_id);
                echo json_encode($response);
            }

        }else{
            $response = array('error'=>true,'title'=>'Update Gagal!','pesan'=>strip_tags(validation_errors()),'category'=>$category);
            echo json_encode($response);
        }
    }

    public function komentarItem()
    {

        $this->data['page_title'] = 'Komentar Item';
        $this->data['main_view'] = 'content/komentar_item';
        $this->data['data'] = $this->dashboard->get('t_item_review',1,false,false,array('param'=>'id_review','by'=>'DESC'));
        $this->load->view('template_content', $this->data);
    }

    public function komentarCatalog()
    {

        $this->data['page_title'] = 'Komentar Katalog';
        $this->data['main_view'] = 'content/komentar_catalog';
        $this->data['data'] = $this->dashboard->get('t_catalog_review',1,false,false,array('param'=>'id_review','by'=>'DESC'));
        $this->load->view('template_content', $this->data);
    }

    public function sellerPending()
    {

        $this->data['page_title'] = 'Konfirmasi Seller Pending';
        $this->data['main_view'] = 'content/seller_pending';
        $this->data['data'] = $this->dashboard->getwhere('t_transaksi_item',array('status' => 1,'no_resi'=>'0'),1,false,'no_invoice');
        $this->load->view('template_content', $this->data);
    }

    public function actCancelSellerPending($noInvoice = false,$id_seller = false)
    {
        if($noInvoice == false && $id_seller == false){
            show_404();
        }
        $noInvoice_clean = strip_tags($noInvoice);
        $getItemData = $this->dashboard->getwhere('t_transaksi_item',array('no_invoice'=>$noInvoice_clean));

            $updateTransaksiItem = $this->dashboard->update('t_transaksi_item',array('no_invoice'=>$noInvoice_clean),array('no_resi'=>0));
            if($updateTransaksiItem) {

                #get Email Reseller
                $getNmCatalog = $this->dashboard->getwhere('t_transaksi',array('id'=>$getItemData['id_transaksi']));
                $getIdReseller = $this->dashboard->getwhere('t_catalog',array('nm_catalog'=>$getNmCatalog['nm_catalog']));
                $getEmailReseller = $this->dashboard->getwhere('m_user',array('id'=>$getIdReseller['id_user']));

                $getNameSeller = $this->dashboard->getwhere('m_user',array('id'=>$id_seller));
                #Send Email Confirm
                error_reporting(0);
                $this->load->helper('email_helper');
                $email_seller = $getNameSeller['email'];
                $email_reseller = $getEmailReseller['email'];
                $subjectToSeller = "Info Penolakan Barang Mitrareseller.com";
                $subjectToReseller = "Info Pengiriman Barang Mitrareseller.com";
                $messageToSeller = "Admin Telah melakukan cancel pesanan barang untuk nomor invoice ".$noInvoice_clean.", mohon untuk tingkatkan integritas toko anda jika tidak ingin di suspend admin. <br><br> Terimakasih atas kerjasama anda.";
                $messageToReseller = "Mohon maaf pesanan barang dengan nomor invoice ".$noInvoice_clean." di tolak segera lakukan konfirmasi dan uang akan kami transfer pada rekening anda,<br> anda bisa pantau pada riwayat transfer akun. <br><br> Mohon maaf dan terimakasih atas kerjasama anda.";

                $sendToAdmin = kirim_email($email_seller,$subjectToSeller,$messageToSeller);
                $sendToReseller = kirim_email($email_reseller,$subjectToReseller,$messageToReseller);

                if(!$sendToAdmin){
                    #kirim email gagal ke db
                    $this->seller->create('m_email_monitoring',array('email'=>$email_seller,'bug'=>$this->email->print_debugger()));
                }
                if(!$sendToReseller){
                    #kirim email gagal ke db
                    $this->seller->create('m_email_monitoring',array('email'=>$email_reseller,'bug'=>$this->email->print_debugger()));
                }

                echo"<script>alert('Cancel Berhasil!');window.location.href='".base_url('dashboard/sellerPending')."'</script>";
            }
    }

    public function confPembayaran()
    {

        $this->data['page_title'] = 'Konfirmasi Pembayaran';
        $this->data['main_view'] = 'content/conf_pembayaran';
        $this->data['data'] = $this->dashboard->get('t_transaksi_konfirmasi',1);
        $this->load->view('template_content', $this->data);
    }

    public function act_confirm($id_transaksi)
    {
        $id = strip_tags($id_transaksi);

            $update_status_item = $this->dashboard->update('t_transaksi_item',array('id_transaksi'=>$id), array('status' => 1));
            $update_status = $this->dashboard->update('t_transaksi',array('id'=>$id), array('status' => 3));
            $update_status_konfirmasi = $this->dashboard->update('t_transaksi_konfirmasi',array('id_transaksi'=>$id), array('status' => 1));
            if ($update_status && $update_status_item && $update_status_konfirmasi) {

                #kirim email
                $this->load->helper('email_helper');
                error_reporting(0);

                $getNoInvoice = $this->dashboard->getwhere('t_transaksi_item',array('id_transaksi'=>$id),1,false,'no_invoice');
                if($getNoInvoice){
                    foreach($getNoInvoice as $row){
                        $getEmailSeller = $this->dashboard->getwhere('m_user',array('id'=>$row['id_seller']));
                        $subject = "Notifikasi Order Mitrareseller.com";
                        $message = "Anda memiliki Order untuk nomor invoice <b>".$row['no_invoice']."</b>
                            Segera Lakukan pengiriman barang dan lakukan konfirmasi pengiriman.</b>

                            <br><br>

                            Terimakasih atas kerjasama anda.";

                        $send = kirim_email($getEmailSeller['email'],$subject,$message);
                    }
                }

                if(!$send){
                    #kirim email gagal ke db
                    $this->dashboard->create('m_email_monitoring',array('email'=>$getEmailSeller['email'],'bug'=>$this->email->print_debugger()));
                }
                #end kirim email
                $response = array('error'=>false,'title'=>'konfirmasi Berhasil','pesan'=>'');
                echo json_encode($response);
            }

    }



    public function paymentReseller()
    {
        $this->data['page_title'] = 'Payment Reseller';
        $this->data['main_view'] = 'content/payment_reseller';
        $this->data['data'] = $this->dashboard->getwhere('t_transaksi',array('status' => 4,'payment_reseller'=>null),1,false,'nm_catalog');
        $this->load->view('template_content', $this->data);

    }

    public function act_paymentReseller()
    {
        $nm_catalog = strip_tags($this->input->post('nm_catalog'));
        $link_images = strip_tags($this->input->post('bukti_transfer'));

        $getIdUser = $this->dashboard->getwhere('t_catalog',array('nm_catalog'=>$nm_catalog));

        $insertPayment = $this->dashboard->create('m_payment',array('id_user'=>$getIdUser['id_user'],'link_images'=>$link_images,'role'=>'reseller'));
        $id_payment = $this->db->insert_id();
        $getIdTransaksi = $this->dashboard->getwhere('t_transaksi',array('status'=>4,'nm_catalog'=>$nm_catalog,'payment_reseller' => null),1);
        if($getIdTransaksi){
            foreach($getIdTransaksi as $row){
                $this->dashboard->create('m_payment_item',array('id_payment'=>$id_payment,'id_transaksi'=>$row['id']));

                $this->dashboard->create('m_transaksi',array('id'=>$row['id'],'nm_catalog'=>$row['nm_catalog'],'kode_unik'=>$row['kode_unik'],'total_pembayaran'=>$row['total_pembayaran'],'batas_waktu'=>$row['batas_waktu'],'status'=>$row['status'],'payment_reseller'=>1,'created'=>$row['created']));
                $getTransaksiItem = $this->dashboard->getwhere('t_transaksi_item',array('id_transaksi'=>$row['id']),1);
                if($getTransaksiItem){
                    foreach($getTransaksiItem as $data){
                        $this->dashboard->create('m_transaksi_item',array('id'=>$data['id'],'no_invoice'=>$data['no_invoice'],'id_transaksi'=>$data['id_transaksi'],'id_item'=>$data['id_item'],'id_seller'=>$data['id_seller'],'qty'=>$data['qty'],'id_alamat'=>$data['id_alamat'],'tipe_kurir'=>$data['tipe_kurir'],'tipe_layanan'=>$data['tipe_layanan'],'ongkir'=>$data['ongkir'],'subtotal'=>$data['subtotal'],'no_resi'=>$data['no_resi'],'status'=>$data['status'],'created'=>$data['created']));
                    }
                }
                $this->dashboard->update('t_transaksi',array('id'=>$row['id']),array('payment_reseller'=>1));

            }
        }


        if ($insertPayment) {

            #kirim email
            $this->load->helper('email_helper');
            error_reporting(0);
                    $getEmailSeller = $this->dashboard->getwhere('m_user',array('id'=>$getIdUser['id_user']));
                    $subject = "Notifikasi Komisi Mitrareseller.com";
                    $message = "Admin Mitrareseller.com telah melakukan transfer komisi menuju rekening anda.

                            <br><br>

                            Terimakasih atas kerjasama anda.";

                    $send = kirim_email($getEmailSeller['email'],$subject,$message);

            if(!$send){
                #kirim email gagal ke db
                $this->dashboard->create('m_email_monitoring',array('email'=>$getEmailSeller['email'],'bug'=>$this->email->print_debugger()));
            }
            #end kirim email
            $response = array('error'=>false,'title'=>'konfirmasi Berhasil','pesan'=>'');
            echo json_encode($response);
        }

    }

    public function paymentRefund()
    {
        $this->data['page_title'] = 'Payment Refund';
        $this->data['main_view'] = 'content/payment_refund';
        $this->data['data'] = $this->dashboard->get('t_transaksi_failed',1,false,'nm_catalog');
        $this->load->view('template_content', $this->data);

    }

    public function act_paymentRefund()
    {
        $nm_catalog = strip_tags($this->input->post('nm_catalog'));
        $link_images = strip_tags($this->input->post('bukti_transfer'));

        $getIdUser = $this->dashboard->getwhere('t_catalog',array('nm_catalog'=>$nm_catalog));

        $insertPayment = $this->dashboard->create('m_payment',array('id_user'=>$getIdUser['id_user'],'link_images'=>$link_images,'role'=>'reseller','payment_refund'=> 1));
        $id_payment = $this->db->insert_id();
        $getIdTransaksi = $this->dashboard->getwhere('t_transaksi_failed',array('status'=>4,'nm_catalog'=>$nm_catalog),1);
        if($getIdTransaksi){
            foreach($getIdTransaksi as $row){
                $this->dashboard->create('m_payment_item',array('id_payment'=>$id_payment,'id_transaksi'=>$row['id']));


                    $this->dashboard->create('m_transaksi_failed',array('id'=>$row['id'],'nm_catalog'=>$row['nm_catalog'],'kode_unik'=>$row['kode_unik'],'total_pembayaran'=>$row['total_pembayaran'],'batas_waktu'=>$row['batas_waktu'],'status'=>$row['status'],'payment_reseller'=>1,'created'=>$row['created']));
                    $getTransaksiItem = $this->dashboard->getwhere('t_transaksi_item_failed',array('id_transaksi'=>$row['id']),1);
                    if($getTransaksiItem){
                        foreach($getTransaksiItem as $data){
                            $this->dashboard->create('m_transaksi_item_failed',array('id'=>$data['id'],'no_invoice'=>$data['no_invoice'],'id_transaksi'=>$data['id_transaksi'],'id_item'=>$data['id_item'],'id_seller'=>$data['id_seller'],'qty'=>$data['qty'],'id_alamat'=>$data['id_alamat'],'tipe_kurir'=>$data['tipe_kurir'],'tipe_layanan'=>$data['tipe_layanan'],'ongkir'=>$data['ongkir'],'subtotal'=>$data['subtotal'],'no_resi'=>$data['no_resi'],'status'=>$data['status'],'created'=>$data['created']));
                        }
                    }

                $this->dashboard->delete('t_transaksi_failed',array('id'=>$row['id']));
                $this->dashboard->delete('t_transaksi_item_failed',array('id_transaksi'=>$row['id']));
                $this->dashboard->delete('t_transaksi_konfirmasi',array('id_transaksi'=>$row['id']));

            }
        }

        if ($insertPayment) {

            #kirim email
            $this->load->helper('email_helper');
            error_reporting(0);
            $getEmailSeller = $this->dashboard->getwhere('m_user',array('id'=>$getIdUser['id_user']));
            $subject = "Notifikasi Komisi Mitrareseller.com";
            $message = "Admin Mitrareseller.com telah melakukan transfer Pengembalian dana barang yang ditolak menuju rekening anda.

                            <br><br>

                            Terimakasih atas kerjasama anda.";

            $send = kirim_email($getEmailSeller['email'],$subject,$message);

            if(!$send){
                #kirim email gagal ke db
                $this->dashboard->create('m_email_monitoring',array('email'=>$getEmailSeller['email'],'bug'=>$this->email->print_debugger()));
            }
            #end kirim email
            $response = array('error'=>false,'title'=>'konfirmasi Berhasil','pesan'=>'');
            echo json_encode($response);
        }

    }

    public function paymentSeller()
    {
        $this->data['page_title'] = 'Payment Seller';
        $this->data['main_view'] = 'content/payment_seller';
        $getIdTransaksi = $this->dashboard->getwhere('t_transaksi',array('status'=>'4','payment_seller'=>null),1);
        $in = array();
        if($getIdTransaksi){
            foreach ($getIdTransaksi as $row) {
                $in[] = $row['id'];
            }
        }else{
            $in = "";
        }

        $this->data['all_id_transaksi'] = $in;
        $this->data['data'] = $this->db->group_by('id_seller')->where('no_resi <>','0')->where('status','2')->where_in('id_transaksi', $in)->get('t_transaksi_item')->result_array();
        $this->load->view('template_content', $this->data);

    }

    public function act_paymentSeller()
    {
        #harus pake where in
        $id_seller = strip_tags($this->input->post('id_seller'));
        $link_images = strip_tags($this->input->post('bukti_transfer'));

        $getIdTransaksi = $this->dashboard->getwhere('t_transaksi',array('status'=>'4','payment_seller'=>null),1);
        $in = array();
        if($getIdTransaksi){
            foreach ($getIdTransaksi as $row) {
                $in[] = $row['id'];	
            }
        }

	$cekPaymentReseller = $this->db->select('id')->where('payment_reseller',NULL)->where('status','4')->where_in('id', $in)->get('t_transaksi')->num_rows();

        if($cekPaymentReseller > 0){
            $response = array('error'=>true,'title'=>'Warning','pesan'=>'Reseller harus dibayar lebih dulu/transaksi belum selesai di reseller');
            echo json_encode($response);
            exit;
        }

        $insertPayment = $this->dashboard->create('m_payment',array('id_user'=>$id_seller,'link_images'=>$link_images,'role'=>'seller'));
        $id_payment = $this->db->insert_id();

        $getIdTransaksi = $this->db->group_by('id_transaksi')->where('id_seller',$id_seller)->where('no_resi <>','0')->where('status','2')->where_in('id_transaksi', $in)->get('t_transaksi_item')->result_array();

        if($getIdTransaksi){
            foreach($getIdTransaksi as $row){
                $cekSeller = $this->db->get_where('t_transaksi_item',array('id_transaksi'=>$row['id_transaksi'],'id_seller <>' => $id_seller))->num_rows();

                $this->dashboard->create('m_payment_item',array('id_payment'=>$id_payment,'id_transaksi'=>$row['id_transaksi']));
                if($cekSeller == 0){
                    $this->dashboard->delete('t_transaksi',array('id'=>$row['id_transaksi']));
                    $this->dashboard->delete('t_transaksi_item',array('id_transaksi'=>$row['id_transaksi']));
                    $this->dashboard->delete('t_transaksi_konfirmasi',array('id_transaksi'=>$row['id_transaksi']));
                }else{
                    $this->dashboard->delete('t_transaksi_item',array('id_transaksi'=>$row['id_transaksi'],'id_seller'=>$id_seller));
                }

            }
        }

        if ($insertPayment) {

            #kirim email
            $this->load->helper('email_helper');
            error_reporting(0);
            $getEmailSeller = $this->dashboard->getwhere('m_user',array('id'=>$id_seller));
            $subject = "Notifikasi Komisi Mitrareseller.com";
            $message = "Admin Mitrareseller.com telah melakukan transfer komisi menuju rekening anda.

                            <br><br>

                            Terimakasih atas kerjasama anda.";

            $send = kirim_email($getEmailSeller['email'],$subject,$message);

            if(!$send){
                #kirim email gagal ke db
                $this->dashboard->create('m_email_monitoring',array('email'=>$getEmailSeller['email'],'bug'=>$this->email->print_debugger()));
            }
            #end kirim email
            $response = array('error'=>false,'title'=>'konfirmasi Berhasil','pesan'=>'');
            echo json_encode($response);
        }

    }

    public function histPaymentReseller()
    {
        $this->data['page_title'] = 'History Payment Reseller';
        $this->data['main_view'] = 'content/hist_payment_reseller';
        $this->data['data'] = $this->dashboard->getwhere('m_payment',array('role'=>'reseller','payment_refund <>'=> 1),1,false,false,array('param'=>'id','by'=>'desc'));
        $this->load->view('template_content', $this->data);

    }

    public function histPaymentRefund()
    {
        $this->data['page_title'] = 'History Payment Refund';
        $this->data['main_view'] = 'content/hist_payment_refund';
        $this->data['data'] = $this->dashboard->getwhere('m_payment',array('role'=>'reseller','payment_refund'=> 1),1,false,false,array('param'=>'id','by'=>'desc'));
        $this->load->view('template_content', $this->data);

    }

    public function histPaymentSeller()
    {
        $this->data['page_title'] = 'History Payment Seller';
        $this->data['main_view'] = 'content/hist_payment_seller';
        $this->data['data'] = $this->dashboard->getwhere('m_payment',array('role'=>'seller'),1,false,false,array('param'=>'id','by'=>'desc'));
        $this->load->view('template_content', $this->data);

    }

    public function media()
    {
        $this->data['page_title'] = 'Manage Media';
        $this->data['data'] = $this->dashboard->get('m_media',1,false,false,array('param'=>'id','by'=>'desc'));
        $this->data['main_view'] = 'content/media';
        $this->load->view('template_content', $this->data);
    }

    public function actInsertMedia(){
        $title = strip_tags($this->input->post('title'));

        // config upload
        $config['upload_path'] = $this->config->item('path_images_media');
        $config['allowed_types'] = 'jpg|png|pdf'; //sebenernya udah di filter lagi oleh mime.php bawaan ci to xss
        $config['max_size'] = '500'; // 1MB
        $config['encrypt_name'] = true; // to clean xss in name of file
        $this->load->library('upload', $config);
        //$this->upload->initialize($config);


        if (!$this->upload->do_upload('media')) {
            $error = strip_tags($this->upload->display_errors());
            echo"<script>alert('{$error}');window.location.href='".base_url('dashboard/media')."'</script>";
            exit;
        }else{
            $name_file = $this->upload->data('file_name');
            $file_size = $this->upload->data('file_size');
            if (!empty($title)) {
                $insertMedia = $this->dashboard->create('m_media', array('name_file' => $name_file,'size'=>$file_size, 'title' => $title));
                if ($insertMedia) {
                    echo"<script>alert('Upload Berhasil');window.location.href='".base_url('dashboard/media')."'</script>";
                    exit;
                }
            } else {
                $path = $this->config->item('path_images_media').$name_file;
                unlink($path);
                echo"<script>alert('title harus diisi');window.location.href='".base_url('dashboard/media')."'</script>";
                exit;
            }
        }
    }

    public function actDeleteMedia($id = false, $name_file = false)
    {
        $delete = $this->dashboard->delete('m_media',array('id'=>$id));

        if ($delete) {
            $path = $this->config->item('path_images_media').$name_file;
            unlink($path);
            echo"<script>alert('Delete Success');window.location.href='".base_url('dashboard/media')."'</script>";
            exit;
        }else{
            echo"<script>alert('Delete failed');window.location.href='".base_url('dashboard/media')."'</script>";
            exit;
        }
    }

    public function backupDatabase()
    {

        $this->data['page_title'] = 'Backup Database';
        $this->data['main_view'] = 'form/backup_database';
        $this->load->view('template_content', $this->data);
    }

    public function actBackupDatabase()
    {
        $password = strip_tags($this->input->post('password'));

        if($password == "M1s3ll2017"){

            $this->load->dbutil();

            $prefs = array(
                'format'      => 'zip',
                'filename'    => 'my_db_backup.sql'
            );


            $backup =& $this->dbutil->backup($prefs);

            $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
            $save = 'pathtobkfolder/'.$db_name;

            $this->load->helper('file');
            write_file($save, $backup);


            $this->load->helper('download');
            force_download($db_name, $backup);

        }else{
            echo"<script>alert('Password Salah');window.location.href='".base_url('dashboard/backupDatabase')."'</script>";
            exit;
        }
    }

    public function maintenance()
    {
        $this->data['page_title'] = 'Manage System';
        $this->data['main_view'] = 'content/maintenance';
        $this->data['data'] = $this->dashboard->get('m_maintenance');
        $this->load->view('template_content', $this->data);
    }


    public function act_maintenance($value = '0')
    {
        
        $update_maintenance = $this->dashboard->update('m_maintenance', array('id' => '1'), array('status' => $value));

        if ($value == '0') {
            echo"<script>alert('Maintenance Mode OFF');window.location.href='".base_url('dashboard/maintenance')."'</script>";
            exit;
        }else{
            $update_all_session = $this->dashboard->update('log_sessions', array('id_user <>' => '10001'), array('id_sessions' => 'maintenance'));
            echo"<script>alert('Maintenance Mode ON');window.location.href='".base_url('dashboard/maintenance')."'</script>";
            exit;
        }
    }

    public function cekUntung()
    {

        $kodeUnik = array();
        $platformPayment = array();

        $getTransaksi = $this->dashboard->getwhere('t_transaksi',array('status'=>4),1);
        if($getTransaksi){
            foreach($getTransaksi as $row){
                $kodeUnik[] = $row['kode_unik'];

                $getIdItem = $this->dashboard->getwhere('t_transaksi_item',array('id_transaksi'=>$row['id']),1);
                if($getIdItem){
                    foreach($getIdItem as $row2){
                        $getData = $this->dashboard->getwhere('t_item_harga',array('id_item'=>$row2['id_item']));
                        $platformPayment[] = $getData['platform_payment'] * $row2['qty'];
                    }
                }

            }
        }

        $cekTotal = array_sum($kodeUnik) + array_sum($platformPayment);
        $cekTotalFormat = number_format($cekTotal,0);



        if (!empty($cekTotal)) {
           $this->data['data'] = 'Rp. '.$cekTotalFormat;
        }else{
            $this->data['data'] = '0';
        }

        $this->data['page_title'] = 'Cek Untung';
        $this->data['main_view'] = 'content/cek_untung';
        $this->load->view('template_content', $this->data);

    }

    public function deleteReviewItem($id = false)
    {

        $delete = $this->dashboard->delete('t_item_review',array('id_review'=>$id));

        if ($delete) {
            echo"<script>alert('Delete Berhasil');window.location.href='".base_url('dashboard/komentarItem')."'</script>";
            exit;
        }else{
            echo"<script>alert('Delete Gagal');window.location.href='".base_url('dashboard/komentarItem')."'</script>";
            exit;
        }
    }

    public function deleteReviewCatalog($id = false)
    {

        $delete = $this->dashboard->delete('t_catalog_review',array('id_review'=>$id));

        if ($delete) {
            echo"<script>alert('Delete Berhasil');window.location.href='".base_url('dashboard/komentarCatalog')."'</script>";
            exit;
        }else{
            echo"<script>alert('Delete Gagal');window.location.href='".base_url('dashboard/komentarCatalog')."'</script>";
            exit;
        }
    }

    public function deleteMember($id = false)
    {
        $cekStatus = $this->dashboard->getwhere('m_user',array('id'=>$id));
        if($cekStatus['confirm'] == 'false'){
            $delete = $this->dashboard->delete('m_user',array('id'=>$id));
        }else{
            $delete = false;
        }

        if ($delete) {
            echo"<script>alert('Delete Berhasil');window.location.href='".base_url('dashboard/memberMitrareseller')."'</script>";
            exit;
        }else{
            echo"<script>alert('Action Protected');window.location.href='".base_url('dashboard/memberMitrareseller')."'</script>";
            exit;
        }
    }

//    public function sendEmail(){
//        #kirim email
//        $this->load->helper('email_helper');
//        error_reporting(0);
//
//        $getNoInvoice = $this->dashboard->getwhere('t_transaksi_item',array('id_transaksi'=>35));
//        $subject = "Order barang";
//        $message = "Anda memiliki Order untuk nomor invoice
//                            Segera Lakukan pengiriman barang dan lakukan konfirmasi pengiriman.</b>
//
//                            <br><br>
//
//                            Terimakasih atas kerjasama anda.";
//
//        $send = kirim_email('hzulqan@gmail.com',$subject,$message);
//        if(!$send){
//            #kirim email gagal ke db
//            $this->dashboard->create('m_email_monitoring',array('email'=>'hzulqan@gmail.com','bug'=>$this->email->print_debugger()));
//        }
//        #end kirim email
//    }

//  +++++++++++++++++++++++++ Function DELETE Global +++++++++++++++++++++++++++++
    public function act_delete($id = false, $table = false)
    {

        //cek table yang mengandung gambar
        if($table == 't_blog'){
            $get_images = $this->dashboard->getwhere($table,array('id'=>$id));
            if($get_images) {
                $path = $this->config->item('path_images_thumbnail').$get_images['thumbnail'];
                unlink($path);
            }
        }

        $delete = $this->dashboard->delete($table,array('id'=>$id));

        if ($delete) {
            $response = array('error'=>false,'title'=>'Delete Berhasil','pesan'=>'');
            echo json_encode($response);
        }else{
            $response = array('error'=>true,'title'=>'Delete Gagal!','pesan'=>'Query Failed');
            echo json_encode($response);
        }
    }
//  +++++++++++++++++++++++++ End Function Delete Global +++++++++++++++++++++++++++





}
