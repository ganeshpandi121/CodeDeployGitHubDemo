<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Base_Controller {

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
        $this->load->model('General_model');
        $this->load->model('Base_model');
        $this->load->model('JobQuote_model');
    }

    /**
     * 
     * @param type $page
     */
    public function index($page = 1) {
        $this->page_data['page_title'] = 'Current Orders';


        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);

        $this->page_data['user_id'] = $user_id = $this->session->userdata('user_id');
        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_term'] = $search_term = $this->input->get('search_term');
        }
        
        if ($this->session->userdata('user_type_id') == 4) {

            $this->load->model('Freight_model');
            $cnt = $this->Freight_model->get_freight_order_count($user_id, $search_term);
            $url = base_url() . "/dashboard/orders-list/";
            $this->page_data['per_page'] = "10";
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['supplier_order_list'] = $this->Freight_model->get_freight_orders($user_id, $search_term, $offset, $this->page_data['per_page']);
        }

        $this->load->view('dashboard/orders_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    
    public function user_current_sales($page = 1){
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
        $this->page_data['page_title'] = 'Current Sales';
        $this->load->model('Supplier_model');
        $cnt = $this->Supplier_model->get_supplier_order_count($user_id, $search_term);
        $url = base_url() . "/dashboard/current-sale/";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['current_sale_list'] = $this->Supplier_model->get_supplier_orders($user_id, $search_term, $offset, $this->page_data['per_page']);
        
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('dashboard/current_sale_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    
    public function user_current_purchases($page = 1){
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
        $this->page_data['page_title'] = 'Current Purchases';
        $this->load->model('Consumer_model');
        $cnt = $this->Consumer_model->get_consumer_order_count($user_id, $search_term);
        $url = base_url() . "/dashboard/current-purchase/";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['current_purchase_list'] = $this->Consumer_model->get_consumer_orders($user_id, $search_term, $offset, $this->page_data['per_page']);
        
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('dashboard/current_purchase_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    /**
     * Method to fetch all information about specified order
     */
    public function view_order() {
        $this->page_data['page_title'] = 'Order';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $redirection_arr = array(
            'Quote Request' => 'dashboard/job',
            'Cancelled' => 'dashboard/order/past-order-view',
            'Completed' => 'dashboard/order/completed-view'
        );
        $id = $this->uri->segment(4) ? $this->uri->segment(4) : '';
        $this->page_data['from_order'] = true;
        $this->page_data['job_id'] = $id;
        $job_info = $this->Job_model->get_job_details($id);
        $this->page_data['job_additional_details'] = $this->Job_model->get_job_additional_details($id);
        $this->page_data['user_type_id'] = $this->session->userdata('user_type_id');
        if (!empty($job_info)) {
            $this->page_data['job_details'] = $job_info['job_data'];
            $this->page_data['job_user_data'] = $job_info['user_data'];
            $user_id = $this->session->userdata('user_id');
            $job_status = $job_info['job_data']->job_status_name;
            $this->page_data['is_job_submmitted'] = $this->Job_model->check_if_user_has_submitted($id, $user_id);
            $this->page_data['is_job_allocated'] = $this->Job_model->check_if_job_allocated($id, $user_id);
            $this->page_data['is_job_quoted_by_user'] = $this->Job_model->check_if_user_quoted($id, $user_id);
            /*if (!empty($job_info['user_data']->country_id)) {
                $this->page_data['buyer_country'] = $this->Base_model->get_one_entry('country', array('country_id' => $job_info['user_data']->country_id));
            } else {
                $this->page_data['buyer_country'] = '---';
            }*/
            
            /*Checking whether same buyer is trying to access the page
            if (($this->page_data['user_type_id'] == 2 &&
                    $this->session->userdata('user_id') != $job_info['user_data']->user_id)) {
                redirect(base_url('page_not_found'));
            }*/

            //Redirect to the correct page based on job status
            foreach ($redirection_arr as $status => $page) {
                if ($job_status == $status) {
                    $page = $page . '/' . $id;
                    redirect($page);
                }
            }
            $this->page_data['job_status'] = $job_status;
            $this->page_data['job_history_log'] = $this->Job_model->get_job_history($id);
            $this->page_data['job_file_types'] = $this->General_model->get_file_type();
            $this->page_data['consumer_job_updates'] = $this->Job_model->get_consumer_job_updates($id);
            $this->page_data['currencies'] = $this->General_model->get_all_currency();
            $this->page_data['incoterms'] = $this->General_model->get_all_incoterms();
            $this->page_data['countries'] = $this->Base_model->get_all('country');
            $user_country_id = !empty($job_info['user_data']->country_id) ? $job_info['user_data']->country_id : '';
            $this->page_data['user_country'] = $this->Base_model->get_one_entry('country', array('country_id' => $user_country_id));


            $this->page_data['approved_quote'] = $this->JobQuote_model->get_approved_quote_of_order($id);

            if (!empty($this->page_data['approved_quote'])) {
                $supplier_id = $this->page_data['approved_quote']->sd_id;
                $this->page_data['approved_supplier_data'] = $this->JobQuote_model->get_approved_supplier_data($supplier_id);
            }

            $this->load->model('JobFreight_model');
            $this->page_data['quote_approved'] = $this->JobFreight_model->check_quote_approved_or_not($id);

            /* krishna address ids */

            $shipping_details = $this->Base_model->get_one_entry('job_shipping_details', array("job_id" => $id));
            if ($shipping_details->to_address_consumer_address == 1) {

                $address_id = $job_info['user_data']->address_id;
                $this->page_data['note_to_address'] = "Shipping to Buyer Address";
            } else {
                $address_id = $shipping_details->to_address_id;
                $this->page_data['note_to_address'] = "Shipping to other Address";
            }
            $this->page_data['shipping_details'] = $shipping_details;
            $this->page_data['get_shipping_to_address'] = $this->General_model->get_full_address($address_id);

            /* krishna address ids */

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('dashboard/orders', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }

    /**
     * Method for add order adress
     */
    public function update_order_address() {
        $this->load->model('Job_model');
        $job_id = $this->input->post('jobid');
        $this->input->post('hdnAdrType');
        $job_ship_data = $this->Base_model->get_one_entry('job_shipping_details', array('job_id' => $job_id));
        $user_id = $this->session->userdata('user_id');
        if ($this->input->post('hdnAdrType') == "old") {
            $from_id = $this->input->post('from_id');
            $to_id = $this->input->post('to_id');
            if ($from_id != "") {
                if (!$job_ship_data) {
                    $addr_ins['job_id'] = $job_id;
                    $addr_ins['from_address_id'] = $from_id;
                    $addr_ins['is_active'] = "1";
                    $this->Base_model->insert_entry('job_shipping_details', $addr_ins);
                } else {
                    $addr_updt['from_address_id'] = $from_id;
                    $addr_updt['is_active'] = "1";
                    $this->Base_model->update_entry('job_shipping_details', $addr_updt, 'job_id', $job_id);
                }
            }
            if ($to_id != "") {
                if (!$job_ship_data) {
                    $addr_ins['job_id'] = $job_id;
                    $addr_ins['to_address_id'] = $to_id;
                    $addr_ins['is_active'] = "1";
                    $this->Base_model->insert_entry('job_shipping_details', $addr_ins);
                } else {
                    $addr_updt['to_address_id'] = $to_id;
                    $addr_updt['is_active'] = "1";
                    $this->Base_model->update_entry('job_shipping_details', $addr_updt, 'job_id', $job_id);
                }
            }
            $updt_history = ($from_id != "") ? "from" : "to";
            $history_desc = 'User Updated shipping ' . $updt_history . ' order Address';

            $this->Job_model->add_job_history($user_id, $job_id, $history_desc);
        } else {
            $user_id = $this->session->userdata('user_id');
            $updt_history = ($this->input->post('userType') == 'supplier') ? "from" : "to";
            $history_desc = 'User Updated shipping ' . $updt_history . ' order Address';

            $this->Job_model->add_job_history($user_id, $job_id, $history_desc);

            //$this->Login_model->add_history_log($user_id, 'job_history', 'User Updated shipping '.$updt_history.' order Address');
            $data['address_name'] = $this->input->post('address_name');
            $data['street_address'] = $this->input->post('street_address');
            $data['city'] = $this->input->post('city');
            $data['state'] = $this->input->post('state');
            $data['country_id'] = $this->input->post('country_id');
            $data['post_code'] = $this->input->post('post_code');
            $telephone_code = !empty($this->input->post('telephone_code')) ? $this->input->post('telephone_code') : NULL;
            // $data['telephone_code'] = $telephone_code;
            //$data['telephone_no'] = $this->input->post('telephone_no');
            $data['fax_no'] = $this->input->post('fax_no');
            $val = $this->Base_model->insert_entry('address', $data);
            if ($val > 0) {
                if ($this->input->post('userType') == "supplier") {
                    if (!$job_ship_data) {
                        $addr_ins['job_id'] = $job_id;
                        $addr_ins['from_address_id'] = $val;
                        $addr_ins['is_active'] = "1";
                        $this->Base_model->insert_entry('job_shipping_details', $addr_ins);
                    } else {
                        $addr_updt['from_address_id'] = $val;
                        $addr_updt['is_active'] = "1";
                        $this->Base_model->update_entry('job_shipping_details', $addr_updt, 'job_id', $job_id);
                    }
                } else {
                    if (!$job_ship_data) {
                        $addr_ins['job_id'] = $job_id;
                        $addr_ins['to_address_id'] = $val;
                        $addr_ins['is_active'] = "1";
                        $this->Base_model->insert_entry('job_shipping_details', $addr_ins);
                    } else {
                        $addr_updt['to_address_id'] = $val;
                        $addr_updt['is_active'] = "1";
                        $this->Base_model->update_entry('job_shipping_details', $addr_updt, 'job_id', $job_id);
                    }
                }
                $this->page_data['msg'] = "Updated Address";
                $this->session->set_flashdata('backend_msg', '<div class="alert alert-success text-center">Address is updated</div>');


                $get_country = $this->Base_model->get_list('country', 'country_name', array('country_id' => $data['country_id']));
                if (!empty($get_country)) {
                    $consumer_country = $get_country[0]->country_name;
                }
                $post = ($data['post_code'] != "") ? "PIN " : "";
                $fax = ($data['fax_no'] != "") ? "Fax: " : "";
                $adrStr = $data['address_name'] . '<br/>' . $data['street_address'] . '<br/>' . $data['city'] . '<br/>' . $data['state'] . '<br/>' . $data['state'] . '<br/>' . $consumer_country . '<br/>' . $post . $data['post_code'] . '<br/>' . $fax . $data['fax_no'];
                $adr = array('adrs' => $adrStr, 'msg' => 'Address successfully updated');
                echo json_encode($adr);
            } else {
                echo '<div class="alert alert-danger text-center">Address not updated</div>';
            }
        }
    }

    /**
     * Method for make a request for freight
     */
    public function request_freight_quote() {
        $job_id = $this->uri->segment(4);

        //randomly adding order to all freight -- will have modifications later
        $this->load->model('Freight_model');
        $last_allocation_insert_id = $this->Freight_model->freight_job_allocation($job_id);
        if (!empty($last_allocation_insert_id)) {
            $this->session->set_flashdata('success_msg', 'Your request for freight has been posted successfully!');
            redirect('dashboard/order/view/' . $job_id);
        } else {
            $this->session->set_flashdata('error_msg', 'Something went wrong!!!');
            redirect('dashboard/order/view/' . $job_id);
        }
    }

    /**
     * Method to approve freight forwarder's quote by user
     */
    public function approve_freight_quote() {
        if (!empty($this->uri->segment(5)) && !empty($this->uri->segment(4))) {
            $quote_id = $this->uri->segment(4);
            $job_id = $this->uri->segment(5);
            $updated = $this->Base_model->update_entry('freight_quote', array('is_approved' => '1'), 'fq_id', $quote_id);
            $this->load->model('JobFreight_model');
            if (!empty($updated)) {
                $this->JobFreight_model->add_job_freight($job_id, $quote_id);
                $this->session->set_flashdata('success_msg', 'This freight quote has been approved successfully!');
                redirect('dashboard/order/view/' . $job_id);
            }
        }
        $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
        redirect('dashboard/order/view/' . $job_id);
    }

    public function complete_job() {
        $job_id = $this->uri->segment(4);
        $job_status = $this->Base_model->get_one_entry('job_status', array('job_status_name' => 'Completed'));
        $completed_time = time();
        $this->Job_model->update_job_status($job_id, $job_status->job_status_id, $completed_time);

        $user_id = $this->session->userdata('user_id');
        $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['completed'];
        $this->Job_model->add_job_history($user_id, $job_id, $history_desc);
        $this->session->set_flashdata('success_msg', 'Order has been moved to completed status successfully!');
        redirect('dashboard/order/completed-view/' . $job_id);
    }

    /**
     * View freight quote on popup
     */
    public function view_freight_quote() {
        $fq_id = $this->input->post('fq_id');
        $this->load->model('JobFreight_model');
        $freight_quote = $this->JobFreight_model->get_freight_quote_info($fq_id);
        if (!empty($freight_quote)) {
            $approve_display = '';
            if ($freight_quote->is_approved == 1) {
                $approve_display = "style=display:none;";
            }
            $pre_approved_sample = !empty($freight_quote->payment_term) ? 'Yes' : 'No';
            echo $strModal = '<div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <img height="40px" width="40px" src="' . base_url() . 'styles/images/default.png"> ' . $freight_quote->freight_name . ' </h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered clearfix">

                    <tr>
                        <th width="50%">Shipment Total Cost (ex. Tax)  </th>
                        <td >' . $freight_quote->shipment_total_cost_ex_tax . ' </td>
                    </tr>
                    <tr>
                        <th>Shipment Total Cost (inc. Tax)</th>
                        <td>' . $freight_quote->shipment_total_cost_inc_tax . '</td>
                    </tr>
                    <tr>
                        <th>Shipping Method</th>
                        <td>' . $freight_quote->shipping_method . '
                        </td>
                    </tr>
                    <tr>
                        <th>Shipment Nett Weight</th>
                        <td>' . $freight_quote->shipment_nett_weight . '</td>
                    </tr>
                    <tr>
                        <th>Shipment Gross Weight</th>
                        <td>' . $freight_quote->shipment_gross_weight . '</td>
                    </tr>
                    <tr>
                        <th>Incoterms</th>
                        <td>' . $freight_quote->incoterm_name . '</td>
                    </tr>
                    <tr>
                        <th>Transit Time</th>
                        <td>' . date('Y-m-d h:i', $freight_quote->transit_time) . '</td>
                    </tr>
                    
                    <tr>
                        <th>Additional Information</th>
                        <td>' . $freight_quote->additional_notes . '</td>
                    </tr>
                </table>
                <div class=" text-center">
                    <a class="btn btn-success" ' . $approve_display . ' href=' . base_url() . 'dashboard/order/approve_freight_quote' . '/' . $freight_quote->fq_id . '/' . $freight_quote->job_id . '> Approve </a>
                            
                </div>
            </div>
        </div>';
        }
    }

    /**
     * 
     * @param type $page
     */
    public function completed_sales($page = 1) {
        $this->page_data['page_title'] = 'Completed Sales';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);

        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_term'] = $search_term = $this->input->get('search_term');
        }
        $this->load->model('Supplier_model');
        $cnt = $this->Supplier_model->get_seller_completed_order_count($this->page_data['user_id'], $search_term);
        $url = base_url() . "/dashboard/completed-sales/";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['completed_sale_list'] = $this->Supplier_model->get_seller_completed_orders($this->page_data['user_id'], $search_term, $offset, $this->page_data['per_page']);

        $this->load->view('dashboard/completed_sale_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    
    public function completed_purchases($page = 1) {
        $this->page_data['page_title'] = 'Completed Purchases';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);

        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_term'] = $search_term = $this->input->get('search_term');
        }
        $this->load->model('Consumer_model');
        $cnt = $this->Consumer_model->get_buyer_completed_order_count($this->page_data['user_id'], $search_term);
        $url = base_url() . "/dashboard/completed-purchases/";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['completed_purchase_list'] = $this->Consumer_model->get_buyer_completed_orders($this->page_data['user_id'], $search_term, $offset, $this->page_data['per_page']);

        $this->load->view('dashboard/completed_purchase_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

    /**
     * Method to fetch all information of specified completed order
     */
    public function completed_view() {
        $this->page_data['page_title'] = 'Order';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        $redirection_arr = array(
            'Quote Request' => 'dashboard/job',
            'Order' => 'dashboard/order/view',
            'Cancelled' => 'dashboard/order/past-order-view'
        );
        $id = $this->uri->segment(4) ? $this->uri->segment(4) : '';
        $job_info = $this->Job_model->get_job_details($id);
        $this->page_data['job_additional_details'] = $this->Job_model->get_job_additional_details($id);

        if (!empty($job_info)) {
            $this->page_data['job_details'] = $job_info['job_data'];
            if (!empty($job_info['user_data']->country_id)) {
                $this->page_data['buyer_country'] = $this->Base_model->get_one_entry('country', array('country_id' => $job_info['user_data']->country_id));
            } else {
                $this->page_data['buyer_country'] = '---';
            }

            $job_status = $job_info['job_data']->job_status_name;
            //Redirect to the correct page based on job status
            foreach ($redirection_arr as $status => $page) {
                if ($job_status == $status) {
                    $page = $page . '/' . $id;
                    redirect($page);
                }
            }
            $this->common_order_view($id);
        } else {
            redirect(base_url('page_not_found'));
        }
    }

    /**
     * Method to fetch all information of specified completed order
     */
    public function past_order_view() {
        $this->page_data['page_title'] = 'Order';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        $redirection_arr = array(
            'Quote Request' => 'dashboard/job',
            'Order' => 'dashboard/order/view',
            'Completed' => 'dashboard/order/completed-view'
        );
        $id = $this->uri->segment(4) ? $this->uri->segment(4) : '';
        $job_info = $this->Job_model->get_job_details($id);
        $this->page_data['job_additional_details'] = $this->Job_model->get_job_additional_details($id);
        if (!empty($job_info)) {
            $this->page_data['job_details'] = $job_info['job_data'];
            if (!empty($job_info['user_data']->country_id)) {
                $this->page_data['buyer_country'] = $this->Base_model->get_one_entry('country', array('country_id' => $job_info['user_data']->country_id));
            } else {
                $this->page_data['buyer_country'] = '---';
            }
            $job_status = $job_info['job_data']->job_status_name;
            //Redirect to the correct page based on job status
            foreach ($redirection_arr as $status => $page) {
                if ($job_status == $status) {
                    $page = $page . '/' . $id;
                    redirect($page);
                }
            }
            $this->common_order_view($id);
        } else {
            redirect(base_url('page_not_found'));
        }
    }

    public function common_order_view($id) {
        $this->page_data['job_id'] = $id;
        $job_info = $this->Job_model->get_job_details($id);
        $this->page_data['job_additional_details'] = $this->Job_model->get_job_additional_details($id);
        if (!empty($job_info)) {
            $this->page_data['job_details'] = $job_info['job_data'];
            $this->page_data['job_user_data'] = $job_info['user_data'];
            $job_status = $job_info['job_data']->job_status_name;
            $this->page_data['job_status'] = $job_status;
            $user_id = $this->session->userdata('user_id');
            $this->page_data['is_job_submmitted'] = $this->Job_model->check_if_user_has_submitted($id, $user_id);
            $this->page_data['is_job_allocated'] = $this->Job_model->check_if_job_allocated($id, $user_id);
            $this->page_data['is_job_quoted_by_user'] = $this->Job_model->check_if_user_quoted($id, $user_id);
            
            $this->page_data['job_history_log'] = $this->Job_model->get_job_history($id);
            $this->page_data['consumer_job_updates'] = $this->Job_model->get_consumer_job_updates($id);
            $user_country_id = $job_info['user_data']->country_id;
            $this->page_data['user_country'] = $this->Base_model->get_one_entry('country', array('country_id' => $user_country_id));
            $this->page_data['approved_quote'] = $this->JobQuote_model->get_approved_quote_of_order($id);
            if (!empty($this->page_data['approved_quote'])) {
                $supplier_id = $this->page_data['approved_quote']->sd_id;
                $this->page_data['approved_supplier_data'] = $this->JobQuote_model->get_approved_supplier_data($supplier_id);
            }

            $shipping_details = $this->Base_model->get_one_entry('job_shipping_details', array("job_id" => $id));
            if ($shipping_details->to_address_consumer_address == 1) {
                $get_consumer = $this->Base_model->get_one_entry('consumer_details', array('cd_id' => $job_info['job_data']->cd_id));
                $this->page_data['note_to_address'] = "Shipping to Buyer Address";
                $address_id = $get_consumer->address_id;
            } else {
                $this->page_data['note_to_address'] = "Shipping to other Address";
                $address_id = $shipping_details->to_address_id;
            }
            $this->page_data['shipping_details'] = $shipping_details;
            $this->page_data['get_shipping_to_address'] = $this->General_model->get_full_address($address_id);

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('dashboard/common/completed_order', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        }
    }

    /**
     * Method to reactivate a cancelled order
     */
    public function re_activate() {
        if ($this->input->post()) {
            $job_id = $this->input->post('job_id');
            $update_data['sla_milestone'] = strtotime($this->input->post('sla_milestone'));
            $update_data['product_lead_time'] = strtotime($this->input->post('product_lead_time'));
            $activated = $this->Job_model->re_activate_order($job_id, $update_data);
            if ($activated) {
                $this->session->set_flashdata('success_msg', 'Project has been re-activated successfully!');
                redirect('dashboard/job/' . $job_id);
            }
        }
        $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
        redirect('dashboard/order/past-order-view/' . $job_id);
    }

    /**
     * Method to reorder an order
     */
    public function re_order() {
        if ($this->input->post()) {
            $job_id = $this->input->post('job_id');
            $update_data['sla_milestone'] = strtotime($this->input->post('sla_milestone'));
            $update_data['product_lead_time'] = strtotime($this->input->post('product_lead_time'));
            $reordered_job = $this->Job_model->re_order($job_id, $update_data);
            if (!empty($reordered_job)) {
                $this->session->set_flashdata('success_msg', 'Project has been re-ordered successfully!');
                redirect('dashboard/my-bids');
            }
        }
        $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
        redirect('dashboard/order/completed-view/' . $job_id);
    }

}
