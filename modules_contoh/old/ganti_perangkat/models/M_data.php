<?php

class m_data extends CI_Model {

    
    public function get_lokasi_options() {
        $query = $this->db->get('tiket');
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
      
    
    //Model Untuk memanggil data button down 
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
      return $this->db->insert('ganti_perangkat', $data);
    }


    // Model untuk memanggil data read only
    public function getidfasilitas(){
      $this->db->select_max('id_fasilitas');
      $query = $this->db->get('tiket');
      $row = $query->row();

      return $row->id_fasilitas;
    }

    public function getnotiket(){
      $this->db->select_max('no_tiket');
      $query = $this->db->get('tiket');
      $row = $query->row();

      return $row->no_tiket;
    }

    public function getidlokasi(){
      $this->db->select_max('id_lokasi');
      $query = $this->db->get('tiket');
      $row = $query->row();

      return $row->id_lokasi;
    }

    
   

}