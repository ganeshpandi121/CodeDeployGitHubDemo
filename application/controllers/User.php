<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Base_Controller {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Base_model');
        $this->load->model('General_model');
    }

    public function login() {

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->page_data['page_title'] = 'Login to system';

        if (!empty($this->input->post())) {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->page_data['page_title'] = 'Welcome';
            } else {

                $login_arr = array(
                    'email' => $this->input->post('email'),
                    'password' => md5($this->input->post('password'))
                );

                if (!empty($this->Login_model->login($login_arr))) {
                    $user_type_id = $this->session->userdata('user_type_id');
                    $user_id = $this->session->userdata('user_id');
                    
                    $base_url = base_url();
                    $redirect_url= $this->input->post('redirect_url');
                    $user_added_address = $this->Base_model->is_exists('users', array(
                        'user_id' => $user_id,
                        'is_address_added' => 1 ) );
                        if ($user_added_address == 0) {
                            $url = 'dashboard/profile';
                        }
                    if ($user_type_id == 3 || $user_type_id == 4) {
                        $user_added_settings = $this->Base_model->is_exists('users', array(
                            'user_id' => $user_id,
                            'is_settings_added' => 1 ) );
                        if ($user_added_settings == 0) {
                            $url = 'dashboard/settings';
                        }
                    }
                    
                    if($user_type_id == 2){
                        $url = 'dashboard/my-projects';
                    }else if($user_type_id == 3){
                        $url = 'dashboard/my-bids';
                    }else if($user_type_id == 4){
                        $url = 'dashboard';
                    }else if($user_type_id == 1){
                        $url = 'admin/project_list';
                    }
                    
                    if(!empty ($redirect_url)){
                        redirect($base_url.$redirect_url);
                    }else{
                        redirect($base_url.$url);
                    }
                   
                } else {
                    $this->session->set_flashdata('error_msg', 'Wrong Username and Password');
                    redirect(base_url());
                }
            }
        }
    }

    public function logout() {

        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->Login_model->unset_user_session($user_id);
        }

        redirect(base_url());
    }

    public function forgot_password() {
        $this->page_data['page_title'] = 'Forgot Password';
        $this->page_data['msg'] = '';

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_isEmailExist');


            if ($this->form_validation->run() === FALSE) {
                $this->page_data['msg'] = validation_errors();
            } else {
                $data['created_time'] = time();
                $email = $this->input->post('email');
                $user_det = $this->Base_model->get_one_entry("users", array("email" => $email));
                $this->page_data['success'] = "0";
                $user_id = $user_det->user_id;
                $log_data['random_hash_tag'] = md5($email);
                $log_data['user_id'] = $user_id;
                $log_data['old_password'] = $user_det->password;
                $log_data['created_time'] = $data['created_time'];
                $log_data['is_active'] = "1";

                $user_password_log_id = $this->Base_model->insert_entry('user_password_log', $log_data);
                if (!empty($user_id) && !empty($user_password_log_id)) {
                    $this->load->model('Email_model');
                    $email_sent = $this->Email_model->send_forgot_mail($email);
                    if (!empty($email_sent)) {
                        $this->page_data['success'] = "1";
                        $this->page_data['msg'] = "Email sent";
                    } else {
                        $this->page_data['msg'] = "Email not sent";
                    }
                }
            }
        }
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_blank');
        $this->load->view('static/forgot_password', $this->page_data);
        $this->load->view('templates/footer');
        $this->load->view('templates/bottom');
    }

    public function isEmailExist($email) {

        $is_exist = $this->Base_model->get_one_entry_all("users", array("email" => $email));
        if ($is_exist) {
            if ($is_exist->is_active == 1) {
                return true;
            } else {
                $this->form_validation->set_message('isEmailExist', 'Email is deactivated. Please contact admin <a href="mailto:info@smartcardmarket.com">info@smartcardmarket.com</a>');
                return false;
            }
        } else {
            $this->form_validation->set_message('isEmailExist', 'Email does not exist');
            return false;
        }
    }

    public function reset_password() {

        $this->page_data['page_title'] = 'Reset Password';
        $this->page_data['msg'] = "";
        $show_login = false;
        $token = $this->uri->segment(3);
        $this->page_data['token'] = $token;
        if (!empty($token)) {
            $user_data = $this->Base_model->get_one_entry('user_password_log', array('random_hash_tag' => $token));

            if (!empty($user_data)) {
                $user_id = $user_data->user_id;
                if ($this->input->post()) {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
                    if ($this->form_validation->run() === FALSE) {
                        $this->page_data['msg'] = validation_errors();
                    } else {

                        $data['password'] = md5($this->input->post('new_password'));
                        $this->Base_model->update_entry('users', $data, 'user_id', $user_id);
                        $log = array('modified_time' => time());
                        $this->Base_model->update_entry('user_password_log', $log, 'user_id', $user_id);
                        $this->Login_model->add_history_log($user_id, "Reset Password", "Password changed");
                        $this->page_data['msg'] = "Password changed";
                    }
                }
            }
            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header', $show_login);
            $this->load->view('static/reset_password', $this->page_data);
            $this->load->view('templates/footer');
            $this->load->view('templates/bottom');
        }
    }

    public function newsletter() {
        $this->load->model('Email_model');
        $log_data['email'] = $this->input->post('emailid');
        $log_data['hash_tag'] = md5($log_data['email']);
        $log_data['is_active'] = "1";
        $newsletter_exist = $this->Base_model->get_one_entry_all('newsletter', array('hash_tag' => $log_data['hash_tag']));
        if ($newsletter_exist) {
            $val = $newsletter_exist->nl_id;
            if ($newsletter_exist->is_active == "0") {
                $ins_data['is_active'] = "1";
                $this->Base_model->update_entry('newsletter', $ins_data, 'hash_tag', $log_data['hash_tag']);
                $em = $this->Email_model->newsletter_subscription($log_data['email']);
                $res = "Subscribed successfully";
            } else {
                $res = "You are already subscribed for news letter";
            }
        } else {
            $val = $this->Base_model->insert_entry('newsletter', $log_data);
            $em = $this->Email_model->newsletter_subscription($log_data['email']);
            $res = "Subscribed successfully";
        }
        if ($val) {
            echo $res;
        }
    }

    public function newsletter_unsubscribe($token) {
        $this->page_data['page_title'] = 'Newsletter Unsubscribe';
        $hash_tag = $token;
        $log_data['is_active'] = "0";
        $this->Base_model->update_entry('newsletter', $log_data, 'hash_tag', $hash_tag);
        $this->session->set_flashdata('unsubscribe_msg', '<div class="alert alert-success text-center">Your email address is unsubscribed successfully</div>');
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_blank');
        $this->load->view('static/unsubscription', $this->page_data);
        $this->load->view('templates/footer');
        $this->load->view('templates/bottom');
    }
    
    public function become_buyer(){
        $this->Login_model->set_buyer_session();
        $this->session->set_flashdata('success_msg', 'You have successfully become a buyer.');
        redirect('dashboard/my-projects');
    }
    
    
    public function become_seller() {
        $this->page_data['page_title'] = 'Seller Categories';
        
        $this->page_data['categories'] = $this->General_model->get_all_categories_sub_categories();
        if ($this->input->post()) {
            $this->page_data['added_categories'] = json_encode($this->input->post('sub_category')) ;
            $msg = !empty($this->page_data['categories']) ? "Categories added successfully!" :
                    "Something went wrong! Please try again.";
            $this->session->set_flashdata('success_msg', $msg);
            $this->page_data['page_title'] = 'Seller Regions';
            
            $this->page_data['regions'] = $this->General_model->get_all_regions();
            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('dashboard/add_seller_region', $this->page_data);
            $this->load->view('templates/footer');
            $this->load->view('templates/bottom');
        } else {
            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('dashboard/add_seller_category', $this->page_data);
            $this->load->view('templates/footer');
            $this->load->view('templates/bottom');
        }
    }

    public function seller_process_complete(){
        $this->page_data['page_title'] = 'Seller Regions';
        $this->load->model('Supplier_model');
        if ($this->input->post()) {
            $user_id = $this->session->userdata('user_id');
            $categories = json_decode($this->input->post('added_categories'));
            $regions = $this->input->post('region') ;
            $flag = false;
            
            if(!empty($regions) && !empty($categories)){
                //Create supplier entry in supplier_details table
                $buyer_data = $this->Base_model->get_one_entry_all('consumer_details',array('user_id' => $user_id));
                $data['user_id'] = $user_id;
                $data['company_details_id'] = $buyer_data->company_details_id;
                $data['address_id'] = $buyer_data->address_id;
                $data['logo_path'] = $buyer_data->logo_path;
                $data['is_active'] = $buyer_data->is_active;
                $this->Base_model->insert_entry('supplier_details', $data);
                $this->Supplier_model->insert_seller_categories_regions($user_id, $categories, $regions);
                $flag = true;
            }
            if($flag == true){
                $this->Login_model->set_seller_session();
                $this->session->set_flashdata('success_msg', 'You have successfully become a seller.');
                redirect('dashboard/my-bids');
            }
        }
        $this->page_data['regions'] = $this->General_model->get_all_regions();
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_blank');
        $this->load->view('dashboard/add_seller_region', $this->page_data);
        $this->load->view('templates/footer');
        $this->load->view('templates/bottom');
    }

}
