<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Base_Controller {

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
        //$this->load->model('Job_model');
        $this->load->model('General_model');
        $this->load->model('Base_model');
        $this->load->model('User_model');
        $this->load->model('Login_model');
    }

    public function index() {
        $this->page_data['page_title'] = 'Profile';
        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        if ($this->session->userdata("active_tab") == "adres")
            $tab = "address";
        else if ($this->session->userdata("active_tab") == "personal")
            $tab = "personal_info";
        else if ($this->session->userdata("active_tab") == "comp_info")
            $tab = "company_info";
        else if ($this->session->userdata("active_tab") == "password")
            $tab = "password_change";
        else if ($this->session->userdata("active_tab") == "pic")
            $tab = "profile_pic";
        else
            $tab = "address";
        $this->session->unset_userdata('active_tab');
        $this->page_data['active_tab'] = $tab;
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type_id');
        $super_admin = ($user_type == 1) ? $user_id : '';
        $this->page_data['user_info'] = $this->User_model->get_user_full_info($user_id, $user_type);
        $this->page_data['user_history_log'] = $this->User_model->get_history_log($user_id, $super_admin);
        $this->page_data['countries'] = $this->Base_model->get_all('country');
        //$this->page_data['address'] = $this->User_model->get_address($user_id);
        $this->page_data['telephone_codes'] = $this->General_model->get_all_telephone_codes();
        
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('dashboard/profile', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

    public function update_address() {

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('address_name', 'Address Name', 'trim|required');
            $this->form_validation->set_rules('street_address', 'Street Address', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('country_id', 'Country', 'trim|required');
            $this->form_validation->set_rules('post_code', 'Zip Code', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('backend_msg', '<div class="alert alert-danger text-center">Error! Please update address again.</div>');
                redirect('dashboard/profile');
            } else {

                $user_id = $this->session->user_id;
                $this->Login_model->add_history_log($user_id, 'Profile', 'User Updated Address');
                $data['address_name'] = $this->input->post('address_name');
                $data['street_address'] = $this->input->post('street_address');
                $data['city'] = $this->input->post('city');
                $data['state'] = $this->input->post('state');
                $data['country_id'] = $this->input->post('country_id');
                $data['post_code'] = $this->input->post('post_code');
                if ($this->session->userdata('user_type_id') == 2) {
                    $telephone_code = !empty($this->input->post('telephone_code')) ? $this->input->post('telephone_code') : NULL;

                    $data['fax_no'] = $this->input->post('fax_no');
                }
                $this->User_model->update_address($data, $user_id);
                $this->Base_model->update_entry('users', array('is_address_added' => '1'), 'user_id', $user_id);
                $this->page_data['msg'] = "Updated Address";
                $this->session->set_userdata(array("active_tab" => "adres"));
                $this->session->set_flashdata('backend_msg_adres', '<div class="alert alert-success text-center">Address is updated</div>');
                redirect('dashboard/profile');
            }
        }
    }

    /* Commenting out unused method
     * public function update_phone() {

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('telephone_no', 'Phone Number', 'trim|required');
            $this->form_validation->set_rules('country_id', 'Country Id', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('backend_msg', '<div class="alert alert-danger text-center">Error! Please update phone number again.</div>');
                redirect('dashboard/profile');
            } else {

                $user_id = $this->session->user_id;
                $data['country_id'] = $this->input->post('country_id');
                $data['telephone_no'] = $this->input->post('telephone_no');
                $telephone_code = !empty($this->input->post('telephone_code')) ? $this->input->post('telephone_code') : NULL;
                $data['telephone_code'] = $telephone_code;
                $update = $this->User_model->update_phone($data, $user_id);

                if ($update) {
                    $this->Login_model->add_history_log($user_id, 'Profile', 'User Updated Phone Number');
                    $this->session->set_flashdata('backend_msg_phone', '<div class="alert alert-success text-center">Phone Number is updated</div>');
                }

                redirect('dashboard/profile');
            }
        }
    }*/

    public function update_personal_info() {

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('backend_msg', '<div class="alert alert-danger text-center">Error! Please update personal information again.</div>');
                redirect('dashboard/profile');
            } else {
                $user_id = $this->session->userdata('user_id');

                $this->Login_model->add_history_log($user_id, 'Profile', 'User Updated Personal Info');
                $data['user_first_name'] = $this->input->post('user_first_name');
                $data['user_last_name'] = $this->input->post('user_last_name');
                
                $this->User_model->update_personal_info($data, $user_id);
                $this->page_data['msg'] = "Updated Personal Information";
                $this->session->set_userdata(array("active_tab" => "personal"));
                $this->session->set_flashdata('backend_msg_personal', '<div class="alert alert-success text-center">Personal information is updated</div>');
                redirect('dashboard/profile');
            }
            redirect('dashboard/profile');
        }
    }

    public function update_company_info() {

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('telephone_no', 'Phone Number', 'trim|required');
            $this->form_validation->set_rules('telephone_code', 'Telephone Code', 'trim|required');
            if ($this->session->userdata('user_type_id') == 3 || $this->session->userdata('user_type_id') == 4) {
                $this->form_validation->set_rules('website_url', 'Website Url', 'trim|required');
            }
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('backend_msg', '<div class="alert alert-danger text-center">Error! Please update company information again.</div>');
                redirect('dashboard/profile');
            } else {
                $user_id = $this->session->userdata('user_id');
                $company_data['company_name'] = $this->input->post('company_name');
                if ($this->session->userdata('user_type_id') != 1) {
                    $company_data['website'] = $this->input->post('website_url');
                }
                //Company Logo upload
                if (isset($_FILES['company_logo']) && !empty($_FILES['company_logo']['tmp_name'])) {
                    $config['allowed_types'] = 'jpg|png|jpeg|gif';
                    $config['max_size'] = '2500';
                    $filesize = $_FILES['company_logo']['size'] / 1024;

                    if ($filesize > 2000) {
                        $this->session->set_flashdata('backend_msg', '<div class="alert alert-danger text-center">Image size is more than 2 MB. Please Upload again.</div>');
                        redirect('dashboard/profile');
                    }
                    $upload_return = $this->General_model->do_upload('company_logo', $_FILES['company_logo'], 'company', $config);

                    if (!empty($upload_return['error'])) {
                        $this->session->set_flashdata('backend_msg', $upload_return['error']);
                        redirect('dashboard/profile');
                    } else {
                        $company_data['company_logo_path'] = $upload_return['data']['file_name'];
                    }
                }
               
                //Address Update
                $address_data['fax_no'] = $this->input->post('fax_no');
                $address_data['telephone_no'] = $this->input->post('telephone_no');
                $address_data['telephone_code'] = !empty($this->input->post('telephone_code')) ? $this->input->post('telephone_code') : NULL;

                $this->User_model->update_address($address_data, $user_id);
                $updated = $this->User_model->update_company($company_data, $user_id);
                
                $this->session->set_userdata(array("active_tab" => "comp_info"));
                
                if(!empty($updated)){
                    $this->Login_model->add_history_log($user_id, 'Profile', 'User Updated Company Info');
                    $this->page_data['msg'] = "Updated Company Information";
                    $this->session->set_flashdata('backend_msg_comp_info', '<div class="alert alert-success text-center">Company information is updated</div>');
                }
            }
        }
        redirect('dashboard/profile');
    }

    public function update_password() {

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->session->set_userdata(array("active_tab" => "password"));
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
            $this->form_validation->set_rules('confirm_new_password', 'Confirm Password', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('backend_msg_password', '<div class="alert alert-danger text-center">Error! Please update password again.</div>');
                redirect('dashboard/profile');
            } else {
                $user_id = $this->session->userdata('user_id');
                $old_password = md5($this->input->post('old_password'));
                $new_password = md5($this->input->post('new_password'));
                $confirm_password = md5($this->input->post('confirm_new_password'));
                $get_old_password = $this->Base_model->get_one_entry('users', array('user_id' => $user_id));

                if ($get_old_password->password != $new_password) {
                    if ($get_old_password->password != $old_password) {
                        $this->session->set_flashdata('backend_msg_password', '<div class="alert alert-danger text-center">There is a mismatch with old password. Please try again</div>');
                        redirect('dashboard/profile');
                    }
                    if ($new_password == $confirm_password) {

                        $data['password'] = $new_password;
                        $update = $this->Base_model->update_entry('users', $data, 'user_id', $user_id);
                        if ($update) {
                            $this->Login_model->add_history_log($user_id, 'Profile', 'User Updated Password'
                                    . '');
                            $this->session->set_flashdata('password_reset_msg', '<div class="alert alert-success" >Password is updated.</div>');
                            redirect('dashboard/profile');
                            //redirect(base_url());
                        }
                    } else {
                        $this->session->set_flashdata('backend_msg_password', '<div class="alert alert-danger text-center">New password and Confirm password does not match.</div>');
                        redirect('dashboard/profile');
                    }
                } else {
                    $this->session->set_flashdata('backend_msg_password', '<div class="alert alert-danger text-center">Old password and new password cannot be same</div>');
                    redirect('dashboard/profile');
                }
            }
        }
    }

    public function profile_pic() {

        if (isset($_FILES['profile_pic']) && !empty($_FILES['profile_pic']['tmp_name'])) {
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['max_size'] = '2500';
            $filesize = $_FILES['profile_pic']['size'] / 1024;

            if ($filesize > 2000) {
                $this->session->set_flashdata('backend_msg', '<div class="alert alert-danger text-center">Image size is more than 2 MB. Please Upload again.</div>');
                redirect('dashboard/profile');
            }
            $upload_return = $this->General_model->do_upload('profile_pic', $_FILES['profile_pic'], 'profile', $config);

            if (!empty($upload_return['error'])) {
                $this->session->set_flashdata('backend_msg', $upload_return['error']);
                redirect('dashboard/profile');
            } else {


                if ($this->session->userdata('user_type_id') == 2) {//consumer details table
                    $table_name = 'consumer_details';
                } else if ($this->session->userdata('user_type_id') == 3) {
                    //supplier_details table
                    $table_name = 'supplier_details';
                } else if ($this->session->userdata('user_type_id') == 4) {
                    //Freight forwarder 
                    $table_name = 'freight_details';
                }else if ($this->session->userdata('user_type_id') == 1) {
                    //Freight forwarder 
                    $table_name = 'admin_details';
                }
                $send_data = array();
                $send_data['logo_path'] = $upload_return['data']['file_name'];
                $user_id = $this->session->userdata('user_id');
                $this->Base_model->update_list($table_name, $send_data, array('user_id' => $user_id));
                $this->Login_model->add_history_log($user_id, 'Profile', 'User Updated Profile Picture');
                $this->session->set_userdata(array("active_tab" => "pic"));
                $this->session->set_flashdata('backend_msg_profile_pic', '<div class="alert alert-success text-center">Profile picture updated successfully</div>');
                redirect('dashboard/profile');
            }
        }
        redirect('dashboard/profile');
    }

}
