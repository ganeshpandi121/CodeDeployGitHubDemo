<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class News_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('Base_model');
    }

    /**
     * 
     * @param type $news_id  
     * @return type  
     */
    public function get_news_data($news_id) {
        $sql = 'SELECT n.news_id,n.news_title,n.news_permalink,n.description,n.news_subcategory_id,nc.news_category_id,'
                . ' m.meta_id,m.meta_title,m.meta_keyword,m.meta_description,n.created_time,'
                . ' cpm.cat_id ,cpm.sub_cat_id ,'
                . ' nm.image_path'
                . ' FROM news n '
                . ' LEFT JOIN news_subcategory nsc ON n.news_subcategory_id = nsc.news_subcategory_id'
                . ' LEFT JOIN news_category nc ON n.news_category_id = nc.news_category_id'
                . ' LEFT JOIN meta m ON n.meta_id = m.meta_id'
                . ' LEFT JOIN content_product_mapping cpm ON n.news_id = cpm.news_id'
                . ' LEFT JOIN categories c ON cpm.cat_id = c.cat_id'
                . ' LEFT JOIN sub_categories sc ON cpm.sub_cat_id = sc.sub_cat_id'
                . ' LEFT JOIN news_images nm ON n.news_id = nm.news_id'
                . ' WHERE n.news_id = ' . $news_id
                . ' AND n.is_active = 1';
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * 
     * @param type $table 
     * @return type  
     */
    public function get_all_news_count() {
        $sql = 'SELECT count(*) as cnt '
                . ' FROM news'
                . ' WHERE is_active = 1 AND news_subcategory_id!=0';
        $result = $this->db->query($sql);
        $res = $result->row();
        return $res->cnt;
    }

    /**
     * 
     * @param type $table 
     * @return type  
     */
    public function get_all_news($offset, $per_page) {
        $sql = 'SELECT * '
                . ' FROM news'
                . ' WHERE is_active = 1 AND news_subcategory_id!=0'
                . ' ORDER BY news_id DESC'
                . ' LIMIT ' . $offset . ',' . $per_page;
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function get_front_news_count($keyword = '') {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM news n'
                . ' LEFT JOIN news_subcategory nsc ON nsc.news_subcategory_id = n.news_subcategory_id'
                . ' LEFT JOIN news_category nc ON nc.news_category_id = nsc.news_category_id'
                . ' WHERE n.is_active = 1'
                . ' AND nsc.is_active = 1'
                . ' AND nc.is_active = 1';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'n.news_title LIKE "%' . $keyword . '%"'
                    . 'OR nc.category_name LIKE "%' . $keyword . '%" ';
            $sql .= ')';
        }
        $sql .= ' ORDER BY n.created_time DESC';
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
    public function get_front_news($keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT n.news_title,n.description,n.news_permalink,n.news_id,'
                . 'nc.category_name,nc.news_category_id,nsc.news_subcategory_id,'
                . 'nsc.subcategory_name,n.created_time,ni.image_path '
                . ' FROM news n'
                . ' LEFT JOIN news_subcategory nsc ON nsc.news_subcategory_id = n.news_subcategory_id'
                . ' LEFT JOIN news_category nc ON nc.news_category_id = nsc.news_category_id AND nc.is_active = 1'
                . ' LEFT JOIN news_images ni ON ni.news_id = n.news_id AND ni.is_active = 1'
                . ' WHERE nc.category_name LIKE "News"';
        if (!empty($keyword)) {
            $sql .= ' AND ('
                    . 'n.news_title LIKE "%' . $keyword . '%"'
                    . ' OR nc.category_name LIKE "%' . $keyword . '%" ';
            $sql .= ')';
        }
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

    /*
     * get news comments
     */

    public function get_news_comments($news_id, $per_page = '', $limit_page = '') {
        $sql = 'SELECT nc.*, u.user_first_name, u.user_last_name, u.user_type_id, '
                . ' case u.user_type_id '
                . ' when "2" then (SELECT c.logo_path FROM consumer_details c WHERE c.user_id = u.user_id) '
                . ' when "3" then (SELECT s.logo_path FROM supplier_details s WHERE s.user_id = u.user_id) '
                . ' when "4" then (SELECT f.logo_path FROM freight_details f WHERE f.user_id = u.user_id) '
                . ' when "1" then (SELECT a.logo_path FROM admin_details a WHERE a.user_id = u.user_id) '
                . ' end as logo_path'
                . ' FROM news_comments nc'
                . ' LEFT JOIN users u ON u.`user_id` = nc.`user_id` '
                . ' WHERE nc.news_id = ' . $news_id
                . ' AND nc.is_moderated = 1'
                . ' AND nc.is_active = 1'
                . ' ORDER BY nc.news_comment_id DESC';
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
    public function get_all_news_comment_count($news_id){
       $sql = 'SELECT count(*) as cnt '
               .' FROM news_comments nc'
               .' LEFT JOIN users u ON u.`user_id` = nc.`user_id` '
               .' WHERE nc.news_id = '. $news_id 
               . ' AND nc.is_moderated = 1'
               . ' AND nc.is_active = 1'
               .' ORDER BY nc.news_comment_id DESC' ;
                
        $result = $this->db->query($sql);
        return  $result->row()->cnt;
    }
    
    public function get_admin_news_comment($offset, $per_page){
     
       $sql = 'SELECT n.news_title,nc.description,nc.news_comment_id,nc.is_moderated,'
               . 'concat(u.user_first_name," ",u.user_last_name) as name,u.email'
                . ' FROM news_comments nc'
                . ' LEFT JOIN news n ON nc.news_id = n.news_id'
                . ' LEFT JOIN users u ON nc.user_id = u.user_id'
                . ' WHERE nc.is_active = 1'
                . ' ORDER BY nc.created_time DESC';
        if ($per_page != 0) {
            $sql .= ' LIMIT '.$per_page.' OFFSET '.$offset;
        } else {
            $sql .= ' LIMIT '.$per_page;
        }
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result();
        }
        return array();
    }
    public function get_admin_news_comment_count(){
       $sql = 'SELECT count(*) as cnt '
               . ' FROM news_comments nc'
                . ' LEFT JOIN news n ON nc.news_id = n.news_id'
                . ' LEFT JOIN users u ON nc.user_id = u.user_id'
                . ' WHERE nc.is_active = 1'
                . ' ORDER BY nc.created_time DESC';
        $result = $this->db->query($sql);
        return  $result->row()->cnt;
    }
    public function get_all_product_count(){
       $sql = 'SELECT count(*) as cnt '
                . ' FROM news '
                . ' WHERE is_active = 1 AND news_subcategory_id=0 ';
        $result = $this->db->query($sql);
        $res = $result->row();
        return $res->cnt;
    }

    /**
     * 
     * @param type $table 
     * @return type  
     */
    public function get_all_product($offset, $per_page) {
        $sql = 'SELECT * '
                . ' FROM news'
                . ' WHERE is_active = 1 AND news_subcategory_id=0 '
                . ' ORDER BY news_id DESC'
                . ' LIMIT ' . $offset . ',' . $per_page;
        $result = $this->db->query($sql);
        return $result->result();
    }

}
