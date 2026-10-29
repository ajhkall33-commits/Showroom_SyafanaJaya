<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ai_analytics extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->role();
        $this->load->model('Ai_analytics_model');
    }

    private function role() {
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    public function index() {
        $data["plugin"][] = "plugin/datatable";
        $data["title"] = "AI Analytics Dashboard";
        $data["title_des"] = "Laporan Penggunaan Token & Request AI";
        $data["content"] = "ai_analytics/v_analytics";

        $data['stats']    = $this->Ai_analytics_model->get_overall_stats();
        $data['providers']= $this->Ai_analytics_model->get_provider_breakdown();
        $data['logs']     = $this->Ai_analytics_model->get_recent_usage(20);
        $data['trend']    = $this->Ai_analytics_model->get_daily_trend(7);
        $data['data']     = $data;

        $this->load->view('template_v2', $data);
    }
}
