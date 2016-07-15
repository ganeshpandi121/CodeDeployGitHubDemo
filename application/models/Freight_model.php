<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Freight_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model("Base_model");
    }

    /**
     * 
     * @param type $user_id
     * @param type $job_status
     * @return type
     */
    public function get_freight_quote_count($user_id, $keyword ='') {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM job_freight_allocation jfa '
                . ' LEFT JOIN job_details j ON j.job_id = jfa.job_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN freight_details fd ON fd.fd_id = jfa.fd_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND fd.is_active = 1'
                . ' AND js.job_status_name = "Freight Request"'
                . ' AND fd.user_id = ' . $this->db->escape($user_id);
        if(!empty($keyword)){
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%'.$keyword.'%"'
                    . 'OR sc.sub_category_name LIKE "%'.$keyword.'%" '
                    . 'OR c.category_name LIKE "%'.$keyword.'%"';
            if(is_numeric($keyword)){
                $sql .= ' OR j.job_id ='.$keyword ;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.created_time DESC';
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
    public function get_freight_quotes($user_id, $keyword ='', $per_page ='', $limit_page ='') {
        
        $sql = 'SELECT jfa.job_id,j.job_name,js.job_status_name,j.product_quantity,'
                . 'j.created_time,j.product_lead_time,j.sla_milestone'
                . ' FROM job_freight_allocation jfa '
                . ' LEFT JOIN job_details j ON j.job_id = jfa.job_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN freight_details fd ON fd.fd_id = jfa.fd_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND fd.is_active = 1'
                . ' AND js.job_status_name = "Freight Request"'
                . ' AND fd.user_id = ' . $this->db->escape($user_id);
        if(!empty($keyword)){
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%'.$keyword.'%"'
                    . 'OR sc.sub_category_name LIKE "%'.$keyword.'%" '
                    . 'OR c.category_name LIKE "%'.$keyword.'%"';
            if(is_numeric($keyword)){
                $sql .= ' OR j.job_id ='.$keyword ;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.created_time DESC';
        if ($per_page != 0) {
            $sql .= ' LIMIT '.$limit_page.' OFFSET '.$per_page;
        } else {
            $sql .= ' LIMIT '.$limit_page;
        }
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function freight_job_allocation($job_id) {
        $this->load->model('User_model');
        $this->load->model('Job_model');

        //adding job history for freight request

        $job_status = $this->Base_model->get_one_entry('job_status', array('job_status_name' => 'Freight Request'));
        $this->Job_model->update_job_status($job_id, $job_status->job_status_id);
        $user_id = $this->session->userdata('user_id');
        $history_desc = $this->config->item('job_history_desc','smartcardmarket')['freight_request'];
        $this->Job_model->add_job_history($user_id, $job_id, $history_desc);

        $freight_ids = $this->get_all_freights();
        $last_entry_id = $this->allocate_job_to_freight($job_id, $freight_ids);

        //adding job history for freight allocation

        $admin_id = $this->User_model->get_admin_id();
        $history_desc = $this->config->item('job_history_desc','smartcardmarket')['freight_allocated'];

        $this->Job_model->add_job_history($admin_id, $job_id, $history_desc);
        return $last_entry_id;
    }

    /**
     * 
     * @return type
     */
    public function get_all_freights() {
        $sql = 'SELECT fd.fd_id'
                . ' FROM users u'
                . ' LEFT JOIN freight_details fd ON fd.user_id = u.user_id '
                . ' WHERE u.is_active = 1'
                . ' AND fd.is_active = 1';
        $result = $this->db->query($sql);
        return $result->result();
    }

    /**
     * 
     * @param type $job_id
     * @param type $supplier_ids
     * @return type
     */
    public function allocate_job_to_freight($job_id, $freight_ids) {

        $insert_query = " INSERT INTO job_freight_allocation (job_id, fd_id, is_active)
                         VALUES ";

        $values = '';
        foreach ($freight_ids as $ids) {
            $values .= "(" . $job_id . "," . $ids->fd_id . ",'1' ),";
        }
        $query = $insert_query . rtrim($values, ",");
        $this->db->query($query);
        return $this->db->insert_id();
    }

    /**
     * 
     * @param type $user_id
     * @param type $job_status
     * @return boolean
     */
    public function get_freight_order_count($user_id) {
        $this->db->select('count(*) as count_row');
        $this->db->from('job_details j');
        $this->db->join('job_freight jf', 'jf.job_id = j.job_id ');
        $this->db->join('job_status js', 'js.job_status_id = j.job_status_id ', 'LEFT');
        $this->db->join('freight_details fd ', 'fd.fd_id = jf.fd_id ', 'LEFT');
        $this->db->where('fd.user_id', $user_id);
        $this->db->where('j.is_active', '1');
        $this->db->where('jf.is_active', '1');
        $this->db->order_by('jf.created_time', 'desc');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }

    /**
     * 
     * @param type $user_id
     * @param type $per_page
     * @param type $limit_page
     * @param type $job_status
     * @return type
     */
    public function get_freight_orders($user_id, $per_page, $limit_page) {
        $this->db->select('j.job_id,j.job_name,js.job_status_name,j.created_time AS created_date,j.product_lead_time,j.sla_milestone,j.product_quantity');
        $this->db->from('job_details j');
        $this->db->join('job_freight jf', 'jf.job_id = j.job_id ');
        $this->db->join('job_status js', 'js.job_status_id = j.job_status_id ', 'LEFT');
        $this->db->join('freight_details fd ', 'fd.fd_id = jf.fd_id ', 'LEFT');
        $this->db->where('fd.user_id', $user_id);
        $this->db->where('j.is_active', '1');
        $this->db->where('jf.is_active', '1');
        $this->db->order_by('jf.created_time', 'desc');
        if ($per_page != 0) {
            $this->db->limit($limit_page, $per_page);
        } else {
            $this->db->limit($limit_page);
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    /**
     * 
     * @param type $user_id
     * @return type
     */
    public function get_freight_data($user_id) {
        $sql = 'SELECT fd.fd_id,u.email AS email,'
                . ' u.user_first_name AS first_name,u.user_last_name AS last_name'
                . ' FROM users u '
                . ' JOIN freight_details fd ON fd.user_id = u.user_id '
                . ' WHERE fd.is_active = 1'
                . ' AND u.is_active = 1'
                . ' AND fd.user_id =' . $this->db->escape($user_id);
        $result = $this->db->query($sql);
        return $result->row();
    }

}
