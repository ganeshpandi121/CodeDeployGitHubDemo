<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Base_Controller {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('Zoho');
        $this->load->model('Base_model');
    }

    /**
     * 
     */
    public function index() {
        $this->page_data['page_title'] = 'Contact | SMARTCard Market';
        $this->page_data['meta_description'] = 'Contact SMARTCardMarket for more information with '
                . 'Plastic card supplier and supplier comparison service, Gift card manufactures and '
                . 'SMARTCard Market will review your queries and get back you with great response for '
                . 'the same.';
        $this->page_data['meta_keywords'] = 'Smart card supplier contact, plastic card supplier contact,'
                . ' smartcard market contact, plastic card manufactures contact, supplier comparison '
                . 'contact';
        $this->page_data['msg'] = '';
        $this->page_data['contact_login'] = false;
        $this->page_data['success'] = "0";
        $show_login = false;
        $this->load->model('General_model');
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email_id', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('telephone_no', 'Telephone Number', 'trim|required');
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
            $this->form_validation->set_rules('message', 'Message', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $this->page_data['msg'] = validation_errors();
            } else {
                $log_data['first_name'] = $this->input->post("first_name");
                $log_data['last_name'] = $this->input->post("last_name");
                $log_data['email'] = $this->input->post("email_id");
                $log_data['telephone_code'] = $this->input->post("telephone_code");
                $log_data['telephone_no'] = $this->input->post("telephone_no");
                $log_data['subject'] = $this->input->post("subject");
                $log_data['message'] = $this->input->post("message");
                $log_data['is_active'] = "1";
                $log_data['created_time'] = time();

                $this->Base_model->insert_entry('contact_us', $log_data);
                $this->load->model('Email_model');
                
                $email_sent = $this->Email_model->send_contact_mail($log_data);

                if (!empty($email_sent)) {

                    $zoho = new zoho();
                    $auth_token = $this->config->item('zoho_auth', 'smartcardmarket');
                    $log_data['phone'] = $log_data['telephone_code'] . $log_data['telephone_no'];
                    unset($log_data['telephone_code']);
                    unset($log_data['telephone_no']);
                    unset($log_data['is_active']);
                    unset($log_data['created_time']);
                    $zoho->data_to_leads($auth_token, $log_data);
                    $this->page_data['success_msg'] = "Email has been sent successfully";
                } else {
                    $this->page_data['error_msg'] = "Email has not been sent";
                }
            }
        }

        $this->page_data['telephone_codes'] = $this->General_model->get_all_telephone_codes();
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_blank', $show_login);
        $this->load->view('static/contactus', $this->page_data);
        $this->load->view('templates/footer');
        $this->load->view('templates/bottom');
    }

    public function compose_email() {
        $sd_id = $this->input->post('sd_id');
        $is_find_supplier = $this->input->post('is_find_supplier');
        $content = '<div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Compose Email</h4>
                </div>
                <form method="post" action="' . base_url("find_supplier_now/request/1" . "/" . $sd_id . "?find_supplier=" . $is_find_supplier) . '" class="form-horizontal" id="send_popup_form" onsubmit= "return validate_popup()">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row"> 
                            <div class="col-md-12">
                                ' . form_label("Message", "email_body") . '
                                ' . form_textarea(array("name" => "email_body", "id" => "email_body", "rows" => "10", "cols" => "40", 'placeHolder' => 'Enter Message Here')) . '
                            </div>
                            
                        </div>
                        <div class="row"> 
                            <div class="col-md-9">
                                <p id="message_err"></p> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" id="send_email" class="btn btn-primary" value="Send" />
                </div>
            </form>  
         </div>';
        echo $content;
    }

    public function find_supplier_contact($request_type, $sd_id) {
        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
       $this->load->model('Email_model');
       $contacted_user_id = $this->session->userdata('user_id');
       $email_message ='';
       if($request_type == 1){
           $email_message = $this->input->post('email_body');
           $supplier_type = $this->input->post('find_supplier');
           if(empty($supplier_type) && !isset($supplier_type)){
            $supplier_type = $this->input->get('find_supplier');
           }
       }else{
           $supplier_type = $this->input->get('find_supplier');
       }
       

       $insert_arr = array(
                    'user_id' => $contacted_user_id,
                    'request_type_id' => $request_type,
                    'is_active' => 1,
                    'comments' => $email_message,
                    'email' => $this->session->userdata('email'));
       if($supplier_type == 0){
          $insert_arr['sd_id'] =  $sd_id;
       }else if($supplier_type == 1){
          $insert_arr['find_supplier_id'] =  $sd_id;
       }
       
       $inserted = $this->Base_model->insert_entry('find_supplier_request', $insert_arr);
       $this->Email_model->find_supplier_email($sd_id, $contacted_user_id, $request_type, $supplier_type, $email_message);
       if (!empty($inserted)) {
           $this->session->set_flashdata('find_success_msg', 'Your request has been sent successfully');
       }else{
           $this->session->set_flashdata('find_error_msg', 'Something went wrong! Please try again');
       }
       redirect('find_supplier_now');
    }

}
