<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Login_model extends CI_Model
{
	function cek_login($email,$password)
	{
		$query = $this->db->get_where('m_admin', array('email'=>$email,'password'=>$password),1);

		if ($query->num_rows() == 1)
		{
            //reset userdata dulu biar aman
            $this->session->set_userdata(array('id' => '','role_id' => '','email' => '','login' => '','name'=>'' ));
            //end

            $row = $query->row_array();
            $data = array('id' => $row['id'],'role_id' => $row['role_id'],'email' => $row['email'],'login' => 'admin' );
            $this->session->set_userdata($data);
            //Insert or update id_session untuk single device
            $cek_log = $this->db->get_where('log_sessions',array('id_user'=>$row['id']),1);
            if($cek_log->num_rows() == 1) {
                $this->db->update('log_sessions', array('id_sessions' => session_id(), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'last_date' => date('Y-m-d H:i:s')),array('id_user' => $row['id']));
            }else{
                $this->db->insert('log_sessions', array('id_user' => $row['id'], 'id_sessions' => session_id(), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'last_date' => date('Y-m-d H:i:s')));
            }
            return TRUE;

		} else	{
			return FALSE;
		}
	}

    function cek_login_reseller($email,$password)
    {
        $query = $this->db->get_where('m_user', array('email'=>$email,'password'=>$password),1);

        if ($query->num_rows() == 1)
        {
            //reset userdata dulu biar aman
            $this->session->set_userdata(array('id' => '','role_id' => '','email' => '','login' => '','name'=>'' ));
            //end

            $row = $query->row_array();
            $data = array('id' => $row['id'],'role_id' => $row['role_id'],'email'=>$email,'name' => $row['name'],'login' => 'reseller' );
            $this->session->set_userdata($data);
            //Insert or update id_session untuk single device
            $cek_log = $this->db->get_where('log_sessions',array('id_user'=>$row['id']),1);
            if($cek_log->num_rows() == 1) {
                $this->db->update('log_sessions', array('id_sessions' => session_id(), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'last_date' => date('Y-m-d H:i:s')),array('id_user' => $row['id']));
            }else{
                $this->db->insert('log_sessions', array('id_user' => $row['id'], 'id_sessions' => session_id(), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'last_date' => date('Y-m-d H:i:s')));
            }
            return TRUE;
        } else	{
            return FALSE;
        }
    }

    function cek_login_seller($email,$password)
    {
        $query = $this->db->get_where('m_user', array('email'=>$email,'password'=>$password,'role_id'=>2),1);

        if ($query->num_rows() == 1)
        {
            //reset userdata dulu biar aman
            $this->session->set_userdata(array('id' => '','role_id' => '','email' => '','login' => '','name'=>'' ));
            //end

            $row = $query->row_array();
            $data = array('id' => $row['id'],'role_id' => $row['role_id'],'email'=>$email,'name' => $row['name'],'login' => 'seller' );
            $this->session->set_userdata($data);
            //Insert or update id_session untuk single device
            $cek_log = $this->db->get_where('log_sessions',array('id_user'=>$row['id']),1);
            if($cek_log->num_rows() == 1) {
                $this->db->update('log_sessions', array('id_sessions' => session_id(), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'last_date' => date('Y-m-d H:i:s')),array('id_user' => $row['id']));
            }else{
                $this->db->insert('log_sessions', array('id_user' => $row['id'], 'id_sessions' => session_id(), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'last_date' => date('Y-m-d H:i:s')));
            }
            return TRUE;
        } else	{
            return FALSE;
        }
    }

    function cekEmailKonfirmasi($email = false){
        $query = $this->db->get_where('m_user',array('email'=>$email,'confirm'=>'true'))->num_rows();
        if($query > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}