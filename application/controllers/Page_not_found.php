<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Page_not_found extends CI_Controller {

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
    public function index() {
        $page_data['page_title'] = 'Page Not Found';
        $page_data['meta_description'] = "";
        $page_data['meta_keywords'] = "";
        $this->load->view('templates/top');
        $this->load->view('templates/head', $page_data);
        $this->load->view('templates/header');
        $this->load->view('page_not_found');
        $this->load->view('templates/footer');
        $this->load->view('templates/bottom');
    }

}
