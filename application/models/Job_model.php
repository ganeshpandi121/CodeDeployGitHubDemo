<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Job_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('Base_model');
        $this->load->model('Supplier_model');
        $this->load->model('User_model');
    }
    
    /**
     * Method to fetch info about a job
     * @param type $job_id
     * @return type
     */
    public function get_job_data($job_id) {
        $sql = 'SELECT j.job_id,j.job_name,j.cd_id,js.job_status_name,jf.file_name,jf.job_file_id,'
                . ' j.job_overview, j.description AS note, j.product_lead_time,j.special_requirement, '
                . ' j.expected_amount AS budget,j.product_quantity,j.sla_milestone,j.is_urgent,'
                . ' j.is_sealed,j.completed_time,j.is_sample_required,'
                . ' sc.sub_cat_id, sc.sub_category_name, c.cat_id, c.category_name,'
                . ' j.created_time AS created_date,jsd.to_address_id,jsd.is_require_delivery,'
                . ' jsd.is_courier,jsd.is_air_freight,jsd.is_sea_freight,jsd.to_address_consumer_address'
                . ' FROM job_details j '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' LEFT JOIN job_file jf ON jf.job_file_id = j.job_file_id '
                . ' LEFT JOIN job_shipping_details jsd ON jsd.job_id = j.job_id '
                . ' WHERE j.is_active = 1'
                . ' AND j.job_id =' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        return $result->row();
    }
    
    /**
     * Method to fetch all data of user from job id
     * @param type $job_id
     * @return type
     */
    public function get_job_user_data($job_id) {
        $query = 'SELECT u.user_first_name, u.user_last_name, u.user_id,u.email,'
                . ' cd.address_id,cd.logo_path,'
                . ' cp.company_name,cp.company_logo_path, ad.country_id,'
                . ' ad.telephone_code,ad.fax_no,cp.website,ad.telephone_no,c.country_name,'
                . ' ad.address_name,ad.street_address,ad.post_code, ad.city,ad.state'
                . ' FROM users u '
                . ' JOIN consumer_details cd ON cd.user_id = u.user_id'
                . ' JOIN job_details j ON cd.cd_id = j.cd_id'
                . ' LEFT JOIN address ad ON cd.address_id = ad.address_id AND ad.is_active = 1'
                . ' LEFT JOIN country c ON c.country_id = ad.country_id AND c.is_active = 1'
                . ' LEFT JOIN company_details cp ON cp.company_details_id = cd.company_details_id AND cp.is_active = 1'
                . ' WHERE j.is_active = 1'
                . ' AND cd.is_active = 1'
                . ' AND u.is_active = 1'
                . ' AND j.job_id =' . $this->db->escape($job_id);
        $user_result = $this->db->query($query);
        return $user_result->row();
    }
    /**
     * 
     * @param type $job_id  
     * @return type  
     */ 
    public function get_job_details($job_id) {
        //all the details for the individual job - including user info 
        
        $job_data = $this->get_job_data($job_id);
        $user_data = $this->get_job_user_data($job_id);
        
        if(!empty($job_data)){
            return array(
                    'job_data' => $job_data,
                    'user_data' => $user_data
                    );
        }
        
        return false;
    }
    
     /**
     * 
     * @param type $job_id  
     * @return type  
     */ 
    public function get_job_additional_details($job_id) {
        //all the  additional details for the individual job 
        $sql = 'SELECT ja.*, p.plastic_name, th.thickness_name, cm.cmyk_name, mi.metallic_ink_name, mt.magnetic_tape_name, per.personalization_name, fsp.front_signature_panel_name, rsp.reverse_signature_panel_name, em.embossing_name, hst.hotstamping_name, hol.hologram_name, f.finish_name, br.bundling_required_name, clc.contactless_chip_name, cc.contact_chip_name, kt.key_tag_name '
                . ' FROM job_additional_details ja '
                . ' LEFT JOIN plastic p ON p.plastic_id = ja.plastic_id '
                . ' LEFT JOIN thickness th ON th.thickness_id = ja.thickness_id '
                . ' LEFT JOIN cmyk cm ON cm.cmyk_id = ja.cmyk_id '
                . ' LEFT JOIN metallic_ink mi ON mi.metallic_ink_id = ja.metallic_ink_id '
                . ' LEFT JOIN magnetic_tape mt ON mt.magnetic_tape_id = ja.magnetic_tape_id '
                . ' LEFT JOIN personalization per ON per.personalization_id = ja.personalization_id '
                . ' LEFT JOIN front_signature_panel fsp ON fsp.front_signature_panel_id = ja.front_signature_panel_id '
                . ' LEFT JOIN reverse_signature_panel rsp ON rsp.reverse_signature_panel_id = ja.reverse_signature_panel_id '
                . ' LEFT JOIN embossing em ON em.embossing_id = ja.embossing_id '
                . ' LEFT JOIN hotstamping hst ON hst.hotstamping_id = ja.hotstamping_id '
                . ' LEFT JOIN hologram hol ON hol.hologram_id = ja.hologram_id '
                . ' LEFT JOIN finish f ON f.finish_id = ja.finish_id '
                . ' LEFT JOIN bundling_required br ON br.bundling_required_id = ja.bundling_required_id '
                . ' LEFT JOIN contactless_chip clc ON clc.contactless_chip_id = ja.contactless_chip_id '
                . ' LEFT JOIN contact_chip cc ON cc.contact_chip_id = ja.contact_chip_id '
                . ' LEFT JOIN key_tag kt ON kt.key_tag_id = ja.key_tag_id '
                . ' WHERE ja.is_active = 1'
                . ' AND ja.job_id =' . $this->db->escape($job_id);
       
        
        $result = $this->db->query($sql);
        if ($result) {
           return $result->row(); 
        }
        else {
            return NULL;
        }
        
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function get_job_history($job_id, $super_admin = '') {

        //job history details
        $sql = 'SELECT CONCAT(u.user_first_name," ", u.user_last_name) AS user_name,jh.description,'
                . 'js.job_status_name,jh.created_time AS created_date'
                . ' FROM job_history jh '
                . ' LEFT JOIN users u ON u.user_id = jh.user_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = jh.job_status_id '
                . ' WHERE jh.job_id =' . $this->db->escape($job_id);
        if(empty($super_admin)){
            $sql .=  ' AND jh.super_admin_id = 0';
        }
        $sql .= ' ORDER BY jh.created_time DESC, jh.job_history_id DESC';
        $result = $this->db->query($sql);
        return $result->result();
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function get_consumer_job_updates($job_id) {
        $sql = 'SELECT jl.job_log_id,jl.job_id,jl.description,jl.job_status_id,jl.job_file_id,'
                . ' u.user_first_name,u.user_last_name'
                . ' FROM job_log jl '
                . ' LEFT JOIN users u ON u.user_id = jl.user_id '
                . ' WHERE jl.is_active = 1'
                . ' AND jl.job_id =' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        $updates = $result->result();
        $arr = array();

        foreach ($updates as $key => $update) {

            $arr[$key]['job_log_id'] = $update->job_log_id;
            $arr[$key]['job_id'] = $update->job_id;
            $arr[$key]['description'] = $update->description;
            $arr[$key]['job_status_id'] = $update->job_status_id;
            $arr[$key]['user_first_name'] = $update->user_first_name;
            $arr[$key]['user_last_name'] = $update->user_last_name;
            if ($update->job_file_id != '') {
                $childs = $this->Job_model->get_consumer_job_files($update->job_file_id);
                $arr[$key]['job_file_id'] = $childs;
            }
        }
        return $arr;
    }

    /**
     * 
     * @param type $job_file_id
     * @return type
     */
    public function get_consumer_job_files($job_file_id) {
        $sql = 'SELECT f.file_type_name,jf.file_name,jf.job_file_id,'
                . 'jf.created_time AS file_created_date,jf.job_id'
                . ' FROM job_file jf'
                . ' LEFT JOIN file_type f ON f.file_type_id = jf.file_type_id '
                . ' WHERE jf.is_active = 1'
                . ' AND jf.job_file_id =' . $this->db->escape($job_file_id);
        $result = $this->db->query($sql);
        return $result->result();
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function supplier_job_allocation($job_id, $sub_category, $submitted_user_id) {
        $this->load->model('User_model');
        //get eligible supplier ids for allocation
        $supplier_ids = $this->get_suppliers_of_subcategory($sub_category, $submitted_user_id);
        $this->allocate_job_to_supplier($job_id, $supplier_ids);
        
        //Add notification 
        $notify_arr = array();
        $admin_id = $this->User_model->get_admin_id();
        if($supplier_ids){
        foreach ($supplier_ids as $ids) {
            $notify_arr[] = $ids->user_id;
        }
        $notify_desc = $this->config->item('notification_desc','smartcardmarket')['quote_request_allocated'];
        $this->add_notification($notify_arr, $admin_id, $job_id, $notify_desc);
        }
        $this->load->model('Email_model');
        $this->Email_model->job_allocation_notify($job_id);
        
        //adding job history for supplier allocation
        $history_desc = $this->config->item('job_history_desc','smartcardmarket')['quote_allocated'];
        $this->add_job_history($admin_id, $job_id, $history_desc, 'quote_allocated');
        return true;
    }

    /**
     * 
     * @return type
     */
    public function get_suppliers_of_subcategory($sub_category, $submitted_user_id) {
        $sql = 'SELECT sd.sd_id,u.user_id'
                . ' FROM users u'
                . ' JOIN supplier_details sd ON sd.user_id = u.user_id '
                . ' JOIN supplier_sub_category ssc ON ssc.sd_id = sd.sd_id '
                . ' WHERE u.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND ssc.is_active = 1'
                . ' AND ssc.sub_cat_id = '.$sub_category
                . ' AND u.user_id != '.$this->db->escape($submitted_user_id);
        $result = $this->db->query($sql);
        return $result->result();
    }

    /**
     * 
     * @param type $job_id
     * @param type $supplier_ids
     * @return type
     */
    public function allocate_job_to_supplier($job_id, $supplier_ids) {

        $insert_query = " INSERT INTO job_supplier_allocation (job_id, sd_id, is_active) VALUES ";
        
        $values = '';
        
        $condition = array();
        //make inactive for all entries of job_id
        $this->Base_model->update_list('job_supplier_allocation', array('is_active' => 0), array('job_id'=> $job_id));
        foreach ($supplier_ids as $ids) {
            $sd_id = $ids->sd_id;
            $allocation_exists = $this->Base_model->get_list_all('job_supplier_allocation','jsa_id',
                    array('sd_id' => $sd_id, 'job_id' => $job_id));
            if(empty($allocation_exists)){
                $values .= "(" . $job_id . "," . $sd_id . ",'1' ),";
            }else{
                //make active only the sd_id which is present in the array
                $condition = array( 'sd_id' =>  $sd_id, 'job_id' =>  $job_id);
                $this->Base_model->update_list('job_supplier_allocation', array('is_active' => 1), $condition);
            }
        }
        if(!empty($values)){
            $query = $insert_query . rtrim($values, ",");
            $this->db->query($query);
        }
        return true;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function get_supplier_quote_list($id) {
        $sql = " SELECT `jq`.*, `sd`.`sd_id`, `sd`.`user_id`, "
                . "CONCAT(u.user_first_name, ' ', u.user_last_name) AS supplier_name, "
                . "`inco`.`incoterm_name`, `c`.`currency_name` "
                . " FROM `job_quote` `jq` "
                . " JOIN `supplier_details` `sd` ON `sd`.`sd_id`=`jq`.`sd_id` "
                . " JOIN `users` u ON `sd`.`user_id`=`u`.`user_id` "
                . " LEFT JOIN `incoterm` inco ON `jq`.`incoterm_id`=`inco`.`incoterm_id` "
                . " LEFT JOIN `currency` c ON `jq`.`currency_id`=`c`.`currency_id` "
                . " WHERE sd.`is_active` = '1' "
                . " AND `jq`.`jq_id` = " . $this->db->escape($id)
                . " AND `jq`.`is_active` = '1'";
        $q = $this->db->query($sql);
        $result = $q->result();

        return $result;
    }

    /**
     * 
     * @param array $history_arr
     * @return type
     */
    public function add_job_history($user_id, $job_id, $history_desc) {
        
        //adding job history
        $job_data = $this->Base_model->get_one_entry('job_details', array('job_id' => $job_id));
        $history_arr['job_status_id'] = $job_data->job_status_id;
        $history_arr['job_id'] = $job_id;
        $history_arr['user_id'] = $user_id;
        $history_arr['created_time'] = time();
        $history_arr['user_id'] = $user_id;
        if(!empty($history_desc)){
            $desc = $history_desc;
            if($this->session->userdata('super_admin_id')){
                $desc .= ' (Super Admin)';
                $history_arr['super_admin_id'] = $this->session->userdata('super_admin_id');
            }
            $history_arr['description'] = $desc;
        }
        return $this->Base_model->insert_entry('job_history', $history_arr);
    }
    
    public function add_notification($to_be_notified_userid, $generated_user_id, $job_id, $history_desc){
        
        $data = array();
        if(is_array($to_be_notified_userid)){
            
            foreach ($to_be_notified_userid as $user_id) {
                $data[] = array(
                    'job_id' => $job_id,
                    'generated_by' => $generated_user_id,
                    'created_time' => time(),
                    'description' => $history_desc,
                    'is_active' => 1,
                    'is_read' => 0,
                    'user_id' => $user_id
                );
            };
            $this->Base_model->insert_many('notification', $data); 
        }else{
            $not_arr['job_id'] = $job_id;
            $not_arr['generated_by'] = $generated_user_id;
            $not_arr['created_time'] = time();
            $not_arr['description'] = $history_desc;
            $not_arr['is_active'] = 1;
            $not_arr['is_read'] = 0;
            $not_arr['user_id'] = $to_be_notified_userid;
            $this->Base_model->insert_entry('notification', $not_arr);
        }
        return 1;
    }
    
    public function send_job_update_notification($generated_user_id, $job_id){
        
        $notify_desc = $this->config->item('notification_desc','smartcardmarket')['job_updates_submitted'];
        $user_type_id = $this->Base_model->get_one_entry('users',
                array('user_id' => $generated_user_id))->user_type_id;
        if($user_type_id == 3){
            $buyer_id = $this->get_consumer_of_job($job_id)->user_id;
            $this->add_notification($buyer_id, $generated_user_id, $job_id, $notify_desc);
        }else if($user_type_id == 2){
            $allocated_seller_ids = $this->Supplier_model->get_allocated_sellers_of_job($job_id);
            if(!empty($allocated_seller_ids)){
                //Add notification 
                $notify_arr = array();
                foreach ($allocated_seller_ids as $ids) {
                    $notify_arr[] = $ids->user_id;
                }
                
                $this->add_notification($notify_arr, $generated_user_id, $job_id, $notify_desc);
            }
        }
    }

    /**
     * 
     * @param type $job_id
     * @param type $job_status_id
     * @return type
     */
    public function update_job_status($job_id, $job_status_id, $completed_time= '') {
        $this->load->model('Email_model');
        $data['job_status_id'] = $job_status_id;
        if(!empty($completed_time)){
           $data['completed_time'] = $completed_time; 
        }
        $this->Base_model->update_entry('job_details', $data, 'job_id', $job_id);
        $this->Email_model->job_status_change_notify($job_id);
        
    }

    /**
     * 
     * @param type $job_id
     * @param type $file_type_id
     * @return type
     */
    public function check_uploaded_file_type($job_id, $file_type_id) {
        $sql = 'SELECT f.file_type_name'
                . ' FROM file_type f '
                . ' WHERE f.is_active = 1'
                . ' AND f.file_type_id =' . $this->db->escape($file_type_id);
        $result = $this->db->query($sql);
        $file_type_name = $result->row()->file_type_name;

        // update job table if supplier uploads invoice or packaging list
        if ($file_type_name == $this->config->item('supplier_doc','smartcardmarket')['packaging_list']) {
            $this->Base_model->update_entry('job_details', array('is_packaging_list_uploaded' => '1'), 'job_id', $job_id);
        } else if ($file_type_name == $this->config->item('supplier_doc','smartcardmarket')['invoice']) {
            $this->Base_model->update_entry('job_details', array('is_invoice_uploaded' => '1'), 'job_id', $job_id);
        }

        //if all documents has been uploaded by supplier then order status will change.
        return $this->check_all_docs_uploaded_by_supplier($job_id);
    }

    /**
     * 
     * @param type $job_id
     * @return boolean
     */
    public function check_all_docs_uploaded_by_supplier($job_id) {
        $sql = 'SELECT j.job_id '
                . 'FROM job_details j '
                . 'WHERE j.is_invoice_uploaded = 1 '
                . 'AND j.is_packaging_list_uploaded = 1 '
                . ' AND j.job_id = ' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        if (sizeof($result->row()) > 0) {
            $this->joborder_status_update($job_id);
        }
        return false;
    }

    /**
     * Method for changing job status from order to freight ready
     * @param type $job_id
     */
    public function joborder_status_update($job_id) {
        $job_status = $this->Base_model->get_one_entry('job_status', array('job_status_name' => 'Freight Ready'));
        //update job order status to freight
        $this->update_job_status($job_id, $job_status->job_status_id);

        //add job history for status change
        $user_id = $this->session->userdata('user_id');
        $history_desc = $this->config->item('job_history_desc','smartcardmarket')['freight_ready'];
        $this->add_job_history($user_id, $job_id, $history_desc);
        return true;
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function get_job_status($job_id) {
        //status for the individual job
        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,j.product_quantity,j.product_lead_time,'
                . ' j.description AS note,j.special_requirement,j.job_overview,'
                . 'j.expected_amount AS budget, j.is_urgent,j.is_sealed,'
                . ' sc.sub_category_name, c.category_name'
                . ' FROM job_details j '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND j.job_id =' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function get_supplier_of_job($job_id) {
        $sql = 'SELECT u.user_id ,u.email'
                . ' FROM job_order jo '
                . ' JOIN users u ON u.user_id = jo.user_id '
                . ' WHERE jo.is_active = 1'
                . ' AND u.is_active = 1'
                . ' AND jo.job_id =' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function get_consumer_of_job($job_id) {
        $sql = 'SELECT u.user_id,u.email,u.user_first_name,u.user_last_name'
                . ' FROM job_details j '
                . ' JOIN consumer_details cd ON cd.cd_id = j.cd_id '
                . ' JOIN users u ON u.user_id = cd.user_id '
                . ' WHERE j.is_active = 1'
                . ' AND u.is_active = 1'
                . ' AND cd.is_active = 1'
                . ' AND j.job_id =' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function get_freight_of_job($job_id) {
        $sql = 'SELECT u.user_id ,u.email'
                . ' FROM job_freight jf '
                . ' JOIN freight_details fd ON fd.fd_id = jf.fd_id '
                . ' JOIN users u ON u.user_id = fd.user_id '
                . ' WHERE jf.is_active = 1'
                . ' AND u.is_active = 1'
                . ' AND fd.is_active = 1'
                . ' AND jf.job_id =' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * 
     * @param type $date
     * @return type
     */
    public function is_weekend($date) {
        $weekDay = date('w', strtotime($date));
        return $weekDay;
    }

    public function add_days_if_weekend($updated_date) {
        $is_weekend = $this->is_weekend($updated_date);
        if ($is_weekend == 0) {
            $updated_date = strtotime($updated_date);
            $latest_date = date('Y-m-d H:i:s', strtotime("+1 day", $updated_date));
        } else if ($is_weekend == 6) {
            $updated_date = strtotime($updated_date);
            $latest_date = date('Y-m-d H:i:s', strtotime("+2 day", $updated_date));
        } else {
            $latest_date = $updated_date;
        }
        return $latest_date;
    }

    public function calculate_time($time, $type) {
        $this->load->helper('date');
        if ($type == 'week') {
            $updated_time = date('Y-m-d H:i:s', strtotime('+' . $time . ' WEEK'));
        } else if ($type == 'hour') {
            $updated = date('Y-m-d H:i:s', strtotime('+' . $time . ' HOURS'));
            $updated_time = $this->add_days_if_weekend($updated);
        }
        return strtotime($updated_time);
    }
    
    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function allocate_jobs_to_a_supplier($seller_id, $subcategories) {
        
        $sub_cats = implode(', ', $subcategories);
        $active_allocated_jobids = $this->Base_model->get_list('job_supplier_allocation','job_id',array('sd_id' => $seller_id));
        
        $inactive_allocated_jobids = $this->Base_model->get_list_all('job_supplier_allocation','job_id',array('sd_id' => $seller_id,'is_active' => 0));
        
        $new_job_ids = $this->get_jobids_of_categories($sub_cats);
        $new_jobs = array();
        foreach($new_job_ids as $job_id){
            $new_jobs[] = $job_id->job_id;
        }
        
        if(empty($active_allocated_jobids) && empty($inactive_allocated_jobids)){
            $this->allocate_supplier_insert($seller_id, $new_jobs);
        }else{
            $active_seller_jobs = array();
            foreach($active_allocated_jobids as $active_jobs){
                $active_seller_jobs[] = $active_jobs->job_id;
            }
            
            $inactive_seller_jobs = array();
            foreach($inactive_allocated_jobids as $inactive_jobs){
                $inactive_seller_jobs[] = $inactive_jobs->job_id;
            }
            $jobs_to_insert = $jobs_to_update = $jobs_to_be_inactive = array();
            if(!empty($new_jobs)){
                //first check in inactive allocated jobs
                $jobs_to_update = array_intersect($inactive_seller_jobs, $new_jobs);
                $this->allocate_supplier_update($seller_id, $jobs_to_update, 1);
                
                if(empty($jobs_to_update)){
                    //check in active allocated jobs - insert new jobs
                    $jobs_to_insert = array_diff($new_jobs, $active_seller_jobs);
                    $this->allocate_supplier_insert($seller_id, $jobs_to_insert);
                }
                //check active jobs - update already allocated jobs to inactive if it is not in new jobs
                $jobs_to_be_inactive = array_diff($active_seller_jobs, $new_jobs);
                $jobs_to_be_inactive_string = implode(',',$jobs_to_be_inactive);
                $job_remain_active = $this->check_if_jobs_already_quoted($jobs_to_be_inactive_string, $seller_id);
                if(!empty($job_remain_active)){
                    $jobs_to_be_inactive = array_diff($job_remain_active, $jobs_to_be_inactive);
                }
                $this->allocate_supplier_update($seller_id, $jobs_to_be_inactive, 0);
                
                //check in inactive allocated jobs
                $jobs_to_update = array_intersect($inactive_seller_jobs, $new_jobs);
                $this->allocate_supplier_update($seller_id, $jobs_to_update, 1);
            }else{
                $active_jobs_string = implode(',',$active_seller_jobs);
                $job_remain_active = $this->check_if_jobs_already_quoted($active_jobs_string, $seller_id);
                if(!empty($job_remain_active)){
                    $jobs_to_be_inactive = array_diff($active_seller_jobs,$job_remain_active);
                }else{
                    $jobs_to_be_inactive = $active_seller_jobs;
                }

                $this->allocate_supplier_update($seller_id, $jobs_to_be_inactive, 0);
            }
         }
         return true;
    }
    
    public function check_if_jobs_already_quoted($jobs, $seller_id){
       if(!empty($jobs)){
        $sql = 'SELECT j.job_id'
                 . ' FROM job_details j'
                 .'  JOIN job_status js ON js.job_status_id = j.job_status_id'
                 .'  JOIN job_quote jq ON jq.job_id = j.job_id'
                 . ' WHERE j.is_active = 1'
                 . ' AND js.is_active = 1'
                 . ' AND js.job_status_name = "Quote Request"'
                 . ' AND jq.sd_id = '.$seller_id
                 . ' AND j.job_id IN (' . $jobs .')';
         $res = $this->db->query($sql)->result();
         $already_quoted_jobs = array();
         foreach ($res as $k){
             $already_quoted_jobs[] = $k->job_id;
         }
         return $already_quoted_jobs;
       }
       return array();
    }
    
    /**
     * 
     * @param type $seller_id
     * @param type $job_ids
     * @param type $is_active
     * @return boolean
     */
    public function allocate_supplier_update($seller_id, $job_ids, $is_active){
        if(!empty($job_ids)){
            $this->load->model('User_model');
            $admin_id = $this->User_model->get_admin_id();
            if($is_active == 1){
                $history_desc = $this->config->item('job_history_desc','smartcardmarket')['quote_allocated'];
            }else{
                $history_desc = $this->config->item('job_history_desc','smartcardmarket')['quote_deallocated'];
            }
            
            foreach ($job_ids as $id) {
                
                $this->Base_model->update_list('job_supplier_allocation',
                        array('is_active' => $is_active),
                        array('sd_id' => $seller_id, 'job_id' => $id));
                
                //adding job history for supplier allocation
                $this->add_job_history($admin_id, $id, $history_desc);
            }
            return true;
        }
    
        
    }
    /**
     * Will be removing this method later
     * @param type $job_ids
     * @param type $sd_id
     * @return type
     */
    public function allocate_supplier_insert($sd_id, $job_ids) {
        
        if(!empty($job_ids)){
            $this->load->model('User_model');
            $insert_query = " INSERT INTO job_supplier_allocation (sd_id, job_id, is_active)
                             VALUES ";

            $values = '';
            $admin_id = $this->User_model->get_admin_id();
            $history_desc = $this->config->item('job_history_desc','smartcardmarket')['quote_allocated'];
            $user_id = $this->Base_model->get_list_all('supplier_details','user_id',array('sd_id' => $sd_id));
            $user_id = $user_id[0]->user_id;
            foreach ($job_ids as $ids) {
               
                $user_submited = $this->check_if_job_by_user($user_id, $ids);
                if(empty($user_submited)){
                    $values .= "(" . $sd_id . "," . $ids . ",'1' ),";
                }

                //adding job history for supplier allocation
                $this->add_job_history($admin_id, $ids, $history_desc);
            }
            $query = $insert_query . rtrim($values, ",");
            $this->db->query($query);
            return true;
        }
        return false;
    }
    public function check_if_job_by_user($user_id, $job_id){
        $sql = 'SELECT count(j.job_id) AS count_job'
                . ' FROM job_details j '
                . ' JOIN consumer_details cd ON cd.cd_id = j.cd_id '
                . ' WHERE j.is_active = 1'
                . ' AND cd.user_id ='.$user_id
                . ' AND j.job_id ='.$job_id;
        $result = $this->db->query($sql)->row()->count_job;
        if(!empty($result)){
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param type $cd_id
     * @return type
     */
    public function get_buyer_data($cd_id) {
       $sql = 'SELECT u.user_id,u.user_first_name,u.user_last_name'
                . ' FROM users u'
                .'  JOIN consumer_details cd ON u.user_id = cd.user_id'
                . ' WHERE u.is_active = 1'
                . ' AND cd.is_active = 1'
                . ' AND cd.cd_id =' . $this->db->escape($cd_id);
        $result = $this->db->query($sql);
        return $result->row();  
    }
    
    /**
     * 
     * @param type $subcategories
     */
    public function get_jobids_of_categories($subcategories){
        
        $sql = 'SELECT j.job_id'
                . ' FROM job_details j '
                . ' JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' WHERE j.is_active = 1'
                . ' AND jsc.is_active = 1'
                . ' AND sc.is_active = 1'
                . ' AND js.job_status_name = "Quote Request"'
                . ' AND sc.sub_cat_id IN (' .$subcategories.')';
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    /**
     * 
     * @param type $job_id
     * @param array $data
     * @return type
     */
    public function re_activate_order($job_id, $data){
        
        $job_data = $this->get_job_data($job_id);
        $job_user_data = $this->get_job_user_data($job_id);
        $job_status = $this->Base_model->get_one_entry('job_status', 
                array('job_status_name' => 'Quote Request'));
        $data['job_status_id'] = $job_status->job_status_id;
        $this->Base_model->update_entry('job_details', $data, 'job_id', $job_id);
        
        //Allocating job to associated suppliers
        $this->supplier_job_allocation($job_id, $job_data->sub_cat_id, $job_user_data->user_id);
        
        //Adding job history
        $user_id = $this->session->userdata('user_id');
        $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['re-activated'];
        return $this->add_job_history($user_id, $job_id, $history_desc);
    }
    
    /**
     * 
     * @param type $job_id
     * @param array $data
     * @return type
     */
    public function re_order($job_id, $data){
        
        $job_data = $this->get_job_data($job_id);
        $job_user_data = $this->get_job_user_data($job_id);
        $job_additional_data = $this->get_job_additional_details($job_id);
        $job_status = $this->Base_model->get_one_entry('job_status', 
                array('job_status_name' => 'Quote Request'));
        $insert_data['job_name'] = $job_data->job_name;
        $insert_data['cd_id'] = $job_data->cd_id;
        $insert_data['job_overview'] = $job_data->job_overview;
        $insert_data['product_quantity'] = $job_data->product_quantity;
        $insert_data['expected_amount'] = $job_data->budget;
        $insert_data['is_urgent'] = $job_data->is_urgent;
        $insert_data['is_sealed'] = $job_data->is_sealed;
        $insert_data['is_sample_required'] = $job_data->is_sample_required;
        $insert_data['job_file_id'] = $job_data->job_file_id;
        $insert_data['description'] = $job_data->note;
        $insert_data['special_requirement'] = $job_data->special_requirement;
        $insert_data['job_status_id'] = $job_status->job_status_id;
        $insert_data['sla_milestone'] = $data['sla_milestone'];
        $insert_data['product_lead_time'] = $data['product_lead_time'];
        $insert_data['created_time'] = time();
        $insert_data['completed_time'] = NULL;
        $insert_data['is_active'] = 1;
        $inserted_job_id = $this->Base_model->insert_entry('job_details', $insert_data);
        
        if(!empty($job_additional_data)){
            $additonal_data['job_id'] = $inserted_job_id;
            $additonal_data['plastic_id'] = $job_additional_data->plastic_id;
            $additonal_data['plastic_other'] = $job_additional_data->plastic_other;
            $additonal_data['thickness_id'] = $job_additional_data->thickness_id;
            $additonal_data['thickness_other'] = $job_additional_data->thickness_other;
            $additonal_data['cmyk_id'] = $job_additional_data->cmyk_id;
            $additonal_data['metallic_ink_id'] = $job_additional_data->metallic_ink_id;
            $additonal_data['pantone_front_color'] = $job_additional_data->pantone_front_color;
            $additonal_data['pantone_reverse_color'] = $job_additional_data->pantone_reverse_color;
            $additonal_data['magnetic_tape_id'] = $job_additional_data->magnetic_tape_id;
            $additonal_data['personalization_id'] = $job_additional_data->personalization_id;
            $additonal_data['front_signature_panel_id'] = $job_additional_data->front_signature_panel_id;
            $additonal_data['reverse_signature_panel_id'] = $job_additional_data->reverse_signature_panel_id;
            $additonal_data['embossing_id'] = $job_additional_data->embossing_id;
            $additonal_data['hotstamping_id'] = $job_additional_data->hotstamping_id;
            $additonal_data['hologram_id'] = $job_additional_data->hologram_id;
            $additonal_data['hologram_other'] = $job_additional_data->hologram_other;
            $additonal_data['dimensions'] = $job_additional_data->dimensions;
            $additonal_data['gsm'] = $job_additional_data->gsm;
            $additonal_data['finish_id'] = $job_additional_data->finish_id;
            $additonal_data['bundling_required_id'] = $job_additional_data->bundling_required_id;
            $additonal_data['bundling_required_other'] = $job_additional_data->bundling_required_other;
            $additonal_data['contactless_chip_id'] = $job_additional_data->contactless_chip_id;
            $additonal_data['contactless_chip_other'] = $job_additional_data->contactless_chip_other;
            $additonal_data['contact_chip_id'] = $job_additional_data->contact_chip_id;
            $additonal_data['contact_chip_other'] = $job_additional_data->contact_chip_other;
            $additonal_data['key_tag_id'] = $job_additional_data->key_tag_id;
            $additonal_data['unique_card_size'] = $job_additional_data->unique_card_size;
            $additonal_data['scented_ink'] = $job_additional_data->scented_ink;
            $additonal_data['uv_ink'] = $job_additional_data->uv_ink;
            $additonal_data['raised_surface'] = $job_additional_data->raised_surface;
            $additonal_data['magnetic_strip_encoding'] = $job_additional_data->magnetic_strip_encoding;
            $additonal_data['scratch_off_panel'] = $job_additional_data->scratch_off_panel;
            $additonal_data['fulfillment_service_required'] = $job_additional_data->fulfillment_service_required;
            $additonal_data['card_holder'] = $job_additional_data->card_holder;
            $additonal_data['attach_card_with_glue'] = $job_additional_data->attach_card_with_glue;
            $additonal_data['key_hole_punching'] = $job_additional_data->key_hole_punching;
            $additonal_data['is_active'] = 1;
            $this->Base_model->insert_entry('job_additional_details', $additonal_data);
        }
        $ship_data['to_address_id'] = "";
        if(!empty($job_data->to_address_id)){
            $get_job_shipping_address = $this->Base_model->get_one_entry('address',
                    array('address_id' => $job_data->to_address_id), 
                    'address_name,street_address,state,city,post_code,country_id,'
                    . 'telephone_code,telephone_no,fax_no');
           
            $ship_data['to_address_id'] = $this->Base_model->insert_entry('address',$get_job_shipping_address);
        }
        $ship_data['job_id'] = $inserted_job_id;
        $ship_data['is_require_delivery'] = $job_data->is_require_delivery;
        $ship_data['to_address_consumer_address'] = $job_data->to_address_consumer_address;
        $ship_data['is_courier'] = $job_data->is_courier;
        $ship_data['is_air_freight'] = $job_data->is_air_freight;
        $ship_data['is_sea_freight'] = $job_data->is_sea_freight;
        $ship_data['is_active'] = 1;
        
        $this->Base_model->insert_entry('job_shipping_details', $ship_data);
        
        //Adding category job mapping to the table
        $cat_data['sub_cat_id'] = $job_data->sub_cat_id;
        $cat_data['job_id'] = $inserted_job_id;
        $cat_data['is_active'] = 1;
        $this->Base_model->insert_entry('job_sub_category', $cat_data);
        
        //Sending email notification to buyer
        $this->load->model('Email_model');
        $this->Email_model->job_submit_notify($inserted_job_id);

        //Allocating job to associated suppliers
        $this->supplier_job_allocation($inserted_job_id, $job_data->sub_cat_id, $job_user_data->user_id);
        //Adding job history
        $user_id = $this->session->userdata('user_id');
        $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['re-ordered'];
        $this->add_job_history($user_id, $inserted_job_id, $history_desc);
        return $inserted_job_id;
    }
    /**
     * 
     * @param type $job_id
     */
    public function cancel_a_job($job_id){
        
        $job_status = $this->Base_model->get_one_entry('job_status', array('job_status_name' => 'Cancelled'));
        $this->deactivate_seller_allocation_and_quote($job_id);
        $this->Job_model->update_job_status($job_id, $job_status->job_status_id);
        
        return true;
    }
    
    /**
     * 
     * @param type $job_id
     * @return boolean
     */
    public function deactivate_seller_allocation_and_quote($job_id){
        if(!empty($job_id)){
            $admin_id = $this->User_model->get_admin_id();
            
            $this->Supplier_model->deactivate_seller_quote($job_id, $admin_id);
            $this->Supplier_model->deallocate_sellers_of_job($job_id, $admin_id);
            
            return true;
        }
    }
    
    /* Cron job model method - commenting out for time being
     * public function get_jobs_to_be_remindered(){
        $sql = 'SELECT j.job_id,u.user_id,u.user_first_name,u.user_last_name,u.email'
                 . ' FROM job_details j'
                 .'  JOIN job_status js ON js.job_status_id = j.job_status_id'
                 .'  JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                 .'  JOIN users u ON u.user_id = cd.user_id'
                 . ' WHERE j.is_active = 1'
                 . ' AND js.is_active = 1'
                 . ' AND js.job_status_name = "Quote Request"'
                 . ' AND j.job_id NOT IN (SELECT jq.job_id '
                        . 'FROM job_quote jq )'
                 . ' AND j.sla_milestone <='.time();
         $res = $this->db->query($sql)->result();
         
         $query = 'SELECT j.job_id,u.user_id,u.user_first_name,u.user_last_name,u.email'
                 . ' FROM job_details j'
                 .'  JOIN job_status js ON js.job_status_id = j.job_status_id'
                 .'  JOIN job_supplier_allocation jsa ON jsa.job_id = j.job_id'
                 .'  JOIN supplier_details sd ON sd.sd_id = jsa.sd_id'
                 .'  JOIN users u ON u.user_id = sd.user_id'
                 . ' WHERE j.is_active = 1'
                 . ' AND js.is_active = 1'
                 . ' AND jsa.is_active = 1'
                 . ' AND js.job_status_name = "Quote Request"'
                 . ' AND j.job_id NOT IN (SELECT jq.job_id '
                        . 'FROM job_quote jq )'
                 . ' AND j.sla_milestone <='.time();
         $seller_arr = $this->db->query($query)->result();
         if(!empty($res)){
             foreach ($res as $item){
                $arr[$item->job_id]['job_buyer']['user_id']= $item->user_id;
                $arr[$item->job_id]['job_buyer']['user_first_name']= $item->user_first_name;
                $arr[$item->job_id]['job_buyer']['user_last_name']= $item->user_last_name;
                $arr[$item->job_id]['job_buyer']['email']= $item->email;
             }
         }
         if(!empty($seller_arr)){
             foreach ($seller_arr as $item){
                
                $arr[$item->job_id]['job_sellers'][$item->user_id]['user_id']= $item->user_id;
                $arr[$item->job_id]['job_sellers'][$item->user_id]['user_first_name']= $item->user_first_name;
                $arr[$item->job_id]['job_sellers'][$item->user_id]['user_last_name']= $item->user_last_name;
                $arr[$item->job_id]['job_sellers'][$item->user_id]['email']= $item->email;
             }
         }
         return $arr;
    }
    */
    
    /**
     * 
     * @param type $job_id
     * @return boolean
     */
    public function check_if_user_has_submitted($job_id, $user_id){
       $sql = 'SELECT cd.cd_id'
                 . ' FROM job_details j'
                 .'  JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                 . ' WHERE j.is_active = 1'
                 . ' AND cd.is_active = 1'
                 . ' AND cd.user_id = '.$user_id
                 . ' AND j.job_id = '.$job_id;
        $res = $this->db->query($sql)->row(); 
        if(!empty($res)){
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param type $job_id
     * @return boolean
     */
    public function check_if_job_allocated($job_id, $user_id){
       $sql = 'SELECT sd.sd_id'
                 . ' FROM job_details j'
                 .'  JOIN job_supplier_allocation jsa ON jsa.job_id = j.job_id'
                 .'  JOIN supplier_details sd ON sd.sd_id = jsa.sd_id'
                 . ' WHERE j.is_active = 1'
                 . ' AND sd.is_active = 1'
                 . ' AND sd.user_id = '.$user_id
                 . ' AND j.job_id = '. $job_id;
        $res = $this->db->query($sql)->row(); 
        if(!empty($res)){
            return true;
        }
        return false;
    }
    
    public function check_if_user_quoted($job_id, $user_id){
       $sql = 'SELECT sd.sd_id'
                 . ' FROM job_details j'
                 .'  JOIN job_order jo ON jo.job_id = j.job_id'
                 .'  JOIN supplier_details sd ON sd.sd_id = jo.sd_id'
                 . ' WHERE j.is_active = 1'
                 . ' AND sd.user_id = '.$user_id
                 . ' AND j.job_id = '. $job_id;
        $res = $this->db->query($sql)->row(); 
        if(!empty($res)){
            return true;
        }
        return false;
    }
}
