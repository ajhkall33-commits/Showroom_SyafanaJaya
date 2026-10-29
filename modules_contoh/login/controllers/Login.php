<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("user/m_user");
    }
	
	public function auth()
	{
        $this->load->view('login');
	}

    public function index() {
        //die;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|trim');

        $this->form_validation->set_error_delimiters('<li>', '</li>');

        $u_name = strtolower($this->input->post('username'));
        
        $u_pass = $this->input->post('password');
        $this->session->set_flashdata("username2", $u_name);
        $this->session->set_flashdata("userid", $u_name);

        
        
        if ($this->form_validation->run() !== FALSE) {
            //echo "OK"; die;
            

            $login = array($u_name, $u_pass);

            if($this->m_user->login()){
                $this->m_user->log_login();
               redirect("?login=true");
            }else {
                $this->session->set_flashdata("pesan", warning("Username atau Password Anda tidak valid!", null, false));
               redirect("?login=true");
            }
        } else {
          
           $this->session->set_flashdata("pesan", warning(validation_errors(), null, false));
            redirect("?login=true");
        }
        
    }

 
  

   
    function logout() {
        $this->session->sess_destroy();

        redirect("");
    }

}
