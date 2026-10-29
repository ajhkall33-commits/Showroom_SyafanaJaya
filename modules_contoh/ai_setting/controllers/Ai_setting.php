<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ai_setting extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->role();
        $this->load->model('Ai_setting_model');
        $this->load->library('Ai_provider');
    }

    private function role() {
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    public function index() {
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "AI Configuration Settings";
        $data["title_des"] = "Pengaturan Provider AI Groq & OpenAI";
        $data["content"] = "ai_setting/v_setting";

        $data['settings'] = $this->Ai_setting_model->get_all_settings();
        $data['data'] = $data;

        $this->load->view('template_v2', $data);
    }

    public function save() {
        $provider = $this->input->post('ai_provider');
        
        $groq_key = trim($this->input->post('groq_api_key'));
        $groq_model = trim($this->input->post('groq_model'));
        $openai_key = trim($this->input->post('openai_api_key'));
        $openai_model = trim($this->input->post('openai_model'));
        
        $cerebras_key = trim($this->input->post('cerebras_api_key'));
        $cerebras_model = trim($this->input->post('cerebras_model'));
        $gemini_key = trim($this->input->post('gemini_api_key'));
        $gemini_model = trim($this->input->post('gemini_model'));
        $openrouter_key = trim($this->input->post('openrouter_api_key'));
        $openrouter_model = trim($this->input->post('openrouter_model'));
        
        $system_prompt = trim($this->input->post('system_prompt'));

        if (!empty($provider)) {
            $this->Ai_setting_model->save_setting('ai_provider', $provider);
        }
        if (!empty($groq_key) || $groq_key === '') {
            $this->Ai_setting_model->save_setting('groq_api_key', $groq_key);
        }
        if (!empty($groq_model)) {
            $this->Ai_setting_model->save_setting('groq_model', $groq_model);
        }
        if (!empty($openai_key) || $openai_key === '') {
            $this->Ai_setting_model->save_setting('openai_api_key', $openai_key);
        }
        if (!empty($openai_model)) {
            $this->Ai_setting_model->save_setting('openai_model', $openai_model);
        }
        if (!empty($cerebras_key) || $cerebras_key === '') {
            $this->Ai_setting_model->save_setting('cerebras_api_key', $cerebras_key);
        }
        if (!empty($cerebras_model)) {
            $this->Ai_setting_model->save_setting('cerebras_model', $cerebras_model);
        }
        if (!empty($gemini_key) || $gemini_key === '') {
            $this->Ai_setting_model->save_setting('gemini_api_key', $gemini_key);
        }
        if (!empty($gemini_model)) {
            $this->Ai_setting_model->save_setting('gemini_model', $gemini_model);
        }
        if (!empty($openrouter_key) || $openrouter_key === '') {
            $this->Ai_setting_model->save_setting('openrouter_api_key', $openrouter_key);
        }
        if (!empty($openrouter_model)) {
            $this->Ai_setting_model->save_setting('openrouter_model', $openrouter_model);
        }
        if (!empty($system_prompt)) {
            $this->Ai_setting_model->save_setting('system_prompt', $system_prompt);
        }

        echo json_encode(array('status' => '200', 'msg' => 'Konfigurasi AI berhasil disimpan.'));
    }

    public function test_connection() {
        $provider = $this->input->post('provider');
        $apiKey   = trim($this->input->post('apiKey'));
        $model    = trim($this->input->post('model'));

        if (empty($apiKey)) {
            // Ambil dari DB jika dikosongkan
            $settings = $this->Ai_setting_model->get_all_settings();
            $key_field = $provider . '_api_key';
            $apiKey = isset($settings[$key_field]) ? $settings[$key_field] : '';
        }

        if (empty($apiKey)) {
            echo json_encode(array('status' => '400', 'msg' => 'API Key wajib diisi untuk melakukan pengujian.'));
            return;
        }

        $res = $this->ai_provider->test_connection($provider, $apiKey, $model);
        if ($res['success']) {
            echo json_encode(array('status' => '200', 'msg' => 'Koneksi ke ' . strtoupper($provider) . ' Berhasil! Respon: "' . substr($res['content'], 0, 50) . '..."'));
        } else {
            echo json_encode(array('status' => '500', 'msg' => 'Koneksi ke ' . strtoupper($provider) . ' Gagal: ' . $res['error']));
        }
    }
}
