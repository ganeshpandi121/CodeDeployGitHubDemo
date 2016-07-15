<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Consumer_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    
    /**
     * 
     * @param type $user_id
     * @param type $job_status
     * @return boolean
     */
    public function get_consumer_quote_count($user_id, $keyword = '') {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Quote Request"'
                . ' AND cd.user_id = ' . $this->db->escape($user_id);
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'j.job_name LIKE "%' . $keyword . '%"'
                    . 'OR sc.sub_category_name LIKE "%' . $keyword . '%" '
                    . 'OR c.category_name LIKE "%' . $keyword . '%"';
            if (is_numeric($keyword)) {
                $sql .= ' OR j.job_id =' . $keyword;
            }
            $sql .= ')';
        }
        $sql .= ' ORDER BY j.created_time DESC';
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->row()->count_row;
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
    public function get_consumer_quotes($user_id, $keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,j.product_quantity,'
                . 'j.created_time AS created_date,j.product_lead_time,j.sla_milestone,'
                . '(SELECT count(jq.jq_id) '
                    . ' FROM job_quote jq'
                    . ' WHERE jq.job_id = j.job_id '
                    . ' AND jq.is_active = 1) AS seller_quote_count,'
                . ' (SELECT COUNT(n.notification_id)'
                     . ' FROM notification n '
                     . ' WHERE n.job_id = j.job_id '
                     . ' AND n.user_id = cd.user_id'
                     . ' AND n.is_read = 0'
                     . ' ) AS job_has_notification'
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.job_status_name = "Quote Request"'
                . ' AND cd.user_id = ' . $this->db->escape($user_id);
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
     * @param type $user_id
     * @param type $job_status
     * @return boolean
     */
    public function get_consumer_order_count($user_id, $keyword = '') {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM job_details j'
                . ' JOIN job_order jo ON jo.job_id = j.job_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND jo.is_active = 1'
                . ' AND js.job_status_name = "Order"'
                . ' AND cd.user_id = ' . $this->db->escape($user_id);
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
        $sql .= ' ORDER BY jo.created_time DESC';
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->row()->count_row;
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
    public function get_consumer_orders($user_id, $keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,j.product_quantity,'
                . 'j.created_time AS created_date,j.product_lead_time,j.sla_milestone '
                . ' FROM job_details j'
                . ' JOIN job_order jo ON jo.job_id = j.job_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND jo.is_active = 1'
                . ' AND js.job_status_name = "Order"'
                . ' AND cd.user_id = ' . $this->db->escape($user_id);
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
        $sql .= ' ORDER BY jo.created_time DESC';
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
     * @param type $user_id
     * @param type $job_status
     * @return boolean
     */
    public function get_buyer_completed_order_count($user_id, $keyword = '') {

        $sql = 'SELECT count(*) as count_row'
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND cd.is_active = 1'
                . ' AND js.job_status_name = "Completed"'
                . ' AND cd.user_id = ' . $this->db->escape($user_id);
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
        $result = $this->db->query($sql);

        if ($result->num_rows() > 0) {
            return $result->row()->count_row;
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
    public function get_buyer_completed_orders($user_id, $keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,j.product_quantity,'
                . 'j.created_time AS created_date,j.completed_time'
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND cd.is_active = 1'
                . ' AND js.job_status_name = "Completed"'
                . ' AND cd.user_id = ' . $this->db->escape($user_id);
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
     * @param type $user_id
     * @param type $job_status
     * @return boolean
     */
    public function get_buyer_passed_order_count($user_id, $keyword = '') {
        $sql = 'SELECT count(*) as count_row'
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND cd.is_active = 1'
                . ' AND js.job_status_name = "Cancelled"'
                . ' AND cd.user_id = ' . $this->db->escape($user_id);
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
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->row()->count_row;
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
    public function get_buyer_passed_orders($user_id, $keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,j.product_quantity,j.created_time'
                . ' FROM job_details j'
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id'
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND cd.is_active = 1'
                . ' AND js.job_status_name = "Cancelled"'
                . ' AND cd.user_id = ' . $this->db->escape($user_id);
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

}
