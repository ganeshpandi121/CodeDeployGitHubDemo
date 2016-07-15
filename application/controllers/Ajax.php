<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends Base_Controller {

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
        $this->load->model('Job_model');
    }

    public function index() {
        
    }

    /**
     * 
     * @return boolean
     */
    function get_sub_categories() {
        if ($this->input->post('isAjax') == true) {
            $catid = $this->input->post('categoryID');
            $this->load->model('General_model');
            $sub_categories = $this->General_model->get_sub_categories_by_catid($catid);
            echo json_encode($sub_categories);
        }
        return false;
    }

}
