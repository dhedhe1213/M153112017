<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Main extends CI_Controller
{
	public $data = array('title' => 'Mitra Reseller | Mau Jadi Reseller Tanpa Modal?Kami Punya Solusinya',
						 'main_view' => '',
                         'menu_active' => '');

	public function __construct()
	{
		parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
		$this->load->model('main_model','main');
        $this->load->helper(array('role_form_helper','xss_helper'));
        $this->data['new_member'] = $this->main->get('m_user',1,15,false,array('param' => 'id', 'by' => 'desc'));
	}

	public function index()
	{
        ####Google Login####

        // Include the google api php libraries
        include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
        include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
        // Google Project API Credentials
        $clientId = '438960739955-n3se0n4sv766aq9ivh1k75eo6s67n5u4.apps.googleusercontent.com';
        $clientSecret = 'Vjn6qwsPRA5fuMmGcNvA67Rn';
        $redirectUrl = "https://www.mitrareseller.com";
        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to Mitrareseller.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_REQUEST['code'])) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');

        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {

            $userProfile = $google_oauthV2->userinfo->get();
            // Preparing data for database insertion
              $userData['oauth_provider'] = 'google';
              $userData['oauth_uid'] = $userProfile['id'];
              $userData['name'] = $userProfile['given_name']." ".$userProfile['family_name'];
              $userData['email'] = $userProfile['email'];
              $userData['picture_url'] = $userProfile['picture'];
            // Insert or update user data
            $userID = $this->main->checkUser($userData);

            if(!empty($userID)){
                $data['userData'] = $userData;
//                $this->session->set_userdata('userData',$userData);
            } else {
                $data['userData'] = array();
            }

        } else {
            $this->data['authUrl'] = $gClient->createAuthUrl();
        }
        ###end Google Login ####


		$this->data['main_view'] = 'content/home';
        $this->data['menu'] = 'home';

		$this->load->view('template',$this->data);
	}

    public function loginSeller()
    {
        ####Google Login####

        // Include the google api php libraries
        include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
        include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
        // Google Project API Credentials
        $clientId = '438960739955-n3se0n4sv766aq9ivh1k75eo6s67n5u4.apps.googleusercontent.com';
        $clientSecret = 'Vjn6qwsPRA5fuMmGcNvA67Rn';
        $redirectUrl = "https://mitrareseller.com/main/loginSeller";
        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to Mitrareseller.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_REQUEST['code'])) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');

        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {

            $userProfile = $google_oauthV2->userinfo->get();
            // Preparing data for database insertion
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid'] = $userProfile['id'];
            $userData['name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            $userData['email'] = $userProfile['email'];
            $userData['picture_url'] = $userProfile['picture'];
            // Insert or update user data
            $userID = $this->main->checkUser($userData);

            if(!empty($userID)){
                $data['userData'] = $userData;
//                $this->session->set_userdata('userData',$userData);
            } else {
                $data['userData'] = array();
            }

        } else {
            $this->data['authUrl'] = $gClient->createAuthUrl();
        }
        ###end Google Login ####

        $this->data['main_view'] = 'content/login_seller';
        $this->data['menu'] = 'home';

        $this->load->view('template',$this->data);
    }

    public function register()
    {
        $this->load->library('Recaptcha');

        # menampilkan recaptcha
        $this->data['captcha'] = $this->recaptcha->getWidget();
        # javascript recaptcha ditaruh di head
        $this->data['script_captcha'] = $this->recaptcha->getScriptTag();

        $this->data['main_view'] = 'content/register';
        $this->data['menu'] = 'home';

        $this->load->view('template',$this->data);
    }

    public function act_register()
    {
        $this->load->library('Recaptcha');
        $this->load->helper('email_helper');

        $name = strip_tags($this->input->post('name'));
        $phone = strip_tags($this->input->post('phone'));
        $email = strip_tags($this->input->post('email'));
        $password = strip_tags(hash('sha256',$this->input->post('password')));
        $date = strip_tags($this->input->post('date'));
        $month = strip_tags($this->input->post('month'));
        $year = strip_tags($this->input->post('year'));
        $gender = strip_tags($this->input->post('gender'));
        $picture_default = base_url().'assets/images/user/default.png';

        $recaptcha = $this->input->post('g-recaptcha-response');
        $response = $this->recaptcha->verifyResponse($recaptcha);

        if(!isset($response['success']) || $response['success'] <> true) {
            $response = array('error' => 'captcha', 'title' => 'Registrasi Gagal!', 'pesan' => 'Captcha harus di centang/diisi');
            echo json_encode($response);
        }else{
            if (validation_register()) {
                $this->main->create('m_user', array('oauth_provider' => 'mitrareseller', 'oauth_uid' => '0101' . rand(100000, 1000000000), 'name' => $name, 'phone' => $phone, 'email' => $email, 'password' => $password, 'birthday' => $year . '-' . $month . '-' . $date, 'gender' => $gender, 'picture_url' => $picture_default, 'picture_url_thumb' => $picture_default, 'created' => date("Y-m-d H:i:s"), 'confirm' => 'false','role_id' => '1'));
                $get_id = $this->db->insert_id();
                #dibuat panjang phisingx
                $link = "http://mitrareseller.com/main/confirm/".rand(10000,90000).$get_id."?form=confirmation&id=1110201";

                #Send Email Confirm
                error_reporting(0);
                $subject = "Info Registrasi MitraReseller.com";
                $message = "Terimakasih anda telah mendaftarkan diri untuk menjadi rekan Mitrareseller.com. <br>
                            klik tautan berikut untuk mengkonfirmasi akun anda :<br><br>{$link}<br><br>
                            Ayo manfaatkan media sosial yang anda gunakan untuk hal yang positif dan menambah penghasilan.";

                $send = kirim_email($email,$subject,$message);
                if(!$send){
                    #kirim email gagal ke db
                    $this->main->create('m_email_monitoring',array('email'=>$email,'bug'=>$this->email->print_debugger()));
                }

                $response = array('error' => false, 'title' => 'Registrasi Berhasil', 'pesan' => 'Silahkan Cek Email Untuk Aktivasi Akun Anda');
                echo json_encode($response);
            } else {
                $response = array('error' => true, 'title' => 'Registrasi Gagal!', 'pesan' => strip_tags(validation_errors()));
                echo json_encode($response);
            }
        }

    }

    public function confirm($id = false){
        $id = substr(strip_tags($id),5,1000);
        $cek = $this->main->getwhere('m_user',array('id'=>$id,'confirm'=>'false'));
        if($cek){
            $this->data['menu'] = '';
            $this->data['main_view'] = 'content/blank';
            $this->data['email'] = $cek['email'];
            $this->main->update('m_user',array('id'=>$id),array('confirm'=>'true'));
            $this->load->view('template',$this->data);
            //echo "Confirmation Success... <a href ='".base_url()."'>Login</a>";
        }else{
            show_404();
        }

    }

    public function about()
    {
        $this->data['main_view'] = 'content/about';
        $this->data['menu'] = 'about';
        $this->data['data_about'] = $this->main->getwhere('t_about',array('category'=>1),1);
        $this->data['data_member'] = $this->main->getwhere('t_about',array('category'=>2),1);
        $this->data['data_syarat'] = $this->main->getwhere('t_about',array('category'=>3),1);
        $this->data['data_kebijakan'] = $this->main->getwhere('t_about',array('category'=>4),1);

        $this->load->view('template',$this->data);
    }

    public function blog($offset = false)
    {
        $offset = strip_tags($offset);

        $this->load->library('pagination');

        $this->data['main_view'] = 'content/blog';
        $this->data['menu'] = 'blog';

            #Pagination#
            $jml = $this->db->get('t_blog');
            //pengaturan pagination

            $config['base_url'] = base_url().'main/blog';
            $config['total_rows'] = $jml->num_rows();
            $config['per_page'] = '5';
            $config['next_page'] = '&laquo;';
            $config['prev_page'] = '&raquo;';
            //inisialisasi config
            $this->pagination->initialize($config);
            //buat pagination
            $this->data['halaman'] = $this->pagination->create_links();
            #End Pagination#
            $data = $this->main->get('t_blog',1,$config['per_page'],false,array('param'=>'id','by'=>'desc'),$offset);

        if($data) {
            $this->data['data'] = $data;
            $this->data['data_recent'] = $this->main->get('t_blog', 1, 3, false, array('param' => 'RAND()', 'by' => ''));
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
    }

    public function blog_cat($cat=false, $offset = false)
    {
        $offset = strip_tags($offset);

        $this->load->library('pagination');

        $this->data['main_view'] = 'content/blog';
        $this->data['menu'] = 'blog';

        $category = strip_tags($cat);

        #Pagination#
        $jml = $this->db->get_where('t_blog',array('category'=>$category));
        //pengaturan pagination

        $config['base_url'] = base_url().'main/blog_cat/'.$category;
        $config['total_rows'] = $jml->num_rows();
        $config['per_page'] = '5';
        $config['next_page'] = '&laquo;';
        $config['prev_page'] = '&raquo;';
        //inisialisasi config
        $this->pagination->initialize($config);
        //buat pagination
        $this->data['halaman'] = $this->pagination->create_links();
        #End Pagination#
        $data = $this->main->getwhere('t_blog',array('category'=>$category),1,$config['per_page'],false,array('param' => 'id', 'by' => 'desc'),$offset);

        if($data) {
            $this->data['data'] = $data;
            $this->data['data_recent'] = $this->main->get('t_blog', 1, 3, false, array('param' => 'RAND()', 'by' => ''));
            $this->load->view('template', $this->data);
        }else{
            show_404();
        }
    }

    public function blog_detail($id = false)
    {

        $id = strip_tags($id);
        $data = $this->main->getwhere('t_blog', array('id' => $id));
        if($data) {
            $this->data['main_view'] = 'content/blog_detail';
            $this->data['menu'] = 'blog';
            $this->data['data'] = $data;
            $this->data['data_recent'] = $this->main->get('t_blog', 1, 3, false, array('param' => 'id', 'by' => 'desc'));

            $this->load->view('template', $this->data);
        }else{
            show_404();
        }

    }

    public function sendEmail()
    {

        $this->load->helper('email_helper');


                $email = "dede.irawan1213@gmail.com";
                #Send Email Confirm
                error_reporting(0);
                $subject = "Info Registrasi MitraReseller.com";
                $message = "Terimakasih anda telah mendaftarkan diri untuk menjadi rekan Mitrareseller.com. <br>
                            klik tautan berikut untuk mengkonfirmasi akun anda :<br><br><br><br>
                            Ayo manfaatkan media sosial yang anda gunakan untuk hal yang positif dan menambah penghasilan.";

                $send = kirim_email($email, $subject, $message);
                if (!$send) {
                    #kirim email gagal ke db
                    $this->main->create('m_email_monitoring', array('email' => $email, 'bug' => $this->email->print_debugger()));
                }


    }

}