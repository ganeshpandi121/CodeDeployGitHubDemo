<div class="container-fluid main-menu">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <ul class="nav navbar-nav">
                    <li style="background: #fff;"> <a style="padding:0 15px 0 10px" href="<?php echo $this->config->base_url(); ?>"><?php echo img('styles/images/logo.png', '', array('alt' => 'Logo', 'height' => '52', 'padding' => '0')); ?>          
                        </a> </li>
                    <?php
                    $noti_active_class = !empty($notification_count) ? 'notification-active' : 'notification';
                    $chat_noti_active_class = !empty($chat_notification_count) ? 'notification-active' : 'notification';
                    if ($user_type_id == 2 || 
                            ($user_type_id == 3 && $this->session->userdata('is_transformed'))) { ?>
                        <li>
                            <a href="<?php echo $this->config->base_url(); ?>dashboard/post-a-requirement">
                                Request For Quote
                            </a>
                        </li>
                    <?php }
                        if($user_type_id == 2){
                            $dashboard_url = "dashboard/my-projects";
                            $current_order_url = "dashboard/current-purchases";
                            $complete_order_url = "dashboard/completed-purchases";
                        }else if($user_type_id == 3){
                            $dashboard_url = "dashboard/my-bids";
                            $current_order_url = "dashboard/current-sales";
                            $complete_order_url = "dashboard/completed-sales";
                        }
                    ?>
                    <?php if ($user_type_id == 2 ||  $user_type_id == 3 ){?>
                        <li><a href="<?php echo $this->config->base_url($dashboard_url); ?>">Quote Requests</a></li>
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Orders <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo $this->config->base_url($current_order_url); ?>">
                                        Current Orders
                                    </a>
                                </li>
                                <?php if($user_type_id == 2 || 
                                ($user_type_id == 3 && $this->session->userdata('is_transformed') == 1)){?>
                                    <li>
                                        <a href="<?php echo $this->config->base_url(); ?>dashboard/past-order-list"> 
                                            Past Orders
                                        </a>
                                    </li>
                                <?php }?>
                                <li>
                                    <a href="<?php echo $this->config->base_url($complete_order_url); ?>">
                                        Completed Orders
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php } ?>
                    <?php
                    //if ($user_type_id == 3) { ?>
                       <!-- <li><a href="<?php //echo $this->config->base_url(); ?>user-dashboard">Quotes</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Orders <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php //echo $this->config->base_url(); ?>dashboard/orders-list">Current Orders</a>
                                </li>
                                <li>
                                    <a href="<?php //echo $this->config->base_url(); ?>dashboard/completed-order-list">Completed Orders
                                    </a>
                                </li>
                            </ul>
                        </li>-->
                    <?php //}
                    ?>
                    <?php
                    if ($user_type_id == 4) {
                        ?>
                        <li><a href="<?php echo $this->config->base_url(); ?>dashboard">Freight Quotes</a></li>     
                        <li><a href="<?php echo $this->config->base_url(); ?>dashboard/orders-list">Current Orders</a></li>

                    <?php }
                    ?>
                    <?php if ($user_type_id == 1) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $this->config->base_url(); ?>admin/buyers">Buyers</a></li>
                                <li><a href="<?php echo $this->config->base_url(); ?>admin/sellers">Sellers</a></li>
                            </ul>

                        </li>
                        <li><a href="<?php echo $this->config->base_url(); ?>admin/projects">Job Quotes</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Orders <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $this->config->base_url(); ?>admin/orders">Current Orders</a></li>
                                <li><a href="<?php echo $this->config->base_url(); ?>admin/past_orders">Past Orders</a></li>
                                <li><a href="<?php echo $this->config->base_url(); ?>admin/completed_orders">Completed Orders</a></li>
                            </ul>

                        </li>
                        <!--  <li><a href="<?php echo $this->config->base_url(); ?>dashboard">Freight Quotes</a></li>          
                        <li><a href="<?php echo $this->config->base_url(); ?>dashboard">Freight Orders</a></li>
                        <li><a href="<?php echo $this->config->base_url(); ?>dashboard">Payments</a></li>-->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Settings 
                                <span class="caret"></span>
                            </a>
                            
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Content</li>
                                <li><a href="<?php echo base_url() . 'news' ?>">News</a></li>
                                <li class="dropdown-header">Content</li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/view-content">
                                        All News
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>news/product_list">
                                        All Product
                                    </a>
                                </li>
                               
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/content">
                                        Add Content
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/news_comment_list">
                                        News Comments
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/view-category">
                                        All Content Category
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/news-category">
                                        Add Content Category</a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/view-subcategory">
                                        All Content Subcategory
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/news-subcategory">
                                        Add Content Subcategory</a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/news-tags">
                                        Add Content Tags</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">Product</li>
                                 <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/view-product-category">
                                        All Product Category
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/product_category">
                                        Add Product Category</a>
                                </li>
                                 <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/view-product-subcategory">
                                        All Product Subcategory
                                    </a>
                                    <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/product_subcategory">
                                        Add Product SubCategory</a>
                                </li>

                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">Find Supplier</li>

                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/list-find-supplier">
                                        All Supplier</a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/find-supplier">
                                        Add Supplier</a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/find_supplier_requests">
                                        Find Supplier Requests</a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/find_lead_count">
                                        Find Leads Count</a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/find_lead_count_outside">
                                        Find Leads Count Outside</a>
                                </li>
                                <li>
                                    <a href="<?php echo $this->config->base_url(); ?>admin/find_supplier_job_count">
                                        Find Supplier Job Count</a>
                                </li>
                            </ul>
                        </li>
                    <?php }else{ ?>
                        <li><a href="<?php echo base_url() . 'news' ?>">News</a></li>
                        
                    <?php }?>
                        
                    <li>
                        <a class="info" href="<?php echo $this->config->base_url(); ?>find_supplier_now">
                            Find Supplier Now
                        </a>
                    </li>
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> My Account <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" ><b><?php if ($this->session->userdata('logged_in')) echo $this->session->userdata('user_name'); ?></b></a></li>
                            <li>   <a href="<?php echo base_url('user/logout'); ?>">Log out</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo $this->config->base_url(); ?>dashboard/profile">Profile</a></li>
                            <?php if ($user_type_id == 3 || 
                                    ($user_type_id == 2 && $this->session->userdata('is_transformed'))) { ?>
                                <li><a href="<?php echo $this->config->base_url(); ?>dashboard/settings">Settings</a></li> <?php } ?> <li role="separator" class="divider"></li>
                            <li>  <a>System Time  <br/><?php echo date("F j, Y g:i a ", time()); ?></a></li>
                        </ul>
                    </li>
                    <li class="<?php echo $noti_active_class; ?>" >
                        <a href="#"  data-toggle="dropdown" >
                            <span  aria-hidden="true" class="dropdown-toggle glyphicon glyphicon-bell">
                            </span>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <?php if (!empty($user_notifications)) { ?>
                                <?php foreach ($user_notifications as $notification) { ?>
                                    <li>
                                        <a href="<?php echo base_url('dashboard/job'). '/' .$notification->job_id; ?>">
                                            <?php echo $notification->description;?>
                                            <label>Order ID: <?php echo $notification->job_id; ?> </label>
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                <?php } ?>
                            <?php } ?>
                            <li>
                                <a href="<?php echo $this->config->base_url(); ?>dashboard/notifications">
                                    See All
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $chat_noti_active_class;?>"> <a href="#" data-toggle="dropdown">
                            <span  aria-hidden="true" class="glyphicon glyphicon-comment"></span> 
                        </a>
                       <?php if(!empty($user_chat_notifications)){?>
                            <ul class="dropdown-menu pull-right">
                                <?php foreach ($user_chat_notifications as $chat_notification){?>
                                    <li>
                                        <a href="<?php echo base_url('dashboard/job').'/'.$chat_notification->job_id;?>">
                                            <label>
                                                <?php echo $chat_notification->from_user_name; ?>
                                            </label><br/>
                                            <?php echo $chat_notification->description; ?>
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                </ul> 
            </div>  
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php if ($this->session->userdata('is_verified') == false) { ?>
            <div class="col-md-12">
                <div class="alert alert-danger text-center">
                    <strong>Warning!</strong> Please activate your account through email.
                </div>
            </div>
        <?php } ?>
        <?php if ($this->session->userdata('super_admin_id')) { ?>
            <div class="col-md-12 ">
                <div class="alert alert-danger text-center">
                    <strong>Note!</strong> You are now logged in as 
                    <label><?php echo $this->session->userdata('user_name'); ?></label>. 
                    Click <a href="<?php echo base_url('admin/login_as_admin'); ?>">here</a> to log in back as admin.
                </div>
            </div>
        <?php } ?>
    </div>
</div>