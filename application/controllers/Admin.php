<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Base_Controller {

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
        $this->load->model('Admin_model');
        $this->load->model('General_model');
        $this->load->model('Base_model');
        $this->load->model('Login_model');
    }

    public function index() {
        
    }

    /**
     * List out all users in the system
     */
    public function buyers($page = 1) {

        $this->page_data['page_title'] = 'Users';
        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_term'] = $search_term = $this->input->get('search_term');
        }
        if ($this->session->userdata('user_type_id') == 1) {

            $this->page_data['buyers_count'] = $count = $this->Admin_model->get_all_buyer_count($search_term);
            $url = base_url() . "/admin/buyers/";
            $this->page_data['per_page'] = "10";
            $this->Pagination_model->init_pagination($url, $count, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $count;
            $this->page_data["buyer_pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['buyers_list'] = $this->Admin_model->get_all_buyers($search_term,$offset, $this->page_data['per_page']);

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('admin/buyers', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }

    /**
     * List out all sellers in the system
     */
    public function sellers($page = 1) {
        $this->page_data['page_title'] = 'Sellers';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_term'] = $search_term = $this->input->get('search_term');
        }
        if ($this->session->userdata('user_type_id') == 1) {

            $url = base_url() . "/admin/sellers/";
            $this->page_data['per_page'] = "10";
            $this->page_data['sellers_count'] = $count = $this->Admin_model->get_all_seller_count($search_term);
            $this->Pagination_model->init_pagination($url, $count, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $count;
            $this->page_data["seller_pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['sellers_list'] = $this->Admin_model->get_all_sellers($search_term, $offset, $this->page_data['per_page']);

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('admin/sellers', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }

    /**
     * 
     * @param type $user_id
     * 
     */
    public function view_user($user_id) {

        $this->page_data['page_title'] = 'View User';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        if ($this->session->userdata('user_type_id') == 1) {
            $this->load->model('User_model');
            $user_type_id = $this->User_model->get_usertype_from_user_id($user_id);
            $this->page_data['is_transformed'] = $this->User_model->check_if_user_transformed($user_id);
            $this->page_data['user_details'] = $this->Admin_model->get_user_info($user_id, $user_type_id, $this->page_data['is_transformed']);

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('admin/view_user', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }

    /**
     * 
     * @param type $user_id
     */
    public function deactivate_user($user_id) {
        if (!empty($this->uri->segment(3)) && !empty($this->uri->segment(4))) {
            $user_id = $this->uri->segment(3);
            $user_type = $this->uri->segment(4);
            $updated = $this->Base_model->update_entry('users', array('is_active' => '0'), 'user_id', $user_id);
            $redirect_to = str_replace(base_url(), '', $_SERVER['HTTP_REFERER']);
            $page = ($user_type == 2) ? 'buyers' : 'sellers';
            $url = base_url() . $redirect_to;
            if (!empty($updated)) {
                $this->Login_model->add_history_log($user_id, 'Account Deactivation', 'Account has been deactivated');
                $this->session->set_flashdata('success_msg', 'User has been deactivated successfully!');
                redirect($url);
            }
        }
        $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
        redirect($url);
    }

    /**
     * 
     * @param type $user_id
     */
    public function activate_user($user_id) {
        if (!empty($this->uri->segment(3)) && !empty($this->uri->segment(4))) {
            $user_id = $this->uri->segment(3);
            $user_type = $this->uri->segment(4);
            $updated = $this->Base_model->update_entry('users', array('is_active' => '1'), 'user_id', $user_id);
            $redirect_to = str_replace(base_url(), '', $_SERVER['HTTP_REFERER']);
            $page = ($user_type == 2) ? 'buyers' : 'sellers';
            $url = base_url() . $redirect_to;
            if (!empty($updated)) {
                $this->Login_model->add_history_log($user_id, 'Account Activation', 'Account has been activated');
                $this->session->set_flashdata('success_msg', 'User has been activated successfully!');
                redirect($url);
            }
        }
        $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
        redirect($url);
    }

    /**
     * 
     * @param type $user_id
     */
    public function change_seller_type() {
        $user_id = $this->uri->segment(3);
        $url = base_url('admin/view_user') . '/' . $user_id;
        if (!empty($user_id) && $this->uri->segment(4) != '') {
            $is_vetted = $this->uri->segment(4);
            $updated = $this->Base_model->update_entry('supplier_details', array('is_vetted' => $is_vetted), 'user_id', $user_id);
            $seller_type = ($is_vetted == 0) ? "Demo" : "Live";
            if (!empty($updated)) {
                $this->Login_model->add_history_log($user_id,
                        'Seller Account Type Changed',
                        'Seller account type has been changed to '.$seller_type);
                $this->session->set_flashdata('success_msg', 'Seller mode has been changed successfully!');
                redirect($url);
            }
        }
        $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
        redirect($url);
    }
    
    public function project_list($page = 1) {
        $this->page_data['page_num'] = $page;

        $this->load->model("Pagination_model");

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        $this->page_data['user_id'] = $user_id = $this->session->userdata('user_id');
        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_term'] = $search_term = $this->input->get('search_term');
        }
        $this->page_data['page_title'] = 'Job Quotes';
        $this->load->model('Admin_model');
        $cnt = $this->Admin_model->get_all_quote_count($search_term);
        $url = base_url() . "/admin/projects/";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['admin_dashboard_list'] = $this->Admin_model->get_all_quotes($search_term, $offset, $this->page_data['per_page']);
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/admin_project_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    /**
     * 
     * @param type $page
     */
    public function orders($page = 1) {
        $this->page_data['page_title'] = 'Current Orders';


        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_term'] = $search_term = $this->input->get('search_term');
        }

        if ($this->session->userdata('user_type_id') == 1) {
            $this->load->model('Admin_model');

            $cnt = $this->Admin_model->get_all_order_count($search_term);
            $url = base_url() . "/admin/orders/";
            $this->page_data['per_page'] = "10";
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['order_list'] = $this->Admin_model->get_all_orders($search_term, $offset, $this->page_data['per_page']);

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('admin/admin_order_list', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }

    /*
     * List out all canceled jobs in the system
     */

    public function past_orders($page = 1) {

        $this->page_data['page_title'] = 'Past Orders';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_term'] = $search_term = $this->input->get('search_term');
        }
        if ($this->session->userdata('user_type_id') == 1) {
            $this->load->model('Admin_model');

            $cnt = $this->Admin_model->get_passed_order_count($search_term);
            $url = base_url() . "/admin/past_orders/";
            $this->page_data['per_page'] = "10";
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['all_passed_orders'] = $this->Admin_model->get_passed_orders($search_term, $offset, $this->page_data['per_page']);

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('dashboard/common/canceled_order_list', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }

    /**
     * Method to allow super admin to login as other user.
     */
    public function login_as_user() {
        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        if ($this->session->userdata('user_type_id') == 1) {
            $this->load->model('Login_model');
            $normal_user_id = $this->uri->segment(3);
            $admin_user_id = $this->session->userdata('user_id');
            $this->Login_model->unset_user_session($admin_user_id);
            redirect('admin/set_user_session/' . $normal_user_id . '/' . $admin_user_id);
        }
    }

    /**
     * Method to set new user session when super admin trying to login as other user
     * @param type $login_as_user_id
     * @param type $super_admin_id
     */
    public function set_user_session($login_as_user_id, $super_admin_id = '') {
        $this->load->model('Login_model');
        $super_admin_id = ($super_admin_id != '') ? $super_admin_id : '';
        $this->Login_model->set_user_session($login_as_user_id, $super_admin_id);
        $user_type = $this->User_model->get_usertype_from_user_id($login_as_user_id);
        if($user_type == 1){
           $dashboard_url = "admin/projects";
        }else if($user_type == 2){
            $dashboard_url = "dashboard/my-projects";
        }else if($user_type == 3){
            $dashboard_url = "dashboard/my-bids";
        }
        redirect(base_url().$dashboard_url);
    }
    
    public function completed_orders($page = 1) {
         $this->page_data['page_title'] = 'Completed Orders';


        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        
        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_term'] = $search_term = $this->input->get('search_term');
        }
        
        $cnt = $this->Admin_model->get_all_completed_order_count($search_term);
        $url = base_url() . "/admin/completed_orders/";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['completed_order_list'] = $this->Admin_model->get_all_completed_orders($search_term, $offset, $this->page_data['per_page']);
            
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/completed_order_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');

    }
    /**
     * Method to allow super admin to login as other user.
     */
    public function login_as_admin() {
        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        if ($this->session->userdata('super_admin_id')) {
            $this->load->model('Login_model');
            $admin_user_id = $this->session->userdata('super_admin_id');
            $normal_user_id = $this->session->userdata('user_id');
            $this->Login_model->unset_user_session($normal_user_id);
            redirect('admin/set_user_session/' . $admin_user_id);
        }
    }
    
    /**
     * Method for add find a supplier
     */
    public function find_supplier($id = ""){
        $this->page_data['page_title'] = 'Find Supplier';
        $this->page_data['action'] = "Add"; 
        $this->page_data['success_msg'] = "";
        $this->load->model('General_model');
        $this->page_data['telephone_codes'] = $this->Base_model->get_all('country');
        $this->page_data['categories'] = $this->General_model->get_all_categories_sub_categories();
        $this->page_data['regions'] = $this->General_model->get_all_regions();
        if($this->input->post()){
            $this->load->library('form_validation');
            //set validation rules
            $this->form_validation->set_rules('company_name', 'Company Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('telephone_code_1', 'Phone Code', 'required');
            $this->form_validation->set_rules('telephone_no', 'Phone Number', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', validation_errors());
                //redirect('dashboard/job/' . $job_id);
            } else {
                if (isset($_FILES['logo_image']) && !empty($_FILES['logo_image']['tmp_name'])) {
                        $config['allowed_types'] = 'jpg|png|jpeg|gif|pdf|doc|docx';
                        $upload_return = $this->General_model->do_upload('logo_image', $_FILES['logo_image'], 'company', $config);

                        if (!empty($upload_return['error'])) {
                            $this->session->set_flashdata('error_msg', $upload_return['error']);
                            redirect('admin/find_supplier');
                        } else {
                            $data['company_logo'] = $upload_return['data']['file_name'];
                        }
                }
                $data['company_name'] = $this->input->post('company_name');
                $data['email'] = $this->input->post('email');
                $data['telephone_code'] = $this->input->post('telephone_code');
                $data['telephone_number'] = $this->input->post('telephone_no');
                $data['country'] = $this->input->post('country_id');
                $data['description'] = $this->input->post('description');
                $data['is_active'] = '1';
                if($this->input->post('hdn_find_supplier_id')){
                    $find_supplier_id = $this->input->post('hdn_find_supplier_id');
                    $this->Base_model->update_entry('find_supplier_details',$data,'find_supplier_id',$find_supplier_id);
                    $msg = "updated"; 
                    $this->page_data['action'] = "Update"; 
                }else{
                    $find_supplier_id = $this->Base_model->insert_entry('find_supplier_details',$data);
                    $msg = "added";
                }
                if($find_supplier_id){
                    $this->load->model('Supplier_model');
                    $user_id = $this->input->post('user_id');;
                    $sub_categories = $this->input->post('sub_category');
                    $regions = $this->input->post('region_name');
                    $cat = $this->Supplier_model->add_find_supplier_sub_categories($sub_categories,$find_supplier_id,$user_id);
                    $reg = $this->Supplier_model->add_find_supplier_regions($regions,$find_supplier_id,$user_id);
                    $this->page_data['success_msg'] = '<div class="alert alert-success" id="supplier_alert">Supplier '.$msg.' successfully!</div>';
                }
            }
            
        }
        if($id){
           $this->page_data['action'] = "Update"; 
           $this->page_data['find_supplier'] = $this->Base_model->get_one_entry('find_supplier_details',array('find_supplier_id'=>$id)); 
           $this->page_data['find_supplier_categories'] = $this->Base_model->get_list('find_supplier_sub_category','*',array('find_supplier_id'=>$id)); 
           $this->page_data['find_supplier_regions'] = $this->Base_model->get_list('find_supplier_region','*',array('find_supplier_id'=>$id)); 
           //$this->page_data['count_find_supplier_categories'] = $this->Base_model->get_list('find_supplier_sub_category','count(*) as cnt',array('find_supplier_id'=>$id)); 
           $this->page_data['count_find_supplier_categories'] = $this->Admin_model->sub_category_count($id);
        }
        $find_supp = ($this->input->post('hdn_find_supplier_id'))? $this->input->post('hdn_find_supplier_id'): "";
        if($find_supp){
            $this->session->set_flashdata('succes_message', $this->page_data['success_msg']);
            redirect("admin/find-supplier/".$find_supp,$this->page_data);  
        }
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/find_supplier', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    
    public function delete_find_supplier($id){
        $this->Base_model->delete_entry('find_supplier_details', array('find_supplier_id' => $id));
        redirect('admin/list-find-supplier');
    }

    public function find_supplier_requests($page = 1) {

        $this->page_data['page_title'] = 'Find Supplier Requests';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        
        if ($this->session->userdata('user_type_id') == 1) {
            $this->load->model('Admin_model');

            $cnt = $this->Admin_model->get_supplier_request_count();
            $url = base_url() . "/admin/find_supplier_requests/";
            $this->page_data['per_page'] = "15";
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['supplier_request_list'] = $this->Admin_model->get_supplier_requests($offset, $this->page_data['per_page']);

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('admin/supplier_request_list', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }
    
    //added by Tousif
    public function find_lead_count($page = 1) {

        $this->page_data['page_title'] = 'Find Lead Count';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        
        if ($this->session->userdata('user_type_id') == 1) {
            $this->load->model('Admin_model');

            $cnt = $this->Admin_model->get_lead_overall_count();
            $url = base_url() . "/admin/find_lead_count/";
            $this->page_data['per_page'] = "15";
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['lead_count_list'] = $this->Admin_model->get_leads_count($offset, $this->page_data['per_page']);

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('admin/lead_count_list', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }
    
    public function find_lead_count_outside($page = 1) {

        $this->page_data['page_title'] = 'Find Lead Count Outside';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        
        if ($this->session->userdata('user_type_id') == 1) {
            $this->load->model('Admin_model');

            $cnt = $this->Admin_model->get_lead_overall_count_outside();
            $url = base_url() . "/admin/find_lead_count_outside/";
            $this->page_data['per_page'] = "15";
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['lead_count_list'] = $this->Admin_model->get_leads_count_outside($offset, $this->page_data['per_page']);
            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('admin/lead_count_outside_list', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }
    //added by Tousif
    public function find_supplier_job_count($page = 1) {

        $this->page_data['page_title'] = 'Supplier Job Count';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        
        if ($this->session->userdata('user_type_id') == 1) {
            $this->load->model('Admin_model');

            $cnt = $this->Admin_model->get_overall_supplier_job_count();
            $url = base_url() . "/admin/find_supplier_job_count/";
            $this->page_data['per_page'] = "15";
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['supplier_job_count_list'] = $this->Admin_model->get_supplier_job_count($offset, $this->page_data['per_page']);

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('admin/supplier_job_count_list', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }
    
     /*
     * Method for listing find a supplier
     */
    public function list_find_supplier($page=1){
        $this->page_data['page_title'] = 'List Supplier'; 
        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $url = base_url() . "/admin/list-find-supplier/";
        $this->page_data['per_page'] = "10";
        $cnt = $this->Admin_model->get_all_find_supplier_count();
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['supplier_list'] = $this->Admin_model->get_all_find_supplier($offset, $this->page_data['per_page']);
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/list_find_supplier', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom'); 
    }
     public function add_category($id = "") {
        $this->load->library('form_validation');
        
        $this->page_data['page_title'] = "Product Category";
        $this->page_data['action'] = "Add";
        $this->page_data['cat_id'] = $id;
        if ($this->input->post()) {
            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', validation_errors());
            } else {
                $data['category_name'] = $this->input->post('category_name');
                $data['is_active'] = 1;
                if (!$this->input->post('product_category_id')) {
                    $cat_id = $this->Base_model->insert_entry('categories', $data);
                    $msg = "added";
                } else {
                    $cat_id = $this->input->post('product_category_id');
                    $this->Base_model->update_entry('categories', $data, 'cat_id', $cat_id);
                    $msg = "updated";
                }
                if ($cat_id) {
                    $this->page_data['success_msg'] = '<div class="alert alert-success text-center">Product category '.$msg.' successfully!</div>';
                }
            }
        }
        $this->page_data['category_name'] = "";
        if ($id) {
            $this->page_data['action'] = "Edit";
            $product_category = $this->Base_model->get_one_entry("categories", array('cat_id' => $id));
            if ($product_category) {
                $this->page_data['category_name'] = $product_category->category_name;
            }
        }
        $product_cat = ($this->input->post('product_category_id'))? $this->input->post('product_category_id'): "";
        if($product_cat){
            $this->session->set_flashdata('succes_message', $this->page_data['success_msg']);
            redirect("admin/product_category/".$product_cat,$this->page_data);  
        }
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/product_category', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    public function product_category_list($page=1) {
        $this->page_data['page_title'] = 'Product Category'; 
        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $url = base_url() . "/Admin/product_category_list/";
        $this->page_data['per_page'] = "10";
        $cnt = $this->Admin_model->get_all_productcategory_count();
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['product_categories'] = $this->Admin_model->get_all_product_category($offset, $this->page_data['per_page']);
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/product_category_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    public function product_category_delete($id) {
       $this->session->set_flashdata('message', 'Category Sucessfully Deleted.');
        $this->Base_model->delete_entry('categories', array('cat_id' => $id));
        redirect('admin/view-product-category');
    }
    public function product_subcategory_list($page=1){
        $this->page_data['page_title'] = "Product Subcategory";
        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $url = base_url() . "/Admin/product_subcategory_list/";
        $this->page_data['per_page'] = "10";
        $cnt = $this->Admin_model->get_all_productsubcategory_count();
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['product_subcategories'] = $this->Admin_model->get_all_product_subcategory($offset, $this->page_data['per_page']);
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/product_subcategory_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    public function product_subcategory_delete($id) {
        $this->session->set_flashdata('message', 'SubCategory Sucessfully Deleted.');
        $this->Base_model->delete_entry('sub_categories', array('sub_cat_id' => $id));
        redirect('admin/view-product-subcategory');
    }
    public function add_subcategory($id = "") {
        $this->load->library('form_validation');
        
        $this->page_data['page_title'] = "Product Subcategory";
        $this->page_data['action'] = "Add";
        $this->page_data['subcat_id'] = $id;
        $msg = '';
        if ($this->input->post()) {
            $this->form_validation->set_rules('subcategory_name', 'Subcategory Name', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', validation_errors());
            } else {
                $data['sub_category_name'] = $this->input->post('subcategory_name');
                $data['cat_id'] = $this->input->post('product_category_id');
                $data['is_active'] = 1;
                if (empty($id)) {
                    $subcat_id = $this->Base_model->insert_entry('sub_categories', $data);
                    $msg = "added";
                } else {
                    $this->Base_model->update_entry('sub_categories', $data, 'sub_cat_id', $id);
                    $msg = "updated";
                }
                 $this->session->set_flashdata('success_message', 'Subcategory has been '.$msg.' successfully!');
                 redirect(base_url('admin/product_subcategory').'/'.$id);
            }
        }
        $this->page_data['subcategory_name'] = "";
        $this->page_data['categories'] = $this->Base_model->get_all("categories");
        if ($id) {
            $this->page_data['action'] = "Edit";
            $product_subcategory = $this->Base_model->get_one_entry("sub_categories", array('sub_cat_id' => $id));
            if ($product_subcategory) {
                $this->page_data['product_category_id'] = $product_subcategory->cat_id;
                $this->page_data['subcategory_name'] = $product_subcategory->sub_category_name;
            }
        }
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/product_subcategory', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
}
    

