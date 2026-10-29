<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	protected $api_key;

    function __construct() {
        parent::__construct();
        $this->api_key = str_replace('"', '', file_get_contents('https://pronia.plnindonesiapower.co.id:3000/api/tableau'));
        $this->load->model("m_dashboard");
    }

    public function ap()
    {
        $item = $this->m_dashboard->get_by_name('AP');
        $data = ['position' => 'dashboard/ap'];
        $data = access($data,"VIEW");
        $data["title"] = "Dashboard Anak Perusahaan";
        $data["content"] = "v_dashboard";
        $data['dashboard_url'] = "https://pronia.indonesiapower.co.id:3060/trusted/".$this->api_key.$item->URL;
        $this->load->view('template_v2', $data);
    }

    public function pbr()
    {
        $item = $this->m_dashboard->get_by_name('PBR');
    	$data = ['position' => 'dashboard/pbr'];
        $data = access($data,"VIEW");
        $data["title"] = "Dashboard PBR";
        $data["content"] = "v_dashboard";
    	$data['dashboard_url'] = "https://pronia.indonesiapower.co.id:3060/trusted/".$this->api_key.$item->URL;
        //echo "<pre>", print_r($data), "</pre>";
        $this->load->view('template_v2', $data);
    }

    public function unit()
    {
        $item = $this->m_dashboard->get_by_name('UNIT');
        $data = ['position' => 'dashboard/unit'];
        $data = access($data,"VIEW");
        $data["title"] = "Dashboard UNIT";
        $data["content"] = "v_dashboard";
        $data['dashboard_url'] = "https://pronia.indonesiapower.co.id:3060/trusted/".$this->api_key.$item->URL;
        
        $this->load->view('template_v2', $data);
    }

    public function setting()
    {
        $data = ['position' => 'dashboard/setting'];
        $data = access($data, 'VIEW');
        $data['title'] = 'Setting Dashboard';
        $data['content'] = 'v_setting';
        $data['items'] = $this->m_dashboard->get_all_data();
        // echo var_dump($data['items']); die();
        $this->load->view('template_v2', $data);
    }

    public function update($ID)
    {
        $this->m_dashboard->update($ID);
        redirect('/dashboard/setting');
    }
}