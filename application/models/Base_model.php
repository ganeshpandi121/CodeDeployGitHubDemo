<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Base_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    /* Returns all records from the table

     * Parameters
     * $table (string) specifies table name
     */

    public function get_all($table) {
        $this->db->where('is_active', '1');
        $q = $this->db->get($table);
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    /* Returns all active records from the table with specified fields

     * Parameters
     * $table (string) specifies table name
     * $fields (string seperated by comma)
     */

    public function get_list($table, $fields, $condition = array(), $limit = '') {

        $this->db->select($fields);
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->where('is_active', '1');
        $q = $this->db->get($table);
        if (!empty($limit)) {
            $this->db->limit($limit);
        }
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    /* Returns all records from the table with specified fields

     * Parameters
     * $table (string) specifies table name
     * $fields (string seperated by comma)
     */

    public function get_list_all($table, $fields, $condition = array(), $limit = '') {

        $this->db->select($fields);
        if ($condition) {
            $this->db->where($condition);
        }
        $q = $this->db->get($table);
        if (!empty($limit)) {
            $this->db->limit($limit);
        }
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return array();
    }

    /* Returns a row from the table only active

     * Parameters
     * $table (string) specifies table name
     * $condition_array (array) specifies condition

     */

    public function get_one_entry($table, $condition_array, $fields='') {
        if ($fields) {
            $this->db->select($fields);
        }
        $this->db->where($condition_array);
        $this->db->where('is_active', '1');
        $q = $this->db->get($table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    /**
     * This to get one  entry whether active or inactive
     * @param type $table
     * @param type $condition_array
     * @return boolean
     */
    public function get_one_entry_all($table, $condition_array) {
        $this->db->where($condition_array);
        $q = $this->db->get($table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    /* Insert entries into table

     * Parameters
     * $table (string) specifies table name
     * $data (array), that needs to be inserted

     */

    public function insert_entry($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * Inserts entries in a batch
     * @param type $table
     * @param type $data
     * @return type
     */
    public function insert_many($table, $data) {
        $this->db->insert_batch($table, $data);
        return $this->db->insert_id();
    }


    /* Update data to table 

     * Parameters
     * $table (string) specifies table name
     * $data (array), that needs to be updated
     * $column (string) specifies table column name
     */

    public function update_entry($table, $data, $column, $id) {
        $this->db->where($column, $id);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    /* Update data to table with conditions

     * Parameters
     * $table (string) specifies table name
     * $data (array), that needs to be updated
     * $column (string) specifies table column name
     */

    public function update_list($table, $data, $condition = array()) {

        if (!empty($condition)) {
            $this->db->where($condition);
        }
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    /* Delete record from table - Soft delete

     * Parameters
     * $table (string) specifies table name
     * $column (string) specifies table column name
     */

    public function delete_entry($table, $condition_array) {
        $this->db->where($condition_array);
        $data = array('is_active' => '0');
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    /* Delete record from table - force delete

     * Parameters
     * $table (string) specifies table name
     * $column (string) specifies table column name
     */

    public function force_delete($table, $column, $id) {
        $this->db->where($column, $id);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    /* Check whether an entry exists or not 

     * Parameters
     * $table (string) specifies table name
     * $column_arr (array) specifies table column name
     */

    public function is_exists($table, $column_arr) {
        $this->db->where($column_arr);
        $this->db->where('is_active', '1');
        $q = $this->db->get($table);
        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }

}
