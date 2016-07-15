<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class JobQuote_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_supplier_quotes($user_id) {
        $sql = 'SELECT jsa.job_id,j.job_name,js.job_status_name,from_unixtime(j.created_time, "%M %d, %Y") AS created_date, '
                . 'from_unixtime(j.created_time, "%M %d, %Y %h:%i:%s") AS created_time '
                . ' FROM job_supplier_allocation jsa '
                . ' LEFT JOIN job_details j ON j.job_id = jsa.job_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN supplier_details sd ON sd.sd_id = jsa.sd_id '
                . ' WHERE j.is_active = 1'
                . ' AND sd.user_id =' . $this->db->escape($user_id);
        $result = $this->db->query($sql);
        return $result->result();
    }

    /**
     * fetch all supplier quotes of a job
     * @param type $job_id
     * @return type
     */
    public function get_supplier_quote_by_job($job_id) {
        $sql = 'SELECT sd.sd_id, u.user_id AS user_id, u.email AS email,'
                . 'jq.jq_id, jq.price_per_unit, jq.total_order,jq.freight_quote_cost, '
                . 'jq.lead_time,jq.job_id,jq.is_approved,jq.total_cost_rank,jq.total_cost,'
                . ' CONCAT(u.user_first_name, " ",u.user_last_name) AS supplier_name,'
                . 'jq.rank,co.iso_country_code,co.country_name,'
                . ' cp.company_name,cp.company_logo_path '
                . ' FROM users u'
                . ' JOIN supplier_details sd ON sd.user_id = u.user_id '
                . ' JOIN job_quote jq ON jq.sd_id = sd.sd_id '
                . ' LEFT JOIN address ad ON sd.address_id=ad.address_id '
                . ' LEFT JOIN country co ON ad.country_id=co.country_id '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = sd.company_details_id '
                . ' WHERE u.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND jq.is_active = 1'
                . ' AND jq.job_id = ' . $this->db->escape($job_id)
                . ' ORDER BY jq.total_cost_rank ASC, jq.created_time DESC';
        $result = $this->db->query($sql);
        return  $result->result();
    }

    /**
     * 
     * @param type $job_id
     * @param type $quote_id
     * @return boolean
     */
    public function add_job_order($job_id, $quote_id) {
        $this->load->model('Base_model');
        $this->load->model('Job_model');

        $user_id = $this->session->userdata('user_id');
        $quote_data = $this->Base_model->get_one_entry('job_quote', array('jq_id' => $quote_id));

        $order_exists = $this->Base_model->get_one_entry_all('job_order', array(
            'jq_id' => $quote_id,
            'job_id' => $job_id,
            'sd_id' => $quote_data->sd_id)
        );
        
        $job_status = $this->Base_model->get_one_entry('job_status', array('job_status_name' => 'Order'));

        $history_desc = $this->config->item('job_history_desc','smartcardmarket')['supplier_quote_approval'];
        $this->Job_model->add_job_history($user_id, $job_id, $history_desc);
        $this->Job_model->update_job_status($job_id, $job_status->job_status_id);

        if (empty($order_exists)) {
            //send email notification to approved supplier
            $this->load->model('Email_model');
            $this->Email_model->supplier_quote_approve_notify($job_id, $user_id);

            $insert_arr = array(
                'job_id' => $job_id,
                'jq_id' => $quote_id,
                'sd_id' => $quote_data->sd_id,
                'user_id' => $user_id,
                'created_time' => time(),
                'is_active' => '1'
            );
            return $this->Base_model->insert_entry('job_order', $insert_arr);
        }
        return false;
    }

    /**
     * 
     * @param type $job_id
     * @param type $quote_id
     * @return type
     * 
     */
    public function remove_job_order($job_id, $quote_id) {

        return $this->Base_model->delete_entry('job_order', array('job_id' => $job_id, 'jq_id' => $quote_id)
        );
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function get_approved_quote_of_order($job_id) {
        $sql = 'SELECT sd.sd_id, cp.company_logo_path, u.user_id AS user_id, u.email AS email,'
                . 'jq.*, c.currency_name, i.incoterm_name,'
                . ' CONCAT(u.user_first_name, " ",u.user_last_name) AS supplier_name'
                . ' FROM users u'
                . ' JOIN supplier_details sd ON sd.user_id = u.user_id '
                . ' JOIN job_quote jq ON jq.sd_id = sd.sd_id '
                . ' LEFT JOIN currency c ON c.currency_id = jq.currency_id '
                . ' LEFT JOIN incoterm i ON i.incoterm_id = jq.incoterm_id '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = sd.company_details_id AND cp.is_active = 1'
                . ' WHERE jq.is_active = 1'
                . ' AND jq.is_approved = 1'
                . ' AND jq.job_id = ' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * 
     * @param type $sd_id
     * @return type
     */
    public function get_approved_supplier_data($sd_id) {
        $sql = 'SELECT sd.sd_id, sd.address_id, u.user_id AS user_id, u.email AS email, a.telephone_code, a.telephone_no,'
                . ' CONCAT(u.user_first_name, " ",u.user_last_name) AS supplier_name, sd.description,'
                . ' cp.company_name,sd.trading_name,sd.brand,cp.website,cp.company_logo_path,'
                . ' a.address_name, a.street_address, a.city, a.state, a.post_code, a.fax_no, c.country_name'
                . ' FROM users u'
                . ' JOIN supplier_details sd ON sd.user_id = u.user_id '
                . ' LEFT JOIN address a ON a.address_id = sd.address_id AND a.is_active = 1'
                . ' LEFT JOIN country c ON c.country_id = a.country_id '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = sd.company_details_id AND cp.is_active = 1'
                . ' WHERE sd.sd_id = ' . $this->db->escape($sd_id);
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * 
     * @param type $job_id
     * @param type $job_quote_id
     * @return boolean
     */
    public function calculate_job_quote_ranking($job_id, $job_quote_id) {
        $quote_data = $this->Base_model->get_one_entry('job_quote', array('jq_id' => $job_quote_id));
        if (!empty($quote_data)) {
            $this->add_job_rank($job_id);
        } else {
            $update_sql = " UPDATE job_quote jq "
                    . " SET jq.rank = 1 "
                    . " WHERE jq.is_active = 1"
                    . " AND jq.jq_id = " . $this->db->escape($job_quote_id);
            $this->db->query($update_sql);
        }
        $this->load->model('Email_model');
        $this->Email_model->seller_quote_notify($job_id);

        return true;
    }

    /**
     * 
     * @param type $job_id
     */
    public function add_job_rank($job_id) {
        $sql = "SELECT jq.jq_id"
                . " FROM job_quote jq"
                . " WHERE jq.is_active = 1"
                . " AND jq.job_id = " . $this->db->escape($job_id)
                . " ORDER BY jq.total_order ASC";
        $update_rows = $this->db->query($sql)->result();
        $rank = 1;
        foreach ($update_rows as $rows) {
            $update_sql = " UPDATE job_quote jq "
                    . " SET jq.rank = $rank "
                    . " WHERE jq.is_active = 1"
                    . " AND jq.jq_id = " . $this->db->escape($rows->jq_id);
            $this->db->query($update_sql);
            $rank++;
        }
    }
    
    /**
     * 
     * @param type $job_id
     * @param type $job_quote_id
     * @return boolean
     */
    public function calculate_total_cost_ranking($job_id, $job_quote_id) {
        $quote_data = $this->Base_model->get_one_entry('job_quote', array('jq_id' => $job_quote_id));
        if (!empty($quote_data)) {
            $this->add_total_cost_rank($job_id);
        } else {
            $update_sql = " UPDATE job_quote jq "
                    . " SET jq.total_cost_rank = 1 "
                    . " WHERE jq.is_active = 1"
                    . " AND jq.jq_id = " . $this->db->escape($job_quote_id);
            $this->db->query($update_sql);
        }

        return false;
    }

    /**
     * 
     * @param type $job_id
     */
    public function add_total_cost_rank($job_id) {
        $sql = "SELECT jq.jq_id,jq.total_cost,sd_id,jq.total_cost_rank"
                . " FROM job_quote jq"
                . " WHERE jq.is_active = 1"
                . " AND jq.job_id = " . $this->db->escape($job_id)
                . " ORDER BY jq.total_cost ASC";
        $update_rows = $this->db->query($sql)->result();
        $rank = 1;
        foreach ($update_rows as $rows) {
            $update_sql = " UPDATE job_quote jq "
                    . " SET jq.total_cost_rank = $rank "
                    . " WHERE jq.is_active = 1"
                    . " AND jq.jq_id = " . $this->db->escape($rows->jq_id);
            $this->db->query($update_sql);
            $rank++;
            
        }
    }
    
    /**
     * 
     * @param type $seller_id
     * @param type $job_id
     * @return type
     */
     public function get_seller_quotes_of_job($job_id) {
        $sql = 'SELECT sd.sd_id,jq.jq_id,'
                . ' CONCAT(u.user_first_name, " ",u.user_last_name) AS supplier_name'
                . ' FROM users u'
                . ' JOIN supplier_details sd ON sd.user_id = u.user_id '
                . ' JOIN job_quote jq ON jq.sd_id = sd.sd_id '
                . ' WHERE u.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND jq.is_active = 1'
                . ' AND jq.job_id = ' . $this->db->escape($job_id);
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    public function get_seller_quote_data($jq_id) {
        $sql = 'SELECT sd.sd_id,jq.*,c.currency_name,i.incoterm_name,'
                . ' CONCAT(u.user_first_name, " ",u.user_last_name) AS supplier_name'
                . ' FROM job_quote jq'
                . ' JOIN supplier_details sd ON jq.sd_id = sd.sd_id '
                . ' JOIN users u ON sd.user_id = u.user_id '
                . ' LEFT JOIN currency c ON c.currency_id = jq.currency_id '
                . ' LEFT JOIN incoterm i ON i.incoterm_id = jq.incoterm_id '
                . ' WHERE u.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND jq.is_active = 1'
                . ' AND jq.jq_id = ' . $this->db->escape($jq_id);
        $result = $this->db->query($sql);
        return $result->row();
    }
    
    /**
     * 
     * @param type $job_id
     * @param type $seller_id
     * @return type
     */
    public function check_seller_has_quote_for_job($job_id, $seller_id){
       if(!empty($job_id)){
        $sql = 'SELECT j.job_id'
                 . ' FROM job_details j'
                 .'  JOIN job_status js ON js.job_status_id = j.job_status_id'
                 .'  JOIN job_quote jq ON jq.job_id = j.job_id'
                 . ' JOIN supplier_details sd ON jq.sd_id = sd.sd_id '
                 . ' WHERE j.is_active = 1'
                 . ' AND js.is_active = 1'
                 . ' AND jq.is_active = 1'
                 . ' AND js.job_status_name = "Quote Request"'
                 . ' AND sd.user_id = '.$seller_id
                 . ' AND j.job_id = ' . $job_id;
         return $this->db->query($sql)->row();
       }
       return false;
    }
    
    
}
