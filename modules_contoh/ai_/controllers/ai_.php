<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ai_ extends MX_Controller {

    public function index() {
        redirect(base_url('ai_chat'));
    }
}