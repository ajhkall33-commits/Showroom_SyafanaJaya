<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai_setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_settings() {
        $settings = array();
        $query = $this->db->get('ai_settings');
        if ($query) {
            foreach ($query->result_array() as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
        return $settings;
    }

    public function save_setting($key, $value, $desc = '') {
        $this->db->where('setting_key', $key);
        $exists = $this->db->get('ai_settings')->num_rows();

        if ($exists > 0) {
            $this->db->where('setting_key', $key);
            return $this->db->update('ai_settings', array(
                'setting_value' => $value,
                'updated_at'    => date('Y-m-d H:i:s')
            ));
        } else {
            return $this->db->insert('ai_settings', array(
                'setting_key'   => $key,
                'setting_value' => $value,
                'description'   => $desc,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ));
        }
    }
}
