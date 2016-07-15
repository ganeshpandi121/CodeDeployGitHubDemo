<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Base_model');
        $this->load->model('General_model');
    }

    /* Returns all records from the table

     * Parameters
     * $table (string) specifies table name
     */

    public function login($user_arr) {
        $user_data = $this->Base_model->get_one_entry('users', $user_arr);
        if (!empty($user_data)) {
            $userID = $user_data->user_id;
            $this->set_user_session($userID);
            return $userID;
        }
        return false;
    }

    /**
     * 
     * @param type $user_id
     * @return boolean
     */
    function set_user_session($user_id, $super_admin_id = '') {
        if (isset($user_id) && !empty($user_id)) {
            $this->load->model('Supplier_model');
            $user_data = $this->General_model->get_user_data($user_id);
            $user_arr = array(
                'logged_in' => '1',
                'user_id' => $user_id,
                'user_type' => $user_data->user_type,
                'user_type_id' => $user_data->user_type_id,
                'email' => $user_data->email,
                'user_name' => $user_data->first_name . ' ' . $user_data->last_name,
                'is_verified' => $user_data->is_verified
            );
            
            if( $user_data->user_type_id == 3){
                $seller_data = $this->Supplier_model->get_supplier_data($user_id);
                //demo or live seller
                $user_arr['is_vetted'] = $seller_data->is_vetted;
                
                $transformed = $this->Base_model->get_one_entry_all('user_transformation', array('user_id' => $user_id,'user_type_id' => 2));
                //user transformed or not
                $user_arr['is_transformed']= !empty($transformed) ? 1 : '';
            }else if( $user_data->user_type_id == 2 ){
                $this->load->model('User_model');
                $user_transformed = $this->User_model->check_if_user_transformed($user_id);
                if(!empty($user_transformed)){
                    $seller_data = $this->Supplier_model->get_supplier_data($user_id);
                    //demo or live seller
                    $user_arr['is_vetted'] = $seller_data->is_vetted;
                }
               $transformed = $this->Base_model->get_one_entry_all('user_transformation', array('user_id' => $user_id,'user_type_id' => 3));
               //user transformed or not
                $user_arr['is_transformed']= !empty($transformed) ? 1 : '';
            }
            
            if(!empty($super_admin_id)){
                $user_arr['super_admin_id'] = $super_admin_id;
            }
            $this->session->set_userdata($user_arr);
            $this->add_history_log($user_id, 'Login', 'User Logged in');

            return true;
        }
    }
    
    public function set_buyer_session() {
        
        if (!empty($this->session->userdata('logged_in'))) {
            $user_id = $this->session->userdata('user_id');
            $seller_info = $this->Base_model->get_one_entry_all('supplier_details',array('user_id' => $user_id));
            $data['user_id'] = $user_id;
            $data['company_details_id'] = $seller_info->company_details_id;
            $data['address_id'] = $seller_info->address_id;
            $data['logo_path'] = $seller_info->logo_path;
            $data['is_active'] = $seller_info->is_active;
            $this->Base_model->insert_entry('consumer_details', $data);
            
            $trans_data['user_id'] = $user_id;
            $trans_data['user_type_id'] = 2;
            $trans_data['created_time'] = time();
            $this->Base_model->insert_entry('user_transformation', $trans_data);
            
            //set session after transformation
            $this->session->set_userdata(array('is_transformed' => 1));
            $this->add_history_log($this->session->userdata('user_id'), 'Login', 'User Became Buyer');
            
            $this->load->model('Email_model');
            $this->Email_model->notify_user_transformation($user_id,'Buyer');
            return true;
        }
        return false;
    }
    
    public function set_seller_session() {
        
        if (!empty($this->session->userdata('logged_in'))) {
            $user_id = $this->session->userdata('user_id');
            
            //insert into user_transformation table
            $trans_data['user_id'] = $user_id;
            $trans_data['user_type_id'] = 3;
            $trans_data['created_time'] = time();
            $this->Base_model->insert_entry('user_transformation', $trans_data);
            
            //set session after transformation
            $this->session->set_userdata(array('is_transformed' => 1));
            $this->add_history_log($this->session->userdata('user_id'), 'Login', 'User Became Seller');
            
            $this->load->model('Email_model');
            $this->Email_model->notify_user_transformation($user_id,'Seller');
            return true;
        }
        return false;
    }
    /**
     * 
     * @param type $user_id
     * @param type $action
     * @param type $desc
     * @return boolean
     */
    function add_history_log($user_id, $action, $desc) {
        
        $data = array(
            'user_id' => $user_id,
            'action_name' => $action,
            'created_time' => time()
        );
        
        if($this->session->userdata('super_admin_id')){
            $desc .= ' (Super Admin)';
            $data['super_admin_id'] = $this->session->userdata('super_admin_id');
        }
        $data['description'] = $desc;
        $inserted = $this->Base_model->insert_entry('user_history_log', $data);
        if ($inserted) {
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param type $user_id
     */
    function unset_user_session($user_id){
        if (isset($user_id) && !empty($user_id)) {
            $this->add_history_log($user_id, 'Logout', 'User Logged out');
            $this->session->unset_userdata('logged_in');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('user_type');
            $this->session->unset_userdata('user_type_id');
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('user_name');
            $this->session->unset_userdata('is_verified');
            $this->session->sess_destroy();
            return true;
        }
        return false;
    }

}
