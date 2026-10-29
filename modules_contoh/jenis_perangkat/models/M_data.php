<?php

class m_data extends CI_Model {

    // var $table = 'KM_UNIT_BSC';
    // var $unit_table = 'MASTER_UNIT_BISNIS';
    // var $log_table = 'KM_UNIT_BSC_HIS';

    function __construct() {
        parent::__construct();
    }

    /* BEGIN CREATE */

 
    // function insert($PK) {
    //     $post = $this->input->post();
    //     $this->db->set('TANGGAL', "to_date('$post[TANGGAL]','yyyy-mm-dd hh24:mi:ss')", FALSE);
    //     $this->db->set('PK', $PK, FALSE);
        
    //     unset($post['TANGGAL']);
    //     unset($post['DataTables_Table_0_length']);

    //     // var_dump($this->db->insert($this->table, $post)); die();
    //     $this->db->insert($this->table, $post);
    //     return $this->log('insert', $PK);

    // }


    function insertData($t,$data){
        $insert = $this->db->insert($t,$data);
        if ($insert) {
            
            return true;
        } else {
            return false;
        }
    }

    function delete($t,$w){
		$this->db->where($w);
		$this->db->delete($t);
	}

    function updateData($t, $w, $d){
      
        $this->db->where($w);
        $this->db->update($t, $d);
    }

    function getMasterPerangkat(){
       
       
            
            $query = "SELECT  * FROM perangkat ";
       
      
        $res_query = $this->db->query($query);

        return $res_query;
    
    }

    function getWhere($t, $w, $o = false){
       
        if($o == false){
          return $this->db->get_where($t, $w);
        }else{
          $exp = explode(' ',$o);
          return $this->db->order_by($exp[0], $exp[1])->get_where($t, $w);
        }
    }

    function SetQuery($param){
        $query = $param;
        $res_query = $this->db->query($query);

        return $res_query;
    }

    function get_join_WhereCustom($tb1, $tb2, $j, $j2, $c = false){
        $this->db->select("$tb1.*, $tb2.*, $tb1.status as masalah_status");
        if($c == false){
          $this->db->from($tb1);
          return $this->db->join($tb2, $tb1.'.'.$j.' = '.$tb2.'.'.$j2)->get();
        }else{
          $this->db->from($tb1);
          $this->db->join($tb2, $tb1.'.'.$j.' = '.$tb2.'.'.$j2);
          return $this->db->where($tb1.'.'.$j, $c)->get();
        }
      }


}