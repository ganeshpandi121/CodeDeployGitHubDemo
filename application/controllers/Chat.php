<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends Base_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Base_model');
        $this->load->model('User_model');
        $this->load->database();
    }

    public function index($id) {
        $this->page_data['chats'] = $this->User_model->get_chats($id);
        $this->load->view('dashboard/chat', $this->page_data);
    }

    public function submit_chat() {
        $jq_id = $this->input->get('jq_id');
        $user_id = $this->input->get('user_id');
        $message = $this->input->get('msg');
        
        $arr = array(
                    'jq_id' => $jq_id, 
                    'user_id' => $user_id, 
                    'msg' => $message, 
                    'is_active' => 1, 
                    'created_time' => time()
            );
        $this->Base_model->insert_entry('job_quote_chat', $arr);
        $from_id = $this->session->userdata('user_id');
        $to_user_id = $this->input->get('to_user_id');
        $this->User_model->add_chat_notification($from_id, $to_user_id, $jq_id, $message);
        redirect('dashboard/job/chat/' . $jq_id);
    }

}
