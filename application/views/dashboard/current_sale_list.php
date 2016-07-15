<div class="container-fluid">
    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#current-sale">Current Sale</a></li>
                <li>
                    <a href="<?php echo base_url('dashboard/current-purchases');?>"> Current Purchase</a>
                </li>
                
            </ul>
            <div class="tab-content">
                <div id="current-sale" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-md-6 "> <h2><?php echo ($page_title != '') ? $page_title : '';?></h2></div>
                        <div class="col-md-6 ">
                            <br/>
                            <div class="form-inline pull-right">
                                <?php
                                echo form_open(base_url() . 'dashboard/current-sales', array('id' => 'search_order_form', 'method' => 'get'));
                                $search_term = !empty($search_term) ? $search_term : '';
                                echo form_input('search_term', $search_term, array('id' => 'search_term', 'placeHolder' => 'Search Job Here', 'style' => 'width:350px;'));
                                ?>
                                <?php echo form_submit('search', 'Search', array('class' => 'btn btn-primary form-control', 'type' => 'submit')); ?>

                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <?php if($this->session->userdata('user_type_id') == 2 && 
                                   $this->session->userdata('is_transformed') == 0){?>
                            <a class="btn btn-warning btnView" href="<?php echo base_url('dashboard/become_seller');?>">Become a Seller </a>
                        <?php }else{?>
                            <?php if (!empty($current_sale_list)) { ?>
                            <table class="table table-striped">
                                <thead >
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Project Name</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Project Lead Time</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = (($page_num - 1) * $this->page_data['per_page']);
                                    foreach ($current_sale_list as $key => $list) {
                                        ?>
                                        <tr>
                                            <td><?php echo "#" . $list->job_id; ?></td>
                                            <td><?php echo $list->job_name; ?></td>
                                            <td><?php echo $list->product_quantity; ?></td>
                                            <td class="text-info"><?php echo $list->job_status_name; ?></td>
                                            <td><?php echo date("F j, Y", $list->created_date); ?></td>
                                            <td>
                                                <?php $time_class = (time() < $list->product_lead_time) ? "text-success" : "text-danger" ?>
                                                <b class="<?php echo $time_class; ?>">
                                                    <script>
                                                        document.write(moment('<?php echo date("Y-m-d H:i", $list->product_lead_time); ?>').endOf('minutes').fromNow())
                                                    </script>
                                                </b> <br/>
                                                <?php echo date("F j, Y", $list->product_lead_time); ?>
                                            </td>
                                            <td><a class="btn btn-blue" href="<?php echo base_url() . "dashboard/order/view/" . $list->job_id; ?>">View </a></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">                               
                                        <ul class="pagination">
                                            <?php echo $pagination_helper->create_links(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                               <br>
                               <div class="alert alert-info">
                                   <strong>Info!</strong> You don't have any current sale.
                               </div>
                           <?php }?>
                        <?php }?>
                        </div>        
                    </div>
                </div>
            </div><br/>
        </div>
    </div>                    
  </div>
</div>