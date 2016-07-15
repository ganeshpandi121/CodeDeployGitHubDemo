<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    /**
     * 
     * @param type $user_id
     * @return boolean
     */
    public function get_all_quote_count($keyword = '') {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Quote Request"';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%' . $keyword . '%"'
                    . ' OR sc.sub_category_name LIKE "%' . $keyword . '%" '
                    . ' OR c.category_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR j.job_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.created_time DESC';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }

    /**
     * 
     * @param type $per_page
     * @param type $limit_page
     * @param type $job_status
     * @return type
     */
    public function get_all_quotes($keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,j.product_quantity,'
                . 'j.created_time AS created_date,j.product_lead_time,j.sla_milestone '
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Quote Request"';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%' . $keyword . '%"'
                    . ' OR sc.sub_category_name LIKE "%' . $keyword . '%" '
                    . ' OR c.category_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR j.job_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.created_time DESC';

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

    /**
     * 
     * @return boolean
     */
    public function get_all_buyer_count($keyword = '') {
        
        $sql = 'SELECT count(*) as count_row '
                . ' FROM consumer_details cd '
                . ' LEFT JOIN users u ON cd.user_id = u.user_id  '
                . ' LEFT JOIN user_type ut ON ut.user_type_id = u.user_type_id  '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = cd.company_details_id  '
                . ' WHERE ut.user_type_id = 2';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'u.user_first_name LIKE "%' . $keyword . '%"'
                    . ' OR u.user_last_name LIKE "%' . $keyword . '%" '
                    . ' OR u.email LIKE "%' . $keyword . '%"'
                    . ' OR cp.company_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR u.user_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY u.created_time DESC';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }

    /**
     * 
     * @param type $per_page
     * @param type $limit_page
     * @return type
     */
    public function get_all_buyers($keyword = '', $per_page = '', $limit_page = '') {
        
        $sql = 'SELECT u.user_id, u.user_first_name,u.user_last_name,'
                . 'u.email, u.created_time, u.user_type_id,'
                . 'u.is_active,cp.company_name,cp.website '
                . ' FROM consumer_details cd '
                . ' JOIN users u ON cd.user_id = u.user_id  '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = cd.company_details_id  ';
        if (!empty($keyword)) {
            $sql .= ' WHERE ('
                    . 'u.user_first_name LIKE "%' . $keyword . '%"'
                    . ' OR u.user_last_name LIKE "%' . $keyword . '%" '
                    . ' OR u.email LIKE "%' . $keyword . '%"'
                    . ' OR cp.company_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR u.user_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY u.created_time DESC';
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

    /**
     * 
     * @return boolean
     */
    public function get_all_seller_count($keyword = '') {
        
        $sql = 'SELECT count(*) as count_row '
                . ' FROM supplier_details sd '
                . ' JOIN users u ON sd.user_id = u.user_id  '
                . ' LEFT JOIN user_type ut ON ut.user_type_id = u.user_type_id  '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = sd.company_details_id  ';
        if (!empty($keyword)) {
            $sql .= ' WHERE ('
                    . 'u.user_first_name LIKE "%' . $keyword . '%"'
                    . ' OR u.user_last_name LIKE "%' . $keyword . '%" '
                    . ' OR u.email LIKE "%' . $keyword . '%"'
                    . ' OR cp.company_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR u.user_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY u.created_time DESC';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }

    /**
     * 
     * @param type $per_page
     * @param type $limit_page
     * @return type
     */
    public function get_all_sellers($keyword = '', $per_page = '', $limit_page = '') {
        
        $sql = 'SELECT u.user_id, u.user_first_name,u.user_last_name,cp.company_name,sd.is_vetted,'
                . 'u.email, u.created_time, u.user_type_id,u.is_active'
                . ' FROM supplier_details sd'
                . ' JOIN users u ON sd.user_id = u.user_id  '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = sd.company_details_id  ';
        if (!empty($keyword)) {
            $sql .= ' WHERE ('
                    . 'u.user_first_name LIKE "%' . $keyword . '%"'
                    . ' OR u.user_last_name LIKE "%' . $keyword . '%" '
                    . ' OR u.email LIKE "%' . $keyword . '%"'
                    . ' OR cp.company_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR u.user_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY u.created_time DESC';
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

    public function get_user_info($user_id, $user_type_id, $is_transformed = '') {

        $sql = "SELECT u.*,a.*, c.country_name,u.is_active AS is_user_active";
        if($is_transformed){
            $sql .= " ,cd.cd_id,cp.company_name,cp.website,sd.sd_id,sd.is_vetted,"
                    . "cp.company_name,cp.website,sd.trading_name,sd.brand ";
        }else{
            if ($user_type_id == 2) {
                $sql .= " ,cd.cd_id,cp.company_name,cp.website";
            } else if ($user_type_id == 3) {
                $sql .= " ,sd.sd_id,sd.is_vetted,cp.company_name,cp.website,sd.trading_name,sd.brand ";
            }
        }
        $sql .= " FROM users u ";
        if($is_transformed){
            $sql .= " LEFT JOIN consumer_details cd ON cd.user_id = u.user_id"
                    . " LEFT JOIN supplier_details sd ON sd.user_id = u.user_id"
                    . " LEFT JOIN address a ON cd.address_id = a.address_id"
                    . ' LEFT JOIN company_details cp ON cp.company_details_id = cd.company_details_id  ';
             
        }else{
            if ($user_type_id == 2) {
                //consumer details table
                $sql .= " LEFT JOIN consumer_details cd ON cd.user_id = u.user_id"
                    . " LEFT JOIN address a ON cd.address_id = a.address_id"
                    . ' LEFT JOIN company_details cp ON cp.company_details_id = cd.company_details_id  ';
            } else if ($user_type_id == 3) {
                //supplier_details table
                $sql .= " LEFT JOIN supplier_details sd ON sd.user_id = u.user_id"
                    . " LEFT JOIN address a ON sd.address_id = a.address_id"
                    . ' LEFT JOIN company_details cp ON cp.company_details_id = sd.company_details_id  ';
            }
         }
        $sql .= " LEFT JOIN country c ON c.country_id = a.country_id"
                . " WHERE u.user_id = " . $user_id;

        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    /**
     * 
     * @return boolean
     */
    public function get_all_order_count($keyword = '') {

        $sql = 'SELECT count(*) as count_row '
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Order"';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%' . $keyword . '%"'
                    . ' OR sc.sub_category_name LIKE "%' . $keyword . '%" '
                    . ' OR c.category_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR j.job_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.created_time DESC';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }

    /**
     * 
     * @param type $per_page
     * @param type $limit_page
     * @return type
     */
    public function get_all_orders($keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,j.created_time AS created_date,'
                . 'j.product_lead_time,j.product_quantity '
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Order"';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%' . $keyword . '%"'
                    . ' OR sc.sub_category_name LIKE "%' . $keyword . '%" '
                    . ' OR c.category_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR j.job_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.created_time DESC';

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

    /**
     * 
     * @return boolean
     */
    public function get_all_completed_order_count($keyword = '') {

        $sql = 'SELECT count(*) as count_row'
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Completed"';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%' . $keyword . '%"'
                    . ' OR sc.sub_category_name LIKE "%' . $keyword . '%" '
                    . ' OR c.category_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR j.job_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.completed_time DESC';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }

    /**
     * 
     * @param type $per_page
     * @param type $limit_page
     * @return type
     */
    public function get_all_completed_orders($keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,'
                . 'j.created_time AS created_date,j.completed_time,j.product_quantity'
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Completed"';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%' . $keyword . '%"'
                    . ' OR sc.sub_category_name LIKE "%' . $keyword . '%" '
                    . ' OR c.category_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR j.job_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.completed_time DESC';

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

    /**
     * 
     * @return boolean
     */
    public function get_passed_order_count($keyword = '') {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Cancelled"';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%' . $keyword . '%"'
                    . ' OR sc.sub_category_name LIKE "%' . $keyword . '%" '
                    . ' OR c.category_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR j.job_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.created_time DESC';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }

    /**
     * 
     * @param type $per_page
     * @param type $limit_page
     * @return type
     */
    public function get_passed_orders($keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,j.created_time,'
                . 'j.product_lead_time,j.product_quantity '
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Cancelled"';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%' . $keyword . '%"'
                    . ' OR sc.sub_category_name LIKE "%' . $keyword . '%" '
                    . ' OR c.category_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR j.job_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.created_time DESC';
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
    
    
    public function get_supplier_request_count() {
         $sql = 'SELECT count(*) as count_row '
                . ' FROM find_supplier_request fs'
                . ' LEFT JOIN request_type rt ON rt.request_id = fs.request_type_id '
                . ' LEFT JOIN users u ON u.user_id = fs.user_id '
                . ' LEFT JOIN (SELECT sd.sd_id,us.user_first_name AS request_to_firstname '
                    . ' FROM supplier_details sd '
                    . ' LEFT JOIN users us ON us.user_id = sd.user_id ) sub ON sub.sd_id = fs.sd_id '
                . ' WHERE fs.is_active = 1'
                . ' AND u.is_active = 1'
                . ' AND rt.is_active = 1';
        $sql .= ' ORDER BY fs.find_supplier_request_id DESC';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }
    
    public function get_lead_overall_count() {
         $sql = 'SELECT COUNT(DISTINCT `find_supplier_id`) AS count_row FROM  `find_supplier_request` WHERE find_supplier_id >0;';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }
    
    public function get_lead_overall_count_outside() {
         $sql = 'SELECT COUNT(DISTINCT `sd_id`) AS count_row FROM  `find_supplier_request` WHERE sd_id >0;';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }
    
    public function get_overall_supplier_job_count() {
         $sql = 'SELECT COUNT(DISTINCT `sd_id`) AS count_row FROM  `job_supplier_allocation` WHERE sd_id >0;';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row()->count_row;
        }
        return false;
    }
    
    
    public function get_supplier_requests($per_page = '', $limit_page = '') {

        $sql = 'SELECT fs.user_id,u.user_first_name AS request_from_firstname,'
                . 'u.user_last_name AS request_from_lastname, rt.request_type,'
                . 'sub.user_first_name AS request_to_firstname,'
                . 'sub.user_last_name AS request_to_lastname,find_sub.company_name, (case when fs.comments !="" then fs.comments else "-" end) as comments, (case when fs.sd_id > 0 then "In-House" when fs.find_supplier_id >0 THEN "Outside" end) as supplier_type '
                . ' FROM find_supplier_request fs'
                . ' LEFT JOIN request_type rt ON rt.request_id = fs.request_type_id '
                . ' LEFT JOIN users u ON u.user_id = fs.user_id '
                . ' LEFT JOIN (SELECT sd.sd_id,us.user_first_name,us.user_last_name '
                    . ' FROM supplier_details sd '
                    . ' LEFT JOIN users us ON us.user_id = sd.user_id ) sub ON sub.sd_id = fs.sd_id '
                . ' LEFT JOIN (SELECT fsd.find_supplier_id,fsd.company_name '
                    . ' FROM find_supplier_details fsd ) find_sub '
                    . 'ON find_sub.find_supplier_id = fs.find_supplier_id '
                . ' WHERE fs.is_active = 1'
                . ' AND u.is_active = 1'
                . ' AND rt.is_active = 1';
        $sql .= ' ORDER BY fs.find_supplier_request_id DESC';
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
    
    public function get_leads_count($per_page = '', $limit_page = '') {
        
        $sql = 'SELECT fsr.sd_id,concat(u.user_first_name, " ", u.user_last_name) as name,u.email,sd.company_name,COUNT(find_supplier_request_id) as counts'
                .' FROM  find_supplier_request as fsr'
                .' LEFT JOIN supplier_details AS sd ON sd.sd_id = fsr.sd_id'
                .' LEFT JOIN users AS u ON u.user_id = sd.user_id'
                .' WHERE fsr.sd_id >0 GROUP BY fsr.sd_id';
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
    
    public function get_leads_count_outside($per_page = '', $limit_page = '') {
        
        $sql = 'SELECT fsr.find_supplier_id,fsd.company_name,COUNT(find_supplier_request_id) as counts'
                .' FROM  find_supplier_request as fsr'
                .' LEFT JOIN find_supplier_details AS fsd ON fsd.find_supplier_id = fsr.find_supplier_id'
                .' WHERE fsr.find_supplier_id >0 GROUP BY fsr.find_supplier_id';
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
    
    public function get_supplier_job_count($per_page = '', $limit_page = '') {
        
        $sql = 'SELECT jsa.sd_id,concat(u.user_first_name, " ", u.user_last_name) as name,u.email,cd.company_name,count(jsa.sd_id) as counts'
                .' FROM  job_supplier_allocation as jsa'
                .' left join supplier_details as sd on sd.sd_id = jsa.sd_id'
                .' left join company_details as cd on cd.company_details_id =sd.company_details_id'
                .' left JOIN users as u on u.user_id = sd.user_id'
                .' WHERE jsa.sd_id >0 GROUP BY jsa.sd_id';
        
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
    
   /**
     * 
     * @param type $table 
     * @return type  
     */ 
    public function get_all_find_supplier($offset, $per_page){
       $sql = 'SELECT fs.*, c.country_id, c.country_name '
                . ' FROM find_supplier_details fs'
                . ' JOIN country c ON (fs.country = c.country_id)'
                . ' WHERE fs.is_active = 1 '
                . ' LIMIT '.$offset.','.$per_page;
        $result = $this->db->query($sql);
        return $result->result();
        
    }
    
     /**
     * 
     * @param type $table 
     * @return type  
     */ 
    public function get_all_find_supplier_count(){
       $sql = 'SELECT count(*) as cnt '
                . ' FROM find_supplier_details'
                . ' WHERE is_active = 1 ';
        $result = $this->db->query($sql);
        $res = $result->row();
        return $res->cnt;
    }
    
    /**
     * 
     * @param type $supplier_id
     * @return boolean
     */
    public function sub_category_count($find_supplier_id) {
        $sql = 'SELECT count(*) as count_subcat,categories.cat_id '
                . 'FROM find_supplier_sub_category '
                . 'INNER JOIN sub_categories '
                . 'on (find_supplier_sub_category.sub_category_id = sub_categories.sub_cat_id) '
                . 'INNER JOIN categories '
                . 'on (categories.cat_id=sub_categories.cat_id) '
                . 'WHERE find_supplier_sub_category.find_supplier_id = ' . $find_supplier_id . ' '
                . 'AND find_supplier_sub_category.is_active = 1 '
                . 'AND sub_categories.is_active = 1 '
                . 'GROUP BY `categories`.`cat_id`';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }
    // find product categories.
    public function get_all_productcategory_count(){
       $sql = 'SELECT count(*) as cnt '
                . ' FROM categories'
                . ' WHERE is_active = 1 ';
        $result = $this->db->query($sql);
        $res = $result->row();
        return $res->cnt;
    }
    public function get_all_product_category($offset, $per_page){
       $sql = 'SELECT * '
                . ' FROM categories'
                . ' WHERE is_active = 1 ';
        $sql .= ' ORDER BY cat_id DESC';      
        if ($per_page != 0) {
            $sql .= ' LIMIT '.$offset.','.$per_page;
        } else {
            $sql .= ' LIMIT '.$per_page;
        } 
        $result = $this->db->query($sql);
        return $result->result(); 
    }

    public function get_all_productsubcategory_count(){
       $sql = 'SELECT count(*) as cnt '
                . ' FROM sub_categories sc'
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id'
                . ' WHERE sc.is_active = 1 AND c.is_active=1';
        $result = $this->db->query($sql);
        $res = $result->row();
        return $res->cnt;
    }

    public function get_all_product_subcategory($offset, $per_page){
       $sql = 'SELECT * '
                . ' FROM sub_categories sc'
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id'
                . ' WHERE sc.is_active = 1  AND c.is_active=1';
        $sql .= ' ORDER BY sc.sub_cat_id DESC';
        if ($per_page != 0) {
            $sql .= ' LIMIT '.$offset.','.$per_page;
        } else {
            $sql .= ' LIMIT '.$per_page;
        } 
        $result = $this->db->query($sql);
        return $result->result();
    }
}
