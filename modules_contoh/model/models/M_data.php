<?php

class m_data extends CI_Model {

    function __construct() {
        parent::__construct();
    }

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
       
       
            
            $query = "SELECT  * FROM model ";
       
      
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

}