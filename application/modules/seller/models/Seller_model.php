<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Seller_model extends CI_Model
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

    #++++++++++++++++++++++++++++ GETWHERE CUSTOM

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

    #++++++++++++++++++++++++++++ JOIN

    function getJoin($table, $table2, $table3, $param1, $param2, $param3, $isresult = false, $limit = false, $group = false, $order = false,$offset = false){
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

        if($table3){
            $this->db->join($table3, $table.".".$param1."=".$table3.".".$param3 );
        }


        $this->db->join($table2, $table.".".$param1."=".$table2.".".$param2 );
        $rea = $this->db->get($table);

        if($isresult == 1){
            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        }else{
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }

    }

    #++++++++++++++++++++++++++++ WHERE JOIN

    function getwhereJoin($table, $table2, $table3, $param1, $param2, $param3, $where, $isresult = false, $limit = false, $group = false, $order = false,$offset = false){

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

        if($table3){
            $this->db->join($table3, $table.".".$param1."=".$table3.".".$param3 );
        }

        $this->db->join($table2, $table.".".$param1."=".$table2.".".$param2 );

        $rea = $this->db->get_where($table,$where);

        if($isresult == 1){
            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        }else{
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }

    }



    #++++++++++++++++++++++++++++ GET LIKE

    function getlike($table,$where = false, $like = false, $limit = false,$group = false,$order = false, $offset=false){
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
            $this->db->where($where);
        }
        if($offset){
            $this->db->offset($offset);
        }
        if($like){
            $this->db->like($like['param'], $like['value']);
        }


        $rea = $this->db->get($table);
        return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);

    }

    #++++++++++++++++++++++++++++ GET LIKE JOIN

    function getlikejoin($table, $table2, $table3 = false, $param1, $param2, $param3 = false, $where, $like = false, $limit,$group = false,$order = false,$offset = false){
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
        if($where){
            $this->db->where($where);
        }
        if($like){
            $this->db->like($like['param'], $like['value']);
        }
        $this->db->join($table2, $table.".".$param1."=".$table2.".".$param2 );

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

    #load Table

    function load_tb_riwayat_transaksi($nm_catalog) {
        $this->datatables->select('id,no_invoice,total_pembayaran,batas_waktu');
        $this->datatables->from('t_transaksi');
        $this->datatables->where(array('nm_catalog'=>$nm_catalog,'status'=>4));

        return $this->datatables->generate();
    }




}