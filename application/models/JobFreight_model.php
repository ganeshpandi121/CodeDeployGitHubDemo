<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class JobFreight_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('Base_model');
    }
    
    /**
     * 
     * @param type $job_id
     * @return type
     */
    
    public function get_freight_quote_by_job($job_id){
        $sql = 'SELECT fd.fd_id, u.user_id AS user_id, u.email AS email,'
                . 'fq.fq_id, c.currency_name, fq.job_id,fq.is_approved,'
                . 'fq.shipment_total_cost_ex_tax,fq.transit_time,'
                . ' CONCAT(u.user_first_name, " ",u.user_last_name) AS freight_forwarder_name'
                . ' FROM users u'
                . ' JOIN freight_details fd ON fd.user_id = u.user_id '
                . ' JOIN freight_quote fq ON fq.fd_id = fd.fd_id '
                . ' LEFT JOIN currency c ON c.currency_id = fq.currency_id '
                . ' WHERE u.is_active = 1'
                . ' AND fd.is_active = 1'
                . ' AND fq.is_active = 1'
                . ' AND fq.job_id = ' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        return $result->result(); 
    }
    
    
    /**
     * 
     * @param type $job_id
     * @param type $quote_id
     * @return boolean
     */
    public function add_job_freight($job_id, $quote_id){
        
        $this->load->model('Job_model');
        $quote_data = $this->Base_model->get_one_entry('freight_quote',array('fq_id' => $quote_id));
        $job_status = $this->Base_model->get_one_entry('job_status', array('job_status_name' => 'Freight Approved'));
        
        $user_id = $this->session->userdata('user_id');
        $history_desc = $this->config->item('job_history_desc','smartcardmarket')['freight_quote_approval'];

        $this->Job_model->add_job_history($user_id, $job_id, $history_desc);
        $this->Job_model->update_job_status($job_id, $job_status->job_status_id);
        $insert_arr = array(
                'job_id' => $job_id,
                'fq_id' => $quote_id,
                'fd_id' => $quote_data->fd_id,
                'job_order_id' => $quote_data->job_order_id,
                'created_time' => time(),
                'is_active' => '1'
        );
        
        //send email notification to approved freight forwarder
        $this->load->model('Email_model');
        $this->Email_model->freight_quote_approve_notify($job_id, $this->session->userdata('user_id'));
        return $this->Base_model->insert_entry('job_freight',$insert_arr);
    }
    /**
     * 
     * @param type $job_id
     * @return type
     */
    
    public function check_any_freight_quote_approved($job_id){
        $sql = 'SELECT COUNT(fq.fq_id) AS count'
                . ' FROM freight_quote fq '
                . ' JOIN job_details j ON j.job_id = fq.job_id'
                . ' JOIN job_status js ON js.job_status_id = j.job_status_id'
                . ' WHERE fq.is_active = 1'
                . ' AND j.is_active = 1'
                . ' AND fq.is_approved = 1'
                . ' AND js.job_status_name = "Freight Request"'
                . ' AND fq.job_id = ' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        $count = $result->row()->count; 
        return ($count >= 1) ? true : false;
    }
    
    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function get_approved_freight_quote_of_order($job_id){
        $sql = 'SELECT fd.fd_id, u.user_id AS user_id, u.email AS email,'
                . 'jf.shipment_total_cost_ex_tax,jf.shipment_total_cost_inc_tax,'
                . 'jf.shipment_nett_weight,jf.shipment_gross_weight,'
                . 'jf.transit_time,jf.additional_notes,s.shipping_method_name,'
                . ' c.currency_name, i.incoterm_name,'
                . ' CONCAT(u.user_first_name, " ",u.user_last_name) AS freight_name'
                . ' FROM users u'
                . ' JOIN freight_details fd ON fd.user_id = u.user_id '
                . ' JOIN freight_quote jf ON jf.fd_id = fd.fd_id '
                . ' LEFT JOIN currency c ON c.currency_id = jf.currency_id '
                . ' LEFT JOIN incoterm i ON i.incoterm_id = jf.incoterm_id '
                . ' LEFT JOIN shipping_method s ON s.shipping_method_id = jf.shipping_method_id '
                . ' WHERE u.is_active = 1'
                . ' AND fd.is_active = 1'
                . ' AND jf.is_active = 1'
                . ' AND jf.is_approved = 1'
                . ' AND jf.job_id = ' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        return $result->row();
    }
    
    /**
     * Method to get freight data of a freight forwarder
     * @param type $fd_id
     * @return type
     */
    public function get_approved_freight_data($fd_id){
        $sql = 'SELECT fd.fd_id, u.user_id AS user_id, u.email AS email, a.telephone_code, a.telephone_no,'
                . ' CONCAT(u.user_first_name, " ",u.user_last_name) AS freight_name,'
                . ' a.address_name, a.street_address, a.city, a.state, c.country_name'
                . ' FROM users u'
                . ' JOIN freight_details fd ON fd.user_id = u.user_id '
                . ' LEFT JOIN address a ON a.address_id = fd.address_id AND a.is_active = 1'
                . ' LEFT JOIN country c ON c.country_id = a.country_id '
                . ' WHERE u.is_active = 1'
                . ' AND fd.is_active = 1'
                . ' AND fd.fd_id = ' . $this->db->escape($fd_id);
        $result = $this->db->query($sql);
        return $result->row();
    }
    
    
    /**
     * 
     * @param type $id
     * @return type
     */
    
    public function get_freight_quote_info($id){
      $sql =" SELECT `fq`.*, `fd`.`fd_id`, `fd`.`user_id`, "
               . "CONCAT(u.user_first_name, ' ', u.user_last_name) AS freight_name, "
               . "`inco`.`incoterm_name`,s.shipping_method_name AS shipping_method "
               . " FROM `freight_quote` `fq` "
               . " JOIN `freight_details` `fd` ON `fd`.`fd_id`=`fq`.`fd_id` "
               . " JOIN `users` u ON `fd`.`user_id`=`u`.`user_id` "
               . " LEFT JOIN `incoterm` inco ON `fq`.`incoterm_id`=`inco`.`incoterm_id` "
               . " LEFT JOIN `shipping_method` s ON `fq`.`shipping_method_id`=`s`.`shipping_method_id` "
               . " WHERE fd.`is_active` = '1' "
               . " AND `fq`.`fq_id` = ".$this->db->escape($id)
               . " AND `fq`.`is_active` = '1'";
       $q = $this->db->query($sql);     
       return $q->row();
    }
    
    /**
     * 
     * @param type $job_id
     * @param type $shipaddr_data
     * @param type $address_id
     * @return type
     */
    public function add_shipping_address($job_id, $shipaddr_data, $address_id = '') {
        $this->load->model('Job_model');
        $user_id = $this->session->userdata('user_id');
        $insert_id = '';
        if(!empty($address_id)){
            $history_desc = 'Buyer Updated Shipping Address';
            $this->Base_model->update_entry('address', $shipaddr_data, 'address_id', $address_id);
            
        }else{
            $history_desc = 'Buyer Added Shipping Address';
            $insert_id = $this->Base_model->insert_entry('address', $shipaddr_data);
        }
        $this->Job_model->add_job_history($user_id, $job_id, $history_desc);
        //return inserted address id
        if(!empty($address_id)){
        return $address_id;  
        }else{
         return $insert_id; 
        }
    }
    
    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function check_quote_approved_or_not($job_id){
        $sql = 'SELECT COUNT(jq.jq_id)'
                . ' FROM job_quote jq '
                . ' WHERE jq.is_active = 1'
                . ' AND jq.is_approved = 1'
                . ' AND jq.job_id = ' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        if(sizeof($result->row()) == 1)
            return true;
        return false;
    }
}
