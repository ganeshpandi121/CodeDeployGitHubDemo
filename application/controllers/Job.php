<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends Base_Controller {

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
        $this->config->load('smartcardmarket', true);
    }

    public function index() {
        $this->page_data['page_title'] = 'Quote';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        $redirection_arr = array(
            //'Quote Request' => 'dashboard/job',
            'Order' => 'dashboard/order/view',
            'Cancelled' => 'dashboard/order/past-order-view',
            'Completed' => 'dashboard/order/completed-view'
        );
        $id = $this->uri->segment(3);
        $this->page_data['job_id'] = $id;
        $job_info = $this->Job_model->get_job_details($id);
        $this->page_data['job_additional_details'] = $this->Job_model->get_job_additional_details($id);

        if (!empty($job_info)) {
            $this->page_data['job_details'] = $job_info['job_data'];
            $this->page_data['job_user_data'] = $job_info['user_data'];
            $job_status = $this->page_data['job_details']->job_status_name;
            $user_id = $this->session->userdata('user_id');
            
            $this->page_data['is_job_submmitted'] = $this->Job_model->check_if_user_has_submitted($id, $user_id);
            $this->page_data['is_job_allocated'] = $this->Job_model->check_if_job_allocated($id, $user_id);
            /*Checking whether same buyer is trying to access the page
            if (($this->session->userdata('user_type_id') == 2 &&
                    $user_id != $job_info['user_data']->user_id)) {
                redirect(base_url('page_not_found'));
            }*/

            //Redirect to the correct page based on job status
            foreach ($redirection_arr as $status => $page) {
                if ($job_status == $status) {
                    $page = $page . '/' . $id;
                    redirect($page);
                }
            }
            $super_admin = ($this->session->userdata('user_type_id') == 1) ? $user_id : '';
            $this->page_data['job_status'] = $job_status;
            $this->page_data['job_history_log'] = $this->Job_model->get_job_history($id, $super_admin);
            $this->page_data['job_file_types'] = $this->General_model->get_file_type();
            $this->page_data['consumer_job_updates'] = $this->Job_model->get_consumer_job_updates($id);

            //List out all quotes from suppliers
            $this->page_data['job_quotes'] = $this->JobQuote_model->get_supplier_quote_by_job($id);
            $this->page_data['countries'] = $this->Base_model->get_all('country');
            $user_country_id = !empty($job_info['user_data']->country_id) ? $job_info['user_data']->country_id : '';
            $this->page_data['user_country'] = $this->Base_model->get_one_entry('country', array('country_id' => $user_country_id));

            if (!empty($this->page_data['is_job_submmitted'])) {
                //check if any quote approved by consumer
                $this->page_data['approved_quote'] = $this->JobQuote_model->get_approved_quote_of_order($id);
            }
            if (!empty($this->page_data['is_job_allocated'])) {
                $this->page_data['currencies'] = $this->General_model->get_all_currency();
                $this->page_data['incoterms'] = $this->General_model->get_all_incoterms();
                $this->page_data['shipping_methods'] = $this->General_model->get_shipping_method();

                $suppliers_quote = $this->page_data['job_quotes'];
                foreach ($suppliers_quote as $supplier) {
                    if ($supplier->user_id == $this->session->userdata('user_id')) {
                        $this->page_data['supplier_quote_for_job'] = $this->Job_model->get_supplier_quote_list($supplier->jq_id);
                    }
                }
                //Checking if the seller has quoted or not for this job
                $this->page_data['seller_quoted_job'] = $this->JobQuote_model->check_seller_has_quote_for_job($id, $user_id);
            }
            /* krishna address ids */

            $shipping_details = $this->Base_model->get_one_entry('job_shipping_details', array("job_id" => $id));

            if ($shipping_details->to_address_consumer_address == 1) {
                $address_id = !empty($job_info['user_data']->address_id) ? $job_info['user_data']->address_id:'';
                $this->page_data['note_to_address'] = "Buyer Shipping Address";
            } else {
                $this->page_data['note_to_address'] = "Ship to other Address";
                $address_id = $shipping_details->to_address_id;
            }

            $this->page_data['shipping_details'] = $shipping_details;
            $this->page_data['get_shipping_to_address'] = $this->General_model->get_full_address($address_id);

            /* krishna address ids */

            /* Edit job details */
            $this->page_data['categories'] = $this->General_model->get_all_categories();
            $this->page_data['sub_categories'] = $this->General_model->get_sub_categories_by_catid($this->page_data['job_details']->cat_id);
            /* End */

            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('dashboard/job', $this->page_data);
            $this->load->view('templates/footer_dashboard');
            $this->load->view('templates/bottom');
        } else {
            redirect(base_url('page_not_found'));
        }
    }

    public function edit_job() {
        $this->load->model('Email_model');
        $this->page_data['categories'] = $this->General_model->get_all_categories();
        $job_id = $this->input->post('job_id');
        if ($this->input->post()) {

            $this->load->library('form_validation');
            //set validation rules
            $this->form_validation->set_rules('job_name', 'Project Name', 'required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', validation_errors());
                redirect('dashboard/job/' . $job_id);
            } else {

                $user_id = $this->session->userdata('user_id');
                $data['job_name'] = $this->input->post('job_name');

                $data['job_overview'] = $this->input->post('job_overview');
                $data['product_quantity'] = $this->input->post('product_quantity');

                $product_lead_time = $this->input->post('product_lead_time');
                $data['description'] = $this->input->post('description');
                $data['special_requirement'] = $this->input->post('special_requirement');
                $data['expected_amount'] = $this->input->post('expected_amount');
                
                $data['is_sealed'] = $this->input->post('is_sealed');
                $data['is_sample_required'] = $this->input->post('is_sample_required');
                $sla_milestone = $this->input->post('sla_milestone');
                $data['is_urgent'] = $this->input->post('is_urgent');
                $data['created_time'] = time();
                $data['is_active'] = '1';
                $data['product_lead_time'] = strtotime($product_lead_time);
                $data['sla_milestone'] = strtotime($sla_milestone);

                $job_status = $this->Base_model->get_one_entry('job_status', array('job_status_name' => 'Quote Request'));
                $data['job_status_id'] = $job_status->job_status_id;
                $data['cd_id'] = $this->input->post('consumer_id');

                //Adding category job mapping to the table
                $cat_data['sub_cat_id'] = $this->input->post('sub-category');
                $cat_data['job_id'] = $job_id;
                $cat_data['is_active'] = '1';
                $job_sub_cat_id = $this->Base_model->update_entry('job_sub_category', $cat_data, 'job_id', $job_id);

                $this->Base_model->update_entry('job_details', $data, 'job_id', $job_id);
                redirect('dashboard/job/' . $job_id);
            }
        }
    }

    public function submit_job_update() {
        $this->page_data['page_title'] = 'Job Updates';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }

        if (($this->input->post())) {
            $data = array();
            $file_data = array();
            $job_id = $this->input->post('job_id');
            $job_data = $this->Base_model->get_one_entry('job_details', array('job_id' => $job_id));
            $from_order = !empty($this->input->post('from_order')) ? $this->input->post('from_order') : '';
            if (!empty($from_order)) {
                $redirect_url = 'dashboard/order/view/' . $job_id;
            } else {
                $redirect_url = 'dashboard/job/' . $job_id;
            }

            $this->load->library('form_validation');
            //set validation rules
            $this->form_validation->set_rules('job_update', 'Type', 'trim|required');

            //validate form input
            $user_id = $this->session->userdata('user_id');
            $user_name = $this->session->userdata('user_name');

            if ($this->form_validation->run() == TRUE) {
                $data['description'] = $this->input->post('job_update');
                //$data['job_status_id'] = $this->input->post('job_status_name');
                $data['job_id'] = $job_id;
                $data['user_id'] = $user_id;
                $data['is_active'] = '1';
                $job_log_id = $this->Base_model->insert_entry('job_log', $data);
                $history_desc = "Job update has been added by " . $user_name . "\n Details: " . $data['description'] . ".";
                if (isset($_FILES['job_update_file']) && !empty($_FILES['job_update_file']['tmp_name'])) {
                    $config['allowed_types'] = 'jpg|png|jpeg|gif|pdf|doc|docx';
                    $upload_return = $this->General_model->do_upload('job_update_file', $_FILES['job_update_file'], 'documents', $config);

                    if (!empty($upload_return['error'])) {
                        $this->session->set_flashdata('update_error_msg', $upload_return['error']);
                        redirect($redirect_url);
                    } else {
                        $history_desc .= "\n One File has been uploaded to the job.";
                        $file_data['file_type_id'] = $file_type_id = $this->input->post('file_type_id');
                        $file_data['job_id'] = $job_id;
                        $file_data['file_name'] = $upload_return['data']['file_name'];
                        $file_data['user_id'] = $user_id;
                        $file_data['created_time'] = time();
                        $file_data['is_active'] = '1';
                        $file_data['job_file_id'] = $this->Base_model->insert_entry('job_file', $file_data);
                        if (!empty($from_order)) {
                            if ($this->session->userdata('user_type_id') == 3) {
                                $this->Job_model->check_uploaded_file_type($job_id, $file_type_id);
                            }
                        }

                        $this->Base_model->update_entry('job_log', array('job_file_id' => $file_data['job_file_id']), 'job_log_id', $job_log_id);
                    }
                }

                $this->Job_model->add_job_history($user_id, $job_id, $history_desc);

                //Send notifications to all associated users
                $this->Job_model->send_job_update_notification($user_id, $job_id);
                $this->load->model('Email_model');
                $this->Email_model->job_update_notify($job_id, $user_id, $data['description'], $file_data);
                if (!empty($job_log_id)) {
                    $this->session->set_flashdata('success_msg', 'Your update has been submitted successfully');
                    redirect($redirect_url);
                }
            } else {
                $this->session->set_flashdata('update_error_msg', 'Something went wrong!!!');
                redirect($redirect_url);
            }
        }
    }

    public function view_supplier_quote() {
        $id = $this->input->post('jq_id');
        $job_id = $this->input->post('job_id');
        $supplier_quotes = $this->Job_model->get_supplier_quote_list($id);
        if (!empty($supplier_quotes)) {
            $approve_display = '';
            if ($supplier_quotes[0]->is_approved == 1) {
                $approve_display = "style=display:none;";
            }
            $pre_approved_sample = !empty($supplier_quotes[0]->pre_approved_sample) ? 'Yes' : 'No';
            $sample_lead_time = !empty($supplier_quotes[0]->sample_lead_time) ? date('Y-m-d', $supplier_quotes[0]->sample_lead_time) : '';
            //$freight_quote_cost = !empty($supplier_quotes[0]->freight_quote_cost) ? $supplier_quotes[0]->freight_quote_cost : '';
            $strModal = '<div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <img height="40px" width="40px" src="' . base_url() . 'styles/images/default.png"> ' . $supplier_quotes[0]->supplier_name . ' </h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered clearfix">

                    <tr>
                        <th width="50%">Unit Volume  </th>
                        <td >' . $supplier_quotes[0]->unit_volume . ' </td>
                    </tr>
                    <tr>
                        <th>Price Per Unit</th>
                        <td>$' . $supplier_quotes[0]->price_per_unit . '</td>
                    </tr>
                    <tr>
                        <th>Total Order (ex Tax)</th>
                        <td>$' . $supplier_quotes[0]->total_order . '
                        </td>
                    </tr>
                    <tr>
                        <th>Currency</th>
                        <td>' . $supplier_quotes[0]->currency_name . '</td>
                    </tr>
                    <tr>
                        <th>Payment Terms</th>
                        <td>' . $supplier_quotes[0]->payment_term . '</td>
                    </tr>
                    <tr>
                        <th>Incoterms</th>
                        <td>' . $supplier_quotes[0]->incoterm_name . '</td>
                    </tr>
                    <tr>
                        <th>Project Lead Time</th>
                        <td>' . date('Y-m-d', $supplier_quotes[0]->lead_time) . '</td>
                    </tr>';
            if (!empty($supplier_quotes[0]->pre_approved_sample)) {
                $strModal .= '
                    <tr>
                        <th>Pre-Approved

                            Samples</th>
                            
                        <td>' . $pre_approved_sample . '</td>
                    </tr>
                    <tr>
                        <th>Samples Lead Time</th>
                        <td>' . $sample_lead_time . '</td>
                    </tr>';
            }

            $strModal .= '<tr>
                        <th>Additional Information</th>
                        <td>' . $supplier_quotes[0]->additional_information . '</td>
                    </tr>
                    
                   <!--<tr>
                    <td colspan="2">
                    
                    <a class="btn btn-success " ' . $approve_display . ' href=' . base_url() . 'dashboard/job/approve_quote' . '/' . $supplier_quotes[0]->jq_id . '/' . $supplier_quotes[0]->job_id . '> Approve </a>
                            
                
                </td>
                    </tr> -->

                </table>
            
            </div>

        </div>';
            echo $strModal;
        }
    }

    /**
     * 
     * @param type $id
     * @return boolean
     */
    public function download_job_file($id) {

        $file_name = $this->Base_model->get_one_entry('job_file', array('job_file_id' => $id))->file_name;
        $this->General_model->do_download($file_name, 'documents');
        return true;
    }

    public function submit_supplier_quote() {

        if (($this->input->post())) {
            $flag = false;
            $data = array();
            $job_id = $this->input->post('job_id');
            $this->load->library('form_validation');
            //set validation rules
            $this->form_validation->set_rules('unit_volume', 'Unit Volume', 'trim|required');
            $this->form_validation->set_rules('price_per_unit', 'Price per unit', 'trim|required');
            $this->form_validation->set_rules('total_order', 'Total order', 'trim|required');
            $this->form_validation->set_rules('currency', 'Currency', 'trim|required');
            $this->form_validation->set_rules('payment_term', 'Payment_term', 'trim|required');
            $this->form_validation->set_rules('incoterm_id', 'Incoterm', 'trim|required');
            $this->form_validation->set_rules('lead_time', 'Lead time', 'trim|required');
            //$this->form_validation->set_rules('pre_approved_sample', 'Preapproved sample', 'trim|required');
            //$this->form_validation->set_rules('sample_lead_time', 'Sample lead time', 'trim|required');
            // $this->form_validation->set_rules('additional_information', 'Additional information', 'trim|required');
            //validate form input
            $user_id = $this->session->userdata('user_id');
            if ($this->form_validation->run() == TRUE) {
                $data['unit_volume'] = $this->input->post('unit_volume');
                $data['price_per_unit'] = $this->input->post('price_per_unit');
                $data['total_order'] = $this->input->post('total_order');
                $data['currency_id'] = $this->input->post('currency');
                $data['payment_term'] = $this->input->post('payment_term');
                $data['incoterm_id'] = $this->input->post('incoterm_id');
                $lead_time = strtotime($this->input->post('lead_time'));
                $data['lead_time'] = $lead_time;
                $data['pre_approved_sample'] = $this->input->post('pre_approved_sample');
                $sample_lead_time = strtotime($this->input->post('sample_lead_time'));
                $data['sample_lead_time'] = $sample_lead_time;
                $data['additional_information'] = $this->input->post('additional_information');
                //$data['transaction_fee'] = $this->input->post('transaction_fee');
                $data['created_time'] = time();
                $data['is_active'] = '1';
                $data['total_cost'] = $data['total_order'];

                $user_id = $this->session->userdata('user_id');
                $job_quote_id = '';
                if ($this->input->post('jq_id')) {
                    $job_quote_id = $this->input->post('jq_id');
                    $quote_data = $this->Base_model->get_one_entry('job_quote', array('jq_id' => $job_quote_id));
                    if (!empty($quote_data->freight_quote_cost)) {
                        $data['total_cost'] = $data['total_order'] + $quote_data->freight_quote_cost;
                    }
                    $updated_quote = $this->Base_model->update_entry('job_quote', $data, 'jq_id', $job_quote_id);
                    if ($updated_quote) {
                        //Adding quote editing history
                        $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['supplier_edit_quote_submit'];
                        $success_msg = 'Your quote has been edited successfully!';
                        $flag = true;
                    }
                } else {
                    $this->load->model('Supplier_model');
                    $supplier_data = $this->Supplier_model->get_supplier_data($user_id);

                    if (!empty($supplier_data)) {
                        $data['sd_id'] = $supplier_data->sd_id;
                        $data['job_id'] = $job_id;
                        $allocation_data = $this->Base_model->get_one_entry('job_supplier_allocation', array('job_id' => $job_id, 'sd_id' => $data['sd_id']));
                        if (empty($allocation_data)) {
                            $msg = "Sorry, This job has not been allocated to you. Please try with another.";
                            $flag = false;
                        } else {
                            $data['jsa_id'] = $allocation_data->jsa_id;
                            $job_quote_id = $this->Base_model->insert_entry('job_quote', $data);

                            //Send notification email to buyer and seller 
                            $this->load->model('Email_model');
                            $this->Email_model->seller_quote_buyer_notify($job_id, $job_quote_id, $user_id);
                            //Adding quote submitting history
                            $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['supplier_quote_submit'];
                            $flag = true;
                            $success_msg = 'Your quote has been posted successfully!';
                        }
                    }
                }
                //insert quote history
                $this->Job_model->add_job_history($user_id, $job_id, $history_desc);

                //Calculate supplier ranking
                $this->JobQuote_model->calculate_job_quote_ranking($job_id, $job_quote_id);

                //Calculate total cost ranking
                $this->JobQuote_model->calculate_total_cost_ranking($job_id, $job_quote_id);

                if ($flag == true && !empty($job_quote_id)) {
                    $this->session->set_flashdata('success_msg', $success_msg);
                } else {
                    $err_msg = !empty($msg) ? $msg : 'Something went wrong!!!';
                    $this->session->set_flashdata('error_msg', $err_msg);
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Please enter required fields');
            }
        }
        redirect('dashboard/job/' . $job_id);
    }

    public function approve_quote() {
        if (!empty($this->uri->segment(5)) && !empty($this->uri->segment(4))) {
            $quote_id = $this->uri->segment(4);
            $job_id = $this->uri->segment(5);
            $updated = $this->Base_model->update_entry('job_quote', array('is_approved' => '1'), 'jq_id', $quote_id);
            if (!empty($updated)) {
                $this->JobQuote_model->add_job_order($job_id, $quote_id);
                $this->session->set_flashdata('success_msg', 'Quote has been approved successfully!');
                redirect('dashboard/order/view/' . $job_id);
            }
        }
        $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
        redirect('dashboard/order/view/' . $job_id);
    }

    /*  Not being used for time being
     * public function reject_quote() {
      if (!empty($this->uri->segment(5)) && !empty($this->uri->segment(4))) {
      $quote_id = $this->uri->segment(4);
      $job_id = $this->uri->segment(5);
      $updated = $this->Base_model->update_entry('job_quote', array('is_approved' => '0'), 'jq_id', $quote_id);
      if (!empty($updated)) {
      $this->JobQuote_model->remove_job_order($job_id, $quote_id);
      $this->session->set_flashdata('success_msg', 'This quote has been rejected successfully!');
      redirect('dashboard/job/' . $job_id);
      }
      }
      $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
      redirect('dashboard/job/' . $job_id);
      }
     */

    public function submit_freight_quote() {

        if (($this->input->post())) {
            $flag = false;
            $data = array();
            $job_id = $this->input->post('job_id');
            $this->load->library('form_validation');
            //set validation rules                       
            $this->form_validation->set_rules('total_shipment_ex_tax', 'Total shipment excluding Tax', 'trim|required');
            $this->form_validation->set_rules('total_shipment_inc_tax', 'Total Shipment including Tax', 'trim|required');
            $this->form_validation->set_rules('shipping_method', 'Shipping method', 'trim|required');
            $this->form_validation->set_rules('incoterm_id', 'Incoterm', 'trim|required');
            $this->form_validation->set_rules('net_weight', 'Net weight', 'trim|required');
            $this->form_validation->set_rules('gross_weight', 'Gross weight', 'trim|required');
            $this->form_validation->set_rules('transit_time', 'Transit time', 'trim|required');
            //validate form input
            $user_id = $this->session->userdata('user_id');

            if ($this->form_validation->run() == TRUE) {
                $data['shipment_total_cost_ex_tax'] = $this->input->post('total_shipment_ex_tax');
                $data['shipment_total_cost_inc_tax'] = $this->input->post('total_shipment_inc_tax');
                $data['shipping_method_id'] = $this->input->post('shipping_method');
                $data['incoterm_id'] = $this->input->post('incoterm_id');
                $data['shipment_nett_weight'] = $this->input->post('net_weight');
                $data['shipment_gross_weight'] = $this->input->post('gross_weight');
                $data['transit_time'] = $this->input->post('transit_time');
                $data['additional_notes'] = $this->input->post('additional__notes');
                $data['created_time'] = time();
                $data['is_active'] = '1';

                $this->load->model('Freight_model');
                $freight_data = $this->Freight_model->get_freight_data($user_id);
                $freight_quote_id = '';
                if (!empty($freight_data)) {
                    $data['fd_id'] = $freight_data->fd_id;
                    $data['job_id'] = $job_id;
                    $allocation_data = $this->Base_model->get_one_entry('job_freight_allocation', array('job_id' => $job_id, 'fd_id' => $data['fd_id']));
                    if (empty($allocation_data)) {
                        $msg = "Sorry, This job has not been allocated to you. Please try with another.";
                        $flag = false;
                    } else {
                        //$data['jfa_id'] = $allocation_data->jfa_id;
                        $job_order_data = $this->Base_model->get_one_entry('job_order', array('job_id' => $job_id));
                        $data['job_order_id'] = $job_order_data->job_order_id;
                        $freight_quote_id = $this->Base_model->insert_entry('freight_quote', $data);

                        $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['freight_quote_submit'];
                        $this->Job_model->add_job_history($user_id, $job_id, $history_desc);
                        $flag = true;
                    }
                }

                if ($flag == true && !empty($freight_quote_id)) {
                    $this->session->set_flashdata('success_msg', 'Your quote has been posted successfully!');
                } else {
                    $err_msg = !empty($msg) ? $msg : 'Something went wrong!!!';
                    $this->session->set_flashdata('error_msg', $err_msg);
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Please enter required fields');
            }
        }
        redirect('dashboard/job/' . $job_id);
    }

    public function freight_cost_submit() {

        if (($this->input->post())) {

            $job_quote_id = $this->input->post('jq_id');
            $job_id = $this->input->post('job_id');
            $quote_data = $this->Base_model->get_one_entry('job_quote', array('jq_id' => $job_quote_id));
            $data['freight_quote_cost'] = $this->input->post('freight_quote_cost');
            if (!empty($data['freight_quote_cost']) && !empty($quote_data)) {
                $data['total_cost'] = $data['freight_quote_cost'] + $quote_data->total_order;
            }
            $this->Base_model->update_entry('job_quote', $data, 'jq_id', $job_quote_id);
            //Calculate total cost ranking
            $this->JobQuote_model->calculate_total_cost_ranking($job_id, $job_quote_id);

            $this->session->set_flashdata('success_msg', 'Freight quote cost has been saved successfully!');
            redirect('dashboard/job/' . $job_id);
        }
    }

    public function edit_shipping_address($address_id) {
        if (($this->input->post())) {
            $job_id = $this->input->post('job_id');
            $addr_data['address_name'] = $this->input->post('address_name');
            $addr_data['street_address'] = $this->input->post('street_address');
            $addr_data['city'] = $this->input->post('city');
            $addr_data['state'] = $this->input->post('state');
            $addr_data['country_id'] = $this->input->post('country_id');
            $addr_data['post_code'] = $this->input->post('post_code');
            $addr_data['telephone_no'] = $this->input->post('telephone_no');
            $addr_data['telephone_code'] = !empty($this->input->post('telephone_code')) ? $this->input->post('telephone_code') : NULL;
            $addr_data['fax_no'] = $this->input->post('fax_no');

            $this->load->model('JobFreight_model');
            $this->JobFreight_model->add_shipping_address($job_id, $addr_data, $address_id);
            redirect('dashboard/job/' . $job_id);
        }
    }

    public function notify_demo_seller() {
        $seller_id = $this->uri->segment(4);
        $job_id = $this->uri->segment(5);
        if (!empty($seller_id) && !empty($job_id)) {
            $this->load->model('Email_model');
            $this->load->model('Login_model');

            $response = $this->Email_model->demo_seller_notify($seller_id);
            if ($response) {
                $this->Login_model->add_history_log($seller_id, 'Seller Request Sent', 'Seller has been requested to change from demo to live account');
                $this->session->set_flashdata('success_msg', 'Thank you, your request has been submitted successfully');
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
        }
        redirect('dashboard/job/' . $job_id);
    }

    /*
     * List out canceled jobs of a buyer
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
        if ($this->session->userdata('user_type_id') == 2 || 
                $this->session->userdata('is_transformed') == 1) {
            $this->load->model('Consumer_model');
            $cnt = $this->Consumer_model->get_buyer_passed_order_count($this->page_data['user_id'], $search_term);
            $url = base_url() . "/dashboard/past-order-list/";
            $this->page_data['per_page'] = "10";
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['buyer_passed_orders'] = $this->Consumer_model->get_buyer_passed_orders($this->page_data['user_id'], $search_term, $offset, $this->page_data['per_page']);

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
     * Method to cancel a job
     */
    public function cancel_job() {
        if (!empty($this->uri->segment(4))) {
            $job_id = $this->uri->segment(4);

            $this->Job_model->cancel_a_job($job_id);

            $user_id = $this->session->userdata('user_id');
            $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['cancelled'];
            $updated = $this->Job_model->add_job_history($user_id, $job_id, $history_desc);
            if (!empty($updated)) {
                $this->session->set_flashdata('success_msg', 'Project has been cancelled successfully!');
                redirect('dashboard/order/past-order-view/' . $job_id);
            }
        }
        $this->session->set_flashdata('error_msg', 'Something went wrong. Try again!!!');
        redirect('dashboard/order/past-order-view/' . $job_id);
    }

    public function seller_info_popup() {
        $seller_id = $this->input->post('sellerid');
        $this->load->model('Supplier_model');
        $supplier_data = $this->Supplier_model->get_supplier_data($seller_id);
        if (!empty($supplier_data->logo_path)) {
            $logo = base_url() . "uploads/company/" . $supplier_data->logo_path;
        } else {
            $logo = base_url() . "styles/images/default.png";
        }
        $supplier_name = ucfirst($supplier_data->first_name) . ' ' . $supplier_data->last_name;
        $fax_number = !empty($supplier_data->fax_no) ? $supplier_data->fax_no : '---';
        $address = '---';
        if (!empty($supplier_data->street_address)) {
            $address = $supplier_data->address_name . ',<br/> ' . $supplier_data->street_address . '.';
        }
        $city = !empty($supplier_data->city) ? $supplier_data->city : '---';
        $state = !empty($supplier_data->state) ? $supplier_data->state : '---';
        $country = !empty($supplier_data->country_name) ? $supplier_data->country_name : '---';
        $post_code = !empty($supplier_data->post_code) ? $supplier_data->post_code : '---';
        $company_name = !empty($supplier_data->company_name) ? $supplier_data->company_name : '---';
        $website_url = !empty($supplier_data->website) ? $supplier_data->website : '---';
        $sup_content = '';
        $sup_content .= '<div class="modal-content"><div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    
                    <h4 class="modal-title"> 
                    <img src="' . $logo . '" width="40px" height="40px">' . $supplier_name . ' </h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered clearfix">
                        <tr>
                            <th width="50%">Name </th>
                            <td >' . $supplier_name . ' </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>' . $supplier_data->email . '</td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>' . $supplier_data->telephone_code . '' . $supplier_data->telephone_no . '</td>
                        </tr>
                        <tr>
                            <th>Fax Number</th>
                            <td>' . $fax_number . '</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>' . $address . '</td>
                        </tr>
                         <tr>
                            <th>City</th>
                            <td>' . $city . '</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>' . $state . '</td>
                        </tr>
                        
                        <tr>
                            <th>Country</th>
                            <td>' . $country . '</td>
                        </tr>
                        <tr>
                            <th>ZIP code</th>
                            <td>' . $post_code . '</td>
                        </tr>
                        <tr>
                            <th>Additional Information</th>
                            <td><b>Company:</b>  ' . $company_name . '<br/>
                                <b>Website</b>:  ' . $website_url . '
                           </td>
                        </tr>
                    </table>
                </div></div>';
        echo $sup_content;
    }

}
