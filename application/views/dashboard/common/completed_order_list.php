<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6"> <h2>Completed Orders</h2></div>
            <div class="col-md-6 ">
                <br/>
                <div class="form-inline pull-right">
                    <?php
                    echo form_open(base_url() . 'dashboard/completed-order-list', array('id' => 'past_order_search_form', 'method' => 'get'));
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

                <?php if (!empty($buyer_corder_list)) { ?>
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
                            foreach ($buyer_corder_list as $key => $list) {
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
                <?php } else if (!empty($seller_corder_list)) { ?>
                    <table class="table table-striped">
                        <thead >
                            <tr>
                                <th>Order ID</th>
                                <th>Project Name</th>
                                <th>Company Name</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <!--<th>Rank</th>-->
                                <th>Created Date</th>
                                <th>Completed Time</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $count = (($page_num - 1) * $this->page_data['per_page']); ?>
                            <?php foreach ($seller_corder_list as $k => $item) { ?>
                                <tr>
                                    <td><?php echo "#" . $item->job_id; ?></td>
                                    <td><?php echo $item->job_name; ?></td>
                                    <td><?php echo $item->company_name; ?></td>
                                    <td><?php echo $item->product_quantity; ?></td>
                                    <td class="text-info"><?php echo $item->job_status_name; ?></td>
                                    <!--<td><?php //echo "Rank";      ?></td>-->
                                    <td><?php echo date("F j, Y", $item->created_date); ?></td>
                                    <td>
                                        <?php echo date("F j, Y", $item->completed_time); ?>
                                    </td>
                                    <td><a class="btn btn-blue" href="<?php echo base_url() . "dashboard/order/completed-view/" . $item->job_id; ?>">View </a></td>
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
                <?php } else if (!empty($completed_order_list)) { ?>
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

                            <?php $count = (($page_num - 1) * $this->page_data['per_page']); ?>
                            <?php foreach ($completed_order_list as $k => $item) { ?>
                                <tr>
                                    <td><?php echo "#" . $item->job_id; ?></td>
                                    <td><?php echo $item->job_name; ?></td>
                                    <td><?php echo $item->product_quantity; ?></td>
                                    <td class="text-info"><?php echo $item->job_status_name; ?></td>
                                    <td><?php echo date("F j, Y", $item->created_date); ?></td>
                                    <td>
                                        <?php echo date("F j, Y", $item->completed_time); ?>
                                    </td>
                                    <td><a class="btn btn-blue" href="<?php echo base_url() . "dashboard/order/completed-view/" . $item->job_id; ?>">View </a></td>
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
                        <strong>Info!</strong> You don't have any Completed Order.
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>
