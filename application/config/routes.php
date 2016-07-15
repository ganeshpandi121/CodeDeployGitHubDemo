<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */


$route['Registration'] = 'Registration/index';
$route['Registration/seller-signup'] = 'Registration/seller_signup';
$route['Registration/seller-signup-complete'] = 'Registration/seller_signup_complete';
$route['user_login'] = 'User/login';
$route['forgot_password'] = 'User/forgot_password';
$route['reset_password/(:any)'] = 'User/reset_password';

$route['dashboard'] = 'dashboard';

$route['dashboard/(:num)'] = 'dashboard/index/$1';
$route['dashboard/my-bids'] = 'dashboard/user_bid_list';
$route['dashboard/my-bids/(:num)'] = 'dashboard/user_bid_list/$1';
$route['dashboard/my-projects'] = 'dashboard/user_project_list';
$route['dashboard/my-projects/(:num)'] = 'dashboard/user_project_list/$1';
$route['dashboard/current-purchases'] = 'order/user_current_purchases';
$route['dashboard/current-purchases/(:num)'] = 'order/user_current_purchases/$1';
$route['dashboard/current-sales'] = 'order/user_current_sales';
$route['dashboard/current-sales/(:num)'] = 'order/user_current_sales/$1';
$route['dashboard/completed-purchases'] = 'order/completed_purchases';
$route['dashboard/completed-purchases/(:num)'] = 'order/completed_purchases/$1';
$route['dashboard/completed-sales'] = 'order/completed_sales';
$route['dashboard/completed-sales/(:num)'] = 'order/completed_sales/$1';

$route['dashboard/become_seller'] = 'user/become_seller';
$route['dashboard/seller-process-complete'] = 'user/seller_process_complete';
$route['dashboard/become_buyer'] = 'user/become_buyer';
$route['dashboard/job/(:num)'] = 'job/index/$1';
$route['dashboard/job/chat/(:num)'] = 'chat/index/$1';
$route['dashboard/job/chat/submit_chat'] = 'chat/submit_chat';
$route['dashboard/job/submit_job_update'] = 'job/submit_job_update/$1';
$route['dashboard/job/submit_quote'] = 'job/submit_supplier_quote';
$route['dashboard/job/approve_quote/(:num)/(:num)'] = 'job/approve_quote/$1/$2';
$route['dashboard/job/reject_quote/(:num)/(:num)'] = 'job/reject_quote/$1/$2';
$route['dashboard/order'] = 'order/index';
$route['dashboard/profile'] = 'profile/index';
$route['dashboard/settings'] = 'settings/index';
$route['dashboard/submit_requirement'] = 'dashboard/submit_requirement';
$route['dashboard/orders-list'] = 'order/index';
$route['dashboard/orders-list/(:num)'] = 'order/index/$1';
$route['dashboard/order/view/(:num)'] = 'order/view_order/$1';
$route['dashboard/order/request_freight_quote/(:num)'] = 'order/request_freight_quote/$1';
$route['dashboard/order/approve_freight_quote/(:num)/(:num)'] = 'order/approve_freight_quote/$1/$2';
$route['dashboard/order/complete_job/(:num)'] = 'order/complete_job/$1';
$route['dashboard/job/submit_freight_quote'] = 'job/submit_freight_quote';
$route['dashboard/order/completed-view/(:num)'] = 'order/completed_view/$1';
$route['dashboard/job/freight_cost_submit'] = 'job/freight_cost_submit';
$route['dashboard/job/edit_shipping_address/(:num)'] = 'job/edit_shipping_address/$1';
$route['dashboard/job/view_supplier_quote'] = 'job/view_supplier_quote';
$route['dashboard/past-order-list'] = 'job/past_orders';
$route['dashboard/past-order-list/(:num)'] = 'job/past_orders/$1';
$route['dashboard/order/past-order-view/(:num)'] = 'order/past_order_view/$1';
$route['dashboard/job/cancel_job/(:num)'] = 'job/cancel_job/$1';
$route['dashboard/job/notify_demo_seller/(:num)/(:num)'] = 'job/notify_demo_seller/$1/$2';
$route['dashboard/order/re-activate'] = 'order/re_activate';
$route['dashboard/order/re-order'] = 'order/re_order';
$route['news'] = 'dashboard/news';
$route['news/(:num)'] = 'dashboard/news/$1';
$route['news_view/(:num)'] = 'dashboard/news_view/$1';
$route['news_detail/(:any)'] = 'dashboard/news_detail/$1';
$route['news_detail/(:any)/(:num)'] = 'dashboard/news_detail/$1/$2';
$route['news-comment'] = 'news/news_comment';
$route['dashboard/notifications'] = 'dashboard/get_notifications';
$route['dashboard/notifications/(:num)'] = 'dashboard/get_notifications/$1';
$route['dashboard/(:any)'] = 'dashboard/view/$1';
$route['dashboard/(:any)/(:num)'] = 'dashboard/view/$1/$2';

$route['admin/buyers/(:num)'] = 'admin/buyers/$1';
$route['admin/sellers/(:num)'] = 'admin/sellers/$1';
$route['admin/projects'] = 'admin/project_list';
$route['admin/projects/(:num)'] = 'admin/project_list/$1';
$route['admin/product_list'] = 'news/product_list';
$route['admin/product_list/(:num)'] = 'news/product_list/$1';
$route['admin/orders/(:num)'] = 'admin/orders/$1';
$route['admin/past_orders/(:num)'] = 'admin/past_orders/$1';
$route['admin/completed_orders'] = 'admin/completed_orders';
$route['admin/completed_orders/(:num)'] = 'admin/completed_orders/$1';
$route['admin/content'] = 'news/index';
$route['admin/content/(:num)'] = 'news/index/$1';
$route['admin/view-content'] = 'news/news_list';
$route['admin/view-content/(:num)'] = 'news/news_list/$1';
$route['admin/content-delete/(:num)'] = 'news/news_delete/$1';
$route['admin/news_comment_list'] = 'news/news_comment_list';
$route['admin/news_comment_list/(:num)'] = 'news/news_comment_list/$1';
$route['admin/approve_news_comment/(:num)'] = 'news/approve_news_comment/$1';
$route['admin/reject_news_comment/(:num)'] = 'news/reject_news_comment/$1';
$route['admin/delete_news_comment/(:num)'] = 'news/delete_news_comment/$1';
$route['admin/view-category'] = 'news/category_list';
$route['admin/news-category'] = 'news/category';
$route['admin/news-category/(:num)'] = 'news/category/$1';
$route['admin/news-category-delete/(:num)'] = 'news/news_category_delete/$1';
$route['admin/news-subcategory'] = 'news/subcategory';
$route['admin/news-subcategory/(:num)'] = 'news/subcategory/$1';
$route['admin/view-subcategory'] = 'news/subcategory_list';
$route['admin/news-subcategory-delete/(:num)'] = 'news/subcategory_delete/$1';
$route['admin/news-tags'] = 'news/tags';
$route['admin/list-find-supplier'] = 'admin/list_find_supplier';
$route['admin/list-find-supplier/(:num)'] = 'admin/list_find_supplier/$1';
$route['admin/find-supplier'] = 'admin/find_supplier';
$route['admin/find-supplier/(:num)'] = 'admin/find_supplier/$1';
$route['admin/find-supplier-delete/(:num)'] = 'admin/delete_find_supplier/$1';
$route['admin/find_supplier_requests/(:num)'] = 'admin/find_supplier_requests/$1';

//added by Tousif
$route['admin/find_lead_count/(:num)'] = 'admin/find_lead_count/$1';
$route['admin/find_supplier_job_count/(:num)'] = 'admin/find_supplier_job_count/$1';

$route['find_supplier_now/request/(:num)/(:num)'] = 'Contact/find_supplier_contact/$1/$2';
$route['find_supplier_now/email'] = 'Contact/compose_email';
$route['newsletter'] = 'User/newsletter';
$route['User/unsubscribe/(:any)'] = 'User/newsletter_unsubscribe/$1';
$route['ajax/get_sub_categories'] = 'ajax/get_sub_categories';

$route['admin/view-product-category'] = 'Admin/product_category_list';
$route['admin/product_category_delete/(:num)'] = 'Admin/product_category_delete/$1';
$route['admin/product_category'] = 'Admin/add_category';
$route['admin/product_category/(:num)'] = 'Admin/add_category/$1';
$route['admin/view-product-subcategory'] = 'Admin/product_subcategory_list';
$route['admin/product_subcategory_delete/(:num)'] = 'Admin/product_subcategory_delete/$1';
$route['admin/product_subcategory'] = 'Admin/add_subcategory';
$route['admin/product_subcategory/(:num)'] = 'Admin/add_subcategory/$1';
$route['contact'] = 'Contact/index';
$route['default_controller'] = 'page';
$route['(:any)'] = 'page/view/$1';
$route['404_override'] = 'page_not_found';

$route['translate_uri_dashes'] = FALSE;
