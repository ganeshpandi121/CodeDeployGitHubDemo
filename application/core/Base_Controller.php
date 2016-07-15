<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

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
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $this->config->load('smartcardmarket', true);
        $this->page_data['logged_in'] = $this->session->userdata('logged_in');
        $this->page_data['user_type'] = $this->session->userdata('user_type');
        $this->page_data['user_type_id'] = $this->session->userdata('user_type_id');
        $this->page_data['user_id'] = $user_id;
        
        //Getting all telephone codes for sign up process
        $this->load->model('General_model');
        $this->page_data['telephone_codes'] = $this->General_model->get_all_telephone_codes();
        $this->load->model('User_model');
        $this->page_data['notification_count'] = $this->User_model->get_unread_notification_count($user_id);
        $this->page_data['user_notifications'] = $this->User_model->get_user_notifications($user_id,'0','10');
         $this->page_data['chat_notification_count'] = $this->User_model->get_unread_chat_notification_count($user_id);
        $this->page_data['user_chat_notifications'] = $this->User_model->get_chat_notifications($user_id,'15');
    }

}
