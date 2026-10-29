<?php

class m_dashboard extends CI_Model {

    var $table = 'SETTING_DASHBOARD';

    function __construct() {
        parent::__construct();
    }

    function get_next_id_kor($ID = null) {
        $temp = clone $this;
        if (!$ID) {
            $ID = $this->db->query("SELECT CEMS.KOR_DIREKSI.nextval AS ID FROM DUAL")->row()->ID;
        }else{
            $ID++;
        }
        if ($temp->get_by_id($ID)) {
            $ID = $this->get_next_id_kor($ID);
        }
        return $ID;
    }

    function update($ID)
    {
        $post = $this->input->post();
        if (!isset($post['URL']) || $post['URL'] == '') {
            $post['URL'] = '/';
        }
        $post['URL'] = str_replace(' ', '', $post['URL']);
        $this->db->where('ID',$ID);
        return $this->db->update($this->table, $post);
    }

    function get_all_data()
    {
        return $this->db->get($this->table)->result();
    }

    function get_by_name($NAME)
    {
        $this->db->where('NAME',$NAME);
        return $this->db->get($this->table)->row();
    }
}