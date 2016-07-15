<div class="container-fluid">
    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs">
                <li><a href="<?php echo base_url('dashboard/completed-sales');?>">Completed Sale</a></li>
                <li class="active"> <a  href="#completed-purchase">Completed Purchase</a></li>
            </ul>
            <div class="tab-content">
                <div id="completed-purchase" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-md-6 ">
                            <h2><?php echo ($page_title != '') ? $page_title : '';?></h2>
                        </div>
                        <div class="col-md-6 ">
                            <br/>
                            <div class="form-inline pull-right">
                                <?php
                                echo form_open(base_url() . 'dashboard/completed-purchases', array('id' => 'past_order_search_form', 'method' => 'get'));
                                $search_term = !empty($search_term) ? $search_term : '';
                                echo form_input('search_term', $search_term, array('id' => 'search_term', 'placeHolder' => 'Search Job Here', 'style' => 'width:350px;'));
                                ?>
                                <?php echo form_submit('search', 'Search', array('class' => 'btn btn-primary form-control', 'type' => 'submit')); ?>

                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
            <div class="row">
                <div class="col-md-12 ">
                    <?php if($this->session->userdata('user_type_id') == 3 && 
                              $this->session->userdata('is_transformed') == 0){?>
                        <a class="btn btn-warning btnView" href="<?php echo base_url('dashboard/become_buyer');?>">Become a Buyer </a>
                <?php }else{?>
                    <?php if (!empty($completed_purchase_list)) { ?>
                        <table class="table table-striped">
                            <thead >
                                <tr>
                                    <th>Order ID</th>
                                    <th>Project Name</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Completed Time</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = (($page_num - 1) * $this->page_data['per_page']);
                                foreach ($completed_purchase_list as $key => $list) {
                                    ?>
                                    <tr>
                                        <td><?php echo "#" . $list->job_id; ?></td>
                                        <td><?php echo $list->job_name; ?></td>
                                        <td><?php echo $list->product_quantity; ?></td>
                                        <td class="text-info"><?php echo $list->job_status_name; ?></td>
                                        <td><?php echo date("F j, Y", $list->created_date); ?></td>
                                        <td>
                                            <?php echo date("F j, Y", $list->completed_time); ?>
                                        </td>
                                        <td><a class="btn btn-blue" href="<?php echo base_url() . "dashboard/order/completed-view/" . $list->job_id; ?>">View </a></td>
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
                                <br/>
                                <div class="alert alert-info">
                                    <strong>Info!</strong> You don't have any completed purchase.
                                </div>
                            <?php } ?>
                        <?php } ?>
                      </div>
                    </div>
                </div>
            </div><br/>
        </div>
    </div>
</div>
