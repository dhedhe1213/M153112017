<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Catalog_model extends CI_Model
{
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

    function getwherein($table,$parameter2,$isresult = false,$limit = false,$group = false,$order = false, $offset = false){
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
            $this->db->where_in('id',$parameter2);
            $rea = $this->db->get($table);

            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        }else{
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }
    }

    function getwherein2($table,$parameter2,$parameter3,$isresult = false,$limit = false,$group = false,$order = false, $offset = false){
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
            $this->db->where_in('id',$parameter2);
            $this->db->where('id_user',$parameter3);
            $rea = $this->db->get($table);

            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        }else{
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }
    }



    function getlikein($table,$where = false, $like = false, $limit = false,$group = false,$order = false, $offset=false){
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
        if($like){
            $this->db->like($like['param'], $like['value']);
        }

        $this->db->where_in('id',$where);

        $rea = $this->db->get($table);
        return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);

    }

    function getlikejoinin($table, $table2, $table3 = false, $param1, $param2, $param3 = false, $where, $like = false, $limit,$group = false,$order = false,$offset = false){
        if($limit['start']){
            $this->db->limit($limit['limit'],$limit['start']);
        }else{
            $this->db->limit($limit['limit']);
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
        if($table3){
            $this->db->join($table3, $table.".".$param1."=".$table3.".".$param3 );
        }

        if($like){
            $this->db->like($like['param'], $like['value']);
        }

        $this->db->where_in('id',$where);

        $this->db->join($table2, $table.".".$param1."=".$table2.".".$param2 );

        $rea = $this->db->get($table);
        return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);

    }

    function getwhereCustom($table,$select,$parameter,$isresult = false,$limit = false,$group = false,$order = false){
        if($isresult == 1){

            if($select) {
                $this->db->select($select);
            }

            if($limit['start']){
                $this->db->limit($limit['limit'],$limit['start']);
            }else{
                $this->db->limit($limit['limit']);
            }

            if($group){
                $this->db->group_by($group);
            }
            if($order){
                $this->db->order_by($order['param'],$order['by']);
            }
            $this->db->where($parameter);
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        }else{
            $this->db->select(array($select));
            $this->db->where($parameter);
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }
    }

    function update($table,$parameter, $data) {
        $upd = $this->db->update($table, $data, $parameter);
        return ($upd ? TRUE : FALSE);
    }

    function create($table,$data) {

        $ins = $this->db->insert($table, $data);

        return ($ins ? TRUE : FALSE);

    }



}