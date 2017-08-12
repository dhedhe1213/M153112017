<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
* 
*/
class Dpanel extends CI_Controller
{
	public $data = array('title' => 'Dpanel Version 3.0');

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','role_form_helper'));
		$this->load->library('form_validation');
		$this->load->model('Login_model', 'login', TRUE);
	}

	public function index()
	{
		if($this->session->userdata('login') == 'admin' )
		{
			redirect('dashboard');

		}else{
			$this->load->view('login', $this->data);
		}
	}

    public function act_login()
    {

        $email = strip_tags($this->input->post('email'));
        $password = strip_tags(hash('sha256',$this->input->post('password')));

        if(validation_login())
            {
                $getMaxLogin = $this->db->get_where('m_admin',array('email'=>$email))->row_array();
                if($getMaxLogin['max_login'] > 25){
                    $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>'Akun Anda di block admin!Silahkan hubungi CS Kami');
                    echo json_encode($response);
                    exit;
                }

                if($this->login->cek_login($email,$password))
                {
                    $this->db->update('m_admin',array('max_login'=>NULL),array('email'=>$email));
                    $response = array('error'=>false,'title'=>'Sign in Berhasil','pesan'=>'');
                    echo json_encode($response);
                }else{
                    $maxLogin = $getMaxLogin['max_login']+1;
                    $this->db->update('m_admin',array('max_login'=>$maxLogin),array('email'=>$email));
                    $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>'Username Atau Password Salah');
                    echo json_encode($response);
                }
            }else{
                $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>strip_tags(validation_errors()));
                echo json_encode($response);
            }

    }

    public function act_login_reseller()
    {

        $email = strip_tags($this->input->post('email'));
        $password = strip_tags(hash('sha256',$this->input->post('password')));

        if(validation_login())
        {
            $getMaxLogin = $this->db->get_where('m_user',array('email'=>$email))->row_array();
            if($getMaxLogin['max_login'] > 25){
                $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>'Akun Anda di block admin!Silahkan hubungi CS Kami');
                echo json_encode($response);
                exit;
            }

            if($this->login->cek_login_reseller($email,$password))
            {
                $cekEmailKonfirmasi = $this->login->cekEmailKonfirmasi($email);
                if($cekEmailKonfirmasi){
                    $this->db->update('m_user',array('max_login'=>NULL),array('email'=>$email));
                    $response = array('error'=>false,'title'=>'Sign in Berhasil','pesan'=>'');
                    echo json_encode($response);
                }else{
                    $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>'Email belum di konfirmasi!');
                    echo json_encode($response);
                }
            }else{
                $maxLogin = $getMaxLogin['max_login']+1;
                $this->db->update('m_user',array('max_login'=>$maxLogin),array('email'=>$email));
                $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>'Username Atau Password Salah');
                echo json_encode($response);
            }
        }else{
            $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }

    }

    public function act_login_seller()
    {

        $email = strip_tags($this->input->post('email'));
        $password = strip_tags(hash('sha256',$this->input->post('password')));

        if(validation_login())
        {
            $getMaxLogin = $this->db->get_where('m_user',array('email'=>$email))->row_array();
            if($getMaxLogin['max_login'] > 25){
                $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>'Akun Anda di block admin!Silahkan hubungi CS Kami');
                echo json_encode($response);
                exit;
            }

            if($this->login->cek_login_seller($email,$password))
            {
                $cekEmailKonfirmasi = $this->login->cekEmailKonfirmasi($email);
                if($cekEmailKonfirmasi){
                    $this->db->update('m_user',array('max_login'=>NULL),array('email'=>$email));
                    $response = array('error'=>false,'title'=>'Sign in Berhasil','pesan'=>'');
                    echo json_encode($response);
                }else{
                    $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>'Email belum di konfirmasi!');
                    echo json_encode($response);
                }
            }else{
                $maxLogin = $getMaxLogin['max_login']+1;
                $this->db->update('m_user',array('max_login'=>$maxLogin),array('email'=>$email));
                $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>'Username Atau Password Salah');
                echo json_encode($response);
            }
        }else{
            $response = array('error'=>true,'title'=>'Sign in Gagal!','pesan'=>strip_tags(validation_errors()));
            echo json_encode($response);
        }

    }


    public function logout()
	{
        $this->session->unset_userdata('token');
        $this->session->unset_userdata(
            array('id'=>'','role_id'=>'','email' => '','name'=>'','login' => FALSE )
        );
        $this->session->sess_destroy();
		redirect('main');
	}

}