<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Registration_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Base_model');
    }

    /* Returns all records from the table

     * Parameters
     * $table (string) specifies table name
     */

    public function register_users($data, $address_data, $company_data = '') {
        $current_time = time();
        $data['created_time'] = $current_time;
        $user_id = $this->Base_model->insert_entry('users', $data);
        $log_data['random_hash_tag'] = md5($data['email']);
        $log_data['user_id'] = $user_id;
        $log_data['is_active'] = '1';
        $individual_data['user_id'] = $user_id;
        $individual_data['is_active'] = 1;
        $user_activation_log_id = $this->Base_model->insert_entry('user_activation_log', $log_data);

        if ($data['user_type_id'] == 2) {
            $user_type = 'Buyer';
            $this->Base_model->insert_entry('consumer_details', $individual_data);
        } else if ($data['user_type_id'] == 3) {
            $user_type = 'Seller';
            $this->Base_model->insert_entry('supplier_details', $individual_data);
        } else if ($data['user_type_id'] == 4) {
            $user_type = 'Freight Forwarder';
            $this->Base_model->insert_entry('freight_details', $individual_data);
        }else if ($data['user_type_id'] == 1) {
            $user_type = 'Administrator';
            $this->Base_model->insert_entry('admin_details', $individual_data);
        }
        
        $this->load->library('Zoho');
        if (!empty($user_id) && !empty($user_activation_log_id)) {
            
            //Adding leads to zoho
            $zoho = new zoho();
            $auth_token = $this->config->item('zoho_auth','smartcardmarket');
            
            $lead_data['first_name'] = $data['user_first_name'];
            $lead_data['last_name'] = $data['user_last_name'];
            $lead_data['email'] = $data['email'];
            $lead_data['phone'] = $address_data['telephone_code'] . $address_data['telephone_no'];
            $lead_data['subject'] = "User Signed Up As ".$user_type;
            $lead_data['message'] = "User Signed Up As ".$user_type;
            $zoho->data_to_leads($auth_token, $lead_data);
            
            $this->load->model('Email_model');
            $email_sent = $this->Email_model->send_signup_mail($user_id);
            $this->Email_model->send_welcome_mail($user_id);
            
            $this->Login_model->set_user_session($user_id);
            $this->User_model->update_address($address_data, $user_id);
            $this->User_model->update_company($company_data, $user_id);
            //adding user history
            $this->Login_model->add_history_log($user_id, 'Registration', 'User registered');
            if (!empty($email_sent)) {
                return $user_id;
            }
        }
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public function user_exists($data) {
        return $this->Base_model->get_one_entry_all('users', $data);
    }

    /**
     * 
     * @param type $key
     * @return boolean
     */
    function verify_email($key) {
        if (!empty($key)) {
            $user_data = $this->Base_model->get_one_entry('user_activation_log', array('random_hash_tag' => $key));
            if (!empty($user_data)) {
                $this->db->where('random_hash_tag', $key);
                $this->db->update('user_activation_log', array('is_active' => 0));

                $this->db->where('user_id', $user_data->user_id);
                $this->db->update('users', array('is_verified' => 1));

                return true;
            }
        }
        return false;
    }

}
