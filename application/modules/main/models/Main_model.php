<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Main_model extends CI_Model
{
    function get($table,$isresult =false,$limit = false,$group = false,$order = false,$offset = false){
        if($isresult){
            if($limit){
                $this->db->limit($limit);
            }
            if($group){
                $this->db->group_by($group);
            }
            if($order){
                $this->db->order_by($order['param'],$order['by']);
            }
            if($offset){
                $this->db->offset($offset);
            }
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        }else{
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }
    }

    #++++++++++++++++++++++++++++ GETWHERE

    function getwhere($table,$parameter,$isresult = false,$limit = false,$group = false,$order = false, $offset = false){
        if($isresult == 1){
            if($limit){
                $this->db->limit($limit);
            }
            if($group){
                $this->db->group_by($group);
            }
            if($order){
                $this->db->order_by($order['param'],$order['by']);
            }
            if($offset){
                $this->db->offset($offset);
            }
            $rea = $this->db->get_where($table, $parameter);
            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        }else{
            $rea = $this->db->get_where($table, $parameter);
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }
    }

    #++++++++++++++++++++++++++++ JOIN

    function getJoin($table, $table2, $param1, $param2, $isresult = false){

        // $this->db->select('*');
        // $this->db->from($table);
        $this->db->join($table2, $table.".".$param1."=".$table2.".".$param2 );

        $rea = $this->db->get($table);

        if($isresult == 1){
            return ($rea->result_array());
        }else{
            return ($rea->row_array());
        }

    }

    #++++++++++++++++++++++++++++ WHERE JOIN

    function getwhereJoin($table, $table2, $param1, $param2, $isresult = false,$where,$limit = false,$order = false){

        if($limit){
            $this->db->limit($limit);
        }
        if($order){
            $this->db->order_by($order['param'],$order['by']);
        }

        $this->db->join($table2, $table.".".$param1."=".$table2.".".$param2 );
        $rea = $this->db->get_where($table,$where);

        if($isresult == 1){
            return ($rea->result_array());
        }else{
            return ($rea->row_array());
        }

    }

    #++++++++++++++++++++++++++++ GETWHERE CUSTOM

    function getwhereCustom($table,$select,$parameter,$isresult = false,$limit = false,$group = false,$order = false){
        if($isresult == 1){
            $this->db->select(array($select));
            if($limit){
                $this->db->limit($limit);
            }
            if($group){
                $this->db->group_by($group);
            }
            if($order){
                $this->db->order_by($order['param'],$order['by']);
            }
            $this->db->where($parameter['param'],$parameter['value']);
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        }else{
            $this->db->select(array($select));
            $this->db->where($parameter['param'],$parameter['value']);
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }
    }

    #++++++++++++++++++++++++++++ GET LIKE

    function getlike($table,$parameter,$where = false,$limit = false,$group = false,$order = false){
        if($limit){
            $this->db->limit($limit);
        }
        if($group){
            $this->db->group_by($group);
        }
        if($order){
            $this->db->order_by($order['param'],$order['by']);
        }
        if($where){
            $this->db->where($where['param'],$where['value']);
        }
        $this->db->like($parameter['param'], $parameter['value']);
        $rea = $this->db->get($table);
        return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);

    }

    #++++++++++++++++++++++++++++ GET Last Row

    function getLastRow($table = false,$param){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($param,'DESC');
        $this->db->limit(1);
        $rea = $this->db->get();
        return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
    }


    #+++++++++++++ GET JOIN Custom

    function getItemclassId($id = false){

        $this->db->select(array('p.ID AS parent_id',
            'p.NAME AS parent_name',
            'c1.ID AS child_id',
            'c1.NAME AS child_name',
            'c2.ID AS child_id2',
            'c2.NAME AS child_name2'));
        $this->db->from('TR_ITEMCLASS p');
        $this->db->join('TR_ITEMCLASS c1','c1.PARENT_ID = p.ID','inner');
        $this->db->join('TR_ITEMCLASS c2','c2.PARENT_ID = c1.ID','inner');
        $this->db->where('p.PARENT_ID',0);
        $this->db->where('c2.ID',$id);
        $check = $this->db->get();
        return ($check->num_rows()>0 ? $check->row_array() : FALSE);
    }

    #+++++++++++++ INSERT

    function create($table,$data) {

        $ins = $this->db->insert($table, $data);

        return ($ins ? TRUE : FALSE);

    }

    #+++++++++++++ UPDATE

    function update($table,$parameter, $data) {
        $upd = $this->db->update($table, $data, $parameter);
        return ($upd ? TRUE : FALSE);
    }

    #+++++++++++++ DELETE

    function delete($table,$param) {

        $del = $this->db->delete($table, $param);

        return ($del ? TRUE : FALSE);

    }

    #++++++++++++++ cek user login Google
    public function checkUser($data = array()){

        $this->db->select('*');
        $this->db->from('m_user');
        $this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
        $prevQuery = $this->db->get();
        $prevCheck = $prevQuery->num_rows();


        if($prevCheck > 0){
            $prevResult = $prevQuery->row_array();
            $data['modified'] = date("Y-m-d H:i:s");
            $update = $this->db->update('m_user',$data,array('id'=>$prevResult['id']));
            $userID = $prevResult['id'];

            //reset userdata dulu biar aman
            $this->session->set_userdata(array('id' => '','role_id' => '','email' => '','login' => '','name'=>'' ));
            //end

            $data = array('id' => $prevResult['id'],'role_id' => $prevResult['role_id'],'email'=>$data['email'],'name' => $prevResult['name'],'login' => 'reseller' );
            $this->session->set_userdata($data);

            //update id_session untuk single device
            $this->db->update('log_sessions', array('id_sessions' => session_id(), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'last_date' => date('Y-m-d H:i:s')),array('id_user' => $prevResult['id']));


        }else{
            $data['created'] = date("Y-m-d H:i:s");
            $data['modified'] = date("Y-m-d H:i:s");
            $insert = $this->db->insert('m_user',array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid'],'name'=>$data['name'],'email'=>$data['email'],'picture_url'=>$data['picture_url'],'confirm'=>'true','role_id'=>1));
            $userID = $this->db->insert_id();

            //reset userdata dulu biar aman
            $this->session->set_userdata(array('id' => '','role_id' => '','email' => '','login' => '','name'=>'' ));
            //end

            $data = array('id' => $userID,'role_id' => 1,'email'=>$data['email'], 'name' => $data['name'],'login' => 'reseller' );
            $this->session->set_userdata($data);

            //Insert id_session untuk single device
            $this->db->insert('log_sessions', array('id_user' => $userID, 'id_sessions' => session_id(), 'ip_address' => $_SERVER['REMOTE_ADDR'], 'last_date' => date('Y-m-d H:i:s')));

        }


        return $userID?$userID:FALSE;
    }



}