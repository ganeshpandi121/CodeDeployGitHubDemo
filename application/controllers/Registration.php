<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends Base_Controller {

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
        $this->load->model('Registration_model');
        $this->load->model('Login_model');
        $this->load->model('User_model');
        $this->load->model('Base_model');
        $this->load->library('form_validation');
    }

    public function index() {
        //Registration Process
        if (($this->input->post())) {

            $data = array();
            $base_url = base_url();
            //set validation rules
            $this->form_validation->set_rules('user_type_id', 'Type', 'trim|required');
            $this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
            $this->form_validation->set_rules('terms_conditions', 'Terms and conditions', 'trim|required');
            $this->form_validation->set_rules('telephone_no', 'Phone Number', 'trim|required');
            $this->form_validation->set_rules('telephone', 'Phone Code', 'trim|required');

            //validate form input

            $user_exists = array(
                'email' => $this->input->post('email')
            );
            if ($this->Registration_model->user_exists($user_exists)) {
                $this->session->set_flashdata('error_msg', 'This Email "' . $this->input->post('email') . '" exits in our system.<br/>Try Log In');
                redirect($base_url);
            }

            if ($this->form_validation->run() == TRUE) {
                $data['user_first_name'] = $this->input->post('user_first_name');
                $data['user_last_name'] = $this->input->post('user_last_name');
                $data['email'] = $this->input->post('email');
                $data['user_type_id'] = $this->input->post('user_type_id');
                $data['password'] = md5($this->input->post('password'));
                $data['terms_conditions'] = $this->input->post('terms_conditions');
                $address_data['telephone_code'] = $this->input->post('telephone_code');
                $address_data['telephone_no'] = $this->input->post('telephone_no');
                $address_data['country_id'] = $this->input->post('country_id');
                $company_data['company_name'] = $this->input->post('company_name');
                $url= $this->input->post('redirect_url');
                
                if($this->input->post('user_type_id') == 3){
                    $this->session->set_flashdata('seller_data', $data);
                    $this->session->set_flashdata('seller_address_data', $address_data);
                    $this->session->set_flashdata('seller_company_data', $company_data);
                    redirect('Registration/seller-signup');
                }else{
                    if (!empty($this->Registration_model->register_users($data, $address_data, $company_data))) {
			if(!empty($url)){
                           redirect($base_url.$url);
                        }
                        redirect($base_url.'dashboard/profile');
                    }
                }
            }
        }else{
            redirect($base_url);
        }
    }

    //activate user account
    function verify($hash = NULL) {
        $this->page_data['page_title'] = "Verify";
        $this->load->library('session');
        if ($this->Registration_model->verify_email($hash) == true) {
            $this->session->set_flashdata('verify_msg', 'Your Email Address is successfully verified! Please login to access your account! <a href="' . $this->config->base_url() . '"> Login </a>');
            $userID = $this->session->userdata('user_id');
            if (!empty($userID)) {
                $this->Login_model->unset_user_session($userID);
            }
            //redirect('dashboard');
        } else {
            $this->session->set_flashdata('error_verify_msg', 'Sorry! There is an error occured while verifying your Email Address!!! Seems like you have already verified. Please try logging in.');
        }
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_blank');
        $this->load->view('static/verify', $this->page_data);
        $this->load->view('templates/footer');
        $this->load->view('templates/bottom');
    }

    public function post_a_project() {

        $this->load->model('General_model');
        $this->load->model('Email_model');
        $this->page_data['categories'] = $this->General_model->get_all_categories();
        if (($this->input->post())) {
            $user_type = $this->input->post('user_type');
            if ($user_type == 1) {
                $data = array();

                //set validation rules
                $this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
                $this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required');
                $this->form_validation->set_rules('sign_up_email', 'Email ID', 'trim|required|valid_email');
                $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
                $this->form_validation->set_rules('sign_up_password', 'Password', 'trim|required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[sign_up_password]');
                $this->form_validation->set_rules('terms_conditions', 'Terms and conditions', 'trim|required');
                $this->form_validation->set_rules('telephone_code_1', 'Telephone Code', 'trim|required');
                $this->form_validation->set_rules('telephone_no_1', 'Telephone Number', 'trim|required');
                $address_data['country_id'] = $this->input->post('country_id_1');
                $address_data['telephone_code'] = $this->input->post('telephone_code_1');
                $address_data['telephone_no'] = $this->input->post('telephone_no_1');
                //validate form input

                $user_exists = array(
                    'email' => $this->input->post('sign_up_email')
                );
                if ($this->Registration_model->user_exists($user_exists)) {
                    $this->session->set_flashdata('error_msg', 'This Email "' . $this->input->post('sign_up_email') . '" exits in our system.<br/>Try Log In');

                    redirect('post-a-project');
                }

                if ($this->form_validation->run() == TRUE) {
                    $this->load->model('User_model');
                    $udata['user_type_id'] = 2;
                    $udata['user_first_name'] = $this->input->post('user_first_name');
                    $udata['user_last_name'] = $this->input->post('user_last_name');
                    $udata['email'] = $this->input->post('sign_up_email');
                    $udata['password'] = md5($this->input->post('sign_up_password'));
                    $udata['terms_conditions'] = $this->input->post('terms_conditions');
                    $company_data['company_name'] = $this->input->post('company_name');

                    if (!empty($user_id = $this->Registration_model->register_users($udata, $address_data, $company_data))) {
                        /*
                        $this->Login_model->set_user_session($user_id);
                        $this->User_model->update_address($address_data, $user_id);
                        if ($this->session->user_type_id == 2) {//consumer details table
                            $table_name = 'consumer_details';
                        } elseif ($this->session->user_type_id == 3) {
                            //supplier_details table
                            $table_name = 'supplier_details';
                        } else {
                            //Freight forwarder 
                            $table_name = 'freight_details';
                        }
                        $this->Base_model->update_entry($table_name, $user_details_data, 'user_id', $user_id);
                        $this->Login_model->add_history_log($user_id, 'Registration', 'User registered');
                         * */
                         
                    }
                } else {
                    $this->session->set_flashdata('error_msg', 'Please fill required fields in registration part');
                    redirect('post-a-project');
                }
            } else if ($user_type == 2) {
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $this->session->set_flashdata('error_msg', 'Please fill required fields in login part');
                    redirect('post-a-project');
                } else {

                    $login_arr = array(
                        'email' => $this->input->post('email'),
                        'password' => md5($this->input->post('password'))
                    );

                    if (empty($this->Login_model->login($login_arr))) {
                        $this->session->set_flashdata('error_msg', 'Wrong Username and Password');
                        redirect('post-a-project');
                    }else{
                        if($this->session->userdata('user_type_id') != 2){
                           $this->session->set_flashdata('error_msg', 'Something Went Wrong');
                           redirect('post-a-project'); 
                        }
                    }
                }
            }
            $this->form_validation->set_rules('job_name', 'Project Name', 'required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', 'Please fill required fields in project details');
                redirect('post-a-project');
            } else {
                $user_id = $this->session->userdata('user_id');
                $data['job_name'] = $this->input->post('job_name');
                $data['job_overview'] = $this->input->post('job_overview');
                $data['product_quantity'] = $this->input->post('product_quantity');
                $product_lead_time = $this->input->post('product_lead_time');
                $data['description'] = $this->input->post('description');
                $data['special_requirement'] = $this->input->post('special_requirement');
                $data['expected_amount'] = $this->input->post('expected_amount');
                $data['is_urgent'] = $this->input->post('is_urgent');
                //$data['is_sealed'] = $this->input->post('is_sealed');
                $data['is_sample_required'] = $this->input->post('is_sample_required');
                $sla_milestone = $this->input->post('sla_milestone');
                $data['created_time'] = time();
                $data['is_active'] = '1';
                $sub_category = $this->input->post('sub-category');

                $this->load->model('Base_model');
                $this->load->model('Job_model');

                //$data['product_lead_time'] = $this->Job_model->calculate_time($product_lead_time, 'week');
                $data['sla_milestone'] = $this->Job_model->calculate_time($sla_milestone, 'hour');

                $data['product_lead_time'] = strtotime($product_lead_time);

                $job_status = $this->Base_model->get_one_entry('job_status', array('job_status_name' => 'Quote Request'));
                $data['job_status_id'] = $job_status->job_status_id;

                $consumer = $this->Base_model->get_one_entry('consumer_details', array('user_id' => $user_id));
                $data['cd_id'] = $consumer->cd_id;

                $job_id = $this->Base_model->insert_entry('job_details', $data);

                if ($this->input->post('delivery_required') == 1) {
                    $is_courier = $this->input->post('is_courier');
                    $is_air_freight = $this->input->post('is_air_freight');
                    $is_sea_freight = $this->input->post('is_sea_freight');

                    $my_address_type = $this->input->post('my_address');
                    if ($my_address_type == 2) {
                        //$addr_data['user_id'] = $user_id;
                        $addr_data['address_name'] = $this->input->post('address_name');
                        $addr_data['street_address'] = $this->input->post('street_address');
                        $addr_data['city'] = $this->input->post('city');
                        $addr_data['state'] = $this->input->post('state');
                        $addr_data['country_id'] = $this->input->post('country_id');
                        $addr_data['post_code'] = $this->input->post('post_code');
                        $addr_data['telephone_no'] = $this->input->post('telephone_no');
                        $addr_data['telephone_code'] = !empty($this->input->post('telephone_code')) ? $this->input->post('telephone_code') : NULL;
                        $this->load->model('JobFreight_model');
                        $address_id = $this->JobFreight_model->add_shipping_address($job_id, $addr_data);
                        $ship_data['to_address_consumer_address'] = 0;
                    } else {
                        $ship_data['to_address_consumer_address'] = 1;
                        $address_id = NULL;
                    }

                    $ship_data['job_id'] = $job_id;

                    $ship_data['to_address_id'] = $address_id;
                    $ship_data['is_require_delivery'] = 1;
                    $ship_data['is_courier'] = $is_courier;
                    $ship_data['is_air_freight'] = $is_air_freight;
                    $ship_data['is_sea_freight'] = $is_sea_freight;
                    $ship_data['is_active'] = 1;
                    $this->Base_model->insert_entry('job_shipping_details', $ship_data);
                } else {
                    $ship_data['job_id'] = $job_id;
                    $ship_data['is_require_delivery'] = 0;
                    $ship_data['is_active'] = 1;
                    $this->Base_model->insert_entry('job_shipping_details', $ship_data);
                }
                if (isset($_FILES['job_file']) && !empty($_FILES['job_file']['tmp_name'])) {
                    $config['allowed_types'] = 'jpg|png|jpeg|gif|pdf|doc|docx';
                    $upload_return = $this->General_model->do_upload('job_file', $_FILES['job_file'], 'documents', $config);

                    if (!empty($upload_return['error'])) {
                        $this->session->set_flashdata('error_msg', $upload_return['error']/* 'Something went wrong while uploading file!!!' */);
                        redirect('post-a-project');
                    } else {
                        $file_data['file_type_id'] = $this->input->post('file_type');
                        $file_data['job_id'] = $job_id;
                        $file_data['file_name'] = $upload_return['data']['file_name'];
                        $file_data['user_id'] = $user_id;
                        $file_data['created_time'] = time();
                        $file_data['is_active'] = '1';
                        $file_id = $this->Base_model->insert_entry('job_file', $file_data);

                        //update job_detals table with file_id after file upload
                        $this->Base_model->update_entry('job_details', array('job_file_id' => $file_id), 'job_id', $job_id);
                    }
                }

                //Adding category job mapping to the table
                $cat_data['sub_cat_id'] = $sub_category;
                $cat_data['job_id'] = $job_id;
                $cat_data['is_active'] = '1';
                $job_sub_cat_id = $this->Base_model->insert_entry('job_sub_category', $cat_data);

                //Adding Additional details

                if ($this->input->post('quote_type') == 2) {
                    $additonal_data['job_id'] = $job_id;

                    $additonal_data['plastic_id'] = $this->input->post('plastic_id');
                    $additonal_data['plastic_other'] = $this->input->post('plastic_other');
                    $additonal_data['thickness_id'] = $this->input->post('thickness_id');
                    $additonal_data['thickness_other'] = $this->input->post('thickness_other');
                    $additonal_data['cmyk_id'] = $this->input->post('cmyk_id');
                    $additonal_data['metallic_ink_id'] = $this->input->post('metallic_ink_id');
                    $additonal_data['pantone_front_color'] = $this->input->post('pantone_front_color');
                    $additonal_data['pantone_reverse_color'] = $this->input->post('pantone_reverse_color');
                    $additonal_data['magnetic_tape_id'] = $this->input->post('magnetic_tape_id');
                    $additonal_data['personalization_id'] = $this->input->post('personalization_id');
                    $additonal_data['front_signature_panel_id'] = $this->input->post('front_signature_panel_id');
                    $additonal_data['reverse_signature_panel_id'] = $this->input->post('reverse_signature_panel_id');
                    $additonal_data['embossing_id'] = $this->input->post('embossing_id');
                    $additonal_data['hotstamping_id'] = $this->input->post('hotstamping_id');
                    $additonal_data['hologram_id'] = $this->input->post('hologram_id');
                    $additonal_data['hologram_other'] = $this->input->post('hologram_other');
                    $additonal_data['dimensions'] = $this->input->post('dimensions');
                    $additonal_data['gsm'] = $this->input->post('gsm');
                    $additonal_data['finish_id'] = $this->input->post('finish_id');
                    $additonal_data['bundling_required_id'] = $this->input->post('bundling_required_id');
                    $additonal_data['bundling_required_other'] = $this->input->post('bundling_required_other');
                    $additonal_data['contactless_chip_id'] = $this->input->post('contactless_chip_id');
                    $additonal_data['contactless_chip_other'] = $this->input->post('contactless_chip_other');
                    $additonal_data['contact_chip_id'] = $this->input->post('contact_chip_id');
                    $additonal_data['contact_chip_other'] = $this->input->post('contact_chip_other');
                    $additonal_data['key_tag_id'] = $this->input->post('key_tag_id');
                    $additonal_data['unique_card_size'] = $this->input->post('unique_card_size');
                    $additonal_data['scented_ink'] = $this->input->post('scented_ink');
                    $additonal_data['uv_ink'] = $this->input->post('uv_ink');
                    $additonal_data['raised_surface'] = $this->input->post('raised_surface');
                    $additonal_data['magnetic_strip_encoding'] = $this->input->post('magnetic_strip_encoding');
                    $additonal_data['scratch_off_panel'] = $this->input->post('scratch_off_panel');
                    $additonal_data['fulfillment_service_required'] = $this->input->post('fulfillment_service_required');
                    $additonal_data['card_holder'] = $this->input->post('card_holder');
                    $additonal_data['attach_card_with_glue'] = $this->input->post('attach_card_with_glue');
                    $additonal_data['key_hole_punching'] = $this->input->post('key_hole_punching');
                   
                    $additonal_data['is_active'] = 1;
                    $this->Base_model->insert_entry('job_additional_details', $additonal_data);

                }

                //Adding job history
                $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['quote_request'];
                $this->Job_model->add_job_history($user_id, $job_id, $history_desc);

                //Sending email notification to buyer
                $this->Email_model->job_submit_notify($job_id);

                //randomly adding job to all suppliers -- will have modifications later
                $this->Job_model->supplier_job_allocation($job_id, $sub_category);

                if (!empty($job_id) && !empty($job_sub_cat_id)) {
                    $this->session->set_flashdata('success_msg', 'Your request have been successfully submitted');
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error_msg', 'Something went wrong!!!');
                    redirect(base_url());
                }
            }
        }
    }
    
    
    public function seller_signup() {
        $this->page_data['page_title'] = 'Registration - Step 2';
        
        $this->page_data['seller_data'] = json_encode($this->session->flashdata('seller_data'));
        $this->page_data['seller_address_data'] = json_encode($this->session->flashdata('seller_address_data'));
        $this->page_data['seller_company_data'] = json_encode($this->session->flashdata('seller_company_data'));
        $this->page_data['categories'] = $this->General_model->get_all_categories_sub_categories();
        if ($this->input->post()) {
            $this->page_data['seller_categories'] = json_encode($this->input->post('sub_category')) ;
            $msg = !empty($this->page_data['categories']) ? "Categories added successfully!" :
                    "Something went wrong! Please try again.";
            $this->session->set_flashdata('success_msg', $msg);
            $this->page_data['page_title'] = 'Registration - Step 3';
            $this->page_data['seller_data'] = $this->input->post('seller_data');
            $this->page_data['seller_address_data']=$this->input->post('seller_address_data');
            $this->page_data['seller_company_data']=$this->input->post('seller_company_data');
            
            $this->page_data['regions'] = $this->General_model->get_all_regions();
            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('registration/seller_signup_region', $this->page_data);
            $this->load->view('templates/footer');
            $this->load->view('templates/bottom');
        } else {
            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('registration/seller_signup_category', $this->page_data);
            $this->load->view('templates/footer');
            $this->load->view('templates/bottom');
        }
    }

    public function seller_signup_complete(){
        $this->page_data['page_title'] = 'Registration - Step 3';
        $this->load->model('Supplier_model');
        if ($this->input->post()) {
            
            $data = json_decode($this->input->post('seller_data'), true);
            $address_data = json_decode($this->input->post('seller_address_data'), true);
            $company_data = json_decode($this->input->post('seller_company_data'), true);
            $categories = json_decode($this->input->post('seller_categories'));
            $regions = $this->input->post('region') ;
            $flag = false;
            if(!empty($data)){
                $user_id = $this->Registration_model->register_users($data, $address_data, $company_data);
                $flag = true;
            }
            if(!empty($regions) && !empty($categories) && !empty($user_id)){
                $this->Supplier_model->insert_seller_categories_regions($user_id, $categories, $regions);
                $flag = true;
            }
            if($flag == true){
                redirect('dashboard/profile');
            }
        }
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_blank');
        $this->load->view('registration/seller_signup_region', $this->page_data);
        $this->load->view('templates/footer');
        $this->load->view('templates/bottom');
    }
}
