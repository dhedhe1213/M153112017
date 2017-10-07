<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Dashboard_model extends CI_Model
{
    #+++++++++++++ GET

    function get($table, $isresult = false, $limit = false, $group = false, $order = false)
    {
        if ($isresult) {
            if ($limit) {
                $this->db->limit($limit);
            }
            if ($group) {
                $this->db->group_by($group);
            }
            if ($order) {
                $this->db->order_by($order['param'], $order['by']);
            }
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        } else {
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }
    }

    function getwhere($table, $parameter, $isresult = false, $limit = false, $group = false, $order = false)
    {
        if ($isresult == 1) {
            if ($limit) {
                $this->db->limit($limit);
            }
            if ($group) {
                $this->db->group_by($group);
            }
            if ($order) {
                $this->db->order_by($order['param'], $order['by']);
            }
            $rea = $this->db->get_where($table, $parameter);
            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        } else {
            $rea = $this->db->get_where($table, $parameter);
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }
    }

    #++++++++++++++++++++++++++++ GETWHERE CUSTOM

    function getwhereCustom2($table,$select,$parameter,$isresult = false,$limit = false,$group = false,$order = false){
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

    function count($table, $parameter)
    {
            $rea = $this->db->get_where($table, $parameter);
            return ($rea->num_rows() > 0 ? $rea->num_rows() : FALSE);
    }


    function getJoin($table, $table2, $param, $isresult = false)
    {

        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($table2, $table . "." . $param . "=" . $table2 . "." . $param);
        $rea = $this->db->get();

        if ($isresult == 1) {
            return ($rea->result_array());
        } else {
            return ($rea->row_array());
        }

    }

    function getwhereCustom($table, $select, $parameter, $isresult = false, $limit = false, $group = false, $order = false)
    {
        if ($isresult == 1) {
            $this->db->select(array($select));
            if ($limit) {
                $this->db->limit($limit);
            }
            if ($group) {
                $this->db->group_by($group);
            }
            if ($order) {
                $this->db->order_by($order['param'], $order['by']);
            }
            $this->db->where($parameter['param'], $parameter['value']);
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);
        } else {
            $this->db->select(array($select));
            $this->db->where($parameter['param'], $parameter['value']);
            $rea = $this->db->get($table);
            return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
        }
    }

    function getlike($table, $parameter, $where = false, $limit = false, $group = false, $order = false)
    {
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($group) {
            $this->db->group_by($group);
        }
        if ($order) {
            $this->db->order_by($order['param'], $order['by']);
        }
        if ($where) {
            $this->db->where($where['param'], $where['value']);
        }
        $this->db->like($parameter['param'], $parameter['value']);
        $rea = $this->db->get($table);
        return ($rea->num_rows() > 0 ? $rea->result_array() : FALSE);

    }

    function getLastRow($table = false, $param)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($param, 'DESC');
        $this->db->limit(1);
        $rea = $this->db->get();
        return ($rea->num_rows() > 0 ? $rea->row_array() : FALSE);
    }

    #+++++++++++++ INSERT

    function create($table, $data)
    {

        $ins = $this->db->insert($table, $data);

        return ($ins ? TRUE : FALSE);

    }

    #+++++++++++++ UPDATE

    function update($table, $parameter, $data)
    {
        $upd = $this->db->update($table, $data, $parameter);
        return ($upd ? TRUE : FALSE);
    }

    #+++++++++++++ DELETE

    function delete($table, $param)
    {

        $del = $this->db->delete($table, $param);

        return ($del ? TRUE : FALSE);

    }

    #++++++++++++++++++ Custom Query For Services +++++++++++++++#
    public function getproperty($id = false, $isResult = false)
    {

        $this->db->select('tr_home.*,tr_home_detail.*,tr_area.*,tr_jenis.*,tr_cluster.*');
        $this->db->from('tr_home');
        $this->db->join('tr_area', 'tr_area.id = tr_home.id_area');
        $this->db->join('tr_jenis', 'tr_jenis.id = tr_home.id_jenis');
        $this->db->join('tr_cluster', 'tr_cluster.id = tr_home.id_cluster');
        $this->db->join('tr_home_detail', 'tr_home_detail.id = tr_home.id_home_detail');
        if ($id) {
            $this->db->where('id_home', $id);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            if ($isResult) {
                return $query->row_array();
            } else {
                return $query->result_array();
            }
        } else {
            return false;
        }

    }


    public  function insert_home_menu($id_home)
    {

        $sql = "INSERT INTO tr_home_menu_detail
          (name_menu,id_home)
          SELECT name_menu,?
          FROM tr_home_menu WHERE id IS NOT NULL;";
        $query = $this->db->query($sql, array($id_home));

        return ($query ? TRUE : FALSE);

    }

/*+++++++++++++++++++++++++++++++++++++++DATATABLES QUERY++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    function load_tb_about($cat) {
        $this->datatables->select('id,title,MID(description,1,85) AS description');
        $this->datatables->from('t_about');
        $this->datatables->where(array('category'=>$cat));
        $this->datatables->add_column('view', '<a href='.base_url('dashboard/edit_about/$1').' class="edit-record btn btn-default fa fa-pencil"></a> <a href="#" onclick="delete_global($1);" class="btn btn-default fa fa-trash-o" data-table="t_about"></a>', 'id');
        return $this->datatables->generate();
    }

    function load_tb_blog($cat) {
        $this->datatables->select('id,title,MID(description,1,85) AS description,thumbnail');
        $this->datatables->from('t_blog');
        $this->datatables->where(array('category'=>$cat));
        $this->datatables->add_column('view', '<a href='.base_url('dashboard/edit_blog/$1').' class="edit-record btn btn-default fa fa-pencil"></a> <a href="#" onclick="delete_global($1);" class="btn btn-default fa fa-trash-o" data-table="t_blog"></a>', 'id');
        return $this->datatables->generate();
    }

}