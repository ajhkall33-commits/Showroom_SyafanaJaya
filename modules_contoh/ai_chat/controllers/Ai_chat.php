<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ai_chat extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->role();
        $this->load->model('Ai_chat_model');
        $this->load->library('Ai_provider');
    }

    private function role() {
        if (session("username") == "") {
            redirect(base_url('login/auth'));
        }
    }

    public function index() {
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "AI Chatbot";
        $data["title_des"] = "Asisten Cerdas Database MPS (Main Power Station)";
        $data["content"] = "ai_chat/v_chat";

        $user_id = session('id') ? session('id') : 1;
        $data['conversations'] = $this->Ai_chat_model->get_user_conversations($user_id);
        $data['data'] = $data;

        $this->load->view('template_v2', $data);
    }

    /**
     * Endpoint utama pengiriman pesan AJAX
     */
    public function send() {
        header('Content-Type: application/json');

        try {
            $user_id = session('id') ? session('id') : 1;
            $user_unit = session('unit') ? session('unit') : null;

            $message = trim($this->input->post('message'));
            $conversation_id = (int)$this->input->post('conversation_id');

            if (empty($message)) {
                echo json_encode(array('status' => '400', 'msg' => 'Pesan tidak boleh kosong.'));
                return;
            }

            // Auto-create conversation jika belum ada
            if (empty($conversation_id)) {
                $conversation_id = $this->Ai_chat_model->create_conversation($user_id, $message);
            } else {
                // Update timestamp
                $this->Ai_chat_model->update_conversation_title($conversation_id, $message);
            }

            // Simpan pesan User
            $this->Ai_chat_model->save_message($conversation_id, 'user', $message);

            // Ambil riwayat percakapan untuk kontinyuitas konteks (maks 10 pesan terakhir)
            $history = $this->Ai_chat_model->get_messages($conversation_id, 10);
            $payload_messages = array();
            foreach ($history as $h) {
                $payload_messages[] = array(
                    'role'    => $h['role'],
                    'content' => $h['content']
                );
            }

            // Ambil data kontekstual aktual dari database
            $db_context = $this->Ai_chat_model->build_context($message, $user_unit);

            // Provider Override
            $override_provider = trim($this->input->post('provider'));
            if ($override_provider === 'auto' || empty($override_provider)) {
                $override_provider = null;
            }

            // Request ke AI Provider
            $ai_response = $this->ai_provider->chat($payload_messages, $db_context, $override_provider);

            if ($ai_response['success']) {
                $assistant_reply = $ai_response['content'];

                // Simpan balasan AI
                $msg_id = $this->Ai_chat_model->save_message($conversation_id, 'assistant', $assistant_reply);

                // Log token usage ke database
                $this->Ai_chat_model->log_usage(
                    $user_id,
                    $conversation_id,
                    $ai_response['provider'],
                    $ai_response['model'],
                    $ai_response['input_tokens'],
                    $ai_response['output_tokens'],
                    $ai_response['total_tokens']
                );

                echo json_encode(array(
                    'status'          => '200',
                    'conversation_id' => $conversation_id,
                    'message_id'      => $msg_id,
                    'reply'           => $assistant_reply,
                    'provider'        => strtoupper($ai_response['provider']),
                    'model'           => $ai_response['model'],
                    'tokens'          => $ai_response['total_tokens']
                ));
            } else {
                echo json_encode(array(
                    'status'          => '200',
                    'conversation_id' => $conversation_id,
                    'message_id'      => 0,
                    'reply'           => 'Mohon maaf, terjadi gangguan saat menghubungi server AI. (Detail: ' . $ai_response['error'] . ')',
                    'provider'        => 'SYSTEM',
                    'model'           => 'error',
                    'tokens'          => 0
                ));
            }
        } catch (Throwable $e) {
            echo json_encode(array(
                'status'          => '200',
                'conversation_id' => $conversation_id ?? 0,
                'message_id'      => 0,
                'reply'           => 'Mohon maaf, sistem sedang mengalami kendala. Silakan coba beberapa saat lagi.',
                'provider'        => 'SYSTEM',
                'model'           => 'error',
                'tokens'          => 0
            ));
        }
    }

    public function get_conversations() {
        header('Content-Type: application/json');
        $user_id = session('id') ? session('id') : 1;
        $data = $this->Ai_chat_model->get_user_conversations($user_id);
        echo json_encode(array('status' => '200', 'data' => $data));
    }

    public function get_messages($conversation_id) {
        header('Content-Type: application/json');
        $messages = $this->Ai_chat_model->get_messages((int)$conversation_id);
        echo json_encode(array('status' => '200', 'data' => $messages));
    }

    public function new_conversation() {
        header('Content-Type: application/json');
        $user_id = session('id') ? session('id') : 1;
        $id = $this->Ai_chat_model->create_conversation($user_id, 'Percakapan Baru');
        echo json_encode(array('status' => '200', 'conversation_id' => $id));
    }

    public function delete_conversation($conversation_id) {
        header('Content-Type: application/json');
        $user_id = session('id') ? session('id') : 1;
        $res = $this->Ai_chat_model->delete_conversation((int)$conversation_id, $user_id);
        if ($res) {
            echo json_encode(array('status' => '200', 'msg' => 'Percakapan berhasil dihapus.'));
        } else {
            echo json_encode(array('status' => '400', 'msg' => 'Gagal menghapus percakapan.'));
        }
    }
}
