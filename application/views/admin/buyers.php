<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6">  <h2>Buyers</h2></div>
            <div class="col-md-6 ">
                <br/>
                <div class="form-inline pull-right">
                    <?php
                    echo form_open(base_url() . 'admin/buyers/', array('id' => 'buyer_search_form', 'method' => 'get'));
                    $search_term = !empty($search_term) ? $search_term : '';
                    echo form_input('search_term', $search_term, array('id' => 'search_term', 'placeHolder' => 'Search Buyer Here', 'style' => 'width:350px;'));
                    ?>
                    <?php echo form_submit('search', 'Search', array('class' => 'btn btn-primary form-control', 'type' => 'submit')); ?>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 ">
                <?php if (!empty($buyers_list)) { ?>
                    <table class="table table-striped">
                        <thead >
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Company Name</th>
                                <th>Created Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($buyers_list as $key => $list) { ?>
                                <tr>
                                    <td><?php echo "#" . $list->user_id; ?></td>
                                    <td><?php echo $list->user_first_name . ' ' . $list->user_last_name; ?></td>
                                    <td class="text-info"><?php echo $list->email; ?></td>
                                    <td ><?php echo ucfirst($list->company_name); ?></td>
                                    <td><?php echo date("F j, Y", $list->created_time); ?></td>
                                    <td>
                                        <?php if ($list->is_active == 0) { ?>
                                            <a class="btn btn-blue" href="<?php echo base_url() . "admin/activate_user/" . $list->user_id . '/2'; ?>">Activate </a>
                                        <?php } else { ?>
                                            <a class="btn btn-blue" href="<?php echo base_url() . "admin/deactivate_user/" . $list->user_id . '/2'; ?>">Deactivate </a>
                                        <?php } ?>
                                        <a class="btn btn-blue" href="<?php echo base_url() . "admin/view_user/" . $list->user_id; ?>">View </a>
                                        <a class="btn" href="<?php echo base_url() . "admin/login_as_user/" . $list->user_id; ?>">Login As </a>
                                    </td>
                                </tr>
                                <?php
                            }

                            echo "<h4>Total Buyers: " . $buyers_count . "</h4>";
                            ?>

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">                               
                                <ul class="pagination">
                                    <?php echo $buyer_pagination_helper->create_links(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="alert alert-info">
                        <strong>Info!</strong> No Buyers Found.
                    </div>

                <?php }
                ?>
            </div>
        </div>
    </div>
</div>

