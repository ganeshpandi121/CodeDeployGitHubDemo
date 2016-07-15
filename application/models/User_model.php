<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_model extends CI_Model {

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

    public function get_history_log($user_id, $super_admin = '') {
        $sql = "SELECT ul.* ";
        if (!empty($super_admin)) {
            $sql .= " ,u.user_first_name,u.user_last_name ";
        }
        $sql .= "FROM `user_history_log` ul";
        if (!empty($super_admin)) {
            $sql .= " LEFT JOIN users u ON ul.user_id = u.user_id";
        }
        $sql .= " WHERE ul.`user_id` = " . $user_id;
        if (!empty($super_admin)) {
            $sql .= " OR ul.super_admin_id = " . $super_admin;
        } else {
            $sql .= " AND ul.super_admin_id = 0";
        }
        $sql .= " ORDER BY ul.uhl_id DESC,ul.`created_time` DESC";
        $result = $this->db->query($sql);
        return $result->result();
    }

    /* Commenting out as part of unneccessary code removal
     * public function update_address_in_tables($receive_data, $table_name, $user_id) {

        $get_address_id = $this->Base_model->get_one_entry($table_name, array('user_id' => $user_id));

        if ($get_address_id) {
            $update_address_id = $this->Base_model->update_entry($table_name, $receive_data, 'user_id', $user_id);
            if ($update_address_id) {
                return TRUE;
            }
            return TRUE;
        } else {
            $insert_data['user_id'] = $user_id;
            $insert_data['is_active'] = 1;
            $insert_address_id = $this->Base_model->insert_entry($table_name, $insert_data);
            if ($insert_address_id) {
                return TRUE;
            }
            return FALSE;
        }
    }*/

    /**
     * 
     * @param type $address_data
     * @param type $user_id
     * @return boolean
     */
    public function update_address($address_data, $user_id) {

        $table = $this->get_user_table($this->session->userdata('user_type_id'));
        $get_address = $this->Base_model->get_one_entry($table, array('user_id' => $user_id));
        if (!empty($get_address->address_id)) {
            $result = $this->Base_model->update_entry('address', $address_data, 'address_id', $get_address->address_id);
            
        } else {
            $address_data['is_active'] = 1;
            $insert_address_id = $this->Base_model->insert_entry('address', $address_data);
            //Update or insert respective users table
            $data['address_id'] = $insert_address_id;
            $result = $this->Base_model->update_entry($table, $data, 'user_id', $user_id);
        }
       
        if ($result) {
            return TRUE;
        }

        return false;
    }

    /**
     * 
     * @param type $user_id
     * @return boolean
     */
    public function get_address($user_id) {
        $table = $this->get_user_table($this->session->userdata('user_type_id'));
        $sql = "SELECT a.*"
                . " FROM address a "
                . " JOIN ".$table." ut ON ut.address_id = a.address_id "
                . " WHERE ut.user_id=" . $this->db->escape($user_id)
                . " AND a.is_active = '1'"
                . " AND ut.is_active = '1'";
        $result = $this->db->query($sql)->row();
        if (!empty($result)) {
            return $result;
        }
        return false;
    }
    
    /**
     * 
     * @param type $user_id
     * @return array
     */
    public function get_user_additional_data($user_id) {
        
        $table = $this->get_user_table($this->session->userdata('user_type_id'));
        $user_info = $this->Base_model->get_one_entry($table, array('user_id' =>$user_id));
        if ($user_info) {
            return $user_info;
        }
        return FALSE;
    }
    
    public function get_user_table($user_type_id){
        if ($user_type_id == 2) {
            //consumer details table
            $table_name = 'consumer_details';
        } else if ($user_type_id == 3) {
            //supplier_details table
            $table_name = 'supplier_details';
        } else if ($user_type_id == 4) {
            $table_name = 'freight_details';
        } else if ($user_type_id == 1) {
            $table_name = 'admin_details';
        }
        return $table_name;
    }

    /**
     * 
     * @param type $data
     * @param type $user_id
     * @return boolean
     */
    /* Not being used - Commenting out as part of unneccessary code removal
     * public function update_phone($data, $user_id) {

        //Get address id from respective user detail tables

        if ($this->session->user_type_id == 2) {//consumer details table
            $table_name = 'consumer_details';
        } elseif ($this->session->user_type_id == 3) {
            //supplier_details table
            $table_name = 'supplier_details';
        } else if ($this->session->user_type_id == 4) {
            $table_name = 'freight_details';
        } else if ($this->session->user_type_id == 1) {
            $table_name = 'admin_details';
        }
        $get_address_id = $this->Base_model->get_one_entry($table_name, array('user_id' => $user_id));
        //Update or insert phone number in address table

        if (!empty($get_address_id->address_id)) {

            $result = $this->Base_model->update_entry('address', $data, 'address_id', $get_address_id->address_id);

            if ($result) {
                return TRUE;
            }
            return FALSE;
        } else {
            $result = $this->Base_model->insert_entry('address', $data);
            $insert_data['address_id'] = $result;
            $insert_data['is_active'] = 1;
            $insert_address_id = $this->Base_model->update_entry($table_name, $insert_data, 'user_id', $user_id);
            if ($insert_address_id) {
                return TRUE;
            }
            return FALSE;
        }

        return false;
    }*/

    /**
     * 
     * @param type $data
     * @param type $user_id
     * @return boolean
     */
    public function update_personal_info($data, $user_id) {

        $update = $this->Base_model->update_entry('users', $data, 'user_id', $user_id);
        if ($update) {
            $user_name = $data['user_first_name'] . " " . $data['user_last_name'];
            $this->session->set_userdata(array('user_name' => $user_name));
            return true;
        }
        return false;
    }

    /**
     * 
     * @param type $user_type_name
     * @return type
     */
    public function get_user_type_id($user_type_name) {
        $sql = 'SELECT ut.user_type_id'
                . ' FROM user_type ut '
                . ' WHERE ut.user_type_name LIKE "' . $user_type_name . '" ';
        $result = $this->db->query($sql);
        return $result->row()->user_type_id;
    }
    
    /**
     * 
     * @param type $user_id
     * @return type
     */
    public function get_usertype_from_user_id($user_id) {
        $sql = 'SELECT ut.user_type_id'
                . ' FROM user_type ut '
                . ' JOIN users u ON u.user_type_id = ut.user_type_id '
                . ' WHERE u.user_id = '. $user_id;
        $result = $this->db->query($sql);
        return $result->row()->user_type_id;
    }

    /*
     * Method to get system admin user id
     */

    public function get_admin_id() {
        $sql = "SELECT `u`.`user_id` AS `admin_id` "
                . "FROM `users` `u` "
                . "JOIN `user_type` `ut` ON `u`.`user_type_id` = `ut`.`user_type_id` "
                . "WHERE `ut`.`user_type_name` = 'Admin' "
                . "AND `u`.`is_active` = '1'";
        $result = $this->db->query($sql)->row();
        if (!empty($result)) {
            return $result->admin_id;
        }
        return false;
    }

    public function get_unread_notification_count($user_id) {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM notification n '
                . ' LEFT JOIN job_details j ON j.job_id = n.job_id '
                . ' WHERE j.is_active = 1'
                . ' AND n.is_active = 1'
                . ' AND n.is_read = 0'
                . ' AND n.user_id = ' . $this->db->escape($user_id);

        $sql .= ' ORDER BY n.created_time DESC';

        $result = $this->db->query($sql);
        return $result->row()->count_row;
    }
    
    /**
     * 
     * @param type $user_id
     * @return type
     */
    public function get_user_notification_count($user_id) {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM notification n '
                . ' LEFT JOIN job_details j ON j.job_id = n.job_id '
                . ' WHERE j.is_active = 1'
                . ' AND n.is_active = 1'
                . ' AND n.user_id = ' . $this->db->escape($user_id);

        $sql .= ' ORDER BY n.created_time DESC';

        $result = $this->db->query($sql);
        return $result->row()->count_row;
    }
    /**
     * 
     * @param type $user_id
     * @param type $per_page
     * @param type $limit_page
     * @return type
     */
    public function get_user_notifications($user_id, $per_page = '', $limit_page = '') {
        $sql = 'SELECT n.notification_id,n.user_id,n.generated_by,n.description,'
                . 'n.created_time,n.job_id,j.job_name,n.is_read'
                . ' FROM notification n '
                . ' LEFT JOIN job_details j ON j.job_id = n.job_id '
                . ' WHERE j.is_active = 1'
                . ' AND n.is_active = 1'
                . ' AND n.user_id = ' . $this->db->escape($user_id);

        $sql .= ' ORDER BY n.created_time DESC';
        if ($per_page != 0) {
            $sql .= ' LIMIT ' . $limit_page . ' OFFSET ' . $per_page;
        } else {
            $sql .= ' LIMIT ' . $limit_page;
        }

        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    public function read_notifications($user_id) {
        return $this->Base_model->update_entry('notification', array('is_read' => 1), 'user_id', $user_id);
    }

    public function get_chats($id) {

        $sql = "SELECT * FROM "
                . "(SELECT u.user_first_name,jqc.created_time,jqc.msg "
                . " FROM job_quote_chat jqc "
                . " LEFT JOIN users u ON jqc.user_id=u.user_id "
                . " WHERE jqc.jq_id=" . $this->db->escape($id) . " "
                . " ORDER BY `jqc`.`created_time` DESC "
                . " LIMIT 0 , 15 ) sub "
                . " ORDER BY sub.created_time ASC ";
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function add_chat_notification($from_user, $to_user, $quote_id, $message) {

        $condition_arr = array(
            'jq_id' => $quote_id,
            'to_user_id' => $to_user,
            'from_user_id' => $from_user);
        $chat_exists = $this->Base_model->get_list_all('chat_notification', 'chat_notification_id', $condition_arr);
        if (!empty($chat_exists)) {
            $arr = array('description' => $message, 'is_read' => 0, 'created_time' => time());
            $this->Base_model->update_list('chat_notification', $arr, $condition_arr);
        } else {
            $arr = array(
                'jq_id' => $quote_id,
                'to_user_id' => $to_user,
                'from_user_id' => $from_user,
                'description' => $message,
                'is_read' => 0,
                'is_active' => 1,
                'created_time' => time()
            );
            $chat_notify_id = $this->Base_model->insert_entry('chat_notification', $arr);
            //$this->load->model('Email_model');
            //$this->Email_model->chat_email_notification($chat_notify_id);
        }
        return true;
    }

    public function get_chat_notifications($user_id, $limit = '') {
        $sql = "SELECT cn.*,u.user_first_name,us.user_first_name AS from_user_name,jq.job_id"
                . " FROM  chat_notification cn"
                . " LEFT JOIN users u ON cn.to_user_id = u.user_id "
                . " LEFT JOIN users us ON cn.from_user_id = us.user_id "
                . " LEFT JOIN job_quote jq ON jq.jq_id = cn.jq_id "
                . " WHERE cn.to_user_id=" . $this->db->escape($user_id)
                . " AND is_read = 0"
                . " ORDER BY cn.created_time DESC";
        if (!empty($limit)) {
            $sql .= " LIMIT " . $limit;
        }
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function get_chat_notification_data($chat_notification_id) {
        $sql = "SELECT cn.jq_id,cn.description,u.user_first_name AS to_user_first_name,"
                . "u.user_last_name AS to_user_last_name,u.email AS to_user_email,"
                . "us.user_first_name AS from_first_user_name,"
                . "us.user_last_name AS from_last_user_name,us.email AS from_user_email,"
                . "jq.job_id"
                . " FROM  chat_notification cn"
                . " LEFT JOIN users u ON cn.to_user_id = u.user_id "
                . " LEFT JOIN users us ON cn.from_user_id = us.user_id "
                . " LEFT JOIN job_quote jq ON jq.jq_id = cn.jq_id "
                . " WHERE cn.chat_notification_id = " . $this->db->escape($chat_notification_id)
                . " AND is_read = 0";

        $result = $this->db->query($sql);
        return $result->row();
    }

    public function get_unread_chat_notification_count($user_id) {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM chat_notification n '
                . ' WHERE n.is_active = 1'
                . ' AND n.is_read = 0'
                . ' AND n.to_user_id = ' . $this->db->escape($user_id);

        $sql .= ' ORDER BY n.created_time DESC';

        $result = $this->db->query($sql);
        return $result->row()->count_row;
    }
    public function get_filtered_sellers($filter_arr = array()) {
        $system_seller_arr = $this->get_system_sellers($filter_arr);
        $non_registered_arr = $this->get_non_registered_sellers($filter_arr);
        return array_merge($system_seller_arr, $non_registered_arr);
        
    }
    public function get_system_sellers($filter_arr = array()) {
        $sql = 'SELECT sd.sd_id,cp.company_name,cp.website,c.iso_country_code,'
                . 'c.country_name,c.country_id,u.user_first_name,u.user_last_name'
                . ' FROM supplier_details sd '
                . ' JOIN users u ON u.user_id = sd.user_id AND u.is_active = 1'
                . ' LEFT JOIN supplier_sub_category ssc ON ssc.sd_id = sd.sd_id AND ssc.is_active = 1'
                . ' LEFT JOIN supplier_regions sr ON sr.sd_id = sd.sd_id AND sr.is_active = 1'
                . ' LEFT JOIN address a ON a.address_id = sd.address_id AND a.is_active = 1'
                . ' LEFT JOIN country c ON c.country_id = a.country_id AND c.is_active = 1'
                . ' LEFT JOIN company_details cp ON cp.company_details_id = sd.company_details_id '
                . ' WHERE sd.is_active = 1';
        $search = '';
        if(!empty($filter_arr)){
            if ($filter_arr['sub_cat_id'] != 0 || 
                    $filter_arr['country_id'] != 0 || $filter_arr['region_id'] != 0) {

                $sql .= ' AND (';
                if (!empty($filter_arr['sub_cat_id'])) {
                    $search .= 'ssc.sub_cat_id =' . $filter_arr['sub_cat_id'] . ' OR ';
                }
                if (!empty($filter_arr['country_id'])) {
                    $search .= 'a.country_id =' . $filter_arr['country_id'] . ' OR ';
                }
                if (!empty($filter_arr['region_id'])) {
                    $search .= 'sr.region_id =' . $filter_arr['region_id'] . ' OR ';
                }
                $sql .= rtrim($search, ' OR ') . ')';
            }
        }
        $sql .= ' GROUP BY sd.sd_id';

        $result = $this->db->query($sql);
        return $result->result();
    }
    
    public function get_non_registered_sellers($filter_arr = array()) {
        $sql = 'SELECT fsd.find_supplier_id AS sd_id,fsd.company_name,c.iso_country_code,'
                . 'c.country_name,c.country_id,fsd.find_supplier_id'
                . ' FROM find_supplier_details fsd '
                . ' LEFT JOIN find_supplier_sub_category ssc ON ssc.find_supplier_id=fsd.find_supplier_id '
                     . 'AND ssc.is_active = 1'
                . ' LEFT JOIN find_supplier_region sr ON sr.find_supplier_id = fsd.find_supplier_id '
                     . 'AND sr.is_active = 1'
                . ' LEFT JOIN country c ON c.country_id = fsd.country AND c.is_active = 1'
                . ' WHERE fsd.is_active = 1';
        $search = '';
        if(!empty($filter_arr)){
            if ($filter_arr['sub_cat_id'] != 0 || 
                    $filter_arr['country_id'] != 0 || $filter_arr['region_id'] != 0) {

                $sql .= ' AND (';
                if (!empty($filter_arr['sub_cat_id'])) {
                    $search .= 'ssc.sub_category_id =' . $filter_arr['sub_cat_id'] . ' OR ';
                }
                if (!empty($filter_arr['country_id'])) {
                    $search .= 'fsd.country =' . $filter_arr['country_id'] . ' OR ';
                }
                if (!empty($filter_arr['region_id'])) {
                    $search .= 'sr.region_id =' . $filter_arr['region_id'] . ' OR ';
                }
                $sql .= rtrim($search, ' OR ') . ')';
            }
        }
        $sql .= ' GROUP BY fsd.find_supplier_id';

        $result = $this->db->query($sql);
        return $result->result();
    }
    
    /**
     * 
     * @param type $user_id
     * @param type $user_type_id
     * @return type
     */
    public function get_user_full_info($user_id, $user_type_id) {
        $table = $this->get_user_table($user_type_id);
        $sql = 'SELECT u.user_id AS user_id,u.email AS email,'
                . 'u.user_first_name AS first_name,u.user_last_name AS last_name,u.is_address_added,'
                . 'u.is_verified AS is_verified,a.telephone_code,a.telephone_no,c.country_name,'
                . 'ut.user_type_id AS user_type_id,ut.user_type_name AS user_type,cp.company_name, '
                . 'ud.logo_path,a.street_address,a.address_name,a.state,a.city,a.post_code,a.fax_no,'
                . 'a.country_id,cp.company_logo_path,cp.website'
                .' FROM users u '
                .' JOIN user_type ut ON u.user_type_id = ut.user_type_id '
                .' JOIN '.$table.' ud ON ud.user_id = u.user_id'
                .' LEFT JOIN address a ON a.address_id = ud.address_id AND a.is_active = 1'
                .' LEFT JOIN country c ON c.country_id = a.country_id AND c.is_active = 1'
                .' LEFT JOIN company_details cp ON cp.company_details_id = ud.company_details_id AND cp.is_active = 1'
                .' WHERE u.user_id =' . $this->db->escape($user_id)
                .' AND ud.is_active = 1';

        $result = $this->db->query($sql)->row();

        if ($result) {
            return $result;
        }
        return array();
    }
    
    /*
     * Method to get seller's sd_id
     */

    public function get_seller_id($user_id) {
        $sql = "SELECT `sd`.`sd_id` "
                . " FROM `users` `u` "
                . " JOIN `supplier_details` `sd` ON `sd`.`user_id` = `u`.`user_id` "
                . " WHERE `u`.`user_id` = ".$user_id 
                . " AND `u`.`is_active` = '1'"
                . " AND `sd`.`is_active` = '1'";
        $result = $this->db->query($sql)->row();
        if (!empty($result)) {
            return $result->sd_id;
        }
        return false;
    }
    
    /**
     * 
     * @param type $company_data
     * @param type $user_id
     * @return boolean
     */
    public function update_company($company_data, $user_id) {

        $table_name = $this->get_user_table($this->session->userdata('user_type_id'));
        $get_info = $this->Base_model->get_one_entry($table_name, array('user_id' => $user_id));
        if (!empty($get_info->company_details_id)) {
            $result = $this->Base_model->update_list('company_details', $company_data, array('company_details_id' => $get_info->company_details_id));
            
        } else {
            $company_data['is_active'] = 1;
            $insert_id = $this->Base_model->insert_entry('company_details', $company_data);
            //Update or insert respective users table
            $data['company_details_id'] = $insert_id;
            $result = $this->Base_model->update_list($table_name, $data, array('user_id' => $user_id));
        }
       
        if ($result) {
            return TRUE;
        }

        return false;
    }
    public function check_if_user_transformed($user_id){
        $sql = 'SELECT ut.ut_id'
                . ' FROM users u '
                . ' JOIN user_transformation ut ON ut.user_id = u.user_id '
                . ' WHERE u.user_id = '. $user_id;
        $result = $this->db->query($sql)->row();
        if(!empty($result)){
            return true;
        }
        return false;
    }
}
