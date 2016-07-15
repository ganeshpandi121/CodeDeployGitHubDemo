
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <h2>Users</h2>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#buyers">Buyers List</a></li>
                
                <li><a data-toggle="tab" href="#suppliers">Sellers List</a></li>

            </ul>
            <div class="tab-content">
                <div id="buyers" class="tab-pane fade in active">
                    
                    <div class="row">
                        <div class="col-md-12 ">
                
                <?php if (!empty($users_list)) { ?>
                    <table class="table table-striped">
                        <thead >
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Created Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php
                            //$count = (($page_num - 1) * $this->page_data['per_page']);
                            $total_buyers = 0;
                            foreach ($users_list as $key => $list) {
                                
                                if ($list->user_type_id == 2)
                                {$total_buyers++
                                ?>
                                <tr>
                                    <td><?php echo "#" . $list->user_id; ?></td>
                                    <td><?php echo $list->user_first_name.' '.$list->user_last_name; ?></td>
                                    <td class="text-info"><?php echo $list->email; ?></td>
                                    <td><?php echo date("F j, Y", $list->created_time); ?></td>
                                    <td>
                                        <a class="btn btn-blue" href="<?php echo base_url() . "dashboard/view_user/" . $list->user_id; ?>">View </a>
                                    </td>
                                </tr>
                            <?php
                                }
                                
                                }
                                echo "<h4>Total Buyers: ".$total_buyers."</h4>";?>

                        </tbody>
                    </table>
                   <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">                               
                                <ul class="pagination">
                                    <?php //echo $pagination_helper->create_links(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>-->
                   
                <?php }  else { ?>
                    <div class="alert alert-info">
                        <strong>Info!</strong>No Buyers Found.
                    </div>

                <?php }
                ?>
            </div>
                    </div>
                </div>
                <div id="suppliers" class="tab-pane fade in">
                
                    <div class="row">
                         <div class="col-md-12 ">
                    <?php if (!empty($users_list)) { ?>
                    <table class="table table-striped">
                        <thead >
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Created Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php
                            //$count = (($page_num - 1) * $this->page_data['per_page']);
                             $total_sellers = 0;
                            foreach ($users_list as $key => $list) {
                                 if ($list->user_type_id == 3)
                                {
                                      $total_sellers++;
                                ?>
                                <tr>
                                    <td><?php echo "#" . $list->user_id; ?></td>
                                    <td><?php echo $list->user_first_name.' '.$list->user_last_name; ?></td>
                                    <td class="text-info"><?php echo $list->email; ?></td>
                                    <td><?php echo date("F j, Y", $list->created_time); ?></td>
                                    <td>
                                        <a class="btn btn-blue" href="<?php echo base_url() . "dashboard/view_user/" . $list->user_id; ?>">View </a>
                                    </td>
                                </tr>
                                <?php }
                                }
                                 echo "<h4>Total Sellers: ".$total_sellers."</h4>";?>

                        </tbody>
                    </table>
                    <!--<div class="row">
                        <div class="col-md-12">
                            <div class="text-center">                               
                                <ul class="pagination">
                                    <?php //echo $pagination_helper->create_links(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>-->
                   
                <?php }  else { ?>
                    <div class="alert alert-info">
                        <strong>Info!</strong>No Suppliers Found.
                    </div>

                <?php }
                ?>
            </div>
                    </div>
                </div>
            </div>
            
            
           
            
         </div>
    </div>
</div>
