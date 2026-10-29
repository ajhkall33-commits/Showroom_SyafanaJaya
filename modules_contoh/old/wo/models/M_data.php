<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_data extends CI_Model {

    
    public function get_lokasi_options() {
        $query = $this->db->get('master_lokasi');
        return $query->result();
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

    function getWhere($t, $w, $o = false){
       
        if($o == false){
          return $this->db->get_where($t, $w);
        }else{
          $exp = explode(' ',$o);
          return $this->db->order_by($exp[0], $exp[1])->get_where($t, $w);
        }
    }

    public function save_data($data) {
      // Insert data into the database
      return $this->db->insert('wo', $data);
  }
   
  }


    


