<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai_analytics_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_overall_stats() {
        $today = date('Y-m-d');
        $this_month = date('Y-m');

        $total_requests = $this->db->count_all('ai_usage');
        
        $today_requests = $this->db->like('created_at', $today, 'after')->count_all_results('ai_usage');

        $month_requests = $this->db->like('created_at', $this_month, 'after')->count_all_results('ai_usage');

        $tokens = $this->db->select('SUM(input_tokens) as total_input, SUM(output_tokens) as total_output, SUM(total_tokens) as total_tokens')
                           ->from('ai_usage')
                           ->get()
                           ->row_array();

        return array(
            'total_requests' => $total_requests,
            'today_requests' => $today_requests,
            'month_requests' => $month_requests,
            'total_input'    => $tokens['total_input'] ? (int)$tokens['total_input'] : 0,
            'total_output'   => $tokens['total_output'] ? (int)$tokens['total_output'] : 0,
            'total_tokens'   => $tokens['total_tokens'] ? (int)$tokens['total_tokens'] : 0
        );
    }

    public function get_provider_breakdown() {
        return $this->db->select('provider, COUNT(id) as total_requests, SUM(total_tokens) as total_tokens')
                        ->from('ai_usage')
                        ->group_by('provider')
                        ->get()
                        ->result_array();
    }

    public function get_recent_usage($limit = 20) {
        return $this->db->select('u.*, usr.nama as user_name')
                        ->from('ai_usage u')
                        ->join('user usr', 'usr.id = u.user_id', 'left')
                        ->order_by('u.id', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->result_array();
    }

    public function get_daily_trend($days = 7) {
        $sql = "SELECT DATE(created_at) as date_label, COUNT(id) as req_count, SUM(total_tokens) as token_sum
                FROM ai_usage 
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                GROUP BY DATE(created_at)
                ORDER BY date_label ASC";
        return $this->db->query($sql, array($days))->result_array();
    }
}
