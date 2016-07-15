<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class General_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model("Base_model");
    }

    public function get_all_country() {
        return $this->Base_model->get_all("country");
    }

    public function get_all_user_type() {
        return $this->Base_model->get_all("user_type");
    }

    public function get_all_categories() {
        return $this->Base_model->get_list("categories", "cat_id,category_name");
    }

    public function get_all_sub_categories() {
        return $this->Base_model->get_all("sub_categories");
    }

    public function get_sub_categories_by_catid($cat_id) {
        $this->db->where('cat_id', $cat_id);
        $this->db->where('is_active', '1');
        $q = $this->db->get("sub_categories");
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function get_all_categories_sub_categories() {
        $categories = $this->get_all_categories();
        foreach ($categories as $category) {
            $sub_categories = $this->get_sub_categories_by_catid($category->cat_id);
            $sub_cat = array();
            if(!empty($sub_categories)){
                foreach ($sub_categories as $sub_category) {
                    $sub_cat[] = array('sub_cat_id' => $sub_category->sub_cat_id, 'sub_category_name' => $sub_category->sub_category_name);
                }
            
                $cat[] = array('cat_id' => $category->cat_id, 'category_name' => $category->category_name, 'sub_category' => $sub_cat);
            }
        }
        return $cat;
    }

    /**
     * 
     * @return type
     */
    public function get_all_currency() {
        return $this->Base_model->get_all("currency");
    }

    /**
     * 
     * @return type
     */
    public function get_all_file_type() {
        return $this->Base_model->get_all("file_type");
    }

    /**
     * 
     * @return type
     */
    public function get_all_incoterms() {
        return $this->Base_model->get_all("incoterm");
    }

    /** Get all regions * */
    public function get_all_regions() {
        return $this->Base_model->get_all("regions");
    }

    /**
     * 
     * @param type $user_id
     * @return type
     */
    public function get_user_data($user_id) {
        $sql = 'SELECT u.user_id AS user_id,u.email AS email,'
                . 'u.user_first_name AS first_name,u.user_last_name AS last_name,'
                . 'u.is_verified AS is_verified,'
                . 'ut.user_type_id AS user_type_id,ut.user_type_name AS user_type'
                . ' FROM users u '
                . ' LEFT JOIN user_type ut ON u.user_type_id = ut.user_type_id '
                . ' WHERE u.user_id =' . $this->db->escape($user_id);

        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * 
     * @return type
     */
    public function get_file_type() {
        $this->db->select('file_type_id,file_type_name');
        $q = $this->db->get('file_type');
        $this->db->where('is_active', '1');
        if ($q->num_rows() > 0) {
            $file_arr = $q->result();
            foreach ($file_arr as $data) {
                $arr[$data->file_type_id] = $data->file_type_name;
            }
            return $arr;
        }
        return array();
    }

    /* Common method for uploading a file
     * 
     * $upload_folder (string) specifies file path
     * $file_arr (array) entire FILE array
     * $config (array) specifies configurations for the file upload
     */

    public function do_upload($file_name, $file_arr, $upload_folder, $config = array()) {

        $path_parts = pathinfo($file_arr['name']);
        $upload_file_name = $path_parts['filename'] . "_" . time() . '.' . $path_parts['extension'];

        //$config['upload_path'] = $this->config->item('upload_path').'/'.$upload_folder;
        $config['upload_path'] = './uploads' . '/' . $upload_folder;
        if (empty($config)) {
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['max_size'] = '100';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
        }
        $config['file_name'] = $upload_file_name;

        $this->load->library('upload', $config);

        $upload_data = '';
        $error = '';
        if (!$this->upload->do_upload($file_name)) {
            $error = $this->upload->display_errors();
        } else {
            $upload_data = $this->upload->data();
        }
        return array('data' => $upload_data, 'error' => $error);
    }

    /* Common method for downloading a file
     * 
     * $upload_folder (string) specifies file path
     * $file_name (string) file name from table
     * 
     */

    public function do_download($file_name, $folder) {

        $this->load->helper('download');

        $file_path = './uploads/' . $folder . '/' . $file_name;
        $file_extn = pathinfo($file_path, PATHINFO_EXTENSION);
        $data = file_get_contents($file_path); //assuming my file is on localhost
        $download_file_name = 'document' . '.' . $file_extn;
        force_download($download_file_name, $data);
    }

    /**
     * 
     * @return type
     */
    public function get_shipping_method() {
        return $this->Base_model->get_all("shipping_method");
    }

    /**
     * 
     * @param type $address_id
     * @return type
     */
    public function get_full_address($address_id) {
        $sql = "SELECT a.*,c.country_id, c.country_name,c.iso_country_code "
                . " FROM address a "
                . " LEFT JOIN country c on a.country_id = c.country_id "
                . " WHERE address_id=" . $this->db->escape($address_id) . " "
                . " AND c.is_active=1 "
                . " AND a.is_active=1";

        $result = $this->db->query($sql);
        return $result->row();
    }
    
   
    public function get_all_telephone_codes() {
        $this->db->cache_on();
        $result = $this->db->query("SELECT telephone_code, country_id, country_name FROM country WHERE telephone_code != 'NULL'");
        
        if ($result->num_rows() > 0) {
            return $result->result();
        }
        return array();
        
    }
    
    /*
     * Generating permalink
     */
    public function create_url($url){
        return preg_replace('#[ -]+#', '-', $url);
    }
    
    /*
     * Get permalink
     */
    public function get_permalink($table,$url_field,$condition=array()){
        $this->db->select($url_field);
        if($condition){
            $this->db->where($condition);    
        }
        $this->db->where('is_active', '1');
        $q = $this->db->get($table);
        if ($q->num_rows() > 0) {
            $res = $q->result();
            return $res[0]->$url_field;
        }
        return false;
    }

}
