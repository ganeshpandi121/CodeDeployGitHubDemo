<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| WARNING: You MUST set this value!
|
| If it is not set, then CodeIgniter will try guess the protocol and path
| your installation, but due to security concerns the hostname will be set
| to $_SERVER['SERVER_ADDR'] if available, or localhost otherwise.
| The auto-detection mechanism exists only for convenience during
| development and MUST NOT be used in production!
|
| If you need to allow multiple domains, remember that this file is still
| a PHP script and you can easily do that on your own.
|
*/

$config['version'] = '20160626';

if (ENVIRONMENT == "production") {
    $config['zoho_auth'] = "131b53b675a156dccc1e82a7295e0cd0";
}else{
    $config['zoho_auth'] = "77590d2ab16f0975e51696bc80520fbb";
}

if (ENVIRONMENT == "production") {
    $config['admin_email'] = 'info@smartcardmarket.com';
    $config['admin_cc'] = 'ben@cardcoregroup.com';
    $config['admin_bcc'] = 'adam@121outsource.com';

}else{
    $config['admin_email'] = 'achar.madhwa@gmail.com';
    $config['admin_cc'] = 'smartcardmarket1@gmail.com';
    $config['admin_bcc'] = 'smartcardmarket2@gmail.com';
}
$config['newproject_email'] = 'newproject@smartcardmarket.com';
$config['buyer_email'] = 'buyer@smartcardmarket.com';
$config['seller_email'] = 'seller@smartcardmarket.com';
$config['auto_email'] = 'no-reply@smartcardmarket.com';
$config['website_name'] = 'smartcardmarket.com';
$config['email_name'] = 'SmartCardMarket';
$config['email_team'] = 'The SmartCardMarket Team';
$config['job_history_desc'] = array(
    'quote_request' => 'Quote Request Submitted',
    'quote_allocated' => 'Quote Request Allocated to Seller By Administrator',
    'supplier_quote_submit' => 'Quote Submitted By Seller To This Job',
    'supplier_quote_approval' => 'Seller Quote Has Been Approved By Buyer',
    'freight_ready' => 'Freight Is Ready',
    'freight_request' => 'Freight Request Submitted',
    'freight_quote_submit' => 'Freight Quote Submitted',
    'supplier_edit_quote_submit' => 'Seller Quote Has Been Edited By Seller',
    'freight_allocated' => 'Freight Request Allocated to Freight Forwarders By Administrator',
    'freight_quote_approval' => 'Freight Forwarder Quote Has Been Approved By User',
    'completed' => 'Order Has Been Completed By Buyer',
    'cancelled' => 'Project Has Been Cancelled',
    're-ordered' => 'Project Has Been Re-ordered',
    're-activated' => 'Project Has Been Re-activated',
    'quote_deallocated' => 'Project Has Been De-allocated By Administrator',
    'seller_quote_deactivated' => 'Seller Quote Has Been De-activated',
    'quote_request_edited' => 'Quote Request Has Been Edited',
);
$config['notification_desc'] = array(
    'quote_request_allocated' => 'Quote request has been allocated',
    'job_updates_submitted' => 'You have one update on this Job',
    'seller_quote_submitted' => 'You have one notification on this job - one seller has been quoted',
    'seller_quote_rank_updated' => 'Your rank has been updated for this job'
);

