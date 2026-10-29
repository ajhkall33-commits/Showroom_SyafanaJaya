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

    function deleteData($t, $w){
        $this->db->where($w);
        return $this->db->delete($t);
    }

    function getWhere($t, $w, $o = false){
       
        if($o == false){
          return $this->db->get_where($t, $w);
        }else{
          $exp = explode(' ',$o);
          return $this->db->order_by($exp[0], $exp[1])->get_where($t, $w);
        }
    }

    function getPersonilJadwal($id_unit = null) {
        $sql = "SELECT u.*, r.name_role 
                FROM user u 
                LEFT JOIN role r ON r.id = u.type_user
                WHERE u.status = 1 ";
        $params = array();
        if (!empty($id_unit)) {
            $sql .= " AND u.unit_kerja = ? ";
            $params[] = $id_unit;
        }
        $sql .= " AND u.type_user IN (1, 101, 102, 103, 107, 109, 110, 111)
                  ORDER BY FIELD(u.type_user, 103, 101, 109, 110, 111, 102, 107, 1), u.nama ASC";
        return $this->db->query($sql, $params)->result_array();
    }

}