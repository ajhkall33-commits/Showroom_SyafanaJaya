<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Dasbord extends CI_Controller {

    function __construct() {
        parent::__construct();
     
        $this->load->model("m_data");
        $this->load->library('Ciqrcode');
       // $this->role();
    }

   
    public function index() {

    }

}