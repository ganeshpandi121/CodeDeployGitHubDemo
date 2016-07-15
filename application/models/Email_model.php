<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Email_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Base_model');
        $this->load->model('General_model');
        $this->load->model('Job_model');
        $this->load->library('email');
    }

    /*

     * Parameters
     * $table (string) specifies table name
     */

    public function send_signup_mail($user_id) {

        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));

        $user = $this->Base_model->get_one_entry('users', array('user_id' => $user_id));
        $to_email = $user->email;
        $user_name = ucfirst($user->user_first_name) . " " . $user->user_last_name;
        $subject = 'Verify Your Email Address';

        $message = 'Please click on the below activation link to verify your email address.<br /><br /> <a href=' . base_url('Registration/verify/') . '/' . md5($to_email) . '>'
                . base_url('Registration/verify/') . '/' . md5($to_email);


        return $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_mail);
    }

    /**
     * 
     * @param type $user_id
     * @return type
     */
    public function send_welcome_mail($user_id) {

        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));
        $user = $this->Base_model->get_one_entry('users', array('user_id' => $user_id));

        $to_email = $user->email;
        $user_name = ucfirst($user->user_first_name) . " " . $user->user_last_name;
        $subject = 'Welcome to SmartCardMarket';

        $greeting = 'Welcome ' . $user_name . ',<br/><br/>';
        $message = ' Thank you for signing up with www.SMARTCardMarket.com.<br/><br/>'
                . ' To login, simply click <a href=' . base_url() . '>here</a><br/><br/>'
                . ' Good Luck <br/><br/>'
                . ' Warm Regards, <br/>'
                . ' SmartCardMarket Support Team';

        if ($user->user_type_id == 2) {
            array_push($cc_mail, $this->config->item('buyer_email', 'smartcardmarket'));
        } else if ($user->user_type_id == 3) {
            array_push($cc_mail, $this->config->item('seller_email', 'smartcardmarket'));
        }

        return $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_mail, '', $greeting);
    }

    /**
     * 
     * @param type $to_email
     * @return type
     */
    public function send_forgot_mail($to_email) {

        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));

        $user = $this->Base_model->get_one_entry('users', array('email' => $to_email));
        $user_name = $user->user_first_name;
        $subject = 'Password Reset';
        $message = 'Please click on the below reset password link to reset your password.<br /><br /> <a href='
                . base_url() . 'User/reset_password' . '/' . md5($to_email) . '>'
                . base_url() . 'User/reset_password' . '/' . md5($to_email);


        return $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_mail);
    }

    /**
     * 
     * @param type $from_email
     * @param type $from_name
     * @param type $subject
     * @param type $msg
     * @return type
     */
    public function send_contact_mail($form_data) {
        $from_name = $form_data['first_name'] . ' ' . $form_data['last_name'];
        $from_email = $form_data['email'];
        $subject = $form_data['subject'];
        $msg = $form_data['message'];
        $to_email = $this->config->item('admin_email', 'smartcardmarket');

        $message = " One user has submitted contact form. Please see the details below.<br/>"
                . "Subject: " . $subject . "<br/>"
                . "Message: " . $msg . "<br/>"
                . "User Name: " . $from_name . "<br/>"
                . "Email: " . $form_data['email'] . "<br/>"
                . "Telephone: " .$form_data['telephone_code'].$form_data['telephone_no']. "<br/><br/><br/>"
                . "Thanks & Regards<br/>" . $from_name;

        $this->send_cc_mail_buyer($from_email, $from_name, $subject, $msg, $form_data);
        return $this->send_email($from_email, $from_name, $to_email, $subject, $message, 'Administrator');
    }

    /**
     * 
     * @param type $to_email
     * @param type $to_name
     * @param type $subject
     * @param type $msg
     */
    public function send_cc_mail_buyer($to_email, $to_name, $subject, $msg, $form_data) {
        $from_email = $this->config->item('admin_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));
        $from_name = $form_data['first_name'] . ' ' . $form_data['last_name'];
        $message = "Thank you for contacting us. Please see the entered details below.<br/> "
                . "Subject: " . $subject . "<br/>"
                . "Message: " . $msg . "<br/>"
                . "User Name: " . $from_name . "<br/>"
                . "Email: " . $form_data['email'] . "<br/>"
                . "Telephone: " .$form_data['telephone_code'].$form_data['telephone_no']. "<br/><br/><br/>"
                . "Thanks & Regards<br/>  <b>Smartcardmarket Team</b>";

        $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $to_name, $cc_mail);
    }

    /**
     * 
     * @param type $user_name
     * @param type $subject
     * @param type $message
     * @return type
     */
    public function get_template($user_name, $subject, $message, $greeting = '') {
        $mail_data['greeting'] = !empty($greeting) ? $greeting : '';
        $mail_data['user_name'] = !empty($user_name) ? $user_name : 'User';
        $mail_data['subject'] = $subject;
        $mail_data['message'] = $message;
        $get_template = $this->load->view('emails/email', $mail_data, TRUE);
        return $get_template;
    }

    /**
     * 
     * @param type $to
     * @return type
     */
    public function newsletter_subscription($to_email) {

        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));

        $subject = "Newsletter subscription";
        $msg = "Thank you for Smartcard newsletter subscription.<br/>To Unsubscribe <a href='"
                . base_url() . "User/unsubscribe" . "/" . md5($to_email) . "' target='_blank'>click here</a>";
        $message = $msg . "<br/> <b>Thanks & Regards</b><br/>" . $from_email;

        return $this->send_email($from_email, '', $to_email, $subject, $message, '', $cc_mail);
    }

    /**
     * 
     * @param type $from_email
     * @param type $from_name
     * @param type $to_email
     * @param type $subject
     * @param type $message
     * @param type $recipient_user_name
     * @param type $cc
     * @param type $bcc
     * @return type
     */
    public function send_email($from_email, $from_name = '', $to_email, $subject, $message, $recipient_user_name = '', $cc = '', $bcc = '', $greeting = '') {

        //configure email settings
        // $config['protocol'] = 'smtp';
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';

        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes

        $template = $this->get_template($recipient_user_name, $subject, $message, $greeting);

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from($from_email, $from_name);
        $this->email->to($to_email);

        $cc_insert = '';
        if (!empty($cc)) {
            $cc_insert = implode(',', $cc);
            $this->email->cc($cc);
        }

        if (!empty($bcc)) {
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($template);
        $sent = $this->email->send();

        $email_data = array(
            'from_email' => $from_email,
            'to_email' => $to_email,
            'subject' => $subject,
            'message' => $message,
            'cc_email' => $cc_insert,
            'status' => 'Queued',
            'is_active' => '1');

        $email_notify_id = $this->Base_model->insert_entry('email_notification', $email_data);
        
        if($sent == true){
           $this->Base_model->update_entry('email_notification', 
                   array('status' => 'Delivered'), 'email_notification_id', $email_notify_id); 
        }
        return $sent;
    }

    /**
     * 
     * @param type $job_id
     * @param type $user_id
     * @param type $comment
     * @param type $file_data
     * @return type
     */
    public function job_update_notify($job_id, $user_id, $comment, $file_data = array()) {

        $job_data = $this->Job_model->get_job_status($job_id);
        $job_name = $job_data->job_name;
        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $user_data = $this->General_model->get_user_data($user_id);

        $to_email = $user_data->email;
        $user_name = $user_data->first_name . ' ' . $user_data->last_name;
        $message = '';
        $cc_email = array($this->config->item('admin_email', 'smartcardmarket'));
        if (!empty($job_data)) {
            if ($job_data->job_status_name == 'Quote Request' ||
                    $job_data->job_status_name == 'Freight Request') {
                $url = base_url('dashboard/job') . '/' . $job_id;
            } else {
                $url = base_url('dashboard/order/view') . '/' . $job_id;
            }

            if ($user_data->user_type_id == '2') {
                if ($job_data->job_status_name == 'Quote Request' ||
                        $job_data->job_status_name == 'Freight Request') {
                    $message .= 'You have a new notification on <b>' . $job_name . '</b>.<br/>';
                } else if ($job_data->job_status_name == 'Order') {

                    //send consumer notifications to supplier also - cc
                    $message .= 'You have a new notification on <b>' . $job_name . '</b>.<br/>';
                    $sup_email = $this->Job_model->get_supplier_of_job($job_id)->email;
                    array_push($cc_email, $sup_email);
                    $user_name = '';
                } else if ($job_data->job_status_name == 'Freight Approved') {

                    //send consumer notifications to freight also - cc
                    $message .= 'You have a new notification on <b>' . $job_name . '</b>.<br/>';
                    $fr_email = $this->Job_model->get_freight_of_job($job_id)->email;
                    array_push($cc_email, $fr_email);
                    $user_name = '';
                }
            } else {
                //send supplier or freight notifications to consumer also - cc
                $message .= 'You have a new notification on <b>' . $job_name . '</b>.<br/>';
                $buyer = $this->Job_model->get_consumer_of_job($job_id);
                $buyer_email = !empty($buyer) ? $buyer->email : '';
                array_push($cc_email, $buyer_email);
                $user_name = '';
            }

            $subject = 'Job Update Notification - #' . $job_id . ' - ' . $job_name;

            $message .= ' <p>Comment: <b><i>' . $comment . ' </i></b>.<br/>';
            if (!empty($file_data)) {
                $message .= " One file has been uploaded.<br/> ";
            }
            $message .= ' </p>To review and respond click on the below link. <br/>'
                    . ' <a href="' . $url . '">Click here</a><br/>';

            return $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_email);
        }
    }

    /**
     * 
     * @param type $job_id
     * @param type $user_id
     * @return type
     */
    public function supplier_quote_approve_notify($job_id, $user_id) {

        $this->load->model('JobQuote_model');

        $quote_data = $this->JobQuote_model->get_approved_quote_of_order($job_id);

        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $consumer_data = $this->General_model->get_user_data($user_id);
        $consumer_name = ucfirst($consumer_data->first_name) . ' ' . $consumer_data->last_name;
        $buyer_email = $consumer_data->email;
        $cc_email = array($this->config->item('admin_email', 'smartcardmarket'));

        $message = '';
        $seller_name = ($quote_data->supplier_name != '') ? $quote_data->supplier_name : '';
        $url = base_url('dashboard/order/view') . '/' . $job_id;
        if (!empty($quote_data)) {

            $to_email = $quote_data->email;

            $subject = 'Quote Approved';
            $message .= 'Congratulations!!! Your quote has been approved by the buyer, ' . $consumer_name
                    . ' <p>Submitted Quote Details: </br>'
                    . ' Price Per Unit: $' . $quote_data->price_per_unit . '</br>'
                    . ' Project Lead Time: ' . date("F j, Y", $quote_data->lead_time) . '</br>'
                    . ' Total Order: $' . $quote_data->total_order . '</br>';
            $message .= ' </p>For more details click on the below link. <br/>'
                    . ' <a href="' . $url . '">Click here</a><br/>';

            $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $seller_name, $cc_email);
        }
        $ccmessage = '';
        if (!empty($buyer_email)) {

            $subject = 'Quote Approved';
            $ccmessage .= 'You have been approved one quote from the seller, ' . $seller_name
                    . ' <p>Approved Quote Details: </br>'
                    . ' Price Per Unit: $' . $quote_data->price_per_unit . '</br>'
                    . ' Project Lead Time: ' . date("F j, Y", $quote_data->lead_time) . '</br>'
                    . ' Total Order: $' . $quote_data->total_order . '</br>';
            $ccmessage .= ' </p>For more details click on the below link. <br/>'
                    . ' <a href="' . $url . '">Click here</a><br/>';

            $this->send_email($from_email, 'Smartcardmarket', $buyer_email, $subject, $ccmessage, $consumer_name, $cc_email);
        }
        return;
    }

    /**
     * 
     * @param type $job_id
     * @param type $user_id
     * @return type
     */
    public function freight_quote_approve_notify($job_id, $user_id) {

        $this->load->model('JobFreight_model');

        $quote_data = $this->JobFreight_model->get_approved_freight_quote_of_order($job_id);
        $consumer_data = $this->General_model->get_user_data($user_id);
        $consumer_name = ucfirst($consumer_data->first_name) . ' ' . $consumer_data->last_name;
        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'), $consumer_data->email);

        $message = '';
        if (!empty($quote_data)) {
            $user_name = $quote_data->freight_name;
            $to_email = $quote_data->email;

            $subject = 'Quote Approved';

            $url = base_url('dasboard/order/view') . '/' . $job_id;
            $message .='Congratulations!!! Your quote has been approved by the buyer, ' . $consumer_name
                    . ' <p>Submitted Quote Details: </br>'
                    . ' Total Shipment Cost ex. Tax: $' . $quote_data->shipment_total_cost_ex_tax . '</br>'
                    . ' Transit Time: ' . date("F j, Y", $quote_data->transit_time) . '</br>'
                    . ' Total Shipment Cost inc. Tax: $' . $quote_data->shipment_total_cost_ex_tax . '</br>';
            $message .= ' </p>For more details click on the below link. <br/>'
                    . ' <a href="' . $url . '">Click here</a><br/>';
        }

        return $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_email);
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function job_status_change_notify($job_id) {

        $job_data = $this->Job_model->get_job_data($job_id);
        $user_data = $this->Job_model->get_consumer_of_job($job_id);

        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_email = array($this->config->item('admin_email', 'smartcardmarket'));
        $to_email = $user_data->email;
        $user_name = $user_data->user_first_name . ' ' . $user_data->user_last_name;
        $message = '';
        if (!empty($job_data)) {
            $urgent = ($job_data->is_urgent == 1) ? "Yes" : "No";
            $sealed = ($job_data->is_sealed == 1) ? "Yes" : "No";
            $sample = ($job_data->is_sample_required == 1) ? "Yes" : "No";

            if ($job_data->job_status_name == 'Quote Request' ||
                    $job_data->job_status_name == 'Cancelled' ||
                    $job_data->job_status_name == 'Freight Request') {
                $url = base_url('dashboard/job') . '/' . $job_id;
            } else if ($job_data->job_status_name == 'Order') {
                $url = base_url('dashboard/order/view') . '/' . $job_id;
            } else if ($job_data->job_status_name == 'Completed') {
                $url = base_url('dashboard/order/completed-view') . '/' . $job_id;
            }

            $subject = 'Job Status Change Notification';
            //send  notifications to consumer
            $message .= 'You have one notification on one of your submitted requirement.<br/>'
                    . ' Job status has been changed to <b>' . $job_data->job_status_name . '</b><br/>'
                    . ' Please see below details.</br>';

            $message .= '<br/><p>Job Details: <br/>'
                    . ' Project Name: ' . $job_data->job_name . ' <br/>'
                    . ' Category: ' . $job_data->category_name . '<br/> '
                    . ' Subcategory: ' . $job_data->sub_category_name . '<br/> '
                    . ' Project Overview: ' . $job_data->job_overview . ' <br/>'
                    . ' Project Lead Time: ' . date("F j, Y", $job_data->product_lead_time) . '<br/> '
                    . ' Product Quantity: ' . $job_data->product_quantity . '<br/> '
                    . ' Budget: $' . $job_data->budget . '<br/> '
                    . ' Project Details: ' . $job_data->note . '<br/> '
                    . ' Special Requirements: ' . $job_data->special_requirement . '<br/> '
                    . ' Urgent: Requires 24 hour start time, quotes need Immediately: ' . $urgent . '<br/> '
                    . ' Sealed/Tender: ' . $sealed . '<br/> '
                    . ' Sample Required: ' . $sample . '<br/> ';

            $message .= ' </p>For more details click on the below link.  <br/>'
                    . ' <a href="' . $url . '">Click here</a><br/>';

            return $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_email);
        }
    }

    /**
     * 
     * @param type $job_id
     * @return type
     */
    public function job_submit_notify($job_id) {

        $job_info = $this->Job_model->get_job_details($job_id);
        $user_data = $job_info['user_data'];
        $job_data = $job_info['job_data'];

        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $to_email = $user_data->email;
        $cc_mail = array(
            $this->config->item('newproject_email', 'smartcardmarket'),
            $this->config->item('admin_email', 'smartcardmarket')
        );
        $user_name = $user_data->user_first_name . ' ' . $user_data->user_last_name;
        $message = '';


        if (!empty($job_data)) {
            $url = base_url('dashboard/job') . '/' . $job_id;
            $urgent = ($job_data->is_urgent == 1) ? "Yes" : "No";
            $sealed = ($job_data->is_sealed == 1) ? "Yes" : "No";
            $sample = ($job_data->is_sample_required == 1) ? "Yes" : "No";

            //send  notifications to buyer
            $subject = 'Job Submitted';

            $message .= 'You have successfully submitted your requirement.<br/>'
                    . ' Please see below job details.</br>';

            $message .= '<br/><p>Job Details: <br/>'
                    . ' Project Name: ' . $job_data->job_name . ' <br/>'
                    . ' Category: ' . $job_data->category_name . '<br/> '
                    . ' Subcategory: ' . $job_data->sub_category_name . '<br/> '
                    . ' Project Overview: ' . $job_data->job_overview . ' <br/>'
                    . ' Project Lead Time: ' . date("F j, Y", $job_data->product_lead_time) . '<br/> '
                    . ' Product Quantity: ' . $job_data->product_quantity . '<br/> '
                    . ' Budget: $' . $job_data->budget . '<br/> '
                    . ' Project Details: ' . $job_data->note . '<br/> '
                    . ' Special Requirements: ' . $job_data->special_requirement . '<br/> '
                    . ' Urgent: Requires 24 hour start time, quotes need Immediately: ' . $urgent . '<br/> '
                    . ' Sealed/Tender: ' . $sealed . '<br/> '
                    . ' Sample Required: ' . $sample . '<br/> ';

            $message .= ' </p>For more details click on the below link. <br/>'
                    . ' <a href="' . $url . '">Click here</a><br/>';

            return $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_mail);
        }
    }

    /**
     * 
     * @param type $seller_id
     * @return type
     */
    public function demo_seller_notify($seller_id) {
        $this->load->model('Supplier_model');
        $user_data = $this->Supplier_model->get_supplier_data($seller_id);

        $to_email = $this->config->item('admin_email', 'smartcardmarket');
        $cc_mail = array(
            $this->config->item('admin_cc', 'smartcardmarket'),
            $this->config->item('admin_email', 'smartcardmarket')
        );
        $bcc_email = $this->config->item('admin_bcc', 'smartcardmarket');
        $message = '';
        if (!empty($user_data)) {
            $from_email = $user_data->email;
            $user_name = $user_data->first_name . ' ' . $user_data->last_name;

            //send  notifications to buyer
            $subject = 'Seller Request For Live Account';

            $message .= 'One seller has been requested to change the account type from demo to live.<br/>'
                    . 'Please see the user details below.<br/><br/>'
                    . 'User Information:<br/>'
                    . 'Seller Name: ' . $user_name . '<br/>'
                    . 'Email: ' . $user_data->email . '<br/>'
                    . 'Contact Number: ' . $user_data->telephone_code . $user_data->telephone_no;

            return $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, 'Administrator', $cc_email, $bcc_email);
        }
    }

    /**
     * Methos to notify seller when job is allocated to a seller, using job_id or seller_id
     * @param type $job_id
     * @return type
     */
    public function job_allocation_notify($job_id = '', $seller_id = '') {

        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $this->load->model('Supplier_model');
        $job_data = $this->Job_model->get_job_data($job_id);
        $job_sellers = $this->Supplier_model->get_sellers_of_job($job_id);
        $message = '';
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));

        if (!empty($job_data) && !empty($job_sellers)) {
            $urgent = ($job_data->is_urgent == 1) ? "Yes" : "No";
            $sealed = ($job_data->is_sealed == 1) ? "Yes" : "No";
            $sample = ($job_data->is_sample_required == 1) ? "Yes" : "No";

            $url = base_url('dashboard/job') . '/' . $job_id;

            //send  notifications to buyer
            $subject = 'Project Allocated';

            $message .= 'You have received a request to quote on a new project.<br/>'
                    . ' Please see detailed information below.</br>';

            $message .= '<br/><p>Project Details: <br/>'
                    . ' Project Name: ' . $job_data->job_name . ' <br/>'
                    . ' Category: ' . $job_data->category_name . '<br/> '
                    . ' Subcategory: ' . $job_data->sub_category_name . '<br/> '
                    . ' Project Overview: ' . $job_data->job_overview . ' <br/>'
                    . ' Project Lead Time: ' . date("F j, Y", $job_data->product_lead_time) . '<br/> '
                    . ' Product Quantity: ' . $job_data->product_quantity . '<br/> '
                    . ' Budget: $' . $job_data->budget . '<br/> '
                    . ' Project Details: ' . $job_data->note . '<br/> '
                    . ' Special Requirements: ' . $job_data->special_requirement . '<br/> '
                    . ' Urgent: Requires 24 hour start time, quotes need Immediately: ' . $urgent . '<br/> '
                    . ' Sealed/Tender: ' . $sealed . '<br/> '
                    . ' Sample Required: ' . $sample . '<br/> ';

            $message .= ' </p>For further information regarding this request '
                    . 'and to post your quotation, <br/>'
                    . ' <a href="' . $url . '">Click here</a><br/>';

            foreach ($job_sellers as $seller) {
                $to_email = $seller->email;
                $user_name = $seller->user_first_name . ' ' . $seller->user_last_name;
                $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_mail);
            }
        }
    }

    public function seller_quote_buyer_notify($job_id, $jq_id, $seller_id) {

        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));

        $this->load->model('Job_model');
        $this->load->model('JobQuote_model');
        $buyer_info = $this->Job_model->get_consumer_of_job($job_id);
        $to_email = $buyer_info->email;
        $user_name = ucfirst($buyer_info->user_first_name) . ' ' . $buyer_info->user_last_name;
        //Adding notifications
        $notify_desc = $this->config->item('notification_desc', 'smartcardmarket')['seller_quote_submitted'];
        $this->Job_model->add_notification($buyer_info->user_id, $seller_id, $job_id, $notify_desc);

        $seller_quote_data = $this->JobQuote_model->get_seller_quote_data($jq_id);
        $message = '';

        if (!empty($seller_quote_data)) {
            $pre_sample = ($seller_quote_data->pre_approved_sample == 1) ? "Yes" : "No";
            $url = base_url('dashboard/job') . '/' . $job_id;
            //send  notifications to buyer
            $subject = 'Seller Quote Submitted';

            $message = 'You have received a seller quote on your project, Project ID: #' . $job_id . '.<br/>'
                    . ' Please see detailed information below.</br>';

            $message .= '<br/><p>Quote Details: <br/>'
                    . ' Unit Volume: ' . $seller_quote_data->unit_volume . ' <br/>'
                    . ' Price Per Unit: $' . $seller_quote_data->price_per_unit . '<br/> '
                    . ' Total Order (ex Tax): $' . $seller_quote_data->total_order . '<br/> '
                    . ' Currency: ' . $seller_quote_data->currency_name . ' <br/>'
                    . ' Payment Terms: ' . $seller_quote_data->payment_term . '<br/> '
                    . ' Project Lead Time: ' . date("F j, Y", $seller_quote_data->lead_time) . '<br/> '
                    . ' Incoterms: ' . $seller_quote_data->incoterm_name . '<br/> '
                    . ' Pre Approved Sample: ' . $pre_sample . '<br/> '
                    . ' Sample Lead Time: ' . date("F j, Y", $seller_quote_data->sample_lead_time) . '<br/> '
                    . ' Additional Information: ' . $seller_quote_data->additional_information . '<br/> ';

            $message .= ' </p>For further information regarding this, <br/>'
                    . ' <a href="' . $url . '">Click here</a><br/>';

            $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_mail);
        }
    }

    public function seller_quote_notify($job_id) {
        $this->load->model('User_model');
        $this->load->model('Supplier_model');
        $this->load->model('Job_model');
        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));

        $admin_id = $this->User_model->get_admin_id($job_id);
        $notify_desc = $this->config->item('notification_desc', 'smartcardmarket')['seller_quote_rank_updated'];
        $quoted_sellers = $this->Supplier_model->get_seller_quotes_of_job($job_id);
        if (!empty($quoted_sellers)) {

            $url = base_url('dashboard/job') . '/' . $job_id;

            $subject = 'Quote Rank Has Been Updated';

            foreach ($quoted_sellers as $sellers) {
                $to_email = $sellers->email;
                $user_name = ucfirst($sellers->user_first_name) . ' ' . $sellers->user_last_name;
                $message = 'You have received a notification on one of your quote, '
                        . '<b>Project ID: #' . $job_id . '</b>.'
                        . ' Now you have been ranked as ' . $sellers->rank . '.<br/>';
                $message .= ' </p>To edit your submitted quote, <br/>'
                        . ' <a href="' . $url . '">Click here</a><br/>';
                //Adding notifications
                $this->Job_model->add_notification($sellers->user_id, $admin_id, $job_id, $notify_desc);

                $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_mail);
            }
        }
    }

    /**
     * 
     * @param type $chat_notify_id
     */
    public function chat_email_notification($chat_notify_id) {
        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));

        $chat_data = $this->User_model->get_chat_notification_data($chat_notify_id);

        if (!empty($chat_data)) {

            $url = base_url('dashboard/job') . '/' . $chat_data->job_id;

            $subject = 'Chat Notification';

            $to_email = $chat_data->to_user_email;
            $to_user_name = ucfirst($chat_data->to_user_first_name) . ' ' . $chat_data->to_user_last_name;
            $from_user = $chat_data->from_first_user_name . ' ' . $chat_data->from_last_user_name;
            $message = '<b>' . $from_user . '</b> has contacted to you through chat. <br/> ';
            $message .= '<p>Message: ' . $chat_data->description . '<br/>';

            /* $message .= '<br/><p>User Details: <br/>'
              .' User\'s Name: '.$chat_data->from_first_user_name.' '.$chat_data->from_last_user_name.'<br/>'
              .' User\'s Email: ' .  $chat_data->from_user_email . '<br/> '; */

            $message .= ' </p>To review and respond click on the below link.<br/> '
                    . ' <a href="' . $url . '">Click here</a><br/>';

            $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $to_user_name, $cc_mail);
        }
    }

    /**
     * 
     * @param type $sd_id
     * @param type $requested_user_id
     * @param type $request_type
     */
    public function find_supplier_email($sd_id, $requested_user_id, $request_type, $un_registered_seller, $email_message = '') {
        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));

        $this->load->model('Supplier_model');
        $this->load->model('User_model');
        if($un_registered_seller == 1){
            $seller_data = $this->Supplier_model->get_unregistered_supplier_data($sd_id);
        }else{
            $seller_data = $this->Supplier_model->get_supplier_data('',$sd_id);
        }
        $contacted_person_type = $this->Base_model->get_one_entry('users', array('user_id' => $requested_user_id))->user_type_id;
        $contacted_person_info = $this->User_model->get_user_full_info($requested_user_id, $contacted_person_type);

        if (!empty($seller_data)) {
            $to_email = $seller_data->email;
            $seller_name = ucfirst($seller_data->company_name);
            if(!empty($seller_data->first_name)){
                $seller_name = ucfirst($seller_data->first_name) . ' ' . $seller_data->last_name;
            }
            $contacted_name = $contacted_person_info->first_name.' '.$contacted_person_info->last_name ;
            if ($request_type == 1) {
                $subject = 'Email Enquiry from SMARTCardMarket.com';
                $message = 'Please find email enquiry from '. $contacted_name .', see below:<br/>';
                if(!empty($email_message)){
                    $message .= $email_message;
                    $message .= '<br/><p>See below for email details <br/>'
                        . ' Name: ' . $contacted_name . '<br/>'
                        . ' Email: ' . $contacted_person_info->email . '<br/> '
                        . ' Phone: ' . $contacted_person_info->telephone_code . ' ' . $contacted_person_info->telephone_no . '<br/> '
                        . ' Company: ' . $contacted_person_info->company_name . '<br/> ';
                }
            } else {
                $subject = 'Request a Call Enquiry from SMARTCardMarket.com';

                $message = 'You have received a \'Request a Call Back Enquiry\' 
                            from www.smartcardmarket.com.';

                $message .= '<br/><p>If you can call this enquiry back at the '
                        . 'earliest available opportunity, details below: <br/>'
                        . ' Name: ' . $contacted_name . '<br/>'
                        . ' Phone: ' . $contacted_person_info->telephone_code . ' ' . $contacted_person_info->telephone_no . '<br/> '
                        . ' Company: ' . $contacted_person_info->company_name . '<br/> '
                        . ' Email: ' . $contacted_person_info->email . '<br/> '
                        . ' Country: ' . $contacted_person_info->country_name . '<br/> ';
            }
            $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $seller_name, $cc_mail);
        }
    }
    
    /*
    public function send_sla_reminder(){
        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_email', 'smartcardmarket'));
        
        $this->load->model('Job_model');
        $jobs_to_be_remindered = $this->Job_model->get_jobs_to_be_remindered();
        
        if(!empty($jobs_to_be_remindered)){
            $subject = 'Reminder';
            foreach ($jobs_to_be_remindered as $job_id =>$job_data) {
                $url = base_url('dashboard/job') . '/' . $job_id;
                //$buyer_id = $job_data['job_buyer']['user_id'];
                $buyer_name = ucfirst($job_data['job_buyer']['user_first_name']).' '.$job_data['job_buyer']['user_last_name'];
                
                $buyer_to_email = $job_data['job_buyer']['email'];
                $message = 'You have received a notification on one of your project, '
                            . '<b>Project ID: #' . $job_id . '</b>.'
                            . ' <a href="' . $url . '">Click here</a><br/>';
                $this->send_email($from_email, 'Smartcardmarket', $buyer_to_email, $subject, $message, $buyer_name, $cc_mail);
                if(!empty($job_data['job_sellers'])){
                    foreach ($job_data['job_sellers'] as $sellers) {

                        $to_email = $sellers['email'];
                        $user_name = ucfirst($sellers['user_first_name']). ' ' .$sellers['user_last_name'];
                        $message = 'You have received a reminder on one of your allocated project, '
                                . '<b>Project ID: #' . $job_id . '</b>.';
                        $message .= ' </p>To submit quote for this project, <br/>'
                                . ' <a href="' . $url . '">Click here</a><br/>';

                        $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, $user_name, $cc_mail);
                    }
                }
            }
        }
        
    }
*/
    public function notify_user_transformation($user_id, $transformed_user_type){
        $user_data = $this->General_model->get_user_data($user_id);
        $from_email = $this->config->item('auto_email', 'smartcardmarket');
        $to_email = $this->config->item('admin_email', 'smartcardmarket');
        $cc_mail = array($this->config->item('admin_cc', 'smartcardmarket'));
        
        $message = '';
        if (!empty($user_data)) {
            $from_email = $user_data->email;
            $user_name = $user_data->first_name . ' ' . $user_data->last_name;

            //send  notifications to buyer
            $subject = 'User Has Become '.$transformed_user_type;

            $message .= 'Following user has become '.$transformed_user_type.'.<br/>'
                    . 'Please see the user details below.<br/><br/>'
                    . 'User Information:<br/>'
                    . 'User Name: ' . $user_name . '<br/>'
                    . 'Email: ' . $user_data->email . '<br/>';

            return $this->send_email($from_email, 'Smartcardmarket', $to_email, $subject, $message, 'Administrator', $cc_mail);
        }
    }
}
