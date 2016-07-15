<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Pagination_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function init_pagination($url, $tot_count, $per_page) {
        $this->load->library('pagination');

        $config['per_page'] = $per_page;
        $config['uri_segment'] = 3;
        $config['base_url'] = $url;
        $config['total_rows'] = $tot_count;
        $config['use_page_numbers'] = TRUE;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a><b>';
        $config['cur_tag_close'] = '</b></a></li>';

        $this->pagination->initialize($config);

        return $config;
    }

    public function count_all($table, $condition_arr = array()) {
        //supllier quote list 
        $this->db->select("count(*) as count_row");
        $this->db->where($condition_arr);
        $q = $this->db->get($table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function limit_page($table, $condition_arr = array(), $per_page, $limit_page) {
        //supllier quote list 
        $this->db->select("*");
        $this->db->where($condition_arr);
        if ($per_page != 0) {
            $this->db->limit($limit_page, $per_page);
        } else {
            $this->db->limit($limit_page);
        }
        $q = $this->db->get($table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

}
