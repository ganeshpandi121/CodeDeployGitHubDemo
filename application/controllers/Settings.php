<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Base_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('General_model');
        $this->load->model("Supplier_model");
    }

    public function index() {
        $this->page_data['page_title'] = 'Settings';
        $this->page_data['msg'] = '';
        $this->page_data['success_cat'] = "0";
        $this->page_data['success_reg'] = "0";
        $user_id = $this->session->userdata('user_id');
        $supplier_det = $this->Base_model->get_one_entry('supplier_details', array('user_id' => $user_id));
        $supplier_id = $supplier_det->sd_id;
        $this->page_data['supplier_id'] = $supplier_id;
        $this->page_data['act'] = "category";
        if ($this->input->post()) {
            if ($this->input->post('sub_category') || $this->input->post('region_name')) {
                if ($this->input->post('hdntype') == "category") {
                    $this->page_data['category_login'] = false;
                    $arrSubcateg = $this->input->post('sub_category');
                    $last_id = $this->Supplier_model->add_supplier_sub_categories($arrSubcateg, $supplier_id, $user_id);
                    $this->page_data['success_cat'] = "1";
                    $this->page_data['msg'] = ($last_id) ? "Categories added successfully!" : "";
                    $this->page_data['act'] = "category";
                    $this->Base_model->update_entry('users', array('is_settings_added' => '1'), 'user_id', $user_id);
                }
                if ($this->input->post('hdntype') == "region") {
                    $this->page_data['region_login'] = false;
                    $arrRegion = $this->input->post('region_name');
                    $last_id = $this->Supplier_model->add_supplier_regions($arrRegion, $supplier_id, $user_id);
                    $this->page_data['success_reg'] = "1";
                    $this->page_data['reg_msg'] = ($last_id) ? "Regions added successfully!" : "";
                    $this->page_data['act'] = "regions";
                }
            } else {
                if ($this->input->post('hdntype') == "category") {
                    $this->page_data['msg'] = "Please select any category!";
                    $this->page_data['act'] = "category";
                }
                if ($this->input->post('hdntype') == "region") {
                    $this->page_data['reg_msg'] = "Please select any region!";
                    $this->page_data['act'] = "regions";
                }
            }
        }
        $this->page_data['categories'] = $this->General_model->get_all_categories_sub_categories();
        $this->page_data['supplier_categories'] = $this->Base_model->get_list('supplier_sub_category', '*', array('sd_id' => $supplier_id));
        $this->page_data['regions'] = $this->General_model->get_all_regions();
        $this->page_data['supplier_regions'] = $this->Base_model->get_list('supplier_regions', '*', array('sd_id' => $supplier_id));

        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('dashboard/settings', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

}
