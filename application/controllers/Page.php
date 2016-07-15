<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Base_Controller {

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
        $page_data['page_title'] = 'SMARTCard Market creates a win-win situation for buyers and suppliers';
        $this->load->view('templates/top');
        $page_data['meta_description'] = 'SmartCardMarket.com gain access to leading plastic card '
                . 'manufacturers and product suppliers across the globe. Who can assist you with '
                . 'your requirements within moments of posting a project!';
        $page_data['meta_keywords'] = 'Plastic card suppliers, card supplier comparison service, '
                . 'plastic card manufactures, plastic card buyers and suppliers, card making suppliers,'
                . ' supplier comparison, smart card suppliers, Plastic card services, smart card, '
                . 'smart card market, smartcard market, smartcard suppliers, smartcardmarket';
        
        $this->load->view('templates/head', $page_data);
        $this->load->view('templates/header', $this->page_data);
        $this->load->view('welcome_message');
        $this->load->view('templates/footer');
        $this->load->view('templates/bottom');
    }

    /**
     * 
     * @param type $data
     */
    public function view($data) {
        $this->page_data['page_title'] = "SMARTCardMartket";
        $this->load->view('templates/top');

        if ($data == 'aboutus') {
            $this->page_data['page_title'] = 'About-SMARTCard Market| Company Overview';
            $this->page_data['meta_description'] = 'The plastic card industry has always '
                    . 'been a supplier’s market. SMARTCardMarket is looking to disrupt '
                    . 'that and put the power back in the buyer’s hands. '
                    . '“SMARTCardMarket creates a win-win situation for buyers and '
                    . 'suppliers alike.';
            $this->page_data['meta_keywords'] = 'Plastic card suppliers, smart card suppliers, '
                    . 'supplier comparison, plastic card consumers, card making suppliers, '
                    . 'Plastic card manufactures, card printing and shipping services, '
                    . 'Gift card suppliers';
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('static/aboutus', $this->page_data);
        } elseif ($data == 'post-a-project') {
            $this->page_data['page_title'] = 'Post a Project to SMARTCard Market.com';
            $this->page_data['meta_description'] = 'Post a project for Smart card printing, '
                    . 'secure cards, RFID cards, Telecom cards and Card printers, '
                    . 'card readers. Quote for Plastic card materials and payment services '
                    . 'with Smartcard market.com';
            $this->page_data['meta_keywords'] = 'supplier comparison, plastic card consumers, '
                    . 'card making suppliers, card printing and shipping services,'
                    . 'gift card suppliers, RFID cards suppliers, Magnetic strip card suppliers,'
                    . ' Plastic card materials, telecom cards suppliers.';
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->model('General_model');
            $this->page_data['categories'] = $this->General_model->get_all_categories();
            $this->page_data['countries'] = $this->Base_model->get_all('country');
            $this->page_data['telephone_codes'] = $this->General_model->get_all_telephone_codes();

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


            $this->load->view('static/post_a_project', $this->page_data);
        } elseif ($data == 'faq') {
            $this->page_data['page_title'] = 'Frequently Asked Questions| SMARTCardMarket.com';
            $this->page_data['meta_description'] = 'How to get the best deal with SMARTCard Market '
                    . 'and SMARTCardMarket frequently asked questions on Smart card suppliers, '
                    . 'plastic card vendors, product manufactures and how to order with '
                    . 'SMARTCard Market.';
            $this->page_data['meta_keywords'] = 'Best deals with Plastic cards, plastic card deals, '
                    . 'how to order plastic cards online, smart card suppliers deal, '
                    . 'plastic card manufactures online, plastic shipping service, '
                    . 'plastic cards for industries';
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('static/faq', $this->page_data);
        } elseif ($data == 'terms') {
            $this->page_data['page_title'] = 'Terms and Conditions | SMARTCardMarket.com';
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('static/terms', $this->page_data);
        } elseif ($data == 'privacy_policy') {
            $this->page_data['page_title'] = 'Privacy Policy | SMARTCardMarket.com';
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('static/privacy_policy', $this->page_data);
        } elseif ($data == 'team') {
            $this->page_data['page_title'] = 'Meet Our SMARTCard Market Team| SMARTCardMarket.com';
            $this->page_data['meta_description'] = 'Our Team is our biggest asset and biggest '
                    . 'differentiator in SMARTCardMarket.com. They are passionate about '
                    . 'productivity and results, and also believe in having a lot of '
                    . 'fun along the way.';
            $this->page_data['meta_keywords'] = 'Smartcard market, Supplier comparison service, '
                    . 'Plastic card supplier, smart card supplier service, Smartcard market '
                    . 'team, card printing and shipping services';
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('static/team', $this->page_data);
        } elseif ($data == 'howitworks') {
            $this->page_data['page_title'] = 'How SMARTCard Market works for Purchasing a '
                    . 'product or looking to Manufacture?';
            $this->page_data['meta_description'] = 'SmartCardMarket.com! Gain access to leading '
                    . 'manufacturers and product suppliers across the globe. Who can assist '
                    . 'you with your requirements within moments of posting a project.';
            $this->page_data['meta_keywords'] = 'Plastic card supplier comparison service, '
                    . 'leading plastic card manufactures, card printer’s supplier, '
                    . 'Plastic card offers from providers, Plastic card freight service, '
                    . 'plastic card consumers';
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('static/howitworks', $this->page_data);
        } elseif ($data == 'fees') {
            $this->page_data['page_title'] = 'SMARTCard Market- Fees and Charges';
            $this->page_data['meta_description'] = "SmartCard Market is free to sign up, "
                    . "post a project, receive bids from Sellers, review the Seller's "
                    . "portfolio and discuss the project requirements. There are absolutely "
                    . "no charges for you the Buyer.";
            $this->page_data['meta_keywords'] = 'card printing and shipping services, Smart card '
                    . 'suppliers, greeting card suppliers, supplier comparison card printing '
                    . 'services, card manufactures, Plastic card manufactures';
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('static/fees', $this->page_data);
        } elseif ($data == 'user_agreement') {
            $this->page_data['page_title'] = 'User Agreement | SMARTCardMarket.com';
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_blank');
            $this->load->view('static/user_agreement', $this->page_data);
        } elseif ($data == 'find_supplier_now') {
            $this->page_data['page_title'] = 'Find Supplier Now | SMARTCardMarket.com';
            $arr = array();
            if ($this->input->get()) {
                $arr['country_id'] = $this->input->get('country');
                $arr['sub_cat_id'] = $this->input->get('sub-category');
                $arr['region_id'] = $this->input->get('region');
                $catid = $this->input->get('category');
                $this->page_data['sub_categories'] = $this->General_model->get_sub_categories_by_catid($catid);
            }
          
            $this->page_data['filtered_sellers_list'] = $this->User_model->get_filtered_sellers($arr);
            $this->page_data['categories'] = $this->General_model->get_all_categories();
            $this->page_data['countries'] = $this->Base_model->get_all('country');
            $this->page_data['regions'] = $this->Base_model->get_all('regions');
           
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header_dashboard', $this->page_data);
            $this->load->view('static/find_supplier_now', $this->page_data);
        } else {
            $this->load->view('templates/head', $this->page_data);
            $this->load->view('templates/header');
            $this->load->view('page_not_found');
        }
        $this->load->view('templates/footer');
        $this->load->view('templates/bottom');
    }

}
