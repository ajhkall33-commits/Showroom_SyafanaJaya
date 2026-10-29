<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Url_barcode extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->role();
    }

    private function role()
    {
        $url = urlencode(current_url());
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    public function index()
    {
        // Add required plugins, including the new html5-qrcode
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        
        $data["title"] = "Scan Barcode";
        $data["title_des"] = "Pemindai Barcode / QR Code";
        $data["content"] = "v_scan";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
    }

}
