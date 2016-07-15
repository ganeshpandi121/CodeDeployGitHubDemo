
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <h2>User Details</h2>

                <?php if (!empty($this->session->flashdata('success_msg'))) { ?>
                    <div class="alert alert-success text-center">
                        <?php echo $this->session->flashdata('success_msg'); ?>
                    </div>
                <?php } ?>
                <?php if (!empty($this->session->flashdata('error_msg'))) { ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $this->session->flashdata('error_msg'); ?>
                    </div>
                <?php } ?>

                <?php if (!empty($user_details)) { 
                    $url = ($user_details->user_type_id == 2) ? 'buyers' : 'sellers' ;
                ?>
                    <?php echo '<h5 style="padding-left:10px">User : #' . $user_details->user_id . '</h5>'; ?>
                    <?php if ($user_details->is_user_active == 0) { ?>
                        <a class="btn btn-blue" href="<?php echo base_url() . "admin/activate_user/" . $user_details->user_id . '/' . $user_details->user_type_id; ?>">Activate </a>
                    <?php } else { ?>
                        <a class="btn btn-blue" href="<?php echo base_url() . "admin/deactivate_user/" . $user_details->user_id . '/' . $user_details->user_type_id; ?>">Deactivate </a>
                    <?php } ?>
                        
                    <?php if ($user_details->user_type_id == 3 || !empty($is_transformed) ) { ?>
                        <?php if ($user_details->is_vetted == 0) { ?>
                            <a class="btn btn-blue" href="<?php echo base_url() . "admin/change_seller_type/" . $user_details->user_id . '/1'; ?>">Change to Live Mode</a>
                        <?php } else { ?>
                            <a class="btn btn-blue" href="<?php echo base_url() . "admin/change_seller_type/" . $user_details->user_id . '/0'; ?>">Change to Demo Mode</a>
                        <?php } ?>
                    <?php } ?>
                    <a class="btn" href="<?php echo base_url() . "admin"."/".$url; ?>"> &lt;&lt; Back to list</a>
                    <table class="table table-bordered ">
                        <tr>
                            <th width='30%'>User Name  </th>
                            <td><?php echo $user_details->user_first_name . " " . $user_details->user_last_name; ?></td>
                        </tr>
                        <tr>
                            <th width='30%'>Email Id   </th>
                            <td ><?php echo $user_details->email; ?></td>
                        </tr>
                        <tr>
                            <th width='30%'>Created Date  </th>
                            <td ><?php echo date("F j, Y", $user_details->created_time); ?></td>
                        </tr>
                        <?php
                        if ($user_details->is_address_added != 0) {
                            ?>
                            <tr>
                                <th width='30%'>Address Name </th>
                                <td ><?php echo $user_details->address_name; ?></td>
                            </tr>
                            <tr>
                                <th width='30%'>Street Address </th>
                                <td ><?php echo $user_details->street_address; ?></td>
                            </tr>
                            <tr>
                                <th width='30%'>State</th>
                                <td ><?php echo $user_details->state; ?></td>
                            </tr>
                            <tr>
                                <th width='30%'>City</th>
                                <td ><?php echo $user_details->city; ?></td>
                            </tr>
                            <tr>
                                <th width='30%'>Post Code</th>
                                <td ><?php echo $user_details->post_code; ?></td>
                            </tr>
                            <tr>
                                <th width='30%'>Country</th>
                                <td ><?php echo $user_details->country_name; ?></td>
                            </tr>
                            <tr>
                                <th width='30%'>Company</th>
                                <td ><?php echo ucfirst($user_details->company_name); ?></td>
                            </tr>
                            <tr>
                                <th width='30%'>Website</th>
                                <td ><?php echo $user_details->website; ?></td>
                            </tr>
                            <?php if($user_details->user_type_id==3){?>
                            <tr>
                                <th width='30%'>Trading Name</th>
                                <td > <?php echo $user_details->trading_name;?></td>
                            </tr>
                            <tr>
                                <th width='30%'>Brand</th>
                                <td > <?php echo $user_details->brand;?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th width='30%'>Telephone Number</th>
                                <td ><?php echo $user_details->telephone_code; ?> <?php echo $user_details->telephone_no; ?></td>
                            </tr>
                            <tr>
                                <th width='30%'>Fax Number</th>
                                <td ><?php echo $user_details->fax_no; ?></td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr>
                                <th width='30%'>Address  </th>
                                <td >Address has not been added</td>
                            </tr>
                        <?php } ?>

                    </table>
                <?php } ?> 
            </div> 
        </div>
    </div>
</div>
<br>