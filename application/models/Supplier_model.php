<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Supplier_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model("Base_model");
    }

    /**
     * Method to insert seller categories to table when he signs up
     * @param type $user_id
     * @param type $subcats
     */
    public function insert_seller_categories_regions($user_id, $subcats, $regions){
        $this->load->model("Login_model");
        $sd_id = $this->User_model->get_seller_id($user_id);
        if(!empty($subcats)){
            $insert_query = " INSERT INTO supplier_sub_category (sd_id, sub_cat_id, is_active)
                                 VALUES ";
            $values = '';
            foreach ($subcats as $id) {
                $values .= "(" . $sd_id . "," . $id . ",'1' ),";
            }
            $query = $insert_query . rtrim($values, ",");
            $this->db->query($query);
            $this->Login_model->add_history_log($user_id, 'Settings', 'User Updated Categories');
        }
        if(!empty($regions)){
            $region_query = " INSERT INTO supplier_regions (sd_id, region_id, is_active)
                                 VALUES ";
            $values = '';
            foreach ($regions as $rid) {
                $values .= "(" . $sd_id . "," . $rid . ",'1' ),";
            }
            $sql = $region_query . rtrim($values, ",");
            $this->db->query($sql);
            $this->Login_model->add_history_log($user_id, 'Settings', 'User Updated Regions');
        }
        $this->Base_model->update_entry('users', array('is_settings_added' => '1'), 'user_id', $user_id);
        $this->load->model('Job_model');
        $this->Job_model->allocate_jobs_to_a_supplier($sd_id, $subcats);
        return true;
    }
    /**
     * 
     * @param type $subcat
     * @param type $supplier_id
     * @return boolean
     */
    public function add_supplier_sub_categories($subcats, $supplier_id, $user_id) {
        $exists = $this->Base_model->get_list_all('supplier_sub_category', 'sub_cat_id', array('sd_id' => $supplier_id));
        $subcategory_array = json_decode(json_encode($exists), True);
        $exists_inactive = $this->Base_model->get_list_all('supplier_sub_category', 'sub_cat_id', array('sd_id' => $supplier_id, 'is_active' => '0'));
        $subcategory_array_inactive = json_decode(json_encode($exists_inactive), True);

        $subcat_newarray = array();

        if (!empty($subcats)) {
            foreach ($subcats as $i => $sub) {
                $subcat_newarray[$i]['sub_cat_id'] = $sub;
            }

            function udiffCompare($a, $b) {
                return $a['sub_cat_id'] - $b['sub_cat_id'];
            }

            $add_arrdiff = array_udiff($subcat_newarray, $subcategory_array, 'udiffCompare');
            if (!empty($add_arrdiff)) {
                foreach ($add_arrdiff as $sub) {
                    $log_data['sub_cat_id'] = $sub['sub_cat_id'];
                    $log_data['sd_id'] = $supplier_id;
                    $log_data['is_active'] = "1";
                    $insert_id = $this->Base_model->insert_entry('supplier_sub_category', $log_data);
                }
            }


            $remove_arrdiff = array_udiff($subcategory_array, $subcat_newarray, 'udiffCompare');

            function compareDeepValue($val1, $val2) {
                return strcmp($val1['sub_cat_id'], $val2['sub_cat_id']);
            }

            $intersect = array_uintersect($subcategory_array_inactive, $subcat_newarray, 'compareDeepValue');

            if (!empty($intersect)) {
                foreach ($intersect as $sub1) {
                    $exist_subcategory = $this->Base_model->get_one_entry_all('supplier_sub_category', array('sd_id' => $supplier_id, 'sub_cat_id' => $sub1['sub_cat_id']));
                    $log_data1['is_active'] = ($exist_subcategory->is_active == 1) ? 0 : 1;
                    $this->Base_model->update_list('supplier_sub_category', $log_data1, array('sd_id' => $supplier_id, 'sub_cat_id' => $sub1['sub_cat_id']));
                }
            }

            if (!empty($remove_arrdiff)) {
                foreach ($remove_arrdiff as $sub2) {
                    $log_data2['is_active'] = "0";
                    $this->Base_model->update_list('supplier_sub_category', $log_data2, array('sd_id' => $supplier_id, 'sub_cat_id' => $sub2['sub_cat_id']));
                }
            }

            $this->load->model('Job_model');
            $this->Job_model->allocate_jobs_to_a_supplier($supplier_id, $subcats);

            $this->load->model("Login_model");
            $this->Login_model->add_history_log($user_id, 'Settings', 'User Updated Categories');
            return true;
        } else{
            return false;
        }
    }

    /**
     * 
     * @param type $regions
     * @param type $supplier_id
     * @return boolean
     */
    public function add_supplier_regions($regions, $supplier_id, $user_id) {
        $exists = $this->Base_model->get_list_all('supplier_regions', 'region_id', array('sd_id' => $supplier_id));
        $regions_array = json_decode(json_encode($exists), True);
        $exists_inactive = $this->Base_model->get_list_all('supplier_regions', 'region_id', array('sd_id' => $supplier_id, 'is_active' => '0'));
        $regions_array_inactive = json_decode(json_encode($exists_inactive), True);

        $regions_newarray = array();
        if (!empty($regions)) {
            foreach ($regions as $i => $reg) {
                $regions_newarray[$i]['region_id'] = $reg;
            }

            function udiffCompare($a, $b) {
                return $a['region_id'] - $b['region_id'];
            }

            $add_arrdiff = array_udiff($regions_newarray, $regions_array, 'udiffCompare');
            if (!empty($add_arrdiff)) {
                foreach ($add_arrdiff as $sub) {
                    $log_data['region_id'] = $sub['region_id'];
                    $log_data['sd_id'] = $supplier_id;
                    $log_data['is_active'] = "1";
                    $insert_id = $this->Base_model->insert_entry('supplier_regions', $log_data);
                }
            }

            $remove_arrdiff = array_udiff($regions_array, $regions_newarray, 'udiffCompare');

            function compareDeepValue($val1, $val2) {
                return strcmp($val1['region_id'], $val2['region_id']);
            }

            $intersect = array_uintersect($regions_array_inactive, $regions_newarray, 'compareDeepValue');

            if (!empty($intersect)) {
                foreach ($intersect as $sub1) {
                    $exist_subcategory = $this->Base_model->get_one_entry_all('supplier_regions', array('sd_id' => $supplier_id, 'region_id' => $sub1['region_id']));
                    $log_data1['is_active'] = ($exist_subcategory->is_active == 1) ? 0 : 1;
                    $this->Base_model->update_list('supplier_regions', $log_data1, array('sd_id' => $supplier_id, 'region_id' => $sub1['region_id']));
                }
            }

            if (!empty($remove_arrdiff)) {
                foreach ($remove_arrdiff as $sub2) {
                    $log_data2['is_active'] = "0";
                    $this->Base_model->update_list('supplier_regions', $log_data2, array('sd_id' => $supplier_id, 'region_id' => $sub2['region_id']));
                }
            }

            $this->load->model("Login_model");
            $this->Login_model->add_history_log($user_id, 'Settings', 'User Updated Regions');
            return true;
        } else
            return false;
    }
    
    /**
     * 
     * @param type $subcat
     * @param type $find_supplier_id
     * @return boolean
     */
    public function add_find_supplier_sub_categories($subcats, $find_supplier_id, $user_id) {
        $exists = $this->Base_model->get_list_all('find_supplier_sub_category', 'sub_category_id', array('find_supplier_id' => $find_supplier_id));
        $subcategory_array = json_decode(json_encode($exists), True);
        $exists_inactive = $this->Base_model->get_list_all('find_supplier_sub_category', 'sub_category_id', array('find_supplier_id' => $find_supplier_id, 'is_active' => '0'));
        $subcategory_array_inactive = json_decode(json_encode($exists_inactive), True);

        $subcat_newarray = array();

        if (!empty($subcats)) {
            foreach ($subcats as $i => $sub) {
                $subcat_newarray[$i]['sub_category_id'] = $sub;
            }

            function udiffCompare($a, $b) {
                return $a['sub_category_id'] - $b['sub_category_id'];
            }

            $add_arrdiff = array_udiff($subcat_newarray, $subcategory_array, 'udiffCompare');
            if (!empty($add_arrdiff)) {
                foreach ($add_arrdiff as $sub) {
                    $log_data['sub_category_id'] = $sub['sub_category_id'];
                    $log_data['find_supplier_id'] = $find_supplier_id;
                    $log_data['is_active'] = "1";
                    $insert_id = $this->Base_model->insert_entry('find_supplier_sub_category', $log_data);
                }
            }


            $remove_arrdiff = array_udiff($subcategory_array, $subcat_newarray, 'udiffCompare');

            function compareDeepValue($val1, $val2) {
                return strcmp($val1['sub_category_id'], $val2['sub_category_id']);
            }

            $intersect = array_uintersect($subcategory_array_inactive, $subcat_newarray, 'compareDeepValue');

            if (!empty($intersect)) {
                foreach ($intersect as $sub1) {
                    $exist_subcategory = $this->Base_model->get_one_entry_all('find_supplier_sub_category', array('find_supplier_id' => $find_supplier_id, 'sub_category_id' => $sub1['sub_category_id']));
                    $log_data1['is_active'] = ($exist_subcategory->is_active == 1) ? 0 : 1;
                    $this->Base_model->update_list('find_supplier_sub_category', $log_data1, array('find_supplier_id' => $find_supplier_id, 'sub_category_id' => $sub1['sub_category_id']));
                }
            }

            if (!empty($remove_arrdiff)) {
                foreach ($remove_arrdiff as $sub2) {
                    $log_data2['is_active'] = "0";
                    $this->Base_model->update_list('find_supplier_sub_category', $log_data2, array('find_supplier_id' => $find_supplier_id, 'sub_category_id' => $sub2['sub_category_id']));
                }
            }

            //$this->load->model('Job_model');
            //$this->Job_model->allocate_jobs_to_a_supplier($find_supplier_id, $subcats);

            $this->load->model("Login_model");
            $this->Login_model->add_history_log($user_id, 'Find supplier', 'User Updated Find Supplier');
            return true;
        } else{
            return false;
        }
    }
    
    /**
     * 
     * @param type $regions
     * @param type $find_supplier__id
     * @return boolean
     */
    public function add_find_supplier_regions($regions, $find_supplier_id, $user_id) {
        $exists = $this->Base_model->get_list_all('find_supplier_region', 'region_id', array('find_supplier_id' => $find_supplier_id));
        $regions_array = json_decode(json_encode($exists), True);
        $exists_inactive = $this->Base_model->get_list_all('find_supplier_region', 'region_id', array('find_supplier_id' => $find_supplier_id, 'is_active' => '0'));
        $regions_array_inactive = json_decode(json_encode($exists_inactive), True);

        $regions_newarray = array();
        if (!empty($regions)) {
            foreach ($regions as $i => $reg) {
                $regions_newarray[$i]['region_id'] = $reg;
            }

            function udiffCompare1($a, $b) {
                return $a['region_id'] - $b['region_id'];
            }

            $add_arrdiff = array_udiff($regions_newarray, $regions_array, 'udiffCompare1');
            if (!empty($add_arrdiff)) {
                foreach ($add_arrdiff as $sub) {
                    $log_data['region_id'] = $sub['region_id'];
                    $log_data['find_supplier_id'] = $find_supplier_id;
                    $log_data['is_active'] = "1";
                    $insert_id = $this->Base_model->insert_entry('find_supplier_region', $log_data);
                }
            }

            $remove_arrdiff = array_udiff($regions_array, $regions_newarray, 'udiffCompare1');

            function compareDeepValue1($val1, $val2) {
                return strcmp($val1['region_id'], $val2['region_id']);
            }

            $intersect = array_uintersect($regions_array_inactive, $regions_newarray, 'compareDeepValue1');

            if (!empty($intersect)) {
                foreach ($intersect as $sub1) {
                    $exist_subcategory = $this->Base_model->get_one_entry_all('find_supplier_region', array('find_supplier_id' => $find_supplier_id, 'region_id' => $sub1['region_id']));
                    $log_data1['is_active'] = ($exist_subcategory->is_active == 1) ? 0 : 1;
                    $this->Base_model->update_list('find_supplier_region', $log_data1, array('find_supplier_id' => $find_supplier_id, 'region_id' => $sub1['region_id']));
                }
            }

            if (!empty($remove_arrdiff)) {
                foreach ($remove_arrdiff as $sub2) {
                    $log_data2['is_active'] = "0";
                    $this->Base_model->update_list('find_supplier_region', $log_data2, array('find_supplier_id' => $find_supplier_id, 'region_id' => $sub2['region_id']));
                }
            }



            $this->load->model("Login_model");
            $this->Login_model->add_history_log($user_id, 'Settings', 'User Updated Regions');
            return true;
        } else
            return false;
    }
    

    /**
     * 
     * @param type $supplier_id
     * @return boolean
     */
    public function sub_category_count($supplier_id) {
        $sql = 'SELECT count(*) as count_subcat,categories.cat_id '
                . 'FROM supplier_sub_category '
                . 'INNER JOIN sub_categories '
                . 'on (supplier_sub_category.sub_cat_id = sub_categories.sub_cat_id) '
                . 'INNER JOIN categories '
                . 'on (categories.cat_id=sub_categories.cat_id) '
                . 'WHERE supplier_sub_category.sd_id = ' . $supplier_id . ' '
                . 'AND supplier_sub_category.is_active = 1 '
                . 'AND sub_categories.is_active = 1 '
                . 'GROUP BY `categories`.`cat_id`';
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    /**
     * 
     * @param type $user_id
     * @param type $job_status
     * @return type
     */
    public function get_supplier_quote_count($user_id, $keyword = '') {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM job_supplier_allocation jsa '
                . ' LEFT JOIN job_details j ON j.job_id = jsa.job_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN supplier_details sd ON sd.sd_id = jsa.sd_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND jsa.is_active = 1'
                . ' AND js.job_status_name = "Quote Request"'
                . ' AND sd.user_id = ' . $this->db->escape($user_id);
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
        return $result->row()->count_row;
    }

    public function get_supplier_quotes($user_id, $keyword = '', $per_page = '', $limit_page = '') {
        $sql = 'SELECT jsa.job_id,j.job_name,js.job_status_name,'
                . 'j.created_time AS created_date,j.product_lead_time,'
                . 'j.sla_milestone,cp.company_name,j.product_quantity,'
                . '(select rank '
                    . 'from job_quote '
                    . 'where job_id=j.job_id '
                    . 'and sd_id=sd.sd_id '
                    . 'and is_active = 1) as rank'
                . ' FROM job_supplier_allocation jsa '
                . ' LEFT JOIN job_details j ON j.job_id = jsa.job_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN supplier_details sd ON sd.sd_id = jsa.sd_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = cd.company_details_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND jsa.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND js.job_status_name = "Quote Request"'
                . ' AND sd.user_id = ' . $this->db->escape($user_id);
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
     * @return type
     */
    public function get_supplier_data($user_id = '', $sd_id='') {
        $sql = 'SELECT sd.sd_id,u.email AS email,cp.company_name,'
                . 'cp.company_logo_path,sd.is_vetted,a.telephone_code,a.telephone_no,a.street_address,'
                . ' a.post_code,cp.website,a.address_name,a.fax_no,a.city,a.state,'
                . ' u.user_first_name AS first_name,u.user_last_name AS last_name,c.country_name'
                . ' FROM users u '
                . ' JOIN supplier_details sd ON sd.user_id = u.user_id '
                . ' LEFT JOIN address a ON a.address_id = sd.address_id '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = sd.company_details_id AND cp.is_active = 1'
                . ' LEFT JOIN country c ON c.country_id = a.country_id '
                . ' WHERE sd.is_active = 1'
                . ' AND u.is_active = 1';
        if(!empty($sd_id)){
            $sql .=  ' AND sd.sd_id =' . $this->db->escape($sd_id);
        }else{
            $sql .= ' AND sd.user_id =' . $this->db->escape($user_id);
        }
        $result = $this->db->query($sql);
        return $result->row();
    }
    
    public function get_unregistered_supplier_data($sd_id) {
        $sql = 'SELECT fsd.find_supplier_id AS sd_id,fsd.email AS email,fsd.company_name,'
                . 'fsd.telephone_code,fsd.telephone_number AS telephone_no,c.country_name'
                . ' FROM  find_supplier_details fsd'
                . ' LEFT JOIN country c ON c.country_id = fsd.country '
                . ' WHERE fsd.is_active = 1'
                . ' AND fsd.find_supplier_id =' . $this->db->escape($sd_id);
        
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * 
     * @param type $user_id
     * @param type $job_status
     * @return boolean
     */
    public function get_supplier_order_count($user_id, $keyword = '') {

        $sql = 'SELECT count(*) as count_row '
                . ' FROM job_details j '
                . ' JOIN job_order jo ON jo.job_id = j.job_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN supplier_details sd ON sd.sd_id = jo.sd_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND jo.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND js.job_status_name = "Order"'
                . ' AND sd.user_id = ' . $this->db->escape($user_id);
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
    public function get_supplier_orders($user_id, $keyword = '', $per_page = '', $limit_page = '') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,cp.company_name,j.product_quantity,'
                . 'j.created_time AS created_date,j.product_lead_time,j.sla_milestone '
                . ' FROM job_details j '
                . ' JOIN job_order jo ON jo.job_id = j.job_id '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN supplier_details sd ON sd.sd_id = jo.sd_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = cd.company_details_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND jo.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND js.job_status_name = "Order"'
                . ' AND sd.user_id = ' . $this->db->escape($user_id);
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
     * @return type
     */
    public function get_seller_completed_order_count($user_id, $keyword ='') {
        $sql = 'SELECT count(*) as count_row '
                . ' FROM job_details j '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_order jo ON jo.job_id = j.job_id  '
                . ' LEFT JOIN supplier_details sd ON sd.sd_id = jo.sd_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND jo.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND js.job_status_name = "Completed"'
                . ' AND sd.user_id = ' . $this->db->escape($user_id);
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
        $sql .= ' ORDER BY j.completed_time DESC';
        
        $result = $this->db->query($sql);
        return $result->row()->count_row;
    }

    public function get_seller_completed_orders($user_id, $keyword ='', $per_page ='', $limit_page ='') {

        $sql = 'SELECT j.job_id,j.job_name,js.job_status_name,cp.company_name,j.product_quantity,'
                . 'j.created_time AS created_date,j.product_lead_time,j.completed_time'
                . ' FROM job_details j '
                . ' LEFT JOIN job_status js ON js.job_status_id = j.job_status_id '
                . ' LEFT JOIN job_order jo ON jo.job_id = j.job_id  '
                . ' LEFT JOIN supplier_details sd ON sd.sd_id = jo.sd_id '
                . ' LEFT JOIN job_sub_category jsc ON jsc.job_id = j.job_id '
                . ' LEFT JOIN sub_categories sc ON sc.sub_cat_id = jsc.sub_cat_id '
                . ' LEFT JOIN categories c ON sc.cat_id = c.cat_id '
                . ' LEFT JOIN consumer_details cd ON cd.cd_id = j.cd_id '
                . ' LEFT JOIN company_details cp ON cp.company_details_id = cd.company_details_id '
                . ' WHERE j.is_active = 1'
                . ' AND js.is_active = 1'
                . ' AND jo.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND js.job_status_name = "Completed"'
                . ' AND sd.user_id = ' . $this->db->escape($user_id);
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
     * Fecth all sellers who have been allocated to a job
     * @param type $job_id
     * @return type
     */
    public function get_sellers_of_job($job_id){
        $sql = 'SELECT u.user_id,u.email,u.user_first_name,u.user_last_name'
                . ' FROM users u '
                . ' JOIN supplier_details sd ON sd.user_id = u.user_id '
                . ' LEFT JOIN job_supplier_allocation jsa ON jsa.sd_id = sd.sd_id '
                . ' WHERE u.is_active = 1'
                . ' AND sd.is_active = 1'
                . ' AND jsa.is_active = 1'
                . ' AND jsa.job_id ='.$job_id;
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    /**
     * Fetch all active seller quotes of a job
     */
    public function get_seller_quotes_of_job($job_id){
        $sql = 'SELECT jq.jq_id,sd.sd_id,jq.rank,u.user_id,u.user_first_name,'
                . 'u.user_last_name,u.email'
                . ' FROM job_quote jq '
                . ' JOIN supplier_details sd ON sd.sd_id = jq.sd_id '
                . ' JOIN users u ON u.user_id = sd.user_id '
                . ' WHERE sd.is_active = 1'
                . ' AND jq.is_active = 1'
                . ' AND jq.job_id ='.$job_id;
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    /**
     * Get all active allocated sellers of a job
     * @param type $job_id
     * @return type
     */
    
    public function get_allocated_sellers_of_job($job_id){
        $sql = 'SELECT sd.sd_id,jsa.jsa_id,sd.user_id'
                . ' FROM supplier_details sd '
                . ' LEFT JOIN job_supplier_allocation jsa ON jsa.sd_id = sd.sd_id '
                . ' WHERE sd.is_active = 1'
                . ' AND jsa.is_active = 1'
                . ' AND jsa.job_id ='.$job_id;
        $result = $this->db->query($sql);
        return $result->result();
    }
    
    public function deactivate_seller_quote($job_id, $admin_id){
        $seller_quote_ids = $this->get_seller_quotes_of_job($job_id);
        if(!empty($seller_quote_ids)){
            $history_desc = $this->config->item('job_history_desc','smartcardmarket')['seller_quote_deactivated'];
            $this->Base_model->update_list('job_quote', array('is_active' => 0), array('job_id' =>$job_id));
            //adding job history for supplier allocation
            $this->load->model("Job_model");
            $this->Job_model->add_job_history($admin_id, $job_id, $history_desc);
        }
    }
    public function deallocate_sellers_of_job($job_id, $admin_id){
        $allocated_seller_ids = $this->get_allocated_sellers_of_job($job_id);
        if(!empty($allocated_seller_ids)){
            $history_desc = $this->config->item('job_history_desc','smartcardmarket')['quote_deallocated'];
            
            $this->Base_model->update_list('job_supplier_allocation',
                        array('is_active' => 0), array('job_id' =>$job_id));
            //adding job history for supplier allocation
            $this->load->model("Job_model");
            $this->Job_model->add_job_history($admin_id, $job_id, $history_desc);
        }
    }

}
