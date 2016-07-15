<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Base_Controller {

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
    }

    /**
     * 
     * @param type $page
     */
    public function index($page = 1) {
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
        if ($this->session->userdata('user_type_id') == 4) {
            $this->page_data['page_title'] = 'Quotes';
            $this->load->model('Freight_model');
            $cnt = $this->Freight_model->get_freight_quote_count($user_id, $search_term);
            $url = base_url() . "/dashboard/";
            $this->page_data['per_page'] = "10";
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->pagination->cur_page = $page;
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['freight_dashboard_list'] = $this->Freight_model->get_freight_quotes($user_id, $offset, $search_term, $this->page_data['per_page']);
        } 

        $this->page_data['verify_msg'] = $this->session->flashdata('verify_msg');
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('dash_board', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    
    public function user_bid_list($page = 1){
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
        $this->page_data['page_title'] = 'My Bids';
        $this->load->model('Supplier_model');
        $cnt = $this->Supplier_model->get_supplier_quote_count($user_id, $search_term);
        $url = base_url() . "/dashboard/my-bids";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['user_bid_list'] = $this->Supplier_model->get_supplier_quotes($user_id, $search_term, $offset, $this->page_data['per_page']);
        
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('dashboard/user_bid_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    
    public function user_project_list($page = 1){
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
        $this->page_data['page_title'] = 'My Projects';
        $this->load->model('Consumer_model');
        $cnt = $this->Consumer_model->get_consumer_quote_count($user_id, $search_term);
        $url = base_url() . "/dashboard/my-projects";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['user_project_list'] = $this->Consumer_model->get_consumer_quotes($user_id, $search_term, $offset, $this->page_data['per_page']);
        
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('dashboard/user_project_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

    /**
     * 
     * @param type $data
     */
    public function view($data, $id = "") {
        $this->page_data['page_title'] = 'Pages';
        if ($this->session->logged_in != true) {
            redirect(base_url());
        }
        $this->page_data['user_type'] = $this->session->user_type;
        $this->page_data['user_type_id'] = $this->session->user_type_id;

        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        if ($data == 'post-a-requirement' || $data == 'edit-job') {
            $this->page_data['job_id'] = $id;
            $this->page_data['job_details'] = "";
            $this->page_data['job_additional_details'] = "";
            $this->page_data['page_title'] = 'Request For Quote';
            if ($id) {
                $this->page_data['page_title'] = 'Edit Job';
                $this->load->model('Job_model');
                $job_info = $this->Job_model->get_job_details($id);
                $this->page_data['job_additional_details'] = $this->Job_model->get_job_additional_details($id);

                if (!empty($job_info)) {
                    $this->page_data['job_details'] = $job_info['job_data'];
                    $this->page_data['job_user_data'] = $job_info['user_data'];
                    $job_status = $this->page_data['job_details']->job_status_name;
                    $user_id = $this->session->userdata('user_id');
                    $this->page_data['sub_categories'] = $this->General_model->get_sub_categories_by_catid($this->page_data['job_details']->cat_id);
                }

                $shipping_details = $this->Base_model->get_one_entry('job_shipping_details', array("job_id" => $id));

                if ($shipping_details->to_address_consumer_address == 1) {
                    $address_id = $job_info['user_data']->address_id;
                    $this->page_data['note_to_address'] = "Buyer Shipping Address";
                } else {
                    $this->page_data['note_to_address'] = "Ship to other Address";
                    $address_id = $shipping_details->to_address_id;
                }

                $this->page_data['shipping_details'] = $shipping_details;
                $this->page_data['get_shipping_to_address'] = $this->General_model->get_full_address($address_id);
            }
            
            $this->page_data['categories'] = $this->General_model->get_all_categories();
            $this->page_data['countries'] = $this->Base_model->get_all('country');

            //Getting all Additional job details table data 
            $this->page_data['plastic'] = $this->Base_model->get_all("plastic");
            $this->page_data['thickness'] = $this->Base_model->get_all("thickness");
            $this->page_data['cmyk'] = $this->Base_model->get_all("cmyk");
            $this->page_data['metallic_ink'] = $this->Base_model->get_all("metallic_ink");
            $this->page_data['magnetic_tape'] = $this->Base_model->get_all("magnetic_tape");
            $this->page_data['personalization'] = $this->Base_model->get_all("personalization");
            $this->page_data['front_signature_panel'] = $this->Base_model->get_all("front_signature_panel");
            $this->page_data['reverse_signature_panel'] = $this->Base_model->get_all("reverse_signature_panel");
            $this->page_data['embossing'] = $this->Base_model->get_all("embossing");
            $this->page_data['hotstamping'] = $this->Base_model->get_all("hotstamping");
            $this->page_data['hologram'] = $this->Base_model->get_all("hologram");
            $this->page_data['finish'] = $this->Base_model->get_all("finish");
            $this->page_data['bundling_required'] = $this->Base_model->get_all("bundling_required");
            $this->page_data['contactless_chip'] = $this->Base_model->get_all("contactless_chip");
            $this->page_data['contact_chip'] = $this->Base_model->get_all("contact_chip");
            $this->page_data['key_tag'] = $this->Base_model->get_all("key_tag");


            $this->load->view('dashboard/post_a_requirement', $this->page_data);
        } else {
            $this->load->view('page_not_found');
        }
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

    public function submit_requirement() {

        $this->load->model('Base_model');
        $this->load->model('Job_model');
        $this->load->model('Email_model');
        $this->page_data['page_title'] = 'Post a requirement';
        $this->page_data['categories'] = $this->General_model->get_all_categories();
        $this->page_data['countries'] = $this->Base_model->get_all('country');

        if ($this->input->post()) {

            $this->load->library('form_validation');
            //set validation rules
            $this->form_validation->set_rules('job_name', 'Project Name', 'required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', validation_errors());
                redirect('dashboard/post-a-requirement');
            } else {

                $user_id = $this->session->userdata('user_id');
                $data['job_name'] = $this->input->post('job_name');
                $data['job_overview'] = $this->input->post('job_overview');
                $data['product_quantity'] = $this->input->post('product_quantity');
                $product_lead_time = $this->input->post('product_lead_time');
                $data['description'] = $this->input->post('description');
                $data['special_requirement'] = $this->input->post('special_requirement');
                //$data['file_type'] = $this->input->post('file_type');
                $data['expected_amount'] = $this->input->post('expected_amount');
                $data['is_urgent'] = $this->input->post('is_urgent');
                $data['is_sealed'] = $this->input->post('is_sealed');
                $data['is_sample_required'] = $this->input->post('is_sample_required');
                $sla_milestone = $this->input->post('sla_milestone');
                $data['created_time'] = time();
                $data['is_active'] = '1';
                $sub_category = $this->input->post('sub-category');
                $data['product_lead_time'] = strtotime($product_lead_time);
                $j_id = $this->input->post('job_id');
                if ($j_id) {
                    $sla_milestone .=" 23:59:00";
                    $data['sla_milestone'] = strtotime($sla_milestone);
                    if($data['sla_milestone'] > time() + 86400) {
                        $data['is_urgent'] = "";
                     } else {
                        $data['is_urgent'] = "1";
                     }
                } else {
                    $data['sla_milestone'] = $this->Job_model->calculate_time($sla_milestone, 'hour');
                }

                $job_status = $this->Base_model->get_one_entry('job_status', array('job_status_name' => 'Quote Request'));
                $data['job_status_id'] = $job_status->job_status_id;

                if ($j_id) {
                    $data['cd_id'] = $this->input->post('consumer_id');
                } else {
                    $consumer = $this->Base_model->get_one_entry('consumer_details', array('user_id' => $user_id));
                    $data['cd_id'] = $consumer->cd_id;
                }

                if ($j_id) {
                    $this->Base_model->update_entry('job_details', $data, 'job_id', $j_id);
                    $job_id = $j_id;
                } else {
                    $job_id = $this->Base_model->insert_entry('job_details', $data);
                }

                if (isset($_FILES['job_file']) && !empty($_FILES['job_file']['tmp_name'])) {
                    $config['allowed_types'] = 'jpg|png|jpeg|gif|pdf|doc|docx';
                    $upload_return = $this->General_model->do_upload('job_file', $_FILES['job_file'], 'documents', $config);

                    if (!empty($upload_return['error'])) {
                        $this->session->set_flashdata('error_msg', $upload_return['error']);
                        redirect('dashboard/post-a-requirement');
                    } else {
                        $file_data['file_type_id'] = $this->input->post('file_type');
                        $file_data['job_id'] = $job_id;
                        $file_data['file_name'] = $upload_return['data']['file_name'];
                        $file_data['user_id'] = $user_id;
                        $file_data['created_time'] = time();
                        $file_data['is_active'] = '1';
                        $file_id = $this->Base_model->insert_entry('job_file', $file_data);

                        //update job_detals table with file_id after file upload

                        $this->Base_model->update_entry('job_details', array('job_file_id' => $file_id), 'job_id', $job_id);
                    }
                }

                if ($this->input->post('delivery_required') == 1) {
                    $is_courier = $this->input->post('is_courier');
                    $is_air_freight = $this->input->post('is_air_freight');
                    $is_sea_freight = $this->input->post('is_sea_freight');

                    $my_address_type = $this->input->post('my_address');
                    if ($my_address_type == 2) {
                        //$addr_data['user_id'] = $user_id;
                        $addr_data['address_name'] = $this->input->post('address_name');
                        $addr_data['street_address'] = $this->input->post('street_address');
                        $addr_data['city'] = $this->input->post('city');
                        $addr_data['state'] = $this->input->post('state');
                        $addr_data['country_id'] = $this->input->post('country_id');
                        $addr_data['post_code'] = $this->input->post('post_code');
                        $addr_data['telephone_no'] = $this->input->post('telephone_no');
                        $addr_data['telephone_code'] = !empty($this->input->post('telephone_code')) ? $this->input->post('telephone_code') : NULL;
                        $address_id = (!empty($this->input->post('addressid'))) ? $this->input->post('addressid') : "";
                        $this->load->model('JobFreight_model');
                        $address_id = $this->JobFreight_model->add_shipping_address($job_id, $addr_data, $address_id);
                        $ship_data['to_address_consumer_address'] = 0;
                    } else {
                        $ship_data['to_address_consumer_address'] = 1;
                        $address_id = NULL;
                    }

                    $ship_data['job_id'] = $job_id;
                    $ship_data['to_address_id'] = $address_id;
                    $ship_data['is_require_delivery'] = 1;
                    $ship_data['is_courier'] = $is_courier;
                    $ship_data['is_air_freight'] = $is_air_freight;
                    $ship_data['is_sea_freight'] = $is_sea_freight;
                    $ship_data['is_active'] = 1;
                    if ($j_id) {
                        $this->Base_model->update_entry('job_shipping_details', $ship_data, 'job_id', $j_id);
                    } else {
                        $this->Base_model->insert_entry('job_shipping_details', $ship_data);
                    }
                } else {

                    $ship_data['job_id'] = $job_id;
                    $ship_data['is_require_delivery'] = 0;
                    $ship_data['to_address_id'] = "";
                    $ship_data['is_active'] = 1;
                    if ($j_id) {
                        $this->Base_model->update_entry('job_shipping_details', $ship_data,'job_id',$job_id); 
                    }else{
                        $this->Base_model->insert_entry('job_shipping_details', $ship_data);
                    }
                }

                //Adding category job mapping to the table
                $cat_data['sub_cat_id'] = $sub_category;
                $cat_data['job_id'] = $job_id;
                $cat_data['is_active'] = '1';
                if ($j_id) {
                    $subcat_updated = $this->Base_model->update_entry('job_sub_category', $cat_data, 'job_id', $j_id);
                } else {
                    $subcat_updated = $this->Base_model->insert_entry('job_sub_category', $cat_data);
                }

                //Adding Additional details
                $additional_id = (!empty($this->input->post('additional_id'))) ? $this->input->post('additional_id') : "";
                if ($this->input->post('quote_type') == 2) {
                    $additonal_data['job_id'] = $job_id;

                    $additonal_data['plastic_id'] = $this->input->post('plastic_id');
                    $additonal_data['plastic_other'] = $this->input->post('plastic_other');
                    $additonal_data['thickness_id'] = $this->input->post('thickness_id');
                    $additonal_data['thickness_other'] = $this->input->post('thickness_other');
                    $additonal_data['cmyk_id'] = $this->input->post('cmyk_id');
                    $additonal_data['metallic_ink_id'] = $this->input->post('metallic_ink_id');
                    $additonal_data['pantone_front_color'] = $this->input->post('pantone_front_color');
                    $additonal_data['pantone_reverse_color'] = $this->input->post('pantone_reverse_color');
                    $additonal_data['magnetic_tape_id'] = $this->input->post('magnetic_tape_id');
                    $additonal_data['personalization_id'] = $this->input->post('personalization_id');
                    $additonal_data['front_signature_panel_id'] = $this->input->post('front_signature_panel_id');
                    $additonal_data['reverse_signature_panel_id'] = $this->input->post('reverse_signature_panel_id');
                    $additonal_data['embossing_id'] = $this->input->post('embossing_id');
                    $additonal_data['hotstamping_id'] = $this->input->post('hotstamping_id');
                    $additonal_data['hologram_id'] = $this->input->post('hologram_id');
                    $additonal_data['hologram_other'] = $this->input->post('hologram_other');
                    $additonal_data['dimensions'] = $this->input->post('dimensions');
                    $additonal_data['gsm'] = $this->input->post('gsm');
                    $additonal_data['finish_id'] = $this->input->post('finish_id');
                    $additonal_data['bundling_required_id'] = $this->input->post('bundling_required_id');
                    $additonal_data['bundling_required_other'] = $this->input->post('bundling_required_other');
                    $additonal_data['contactless_chip_id'] = $this->input->post('contactless_chip_id');
                    $additonal_data['contactless_chip_other'] = $this->input->post('contactless_chip_other');
                    $additonal_data['contact_chip_id'] = $this->input->post('contact_chip_id');
                    $additonal_data['contact_chip_other'] = $this->input->post('contact_chip_other');
                    $additonal_data['key_tag_id'] = $this->input->post('key_tag_id');
                    $additonal_data['unique_card_size'] = $this->input->post('unique_card_size');
                    $additonal_data['scented_ink'] = $this->input->post('scented_ink');
                    $additonal_data['uv_ink'] = $this->input->post('uv_ink');
                    $additonal_data['raised_surface'] = $this->input->post('raised_surface');
                    $additonal_data['magnetic_strip_encoding'] = $this->input->post('magnetic_strip_encoding');
                    $additonal_data['scratch_off_panel'] = $this->input->post('scratch_off_panel');
                    $additonal_data['fulfillment_service_required'] = $this->input->post('fulfillment_service_required');
                    $additonal_data['card_holder'] = $this->input->post('card_holder');
                    $additonal_data['attach_card_with_glue'] = $this->input->post('attach_card_with_glue');
                    $additonal_data['key_hole_punching'] = $this->input->post('key_hole_punching');

                    $additonal_data['is_active'] = 1;
                    if (!$additional_id) {
                        $this->Base_model->insert_entry('job_additional_details', $additonal_data);
                    } else {
                        $this->Base_model->update_list('job_additional_details', $additonal_data, array('job_id' => $j_id, 'is_active' => '1'));
                    }
                } else {
                    if ($j_id) {
                        if ($additional_id) {

                            $additonal_data['is_active'] = 0;
                            $this->Base_model->update_entry('job_additional_details', $additonal_data, 'jad_id', $additional_id);
                        }
                    }
                }
                $chk_cat_id = $this->input->post('category');
                if ($chk_cat_id > 4) {
                    if ($additional_id) {
                        $additonal_newdata['is_active'] = 0;
                        $this->Base_model->update_entry('job_additional_details', $additonal_newdata, array('jad_id' => $additional_id));
                    }
                }

                if (!$j_id) {
                   $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['quote_request'];
                    //Sending email notification to buyer
                    $this->Email_model->job_submit_notify($job_id);
                    $success_msg = 'Your requirement has been posted successfully!';
                    $url = 'dashboard/my-projects';
                }else{
                    $history_desc = $this->config->item('job_history_desc', 'smartcardmarket')['quote_request_edited'];
                    $success_msg = 'Your requirement has been edited successfully!';
                    $url = 'dashboard/job/'.$j_id;
                }
                 //Adding job history
                $this->Job_model->add_job_history($user_id, $job_id, $history_desc);
                if(!empty($subcat_updated)){
                    //Allocating job to associated suppliers
                    $this->Job_model->supplier_job_allocation($job_id, $sub_category, $user_id);
                }
                
                if (!empty($job_id)) {
                    $this->session->set_flashdata('success_msg', $success_msg);
                    redirect($url);
                } else {
                    $this->session->set_flashdata('error_msg', 'Something went wrong!!!');
                    redirect('dashboard/post-a-requirement');
                }
            }
        } else {
            redirect('dashboard/post-a-requirement/'.$j_id);
        }
    }

    /**
     * List out all active news on the page
     */
    public function news($page = 1) {
        $this->page_data['page_num'] = $page;

        $this->load->model("Pagination_model");
        $search_term = '';
        if ($this->input->get()) {
            $this->page_data['search_news'] = $search_term = $this->input->get('search_news');
        }
        $this->page_data['page_title'] = 'News';
        $this->load->model('News_model');
        $cnt = $this->News_model->get_front_news_count($search_term);
        $url = base_url() . "/news";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['news_list'] = $this->News_model->get_front_news($search_term, $offset, $this->page_data['per_page']);

        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        if ($this->page_data['logged_in'] == true) {
            $this->load->view('templates/header_dashboard', $this->page_data);
        } else {
            $this->load->view('templates/header_blank', $this->page_data);
        }
        $this->load->view('news_list', $this->page_data);
        if ($this->page_data['logged_in'] == true) {
            $this->load->view('templates/footer_dashboard');
        } else {
            $this->load->view('templates/footer', $this->page_data);
        }
        $this->load->view('templates/bottom');
    }
    
    public function news_view($news_id){
        if($this->session->flashdata('comment_message')){
            $this->session->set_flashdata('comment_message', 'Thank you for your post! Your comment will be reviewed by our moderator and posted momentarily. <br/> Kind Regards, the SMARTCardMarket team.');
          }
        $slug = $this->General_model->get_permalink('news','news_permalink',array('news_id'=>$news_id));
        $this->session->set_userdata('news_id', $news_id);
        redirect("news_detail/".$slug);  
    }

    public function news_detail($slug="" , $page=1) {
        $news_id = $this->session->userdata('news_id');
        $this->load->model("Pagination_model");
        $this->page_data['page_title'] = 'News';
        if (!empty($news_id)) {
            $this->load->model('News_model');
            $this->page_data['news_data'] = $this->News_model->get_news_data($news_id);
            $this->page_data['page_num'] = $page;
            $url = base_url() . "/news_detail/$slug";
            $this->page_data['per_page'] = "10";
            $cnt = $this->News_model->get_all_news_comment_count($news_id);
            $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
            $this->page_data['tot_count'] = $cnt;
            $this->page_data["pagination_helper"] = $this->pagination;
            $offset = ($page - 1) * $this->page_data['per_page'];
            $this->page_data['news_comments'] = $this->News_model->get_news_comments($news_id,$offset, $this->page_data['per_page']);
            $this->load->view('templates/top');
            $this->load->view('templates/head', $this->page_data);
            if ($this->page_data['logged_in'] == true) {
                $this->load->view('templates/header_dashboard', $this->page_data);
            } else {
                $this->load->view('templates/header_blank', $this->page_data);
            }
            $this->load->view('news_view', $this->page_data);
            if ($this->page_data['logged_in'] == true) {
                $this->load->view('templates/footer_dashboard');
            } else {
                $this->load->view('templates/footer', $this->page_data);
            }
            $this->load->view('templates/bottom');
        }
    }

    public function get_notifications($page = 1) {
        $this->page_data['page_title'] = 'Notifications';

        if ($this->page_data['logged_in'] != true) {
            redirect(base_url());
        }
        $this->load->model('User_model');
        $user_id = $this->session->userdata('user_id');
        $this->User_model->read_notifications($user_id);
        $this->load->model("Pagination_model");
        $this->load->model("User_model");

        $cnt = $this->User_model->get_user_notification_count($user_id);
        $url = base_url() . "/dashboard/notifications";
        $this->page_data['per_page'] = "10";
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->pagination->cur_page = $page;
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['notification_list'] = $this->User_model->get_user_notifications($user_id, $offset, $this->page_data['per_page']);
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('dashboard/notifications', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

}
